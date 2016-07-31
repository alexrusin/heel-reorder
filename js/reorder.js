(function($){
	$(document).ready(function(){
		var sortList = $('ul#custom-type-list-women');
		var animation = $('#loading-animation-womens');
		var pageTitle = $('.womens')
		sortList.sortable({
			update: function(event, ui){
				animation.show();
				$.ajax({
					url: ajaxurl,
					type: 'POST',
					dataType: 'json',
					data: {
						action: 'save_sort',
						order: sortList.sortable('toArray'),
						security: whr_heels_reorder.security
					},
					success: function(response){
						$( 'div#message' ).remove();
						animation.hide();
						if( true === response.success ) {
							pageTitle.after( '<div id="message" class="updated"><p>' + whr_heels_reorder.success + '</p></div>' );
						} else {
							pageTitle.after( '<div id="message" class="error"><p>' + whr_heels_reorder.failure + '</p></div>' );
						}
					},
					error: function(error){
						$( 'div#message' ).remove();
						animation.hide();
						pageTitle.after( '<div id="message" class="error"><p>' + whr_heels_reorder.failure+' '+error.responseText + '</p></div>' )

					}
				});
			}
		});
		console.log(sortList.sortable('toArray'));
	});
})(jQuery);