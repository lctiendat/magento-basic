require(["jquery", "owlcarousel", "slick"], function ($) {
    "use strict";
    $(".owl-carousel").owlCarousel({
        items: 6,
        loop: true,
        margin: 0,
        nav: true,
        dots: false,
        autoplay: false,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 2,
            },
            768: {
                items: 4,
            },
            992: {
                items: 5,
            },
        },
    });

    $(".products-crosssell .product-items").slick({
        infinite: true,
        slidesToShow: 6,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
    });
});
