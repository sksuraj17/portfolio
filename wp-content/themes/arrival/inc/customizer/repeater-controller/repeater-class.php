<?php
/**
* arrival customizer repeater class
*
*
* @package arrival
*/

if( class_exists('WP_Customize_Control')):

        
    /**
     * Repeater Custom Control
    */
    class Arrival_Repeater_Controler extends WP_Customize_Control {
    	/**
    	 * The control type.
    	 *
    	 * @access public
    	 * @var string
    	*/
       

        
    	public $type = 'repeater';

    	public $arrival_box_label = '';

    	public $arrival_box_add_control = '';

    	private $cats = '';
        
        private $pages = '';
        
        private $pags = '';
    	/**
    	 * The fields that each container row will contain.
    	 *
    	 * @access public
    	 * @var array
    	 */
    	public $fields = array();

    	/**
    	 * Repeater drag and drop controler
    	 *
    	 * @since  1.0.0
    	 */
    	public function __construct( $manager, $id, $args = array(), $fields = array() ) {
    		$this->fields = $fields;
    		$this->arrival_box_label = $args['arrival_box_label'] ;
    		$this->arrival_box_add_control = $args['arrival_box_add_control'];
    		$this->cats       = get_categories(array( 'hide_empty' => false ));
            $this->pages      = get_pages(array('post_type' => 'page'));
            
    		parent::__construct( $manager, $id, $args );
    	}

    	public function render_content() {

    		$values = json_decode($this->value());
    		if( $this->section == 'arrival_social_icons_section' ){
    		?>
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
       		<?php } ?>

    		<ul class="operation-repeater-field-control-wrap">
    			<?php
    			$this->arrival_get_fields();
    			?>
    		</ul>

    		<input type="hidden" <?php esc_attr( $this->link() ); ?> class="operation-repeater-collector" value="<?php echo esc_attr( $this->value() ); ?>" />
    		<button type="button" class="button operation-add-control-field"><?php echo esc_html( $this->arrival_box_add_control ); ?></button>
    		<?php
    	}

    	private function arrival_get_fields(){
    		$fields = $this->fields;
    		$values = json_decode($this->value());

    		if(is_array($values)){
    		foreach($values as $value){
    		?>
    		<li class="operation-repeater-field-control">
    		<h3 class="operation-repeater-field-title">
    			<?php echo esc_html( $this->arrival_box_label ); ?>
    			<span class="field-value">
    			<?php if( isset($values[0]->social_icons) ){ 
    				echo arrival_get_social_icon_svg($value->social_icons,19);
    			} ?>
    			</span>
    		</h3>
    		
    		<div class="operation-repeater-fields">
    		<?php
    			foreach ($fields as $key => $field) {
    			$class = isset($field['class']) ? $field['class'] : '';
    			?>
    			<div class="operation-fields operation-type-<?php echo esc_attr($field['type']).' '.esc_attr($class); ?>">
	    			<?php 
	    				$label = isset($field['label']) ? $field['label'] : '';
	    				$description = isset($field['description']) ? $field['description'] : '';
	    				$desc_class = '';
	    				if( $description ){
	    					$desc_class = 'has-desc';
	    				}
	    				if($field['type'] != 'checkbox'){ ?>
	    					<span class="customize-control-fields <?php echo esc_attr($desc_class);?>"><?php echo esc_html( $label ); ?></span>
	    					<span class="description customize-control-description"><?php echo wp_kses_post( $description ); ?></span>
	    				<?php 
	    				}

	    				$new_value = isset($value->$key) ? $value->$key : '';
	    				$default = isset($field['default']) ? $field['default'] : '';

	    				switch ($field['type']) {
	    					case 'text':
	    						echo '<input data-default="'.esc_attr($default).'" data-name="'.esc_attr($key).'" type="text" value="'.esc_attr($new_value).'"/>';
	    						break;
                                
                            case 'number':
	    						echo '<input data-default="'.esc_attr($default).'" data-name="'.esc_attr($key).'" type="number" value="'.esc_attr($new_value).'"/>';
	    						break;
                                
                            case 'url':
	    						echo '<input data-default="'.esc_attr($default).'" data-name="'.esc_attr($key).'" type="url" value="'.esc_url($new_value).'"/>';
	    						break;    
                                
	    					case 'textarea':
	    						echo '<textarea data-default="'.esc_attr($default).'"  data-name="'.esc_attr($key).'">'.esc_textarea($new_value).'</textarea>';
	    						break;

	    					case 'upload':
	    						$image = $image_class= "";
	    						if($new_value){	
	    							$image = '<img src="'.esc_url($new_value).'" style="max-width:100%;"/>';	
	    							$image_class = ' hidden';
	    						}
	    						echo '<div class="operation-fields-wrap">';
	    						echo '<div class="attachment-media-view">';
	    						echo '<div class="placeholder'.esc_attr($image_class).'">';
	    						esc_html_e('No image selected', 'arrival');
	    						echo '</div>';
	    						echo '<div class="thumbnail thumbnail-image">';
	    						echo $image;//sanitization already done
	    						echo '</div>';
	    						echo '<div class="actions clearfix">';
	    						echo '<button type="button" class="button operation-delete-button align-left">'.esc_html__('Remove', 'arrival').'</button>';
	    						echo '<button type="button" class="button operation-upload-button alignright">'.esc_html__('Select Image', 'arrival').'</button>';
	    						echo '<input data-default="'.esc_attr($default).'" class="upload-id" data-name="'.esc_attr($key).'" type="hidden" value="'.esc_attr($new_value).'"/>';
	    						echo '</div>';
	    						echo '</div>';
	    						echo '</div>';							
	    						break;

	    					case 'category':
	    						echo '<select data-default="'.esc_attr($default).'"  data-name="'.esc_attr($key).'">';
	    						echo '<option value="0">'.esc_html__('Select Category', 'arrival').'</option>';
	    						echo '<option value="-1">'.esc_html__('Latest Posts', 'arrival').'</option>';
	                                foreach ( $this->cats as $cat )
	                                {
	                                    printf('<option value="%s" %s>%s</option>', esc_attr($cat->term_id), selected($new_value, $cat->term_id, false), esc_html($cat->name));
	                                }
	                      		echo '</select>';
	    						break;

	    					case 'select':
	    						$options = $field['options'];
	    						echo '<select  data-default="'.esc_attr($default).'"  data-name="'.esc_attr($key).'">';
	                                foreach ( $options as $option => $val )
	                                {
	                                    printf('<option value="%s" %s>%s</option>', esc_attr($option), selected($new_value, $option, false), esc_html($val));
	                                }
	                      		echo '</select>';
	    						break;

	    					case 'checkbox':
	    						echo '<label>';
	    						echo '<input data-default="'.esc_attr($default).'" value="'.esc_attr($new_value).'" data-name="'.esc_attr($key).'" type="checkbox" '.checked($new_value, 'yes', false).'/>';
	    						echo esc_html( $label );
	    						echo '<span class="description customize-control-description">'.esc_html( $description ).'</span>';
	    						echo '</label>';
	    						break;
	    					
	    					case 'colorpicker':
	    						echo '<input data-default="'.esc_attr($default).'" class="operation-color-picker" data-alpha="true" data-name="'.esc_attr($key).'" type="text" value="'.esc_attr($new_value).'"/>';
	    						break;
                            
                            case 'page':
                                echo '<select data-default="'.esc_attr($default).'"  data-name="'.esc_attr($key).'">';
	    						echo '<option value="0">'.esc_html__('Select Page', 'arrival').'</option>';
	                                foreach ( $this->pages as $page )
	                                {
	                                    printf('<option value="%s" %s>%s</option>', esc_attr($page->ID), selected($new_value, $page->ID, false), esc_html($page->post_title));
	                                }
	                      		echo '</select>';
	    						break;
                                
                        
                                
	    					case 'selector':
	    						$options = $field['options'];
	    						echo '<div class="selector-labels">';
	    						foreach ( $options as $option => $val ){
	    							$class = ( $new_value == $option ) ? 'selector-selected': '';
	    							echo '<label class="'.esc_attr($class).'" data-val="'.esc_attr($option).'">';
	    							echo '<img src="'.esc_url($val).'"/>';
	    							echo '</label>'; 
	    						}
	    						echo '</div>';
	    						echo '<input data-default="'.esc_attr($default).'" type="hidden" value="'.esc_attr($new_value).'" data-name="'.esc_attr($key).'"/>';
	    						break;

	    					case 'radio':
	    						$options = $field['options'];
	    						echo '<div class="radio-labels">';
	    						foreach ( $options as $option => $val ){
	    							echo '<label>';
	    							echo '<input value="'.esc_attr($option).'" type="radio" '.checked($new_value, $option, false).'/>';
	    							echo wp_kses_post($val);
	    							echo '</label>'; 
	    						}
	    						echo '</div>';
	    						echo '<input data-default="'.esc_attr($default).'" type="hidden" value="'.esc_attr($new_value).'" data-name="'.esc_attr($key).'"/>';
	    						break;

	    					case 'switch':
	    						$switch = $field['switch'];
	    						$switch_class = ($new_value == 'on') ? 'switch-on' : '';
	    						echo '<div class="onoffswitch '.esc_attr($switch_class).'">';
	    	                        echo '<div class="onoffswitch-inner">';
	    	                            echo '<div class="onoffswitch-active">';
	    	                                echo '<div class="onoffswitch-switch">'.esc_html($switch["on"]).'</div>';
	    	                            echo '</div>';
	    	                            echo '<div class="onoffswitch-inactive">';
	    	                                echo '<div class="onoffswitch-switch">'.esc_html($switch["off"]).'</div>';
	    	                            echo '</div>';
	    	                        echo '</div>';
	    		                echo '</div>';
	    		                echo '<input data-default="'.esc_attr($default).'" type="hidden" value="'.esc_attr($new_value).'" data-name="'.esc_attr($key).'"/>';
	    						break;

	    					case 'range':
	    						$options = $field['options'];
	    						$new_value = $new_value ? $new_value : $options['val'];
	    						echo '<div class="operation-range-slider" >';
	    						echo '<div class="range-input" data-defaultvalue="'. esc_attr($options['val']) .'" data-value="' . esc_attr($new_value) . '" data-min="' . esc_attr($options['min']) . '" data-max="' . esc_attr($options['max']) . '" data-step="' . esc_attr($options['step']) . '"></div>';
	    						echo '<input  class="range-input-selector" type="text" value="'.esc_attr($new_value).'"  data-name="'.esc_attr($key).'"/>';
	    						echo '<span class="unit">' . esc_html($options['unit']) . '</span>';
	    						echo '</div>';
	    						break;

	    					case 'icon':
	    						echo '<div class="operation-selected-icon">';
	    						echo '<i class="'.esc_attr($new_value).'"></i>';
	    						echo '<span><i class="dashicons dashicons-arrow-down-alt2"></i></span>';
	    						echo '</div>';
	    						echo '<ul class="operation-icon-list clearfix">';
	    						$arrival_icons_array = arrival_icons_array();
	    						foreach ($arrival_icons_array as $arrival_font_awesome_icon) {
	    							$icon_class = $new_value == $arrival_font_awesome_icon ? 'icon-active' : '';
	    							echo '<li class='.esc_attr($icon_class).'><i class="fa '.esc_attr($arrival_font_awesome_icon).'"></i></li>';
	    						}
	    						echo '</ul>';
	    						echo '<input data-default="'.esc_attr($default).'" type="hidden" value="'.esc_attr($new_value).'" data-name="'.esc_attr($key).'"/>';
	    						break;

	    					case 'social_icon':
	    						echo '<div class="operation-selected-icon clr">';
	    						echo '<span class="icon-preview '.esc_attr($new_value).'">'.arrival_get_social_icon_svg($new_value,19).'</span>';
	    						echo '<span><i class="dashicons dashicons-arrow-down-alt2"></i></span>';
	    						echo '</div>';
	    						echo '<ul class="operation-icon-list clearfix">';
	    						$arrival_icons_array = Arrival_SVG_Icons::$social_icons;
	    						foreach ($arrival_icons_array as $index => $arrival_icons ) {

	    							$new_value == $index;
	    							echo '<li  data-value="'.$index.'">'. arrival_get_social_icon_svg($index,19).'</li>';

	    						}
	    						echo '</ul>';
	    						echo '<input data-default="'.esc_attr($default).'" type="hidden" value="'.esc_attr($new_value).'" data-name="'.esc_attr($key).'"/>';
	    						break;	

	    					case 'multicategory':
	    						$new_value_array = !is_array( $new_value ) ? explode( ',', $new_value ) : $new_value;
	    						echo '<ul class="operation-multi-category-list">';
	    						echo '<li><label><input type="checkbox" value="-1" '. checked('-1', $new_value, false ) .'/>'.esc_html__( 'Latest Posts', 'arrival' ).'</label></li>';
	    						foreach ( $this->cats as $cat ){
	    							$checked = in_array( $cat->term_id, $new_value_array) ? 'checked="checked"' : '';
	    							echo '<li>';
	    							echo '<label>';
	    	                        echo '<input type="checkbox" value="'.esc_attr($cat->term_id).'" '. esc_attr($checked) .'/>'; 
	    	                        echo esc_html( $cat->name );
	    	                    	echo '</label>';
	    							echo '</li>';
	    						}
	    						echo '</ul>';
	    						echo '<input data-default="'.esc_attr($default).'" type="hidden" value="'.esc_attr(implode( ',', $new_value_array )).'" data-name="'.esc_attr($key).'"/>';
	    						break;

	    					default:
	    						break;
	    				}
	    			?>
    			</div>
    			<?php
    			} ?>

    			<div class="clr operation-repeater-footer">
    				<div class="alignright">
    				<a class="operation-repeater-field-remove" href="#remove">
    					<i class="dashicons dashicons-trash" aria-hidden="true"></i>
    					<?php esc_html_e('Delete', 'arrival') ?>
    				</a>
    				<a class="operation-repeater-field-close" href="#close">
    					<i class="dashicons dashicons-arrow-up-alt2" aria-hidden="true"></i>
    					<?php esc_html_e('Close', 'arrival') ?>
    				</a>
    				</div>
    			</div>
    		</div>
    		</li>
    		<?php	
    		}
    		}
    	}

    }

endif;