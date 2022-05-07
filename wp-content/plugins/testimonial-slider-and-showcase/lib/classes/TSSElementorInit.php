<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'TSSElementorInit' ) ) :

	class TSSElementorInit {

		public $elementorWidgets;

		public function __construct() {
			if ( did_action( 'elementor/loaded' ) ) {
				add_action( 'elementor/widgets/widgets_registered', array( $this, 'registerWidgets' ) );
			}

			add_action( 'elementor/controls/controls_registered', array( $this, 'registerControls' ) );
			add_action( 'elementor/elements/categories_registered', array( $this, 'addCategory' ) );
			add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'editorStyles' ) );
			add_filter( 'elementor/editor/localize_settings', array( $this, 'promotePremiumWidgets' ) );
		}

		public function registerWidgets() {
			$this->includes();

			TSSElementorWidgets::register();
		}

		public function registerControls() {
			$this->includes();

			TSSElementorControls::register();
		}

		public function addCategory( $elements_manager ) {
			$elements_manager->add_category(
				'tss-elementor-widgets',
				array(
					'title' => __( 'Testimonial Slider and Showcase', 'testimonial-slider-showcase' ),
					'icon'  => 'fa fa-plug',
				)
			);
		}

		public function editorStyles( $elements_manager ) {
			$img = TSSPro()->assetsUrl . '/images/element-icon.svg';
			$css = '
				.elementor-element .icon .tss-element {
					width: 50px;
					height: 50px;
				}

				.elementor-element .icon .tss-element::before {
					content: url( ' . $img . ');
					content: "";
					background-image: url(' . $img . ');
					width: 50px;
					height: 50px;
					position: absolute;
					background-repeat: no-repeat;
					background-position: center;
					background-size: 100%;
					margin-left: -25px;
					top: 20px;
				}

				.elementor-element .tss-element::after {
					background: #93003c;
					margin: 3px;
					content: "RT";
					font-family: Roboto,Arial,Helvetica,Verdana,sans-serif;
					font-size: 9px;
					position: absolute;
					top: 5px;
					left: 5px;
					padding: 4px 5px 2px;
					color: #fff;
					font-weight: bold;
				}

				.elementor-control[class*="elementor-control-tss_el"] .elementor-control-title {
					font-size: 13px;
					font-weight: 500;
				}

				.elementor-control[class*="elementor-control-tss_el"] .elementor-control-field-description {
					font-size: 13px;
				}

				.elementor-control .tss-elementor-group-heading {
					font-weight: bold;
					border-left: 4px solid #2271b1;
					padding: 10px;
					background: #f1f1f1;
					color: #495157;
				}
			';

			wp_add_inline_style( 'elementor-editor', $css );
		}

		private function includes() {
			TSSPro()->loadClass( TSSPro()->incPath . '/elementor/' );
		}

		public function promotePremiumWidgets( $config ) {

			if ( function_exists( 'rttsp' ) ) {
				return $config;
			}

			if ( ! isset( $config['promotionWidgets'] ) || ! is_array( $config['promotionWidgets'] ) ) {
				$config['promotionWidgets'] = array();
			}

			$pro_widgets = array(
				array(
					'name'       => 'rt-testimonial-isotope',
					'title'      => __( 'Isotope Layout', 'testimonial-slider-showcase' ),
					'description'      => __( 'Isotope Layout', 'testimonial-slider-showcase' ),
					'icon'       => 'eicon-testimonial-carousel tss-element tss-promotional-element',
					'categories' => '[ "tss-elementor-widgets" ]',
				),
			);

			$config['promotionWidgets'] = array_merge( $config['promotionWidgets'], $pro_widgets );

			return $config;
		}
	}

endif;
