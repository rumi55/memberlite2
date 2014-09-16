/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens.
 */
jQuery(document).ready(function(){		
	var mobilenav_trigger = jQuery('button.menu-toggle');
	
/*	mobilenav_trigger.click(function() {		
		jQuery('#mobile-navigation').toggleClass('toggled');
	});
*/
	mobilenav_trigger.click(function() {	
		jQuery('#mobile-navigation').after(jQuery('<div id="mobile-navigation-height-col"></div>'));
		jQuery('#mobile-navigation').toggleClass('toggled');
		jQuery('#mobile-navigation').animate({
            left: '0px'
       });
	   jQuery('#mobile-navigation-height-col').animate({
            left: '0px'
       });
		if(jQuery('#mobile-navigation').hasClass('toggled')){
			jQuery('#mobile-navigation').animate({
				left: '-100%'
		   });
		   jQuery('#mobile-navigation-height-col').animate({
				left: '-100%'
		   });	
		};
	});
});
