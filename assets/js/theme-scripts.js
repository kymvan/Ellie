jQuery(document).ready(function(){
	
	// Show/hide the navigation	
	jQuery( '.menu-toggle, .sub-menu-toggle' ).on( 'click', function() {
			jQuery(this).attr( 'aria-pressed', function( index, value ) {
				return 'false' === value ? 'true' : 'false';
			});
	
			jQuery(this).toggleClass( 'activated' );
			jQuery(this).next( '.main-menu, .sub-menu, .menu' ).slideToggle( 'fast' );
		});
		
	//Add hover class to parent when sub-menu is selected
	jQuery('.genesis-nav-menu .sub-menu, .genesis-nav-menu li.menu-item-has-children a').hover(function(){
		jQuery(this).parent().toggleClass('sfHover');
	});
	
	//Return false # nav items
	jQuery('nav a[href*="#"]').on('click', function(){
		return false;
	});
	
	jQuery('.nav-utilities-menu .search a, .search-toggle').on('click', function(){
		jQuery('.header .search-box').slideToggle( 'fast' );
	});

	
		
	// Animate # links	
	jQuery('.content-area a[href*="#"]').not('.featherlight-link').not('#anchor-menu a[href*="#"]').click(function() {	
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			 	      var target = jQuery(this.hash);
			 	      target = target.length ? target : jQuery('[name=' + this.hash.slice(1) +']');
			 		  
			 		  var targetTop = target.offset().top - 128;
			 		  
			 		  if(jQuery(window).width() < 1024) { targetTop = target.offset().top; }
			 		  
			 	       if (target.length) {
			 	        jQuery('html,body').animate({ scrollTop: targetTop }, 1000);
			 	        return false;
			 	      }
		}
			
	});
	
	 // Animate # links	
	jQuery('#anchor-menu a[href*="#"]').click(function() {	
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			 	      var target = jQuery(this.hash);
			 	      target = target.length ? target : jQuery('[name=' + this.hash.slice(1) +']');
			 		  
			 		  var targetTop = target.offset().top - 182;
			 		  
			 		  if(jQuery(window).width() < 1024) { targetTop = target.offset().top - 218; }
			 		  
			 	       if (target.length) {
			 	        jQuery('html,body').animate({ scrollTop: targetTop }, 1000);
			 		   	if(jQuery(window).width() < 768) {
			 		   		jQuery('#anchor-menu .menu-toggle').toggleClass( 'activated' );
			 		   		jQuery('#anchor-menu .menu-toggle').next( '.menu' ).slideToggle( 'fast' );
			 		   	}
			 	        return false;
			 	      }
		}
			
	});
	
	
	//Galleries
	jQuery('.gallery-item').featherlightGallery();
	
	//Add scroll class
	jQuery(window).scroll(function() {    
		var scroll = jQuery(window).scrollTop();
			
		if (scroll >= 1) {
			        jQuery('body').addClass('scroll');
			    } else {
			       jQuery('body').removeClass('scroll');
			    }
	 });
	 
	  //Click event to scroll to top
	jQuery('.scrollToTop').click(function(){
			jQuery('html, body').animate({scrollTop : 0},1000);
			return false;
	});

	
});

//Animations
function reveal() {
  var reveals = document.querySelectorAll(".reveal");

  for (var i = 0; i < reveals.length; i++) {
    var windowHeight = window.innerHeight;
    var elementTop = reveals[i].getBoundingClientRect().top;
    var elementVisible = 150;

    if (elementTop < windowHeight - elementVisible) {
      reveals[i].classList.add("active");
    } else {
      reveals[i].classList.remove("active");
    }
	
	
  }
}

window.addEventListener("scroll", reveal);