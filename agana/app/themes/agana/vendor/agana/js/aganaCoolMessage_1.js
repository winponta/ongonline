/* 
 * Agana cool messages Jquery plugin
 */

function aganaCoolMessage(element, options) {
    var intervalId;
    var msgObj;
    
    this.element = element;
    this.options = options;
        
    this.showMessages = function() {
        var htmlWidth = $('html').outerWidth();
        var msgWidth = htmlWidth/3;
    
        this.element.css({
            'z-index' : '19999',
            'width' : msgWidth+'px',
            'position': 'fixed',
            'top': '0px',
            'left': htmlWidth + 'px'
        });
        
        this.element.animate({
            opacity:.3
        });
        this.element.animate({
            left:htmlWidth - msgWidth - 20
        }, 400);
        this.element.animate({
            opacity:.9
        }, 700).delay(this.options.timeout).fadeOut(this.options.hideDuration);
    
        this.element.click(function(){
            $(this).fadeOut($(this).data('aganaCoolMessage').options.hideDuration);
        });
        
        //this.intervalId = setInterval("this.hideMessages", 3000);
    }
    
    this.hideMessages = function() {
        this.element.fadeOut(this.options.hideDuration);
        clearInterval(this.intervalId);
    }
}

/**
 * main plugin code 
 */
(function( $ ){
    $.fn.aganaCoolMessage = function( options ) {
        var settings = {
            'location'      :   'top',
            'timeout'       :   10000,
            'hideDuration'  :   800
        }

        if ( options ) { 
            $.extend( settings, options );
        }
      
        return this.each( function (){
            var obj = new aganaCoolMessage($(this), settings);
            $(this).data('aganaCoolMessage', obj);
            obj.showMessages();
        });
    };
})( jQuery );
