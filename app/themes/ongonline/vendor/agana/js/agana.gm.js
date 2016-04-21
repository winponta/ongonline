Agana.Gm = function(app) {    
    this.app = app;
    
    this.contentContainer = null;
    this.container = null;

    this.setContentContainer = function(container) {
        this.contentContainer = $('#'+container);
    }
    
    this.setContainer = function(container) {
        this.container = $('#'+container);
    }
    
    this.loadPage = function(urladdress, container) {        
        if(container) {
            this.setContentContainer(container);
        }
        
        var me = this;

        $.ajax({
            url: urladdress,
            success: function(data) {
//                alert($(me.contentContainer));
//                alert(me.contentContainer);
                $(me.contentContainer).html(data);                
                $(me.contentContainer).find('script').each(function(){
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
    
    this.injectLoadPageEvent = function(container) {
        if(container) {
            this.setContentContainer(container);
        }

        var me = this;
        $('#gm-container #menu-container a, #gm-container a[load-in="'+ this.app.contentContainer.id +'"]').on('click', null,
        function(event){
            event.preventDefault(); 
            me.loadPage($(this).attr('href'));
        });

        var submitSelectors = '#gm-container form[load-in="'+ this.app.contentContainer.id +'"] input[type="submit"]';
        submitSelectors += ',';
        submitSelectors = '#gm-container form[load-in="'+ this.app.contentContainer.id +'"] button[type="submit"]';
        $(submitSelectors).on('click', null, function(event){
            event.preventDefault();
            var form = $('#gm-container form[load-in="'+ this.app.contentContainer.id +'"]');
            var url = form.attr('action');
            var data = $(form).serializeArray();
            data.push(this);
            
            $.post(url,data,function(data){
                me.contentContainer.html(data);
                $(me.contentContainer).find('script').each(function(){
                    eval($(this).html());
                });
            });
            return false;
        });
    };
};