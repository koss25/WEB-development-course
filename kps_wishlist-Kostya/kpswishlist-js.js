jQuery(document).ready(function ($) {

	$('body').on('click', '#kps_add_wishlist', function(e) {
		e.preventDefault();
		
		$.post(MyAjax.ajax_url,
			MyAjax,
			function(response) {
				if (response.success) {
					$('#kps_add_wishlist_div')
					.html(`
						<a id="kps_add_wishlist" href="" title="Click to remove from wishlist">
						   <i class="fa fa-heart" aria-hidden="true"></i>In wishlist
						</a>
					 `);
				} else {
					$('#kps_add_wishlist_div')
					.html(`
						<a id="kps_add_wishlist" href="" title="Click to add to wishlist">
							<i class="fa fa-heart-o" aria-hidden="true"></i>Add to wishlist
						</a>
				  `);
				}
			}
		);
	});

});
