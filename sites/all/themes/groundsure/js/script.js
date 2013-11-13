(function ($) {
    $(document).ready(function(){

    //----------------info toolkit----------------------------
        $( ".repotr-info" ).hover(
            function() {
                $(this).find(".field").css("display", "block");
            },
            function() {
                $(this).find(".field").css("display", "none");
            }
        );
    //----------------end info toolkit----------------------------

    //----------------footer menu breakpoint----------------------------
        if($(window).width() < 974) $( "#header").find(".menu-block-2" ).clone().prependTo( "#footer" );
        if($(window).width() < 751) $( "#footer").find(".menu-block-2" ).prepend( "<h3>Further Actions</h3>" );
        $( window ).resize(function() {
            if($(this).width() > 973){
                $( "#footer .menu-level-1" ).remove();
            }
            else if($(this).width() > 751){
                $( "#footer .menu-level-1" ).remove();
                $( "#header").find(".menu-block-2" ).clone().prependTo( "#footer" );
            }
            else {
                $( "#footer .menu-level-1" ).remove();
                $( "#header").find(".menu-block-2" ).clone().prependTo( "#footer" );
                $( "#footer").find(".menu-block-2" ).prepend( "<h3>Further Actions</h3>" );
            }
        });
    //----------------end footer menu breakpoint----------------------------

    //----------------mobile-menu----------------------------
        $( ".menu-block-3 > .menu > li.first > a").clone().prependTo( ".menu-block-3" );
        $( ".menu-block-3" ).click(function() {
            $( this ).find("> .menu" ).slideToggle();
        });
    //----------------end mobile-menu----------------------------
    });
})(jQuery);
