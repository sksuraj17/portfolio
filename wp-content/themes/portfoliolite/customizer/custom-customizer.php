<?php
//Repeater Control
/**
 * Sanitize repeater control.
 *
 * @param object $value Control output.
 *
 * @return object
 */
//This is the condition for all class extends WP_Customize_Control to prevent from fatal error.
if( ! class_exists( 'WP_Customize_Control' ) ){
    return;
}
function portfoliolite_repeater_sanitize( $value ){
    $value_decoded = json_decode( $value, true );

    if ( ! empty( $value_decoded ) ) {
        foreach ( $value_decoded as $boxk => $box ){
            foreach ( $box as $key => $value ) {

                $value_decoded[ $boxk ][ $key ] = wp_kses_post( force_balance_tags( $value ) );

            }
        }

        return json_encode( $value_decoded );
    }

    return $value;
}
/**
 * Sanitization for text field
 */
function portfoliolite_sanitize_text( $string ) {
    return wp_kses_post( balanceTags( $string ) );
}
/**
 * Sanitization for textarea field
 */
function portfoliolite_sanitize_textarea( $input ) {
    global $allowedposttags;
    $output = wp_kses( $input, $allowedposttags );
    return $output;
}
/**
 * Returns a sanitized filepath if it has a valid extension.
 */
function portfoliolite_sanitize_upload( $upload ) {
    $return = '';
    $fype = wp_check_filetype( $upload );
    if ( $fype["ext"] ) {
        $return = esc_url_raw( $upload );
    }
    return $return;
}
/**
 * Checkbox sanitization callback
 *
 */
function portfoliolite_sanitize_checkbox( $checked ) {
    // Boolean check.
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
}
// radio
function portfoliolite_sanitize_radio( $input, $setting ){

  // Ensure input is a slug.
  $input = sanitize_key( $input );

  // Get list of choices from the control associated with the setting.
  $choices = $setting->manager->get_control( $setting->id )->choices;

  // If the input is a valid key, return it; otherwise, return the default.
  return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}
/**
 * Select sanitization callback
 */
function portfoliolite_sanitize_select( $input, $setting ) {
    // Ensure input is a slug.
    $input = sanitize_key( $input );
    
    // Get list of choices from the control associated with the setting.
    $choices = $setting->manager->get_control( $setting->id )->choices;
    
    // If the input is a valid key, return it; otherwise, return the default.
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}
function portfoliolite_sanitize_email( $email ) {
    // Test for the minimum length the email can be.
    if ( strlen( $email ) < 6 ) {
        /**
         * Filters a sanitized email address.
         *
         * This filter is evaluated under several contexts, including 'email_too_short',
         * 'email_no_at', 'local_invalid_chars', 'domain_period_sequence', 'domain_period_limits',
         * 'domain_no_periods', 'domain_no_valid_subs', or no context.
         *
         * @since 2.8.0
         *
         * @param string $sanitized_email The sanitized email address.
         * @param string $email           The email address, as provided to sanitize_email().
         * @param string|null $message    A message to pass to the user. null if email is sanitized.
         */
        return apply_filters( 'sanitize_email', '', $email, 'email_too_short' );
    }
 
    // Test for an @ character after the first position.
    if ( strpos( $email, '@', 1 ) === false ) {
        /** This filter is documented in wp-includes/formatting.php */
        return apply_filters( 'sanitize_email', '', $email, 'email_no_at' );
    }
 
    // Split out the local and domain parts.
    list( $local, $domain ) = explode( '@', $email, 2 );
 
    // LOCAL PART
    // Test for invalid characters.
    $local = preg_replace( '/[^a-zA-Z0-9!#$%&\'*+\/=?^_`{|}~\.-]/', '', $local );
    if ( '' === $local ) {
        /** This filter is documented in wp-includes/formatting.php */
        return apply_filters( 'sanitize_email', '', $email, 'local_invalid_chars' );
    }
 
    // DOMAIN PART
    // Test for sequences of periods.
    $domain = preg_replace( '/\.{2,}/', '', $domain );
    if ( '' === $domain ) {
        /** This filter is documented in wp-includes/formatting.php */
        return apply_filters( 'sanitize_email', '', $email, 'domain_period_sequence' );
    }
 
    // Test for leading and trailing periods and whitespace.
    $domain = trim( $domain, " \t\n\r\0\x0B." );
    if ( '' === $domain ) {
        /** This filter is documented in wp-includes/formatting.php */
        return apply_filters( 'sanitize_email', '', $email, 'domain_period_limits' );
    }
 
    // Split the domain into subs.
    $subs = explode( '.', $domain );
 
    // Assume the domain will have at least two subs.
    if ( 2 > count( $subs ) ) {
        /** This filter is documented in wp-includes/formatting.php */
        return apply_filters( 'sanitize_email', '', $email, 'domain_no_periods' );
    }
 
    // Create an array that will contain valid subs.
    $new_subs = array();
 
    // Loop through each sub.
    foreach ( $subs as $sub ) {
        // Test for leading and trailing hyphens.
        $sub = trim( $sub, " \t\n\r\0\x0B-" );
 
        // Test for invalid characters.
        $sub = preg_replace( '/[^a-z0-9-]+/i', '', $sub );
 
        // If there's anything left, add it to the valid subs.
        if ( '' !== $sub ) {
            $new_subs[] = $sub;
        }
    }
 
    // If there aren't 2 or more valid subs.
    if ( 2 > count( $new_subs ) ) {
        /** This filter is documented in wp-includes/formatting.php */
        return apply_filters( 'sanitize_email', '', $email, 'domain_no_valid_subs' );
    }
 
    // Join valid subs into the new domain.
    $domain = join( '.', $new_subs );
 
    // Put the email back together.
    $sanitized_email = $local . '@' . $domain;
 
    // Congratulations, your email made it!
    /** This filter is documented in wp-includes/formatting.php */
    return apply_filters( 'sanitize_email', $sanitized_email, $email, null );
}

function portfoliolite_sanitize_phone_number( $phone ) {
  return preg_replace( '/[^\d+]/', '', $phone );
}

/**
 * Color sanitization callback
 *
 * @since 1.2.1
 */
function portfoliolite_sanitize_color( $color ){
    if ( empty( $color ) || is_array( $color ) ){
        return '';
    }

    // If string does not start with 'rgba', then treat as hex.
    // sanitize the hex color and finally convert hex to rgba
    if ( false === strpos( $color, 'rgba' ) ) {
        return sanitize_hex_color( $color );
    }

    // By now we know the string is formatted as an rgba color so we need to further sanitize it.
    $color = str_replace( ' ', '', $color );
    sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );

    return 'rgba('.$red.','.$green.','.$blue.','.$alpha.')';
}
/**
 * vaild int.
 */
function portfoliolite_sanitize_int( $input ) {
$return = absint($input);
    return $return;
}
/**
 * Default color picker palettes
 */
if ( ! function_exists( 'portfoliolite_default_color_palettes' ) ){
    function portfoliolite_default_color_palettes() {
    $palettes = array(
            '#000000',
            '#ffffff',
            '#dd3333',
            '#dd9933',
            '#eeee22',
            '#81d742',
            '#1e73be',
            '#8224e3',
        );
        // Apply filters and return
        return apply_filters( 'portfoliolite_default_color_palettes', $palettes );
    }
}
// Multiple Checkbox Show
function portfoliolite_checkbox_explode( $values ) {
    $multi_values = !is_array( $values ) ? explode( ',', $values ) : $values;
    return !empty( $multi_values ) ? array_map( 'sanitize_text_field', $multi_values ) : array();
}
add_action('customize_register','portfoliolite_custom_customize_register');
function portfoliolite_custom_customize_register( $wp_customize ) {

/**
 * Multiple checkbox customize control class.
 */
class Portfoliolite_Customize_Control_Checkbox_Multiple extends WP_Customize_Control {
    /**
     * The type of customize control being rendered.
     */
    public $type = 'checkbox-multiple';

    /**
     * Enqueue scripts/styles.
     *
     */
    public function enqueue() {
       
    }

    /**
     * Displays the control content.
     *
     */
    public function render_content() {

        if ( empty( $this->choices ) ){
            return;   }
            ?>
        <?php if ( !empty( $this->label ) ) : ?>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
        <?php endif; ?>
        <?php if ( !empty( $this->description ) ) : ?>
            <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
        <?php endif; ?>
        <?php $multi_values = !is_array( $this->value() ) ? explode( ',', $this->value() ) : $this->value(); ?>
        <ul>
            <?php foreach ( $this->choices as $value => $label ) : ?>
                <li>
                    <label>
                        <input type="checkbox" value="<?php echo esc_attr( $value ); ?>" <?php checked( in_array( $value, $multi_values ) ); ?> /> 
                        <?php echo esc_html( $label ); ?>
                    </label>
                </li>
            <?php endforeach; ?>
        </ul>
        <input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr( implode( ',', $multi_values ) ); ?>" />
    <?php }
}

// divider
    class Portfoliolite_Misc_Control extends WP_Customize_Control{
    public $description = '';
    public $url = '';
    public $label = '';
    public $title = '';
    public function render_content() {
        switch ( $this->type ) {
            default:

            case 'heading':
                echo '<span class="customize-control-title">'.esc_html($this->title).'</span>';
                break;
            case 'custom_message' :
                echo '<p class="description">' .esc_html($this->description). '</p>';
                break;
            case 'pro-text' :
                echo '<span class="view-pro">' .esc_html($this->label). '</span><span class="pro-desc">' .esc_html($this->description). '</span>';
                break;
            case'pro-link':
                echo sprintf(
                            '<a href="%1$s" target="_blank">'.esc_html($this->label).'</a>',
                            esc_url( $this->url )
                        );
            break;
            case 'doc-link':
                echo sprintf(
                            '<p class="prt-doc-link"> %1$s  <a href="%2$s" target="_blank">%3$s</a></p>',
                            esc_html( $this->description ),
                            esc_url( $this->url ),
                            esc_html__('Doc', 'portfoliolite' )
                        );
            break;
            case 'hr' :
                echo '<hr />';
            break;
        }
     }   
}
/**
 *widget-redirect
 *
 */
class Portfoliolite_Widegt_Redirect extends WP_Customize_Control {
    /**
     * Control id
     *
     * @var string $id Control id.
     */
    public $id = '';

    /**
     * Button class.
     *
     * @var mixed|string
     */
    public $button_class = '';

    /**
     * Icon class.
     *
     * @var mixed|string
     */
    public $icon_class = '';

    /**
     * Button text.
     *
     * @var mixed|string
     */
    public $button_text = '';

    /**
     * Portfolioline_Display_Text constructor.
     *
     * @param WP_Customize_Manager $manager Customizer manager.
     * @param string               $id Control id.
     * @param array                $args Argument.
     */
    public function __construct( $manager, $id, $args = array() ) {
        parent::__construct( $manager, $id, $args );
        $this->id = $id;
        if ( ! empty( $args['button_class'] ) ) {
            $this->button_class = $args['button_class'];
        }
        if ( ! empty( $args['icon_class'] ) ) {
            $this->icon_class = $args['icon_class'];
        }
        if ( ! empty( $args['button_text'] ) ) {
            $this->button_text = $args['button_text'];
        }
    }

    /**
     * Render content for the control.
     *
     * @since Portfolioline 1.0.0
     */
    public function render_content() {
        if ( ! empty( $this->button_text ) ) {
            echo '<button type="button" class="button menu-shortcut ' . esc_attr( $this->button_class ) . '" tabindex="0">';
            if ( ! empty( $this->button_class ) ) {
                echo '<span class="dashicons dashicons-admin-generic" style="margin-right: 10px;margin-top:3PX;
    color:#999;"></span>';
            }
                echo esc_html( $this->button_text );
            echo '</button>';
        }
    }
}

// Register customizer setting
$wp_customize->register_section_type( 'Portfoliolite_WP_Customizer_Range_Value_Control' );
$wp_customize->register_section_type( 'Portfoliolite_Customizer_Color_Control' );
}
function portfoliolite_registers(){
    wp_enqueue_script( 'portfoliolite_customizer_script', get_template_directory_uri() . '/customizer/customizer.js', array("jquery"), '', true  );  
    wp_enqueue_script( 'portfoliolite_extend_customizer_script', get_template_directory_uri()  .'/customizer/extend-customizer/extend-js/extend-customizer.js', array("jquery"), '', true );  
// select font typography
    wp_enqueue_script( 'portfoliolite-select-script', get_template_directory_uri() . '/customizer/customizer-font-selector/js/select.js', array( 'jquery' ), '1.0.0', true );
    wp_enqueue_script( 'portfoliolite-typography-js', get_template_directory_uri() . '/customizer/customizer-font-selector/js/typography.js', array( 'jquery', 'portfoliolite-select-script' ), '1.0.0', true );
    //tabs
    wp_enqueue_script( 'portfoliolite-tabs-addon-script', get_template_directory_uri() .'/customizer/customizer-tabs/js/customizer-addon-script.js',array('jquery'), '1.0.0' );
    wp_enqueue_script( 'portfoliolite-tabs-control-script', get_template_directory_uri() . '/customizer/customizer-tabs/js/script.js', array( 'jquery'), '1.0.0', true );
}
function portfoliolite_customizer_styles() {
    wp_enqueue_style('portfoliolite_extend_customizer_styles', get_template_directory_uri() .'/customizer/extend-customizer/extend-css/extend-customizer.css');
    // font select typography
    wp_enqueue_style('portfoliolite-select-style', get_template_directory_uri(). '/customizer/customizer-font-selector/css/select.css', null, '1.0.0');
    wp_enqueue_style('portfoliolite-typography', get_template_directory_uri() . '/customizer/customizer-font-selector/css/typography.css', null);
    wp_enqueue_style('portfoliolite_customizer_styles', get_template_directory_uri() . '/customizer/customizer_styles.css');
    //tabs
    wp_enqueue_style( 'portfoliolite-tabs-control-style', get_template_directory_uri() .'/customizer/customizer-tabs/css/style.css', array(), '1.0.0' );
}
add_action('customize_controls_print_styles', 'portfoliolite_customizer_styles');
add_action( 'customize_controls_enqueue_scripts', 'portfoliolite_registers' );
function portfoliolite_customize_preview_js() {
    wp_enqueue_script( 'portfoliolite_live_customizer', get_template_directory_uri().'/customizer/js/live-customizer.js', array( "jquery"), '', true );
}
add_action( 'customize_preview_init', 'portfoliolite_customize_preview_js' );
// single page post meta
function portfoliolite_checkbox_filter($search,$theme_mod,$default=false){
 $filter = get_theme_mod($theme_mod);
$value = (!empty($filter) && !empty($filter[0]))?in_array($search, $filter):$default;
return $value;
}