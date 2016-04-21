Agana.App = function() {
    this.loadingCount = 0;
    this.loadingInterval = 0;
    this.loadingBarTime = 1000;
    this.elLoadingMsgContainer = null;
    this.elLoadingMsgBar = null;
    this.elLoadingMsgInfo = null;

    this.contentContainer = null;

    this.gm = new Agana.Gm(this);

    this.overlay = new Agana.Overlay(this);

    this.setContentContainer = function(container) {
        this.contentContainer = $('#' + container);
    }

    this.loadPage = function(urladdress, container) {
        if (container) {
            this.setContentContainer(container);
        }

        var me = this;

        $.ajax({
            url: urladdress,
            success: function(data) {
                $(me.contentContainer).html(data);
                $(me.contentContainer).find('script').each(function() {
                    eval($(this).html());
                });

                // put focus on first form element
                $('form:first *:input[type!=hidden]:not([disabled="disabled"]):not([readonly="readonly"]):first').focus();
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
    };

    this.showLoadingMsg = function() {
        if (!this.elLoadingMsgContainer) {
            var content = '<div id="loading-msg-container" class="badge badge-important" style="width=20em;position:fixed;top: 10px;">' +
                    ' <i class="icon-spinner icon-spin"></i> loading ... ' +
                    '</div>';
            $('body').append(content);

            this.elLoadingMsgContainer = $('#loading-msg-container');
            var browserwidth = $(window).width();
            var elLeft = (browserwidth - $(this.elLoadingMsgContainer).width()) / 2;
            $(this.elLoadingMsgContainer).css({
                'left': elLeft + 'px'
            });

            this.elLoadingMsgBar = $('#loading-msg-bar');
            this.elLoadingMsgInfo = $('#loading-msg-info');
        }

        this.elLoadingMsgContainer.css({
            'z-index': 999999,
            'opacity': 0.8
        });
    };

    this.stopLoadingMsg = function(showMsg, msg) {
        if (showMsg) {
            this.showAppMsg(msg, 'alert-error');
        }

        this.elLoadingMsgContainer.animate({
            'opacity': '0.0',
            'z-index': -9999
        }, 'fast', "linear");
    };

//    this.animateAppMessages = function() {
//        var $appmessages = $("#app-messages");
//
//        $("#app-messages").addClass('jquery-app-messages')
//        $("#app-messages").animate({
//            'height': 'toggle',
//            'opacity': '0.9'
//        },
//        1000, "linear",
//                function() {
//                    window.setTimeout(function() {
//                        $("#app-messages").slideUp();
//                    }, 60000);
//                });
//    };


    this.animateAppMessages = function() {
        var appmessages = $("#app-messages");

        $(appmessages).addClass('hide');

        var stack_bar_top = {"dir1": "right", "dir2": "down", "push": "top", "spacing1": 10, "spacing2": 10};

        $.pnotify.defaults.labels = {redisplay: "Mostrar novamente", all: "Todos", last: "Último", close: "Fechar", stick: "Fixar"};

        $(appmessages).find('div').each(function() {
            var msgType = 'notice';
            var msgTitle = '';

            if ($(this).hasClass('alert-info')) {
                msgType = 'info';
            } else if ($(this).hasClass('alert-error')) {
                msgType = 'error';
            } else if ($(this).hasClass('alert-success')) {
                msgType = 'success';
            }

            $(this).find('li').each(function() {
                msgTitle = '';
                $(this).find('.title').each(function() {
                    msgTitle = $(this).html();
                    $(this).remove();
                });

                $.pnotify({
                    title: msgTitle,
                    text: $(this).html(),
                    type: msgType,
                    //nonblock: true,
                    animate: 'show',
                    width: '40%',
                    //opacity: 0.9,
                    closer_hover: false,
                    sticker: false,
                    labels: {redisplay: "Mostrar novamente", all: "Todos", last: "Último", close: "Fechar", stick: "Fixar"},
                    history: false
                });
            });
        });

        $(appmessages).remove();
    };

    this.showAllMessages = function() {
        // Display all notices. (Disregarding non-history notices.)
        var jwindow = $(window);
        var notices_data = jwindow.data("pnotify");
        if (!notices_data || !notices_data.length)
            return;

        $.each(notices_data, function() {
            //if (this.pnotify_history) {
            if (this.is(":visible")) {
                if (this.pnotify_hide)
                    this.pnotify_queue_remove();
            } else if (this.pnotify_display)
                this.pnotify_display();
            //}
        });
        return false;
    };

    this.injectLoadPageEvent = function(container) {
        if (container) {
            this.setContentContainer(container);
        }

        var me = this;
        var loadIn = this.contentContainer.selector.substr(1);
        var gmloadIn = this.gm.contentContainer.selector.substr(1);
        var overlayloadIn = this.overlay.contentContainer.selector.substr(1);

        // run this when the load-in is the default container
        $('body').on('click', '#menu-container a:not([data-toggle="dropdown"]), a[load-in="' + loadIn + '"]',
                function(event) {
                    event.preventDefault();

                    // get gm selectors to test if the element selected in this/me 
                    // has gm containers as parents. If so, should call gm and not the 
                    // default container.
                    // 
                    // But if the load-in-force-default is TRUE, then use it
                    var selector = me.gm.contentContainer.selector;
                    selector += ',' + me.gm.container.selector;

                    if ($(this).attr('load-in-force')) {
                        me.loadPage($(this).attr('href'));
                    } else {
                        if ($(this).parents(selector).length) {
                            me.gm.loadPage($(this).attr('href'));
                        } else {
                            me.loadPage($(this).attr('href'));
                        }
                    }
                });

        // run this when the load-in is the gm container
        $('body').on('click', 'a[load-in="' + gmloadIn + '"]', function(event) {
            event.preventDefault();

            me.gm.loadPage($(this).attr('href'));
        });

        // run this when the load-in is the overlay container
        $('body').on('click', 'a[load-in="' + overlayloadIn + '"]', function(event) {
            event.preventDefault();

            me.overlay.loadPage($(this).attr('href'));
        });

        var submitSelectors = 'form[load-in="' + loadIn + '"] input[type="submit"]';
        submitSelectors += ',';
        submitSelectors += 'form[load-in="' + loadIn + '"] button[type="submit"]';

        $('body').on('click', submitSelectors, function(event) {
            event.preventDefault();
            $(this).attr({
                'disabled': 'true'
            });
            var oldText = $(this).text();
            var oldVal = $(this).val();
//            $(this).text('... executando ...');
//            $(this).val('... executando ...');
            var btnClicked = this;

            //var form = $('form[load-in="'+ loadIn +'"]');
            var form = $(this.form);
            var url = form.attr('action');
            var data = $(form).serializeArray();
            data.push(this);

            $.post(url, data, function(data) {
                var gmselector = me.gm.contentContainer.selector;
                var overlayselector = me.overlay.container.selector;

                if ($(form).parents(gmselector).length) {
                    me.gm.contentContainer.html(data);
                    $(me.gm.contentContainer).find('script').each(function() {
                        eval($(this).html());
                    });
                } else if ($(form).parents(overlayselector).length) {
                    me.overlay.setContentContainer(me.overlay.contentContainer.selector);

                    // if there is no contentContainer in overlay
                    // we must create it and wrap the current content
                    if (me.overlay.contentContainer.length == 0) {
                        $(me.overlay.container.selector).children().first().wrap("<div id='" + me.overlay.contentContainer.selector + "' />");
                        me.overlay.contentContainer = $(me.overlay.container.selector).children().first();
                    }

                    //console.info(data);
                    me.overlay.contentContainer.html(data);
                    $(me.overlay.contentContainer).find('script').each(function() {
                        eval($(this).html());
                    });
                } else {
                    me.contentContainer.html(data);
                    $(me.contentContainer).find('script').each(function() {
                        eval($(this).html());
                    });
                }
                
                $(btnClicked).removeAttr('disabled');
//                $(btnClicked).text(oldText);
//                $(btnClicked).val(oldVal);
            });
            return false;
        });
    };

    this.popoverFormErrorMessages = function() {
        $('.form-error-msg').each(function() {
            $(this).addClass('jquery-form-error-msg');

            var relElement = $('#' + $(this).attr('rel'));

            $(this).css({
                'left': relElement.offset().left + relElement.width(),
                'top': relElement.offset().top
            });

            $(this).animate({
                'opacity': 1
            }, 'slow');

            $(this).bind('blur', function() {
                $(this).animate({
                    'opacity': 0
                }, 'slow');
            });
        });

    };

    /**
     * Inject the treatment of ajax returns: Send, Complete and Error
     */
    this.injectAjaxListening = function() {
        var app = this;
        $(document).bind("ajaxSend", function() {
            app.startLoadingMsg();
        }).bind("ajaxComplete", function() {
            //console.debug('Ajax complete: ' + $('form[save-draft]').attr('id'));
            app.stopLoadingMsg();
            app.animateAppMessages();
            app.injectBindings();
        }).bind("ajaxError", function(event, request, settings, error) {
            try {
                $res = jQuery.parseJSON(request.responseText);
                app.showAppMsg($res.message, 'alert-' + $res.type);
            } catch (err) {
                app.showAppMsg("Error requesting page " + settings.url + '<br/>Status: ' + request.status + ' - ' + request.statusText, 'alert-error');
            }
        });
        ;
    }

    this.showAppMsg = function(msg, type) {
        var elMsg = '<div class="jquery-app-messages" id="app-messages" style="display: block; opacity: 0.9; ">' +
                '<div class="alert ' + type + '">' +
                '<a class="close" data-dismiss="alert" href="#">' +
                '<i class="icon-remove-sign"/>' +
                '</a>' +
                '<i class="icon-exclamation-sign"/>' +
                '<ul>' +
                '<li>' + msg + '</li>' +
                '</ul>' +
                '</div>' +
                '</div>';

        this.contentContainer.append(elMsg);
        this.animateAppMessages();
    };

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
     * preventDoubleSubmission for form
     */
    this.injectBindings = function() {
        function defineNumberOfMonths($n) {
            if ($n) {
                return parseInt($n);
            }
            return 1;
            //col
        };

        $("a.fullscreen").on('click', function() {
            app.askFullScreen();
        });

        var dpicker = $('[rel=datepicker]');
        dpicker.datepicker({
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true,
            numberOfMonths: defineNumberOfMonths(dpicker.attr('data-number-of-months'))
        });

        this.injectBindingsXEditable();
        var aganaThis = this;
        
        $('[rel=tooltip]').tooltip();
        $('[rel=popover]').popover();
        $('a[rel=colorbox]').colorbox({
            onComplete: function() {
                aganaThis.injectBindingsXEditable();
            }
        });

        $('[data-spy="affix"]').each(function() {
            var options = {"offset": $(this).attr('data-offset-top') || 0};
            $(this).affix(options);
        });

        $('a[rel=colorbox-system-help]').colorbox({
            width: '95%',
            maxWidth: 1200,
            height: '90%',
            arrowKey: false
        });

        $('.pdf-iframe').one('load', null, function() {
            app.stopLoadingMsg();
        });

        $('.open-report-colorbox').one('click', null, function(event) {
            event.preventDefault();
            // To provent run click on acumulated clicks of reports before this one
            event.stopImmediatePropagation();

            var reportFormat = $(this).attr('report-format');

            var form = $('form.serialize');
            var data = $(form).serializeArray();

            data.push({name: 'format', value: reportFormat});

            if (reportFormat == 'pdf') {
                app.startLoadingMsg();
                //window.write('<iframe src="' + $(form).attr('action') + '?' + $.param(data) + '" width="1" height="1"></iframe>');
                $('<iframe>', {
                    src: $(form).attr('action') + '?' + $.param(data),
                    class: 'pdf-iframe',
                    frameborder: 0,
                    width: 1,
                    height: 1,
                    scrolling: 'no'
                }).appendTo('body');
                //window.location.href= $(form).attr('action') + '?' + $.param(data);
                app.injectBindings();
            } else {
                var w = screen.width * 0.9;
                var h = screen.height * 0.9;
                var l = screen.width - (screen.width * 0.95);
                
                window.open($(form).attr('action') + '?' + $.param(data),'_blank',
                "height="+h+",width="+w+",left="+l+","+
                        "scrollbars=yes,status=no,"+
                        "personalbar=no,titlebar=no"+
                        "alwaysRaised=on,"+
                        "toolbar=no,menubar=no,location=no");
                
//                $.ajax({
//                    'url': $(form).attr('action'),
//                    'type': 'POST',
//                    'data': $.param(data),
//                    'success': function(result, status, xhr) {
//                        var ct = xhr.getResponseHeader("content-type") || "";
//                        if (ct.indexOf('html') > -1) {
//                            
////                            $.colorbox({
////                                width: '95%',
////                                height: '95%',
////                                arrowKey: false,
////                                close: 'Fechar',
////                                html: result
////                            });
//                        }
//                        if (ct.indexOf('pdf') > -1) {
//                            console.log('Pdf download');
//                        }
//                    }
//                });
            }

            return false;
        });

        $('a[rel=colorbox-search]').colorbox({
            maxWidth: '90%',
            height: '95%',
            arrowKey: false,
            close: '<i class="icon-remove-sign icon-large"></i>',
            onOpen: function() {
                $('#colorbox-content-container').data('select-item-id', '');
                $('#colorbox-content-container').data('select-item-value', '');
            },
            onCleanup: function() {
                var id = $('#colorbox-content-container').data('select-item-id');
                var value = $('#colorbox-content-container').data('select-item-value');

                var objId = $('#' + $(this).attr('search-return-id'));
                var objValue = $('#' + $(this).attr('search-return-value'));
                var objTriggerEvent = $('#' + $(this).attr('search-return-obj-trigger-event'));
                var triggerEvent = $(this).attr('search-return-trigger-event');

                if (id != '' && id != null) {
                    $(objId).val($('#colorbox-content-container').data('select-item-id'));
                    $(objValue).val($('#colorbox-content-container').data('select-item-value'));
                    $(objValue).text($('#colorbox-content-container').data('select-item-value'));
                }
                
                $(objTriggerEvent).trigger(triggerEvent);
                
            }
        });

        $('a[rel=colorbox-person-details]').on('click', null, function() {
            $(this).colorbox({
                href: $(this).attr('href') + '/id/' + $('#' + $(this).attr('element-value-id')).val(),
                maxWidth: '98%',
                height: '95%',
                arrowKey: false,
                close: '<i class="icon-remove-sign icon-large"></i>',
            });
        });

        $('a[rel="search-select-item"]').on('click', null, function(event) {
            event.preventDefault();

            var id = $(this).attr('search-select-item-id');
            var value = $(this).attr('search-select-item-value');

            $('#colorbox-content-container').data('select-item-id', id);
            $('#colorbox-content-container').data('select-item-value', value);

            $.colorbox.close();
        });

        $('[rel="show-big-content"]').colorbox({
            width: '96%',
            maxWidth: 1200,
            height: '96%',
            arrowKey: false,
            inline: true,
            href: function() {
                var elementID = $(this).attr('href');
                return $(elementID).html();
            }
        });

        /**
         * Defines an event listening to tables with click-row class
         * then handle click on the tr of a table calling the selector
         * secified in data-click-row-selector
         */
        $('table[rel="click-row"] tr').on('click', null, function(event) {
            if ((event.target instanceof HTMLAnchorElement) !== true) {
                var cr = new Agana.App.Table();
                cr.clickRow(this);
            }
        });


        /**
         * Defines element (select, radio, combo) that when is selected
         * copy its value to another one.
         * If a empty value is the choose, the target is enabled to input text
         */
        $('[rel="choice-for-another-element"]').on('click', null, function(event) {
            var target = $(this).attr('data-target');
            $(target).val($(this).val());
            $(target).attr('readonly', ($(this).val() != ''));
            $(target).focus();
        });

        $('[rel="print-window"]').on('click', null, function(event) {
            window.print();
            return false;
        });

        /**
         * Defines the mask of an input based on mask-input class
         * and data-mask attribute
         */
        $('.mask-input').each(function() {
            var options = $.extend(
                    {}, {"clearMaskOnLostFocus": true},
            $.parseJSON($(this).attr('data-mask'))
                    );
            $(this).inputmask(options);
        });

        /**
         * Selectpicker combo object
         */
        $('.selectpicker').selectpicker('show');

        /**
         * Save draft on localstorage for form that have save-draft attr
         */
//        $('form[save-draft]').sisyphus({
//            customKeyPrefix: $(this).id
//        });

    };

    this.injectBindingsXEditable = function() {

        console.log($('[rel=x-editable]'));

        $('[rel=x-editable]').editable({
            emptytext: '.....',
            success: function(response, newValue) {
                response = jQuery.parseJSON(response);
                if (response.status == 'error' || response.success == false) {
                    return response.msg; //msg will be shown in editable form
                } else {
                    $.pnotify({
                        text: response.msg,
                        type: "success",
                        history: false,
                        animate: 'show',
                        width: '40%',
                        //opacity: 0.9,
                        closer_hover: false,
                        sticker: false
                    });
                }
            },
//            display: function(newValue, response) {
//                response = jQuery.parseJSON(response);
//                if (response.status != 'error' && response.success != false && response.newValueFormated) {
//                    $(this).html(response.newValueFormated);
//                } else {
//                    $(this).html(newValue);
//                }
//            },
            params: function(params) {  //params already contain `name`, `value` and `pk`
                var data = {};
                data['id'] = params.pk;
                data[params.name] = params.value;
                return data;
            }
        });
    };

    this.askFullScreen = function() {
        var docElement, request;

        docElement = document.documentElement;
        request = docElement.requestFullScreen || docElement.webkitRequestFullScreen || docElement.mozRequestFullScreen || docElement.msRequestFullScreen;

        if (typeof request != "undefined" && request) {
            request.call(docElement);
        }
    };

};

Agana.App.Table = function() {
    this.clickRow = function(tableRow) {
        var selector = $(tableRow).parents('table').attr('data-click-row-selector');
        var ref = $(tableRow).find(selector);

        $(ref).trigger('click');
    };
};