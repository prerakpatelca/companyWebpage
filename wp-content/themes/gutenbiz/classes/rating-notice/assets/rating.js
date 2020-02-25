+(function ($) {
	/**
	 * Helper class for the rating notice interface interface.
	 *
	 * @since 1.0.3
	 */
	var GutenbizNotices = {

		/**
		 * Initializes our custom logic for the Customizer.
		 *
		 * @since 1.0.3
		 * @method init
		 */
		init: function(){
			this.bind();
		},

		/**
		 * Binds events for the Gutenbiz.
		 *
		 * @since 1.0.3
		 * @method bind
		 */
		bind: function(){
			$( document ).on('click', '.gutenbiz-notice-close', this.rating_notice );	
		},

		/**
		 * Ajax request
		 *
		 * @since 1.0.3
		 */
		rating_notice: function(){
			jQuery.ajax({
				type : "POST",
				url  : gutenbiz_rate_notice.admin_url,
				data : {
					action: 'rating_notice',
				},
				success: function(response) {
					var $el = $( '#gutenbiz-rating-notice' );
					$el.fadeTo( 100, 0, function() {
						$el.slideUp( 100, function() {
							$el.remove();
						});
					});
				}
			})
		},
	}

	GutenbizNotices.init();
})(jQuery);