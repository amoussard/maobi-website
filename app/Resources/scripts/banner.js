// Banner Full Height JS
$(window).on("load resize",function(){
    $winHeight = $(this).height();
    $(".banner.full").css("height",$winHeight );
});
