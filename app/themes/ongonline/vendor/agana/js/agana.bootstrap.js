var app = null;
var fingerkey = null;

$(document).ready(function(){
    //    acm = new agana.CoolMessage({location:'top', opacity: .9});
    //    acm.show();

    app = new Agana.App();
    
    app.gm.setContainer('gm-container');
    app.gm.setContentContainer('gm-content-container');
    
    app.overlay.setContainer('cboxLoadedContent');
    app.overlay.setContentContainer('colorbox-content-container');
    
    app.injectLoadPageEvent('content-container');
    app.injectAjaxListening();
    app.injectBindings();

    fingerkey = new Agana.Fingerkey();
    $('#fingerkey-setup').on('click', null, function(){
        app.startLoadingMsg();
        fingerkey.renderAppletElement();
        if (fingerkey.boot()) {
            $(this).addClass('badge-success');
            app.showAppMsg('Dispositivo leitor de digital inicializado', 'alert-success');
        } else {
            $(this).addClass('badge-important');
            app.showAppMsg('Não foi possível inicializar o leitor: ' + fingerkey.getMessages(), 'alert-error');
        }
        app.stopLoadingMsg();
    });
    
    // if still have app-messages div it's because the funtion for ajaxComplete
    // didi not run
    
    $('#app-messages').each(app.animateAppMessages());
    
    //    app.gm.injectLoadPageEvent('gm-content-container');
    
    var footerOpen = false;
    $('#footerSlideButton').click(function () {
        if(footerOpen === false) {
            $('#footerSlideContentContainer').animate({
                height: $('#footerSlideContent').height()
            });
            
            $(this).css('backgroundPosition', 'bottom left');
            $(this).find('i').removeClass('icon-caret-up').addClass('icon-caret-down');

            footerOpen = true;
        } else {
            $('#footerSlideContentContainer').animate({
                height: '0px'
            });

            $(this).css('backgroundPosition', 'top left');
            $(this).find('i').removeClass('icon-caret-down').addClass('icon-caret-up');

            footerOpen = false;
        }
    });    
});
