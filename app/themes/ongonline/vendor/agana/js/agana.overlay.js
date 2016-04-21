Agana.Overlay = function(app) {    
    this.app = app;
    
    this.contentContainer = null;
    this.container = null;

    this.setContentContainer = function(container) {
        container = ((container.indexOf('#')== -1) ? '#' : '') + container;
        this.contentContainer = $(container);
    };
    
    this.setContainer = function(container) {
        this.container = $('#'+container);
    };
    
    this.getContentContainer = function() {
        if (! this.contentContainer.length) {
            this.setContentContainer(this.contentContainer.selector);
        }
        
        return this.contentContainer;
    };
    
    this.loadPage = function(urladdress, container) {        
        if(container) {
            this.setContentContainer(container);
        }
        
        var me = this;

        $.ajax({
            url: urladdress,
            success: function(data) {
                console.info($(me.contentContainer));
                console.info(me.contentContainer);
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
    
    this.injectLoadPageEvent = function(container) {
        if(container) {
            this.setContentContainer(container);
        }

        var me = this;
        $('body').on('click', 
        '#' + this.container.id + ' #menu-container a, #' + this.container.id + ' a[load-in="'+ this.app.contentContainer.id +'"]',
        function(event){
            event.preventDefault(); 
            me.loadPage($(this).attr('href'));
        });

        $('body').on('click',
        '#' + this.container.id + ' form[load-in="'+ this.app.contentContainer.id +'"] input[type="submit"]',
        function(event){
            event.preventDefault();
            var form = $('#' + me.container.id + ' form[load-in="'+ this.app.contentContainer.id +'"]');
            var url = form.attr('action');
            var data = $(form).serializeArray();
            data.push(this);
            
            $.post(url,data,function(data){
                me.contentContainer.html(data);
            });
            return false;
        });
    };
};