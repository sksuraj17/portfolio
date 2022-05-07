<?php
if (!class_exists('TSSProField')):
    class TSSProField {

        private $type;
        private $name;
        private $value;
        private $default;
        private $label;
        private $class;
        private $id;
        private $holderClass;
        private $description;
        private $options;
        private $option;
        private $optionLabel;
        private $attr;
        private $multiple;
        private $alignment;
        private $placeholder;
        private $blank;
        private $required;
        private $frontEnd;

        function __construct()
        {
        }

        /**
         *
         * Initiate the predefined property for the field object
         *
         * @param $attr
         */
        private function setArgument($key, $attr)
        {
            $this->type = isset($attr['type']) ? ($attr['type'] ? esc_attr( $attr['type'] ) : 'text') : 'text';
            $this->multiple = isset($attr['multiple']) ? ($attr['multiple'] ? ( $attr['multiple'] ) : false) : false;
            $this->name = !empty($key) ? ( $key ) : null;
            $this->default = isset($attr['default']) ? ( $attr['default'] ) : null;
            $this->value = isset($attr['value']) ? ($attr['value'] ? ( $attr['value'] ) : null) : null;

            if (!$this->value) {
                $post_id = get_the_ID();
                if (!$this->meta_exist($post_id, $this->name)) {
                    $this->value = $this->default;
                } else {
                    if ($this->multiple) {
                        $this->value = get_post_meta($post_id, $this->name);
                    } else {
                        $this->value = get_post_meta($post_id, $this->name, true);
                    }
                }
            }

            $this->label = isset($attr['label']) ? ($attr['label'] ? esc_attr($attr['label']) : null) : null;
            $this->class = isset($attr['class']) ? ($attr['class'] ? esc_attr( $attr['class'] ) : null) : null;
            $this->holderClass = isset($attr['holderClass']) ? ($attr['holderClass'] ? esc_attr($attr['holderClass']) : null) : null;
            $this->placeholder = isset($attr['placeholder']) ? ($attr['placeholder'] ? esc_attr($attr['placeholder']) : null) : null;
            $this->description = isset($attr['description']) ? ($attr['description'] ? wp_kses_post( $attr['description'] ) : null) : null;
            $this->options = isset($attr['options']) ? ($attr['options'] ? array_filter($attr['options']) : array()) : array();
            $this->option = isset($attr['option']) ? ($attr['option'] ? $attr['option'] : null) : null;
            $this->optionLabel = isset($attr['optionLabel']) ? ($attr['optionLabel'] ? esc_html( $attr['optionLabel'] ) : null) : null;
            $this->attr = isset($attr['attr']) ? ($attr['attr'] ? $attr['attr'] : null) : null;
            $this->alignment = isset($attr['alignment']) ? ($attr['alignment'] ? esc_attr($attr['alignment']) : null) : null;
            $this->blank = !empty($attr['blank']) ? esc_html( $attr['blank'] ) : null;
            $this->required = !empty($attr['required']) ? " required": null;
            $this->frontEnd = !empty($attr['frontEnd']) ? true : false;
            if ($this->frontEnd) {
                $this->description = null;
            }
            $this->class = $this->class ? esc_attr($this->class) . " rt-form-control" : "rt-form-control";

        }

        /**
         * Create field
         *
         * @param $key
         * @param $attr
         *
         * @return null|string
         */
        public function Field($key, $attr = array())
        {
            $this->setArgument($key, $attr);
            $holderId = $this->name . "_holder";

            $html = null;
            $html .= "<div class='rt-field-wrapper {$this->holderClass}' id='{$holderId}'>";

            if ( $this->label ) {
				$pro_label = ( isset( $attr['is_pro'] ) && $attr['is_pro'] ) && !function_exists('rttsp') ? '<span class="rtts-pro rtts-tooltip">' . esc_html__( '[Pro]', 'tlp-team' ) . '<span class="rtts-tooltiptext">'.esc_html__( 'This is premium field', 'tlp-team' ).'</span></span>' : '';
				$pro_label = apply_filters('rtts_pro_label', $pro_label);

				$html .= "<div class='rt-label'>";
				$html .= "<label for='{$this->id}'>{$this->label} {$pro_label}</label>";
				$html .= "</div>";
			}

            $pro_class = ( isset( $attr['is_pro'] ) && $attr['is_pro'] ) && !function_exists('rttsp') ? 'pro-field' : '';

			$html .= "<div class='rt-field {$pro_class}'>";

            if ( ( isset( $attr['is_pro'] ) && $attr['is_pro'] ) && !function_exists('rttsp') ) {
				$html .= '<div class="pro-field-overlay"></div>';
			}

            switch ($this->type) {
                case 'text':
                    $html .= $this->text($attr);
                    break;

                case 'slug':
                    $html .= $this->slug();
                    break;

                case 'price':
                    $html .= $this->price();
                    break;

                case 'url':
                    $html .= $this->url();
                    break;

                case 'number':
                    $html .= $this->number($attr);
                    break;

                case 'select':
                    $html .= $this->select($attr);
                    break;

                case 'textarea':
                    $html .= $this->textArea();
                    break;

                case 'checkbox':
                    $html .= $this->checkbox($attr);
                    break;

                case 'switch':
                    $html .= $this->switch($attr);
                    break;

                case 'radio':
                    $html .= $this->radioField($attr);
                    break;

                case 'colorpicker':
                    $html .= $this->colorPicker();
                    break;

                case 'custom_css':
                    $html .= $this->customCss();
                    break;

                case 'style':
                    $html .= $this->smartStyle();
                    break;

                case 'simple_image':
                    $html .= $this->simple_image();
                    break;

                case 'radio-image':
                    $html .= $this->radioImage();
                    break;

                case 'image':
                    $html .= $this->image();
                    break;

                case 'image_size':
                    $html .= $this->imageSize();
                    break;
                case 'video':
                    $html .= $this->video();
                    break;
                case 'rating':
                    $html .= $this->rating();
                    break;
                case 'socialMedia':
                    $html .= $this->socialMedia();
                    break;
                case 'recaptcha':
                    $html .= $this->recaptcha();
                    break;
                case 'multiple_options':
                    $html .= $this->multipleOption($this->options);
                    break;
                default:
                    $html .= $this->text($attr);
                    break;
            }

            if ($this->description) {
                $html .= "<p class='description'>{$this->description}</p>";
            }

            $html .= "</div>"; // field
            $html .= "</div>"; // field holder

            return $html;
        }

        /**
         * Generate text field
         * @return null|string
         */
        private function text($attr) {
            $readonly = ( isset( $attr['is_pro'] ) && $attr['is_pro'] ) && !function_exists('rttsp') ? 'readonly' : '';
            $h = "<input
                    type='text'
                    class='{$this->class}'
                    id='{$this->name}'
                    {$readonly}
                    value='{$this->value}'
                    name='{$this->name}'
                    placeholder='{$this->placeholder}'
                    {$this->attr}
                    {$this->required}
                    />";

            return $h;
        }

        /**
         * Generate text field
         * @return null|string
         */
        private function price()
        {
            $h = null;
            $h .= "<input
                    type='text'
                    class='{$this->class}'
                    id='{$this->name}'
                    value='{$this->value}'
                    name='{$this->name}'
                    placeholder='{$this->placeholder}'
                    {$this->attr}
                    />";

            return $h;
        }

        /**
         * Generate text field
         * @return null|string
         */
        private function slug()
        {
            $h = null;
            $h .= "<input
                    type='text'
                    class='{$this->class}'
                    id='{$this->name}'
                    value='{$this->value}'
                    name='{$this->name}'
                    placeholder='{$this->placeholder}'
                    {$this->attr}
                    />";

            return $h;
        }

        /**
         * Generate color picker
         * @return null|string
         */
        private function colorPicker()
        {
            $h = null;
            $h .= "<input
                    type='text'
                    class='{$this->class} rt-color'
                    id='{$this->name}'
                    value='{$this->value}'
                    name='{$this->name}'
                    placeholder='{$this->placeholder}'
                    {$this->attr}
                    />";

            return $h;
        }

        /**
         * Custom css field
         * @return null|string
         */
        private function customCss()
        {
            $h = null;
            $h .= '<div class="rt-custom-css">';
            $h .= '<div class="custom_css_pfp-container">';
            $h .= "<div name='{$this->name}' id='ret-" . mt_rand() . "' class='custom-css'>";
            $h .= '</div>';
            $h .= '</div>';

            $h .= "<textarea
                        style='display: none;'
                        class='custom_css_textarea'
                        id='{$this->name}'
                        name='{$this->name}'
                        >{$this->value}</textarea>";
            $h .= '<p class="description"
            style="color: red">'.esc_html__('Please use default customizer to add your css. This option is deprecated. ', 'testimonial-slider-showcase').'</p>';
            $h .= '</div>';

            return $h;
        }

        /**
         * Generate URL field
         * @return null|string
         */
        private function url()
        {
            $h = null;
            $h .= "<input
                    type='url'
                    class='{$this->class}'
                    id='{$this->name}'
                    value='{$this->value}'
                    name='{$this->name}'
                    placeholder='{$this->placeholder}'
                    {$this->attr}
                    {$this->required}
                    />";

            return $h;
        }

        /**
         * Generate number field
         * @return null|string
         */
        private function number( $attr )
        {
            $h = null;
            $readonly = ( isset( $attr['is_pro'] ) && $attr['is_pro'] ) && !function_exists('rttsp') ? 'readonly' : '';

            $h .= "<input
                    type='number'
                    class='{$this->class}'
                    {$readonly}
                    id='{$this->name}'
                    value='{$this->value}'
                    name='{$this->name}'
                    placeholder='{$this->placeholder}'
                    {$this->attr}
                    />";

            return $h;
        }

        /**
         * Generate Drop-down field
         * @return null|string
         */
        private function select( $attr ) {
            $h = null;
            if ($this->multiple) {
                $this->attr = " style='min-width:160px;'";
                $this->name = $this->name . "[]";
                $this->attr = $this->attr . " multiple='multiple'";
                $this->value = (is_array($this->value) && !empty($this->value) ? ( $this->value ) : array());
            } else {
                $this->value = array($this->value);
            }

            $disabled = ( isset( $attr['is_pro'] ) && $attr['is_pro'] ) && !function_exists('rttsp') ? 'disabled' : '';

            $h .= "<select {$disabled} name='{$this->name}' id='{$this->name}' class='{$this->class}' {$this->attr}>";
            if ($this->blank) {
                $h .= "<option value=''>{$this->blank}</option>";
            }
            if (is_array($this->options) && !empty($this->options)) {
                foreach ($this->options as $key => $value) {
                    $slt = (in_array($key, $this->value) ? "selected" : null);
                    $h .= "<option {$slt} value='{$key}'>{$value}</option>";
                }
            }
            $h .= "</select>";

            return $h;
        }

        /**
         * Generate textArea field
         * @return null|string
         */
        private function textArea()
        {
            $h = null;
            $h .= "<textarea
                    class='{$this->class} rt-textarea'
                    id='{$this->name}'
                    name='{$this->name}'
                    placeholder='{$this->placeholder}'
                    {$this->attr}
                    {$this->required}
                    >{$this->value}</textarea>";

            return $h;
        }

        /**
         * Generate check box
         * @return null|string
         */
        private function checkbox($attr) {
            $h = null;
            $id = $this->name;
            if ($this->multiple) {
                $this->name = $this->name . "[]";
                $this->value = (is_array($this->value) && !empty($this->value) ? array_filter($this->value) : array());
            }
            if ($this->multiple) {
                $h .= "<div class='checkbox-group {$this->alignment}' id='{$id}'>";
                if (is_array($this->options) && !empty($this->options)) {
                    foreach ($this->options as $key => $value) {
                        $checked = (in_array($key, $this->value) ? "checked" : null);
                        $h .= "<label for='{$id}-{$key}'>
                                <input type='checkbox' id='{$id}-{$key}' {$checked} name='{$this->name}' value='{$key}'>{$value}
                                </label>";
                    }
                }
                $h .= "</div>";
            } else {
                $checked = ($this->value == $this->option ? "checked" : null);
                $readonly = ( isset( $attr['is_pro'] ) && $attr['is_pro'] ) && !function_exists('rttsp') ? 'readonly' : '';
                $h .= "<label><input type='checkbox' {$readonly}  {$checked} id='{$this->name}' name='{$this->name}' value='{$this->option}' />{$this->optionLabel}</label>";
            }

            return $h;
        }

        private function switch() {
			$h = null;
			$checked = ( $this->value ? "checked" : null );
			$h .= "<label class='rtts-switch'><input type='checkbox' {$checked} id='{$this->name}' name='{$this->name}' value='1' /><span class='rtts-switch-slider round'></span></label>";

			return $h;
		}

        /**
         * Generate Radio field
         * @return null|string
         */
        private function radioField($attr)
        {
            if ($this->value === '') {
                $this->value = $this->default;
            }
            $h = null;
            $h .= "<div class='radio-group {$this->alignment}' id='{$this->name}'>";
            $readonly = ( isset( $attr['is_pro'] ) && $attr['is_pro'] ) && !function_exists('rttsp') ? 'readonly' : '';
            if (is_array($this->options) && !empty($this->options)) {
                foreach ($this->options as $key => $value) {
                    $checked = ($key == $this->value ? "checked" : null);
                    $h .= "<label for='{$this->name}-{$key}'>
                            <input type='radio' id='{$this->name}-{$key}' {$readonly} {$checked} name='{$this->name}' value='{$key}'>{$value}
                            </label>";
                }
            }
            $h .= "</div>";

            return $h;
        }

        private function smartStyle()
        {
            $h = null;
            $sColor = !empty($this->value['color']) ? esc_attr( $this->value['color'] ) : null;
            $sSize = !empty($this->value['size']) ? esc_attr( $this->value['size'] ) : null;
            $sWeight = !empty($this->value['weight']) ? esc_attr( $this->value['weight'] ) : null;
            $sAlign = !empty($this->value['align']) ? esc_attr( $this->value['align'] ) : null;
            $h .= "<div class='multiple-field-rt-container rt-clear'>";
            // color
            $h .= "<div class='field-inner col-4'>";
            $h .= "<div class='field-inner-rt-container size'>";
            $h .= "<span class='label'>Color</span>";
            $h .= "<input type='text' value='" . esc_attr($sColor) . "' class='rt-color' name='{$this->name}[color]'>";
            $h .= "</div>";
            $h .= "</div>";

            // Font size
            $h .= "<div class='field-inner col-4'>";
            $h .= "<div class='field-inner-rt-container size'>";
            $h .= "<span class='label'>Font size</span>";
            $h .= "<select name='{$this->name}[size]' class='rt-select2'>";
            $fSizes = TSSPro()->scFontSize();
            $h .= "<option value=''>Default</option>";
            foreach ($fSizes as $size => $label) {
                $sSlt = ($size == $sSize ? "selected" : null);
                $h .= "<option value='{$size}' {$sSlt}>{$label}</option>";
            }
            $h .= "</select>";
            $h .= "</div>";
            $h .= "</div>";

            // Weight

            $h .= "<div class='field-inner col-4'>";
            $h .= "<div class='field-inner-rt-container weight'>";
            $h .= "<span class='label'>Weight</span>";
            $h .= "<select name='{$this->name}[weight]' class='rt-select2'>";
            $h .= "<option value=''>Default</option>";
            $weights = TSSPro()->scTextWeight();
            foreach ($weights as $weight => $label) {
                $wSlt = ($weight == $sWeight ? "selected" : null);
                $h .= "<option value='{$weight}' {$wSlt}>{$label}</option>";
            }
            $h .= "</select>";
            $h .= "</div>";
            $h .= "</div>";

            // Alignment

            $h .= "<div class='field-inner col-4'>";
            $h .= "<div class='field-inner-rt-container alignment'>";
            $h .= "<span class='label'>Alignment</span>";
            $h .= "<select name='{$this->name}[align]' class='rt-select2'>";
            $h .= "<option value=''>Default</option>";
            $aligns = TSSPro()->scAlignment();
            foreach ($aligns as $align => $label) {
                $aSlt = ($align == $sAlign ? "selected" : null);
                $h .= "<option value='{$align}' {$aSlt}>{$label}</option>";
            }
            $h .= "</select>";
            $h .= "</div>";
            $h .= "</div>";
            $h .= "</div>";

            return $h;
        }

        /**
         * Generate textArea field
         * @return null|string
         */
        private function simple_image()
        {
            $h = null;
            $h .= "<div class='rt-simple-image-wrapper'><input
                    type='file'
                    class='{$this->class} rt-simple-image'
                    id='{$this->name}'
                    name='{$this->name}'
                    {$this->attr} /><div class='rt-simple-image-preview'></div></div>";

            return $h;
        }

        private function radioImage() {
			$h = null;
            $id = 'rtts-' . $this->name;

			$h .= sprintf("<div class='rtts-radio-image %s' id='%s'>", esc_attr($this->alignment), esc_attr($id));

            $layout_group = [
                'grid' => [
                    'layout1',
					'layout2',
					'layout3',
					'layout4',
					'layout5',
					'layout6',
					'layout7',
					'layout8',
					'layout9',
					'layout10',
					'layout_video'
                ],
                'slider' => [
                    'carousel1',
					'carousel2',
					'carousel3',
					'carousel4',
					'carousel5',
					'carousel6',
					'carousel7',
					'carousel8',
					'carousel9',
					'carousel10',
					'carousel11',
					'carousel12',
					'carousel_video'
                ],
                'isotope' => [
                    'isotope1',
					'isotope2',
					'isotope3',
					'isotope4',
					'isotope5',
					'isotope_video'
                ],
            ];

			$selected_value = $this->value;
            if( $this->name == 'layout_type' ) {
                if ( !$selected_value ) {
                    $layout = get_post_meta( get_the_ID(), 'tss_layout', true );
                    if ( $layout ) {
                        foreach ( $layout_group as $key => $value ) {
                            if ( in_array( $layout, $value ) ) {
                                $selected_value = $key;
                                break;
                            }
                        }
                    } else {
                        $selected_value = 'grid';
                    }
                }
            }

			if ( is_array($this->options) && !empty($this->options) ) {
				foreach ($this->options as $key => $value) {
					$checked = ($value['value'] == $selected_value ? "checked" : null);
					$is_pro = ( isset( $value['is_pro'] ) && $value['is_pro'] && !function_exists('rttsp') ? '<div class="rtts-ribbon"><span>'.esc_html__( 'Pro', 'review-schema' ).'</span></div>' : '');
					$is_data_pro = ( isset( $value['is_pro'] ) && $value['is_pro'] && !function_exists('rttsp') ? 'yes' : '');
					$name = isset( $value['name'] ) && $value['name'] ? esc_html( $value['name'] ) : '';
					$h .= sprintf('<label for="%1$s-%2$s">
					<input type="radio" id="%1$s-%2$s" %3$s name="%4$s" value="%2$s" data-pro="%7$s">
					<div class="rtts-radio-image-pro-wrap">
						<img src="%5$s" title="%8$s" alt="%2$s">
						%6$s
						<div class="rtts-checked"><span class="dashicons dashicons-yes"></span></div>
					</div>
					</label>',
					esc_attr($this->id),
					esc_attr($value['value']),
					esc_attr($checked),
					esc_attr($this->name),
					esc_url($value['img']),
					$is_pro,
					esc_attr($is_data_pro),
					esc_attr($name)
					);
				}
			}
			$h .= "</div>";
			return $h;
		}

        private function image()
        {
            $h = null;
            $h .= "<div class='rt-image-holder'>";
            $h .= "<input type='hidden' name='{$this->name}' value='{$this->value}' id='{$this->name}' class='hidden-image-id' />";
            $img = null;
            $c = "hidden";
            if ($id = absint($this->value)) {
                $aImg = wp_get_attachment_image_src($id, 'thumbnail');
                $img = "<img src='{$aImg[0]}' >";
                $c = null;
            } else {
                $aImg = TSSPro()->placeholder_img_src();
                $img = "<img src='{$aImg}' >";
            }
            $h .= "<div class='rt-image-preview'>{$img}<span class='dashicons dashicons-plus-alt rtAddImage'></span><span class='dashicons dashicons-trash rtRemoveImage {$c}'></span></div>";
            $h .= "</div>";

            return $h;
        }

        private function imageSize()
        {
            $width = (!empty($this->value['width']) ? absint($this->value['width']) : null);
            $height = (!empty($this->value['height']) ? absint($this->value['height']) : null);
            $cropV = (!empty($this->value['crop']) ? esc_attr( $this->value['crop'] ) : 'soft');
            $h = null;
            $h .= "<div class='rt-image-size-holder'>";
            $h .= "<div class='rt-image-size-width rt-image-size'>";
            $h .= "<label>" . esc_html__("Width", 'testimonial-slider-showcase') . "</label>";
            $h .= "<input type='number' name='{$this->name}[width]' value='{$width}' />";
            $h .= "</div>";
            $h .= "<div class='rt-image-size-height rt-image-size'>";
            $h .= "<label>Height</label>";
            $h .= "<input type='number' name='{$this->name}[height]' value='{$height}' />";
            $h .= "</div>";
            $h .= "<div class='rt-image-size-crop rt-image-size'>";
            $h .= "<label>Crop</label>";
            $h .= "<select name='{$this->name}[crop]' class='rt-select2'>";
            $cropList = TSSPro()->imageCropType();
            foreach ($cropList as $crop => $cropLabel) {
                $cSl = ($crop == $cropV ? "selected" : null);
                $h .= "<option value='{$crop}' {$cSl}>{$cropLabel}</option>";
            }
            $h .= "</select>";
            $h .= "</div>";
            $h .= "</div>";

            return $h;
        }

        private function video()
        {

            $h = null;
            $h .= "<div class='rt-video-holder'>";
            $h .= "<div class='rt-video-field'>";
            $h .= "<input class='rt-video-url {$this->class}'
                    id='{$this->name}'
                    placeholder='{$this->placeholder}'
                    {$this->attr}
                    type='url' name='{$this->name}' value='{$this->value}' />";
            $h .= "</div>";
            $h .= "<div class='rt-video-preview'>";
            $h .= apply_filters('the_content', $this->value);
            $h .= "</div>";
            $h .= "</div>";

            return $h;
        }


        private function rating()
        {
            $h = null;
            $selected = ($this->value ? " selected" : null);
            $h .= "<div class='rt-rating{$selected}'>";
            for ($i = 1; $i <= 5; $i++) {
                $active = ($i == $this->value ? "active" : null);
                $h .= "<span data-star='{$i}' class='star-{$i} dashicons dashicons-star-empty {$active}' aria-hidden='true'></span>";
            }
            $h .= "<input type='hidden' class='rating-value' value='{$this->value}' name='{$this->name}' />";
            $h .= "</div>";

            return $h;
        }

        private function recaptcha()
        {
            $h = null;
            $settings = get_option(TSSPro()->options['settings']);
            $siteKey = (!empty($settings['tss_site_key']) ? esc_attr($settings['tss_site_key']): null);
            $h .= "<div class='g-recaptcha' id='{$this->name}' data-sitekey='{$siteKey}'></div>";

            return $h;
        }

        private function socialMedia()
        {
            $h = null;
            $h .= "<div class='rt-social-media'>";
            if (!$this->frontEnd) {
                $h .= "<div class='rt-sm-wrapper rt-clear' id='{$this->name}'>";
                $h .= "<div class='rt-sm-active rt-sm-sortable-list' data-title='" . esc_html__("Active Social link",
                        "testimonial-slider-showcase") . "'>";
                if (!empty($this->value) && is_array($this->value)) {
                    foreach ($this->value as $socialId => $socialUrl) {
                        $value = !empty($this->value[$socialId]) ? esc_url($this->value[$socialId]) : null;
                        $h .= "<div class='social-item active-item' data-id='{$socialId}'><span class='dashicons dashicons-{$socialId}'></span><input type='text' name='{$this->name}[$socialId]' value='{$value}'></div>";
                    }
                }
                $h .= "</div>";
                $h .= "<div class='rt-sm-available rt-sm-sortable-list' data-title='" . esc_html__("Available Social link",
                        "testimonial-slider-showcase") . "'>";
                $items = $this->options;
                if (!empty($items)) {
                    $keys = (!empty($this->value) ? array_keys($this->value) : array());
                    foreach ($items as $socialId => $title) {
                        if (!in_array($socialId, $keys)) {
                            $h .= "<div class='social-item available-item' data-id='{$socialId}'><span class='dashicons dashicons-{$socialId}'></span></div>";
                        }
                    }
                }
                $h .= "</div>";
                $h .= "</div>";
            } else {
                $h .= "<div class='rt-sm-wrapper rt-clear' id='{$this->name}'>";
                $h .= "<div class='rt-sm-active rt-sm-sortable-list' data-title='" . esc_html__("Active Social link",
                        "testimonial-slider-showcase") . "'>";
                $items = $this->options;
                if (!empty($items)) {
                    foreach ($items as $socialId => $title) {
                        $h .= "<div class='social-item' data-id='{$socialId}'><span class='dashicons dashicons-{$socialId}'></span><input type='text' name='{$this->name}[$socialId]' value=''></div>";
                    }
                }
                $h .= "</div>";
                $h .= "</div>";
            }
            $h .= "</div>";

            return $h;
        }

        private function multipleOption($fields = array())
        {
            $h = null;
            $h .= "<div class='multiple-field-rt-container rt-clear'>";
            if (!empty($fields) && is_array($fields)) {
                foreach ($fields as $key => $field) {
                    $h .= $this->innerField($key, $field);
                }
            }
            $h .= "</div>";

            return $h;
        }

        private function innerField($key, $options = array())
        {
            $h = null;
            $col_size = !empty($options['col_size']) ? absint( $options['col_size'] ) : 3;
            $type = !empty($options['type']) ? esc_attr( $options['type'] ) : 'color';
            $label = !empty($options['label']) ? esc_html( $options['label'] ) : null;
            $desc = !empty($options['description']) ? wp_kses_post($options['description']) : null;
            $val = !empty($this->value[$key]) ? $this->value[$key] : null;
            $class = !empty($options['class']) ? trim($options['class']) : null;
            $blank = !empty($options['blank']) ? trim($options['blank']) : null;
            $lists = !empty($options['options']) ? array_filter($options['options']) : array();
            $default = !empty($options['default']) ? esc_html($options['default']) : null;
            if (!$val) {
                $val = $default;
            }

            switch ($type) {

                case "number":
                    $h .= "<div class='field-inner col-{$col_size}'>";
                    $h .= "<div class='field-inner-rt-container {$key}'>";
                    $h .= ($label ? "<span class='label'>{$label}</span>" : null);
                    $h .= "<input type='number' value='" . esc_attr($val) . "' class='rt-number' name='{$this->name}[{$key}]'>";
                    $h .= ($desc ? "<p class='description'>{$desc}</p>" : null);
                    $h .= "</div>";
                    $h .= "</div>";
                    break;

                case "color":
                    $h .= "<div class='field-inner col-{$col_size}'>";
                    $h .= "<div class='field-inner-rt-container {$key}'>";
                    $h .= ($label ? "<span class='label'>{$label}</span>" : null);
                    $h .= "<input type='text' value='" . esc_attr($val) . "' class='rt-color' name='{$this->name}[{$key}]'>";
                    $h .= ($desc ? "<p class='description'>{$desc}</p>" : null);
                    $h .= "</div>";
                    $h .= "</div>";
                    break;

                case "select":
                    $h .= "<div class='field-inner col-{$col_size}'>";
                    $h .= "<div class='field-inner-rt-container {$key}'>";
                    $h .= ($label ? "<span class='label'>{$label}</span>" : null);

                    $h .= "<select name='{$this->name}[$key]' id='{$this->id}_{$key}' class='{$class}'>";
                    if ($blank) {
                        $h .= "<option value=''>{$blank}</option>";
                    }
                    if (is_array($lists) && !empty($lists)) {
                        foreach ($lists as $lKey => $value) {
                            $slt = ($lKey == $val ? "selected" : null);
                            $h .= "<option {$slt} value='{$lKey}'>{$value}</option>";
                        }
                    }
                    $h .= "</select>";
                    $h .= ($desc ? "<p class='description'>{$desc}</p>" : null);
                    $h .= "</div>";
                    $h .= "</div>";
                    break;

                default:
                    break;
            }

            return $h;
        }

        private function meta_exist($post_id, $meta_key, $type = "post")
        {
            if (!$post_id) {
                return false;
            }

            return metadata_exists($type, $post_id, $meta_key);
        }


    }
endif;
