(function($) {
	function find_page_number( element ) {
		element.find('span').remove();
		return parseInt( element.html() );
	}
	
	$(document).on( 'click', '.pagination a', function( event ) {
		event.preventDefault();
		var page = find_page_number( $(this).clone() );
		var blogID = $('#blog-id').html();
		var catID = $('#cat-id').html();
		
		$.ajax({
			url: ajaxpagination.ajaxurl,
			type: 'post',
			data: {
				action: 'ajax_pagination',
				query_vars: ajaxpagination.query_vars,
				page: page,
				site: blogID,
				cat: catID
			},
			beforeSend: function() {
				$('#blog .post-container').find( 'article' ).remove();
				$('#blog .post-container .archive-pagination').remove();
				var targetTop = $('#blog').offset().top - 120;
				jQuery('html,body').animate({ scrollTop: targetTop }, 1000);
				$('#blog .post-container').append( '<div id="loader"></div>' );
			},
			success: function( result ) {
				$('#blog .post-container').find( '#loader' ).remove();
				$('#blog .post-container').append(result);
			}
		})
	})
})(jQuery);