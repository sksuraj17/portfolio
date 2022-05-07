<?php
/**
 * Functions file.
 *
 * @link http://shapedplugin.com
 * @since 2.0.0
 *
 * @package Testimonial_free.
 * @subpackage Testimonial_free/includes.
 */

namespace ShapedPlugin\TestimonialFree\Includes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}  // if direct access

/**
 * Functions
 */
class TFREE_Functions {

	/**
	 * Initialize the class
	 */
	public function __construct() {
		add_filter( 'post_updated_messages', array( $this, 'sp_tfree_change_default_post_update_message' ) );
		add_filter( 'admin_footer_text', array( $this, 'admin_footer' ), 1, 2 );
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 100 );
		// Post thumbnails.
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'tf-client-image-size', 120, 120, true );
	}

	/**
	 * Post update messages for Shortcode Generator
	 *
	 * @param string $message post update message.
	 */
	public function sp_tfree_change_default_post_update_message( $message ) {
		$screen = get_current_screen();
		if ( 'spt_shortcodes' === $screen->post_type ) {
			$message['post'][1]  = esc_html__( 'View updated.', 'testimonial-free' );
			$message['post'][4]  = esc_html__( 'View updated.', 'testimonial-free' );
			$message['post'][6]  = esc_html__( 'View published.', 'testimonial-free' );
			$message['post'][8]  = esc_html__( 'View submitted.', 'testimonial-free' );
			$message['post'][10] = esc_html__( 'View draft updated.', 'testimonial-free' );
		} elseif ( 'spt_testimonial' === $screen->post_type ) {
			$message['post'][1]  = esc_html__( 'Testimonial updated.', 'testimonial-free' );
			$message['post'][4]  = esc_html__( 'Testimonial updated.', 'testimonial-free' );
			$message['post'][6]  = esc_html__( 'Testimonial published.', 'testimonial-free' );
			$message['post'][8]  = esc_html__( 'Testimonial submitted.', 'testimonial-free' );
			$message['post'][10] = esc_html__( 'Testimonial draft updated.', 'testimonial-free' );
		}

		return $message;
	}

	/**
	 * Review Text
	 *
	 * @param string $text Footer review text.
	 *
	 * @return string
	 */
	public function admin_footer( $text ) {
		$screen = get_current_screen();
		if ( 'spt_testimonial' === get_post_type() || 'spt_testimonial_page_tfree_help' === $screen->id || 'spt_shortcodes' === $screen->post_type ) {
			$url  = 'https://wordpress.org/support/plugin/testimonial-free/reviews/?filter=5#new-post';
			$text = sprintf(
				wp_kses_post( 'If you like <strong>Real Testimonials</strong> please leave us a <a href="%s" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a> rating. Your Review is very important to us as it helps us to grow more. ' ),
				esc_url( $url )
			);
		}
		if ( 'spt_testimonial_page_testimonial_premium' === $screen->id || 'spt_testimonial_page_tfree_help' === $screen->id ) {
			$text = '';
			add_filter( 'update_footer', '__return_empty_string', 11 );
		}
		return $text;
	}

	/**
	 * Admin Menu.
	 */
	public function admin_menu() {
		add_submenu_page(
			'edit.php?post_type=spt_testimonial',
			__( 'Real Testimonials Pro', 'testimonial-free' ),
			__( 'Premium', 'testimonial-free' ),
			'manage_options',
			'testimonial_premium',
			array(
				$this,
				'premium_page_callback',
			)
		);
		add_submenu_page(
			'edit.php?post_type=spt_testimonial',
			__( 'Real Testimonials Help', 'testimonial-free' ),
			__( 'Help', 'testimonial-free' ),
			'manage_options',
			'tfree_help',
			array(
				$this,
				'help_page_callback',
			)
		);
	}

	/**
	 * Happy users.
	 *
	 * @param string $username Happy users.
	 * @param array  $args Happy users args.
	 * @return array
	 */
	public function happy_users( $username = 'shapedplugin', $args = array() ) {
		if ( $username ) {
			$params = array(
				'timeout'   => 10,
				'sslverify' => false,
			);

			$raw = wp_remote_retrieve_body( wp_remote_get( 'http://wptally.com/api/' . $username, $params ) );
			$raw = json_decode( $raw, true );

			if ( array_key_exists( 'error', $raw ) ) {
				$data = array(
					'error' => $raw['error'],
				);
			} else {
				$data = $raw;
			}
		} else {
			$data = array(
				'error' => __( 'No data found!', 'testimonial-free' ),
			);
		}

		return $data;
	}

	/**
	 * Premium Page Callback
	 */
	public function premium_page_callback() {
		wp_enqueue_style( 'testimonial-free-admin-premium', SP_TFREE_URL . 'Admin/assets/css/premium-page.min.css', array(), SP_TFREE_VERSION );
		wp_enqueue_style( 'testimonial-free-admin-premium-modal', SP_TFREE_URL . 'Admin/assets/css/modal-video.min.css', array(), SP_TFREE_VERSION );
		wp_enqueue_script( 'testimonial-free-admin-premium', SP_TFREE_URL . 'Admin/assets/js/jquery-modal-video.min.js', array( 'jquery' ), SP_TFREE_VERSION, true );
		?>
		<!-- Banner section start -->
		<div class="sp-testimonial-premium-wraper">
		<section class="sp_testimonial-banner">
			<div class="sp_testimonial-container">
				<div class="row">
					<div class="sp_testimonial-col-xl-6">
						<div class="sp_testimonial-banner-content">
							<h2 class="sp_testimonial-font-30 main-color sp_testimonial-font-weight-500"><?php esc_html_e( 'Upgrade To Real Testimonials Pro', 'testimonial-free' ); ?></h2>
							<h4 class="sp_testimonial-mt-10 sp_testimonial-font-18 sp_testimonial-font-weight-500"><?php echo wp_kses_post( 'Supercharge <strong>Real Testimonials</strong> with powerful functionality!' ); ?></h4>
							<p class="sp_testimonial-mt-25 text-color-2 line-height-20 sp_testimonial-font-weight-400"><?php esc_html_e( 'Easily collect, manage, and display testimonials reviews, or quotes in multiple ways on any page on your WordPress site. The plugin comes with the easiest Shortcode Generator settings panel that can help you build awesome and unique testimonials showcase with responsive layouts and customized styles.', 'testimonial-free' ); ?></p>
							<p class="sp_testimonial-mt-20 text-color-2 sp_testimonial-line-height-20 sp_testimonial-font-weight-400"><?php esc_html_e( 'Create unlimited Testimonial Collection Forms with our drag-and-drop form builder. Use our smartly designed testimonial form to collect detailed feedback from your customers.', 'testimonial-free' ); ?></p>
						</div>
						<div class="sp_testimonial-banner-button sp_testimonial-mt-40">
							<a class="sp_testimonial-btn sp_testimonial-btn-sky" href="https://shapedplugin.com/real-testimonials/?ref=1" target="_blank">Upgrade To Pro Now</a>
							<a class="sp_testimonial-btn sp_testimonial-btn-border ml-16 sp_testimonial-mt-15" href="https://demo.shapedplugin.com/testimonial/" target="_blank">Live Demo</a>
						</div>
					</div>
					<div class="sp_testimonial-col-xl-6">
						<div class="sp_testimonial-banner-img">
							<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/premium/premium-vector-3.svg' ); ?>" alt="">
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Banner section End -->

		<!-- Count section Start -->
		<section class="sp_testimonial-count">
			<div class="sp_testimonial-container">
				<div class="sp_testimonial-count-area">
					<div class="count-item">
						<h3 class="sp_testimonial-font-24">
						<?php
						$plugin_data  = $this->happy_users();
						$plugin_names = array_values( $plugin_data['plugins'] );

						$active_installations = array_column( $plugin_names, 'installs', 'url' );
						echo esc_attr( $active_installations['http://wordpress.org/plugins/testimonial-free'] ) . '+';
						?>
						</h3>
						<span class="sp_testimonial-font-weight-400">Active Installations</span>
					</div>
					<div class="count-item">
						<h3 class="sp_testimonial-font-24">
						<?php
						$active_installations = array_column( $plugin_names, 'downloads', 'url' );
						echo esc_attr( $active_installations['http://wordpress.org/plugins/testimonial-free'] );
						?>
						</h3>
						<span class="sp_testimonial-font-weight-400">all time downloads</span>
					</div>
					<div class="count-item">
						<h3 class="sp_testimonial-font-24">
						<?php
						$active_installations = array_column( $plugin_names, 'rating', 'url' );
						echo esc_attr( $active_installations['http://wordpress.org/plugins/testimonial-free'] ) . '/5';
						?>
						</h3>
						<span class="sp_testimonial-font-weight-400">user reviews</span>
					</div>
				</div>
			</div>
		</section>
		<!-- Count section End -->

		<!-- Video Section Start -->
		<section class="sp_testimonial-video">
			<div class="sp_testimonial-container">
				<div class="section-title text-center">
					<h2 class="sp_testimonial-font-28">Increase Conversions with Real Testimonials Pro</h2>
					<h4 class="sp_testimonial-font-16 sp_testimonial-mt-10 sp_testimonial-font-weight-400">Make customers 70% more probable to purchase with testimonials that drive sales</h4>
				</div>
				<div class="video-area text-center">
					<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/premium/premium-vector-1.svg' ); ?>" alt="">
					<div class="video-button">
						<a class="js-video-button" href="#" data-channel="youtube" data-video-url="//www.youtube.com/embed/4wtkBqZ4Urw">
							<span><i class="fa fa-play"></i></span>
						</a>
					</div>
				</div>
			</div>
		</section>
		<!-- Video Section End -->

		<!-- Features Section Start -->
		<section class="sp_testimonial-feature">
			<div class="sp_testimonial-container">
				<div class="section-title text-center">
					<h2 class="sp_testimonial-font-28">Key Pro Features</h2>
					<h4 class="sp_testimonial-font-16 sp_testimonial-mt-10 sp_testimonial-font-weight-400">Upgrading to Pro will get you the following amazing benefits.</h4>
				</div>
				<div class="feature-wrapper">
					<div class="feature-area">
						<div class="feature-item mr-30">
							<div class="feature-icon">
								<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/premium/layouts.svg' ); ?>" alt="">
							</div>
							<div class="feature-content">
								<h3 class="sp_testimonial-font-18 sp_testimonial-font-weight-600">5+ Beautiful Layouts</h3>
								<p class="sp_testimonial-font-15 sp_testimonial-mt-15 sp_testimonial-line-height-24">You can select from 5 beautiful testimonial layouts: Slider, Grid, Masonry, List, & Isotope Filter. Creating a customized layout is super easy. You can change the number of layout columns, reviewer info to show, font, & color etc.</p>
							</div>
						</div>
						<div class="feature-item ml-30">
							<div class="feature-icon">
								<img src="
								<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/premium/themes.svg' ); ?>
								" alt="">
							</div>
							<div class="feature-content">
								<h3 class="sp_testimonial-font-18 sp_testimonial-font-weight-600">10+ Professionally Designed Themes</h3>
								<p class="sp_testimonial-font-15 sp_testimonial-mt-15 sp_testimonial-line-height-24">Get designer quality results without writing a single line of code through 10+ professionally pre-designed themes for front-end display. Each theme has a different structure and huge customization options to cover all the demands.</p>
							</div>
						</div>
					</div>
					<div class="feature-area">
						<div class="feature-item mr-30">
							<div class="feature-icon">
								<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/premium/filter.svg' ); ?>" alt="">
							</div>
							<div class="feature-content">
								<h3 class="sp_testimonial-font-18 sp_testimonial-font-weight-600">Filter Testimonials (Groups, Specific, Exclude)</h3>
								<p class="sp_testimonial-font-15 sp_testimonial-mt-15 sp_testimonial-line-height-24">You have the ability to control what testimonials you'll display ot not. You can easily display testimonials by filtering them on your website. You can display groups or specific testimonials and also exclude testimonials if you need.</p>
							</div>
						</div>
						<div class="feature-item ml-30">
							<div class="feature-icon">
								<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/premium/display-options.svg' ); ?>" alt="">
							</div>
							<div class="feature-content">
								<h3 class="sp_testimonial-font-18 sp_testimonial-font-weight-600">14 Display Options (Information Fields)</h3>
								<p class="sp_testimonial-font-15 sp_testimonial-mt-15 sp_testimonial-line-height-24">Pick individual fields for each Testimonial's information. You can toggle between Testimonial Image, Video, title, Content, Name, Rating star, identity, Company, Location, Mobile, E-mail, Date, Website, And Social profile links.</p>
							</div>
						</div>
					</div>
					<div class="feature-area">
						<div class="feature-item mr-30">
							<div class="feature-icon">
								<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/premium/submission-forms.svg' ); ?>" alt="">
							</div>
							<div class="feature-content">
								<h3 class="sp_testimonial-font-18 sp_testimonial-font-weight-600">Multiple Testimonials Submission Forms</h3>
								<p class="sp_testimonial-font-15 sp_testimonial-mt-15 sp_testimonial-line-height-24">You can create Front-end Submission Form for customers to collect new testimonials for your business. When you receive a new testimonial, simply review and approve it to automatically add it to your customer testimonials page!</p>
							</div>
						</div>
						<div class="feature-item ml-30">
							<div class="feature-icon">
								<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/premium/drag-and-drop.svg' ); ?>" alt="">
							</div>
							<div class="feature-content">
								<h3 class="sp_testimonial-font-18 sp_testimonial-font-weight-600">Drag & Drop Submission Forms Fields</h3>
								<p class="sp_testimonial-font-15 sp_testimonial-mt-15 sp_testimonial-line-height-24">You can choose which fields and the messages to display! You can sort your own order and control show/hide, required, label and placeholder attribute for all fields in Testimonial Submission Form. It’s that simple.</p>
							</div>
						</div>
					</div>
					<div class="feature-area">
						<div class="feature-item mr-30">
							<div class="feature-icon">
								<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/premium/thumbnail-slider.svg' ); ?>" alt="">
							</div>
							<div class="feature-content">
								<h3 class="sp_testimonial-font-18 sp_testimonial-font-weight-600">Thumbnail Testimonial Slider</h3>
								<p class="sp_testimonial-font-15 sp_testimonial-mt-15 sp_testimonial-line-height-24">One of the most stunning features of Real Testimonials Pro is the ability to create Thumbnail Slider. If you enable thumbnail slider, you can display testimonials using the Thumbnail Slider. It's modern and looks pretty.</p>
							</div>
						</div>
						<div class="feature-item ml-30">
							<div class="feature-icon">
								<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/premium/video-testimonial.svg' ); ?>" alt="">
							</div>
							<div class="feature-content">
								<h3 class="sp_testimonial-font-18 sp_testimonial-font-weight-600">Video Testimonial with Lightbox</h3>
								<p class="sp_testimonial-font-15 sp_testimonial-mt-15 sp_testimonial-line-height-24">Video Testimonials are more effective to increase sales of a business. You can create video testimonial with Lightbox instead of simple image testimonial with Real Testimonials Pro. You can use video from YouTube, Vimeo or any video link.</p>
							</div>
						</div>
					</div>
					<div class="feature-area">
						<div class="feature-item mr-30">
							<div class="feature-icon">
								<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/premium/read-more.svg' ); ?>" alt="">
							</div>
							<div class="feature-content">
								<h3 class="sp_testimonial-font-18 sp_testimonial-font-weight-600">Read More Action Type (Expand/PopUp)</h3>
								<p class="sp_testimonial-font-15 sp_testimonial-mt-15 sp_testimonial-line-height-24">You can choose Read More button action type to show testimonial in a expand or popup page. In Expand, the testimonial content will collapse and expand long blocks of text. In PopUp, All Testimonials content will show like lightbox.</p>
							</div>
						</div>
						<div class="feature-item ml-30">
							<div class="feature-icon">
								<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/premium/rich-snippets.svg' ); ?>" alt="">
							</div>
							<div class="feature-content">
								<h3 class="sp_testimonial-font-18 sp_testimonial-font-weight-600">Rich Snippets/Structured Data Compatible</h3>
								<p class="sp_testimonial-font-15 sp_testimonial-mt-15 sp_testimonial-line-height-24">Take full advantage of your testimonials with Schema.org. When used properly this information might display in the search engine result pages! Real Testimonials Pro uses schema.org compliant JSON-LD markup to appear correctly in search.</p>
							</div>
						</div>
					</div>
					<div class="feature-area">
						<div class="feature-item mr-30">
							<div class="feature-icon">
								<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/premium/ajax-pagination.svg' ); ?>" alt="">
							</div>
							<div class="feature-content">
								<h3 class="sp_testimonial-font-18 sp_testimonial-font-weight-600">Ajax Pagination</h3>
								<p class="sp_testimonial-font-15 sp_testimonial-mt-15 sp_testimonial-line-height-24">
								Ajax Pagination (Number, Load More, & Infinite Scroll) for Grid, List, and Masonry Layouts. You can control the number testimonials how many you want load on per click and customize the required settings.  </p>
							</div>
						</div>
						<div class="feature-item ml-30">
							<div class="feature-icon">
								<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/premium/translation-ready.svg' ); ?>" alt="">
							</div>
							<div class="feature-content">
								<h3 class="sp_testimonial-font-18 sp_testimonial-font-weight-600">Translation Ready with WPML</h3>
								<p class="sp_testimonial-font-15 sp_testimonial-mt-15 sp_testimonial-line-height-24">Real Testimonials Pro is fully Translation ready with WPML, Polylang, qTranslate-x, GTranslate, Google Language Translator, WPGlobus – Multilingual Everything! You can easily translate into your language.</p>
							</div>
						</div>
					</div>
					<div class="feature-area">
						<div class="feature-item mr-30">
							<div class="feature-icon">
								<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/premium/automatic-updates.svg' ); ?>" alt="">
							</div>
							<div class="feature-content">
								<h3 class="sp_testimonial-font-18 sp_testimonial-font-weight-600">Built-in Automatic Updates</h3>
								<p class="sp_testimonial-font-15 sp_testimonial-mt-15 sp_testimonial-line-height-24">You'll get Automatic Updates when you activate the license key in your site. Once you buy the Real Testimonials Pro, you will get regular update notification to the dashboard. You can see the change logs before update.</p>
							</div>
						</div>
						<div class="feature-item ml-30">
							<div class="feature-icon">
								<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/premium/support.svg' ); ?>" alt="">
							</div>
							<div class="feature-content">
								<h3 class="sp_testimonial-font-18 sp_testimonial-font-weight-600">Fast & Friendly Support (One to One)</h3>
								<p class="sp_testimonial-font-15 sp_testimonial-mt-15 sp_testimonial-line-height-24">We love our valued customers! We always strive to provide 5-star, timely, and comprehensive support whenever you need a helping hand. We've a full time dedicated support team who are always ready to make you happy!</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Features Section End -->

		<!-- Buy Section Start -->
		<section class="sp_testimonial-buy">
			<div class="sp_testimonial-container">
				<div class="row">
					<div class="sp_testimonial-col-xl-6">
						<div class="buy-img">
							<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/premium/premium-vector-2.svg' ); ?>" alt="">
						</div>
					</div>
					<div class="sp_testimonial-col-xl-6">
						<div class="buy-content text-center">
							<h2 class="sp_testimonial-font-28">Join
							<?php
							$install = 0;
							foreach ( $plugin_names as &$plugin_name ) {
								$install += $plugin_name['installs'];
							}
							echo esc_attr( $install + '15000' ) . '+';
							?>
							Happys Users in 160+ Countries </h2>
							<p class="sp_testimonial-font-16 sp_testimonial-mt-25 sp_testimonial-line-height-22">98% of customers are happy with <b>ShapedPlugin's</b> products and support. <br>
								So it’s a great time to join them.</p>
							<a class="sp_testimonial-btn sp_testimonial-btn-buy sp_testimonial-mt-40" href="https://shapedplugin.com/real-testimonials/?ref=1" target="_blank">Buy Real Testimonials Pro Now!</a>
							<span>No Question Asked. 14 Days Money-back Guarantee!</span>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Buy Section End -->
		</div>
		<?php
	}

	/**
	 * Help Page Callback
	 */
	public function help_page_callback() {
		wp_enqueue_style( 'testimonial-free-admin-help', SP_TFREE_URL . 'Admin/assets/css/help-page.min.css', array(), SP_TFREE_VERSION );
		$add_new_testimoinial_link = admin_url( 'post-new.php?post_type=spt_testimonial' );
		?>

<div class="sp_testimonial-main-wrapper">
		<!-- Header section start -->
		<section class="tf-help header">
			<div class="header-area">
				<div class="container">
					<div class="header-logo">
						<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/testimonial-logo-2.svg' ); ?>" alt="">
						<span><?php echo esc_html( SP_TFREE_VERSION ); ?></span>
					</div>
					<div class="header-content">

						<p>Thank you for installing Real Testimonials plugin! This video will help you get started with the plugin.</p>
					</div>
				</div>
			</div>
			<div class="video-area">
				<iframe width="560" height="315" src="https://www.youtube.com/embed/videoseries?list=PLoUb-7uG-5jPTDu5wiWwKhJNuWFWSyA5T" frameborder="0" allowfullscreen=""></iframe>
			</div>
			<div class="content-area">
				<div class="container">
					<p><b>Real Testimonials</b> makes it easy to manage and display testimonials in WordPress. <br>
						You can watch the video tutorial or read our guide on how you manage and display testimonials easily.</p>
					<div class="content-button">
						<a href="<?php echo esc_url( $add_new_testimoinial_link ); ?>">Start Adding Testimonials </a>
						<a href="https://docs.shapedplugin.com/docs/testimonial/overview/" target="_blank">Read Documentation</a>
					</div>
				</div>
			</div>
		</section>
		<!-- Header section end -->

		<!-- Upgrade section start -->
		<section class="tf-help upgrade">
			<div class="upgrade-area">
				<h2>Upgrade To Real Testimonials Pro</h2>
				<p>Easily collect and display testimonials on your website and boost conversions.</p>
				<div class="upgrade-img"><img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/header-img.svg' ); ?>" alt=""></div>
			</div>
			<div class="upgrade-info">
				<div class="container">
					<div class="row">
						<div class="col-lg-6">
							<ul class="upgrade-list">
								<li><img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/checkmark.svg' ); ?>" alt="">
								5+ Beautiful Testimonial Layouts.
								</li>
								<li><img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/checkmark.svg' ); ?>" alt="">
								10+ Customizable & Professionally Designed Themes.</li>
								<li><img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/checkmark.svg' ); ?>" alt="">
								Advanced Shortcode Generator with Query options.</li>
								<li><img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/checkmark.svg' ); ?>" alt="">Thumbnail Testimonials Slider.</li>
								<li><img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/checkmark.svg' ); ?>" alt=""> Advanced Typography and Styling options.</li>
								<li><img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/checkmark.svg' ); ?>" alt=""> Display Group or Specific Testimonials.</li>
								<li><img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/checkmark.svg' ); ?>" alt=""> Isotope Filtering Testimonials by Categories.</li>
								<li><img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/checkmark.svg' ); ?>" alt="">
								Video Testimonials for lightbox functionality.</li>
								<li><img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/checkmark.svg' ); ?>" alt="">Create Multiple Testimonial Submission Forms.</li>
								<li><img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/checkmark.svg' ); ?>" alt="">
								Drag & drop Testimonial Form Builder.</li>
								<li><img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/checkmark.svg' ); ?>" alt=""> Testimonial Pending in Dashboard for approval.</li>
								<li><img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/checkmark.svg' ); ?>" alt=""> Site Admin can manage the Testimonials before publishing.</li>
							</ul>
						</div>
						<div class="col-lg-6">
							<ul class="upgrade-list">
								<li>
									<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/checkmark.svg' ); ?>" alt="">
									Testimonial Form Spam Protection with Google reCAPTCHA.
								</li>
								<li>
									<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/checkmark.svg' ); ?>" alt="">
									Multiple Testimonial Rows in the Carousel.
								</li>
								<li>
									<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/checkmark.svg' ); ?>" alt="">
									Rich Snippets/Structured Data compatible (Schema Markup).
								</li>
								<li>
									<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/checkmark.svg' ); ?>" alt="">
									Ajax Pagination (Number, Load More, & Infinite Scroll).
								</li>
								<li>
									<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/checkmark.svg' ); ?>" alt="">
									14 Display (Reviewer Information) Options.
								</li>
								<li>
									<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/checkmark.svg' ); ?>" alt="">
									Read More & Characters Limit.
								</li>
								<li>
									<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/checkmark.svg' ); ?>" alt="">
									Read More Action Type (Expand/PopUp).
								</li>
								<li>
									<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/checkmark.svg' ); ?>" alt="">
									20+ Slider Control Options.
								</li>
								<li>
									<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/checkmark.svg' ); ?>" alt="">
									Fully Translation ready with WPML, Polylang and more.
								</li>
								<li>
									<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/checkmark.svg' ); ?>" alt="">
									Built-in Automatic Updates.</li>
								<li>
									<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/checkmark.svg' ); ?>" alt="">
									One To One Fast & Friendly Support.
								</li>
								<li>
									<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/checkmark.svg' ); ?>" alt=""><span>
									Not Happy? 100% No Questions Asked <a href="https://shapedplugin.com/refund-policy/" target="_blank">Refund Policy!</a></span>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="upgrade-pro">
					<div class="pro-content">
						<div class="pro-icon">
							<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/Testimonial-icon.svg' ); ?>" alt="">
						</div>
						<div class="pro-text">
							<h2>Real Testimonials Pro</h2>
							<p>Grow Your Business with Real Customer Feedback</p>
						</div>
					</div>
					<div class="pro-btn">
						<a href="https://shapedplugin.com/real-testimonials/?ref=1" target="_blank">Upgrade To Pro Now</a>
					</div>
				</div>
			</div>
		</section>
		<!-- Upgrade section end -->

		<!-- Real Testimonials section start -->
		<section class="tf-help testimonial">
			<div class="row">
				<div class="col-lg-6">
					<div class="testimonial-area">
						<div class="testimonial-content">
							<p>We have the plugin pro version in use on two project sites in various setups and pages and I can only say it is a superb plugin and really easy to setup with so many options to display testimonials. </p>
						</div>
						<div class="testimonial-info">
							<div class="img">
								<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/sirpa.png' ); ?>" alt="">
							</div>
							<div class="info">
								<h3>Sirpa</h3>
								<div class="star">
								<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="testimonial-area">
						<div class="testimonial-content">
							<p>This by far is the best testimonial plugin. Go for the pro version as it gives you all the different testimonial styles that you can think of. Very easy to use with lots of setting options for fonts, layouts and etc.</p>
						</div>
						<div class="testimonial-info">
							<div class="img">
								<img src="<?php echo esc_url( SP_TFREE_URL . 'Admin/assets/images/ali_senejani.png' ); ?>" alt="">
							</div>
							<div class="info">
								<h3>Ali Senejani</h3>
								<div class="star">
								<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Real Testimonials section end -->

</div>
		<?php
	}


}
