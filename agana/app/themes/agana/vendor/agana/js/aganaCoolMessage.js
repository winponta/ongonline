
/* 
 * Agana cool messages Dojo widget
 */

dojo.provide('agana.CoolMessage');

dojo.require('dojox.timing');
dojo.require('dojo.fx');

dojo.declare(
'agana.CoolMessage', 
dojox.timing.Timer,
{
    node: 'messages',
    location : 'right',
    opacity: 0.85,
    timeout  : 10000,
    speed: 800,
    showCloseButton: true,
        
    _timeout: function() {
        this.hide();
    },

    constructor: function(args) {
        dojo.mixin(this, args);
        this.setInterval(this.timeout);
        if (this.timeout > 0) {
            this.onTick = this._timeout;
        }
    },

    show: function(){
        if (dojo.byId(this.node) != null) {
            this.start();

            var h = dojo.query('html');
            var hwidth = h.style('width');
            var hheight = h.style('height');
            console.info(hheight);
            
//            dojo.style(this.node, {
//                position:'fixed'
////                top: '2em'
//            });

            var m = dojo.byId(this.node);
            var mpos = dojo.position(this.node, true);
            console.info(mpos);

//            dojo.style(this.node, {
//                left: (hwidth/2)-(mpos.w/2)+'px'
//            });

            console.info(this.node);

            if (this.showCloseButton) {
                m.innerHTML = m.innerHTML + "<a href='#' class='close' title='Clique nas mensagens para fechar!'></a>"; 
            }

            console.info(m.innerHTML);

            dojo.connect(dojo.byId(this.node), 'onclick', this, this.hide);

            if (this.location.toLowerCase() == 'left') {
                dojo.style(this.node, {
                    position:'fixed',
                    top: '0'+'px'
                });

                dojo.animateProperty({
                    node: this.node,
                    properties: {
                        left: {start: mpos.w*-1, end: 0},
                        opacity: {start: 0, end: this.opacity}
                    },
                    duration: this.speed
                }).play();
            } else if (this.location.toLowerCase() == 'top') {
                dojo.style(this.node, {
                    position:'fixed',
                    top: '0px',
                    left: (hwidth/2)-(mpos.w/2)+'px',
                    width: (hwidth/2)+'px'
                });

                dojo.animateProperty({
                    node: this.node,
                    properties: {
                        top: {start: mpos.h*-1, end: 0},
                        opacity: {start: 0, end: this.opacity}
                    },
                    duration: this.speed
                }).play();
            } else if (this.location.toLowerCase() == 'bottom') {
                dojo.style(this.node, {
                    position:'fixed',
                    bottom: 0+'px',
                    left: (hwidth/2)-(mpos.w/2)+'px',
                    width: (hwidth/2)+'px'
                });

                dojo.animateProperty({
                    node: this.node,
                    properties: {
                        bottom: {start: mpos.h*-1, end: 0},
                        opacity: {start: 0, end: this.opacity}
                    },
                    duration: this.speed
                }).play();

            } else {
                dojo.style(this.node, {
                    position:'fixed',
                    top: 0+'px',
                    left: (hwidth/2)-(mpos.w/2)+'px',
                    width: (hwidth/2)+'px'
                });

                dojo.animateProperty({
                    node: this.node,
                    properties: {
                        left: {start: hwidth, end: hwidth-mpos.w},
                        opacity: {start: 0, end: this.opacity}
                    },
                    duration: this.speed
                }).play();
            }
        }
    },
        
    hide: function() {
        this.stop();

        dojo.fadeOut({
            node: this.node,
            duration: this.speed,
            
            onEnd: function() {
                dojo.style(this.node, 'display', 'none');
            }
        }).play();        
    }             
}
);