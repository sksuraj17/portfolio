<?php
/**
 * @package ThemeHunk
 * @subpackage Portfoliolite
 * @since 1.0.0
 */
    get_template_part( '/inc/static-function');
    get_template_part( '/lib/breadcrumbs/breadcrumbs');
    //theme-option
    get_template_part( 'lib/th-option/th-option');
    get_template_part( 'lib/th-option/child-notify');

    get_template_part( '/inc/custom-style');
    get_template_part( '/customizer/customizer-range-value/class/class-portfoliolite-customizer-range-value-control');
    get_template_part( '/customizer/extend-customizer/class-portfoliolite-wp-customize-panel');
    get_template_part( '/customizer/extend-customizer/class-portfoliolite-wp-customize-section');
    get_template_part( '/customizer/color-picker/alpha-color-picker');
    get_template_part( '/customizer/customizer-font-selector/class/class-portfoliolite-font-selector');
    get_template_part( '/customizer/customizer-tabs/class/class-portfoliolite-customize-control-tabs');
    get_template_part( '/customizer/custom-customizer');
	
	//typography
	get_template_part('/customizer/customizer-font-selector/functions');
    get_template_part( '/customizer/customizer');
    //TYPOGRAPHY SETTINGS
    get_template_part('/customizer/section/typography/base-typography');