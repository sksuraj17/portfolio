<?php
/**
 * Contact Info widget
 *
 * @package Arrival
 */
/**
 * Adds contact info widget.
 */
 if(!function_exists('arrival_register_info_widget')){
add_action('widgets_init', 'arrival_register_info_widget');

function arrival_register_info_widget() {
    register_widget('Arrival_Info');
}
}
if(!class_exists('Arrival_Info')){
class Arrival_Info extends WP_Widget {
    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
                'arrival_info', esc_html__('*Arrival Header Info','arrival'), array(
                'description' => esc_html__('A widget that shows contact information', 'arrival')
                )
        );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {
        $fields = array(
            // This widget has no title
            // Other fields
            'site_logo' => array(
                'arrival_widgets_name' => 'site_logo',
                'arrival_widgets_title' => esc_html__('Display Site Logo ?', 'arrival'),
                'arrival_widgets_description' => esc_html__('Check the box to display site logo.', 'arrival'),
                'arrival_widgets_field_type' => 'checkbox',
            ),

          
            'phone_wrap_start' => array(
                'arrival_widgets_name' => 'phone_wrap_start',
                'arrival_widgets_field_type' => 'wrapper_start',
            ),
            'phone_text' => array(
                'arrival_widgets_name' => 'phone_text',
                'arrival_widgets_title' => esc_html__('Phone Title', 'arrival'),
                'arrival_widgets_field_type' => 'text',
            ),
            'phone' => array(
                'arrival_widgets_name' => 'phone',
                'arrival_widgets_title' => esc_html__('Phone No.', 'arrival'),
                'arrival_widgets_field_type' => 'text',
            ),
            'phone_wrap_end' => array(
                'arrival_widgets_name' => 'phone_wrap_end',
                'arrival_widgets_field_type' => 'wrapper_end',
            ),


            'email_wrap_start' => array(
                'arrival_widgets_name' => 'email_wrap_start',
                'arrival_widgets_field_type' => 'wrapper_start',
            ),
            'email_text' => array(
                'arrival_widgets_name' => 'email_text',
                'arrival_widgets_title' => esc_html__('Email Title', 'arrival'),
                'arrival_widgets_field_type' => 'text',
            ),
            'email' => array(
                'arrival_widgets_name' => 'email',
                'arrival_widgets_title' => esc_html__('Email', 'arrival'),
                'arrival_widgets_field_type' => 'text',
            ),
            'email_wrap_end' => array(
                'arrival_widgets_name' => 'email_wrap_end',
                'arrival_widgets_field_type' => 'wrapper_end',
            ),


            'location_wrap_start' => array(
                'arrival_widgets_name' => 'location_wrap_start',
                'arrival_widgets_field_type' => 'wrapper_start',
            ),
            'location_text' => array(
                'arrival_widgets_name' => 'location_text',
                'arrival_widgets_title' => esc_html__('Location Title', 'arrival'),
                'arrival_widgets_field_type' => 'text',
            ),
            'location' => array(
                'arrival_widgets_name' => 'location',
                'arrival_widgets_title' => esc_html__('Location', 'arrival'),
                'arrival_widgets_field_type' => 'text',
            ),
            'location_wrap_end' => array(
                'arrival_widgets_name' => 'location_wrap_end',
                'arrival_widgets_field_type' => 'wrapper_end',
            ),
            
        );

        return $fields;
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
        extract($args);
        echo wp_kses_post( $args['before_widget'] );
       
        if($instance){
            $site_logo          = isset($instance['site_logo']) ? $instance['site_logo'] : false;
            $site_logo_link     = !empty($instance['site_logo_link']) ? $instance['site_logo_link']: '';
            $location           = !empty($instance['location']) ? $instance['location'] : '';
            $phone              = !empty($instance['phone']) ? $instance['phone'] : '';
            $email              = !empty($instance['email']) ? $instance['email'] : '';
            $phone_text         = !empty($instance['phone_text']) ? $instance['phone_text'] : '';
            $email_text         = !empty($instance['email_text']) ? $instance['email_text'] : '';
            $location_text      = !empty($instance['location_text']) ? $instance['location_text'] : '';

            $single_logo_class = '';
            if( empty($phone && $email && $location) ){
                $single_logo_class = 'logo-only';
            }


            ?>
                <div class="contact-info-wrapp <?php echo esc_attr($single_logo_class);?>">
                    <div class="container clearfix">
                    <?php if( $site_logo ){ ?>
                        <div class="site-branding">
                            <?php the_custom_logo(); ?>
                            <?php if ( is_front_page() && is_home() ) : ?>
                                <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                            <?php else : ?>
                                <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                            <?php endif; ?>

                            <?php $arrival_description = get_bloginfo( 'description', 'display' ); ?>
                            <?php if ( $arrival_description || is_customize_preview() ) : ?>
                                <p class="site-description"><?php echo wp_kses_post($arrival_description); /* WPCS: xss ok. */ ?></p>
                            <?php endif; ?>
                        </div><!-- .site-branding -->
                            
                    <?php } ?>
                    <?php if( $phone || $email || $location ): ?>
                        <div class="info-wrap clearfix">

                             <?php if($phone){ ?>
                                <div class="phone-info contact-info">
                                    <div class="icon-wrap"><i class="ion-ios-telephone-outline" aria-hidden="true"></i></div>
                                    <div class="text-wrapper">
                                        <div class="title-text"><?php echo esc_html($phone_text); ?></div>
                                        <div class="phone contact-vfy"><?php echo esc_html($phone); ?></div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if($email){ ?>
                                <div class="email-info contact-info">
                                    <div class="icon-wrap"><i class="ion-ios-email-outline" aria-hidden="true"></i></div>
                                    <div class="text-wrapper">
                                        <div class="title-text"><?php echo esc_html($email_text); ?></div>
                                        <div class="email contact-vfy"><?php echo esc_html($email); ?></div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if($location){ ?>
                                <div class="location-info contact-info">
                                    <div class="icon-wrap"><i class="ion-ios-location-outline" aria-hidden="true"></i></div>
                                    <div class="text-wrapper">
                                        <div class="title-text"><?php echo esc_html($location_text); ?></div>
                                        <div class="location contact-vfy"><?php echo esc_html($location); ?></div>
                                    </div>
                                </div>
                            <?php } ?>
                           
                            
                        </div>
                    <?php endif; ?>

                    </div>
                </div>
        <?php
        }
        echo wp_kses_post($after_widget);
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param	array	$new_instance	Values just sent to be saved.
     * @param	array	$old_instance	Previously saved values from database.
     *
     * @uses	arrival_widgets_updated_field_value()		defined in widget-fields.php
     *
     * @return	array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ($widget_fields as $widget_field) {

            extract($widget_field);

            // Use helper function to get updated field values
            $instance[$arrival_widgets_name] = arrival_widgets_updated_field_value($widget_field, $new_instance[$arrival_widgets_name]);
        }

        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param	array $instance Previously saved values from database.
     *
     * @uses	arrival_widgets_show_widget_field()		defined in widget-fields.php
     */
    public function form($instance) {
        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ($widget_fields as $widget_field) {

            // Make array elements available as variables
            extract($widget_field);
            $arrival_widgets_field_value = !empty($instance[$arrival_widgets_name]) ? esc_attr($instance[$arrival_widgets_name]) : '';
            arrival_widgets_show_widget_field($this, $widget_field, $arrival_widgets_field_value);
        }
    }

}
}