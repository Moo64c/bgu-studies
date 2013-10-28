/**
 * @file
 * Override the jCarousel buttons markup
 */

(function($) {

Drupal.theme.prototype.jCarouselButton = function(type) {
  return '<a href="javascript:void(0)" class="arrow"><span class="circle"><span class="arrow"></span></span></a>';
};

})(jQuery);
