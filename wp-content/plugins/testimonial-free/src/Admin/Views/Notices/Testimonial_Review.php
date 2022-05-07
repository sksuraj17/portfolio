<?php
/**
 * The admin review notice.
 *
 * @since        2.1.5
 * @version      2.1.5
 *
 * @package    Testimonial
 * @subpackage Testimonial/admin/views/notices
 * @author     ShapedPlugin<support@shapedplugin.com>
 */

namespace ShapedPlugin\TestimonialFree\Admin\Views\Notices;

/**
 * Admin review notice class.
 */
class Testimonial_Review {

	/**
	 * Constructor
	 *
	 * @since 2.0
	 */
	public function __construct() {
		add_action( 'admin_notices', array( $this, 'display_admin_notice' ) );
		add_action( 'wp_ajax_sp-tfree-never-show-review-notice', array( $this, 'dismiss_review_notice' ) );
	}

	/**
	 * Display admin notice.
	 *
	 * @return void
	 */
	public function display_admin_notice() {

		// Show only to Admins.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Variable default value.
		$review = get_option( 'sp_testimonial_review_notice_dismiss' );
		$time   = time();
		$load   = false;

		if ( ! $review ) {
			$review = array(
				'time'      => $time,
				'dismissed' => false,
			);
			add_option( 'sp_testimonial_review_notice_dismiss', $review );
		} else {
			// Check if it has been dismissed or not.
			if ( ( isset( $review['dismissed'] ) && ! $review['dismissed'] ) && ( isset( $review['time'] ) && ( ( $review['time'] + ( DAY_IN_SECONDS * 3 ) ) <= $time ) ) ) {
				$load = true;
			}
		}

		// If we cannot load, return early.
		if ( ! $load ) {
			return;
		}
		?>
		<div id="sp-testimonial-review-notice" class="sp-testimonial-review-notice">
			<div class="sp-testimonial-plugin-icon">
				<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/testimonial-icon1.svg' ); ?>" alt="Testimonial">
			</div>
			<div class="sp-testimonial-notice-text">
				<h3>Enjoying <strong>Real Testimonials</strong>?</h3>
				<p>Hope that you had a good experience with the <strong>Real Testimonials</strong>. Would you please show us a little love by rating us in the <a href="https://wordpress.org/support/plugin/testimonial-free/reviews/?filter=5#new-post" target="_blank"><strong>WordPress.org</strong></a>?
				Just a minute to rate it. Thank you!</p>

				<p class="sp-testimonial-review-actions">
					<a href="https://wordpress.org/support/plugin/testimonial-free/reviews/?filter=5#new-post" target="_blank" class="button button-primary notice-dismissed rate-testimonial">Rate Real Testimonials</a>
					<a href="#" class="notice-dismissed remind-me-later"><span class="dashicons dashicons-clock"></span>Nope, maybe later
</a>
					<a href="#" class="notice-dismissed never-show-again"><span class="dashicons dashicons-dismiss"></span>Never show again</a>
				</p>
			</div>
		</div>

		<script type='text/javascript'>

			jQuery(document).ready( function($) {
				$(document).on('click', '#sp-testimonial-review-notice.sp-testimonial-review-notice .notice-dismissed', function( event ) {
					if ( $(this).hasClass('rate-testimonial') ) {
						var notice_dismissed_value = "1";
					}
					if ( $(this).hasClass('remind-me-later') ) {
						var notice_dismissed_value =  "2";
						event.preventDefault();
					}
					if ( $(this).hasClass('never-show-again') ) {
						var notice_dismissed_value =  "3";
						event.preventDefault();
					}

					$.post( ajaxurl, {
						action: 'sp-tfree-never-show-review-notice',
						notice_dismissed_data : notice_dismissed_value,
						nonce: '<?php echo esc_attr( wp_create_nonce( 'sp_tfree_review_notice' ) ); ?>'
					});

					$('#sp-testimonial-review-notice.sp-testimonial-review-notice').hide();
				});
			});

		</script>
		<?php
	}

	/**
	 * Dismiss review notice
	 *
	 * @since  2.1.5
	 *
	 * @return void
	 **/
	public function dismiss_review_notice() {
		$post_data = wp_unslash( $_POST );

		if ( ! isset( $post_data['nonce'] ) || ! wp_verify_nonce( sanitize_key( $post_data['nonce'] ), 'sp_tfree_review_notice' ) ) {
			return;
		}
		// Variable default value.
		$review = get_option( 'sp_testimonial_review_notice_dismiss' );
		if ( ! $review ) {
			$review = array();
		}
		switch ( isset( $post_data['notice_dismissed_data'] ) ? $post_data['notice_dismissed_data'] : '' ) {
			case '1':
				$review['time']      = time();
				$review['dismissed'] = false;
				break;
			case '2':
				$review['time']      = time();
				$review['dismissed'] = false;
				break;
			case '3':
				$review['time']      = time();
				$review['dismissed'] = true;
				break;
		}
		update_option( 'sp_testimonial_review_notice_dismiss', $review );
		die;
	}
}
