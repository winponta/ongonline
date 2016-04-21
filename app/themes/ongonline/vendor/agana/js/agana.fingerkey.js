Agana.Fingerkey = function() {
    var messages = [];

    var fkey = null;

    this.getMessages = function() {
        return messages;
    };

    this.setFKeyApplet = function(fkeyApplet) {
        fkey = fkeyApplet;
    }

    this.getFKeyApplet = function() {
        return fkey;
    }

    /**
     * 
     * @returns {Boolean}
     */
    this.isReady = function() {
        if (fkey == null) {
            messages.push("Conexão (applet) com dispositivo não foi iniciado");
            return false;
        }
        
        if (fkey.nitgen.getLastErrorCode() > 0) {
            messages = [];
            messages.push(fkey.nitgen.getLastErrorMessage());
            return false;
        }

        return true;
    }

    this.renderAppletElement = function(bootDevice) {
        bootDevice = bootDevice || true;
        
        $('body').append('<applet ' +
                'code="br/com/ongonline/fingerkey/NitgenEnrollApplet.class" ' +
                'width="20" height="20" style="position: fixed; top: 0;" ' +
                'codebase ="' + vendorPath + '/agana/applet/" ' +
                'archive = "FingerkeyApplet.jar,NBioBSPJNI.jar" ' +
                'id = "fkey"> ' +
                '<param name="classloader_cache" value="false"> ' +
                '<param name="separate_jvm" value="true"> ' +
                '</applet>');

        fkey = document.getElementById('fkey');
        
        if (bootDevice) {
            this.boot();
        }
    };

    this.boot = function() {
        messages = [];

        if (fkey == null) {
            messages.push("Conexão (applet) com dispositivo não foi iniciado");
            return false;
        }
        
        if (fkey.nitgen.checkError()) {
            messages = messages.concat("Erro " + fkey.nitgen.getLastErrorCode() + " : " + fkey.nitgen.getLastErrorMessage());
            return false;
        } else {
            if (fkey.nitgen.openDevice()) {
                return true;
            } else {
                messages = messages.concat("Erro ao abrir dispositivo");
                return false
            }
        }
    }
}