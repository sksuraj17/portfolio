<?php
/**
 * Real Testimonials admin class file.
 *
 * @link http://shapedplugin.com
 * @since 2.0.0
 *
 * @package Testimonial_free.
 * @subpackage Testimonial_free/Admin.
 */

namespace ShapedPlugin\TestimonialFree\Admin;

use ShapedPlugin\TestimonialFree\Admin\DBUpdates;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The Admin class.
 */
class Admin {
	/**
	 * The class constructor.
	 *
	 * @since 1.0
	 */
	public function __construct() {
		add_filter( 'init', array( $this, 'register_testimonial_post_type' ) );
		add_filter( 'init', array( $this, 'register_shortcode_post_type' ) );
		add_filter( 'admin_menu', array( $this, 'sptfree_conditional_redirect_post_new' ) );
		add_action( 'admin_head', array( $this, 'spt_testimonial_form_admin_head' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		add_action( 'widgets_init', array( $this, 'sp_testimonial_free_widget' ) );
		new DBUpdates();
	}
	/**
	 * Real Testimonials form publish button disabled.
	 *
	 * @since 1.0
	 */
	public function spt_testimonial_form_admin_head() {
		$screen = get_current_screen();
		if ( 'spt_testimonial_form' === $screen->post_type ) {
			?><script>
			jQuery(document).ready(function(){
				jQuery("#submitdiv #publish, #submitdiv, #submitdiv #save-post").attr("disabled", true).css("opacity", "0.8");
			});</script>
			<?php
		}

	}

	/**
	 * Enqueue admin scripts
	 *
	 * @return void
	 */
	public function admin_scripts() {
		wp_enqueue_style( 'testimonial-free-admin', SP_TFREE_URL . 'Admin/assets/css/admin.min.css', array(), SP_TFREE_VERSION );
	}

	/**
	 * Register Shortcode Post Type
	 *
	 * @return void
	 */
	public function register_shortcode_post_type() {
		$capability = apply_filters( 'sp_tfree_ui_permission', 'manage_options' );
		$show_ui    = current_user_can( $capability ) ? true : false;
		register_post_type(
			'spt_shortcodes',
			array(
				'label'              => __( 'Manage Views', 'testimonial-free' ),
				'description'        => __( 'Manage Views', 'testimonial-free' ),
				'public'             => false,
				'has_archive'        => false,
				'publicly_queryable' => false,
				'show_ui'            => $show_ui,
				'show_in_menu'       => 'edit.php?post_type=spt_testimonial',
				'hierarchical'       => false,
				'query_var'          => false,
				'supports'           => array( 'title' ),
				'capability_type'    => 'post',
				'labels'             => array(
					'name'               => __( 'Manage Views', 'testimonial-free' ),
					'singular_name'      => __( 'Manage View', 'testimonial-free' ),
					'menu_name'          => __( 'Manage Views', 'testimonial-free' ),
					'add_new'            => __( 'Add New', 'testimonial-free' ),
					'add_new_item'       => __( 'Add New View', 'testimonial-free' ),
					'edit'               => __( 'Edit', 'testimonial-free' ),
					'edit_item'          => __( 'Edit View', 'testimonial-free' ),
					'new_item'           => __( 'New View', 'testimonial-free' ),
					'search_items'       => __( 'Search View', 'testimonial-free' ),
					'not_found'          => __( 'No View Found', 'testimonial-free' ),
					'not_found_in_trash' => __( 'No View Found in Trash', 'testimonial-free' ),
					'parent'             => __( 'Parent View', 'testimonial-free' ),
				),
			)
		);
		register_post_type(
			'spt_testimonial_form',
			array(
				'label'               => __( 'Forms', 'testimonial-free' ),
				'description'         => __( 'Generate forms for Frontend.', 'testimonial-free' ),
				'public'              => false,
				'has_archive'         => false,
				'publicaly_queryable' => false,
				'show_ui'             => $show_ui,
				'show_in_menu'        => 'edit.php?post_type=spt_testimonial',
				'hierarchical'        => false,
				'query_var'           => false,
				'supports'            => array( 'title' ),
				'capability_type'     => 'post',
				'labels'              => array(
					'name'               => __( 'Testimonial Forms', 'testimonial-free' ),
					'singular_name'      => __( 'Testimonial Form', 'testimonial-free' ),
					'menu_name'          => __( 'Testimonial Forms', 'testimonial-free' ),
					'add_new'            => __( 'Add New', 'testimonial-free' ),
					'add_new_item'       => __( 'Add New Form', 'testimonial-free' ),
					'edit'               => __( 'Edit', 'testimonial-free' ),
					'edit_item'          => __( 'Edit Form', 'testimonial-free' ),
					'new_item'           => __( 'New Form', 'testimonial-free' ),
					'search_items'       => __( 'Search Forms', 'testimonial-free' ),
					'not_found'          => __( 'No Form Found', 'testimonial-free' ),
					'not_found_in_trash' => __( 'No Form Found in Trash', 'testimonial-free' ),
					'parent'             => __( 'Parent Form', 'testimonial-free' ),
				),
			)
		);
	}

	/**
	 * Register testimonial post type for this plugin.
	 *
	 * @return void
	 */
	public function register_testimonial_post_type() {

		if ( post_type_exists( 'spt_testimonial' ) ) {
			return;
		}
		$settings      = get_option( 'sp_testimonial_pro_options' );
		$singular_name = isset( $settings['tpro_singular_name'] ) ? $settings['tpro_singular_name'] : 'Testimonial';
		$plural_name   = isset( $settings['tpro_plural_name'] ) ? $settings['tpro_plural_name'] : 'Testimonials';
		$capability    = apply_filters( 'sp_tfree_ui_permission', 'manage_options' );
		$show_ui       = current_user_can( $capability ) ? true : false;
		$labels        = apply_filters(
			'sp_testimonial_post_type_labels',
			array(
				/* translators: %s is replaced with 'member plural name' */
				'name'                  => wp_sprintf( __( 'All %s', 'testimonial-free' ), esc_html( $plural_name ) ),
				'singular_name'         => $singular_name,
				'menu_name'             => __( 'Real Testimonials', 'testimonial-free' ),
				/* translators: %s is replaced with 'member plural name' */
				'all_items'             => wp_sprintf( __( 'All %s', 'testimonial-free' ), esc_html( $plural_name ) ),
				'add_new'               => __( 'Add New', 'testimonial-free' ),
				'add_new_item'          => __( 'Add New', 'testimonial-free' ),
				'edit'                  => __( 'Edit', 'testimonial-free' ),
				/* translators: %s is replaced with 'member plural name' */
				'edit_item'             => wp_sprintf( __( 'Edit %s', 'testimonial-free' ), esc_html( $singular_name ) ),
				/* translators: %s is replaced with 'member plural name' */
				'new_item'              => wp_sprintf( __( 'New %s', 'testimonial-free' ), esc_html( $singular_name ) ),
				/* translators: %s is replaced with 'member plural name' */
				'search_items'          => wp_sprintf( __( 'Search %s', 'testimonial-free' ), esc_html( $plural_name ) ),
				/* translators: %s is replaced with 'member plural name' */
				'not_found'             => wp_sprintf( __( 'No %s found', 'testimonial-free' ), esc_html( $plural_name ) ),
				/* translators: %s is replaced with 'member plural name' */
				'not_found_in_trash'    => wp_sprintf( __( 'No %s found in Trash', 'testimonial-free' ), esc_html( $plural_name ) ),
				/* translators: %s is replaced with 'member plural name' */
				'parent'                => wp_sprintf( __( 'Parent %s', 'testimonial-free' ), esc_html( $plural_name ) ),
				/* translators: %s is replaced with 'member plural name' */
				'featured_image'        => wp_sprintf( __( '%s Image', 'testimonial-free' ), esc_html( $singular_name ) ),
				/* translators: %s is replaced with 'member plural name' */
				'set_featured_image'    => wp_sprintf( __( 'Set %s image', 'testimonial-free' ), esc_html( $singular_name ) ),
				'remove_featured_image' => __( 'Remove image', 'testimonial-free' ),
				'use_featured_image'    => __( 'Use as image', 'testimonial-free' ),
			)
		);

		$args = apply_filters(
			'sp_testimonial_post_type_args',
			array(
				'label'              => $singular_name,
				/* translators: %s is replaced with 'member plural name' */
				'description'        => wp_sprintf( __( '%s custom post type.', 'testimonial-free' ), esc_html( $singular_name ) ),
				'taxonomies'         => array(),
				'public'             => false,
				'has_archive'        => false,
				'publicly_queryable' => false,
				'query_var'          => false,
				'show_ui'            => $show_ui,
				'show_in_menu'       => true,
				'menu_icon'          => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIj8+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjUxMnB4IiBoZWlnaHQ9IjUxMnB4IiB2aWV3Qm94PSIwIDAgNDc4LjI0OCA0NzguMjQ4IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA0NzguMjQ4IDQ3OC4yNDg7IiB4bWw6c3BhY2U9InByZXNlcnZlIiBjbGFzcz0iIj48Zz48Zz4KCTxnPgoJCTxnPgoJCQk8cGF0aCBkPSJNNDU2LjAyLDQ0LjgyMUgyNjQuODNjLTEyLjI2LDAtMjIuMjMyLDkuOTcyLTIyLjIzMiwyMi4yMjl2OTguNjUyYzAsMTIuMjU4LDkuOTc0LDIyLjIzLDIyLjIzMiwyMi4yM2gxNi43ODd2MzkuMTYxICAgICBjMCwyLjcwNywxLjU4LDUuMTY1LDQuMDQzLDYuMjkyYzAuOTIsMC40MiwxLjkwMSwwLjYyNywyLjg3NSwwLjYyN2MxLjYzMSwwLDMuMjQ0LTAuNTc2LDQuNTIzLTEuNjg1bDUxLjM4My00NC4zOTZoMTExLjU3NiAgICAgYzEyLjI2LDAsMjIuMjMtOS45NzMsMjIuMjMtMjIuMjNWNjcuMDVDNDc4LjI1LDU0Ljc5Miw0NjguMjc3LDQ0LjgyMSw0NTYuMDIsNDQuODIxeiBNMzE5LjkyMiwxMTIuMjUybC0xMC4yMDksOS45NTMgICAgIGwyLjQxLDE0LjA1NGMwLjE3NCwxLjAxNS0wLjI0MiwyLjAzOC0xLjA3NiwyLjY0M2MtMC40NjksMC4zNDItMS4wMjcsMC41MTYtMS41ODgsMC41MTZjLTAuNDI4LDAtMC44NjEtMC4xMDMtMS4yNTYtMC4zMSAgICAgbC0xMi42MjEtNi42MzVsLTEyLjYxOSw2LjYzNWMtMC45MTIsMC40NzgtMi4wMTYsMC4zOTgtMi44NDgtMC4yMDZzLTEuMjQ4LTEuNjI4LTEuMDc0LTIuNjQzbDIuNDEtMTQuMDU0bC0xMC4yMTEtOS45NTMgICAgIGMtMC43MzQtMC43MTgtMS4wMDItMS43OTItMC42ODUtMi43NjljMC4zMTctMC45NzgsMS4xNjQtMS42OTEsMi4xODMtMS44MzlsMTQuMTEtMi4wNWw2LjMxLTEyLjc4NiAgICAgYzAuNDU3LTAuOTIzLDEuMzk2LTEuNTA3LDIuNDI0LTEuNTA3czEuOTY5LDAuNTg0LDIuNDIyLDEuNTA3bDYuMzEyLDEyLjc4NmwxNC4xMDcsMi4wNWMxLjAyLDAuMTQ4LDEuODYzLDAuODYxLDIuMTg0LDEuODM5ICAgICBDMzIwLjkyNCwxMTAuNDYsMzIwLjY1OCwxMTEuNTM1LDMxOS45MjIsMTEyLjI1MnogTTM4NC43NjYsMTEyLjI1MmwtMTAuMjExLDkuOTUzbDIuNDEyLDE0LjA1NCAgICAgYzAuMTcyLDEuMDE1LTAuMjQ0LDIuMDM4LTEuMDc2LDIuNjQzYy0wLjQ2OSwwLjM0Mi0xLjAyNSwwLjUxNi0xLjU4OCwwLjUxNmMtMC40MywwLTAuODU5LTAuMTAzLTEuMjYtMC4zMWwtMTIuNjE5LTYuNjM1ICAgICBsLTEyLjYxOSw2LjYzNWMtMC45MTIsMC40NzgtMi4wMTQsMC4zOTgtMi44NDYtMC4yMDZjLTAuODM0LTAuNjA0LTEuMjUtMS42MjgtMS4wNzYtMi42NDNsMi40MS0xNC4wNTRsLTEwLjIwOS05Ljk1MyAgICAgYy0wLjczNC0wLjcxOC0xLjAwMi0xLjc5Mi0wLjY4NC0yLjc2OWMwLjMxNi0wLjk3OCwxLjE2LTEuNjkxLDIuMTgyLTEuODM5bDE0LjEwOS0yLjA1bDYuMzExLTEyLjc4NiAgICAgYzAuNDU1LTAuOTIzLDEuMzk2LTEuNTA3LDIuNDIyLTEuNTA3YzEuMDI5LDAsMS45NjcsMC41ODQsMi40MjIsMS41MDdsNi4zMTIsMTIuNzg2bDE0LjEwOSwyLjA1ICAgICBjMS4wMjEsMC4xNDgsMS44NjMsMC44NjEsMi4xODIsMS44MzlDMzg1Ljc2OCwxMTAuNDYsMzg1LjUsMTExLjUzNSwzODQuNzY2LDExMi4yNTJ6IE00NDkuNjA3LDExMi4yNTJsLTEwLjIxMSw5Ljk1MyAgICAgbDIuNDA4LDE0LjA1NGMwLjE3NiwxLjAxNS0wLjIzOCwyLjAzOC0xLjA3MiwyLjY0M2MtMC40NzEsMC4zNDItMS4wMjcsMC41MTYtMS41OSwwLjUxNmMtMC40MywwLTAuODU5LTAuMTAzLTEuMjU4LTAuMzEgICAgIGwtMTIuNjIxLTYuNjM1bC0xMi42MjEsNi42MzVjLTAuOTA4LDAuNDc4LTIuMDEyLDAuMzk4LTIuODQ0LTAuMjA2Yy0wLjgzNC0wLjYwNC0xLjI0OC0xLjYyOC0xLjA3Ni0yLjY0M2wyLjQxMi0xNC4wNTQgICAgIGwtMTAuMjExLTkuOTUzYy0wLjczNC0wLjcxOC0xLTEuNzkyLTAuNjg0LTIuNzY5YzAuMzE2LTAuOTc4LDEuMTY0LTEuNjkxLDIuMTgyLTEuODM5bDE0LjExMS0yLjA1bDYuMzExLTEyLjc4NiAgICAgYzAuNDUzLTAuOTIzLDEuMzk1LTEuNTA3LDIuNDItMS41MDdjMS4wMjcsMCwxLjk3MSwwLjU4NCwyLjQyNiwxLjUwN0w0MzQsMTA1LjU5NGwxNC4xMDksMi4wNSAgICAgYzEuMDE4LDAuMTQ4LDEuODYxLDAuODYxLDIuMTgyLDEuODM5QzQ1MC42MDksMTEwLjQ2LDQ1MC4zNDQsMTExLjUzNSw0NDkuNjA3LDExMi4yNTJ6IiBkYXRhLW9yaWdpbmFsPSIjMDAwMDAwIiBjbGFzcz0iYWN0aXZlLXBhdGgiIGRhdGEtb2xkX2NvbG9yPSIjMDAwMDAwIiBmaWxsPSIjOUZBNEE5Ii8+CgkJCTxwYXRoIGQ9Ik0xNTIuODQ0LDExMi45MjRjLTQ2Ljc2LDAtNzIuNjM5LDI0LjIzMS03Mi4xNjYsNzAuOTIxYzAuNjg2LDYzLjk0NywyNy44NTksMTAyLjc0LDcyLjE2NiwxMDIuMDYzICAgICBjMCwwLDcyLjEzMSwyLjkyNCw3Mi4xMzEtMTAyLjA2M0MyMjQuOTc1LDEzNy4xNTUsMjAwLjYwNSwxMTIuOTI0LDE1Mi44NDQsMTEyLjkyNHoiIGRhdGEtb3JpZ2luYWw9IiMwMDAwMDAiIGNsYXNzPSJhY3RpdmUtcGF0aCIgZGF0YS1vbGRfY29sb3I9IiMwMDAwMDAiIGZpbGw9IiM5RkE0QTkiLz4KCQkJPHBhdGggZD0iTTI4MC40MjgsMzM0LjQ0NGwtNzIuMDc0LTI4LjczNmwtMTYuODc3LTE0LjIyM2MtNC40NTctMy43NjYtMTEuMDQxLTMuNDg4LTE1LjE3OCwwLjYyMWwtMjMuNDYzLDIzLjMzNmwtMjMuNTMzLTIzLjM0MiAgICAgYy00LjEzNy00LjEwNC0xMC43MTMtNC4zNjktMTUuMTY0LTAuNjE1bC0xNi44ODEsMTQuMjIzbC03Mi4wNzQsMjguNzM5QzEuOTc1LDM0My42OSwxLjk5NSw0MjUuODg0LDAsNDMzLjQyN2gzMDUuNjQ2ICAgICBDMzAzLjY1Niw0MjUuOSwzMDMuNjQ2LDM0My42NzksMjgwLjQyOCwzMzQuNDQ0eiIgZGF0YS1vcmlnaW5hbD0iIzAwMDAwMCIgY2xhc3M9ImFjdGl2ZS1wYXRoIiBkYXRhLW9sZF9jb2xvcj0iIzAwMDAwMCIgZmlsbD0iIzlGQTRBOSIvPgoJCTwvZz4KCTwvZz4KPC9nPjwvZz4gPC9zdmc+Cg==',
				'show_in_nav_menus'  => true,
				'show_in_admin_bar'  => true,
				'hierarchical'       => false,
				'menu_position'      => 20,
				'supports'           => array(
					'title',
					'editor',
					'thumbnail',
				),
				'capability_type'    => 'post',
				'labels'             => $labels,
			)
		);

		register_post_type( 'spt_testimonial', $args );
	}

	/**
	 * Redirect function.
	 *
	 * @since 1.0
	 */
	public function sptfree_conditional_redirect_post_new() {
		global $_REQUEST,$pagenow;
		if ( ! empty( $_REQUEST['post_type'] ) && 'spt_testimonial_form' === $_REQUEST['post_type'] && ! empty( $pagenow ) && 'edit.php' === $pagenow ) {
			header( 'Location: ' . get_admin_url( null, 'post-new.php?post_type=spt_testimonial_form' ) );
			exit;
		}
	}

	/**
	 * Register the widget for the public-facing side of the site.
	 *
	 * The register_widget should have full path of namespace of the Widget class file.
	 *
	 * @param object $widget Widget instance.
	 *
	 * @since    2.0
	 */
	public function sp_testimonial_free_widget( $widget ) {
		register_widget( 'ShapedPlugin\TestimonialFree\Admin\Views\TFREE_Widget' );
		return $widget;
	}

}
