var gulp = require('gulp');
var bump = require('gulp-bump');
var args = require('yargs').argv;
var gulpif = require('gulp-if');
var ini = require('ini');
var git = require('gulp-git');

var rsync = require('rsyncwrapper').rsync;
var gulpSSH = require('gulp-ssh')({
    ignoreErrors: false,
    sshConfig: {
        host: '216.158.67.156',
        port: 1891,
        username: 'root',
        password: '749wpserver'
    }
});

var isMajor = args.version === 'major';
var isMinor = args.version === 'minor';
var isPatch = args.version === 'patch' || args.version == null;

var tagMsg = args.tagMessage || 'Tag de versão de deploy automatizada com Gulp';

var tagVersion = '';

var fs = require('fs');
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

gulp.task('bump', function () {
    return gulp.src('./version.json')
            .pipe(gulpif(isPatch, bump({type: 'patch'})))
            .pipe(gulpif(isMinor, bump({type: 'minor'})))
            .pipe(gulpif(isMajor, bump({type: 'major'})))
            .pipe(gulp.dest('./'));
});

gulp.task('set-config-ini', ['bump'], function () {
    var config = ini.parse(fs.readFileSync('./configs/agana_ongonline_version.ini', 'utf-8'));
    config["agana.app.version"] = getFileJson().version;
    config["agana.app.deploydate"] = getDateTime();
    fs.writeFileSync('./configs/agana_ongonline_version.ini', ini.stringify(config));
    tagVersion = getFileJson().version;
});

gulp.task('git-tag-verson', ['set-config-ini'], function () {
    return git.tag(tagVersion, tagMsg, function (err) {
        if (err)
            throw err;
    });
});

// Run git commit with options 
gulp.task('git-commit', ['git-tag-verson'], function () {
    return gulp.src(['./version.json', './configs/agana_ongonline_version.ini'])
            .pipe(git.add())
            .pipe(git.commit('Deploy versão ' + tagVersion));
});

// Run git push with options 
// branch is the remote branch to push to 
gulp.task('git-push-master', ['git-commit'], function () {
    return git.push('origin', 'master', function (err) {
        if (err)
            console.log('ERRO no git-push-master >> ' + err);
    });
});

gulp.task('git-push-tags', ['git-push-master'], function () {
    return git.push('origin', '', {args: " --tags"}, function (err) {
        if (err)
            console.log('ERRO no git-push-tags >> ' + err);
    });
});

gulp.task('copy', ['git-push-tags'], function () {
    gulpSSH
            .shell([
                'cd /home/ong/public_html/app/',
                'rm -f index.php',
                'cp index_maintenance.php index.php',
                'chown ong.ong index.php',
            ], {filePath: 'shell.log'})
            .pipe(gulp.dest('logs'));

    return rsync({
        src: ['./agana/agana', './agana/lib', './configs', './app/themes'],
        dest: 'root@216.158.67.156:/home/ong/ongonline_versions/release-' + tagVersion,
        ssh: true,
        port: "1891",
        recursive: true,
        args: ['--info=progress2'],
        exclude: ['*.git', '.git', '.metadata',
            'Zend/Dojo', 'Zend/Gdata', 'Zend/InfoCard', 'Zend/Amf', 'Zend/Wildfire',
            'Zend/Service', 'Zend/XmlRpc',
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
        }
        console.log('  ..  RSync end!');

        return gulpSSH
                .shell([
                    'cd /home/ong/ongonline_versions/',
                    'chown -R ong.ong release-' + tagVersion,
                    'cd /home/ong/ongonline_app/',
                    'rm -f agana',
                    'rm -f configs',
                    'rm -f lib',
                    'ln -s /home/ong/ongonline_versions/release-' + tagVersion + '/agana/ agana',
                    'ln -s /home/ong/ongonline_versions/release-' + tagVersion + '/configs/ configs',
                    'ln -s /home/ong/ongonline_versions/release-' + tagVersion + '/lib/ lib',
                    'cd /home/ong/public_html/app/',
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
