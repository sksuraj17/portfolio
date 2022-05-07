<?php
/**
 * Define custom fields for widgets
 * 
 * @package Arrival
 */

function arrival_widgets_show_widget_field( $instance = '', $widget_field = '', $athm_field_value = '' ) {
    
    extract( $widget_field );

    switch ( $arrival_widgets_field_type ) {

        // Standard text field
        case 'text' :
        ?>
            <p class="field" >
                <label class="wtitle" for="<?php echo esc_attr( $instance->get_field_id( $arrival_widgets_name ) ); ?>"><?php echo esc_html( $arrival_widgets_title ); ?>:</label>
                <input class="widefat" id="<?php echo esc_attr( $instance->get_field_id( $arrival_widgets_name ) ); ?>" name="<?php echo esc_attr( $instance->get_field_name( $arrival_widgets_name ) ); ?>" type="text" value="<?php echo esc_attr( $athm_field_value ); ?>" />

                <?php if ( isset( $arrival_widgets_description ) ) { ?>
                    <br />
                    <small><?php echo esc_html( $arrival_widgets_description ); ?></small>
                <?php } ?>
            </p>
        <?php
            break;

        case 'wrapper_start' :
        ?>
           <div class="widget-field-wrapper" style="background: #f1f1f1; padding: 30px; margin-top: 10px;">
        <?php
            break;


        case 'wrapper_end' :
        ?>
          </div>
        <?php
            break;

        // Standard url field
        case 'url' :
        ?>
            <p class="field" >
                <label class="wtitle" for="<?php echo esc_attr( $instance->get_field_id( $arrival_widgets_name ) ); ?>"><?php echo esc_html( $arrival_widgets_title ); ?>:</label>
                <input class="widefat" id="<?php echo esc_attr( $instance->get_field_id( $arrival_widgets_name ) ); ?>" name="<?php echo esc_attr( $instance->get_field_name( $arrival_widgets_name ) ); ?>" type="text" value="<?php echo esc_attr( $athm_field_value ); ?>" />

                <?php if ( isset( $arrival_widgets_description ) ) { ?>
                    <br />
                    <small><?php echo esc_html( $arrival_widgets_description ); ?></small>
                <?php } ?>
            </p>
        <?php
            break;

        // Select field
        case 'select' :
            if( empty( $athm_field_value ) ) {
                $athm_field_value = $arrival_widgets_default;
            }
        ?>
            <p class="field">
                <label class="wtitle" for="<?php echo esc_attr( $instance->get_field_id( $arrival_widgets_name ) ); ?>"><?php echo esc_html( $arrival_widgets_title ); ?>:</label>
                <select name="<?php echo esc_attr( $instance->get_field_name( $arrival_widgets_name ) ); ?>" id="<?php echo esc_attr( $instance->get_field_id( $arrival_widgets_name ) ); ?>" class="widefat selectopt">
                    <?php foreach ( $arrival_widgets_field_options as $athm_option_name => $athm_option_title ) { ?>
                        <option value="<?php echo esc_attr($athm_option_name); ?>" id="<?php echo esc_attr( $instance->get_field_id($athm_option_name ) ); ?>" <?php selected( $athm_option_name, $athm_field_value ); ?>><?php echo esc_html( $athm_option_title ); ?></option>
                    <?php } ?>
                </select>

                <?php if ( isset( $arrival_widgets_description ) ) { ?>
                    <br />
                    <small><?php echo esc_html( $arrival_widgets_description ); ?></small>
                <?php } ?>
            </p>
        <?php
            break;

       
         // Checkbox field
        case 'checkbox' :
        ?>
            <div class="control-checkbox" style="background: #f1f1f1; padding: 30px; margin-top: 10px;">
                <input id="<?php echo esc_attr( $instance->get_field_id( $arrival_widgets_name ) ); ?>" name="<?php echo esc_attr( $instance->get_field_name( $arrival_widgets_name ) ); ?>" type="checkbox" value="1" <?php checked('1', $athm_field_value); ?>/>
                <label for="<?php echo esc_attr( $instance->get_field_id( $arrival_widgets_name ) ); ?>"><?php echo esc_html( $arrival_widgets_title ); ?></label>

                <?php if ( isset( $arrival_widgets_description ) ) { ?>
                    <br />
                    <small><?php echo esc_html( $arrival_widgets_description ); ?></small>
                <?php } ?>
            </div>
        <?php
            break;

        case 'section_wrapper_start':
        ?>
            
            <div id="<?php echo esc_attr( $instance->get_field_name( $arrival_widgets_name ) );?>" class="section-wrapper" >
        <?php
            break;

        case 'section_wrapper_end':
        ?>
            </div>
        <?php
            break;

    }
}

function arrival_widgets_updated_field_value( $widget_field, $new_field_value ) {
    extract( $widget_field );

 if ( $arrival_widgets_field_type == 'url' ) {
        return esc_url( $new_field_value );
    } else {
        return strip_tags( $new_field_value );
    }
}