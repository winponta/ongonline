var gulp = require('gulp');
var gutil = require('gulp-util');
var bump = require('gulp-bump');
var args = require('yargs').argv;
var gulpif = require('gulp-if');
var ini = require('ini');
var git = require('gulp-git');
var fs = require('fs');
var rsync = require('rsyncwrapper');

// le o arquivo de propriedades
gutil.log(gutil.colors.green('Lendo build.properties'));
var deployIniConfig = ini.parse(fs.readFileSync('build.properties', 'utf-8'));

// define ambiente pelos argumentos enviados pelo console
var env = args.e ? args.e : 'test';
var isProduction = env == 'production';

// define diretorios de destino pelo ambiente
var dirDestApp = (env == 'production') ? deployIniConfig.ftp.dir.production.app : deployIniConfig.ftp.dir.test.app
var dirDestPublic = (env == 'production') ? deployIniConfig.ftp.dir.production.public : deployIniConfig.ftp.dir.test.public

gutil.log(gutil.colors.green('Diretorios de destino no servidor'));
gutil.log('app    = ' + dirDestApp);
gutil.log('public = ' + dirDestPublic);

// prepara ssh
var gulpSSH = require('gulp-ssh')({
    ignoreErrors: false,
    sshConfig: {
        host: deployIniConfig.ssh.host,
        port: deployIniConfig.ssh.port,
        username: deployIniConfig.ssh.username,
        password: deployIniConfig.ssh.password
    }
});

// variaveis de definicao do tipo de deploy semver
var isMajor = args.version === 'major';
var isMinor = args.version === 'minor';
var isPatch = args.version === 'patch' || args.version == null;

var tagMsg = args.tagMessage || 'Tag de versão de deploy automatizada com Gulp';

var tagVersion = '';

// le o arquivo de configuracao da versao a ser publicada
var getFileJson = function () {
    return JSON.parse(fs.readFileSync('./version.json', 'utf8'));
};

function getDateTime() {

    var date = new Date();

    var hour = date.getHours();
    hour = (hour < 10 ? "0" : "") + hour;

    var min = date.getMinutes();
    min = (min < 10 ? "0" : "") + min;

    var year = date.getFullYear();

    var month = date.getMonth() + 1;
    month = (month < 10 ? "0" : "") + month;

    var day = date.getDate();
    day = (day < 10 ? "0" : "") + day;

    return year + "." + month + "." + day + " " + hour + "." + min;

}

// grava a nova versao no arquivo
gulp.task('bump', function () {
    if (isProduction) {
        gutil.log(gutil.colors.green('Definindo versão em ' + env));

        gulp.src('./version.json')
        .pipe(gulpif(isPatch, bump({type: 'patch'})))
        .pipe(gulpif(isMinor, bump({type: 'minor'})))
        .pipe(gulpif(isMajor, bump({type: 'major'})))
        .pipe(gulp.dest('./'));

        tagVersion = getFileJson().version;

        gutil.log(gutil.colors.green('Nova versão ' + tagVersion ));
    } else {
        gutil.log(gutil.colors.green('Não define versão se não é deploy de produção'));
    }
});

// grava no arquivo de configuracao as informacoes que serao mostradas no app
gulp.task('set-config-ini', ['bump'], function () {
    if (isProduction) {
        gutil.log(gutil.colors.green('Gravando versão ' + tagVersion + ' e data de deploy no arquivo agana_ongonline_version.ini'));

		var config = ini.parse(fs.readFileSync('./configs/agana_ongonline_version.ini', 'utf-8'));
		config["agana.app.version"] = tagVersion;
		config["agana.app.deploydate"] = getDateTime();
		fs.writeFileSync('./configs/agana_ongonline_version.ini', ini.stringify(config));
	};
});

// define a tag de versao no git
gulp.task('git-tag-verson', ['set-config-ini'], function () {
    if (isProduction) {
        gutil.log(gutil.colors.green('Gerango no GIT tag ' + tagVersion + ' e msg = ' + tagMsg));

		return git.tag(tagVersion, tagMsg, function (err) {
			if (err)
				throw err;
		});
	};
});

// Run git commit with options
gulp.task('git-commit', ['git-tag-verson'], function () {
    if (isProduction) {
        gutil.log(gutil.colors.green('GIT commit msg = Deploy versão ' + tagVersion));

		return gulp.src(['./version.json', './configs/agana_ongonline_version.ini'])
				.pipe(git.add())
				.pipe(git.commit('Deploy versão ' + tagVersion));
	};
});

// Run git push with options
// branch is the remote branch to push to
gulp.task('git-push-master', ['git-commit'], function () {
    if (isProduction) {
        gutil.log(gutil.colors.green('GIT Push em MASTER'));

		return git.push('origin', 'master', function (err) {
			if (err)
				gutil.log(gutil.colors.red('ERRO no git-push-master >> ' + err));
		});
	};
});

gulp.task('git-push-tags', ['git-push-master'], function () {
    if (isProduction) {
        gutil.log(gutil.colors.green('GIT Pusg de TAGS'));

		return git.push('origin', '', {args: "--tags"}, function (err) {
			if (err)
				gutil.log(gutil.colors.red('ERRO no git-push-tags >> ' + err));
		});
	};
});

gulp.task('copy', ['git-push-tags'], function () {
	// se o ambiente nao for production entao fixa a versao em test
	tagVersion = isProduction ? tagVersion : 'test';

    gutil.log(gutil.colors.green('Index para manutenção'));
    gulpSSH
            .shell([
                'cd /home/ong/public_html/' + dirDestPublic,
                'rm -f index.php',
                'cp index_maintenance.php index.php',
                'chown ong.ong index.php',
            ], {filePath: 'shell.log'})
            .pipe(gulp.dest('logs'));

    gutil.log(gutil.colors.green('Sincronizando arquivos'));
    return rsync({
        src: ['./agana/agana', './agana/lib', './configs', './app/themes'],
        dest: deployIniConfig.ssh.username + '@' + deployIniConfig.ssh.host + ':/home/ong/ongonline_versions/release-' + tagVersion,
        ssh: true,
        port: deployIniConfig.ssh.port,
        recursive: true,
        args: ['--info=progress2'],
        exclude: ['*.git', '.git', '.metadata', 'jasper-report-templates',
            'Zend/Dojo', 'Zend/Gdata', 'Zend/InfoCard', 'Zend/Amf', 'Zend/Wildfire',
            'Zend/Service', 'Zend/XmlRpc', 'Zend/Feed',
            'mPDF/examples'],
        args: ['-z --verbose'],
                onStdout: function (data) {
                    process.stdout.write('.');
                    //console.log(data.toString());
                }
    }, function (error, stdout, stderr, cmd) {
        if (error) {
            console.log(error);
            console.log(stderr);
			console.log('Comando do RSYNC');
			console.log(cmd);
        }

        gutil.log(gutil.colors.green('RSYNC end'));
        gutil.log(gutil.colors.green('Arquivos sincronizados !!'));

        gutil.log(gutil.colors.green('Montando links simbólicos para versão publicada no servidor'));

        return gulpSSH
                .shell([
                    'cd /home/ong/ongonline_versions/',
                    'chown -R ong.ong release-' + tagVersion,
                    'cd /home/ong/' + dirDestApp,
                    'rm -f agana',
                    'rm -f configs',
                    'rm -f lib',
                    'ln -s /home/ong/ongonline_versions/release-' + tagVersion + '/agana/ agana',
                    'ln -s /home/ong/ongonline_versions/release-' + tagVersion + '/configs/ configs',
                    'ln -s /home/ong/ongonline_versions/release-' + tagVersion + '/lib/ lib',
                    'cd /home/ong/public_html/' + dirDestPublic,
                    'rm -f themes',
                    'ln -s /home/ong/ongonline_versions/release-' + tagVersion + '/themes/ themes',
                    'chown -R ong.ong themes',
                    'rm -f index.php',
                    'cp index_production.php index.php',
                    'chown ong.ong index.php',
                    'exit'

                ], {filePath: 'shell.log'})
                .pipe(gulp.dest('logs'));
    });

});


gulp.task('deploy', ['bump', 'set-config-ini', 'git-tag-verson', 'git-commit', 'copy']);
