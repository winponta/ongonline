$(document).ready(function(){
    $(".debug").click(function () {
        $(this).find('section').slideToggle("slow", function () {
            if ($(this).is(":visible")) {
                $(this).parent().find('.arrow').html('&uarr;');
            } else {
                $(this).parent().find('.arrow').html('&darr;');
            }
        });
    });

});