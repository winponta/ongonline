/* 
 * Main Agana Framework javascript
 */
//$(document).ready(function () {
//   $('#messages').aganaCoolMessage(); 
//});

dojo.require("dijit.layout.BorderContainer");
dojo.require("dijit.layout.ContentPane");

function getPartial() {
    
}

function loadPage(uri) {
    dijit.byId('page').setHref(uri);
}

require(["dojo/domReady!"], function(ready) {

});