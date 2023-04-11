require([
	"jquery",
    "owlcarousel"
  ], function ($)
 {
    "use strict";
	$('.owl-carousel').owlCarousel({
      items: 5,
      loop: true,
      margin: 0,
      nav: true,
      dots: false,
      autoplay: false,
      autoplayHoverPause: true,
      responsive: {
          0: {
              items: 1
          },
          768: {
              items: 3
          },
          992: {
              items: 4
          }
      }
  });
  });