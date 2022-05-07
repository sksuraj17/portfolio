<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'TSSElementorWidgets' ) ) :

	class TSSElementorWidgets {

		private static $widgets;

		public static function register() {
			self::includes();

			self::$widgets = apply_filters(
				'rttss_elementor_widgets',
				array(
					TSSElementorGridWidget::class,
					TSSElementorSliderWidget::class,
				)
			);

			if ( empty( self::$widgets ) ) {
				return;
			}

			// Registering the widgets.
			self::registerWidgets();
		}

		private static function registerWidgets() {
			foreach ( self::$widgets as $widget ) {
				$widgetsManager = \Elementor\Plugin::instance()->widgets_manager;

				$widgetsManager->register_widget_type( new $widget() );
			}
		}

		private static function includes() {
			$directories = array(
				'/elementor/elements/',
				'/elementor/elements/tabs/',
				'/elementor/elements/renders/',
				'/elementor/elements/sections/',
			);

			foreach ( $directories as $include ) {
				TSSPro()->loadClass( TSSPro()->incPath . $include );
			}
		}

		/**
		 * Register widget controls.
		 *
		 * Adds different control fields into the widget settings.
		 *
		 * @param array  $fields Control fields to add.
		 * @param object $obj Object in which controls are adding.
		 * @return void
		 *
		 * @access public
		 */
		public function tssAddElementorControls( $fields, $obj ) {
			foreach ( $fields as $field ) {
				if ( isset( $field['mode'] ) && 'section_start' === $field['mode'] ) {
					$id = $field['id'];
					unset( $field['id'] );
					unset( $field['mode'] );
					$obj->start_controls_section( $id, $field );
				} elseif ( isset( $field['mode'] ) && 'section_end' === $field['mode'] ) {
					$obj->end_controls_section();
				} elseif ( isset( $field['mode'] ) && 'tabs_start' === $field['mode'] ) {
					$id = $field['id'];
					unset( $field['id'] );
					unset( $field['mode'] );
					$obj->start_controls_tabs( $id );
				} elseif ( isset( $field['mode'] ) && 'tabs_end' === $field['mode'] ) {
					$obj->end_controls_tabs();
				} elseif ( isset( $field['mode'] ) && 'tab_start' === $field['mode'] ) {
					$id = $field['id'];
					unset( $field['id'] );
					unset( $field['mode'] );
					$obj->start_controls_tab( $id, $field );
				} elseif ( isset( $field['mode'] ) && 'tab_end' === $field['mode'] ) {
					$obj->end_controls_tab();
				} elseif ( isset( $field['mode'] ) && 'group' === $field['mode'] ) {
					$type          = $field['type'];
					$field['name'] = $field['id'];
					unset( $field['mode'] );
					unset( $field['type'] );
					unset( $field['id'] );
					$obj->add_group_control( $type, $field );
				} elseif ( isset( $field['mode'] ) && 'responsive' === $field['mode'] ) {
					$id = $field['id'];
					unset( $field['id'] );
					unset( $field['mode'] );
					$obj->add_responsive_control( $id, $field );
				} else {
					$id = $field['id'];
					unset( $field['id'] );
					$obj->add_control( $id, $field );
				}
			}
		}

		/**
		 * Register widget tabs with controls.
		 *
		 * @param array $tabs Tabs to register.
		 * @param array $controls Controls to register.
		 * @return array
		 *
		 * @access public
		 */
		public function tssInitTabs( $tabs, $controls ) {
			foreach ( $tabs as $tab ) {
				if ( method_exists( $tab, 'register' ) ) {
					$controls = array_merge( $controls, $tab::register() );
				}
			}

			return $controls;
		}

		/**
		 * Elementor Promotional section controls.
		 *
		 * @param array $fields Elementor Controls.
		 * @return array
		 *
		 * @access public
		 */
		public function tssContentPromotion( $fields ) {
			if ( ! function_exists( 'rttsp' ) ) {
				$fields[] = array(
					'mode'  => 'section_start',
					'id'    => 'tss_el_pro_alert',
					'label' => sprintf(
						'<span style="color: #f54">%s</span>',
						__( 'Go Premium for More Features', 'testimonial-slider-showcase' )
					),
					'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				);

				$fields[] = array(
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'id'   => 'tss_el_get_pro',
					'raw'  => '<div class="elementor-nerd-box"><div class="elementor-nerd-box-title" style="margin-top: 0; margin-bottom: 20px;">Unlock more possibilities</div><div class="elementor-nerd-box-message"><span class="pro-feature" style="font-size: 13px;"> Get the <a href="https://www.radiustheme.com/downloads/wp-testimonial-slider-showcase-pro-wordpress/" target="_blank" style="color: #f54">Pro version</a> for more stunning layouts and customization options.</span></div><a class="elementor-nerd-box-link elementor-button elementor-button-default elementor-button-go-pro" href="https://www.radiustheme.com/downloads/wp-testimonial-slider-showcase-pro-wordpress/" target="_blank">Get Pro</a></div>',
				);

				$fields[] = array(
					'mode' => 'section_end',
				);
			}

			return $fields;
		}
	}

endif;
