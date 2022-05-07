<?php

if ( ! class_exists( 'TSScWidget' ) ):

	class TSScWidget extends WP_Widget {
		/**
		 * TLP TEAM widget setup
		 */
		function __construct() {
			$widget_ops = array(
				'classname'   => 'widget_rt_tss_owl_carousel',
				'description' => esc_html__( 'Display Testimonial', 'testimonial-slider-showcase' )
			);
			parent::__construct( 'widget_tlp_port_owl_carousel', esc_html__( 'Testimonial Slider And Showcase', 'testimonial-slider-showcase' ),
				$widget_ops );
		}

		/**
		 * display the widgets on the screen.
		 */
		function widget( $args, $instance ) {
			extract( $args );
			$id = ( ! empty( $instance['id'] ) ? absint( $instance['id'] ) : null );

			echo $before_widget;
			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title',
						( isset( $instance['title'] ) ? esc_html( $instance['title'] ) : "Testimonials" ) ) . $args['after_title'];
			}
			if(!empty($id)){
				echo do_shortcode("[rt-testimonial id='{$id}' ]");
			}
			echo $after_widget;
		}

		function form( $instance ) {

			$scList   = TSSPro()->get_shortCode_list();
			$defaults = array(
				'title' => "Testimonials",
				'id' => null
			);
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:',
						'testimonial-slider-showcase' ); ?></label>
				<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>"
				       style="width:100%;"/></p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>"><?php _e( 'Select a shortcode',
						'testimonial-slider-showcase' ); ?></label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>"
				        name="<?php echo esc_attr( $this->get_field_name( 'id' ) ); ?>">
					<option value="">Select one</option>
					<?php
					if ( ! empty( $scList ) ) {
						foreach ( $scList as $scId => $sc ) {
							$selected = ($scId == $instance['id'] ? "selected" : null);
							echo "<option value='{$scId}' {$selected}>{$sc}</option>";
						}
					}
					?>
				</select></p>
			<?php
		}

		public function update( $new_instance, $old_instance ) {
			$instance          = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['id']    = ( ! empty( $new_instance['id'] ) ) ? absint( $new_instance['id'] ) : '';

			return $instance;
		}
	}
endif;
