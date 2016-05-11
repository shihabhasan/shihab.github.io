jQuery( document ).ready(function() {

	// add submenu icons class in main menu (only for large resolution)
	if (fpsychology_IsLargeResolution()) {
	
		jQuery('#navmain > div > ul > li:has("ul")').addClass('level-one-sub-menu');
		jQuery('#navmain > div > ul li ul li:has("ul")').addClass('level-two-sub-menu');										
	}

	jQuery('#header-spacer').height(jQuery('#header-main-fixed').height());

	jQuery('#navmain > div').on('click', function(e) {

		e.stopPropagation();

		// toggle main menu
		if (fpsychology_IsSmallResolution() || fpsychology_IsMediumResolution()) {

			var parentOffset = jQuery(this).parent().offset(); 
			
			var relY = e.pageY - parentOffset.top;
		
			if (relY < 36) {
			
				jQuery('ul:first-child', this).toggle(400);
			}
		}
	});

	jQuery("#navmain > div > ul li").mouseleave( function() {
		if (fpsychology_IsLargeResolution()) {
			jQuery(this).children("ul").stop(true, true).css('display', 'block').slideUp(300);
		}
	});
	
	jQuery("#navmain > div > ul li").mouseenter( function() {
		if (fpsychology_IsLargeResolution()) {

			var curMenuLi = jQuery(this);
			jQuery("#navmain > div > ul > ul:not(:contains('#" + curMenuLi.attr('id') + "')) ul").hide();
		
			jQuery(this).children("ul").stop(true, true).css('display','none').slideDown(400);
		}
	});

	if (jQuery('#camera_wrap').length > 0) {

		jQuery('#camera_wrap').camera({
			height: fpsychology_IsLargeResolution() ? '450px' : '300px',
			pagination: true,
			thumbnails: false,
			time: 4500,
	        navigationHover : false,
	        playPause : false,
	        barPosition: 'right',
	        barDirection : 'topToBottom',
	        loader: 'pie',
	        opacityOnGrid: false,
	        piePosition: 'rightTop'
		});
	}
});

function fpsychology_IsSmallResolution() {

	return (jQuery(window).width() <= 360);
}

function fpsychology_IsMediumResolution() {
	
	var browserWidth = jQuery(window).width();

	return (browserWidth > 360 && browserWidth < 800);
}

function fpsychology_IsLargeResolution() {

	return (jQuery(window).width() >= 800);
}

jQuery(document).ready(function () {

  jQuery(window).scroll(function () {
	  if (jQuery(this).scrollTop() > 100) {
		  jQuery('.scrollup').fadeIn();
	  } else {
		  jQuery('.scrollup').fadeOut();
	  }
  });

  jQuery('.scrollup').click(function () {
	  jQuery("html, body").animate({
		  scrollTop: 0
	  }, 600);
	  return false;
  });

});