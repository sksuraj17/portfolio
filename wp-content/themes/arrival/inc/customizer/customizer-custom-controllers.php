<?php
/**
 * Theme customizer custom controller classes
 *
 *
 * @package arrival
 * @copyright Copyright (C) 2018 WPoperation
 * @license  http://www.gnu.org/licenses/gpl-2.0.html
 * @author WPoperation <https://wpoperation.com/>
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return; 
}


class Arrival_Customize_Seperator_Control extends WP_Customize_Control {
     public function render_content() { ?>
       <span class="customize-control-seperator">
           <?php echo esc_html( $this->label ); ?>
            <?php if($this->description): ?>
       			<span class="customizer-desc-wrapp">
       				<a href="javascript:void(0)">
       				<span class="dashicons dashicons-editor-help" aria-hidden="true"></span>
       				</a>
       				<span class="desc">
       				<?php echo esc_html( $this->description ); ?>
       				</span>
       			</span>  
   			<?php endif; ?>
       </span>
      
<?php     
  }     

}

class Arrival_Customize_Pro_Info extends WP_Customize_Control {
     public function render_content() { ?>
       <span class="customize-control-pro-info">
            <?php if($this->description): ?>
              <span class="desc-pro">
                <?php echo esc_html( $this->description ); ?>
                  <?php if($this->label){ ?>
                  <span><?php echo wp_kses_post( $this->label ); ?></span>
                  <?php } ?>
              </span>
        <?php endif; ?>
       </span>
      
<?php     
  }     

}

class Arrival_Customize_Redirect extends WP_Customize_Control{

   public function render_content(){

    if( empty($this->label) ){
      return;
    }
    $controller = $this->description;
    $type = 'section';
    if( !empty($this->type) ){
      $type = $this->type;
    } 
    if($this->type == 'text'){
      $type = 'section';
    }

  ?>
    <a href="javascript:wp.customize.<?php echo esc_attr($type)?>('<?php echo esc_attr($controller);?>').focus();" class="button section-redirect">
      <span><?php echo esc_html($this->label); ?></span>
    </a>
  <?php
  }
}



    /**
    * Image control by radtion button 
    */
    class Arrival_Lite_Image_Radio_Control extends WP_Customize_Control {

    public function render_content() {

      if ( empty( $this->choices ) ) {
        return;
      }

      $name = '_customize-radio-' . $this->id;

      ?>
      <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
      <ul class="controls" id="arrival-img-container">
      <?php
        foreach ( $this->choices as $value => $label ) :
          $class = ( $this->value() == $value ) ? 'arrival-radio-img-selected arrival-radio-img-img' : 'arrival-radio-img-img';
      ?>
          <li class="inc-radio-image">
            <label>
              <input <?php $this->link(); ?>style = 'display:none' type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
              <img src = '<?php echo esc_html( $label ); ?>' class = '<?php echo esc_attr( $class ); ?>' />
            </label>
          </li>
      <?php
        endforeach;
      ?>
      </ul>
      <?php
    }
  }

if( class_exists('WP_Customize_Section')){
  /**
     * Pro customizer section.
     *
     * @since  1.0.0
     * @access public
     */
    class Arrival_Customize_Section_Pro extends WP_Customize_Section {

        /**
         * The type of customize section being rendered.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $type = 'arrival';

        /**
         * Custom button text to output.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $pro_text = '';

        /**
         * Custom pro button URL.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $pro_url = '';

        /**
         * Add custom parameters to pass to the JS via JSON.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        public function json() {
            $json = parent::json();
            $json['pro_text'] = $this->pro_text;
            $json['pro_url']  = esc_url( $this->pro_url );
            return $json;
        }

        /**
         * Outputs the Underscore.js template.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        protected function render_template() { ?>

            <li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
                <h3 class="accordion-section-title">
                    {{ data.title }}
                    <# if ( data.pro_text && data.pro_url ) { #>
                        <a href="{{ data.pro_url }}" class="button button-secondary alignright" target="_blank">{{ data.pro_text }}</a>
                    <# } #>
                </h3>
            </li>
        <?php }
    }
  }
