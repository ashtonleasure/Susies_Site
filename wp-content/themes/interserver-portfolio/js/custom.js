jQuery(document).ready(function () {
   "use strict";
   if (jQuery('#slider').length > 0) {
      jQuery('.nivoSlider').nivoSlider({
         effect: 'slide',
         animSpeed: 500,
         pauseTime: 3000,
         startSlide: 0,
         directionNav: true,
         controlNav: true,
         pauseOnHover: false,
      });
   }
   jQuery('body').prepend('<a href="#" class="back-to-top">Back to Top</a>');
   jQuery('#filters li a').click(function () {
      jQuery(this).addClass('active');
      return false;
   });
   var filterList = {
      init: function () {
         // MixItUp plugin
         // http://mixitup.io
         jQuery('#portfoliolist').mixItUp({
            selectors: {
               target: '.portfolio',
               filter: '.filter'
            },
         });
      }
   };
   // Run the show!
   filterList.init();
});
var amountScrolled = 300;
jQuery(window).scroll(function () {
   "use strict";
   var scroll = jQuery(window).scrollTop();
   if (scroll >= 100) {
      jQuery(".site-header").addClass("small");
   } else {
      jQuery(".site-header").removeClass("small");
   }
   if (jQuery(window).scrollTop() > amountScrolled) {
      jQuery('a.back-to-top').fadeIn('slow');
   } else {
      jQuery('a.back-to-top').fadeOut('slow');
   }
});
jQuery(function () {
   "use strict";
   jQuery('a[href*="#"]:not([href="#"])').click(function () {
      if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
         var target = jQuery(this.hash);
         target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
         if (target.length) {
            jQuery('html, body').animate({
               scrollTop: target.offset().top
            }, 1000);
            return false;
         }
      }
   });
});
// initialize magnific popup galleries with titles and descriptions
jQuery(document).ready(function () {
   "use strict";
   jQuery('.pop').magnificPopup({
      type: 'image'
   });
   //Initialize for wordpress galleries
   jQuery('.gallery').magnificPopup({
      delegate: 'a',
      type: 'image',
      gallery: {
         enabled: true
      }
   });
});