Agana = function() {}

Agana.App = function() {
    this.loadingCount=0;
    this.loadingInterval = 0;
    this.loadingBarTime = 1000;
    this.elLoadingMsgContainer = null;
    this.elLoadingMsgBar = null;
    this.elLoadingMsgInfo = null;

    this.contentContainer = null;
        
    this.gm = new Agana.Gm(this);
    
    this.overlay = new Agana.Overlay(this);
    
    this.setContentContainer = function(container) {
        this.contentContainer = $('#'+container);
    }
    
    this.loadPage = function(urladdress, container) {        
        if(container) {
            this.setContentContainer(container);
        }
        
        var me = this;

        $.ajax({
            url: urladdress,
            success: function(data) {
                $(me.contentContainer).html(data);                
                $(me.contentContainer).find('script').each(function(){
                    eval($(this).html());
                });
            },
            fail: function(data) {
                me.stopLoadingMsg(true, 'Falha no retorno ajax !!');
            }
        });
    };
    
    this.startLoadingMsg = function() {
        this.loadingCount = 0;
        var me = this;
        me.showLoadingMsg();
    //this.loadingInterval = window.setInterval(function(){
    //    me.updateBarLoadingMsg();
    //}, this.loadingBarTime);
        
    };
    
    this.updateBarLoadingMsg = function() {
        var perc = Math.floor((this.loadingCount * 100)/60);
        this.loadingCount += (this.loadingBarTime/1000);
        this.elLoadingMsgBar.css({
            'width':perc+'%'
        });
        
        if (this.loadingCount > 60) {
            this.stopLoadingMsg(true, '</i>O carregamento está mais demorado que o esperado, por favor, tente novamente, se o problema persistir entre em contato com o administrador.');
        }        
    };
    
    this.showLoadingMsg= function(){
        if (!this.elLoadingMsgContainer) {
            var content =   '<div id="loading-msg-container" class="alert alert-danger" style="width=100px;position:fixed;top: 20%;">' +
            '<div id="loading-msg-img">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div> ' + 
            //            '<div class="progress progress-striped active">' + 
            //            '<div id="loading-msg-bar" class="bar" style="width: 0%;"></div>' +
            //            '</div>' +
            //'<p id="loading-msg-info" class="alert alert-error" style="display:none;"></p>' +
            '</div>';
            $('body').append(content);
        
            this.elLoadingMsgContainer = $('#loading-msg-container');
            var browserwidth = $(window).width();
            var elLeft = (browserwidth - $(this.elLoadingMsgContainer).width())/2;
            $(this.elLoadingMsgContainer).css({
                'left':elLeft+'px'
            });
            
            this.elLoadingMsgBar = $('#loading-msg-bar');
            this.elLoadingMsgInfo = $('#loading-msg-info');
        } 
        
        //this.updateBarLoadingMsg();
        this.elLoadingMsgContainer.css({
            'z-index': 999999,
            'opacity':0.8
        });
    };
    
    this.stopLoadingMsg = function(showMsg, msg){
        //window.clearInterval(this.loadingInterval);
        //this.loadingCount=0;
        
        if (showMsg) {
            //            this.elLoadingMsgContainer.addClass('alert-error');
            //            this.elLoadingMsgInfo.html(msg);
            //            this.elLoadingMsgInfo.css('display', 'block');
            this.showAppMsg(msg, 'alert-error');
        } 
        
        this.elLoadingMsgContainer.animate({
            'opacity':'0.0',
            'z-index': -9999
        }, 'fast',"linear");
    };
    
    this.animateAppMessages = function() {
        var $appmessages = $("#app-messages");

        //        if ($appmessages.length > 0) {
        //            $appmessages.css({
        //                'display':'none'
        //            });
        
        $("#app-messages").addClass('jquery-app-messages')
        $("#app-messages").animate({
            'height':'toggle',
            'opacity':'0.9'
        }, 
        1000,"linear", 
        function(){    
            window.setTimeout( function(){
                $("#app-messages").slideUp();
            }, 60000);
        });
    //            $appmessages.meow({
    //                message: $appmessages ,
    //                sticky: true,
    //                classname: $appmessages.find('div').attr('class')
    //            });
    };
    
    this.injectLoadPageEvent = function(container) {
        if (container) {
            this.setContentContainer(container);
        }
        
        var me = this;
        var loadIn          = this.contentContainer.selector.substr(1);
        var gmloadIn        = this.gm.contentContainer.selector.substr(1);
        var overlayloadIn   = this.overlay.contentContainer.selector.substr(1);
        
        $('#menu-container a, a[load-in="'+ loadIn +'"]').live('click', function(event){
            event.preventDefault(); 
            
            var selector = me.gm.contentContainer.selector;
            selector += ',' + me.gm.container.selector;
            
            if ($(this).parents(selector).length) {
                me.gm.loadPage($(this).attr('href'));
            } else {
                me.loadPage($(this).attr('href'));
            }
        });

        $('a[load-in="'+ gmloadIn +'"]').live('click', function(event){
            event.preventDefault(); 
            
            me.gm.loadPage($(this).attr('href'));
        });

        $('a[load-in="'+ overlayloadIn +'"]').live('click', function(event){
            event.preventDefault(); 
            
            me.overlay.loadPage($(this).attr('href'));
        });

        $('form[load-in="'+ loadIn +'"] input[type="submit"]').live('click', function(event){
            event.preventDefault();
            //var form = $('form[load-in="'+ loadIn +'"]');
            var form = $(this.form);
            var url = form.attr('action');
            var data = $(form).serializeArray();
            data.push(this);
            
            $.post(url,data,function(data){
                var gmselector = me.gm.contentContainer.selector;
                var overlayselector = me.overlay.container.selector;

                if ($(form).parents(gmselector).length) {
                    me.gm.contentContainer.html(data);
                } else if ($(form).parents(overlayselector).length) {
                    me.overlay.setContentContainer(me.overlay.contentContainer.selector);
                    
                    // if there is no contentContainer in overlay
                    // we must create it and wrap the current content
                    if (me.overlay.contentContainer.length == 0) {
                        $(me.overlay.container.selector).children().first().wrap("<div id='"+me.overlay.contentContainer.selector+"' />");
                        me.overlay.contentContainer = $(me.overlay.container.selector).children().first();
                    }

                    //console.info(data);
                    me.overlay.contentContainer.html(data);
                } else {
                    me.contentContainer.html(data);
                }
            });
            return false;
        });
    }

    this.popoverFormErrorMessages = function() {
        $('.form-error-msg').each(function(){
            $(this).addClass('jquery-form-error-msg');
            
            var relElement = $('#'+$(this).attr('rel'));
            
            $(this).css({
                'left': relElement.offset().left +  relElement.width(),
                'top': relElement.offset().top
            });
            
            $(this).animate({
                'opacity': 1
            }, 'slow');
            
            $(this).bind('blur',function(){
                $(this).animate({
                    'opacity':0
                }, 'slow'); 
            });
        });

    }
    
    /**
     * Inject the treatment of ajax returns: Send, Complete and Error
     */
    this.injectAjaxListening = function () {
        var app = this;
        $('body').bind("ajaxSend", function(){
            app.startLoadingMsg();
        }).bind("ajaxComplete", function(){
            app.stopLoadingMsg();
            app.animateAppMessages();
            app.injectBindings();
        }).bind("ajaxError", function(event, request, settings, error){
            app.showAppMsg("Error requesting page " + settings.url + '<br/>Status: ' + request.status + ' - ' + request.statusText, 'alert-error');
        });
    }
    
    this.showAppMsg = function(msg, type) {
        var elMsg = '<div class="jquery-app-messages" id="app-messages" style="display: block; opacity: 0.9; ">'+
        '<div class="alert '+ type +'">' +
        '<a class="close" data-dismiss="alert" href="#">'+
        '<i class="icon-remove-sign"/>'+
        '</a>'+
        '<i class="icon-exclamation-sign"/>'+
        '<ul>'+
        '<li>'+ msg + '</li>'+
        '</ul>'+
        '</div>'+
        '</div>';
                
        this.contentContainer.append(elMsg);
        this.animateAppMessages();
    }
    
    this.loadScript = function(url, options) {
        // allow user to set any option except for dataType, cache, and url
        options = $.extend(options || {}, {
            dataType: "script",
            cache: true,
            url: url
        });

        // Use $.ajax() since it is more flexible than $.getScript
        // Return the jqXHR object so we can chain callbacks
        return jQuery.ajax(options);
    };
    
    /**
     * Inject actions by binding it to elements: 
     * tooltip and popover from Twitter Bootstrap
     * colorbox for general colorbox overlay
     * colorbox-system-help to help overlay
     * colorbox-search for search forms
     */
    this.injectBindings = function() {
        $('[rel=tooltip]').tooltip();
        $('[rel=popover]').popover();
        $('a[rel=colorbox]').colorbox();
        
        $('a[rel=colorbox-system-help]').colorbox({
            width:'90%', 
            maxWidth:1200,
            height: '90%',
            arrowKey: false
        });

        $('a[rel=colorbox-search]').colorbox({
            maxWidth:1200,
            height: '95%',
            arrowKey: false,
            close: '<translate>close</transxlate>',
            
            onOpen: function() {
                $('#colorbox-content-container').data('select-item-id', '');
                $('#colorbox-content-container').data('select-item-value', '');
            },
            
            onCleanup: function() {
                var id = $('#colorbox-content-container').data('select-item-id');
                var value = $('#colorbox-content-container').data('select-item-value');
                
                var objId       = $('#' + $(this).attr('search-return-id'));
                var objValue    = $('#' + $(this).attr('search-return-value'));

                if (id != '') {
                    $(objId).val($('#colorbox-content-container').data('select-item-id'));
                    $(objValue).val($('#colorbox-content-container').data('select-item-value'));
                    $(objValue).text($('#colorbox-content-container').data('select-item-value'));
                }                
            }
        });
        
        $('a[rel="search-select-item"]').live('click', function(event){
            event.preventDefault();
            
            var id = $(this).attr('search-select-item-id');
            var value = $(this).attr('search-select-item-value');
            
            $('#colorbox-content-container').data('select-item-id', id);
            $('#colorbox-content-container').data('select-item-value', value);
            
            $.colorbox.close();
        });
    }

}