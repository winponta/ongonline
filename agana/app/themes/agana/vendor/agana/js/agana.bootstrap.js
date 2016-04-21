var app = null;

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

    //    app.gm.injectLoadPageEvent('gm-content-container');
    
    var footerOpen = false;
    $('#footerSlideButton').click(function () {
        if(footerOpen === false) {
            $('#footerSlideContent').animate({
                height: '50px'
            });
            
            $(this).css('backgroundPosition', 'bottom left');
            $(this).find('i').removeClass('icon-caret-up').addClass('icon-caret-down');

            footerOpen = true;
        } else {
            $('#footerSlideContent').animate({
                height: '0px'
            });

            $(this).css('backgroundPosition', 'top left');
            $(this).find('i').removeClass('icon-caret-down').addClass('icon-caret-up');

            footerOpen = false;
        }
    });    
});
