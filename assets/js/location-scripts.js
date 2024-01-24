jQuery(document).ready(function(){
	//Add scroll class
	var distance = jQuery('.anchor-menu').offset().top, jQuerywindow = jQuery(window);
	
	jQuery(window).scroll(function() {    
		 if ( jQuerywindow.scrollTop() >= distance ) {
	       jQuery('.anchor-menu').addClass('at-top');
		 }
		 
		 var scroll = jQuery(window).scrollTop();
		 if (scroll == 0) {
		 	jQuery('.anchor-menu').removeClass('at-top');
		 }	
	 });
	 
	 // Animate # links	
	jQuery('#anchor-menu a[href*="#"]').click(function() {	
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			 	      var target = jQuery(this.hash);
			 	      target = target.length ? target : jQuery('[name=' + this.hash.slice(1) +']');
			 		  
			 		  var targetTop = target.offset().top - 10;
			 		  
			 		  
			 	       if (target.length) {
			 	        jQuery('html,body').animate({ scrollTop: targetTop }, 1000);
			 		   	if(jQuery(window).width() < 1024) {
			 		   		jQuery('.anchor-menu .menu-toggle').toggleClass( 'activated' );
			 		   		jQuery('.anchor-menu .menu-toggle').next( '.menu' ).slideToggle( 'fast' );
			 		   	}
			 	        return false;
			 	      }
		}
			
	});

});