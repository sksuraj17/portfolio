<?php
/**
 * Install demos page
 *
 * @package WOPDI
 * @category Core
 * @author WPoperation
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
class WPOP_Install_Demos {

	/**
	 * Start things up
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_page' ), 999 );
	}

	/**
	 * Add sub menu page for the custom CSS input
	 *
	 * @since 1.0.0
	 */
	public function add_page() {


		$title = '<span style="color: #00b7ea">' . esc_html__( 'Import Demos', 'wpop-demo-importer' ) . '</span>';

		add_submenu_page(
			'themes.php',
			esc_html__( 'WPOP Demo Import', 'wpop-demo-importer' ),
			$title,
			'manage_options',
			'wpop-install-demos',
			array( $this, 'create_admin_page' )
		);
	}

	/**
	 * Settings page output
	 *
	 * @since 1.0.0
	 */
	public function create_admin_page() {

		// Theme branding
		$theme = wp_get_theme();
		$brand = $theme->name; ?>

		<div class="wpop-demo-wrap wrap">

			<h2><?php echo esc_attr( $brand ); ?> - <?php esc_attr_e( 'Install Demos', 'wpop-demo-importer' ); ?></h2>

			<div class="theme-browser rendered">

				<?php
				// Vars
				$demos = WPOP_Demos::get_demos_data();
				$categories = WPOP_Demos::get_demo_all_categories( $demos ); ?>

				<?php if ( ! empty( $categories ) ) : ?>
					<div class="wpop-header-bar">
						<nav class="wpop-navigation">
							<ul>
								<li class="active"><a href="#all" class="wpop-navigation-link"><?php esc_html_e( 'All', 'wpop-demo-importer' ); ?></a></li>
								<?php foreach ( $categories as $key => $name ) : ?>
									<li><a href="#<?php echo esc_attr( $key ); ?>" class="wpop-navigation-link"><?php echo esc_html( $name ); ?></a></li>
								<?php endforeach; ?>
							</ul>
						</nav>
						<div clas="wpop-search">
							<input type="text" class="wpop-search-input" name="wpop-search" value="" placeholder="<?php esc_html_e( 'Search demos...', 'wpop-demo-importer' ); ?>">
						</div>
					</div>
				<?php endif; ?>

				<div class="themes wp-clearfix">

					<?php
					// Loop through all demos
					foreach ( $demos as $demo => $key ) {
						if(class_exists('Arrival_Companion') && get_stylesheet()=='arrival'){
							$theme = 'arrival-pro';
						}else{
							$theme = get_stylesheet();
						}
                        $image_path = 'https://raw.githubusercontent.com/wpoperation/'.$theme.'-demo-data/master/'.$demo.'/screenshot.png';
						// Vars
						$item_categories = WPOP_Demos::get_demo_item_categories( $key );
						$demo_slug = WPOP_Demos::get_demos_data()[ $demo ];
                        $preview_url = isset($demo_slug['preview_url']) ? $demo_slug['preview_url'] : '#';
                        $is_pro = isset($demo_slug['is_premium']) ? $demo_slug['is_premium'] : false;
						$opt_id = 'theme_mods_'.get_stylesheet();
						$options = get_option($opt_id);
						if (!empty($options[$demo])) {
				            $imported_class = 'imported';
				            $status = __( 'Imported', 'wpop-demo-importer' );
						}elseif($is_pro == true){
							$imported_class = 'imported';
							$status = __( 'Pro', 'wpop-demo-importer' );
						}else{
				            $imported_class = 'not-imported';
				            $status = __( 'Not Imported', 'wpop-demo-importer' );
						}
						
                        ?>
						<div class="theme-wrap <?php echo esc_attr($imported_class);?>" data-categories="<?php echo esc_attr( $item_categories ); ?>" data-name="<?php echo esc_attr( strtolower( $demo ) ); ?>">
                            
							<div class="theme wpop-open-popup" data-demo-id="<?php echo esc_attr( $demo ); ?>">

								<div class="theme-screenshot">
									<div class="wpop-tag"><?php echo $status;?></div>
									<img src="<?php echo esc_url( $image_path ); ?>" />
									<div class="import-now button button-primary"><?php _e( 'Import', 'wpop-demo-importer' )?></div>

									<div class="demo-import-loader preview-all preview-all-<?php echo esc_attr( $demo ); ?>"></div>

									<div class="demo-import-loader preview-icon preview-<?php echo esc_attr( $demo ); ?>"><i class="custom-loader"></i></div>
								</div>

								<div class="theme-id-container">
		
									<h2 class="theme-name" id="<?php echo esc_attr( $demo ); ?>"><span><?php echo ucwords( $demo ); ?></span></h2>

									<div class="theme-actions">
										<a class="button button-primary" href="<?php echo esc_url( $preview_url ); ?>" target="_blank"><?php _e( 'Live Preview', 'wpop-demo-importer' ); ?></a>
									</div>

								</div>

							</div>

						</div>

					<?php } ?>

				</div>

			</div>

		</div>

	<?php }
}
new WPOP_Install_Demos();