<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Get Help
 */
?>
	<style>
		.rttss-help-wrapper {
			width: 60%;
			margin: 0 auto;
		}
		.rttss-help-section .embed-wrapper {
			position: relative;
			display: block;
			width: calc(100% - 40px);
			padding: 0;
			overflow: hidden;
		}
		.rttss-help-section .embed-wrapper::before {
			display: block;
			content: "";
			padding-top: 56.25%;
		}
		.rttss-help-section iframe {
			position: absolute;
			top: 0;
			bottom: 0;
			left: 0;
			width: 100%;
			height: 100%;
			border: 0;
		}
		.rttss-help-wrapper .rt-document-box .rt-box-title {
			margin-bottom: 30px;
		}
		.rttss-help-wrapper .rt-document-box .rt-box-icon {
			margin-top: -6px;
		}
		.rttss-help-wrapper .rttss-help-section {
			margin-top: 30px;
		}
		.rttss-feature-list ul {
			column-count: 2;
			column-gap: 30px;
			margin-bottom: 0;
		}
		.rttss-feature-list ul li {
			padding: 0 0 12px;
			margin-bottom: 0;
			width: 100%;
			font-size: 14px;
		}
		.rttss-feature-list ul li:last-child {
			padding-bottom: 0;
		}
		.rttss-feature-list ul li i {
			color: #4C6FFF;
		}
		.rttss-pro-feature-content {
			display: flex;
			flex-wrap: wrap;
		}
		.rttss-pro-feature-content .rt-document-box + .rt-document-box {
			margin-left: 30px;
		}
		.rttss-pro-feature-content .rt-document-box {
			flex: 0 0 calc(33.3333% - 60px);
			margin-top: 30px;
		}
		.rttss-testimonials {
			display: flex;
			flex-wrap: wrap;
		}
		.rttss-testimonials .rttss-testimonial + .rttss-testimonial  {
			margin-left: 30px;
		}
		.rttss-testimonials .rttss-testimonial  {
			flex: 0 0 calc(50% - 30px)
		}
		.rttss-testimonial .client-info {
			display: flex;
			flex-wrap: wrap;
			font-size: 14px;
			align-items: center;
		}
		.rttss-testimonial .client-info img {
			width: 60px;
			height: 60px;
			object-fit: cover;
			border-radius: 50%;
			margin-right: 10px;
		}
		.rttss-testimonial .client-info .rttss-star {
			color: #4C6FFF;
		}
		.rttss-testimonial .client-info .client-name {
			display: block;
			color: #000;
			font-size: 16px;
			font-weight: 600;
			margin: 8px 0 5px;
		}
		.rttss-call-to-action {
			background-size: cover;
			background-repeat: no-repeat;
			background-position: center;
			height: 150px;
			color: #ffffff;
			margin: 30px 0;
		}
		.rttss-call-to-action a {
			color: inherit;
			display: flex;
			flex-wrap: wrap;
			width: 100%;
			height: 100%;
			flex: 1;
			align-items: center;
			font-size: 28px;
			font-weight: 700;
			text-decoration: none;
			margin-left: 130px;
			position: relative;
			outline: none;
			-webkit-box-shadow: none;
			box-shadow: none;
		}
		.rttss-call-to-action a::before {
			content: "";
			position: absolute;
			left: -30px;
			top: 50%;
			height: 30%;
			width: 5px;
			background: #fff;
			-webkit-transform: translateY(-50%);
			transform: translateY(-50%);
		}
		.rttss-call-to-action:hover a {
			text-decoration: underline;
		}
		.rttss-testimonial p {
			text-align: justify;
		}
		@media all and (max-width: 1400px) {
			.rttss-help-wrapper {
				width: 80%;
			}
		}
		@media all and (max-width: 1025px) {
			.rttss-pro-feature-content .rt-document-box {
				flex: 0 0 calc(50% - 55px)
			}
			.rttss-pro-feature-content .rt-document-box + .rt-document-box + .rt-document-box {
				margin-left: 0;
			}
		}
		@media all and (max-width: 991px) {
			.rttss-help-wrapper {
				width: calc(100% - 40px);
			}
			.rttss-call-to-action a {
				justify-content: center;
				margin-left: auto;
				margin-right: auto;
				text-align: center;
			}
			.rttss-call-to-action a::before {
				content: none;
			}
		}
		@media all and (max-width: 600px) {
			.rt-document-box .rt-box-content .rt-box-title {
				line-height: 28px;
			}
			.rttss-help-section .embed-wrapper {
				width: 100%;
			}
			.rttss-feature-list ul {
				column-count: 1;
			}
			.rttss-feature-list ul li {
				width: 100%;
			}
			.rttss-call-to-action a {
				padding-left: 25px;
				padding-right: 25px;
				font-size: 20px;
				line-height: 28px;
				width: 80%;
			}
			.rttss-testimonials {
				display: block;
			}
			.rttss-testimonials .rttss-testimonial + .rttss-testimonial {
				margin-left: 0;
				margin-top: 30px;
				padding-top: 30px;
				border-top: 1px solid #ddd;
			}
			.rttss-pro-feature-content .rt-document-box {
				width: 100%;
				flex: auto;
			}
			.rttss-pro-feature-content .rt-document-box + .rt-document-box {
				margin-left: 0;
			}

			.rttss-help-wrapper .rt-document-box {
				display: block;
				position: relative;
			}

			.rttss-help-wrapper .rt-document-box .rt-box-icon {
				position: absolute;
				left: 20px;
				top: 30px;
				margin-top: 0;
			}

			.rt-document-box .rt-box-content .rt-box-title {
				margin-left: 45px;
			}
		}
	</style>
	<div class="rttss-help-wrapper" >
		<div class="rttss-help-section rt-document-box">
			<div class="rt-box-icon"><i class="dashicons dashicons-media-document"></i></div>
			<div class="rt-box-content">
				<h3 class="rt-box-title">Thank you for installing Testimonial Slider and Showcase</h3>
				<div class="embed-wrapper">
					<iframe src="https://www.youtube.com/embed/Aik0cfidl4A" title="Testimonial Slider and Showcase" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
			</div>
		</div>
		<div class="rt-document-box">
			<div class="rt-box-icon"><i class="dashicons dashicons-megaphone"></i></div>
			<div class="rt-box-content rttss-feature-list">
				<h3 class="rt-box-title">Pro Features</h3>
				<ul>
					<li><i class="dashicons dashicons-saved"></i> 30 Amazing Layouts with Grid, Slider, Isotope.</li>
					<li><i class="dashicons dashicons-saved"></i> Elementor addon for all layouts.</li>
					<li><i class="dashicons dashicons-saved"></i> Even and Masonry Grid.</li>
					<li><i class="dashicons dashicons-saved"></i> Video Layouts in Grid, Slider & Isotope.</li>
					<li><i class="dashicons dashicons-saved"></i> Layout Preview in Shortcode Settings.</li>
					<li><i class="dashicons dashicons-saved"></i> Taxonomy support (Category, Tag).</li>
					<li><i class="dashicons dashicons-saved"></i> All Text and Color control.</li>
					<li><i class="dashicons dashicons-saved"></i> Social media & social share.</li>
					<li><i class="dashicons dashicons-saved"></i> AJAX Pagination (Load more and Load on Scrolling).</li>
					<li><i class="dashicons dashicons-saved"></i> Front End Submission.</li>
					<li><i class="dashicons dashicons-saved"></i> Re-captcha on form.</li>
					<li><i class="dashicons dashicons-saved"></i> Order by Name, Id, Date, Random and Menu order.</li>
					<li><i class="dashicons dashicons-saved"></i> Custom image size control.</li>
					<li><i class="dashicons dashicons-saved"></i> Search field on Isotope.</li>
					<li><i class="dashicons dashicons-saved"></i> Responsive Display Control.</li>
					<li><i class="dashicons dashicons-saved"></i> More Features...</li>
				</ul>
			</div>
		</div>
		<div class="rttss-call-to-action" style="background-image: url('<?php echo TSSPro()->assetsUrl; ?>images/admin/banner.png')">
			<a href="https://www.radiustheme.com/downloads/wp-testimonial-slider-showcase-pro-wordpress/" target="_blank" class="rt-update-pro-btn">
				Update to Pro & Get More Features
			</a>
		</div>
		<div class="rt-document-box">
			<div class="rt-box-icon"><i class="dashicons dashicons-thumbs-up"></i></div>
			<div class="rt-box-content">
				<h3 class="rt-box-title">Happy clients of the Testimonial Slider and Showcase</h3>
				<div class="rttss-testimonials">
					<div class="rttss-testimonial">
						<p>This plugin provides all the functionality needed for professional-looking testimonials. The developer is also quick to provide support when needed and was able to answer all my questions and resovle any issues that I was having. I would recommend this plugin to anyone looking for a robust testimonial slider.</p>
						<div class="client-info">
							<img src="<?php echo TSSPro()->assetsUrl; ?>images/admin/client1.png">
							<div>
								<div class="rttss-star">
									<i class="dashicons dashicons-star-filled"></i>
									<i class="dashicons dashicons-star-filled"></i>
									<i class="dashicons dashicons-star-filled"></i>
									<i class="dashicons dashicons-star-filled"></i>
									<i class="dashicons dashicons-star-filled"></i>
								</div>
								<span class="client-name">akrsmanovic</span>
							</div>
						</div>
					</div>
					<div class="rttss-testimonial">
						<p>I've used other plugins from Radius Themes with great success and this Testimonials Slider doesn't disappoint! Easy to set up and use. I really like how it fits seamlessly with any site I want to build. Thanks again Radius for a great plugin!!</p>
						<div class="client-info">
							<img src="<?php echo TSSPro()->assetsUrl; ?>images/admin/client2.jpeg">
							<div>
								<div class="rttss-star">
									<i class="dashicons dashicons-star-filled"></i>
									<i class="dashicons dashicons-star-filled"></i>
									<i class="dashicons dashicons-star-filled"></i>
									<i class="dashicons dashicons-star-filled"></i>
									<i class="dashicons dashicons-star-filled"></i>
								</div>
								<span class="client-name">tannetoni</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="rttss-pro-feature-content">
			<div class="rt-document-box">
				<div class="rt-box-icon"><i class="dashicons dashicons-media-document"></i></div>
				<div class="rt-box-content">
					<h3 class="rt-box-title">Documentation</h3>
					<p>Get started by spending some time with the documentation we included step by step process with screenshots with video.</p>
					<a href="<?php echo esc_url( TSSPro()->documentation_link() ); ?>" target="_blank" class="rt-admin-btn">Documentation</a>
				</div>
			</div>
			<div class="rt-document-box">
				<div class="rt-box-icon"><i class="dashicons dashicons-sos"></i></div>
				<div class="rt-box-content">
					<h3 class="rt-box-title">Need Help?</h3>
					<p>Stuck with something? Please create a
						<a href="https://www.radiustheme.com/contact/">ticket here</a> or post on <a href="https://www.facebook.com/groups/234799147426640/">facebook group</a>. For emergency case join our <a href="https://www.radiustheme.com/">live chat</a>.</p>
					<a href="https://www.radiustheme.com/contact/" target="_blank" class="rt-admin-btn">Get Support</a>
				</div>
			</div>
			<div class="rt-document-box">
				<div class="rt-box-icon"><i class="dashicons dashicons-smiley"></i></div>
				<div class="rt-box-content">
					<h3 class="rt-box-title">Happy Our Work?</h3>
					<p>If you happy with <strong>Testimonial Slider and Showcase</strong> plugin, please add a rating. It would be glad to us.</p>
					<a href="https://wordpress.org/support/plugin/testimonial-slider-and-showcase/reviews/?filter=5#new-post" class="rt-admin-btn" target="_blank">Post Review</a>
				</div>
			</div>
		</div>
	</div>
<?php
