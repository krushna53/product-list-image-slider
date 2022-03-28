$ = jQuery;

$(window).load(function () {
    $(".slideshow").slick({
        infinite: false,
        autoplay: false,
        dots: true,
        arrows: false,
        autoplaySpeed: 4000
    });
});
