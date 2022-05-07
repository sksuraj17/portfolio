<?php
/**
 * Font selector.
 * @package Portfolioline
 */
if( ! class_exists( 'WP_Customize_Control' ) ){
	return;
}
/**
 * Class Portfoliolite_Font_Selector
 */
class Portfoliolite_Font_Selector extends WP_Customize_Control{
	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'selector-font';
	/**
	 * Render the control's content.
	 * Allows the content to be overriden without having to rewrite the wrapper in $this->render().
	 *
	 * @access protected
	 */
	protected function render_content(){
		$this_val = $this->value(); ?>
		<label>
			<?php if ( ! empty( $this->label ) ) : ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
			<?php endif; ?>

			<select class="themehunk-typography-select" <?php $this->link(); ?>>
				<option value="" 
				<?php
				if ( ! $this_val ) {
					echo 'selected="selected"';
				}
?>
><?php esc_html_e( 'Default', 'portfoliolite' ); ?></option>
<?php
// Get Standard font options
$std_fonts = portfoliolite_get_standard_fonts();
		if (isset($std_fonts) && ! empty( $std_fonts ) ){
				?>
					<optgroup label="<?php esc_attr_e( 'Standard Fonts', 'portfoliolite' ); ?>">
						<?php
						// Loop through font options and add to select
						foreach ( $std_fonts as $font ) {
						?>
							<option value="<?php echo esc_attr( $font ); ?>" <?php selected( $font, $this_val ); ?>><?php echo esc_html( $font ); ?></option>
						<?php } ?>
					</optgroup>
				<?php
				}
				// Google font options
				$google_fonts = portfoliolite_get_google_fonts_array();
				if ( ! empty( $google_fonts ) ){
				?>
					<optgroup label="<?php esc_attr_e( 'Google Fonts', 'portfoliolite' ); ?>">
						<?php
						// Loop through font options and add to select
						foreach ( $google_fonts as $font ) {
						?>
							<option value="<?php echo esc_attr( $font ); ?>" <?php selected( $font, $this_val ); ?>><?php echo esc_html( $font ); ?></option>
						<?php } ?>
					</optgroup>
				<?php } ?>
			</select>
		</label>
	  <?php
	}
}