<?php
/**
 * The plugin gutenberg block.
 *
 * @link       https://shapedplugin.com/
 * @since      2.5.1
 *
 * @package    Testimonial_Free
 * @subpackage Testimonial_Free/Admin
 * @author     ShapedPlugin <support@shapedplugin.com>
 */

namespace ShapedPlugin\TestimonialFree\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Sp_Testimonial_Free_Gutenberg_Block' ) ) {

	/**
	 * Custom Gutenberg Block.
	 */
	class Sp_Testimonial_Free_Gutenberg_Block {

		/**
		 * Block Initializer.
		 */
		public function __construct() {
			new GutenbergBlock\Sp_Testimonial_Free_Gutenberg_Block_Init();
		}

	}
}
