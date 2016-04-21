Agana = function() {
};

Agana.Math = function() {
};

/**
 * Parse a String or integer to float, test is the string has comma as separator
 * and fixs it to point.
 * 
 * @param String | float number
 * @returns {float}
 */
Agana.Math.parseFloat = function(number) {
    if (typeof number == 'string' || number instanceof String) {
        return parseFloat(number.replace(",", "."));
    } else {
        return number;
    }
}

Agana.TinyMCE = {};

Agana.TinyMCE.DefaultConfig = {
        selector: "textarea.editor",
        language: 'pt_BR',
        convert_fonts_to_spans: true,
        menubar: false,
        statusbar: false,
        plugins: "textcolor",
        tools: "inserttable",
        toolbar: "styleselect fontselect fontsizeselect bold italic underline strikethrough \n\
                    forecolor backcolor \n\
                    | outdent indent blockquote numlist bullist hr \n\
                    alignleft aligncenter alignright alignjustify",
//                    cut copy paste removeformat undo redo",
        theme_advanced_blockformats: "p,div,h1,h2,h3,h4,h5,h6,blockquote,dt,dd,code,samp",
        style_formats: [
            {title: 'Título', block: 'h1'},
            {title: 'Sub título', block: 'h2'},
            {title: 'Tópico', block: 'h3'},
            {title: 'Destaque vermelho', inline: 'span', styles: {color: '#a33'}},
            {title: 'Destaque vermelho negrito', inline: 'span', styles: {'font-weight': 'bold', color: '#a33'}},
            {title: 'Destaque fundo vermelho', inline: 'span', styles: {color: '#000', background: '#f88'}},
            {title: 'Destaque fundo vermelho negrito', inline: 'span', styles: {'font-weight': 'bold', color: '#000', background: '#f88'}},
            {title: 'Destaque amarelo', inline: 'span', styles: {color: '#ff0'}},
            {title: 'Destaque amarelo negrito', inline: 'span', styles: {'font-weight': 'bold', color: '#ff0'}},
            {title: 'Destaque fundo amarelo', inline: 'span', styles: {color: '#222', background: '#ff0'}},
            {title: 'Destaque fundo amarelo negrito', inline: 'span', styles: {'font-weight': 'bold', color: '#222', background: '#ff0'}},
        ],
    };