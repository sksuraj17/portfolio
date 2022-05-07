<?php
/**
* Hooks and defunations required for theme headers
*
* @author WPoperation
* @package arrival
*/


if(! function_exists('arrival_site_titles_text')){
	function arrival_site_titles_text(){ 
		$arrival_description 	= get_bloginfo( 'description', 'display' );

		if ( is_front_page() && is_home() ) : ?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<?php else : ?>
			<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
		<?php endif;

		if ( $arrival_description || is_customize_preview() ) : ?>
			<p class="site-description"><?php echo wp_kses_post($arrival_description); /* WPCS: xss ok. */ ?></p>
		<?php endif;

	}
}

add_action( 'arrival_main_nav','arrival_site_logo',5 );
if( ! function_exists('arrival_site_logo')){
	function arrival_site_logo(){
		$default 				= arrival_get_default_theme_options();
		$_main_nav_disable_logo = get_theme_mod('arrival_main_nav_disable_logo',$default['arrival_main_nav_disable_logo']);
		$display_header_text 	= display_header_text();
		
		if( 'yes' == $_main_nav_disable_logo ){
			return;
		}
	?>
	<div class="site-branding">
		<?php if(has_custom_logo() && $display_header_text === true ){ 
			 	the_custom_logo(); ?>
			 	<div class="text-wrapp">
			 		<?php arrival_site_titles_text(); ?>
			 	</div>
		<?php }else{

				the_custom_logo();
				arrival_site_titles_text();
			} ?>

	</div><!-- .site-branding -->
	<?php
	}
}

add_action( 'arrival_main_nav','arrival_main_nav',10 );
if( ! function_exists('arrival_main_nav')){
	function arrival_main_nav(){
		$default = arrival_get_default_theme_options();
		$arrival_main_nav_right_content = get_theme_mod('arrival_main_nav_right_content',$default['arrival_main_nav_right_content']);
		$_cart_display_position 	= get_theme_mod('arrival_cart_display_position',$default['arrival_cart_display_position']);

	?>
		<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Main menu', 'arrival' ); ?>"
				<?php if ( arrival_is_amp() ) : ?>
					[class]=" siteNavigationMenu.expanded ? 'main-navigation toggled-on' : 'main-navigation' "
				<?php endif; ?>
			>
				<?php if ( arrival_is_amp() ) : ?>
					<amp-state id="siteNavigationMenu">
						<script type="application/json">
							{
								"expanded": false
							}
						</script>
					</amp-state>
				<?php endif; ?>

				

				<div class="primary-menu-container">
					<?php

					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_id'        => 'primary-menu',
							'container'      => 'ul',
							'menu_class'	 => 'arrival-main-navigation'
						)
					);

					
					?>
				</div>
			</nav><!-- #site-navigation -->
			<?php 

			/**
			* menu last item
			*
			*/
			if( 'search' == $arrival_main_nav_right_content ){ ?>
				<div class="header-last-item search-wrap">
					<div class="search-wrap">
						<?php echo arrival_get_icon_svg('search'); ?>
					</div>
					<?php if( 'main' == $_cart_display_position ){
						do_action('arrival_header_cart_disp');
					} ?>
				</div>
			<?php }elseif( 'button' == $arrival_main_nav_right_content){ ?>
				<div class="header-last-item search-wrap header-btn">
					<?php do_action('arrival_header_cta_btn_info'); ?>
				<?php if( 'main' == $_cart_display_position ){
						do_action('arrival_header_cart_disp');
					} ?>
				</div>
			<?php }else{ ?>
				<div class="arrival-custom-element">
					<?php apply_filters('arrival_custom_item_reserve','__return_false'); ?>
				</div>
			<?php }

			
			
	}
}

//hook search form on footer if enabled
add_action('wp_footer','arrival_top_search');
if( ! function_exists('arrival_top_search')){
	function arrival_top_search(){
		$default = arrival_get_default_theme_options();
		$arrival_main_nav_right_content = get_theme_mod('arrival_main_nav_right_content',$default['arrival_main_nav_right_content']);

		if( 'search' != $arrival_main_nav_right_content ){
			return;
		}
	?>
		<div class="arrival-search-form-wrapp">
			<span class="close"></span>
			<?php get_search_form(); ?>
		</div>
	<?php 
	}
}

//get page details by page id
add_action('arrival_header_cta_btn_info','arrival_header_cta_btn_info');
if( ! function_exists('arrival_header_cta_btn_info')){
	function arrival_header_cta_btn_info(){
		$default = arrival_get_default_theme_options();
		$_main_nav_right_btn_txt = get_theme_mod('arrival_main_nav_right_btn_txt',$default['arrival_main_nav_right_btn_txt']);
		$_main_nav_right_btn_url = get_theme_mod('arrival_main_nav_right_btn_url',$default['arrival_main_nav_right_btn_url']);

		if( empty($_main_nav_right_btn_txt) ){
			return;
		}
		?>
		<a href="<?php echo esc_url($_main_nav_right_btn_url);?>" class="header-cta-btn">
		 	<?php echo esc_html($_main_nav_right_btn_txt); ?>
		 </a>
		<?php
	}
}
/**
* Top header 
*/
if( ! function_exists('arrival_top_header')){
	function arrival_top_header(){
		$prefix = 'arrival';
		$default = arrival_get_default_theme_options();
		$arrival_top_header_enable = get_theme_mod($prefix.'_top_header_enable',$default[$prefix.'_top_header_enable']);
		$_after_top_header_enable = get_theme_mod('arrival_after_top_header_enable',$default['arrival_after_top_header_enable']);
		$_cart_display_position 	= get_theme_mod('arrival_cart_display_position',$default['arrival_cart_display_position']);

	if( 'on' == $arrival_top_header_enable ){ ?>
	
	<div class="top-header-wrapp <?php echo esc_attr($_after_top_header_enable);?>">
		<div class="container op-grid-two">
		<div class="top-left-wrapp">
			<?php arrival_top_header_left(); ?>
		</div>
		<div class="top-right-wrapp">
			<?php arrival_top_header_right(); ?>
			<?php if( 'top' == $_cart_display_position ) { ?>
				<?php do_action('arrival_header_cart_disp'); ?>
			<?php } ?>
		</div>
		</div>
	</div>
	<?php
	}
	
	do_action('arrival_after_top_header_content'); //after top header contents
	}
}

//top left
add_action('arrival_top_header','arrival_top_header_left',10);
if( ! function_exists('arrival_top_header_left')){
	function arrival_top_header_left(){

		$prefix 					= 'arrival';
		$default 					= arrival_get_default_theme_options();
		$_top_left_content_type 	= get_theme_mod($prefix.'_top_left_content_type',$default[$prefix.'_top_left_content_type']);
		$arrival_top_header_email 	= get_theme_mod($prefix.'_top_header_email',$default[$prefix.'_top_header_email']);
		$arrival_top_header_phone 	= get_theme_mod($prefix.'_top_header_phone',$default[$prefix.'_top_header_phone']);
		$_top_header_txt 			= get_theme_mod($prefix.'_top_header_txt',$default[$prefix.'_top_header_txt']);

		if( 'contacts' == $_top_left_content_type ){

			if( $arrival_top_header_email ): ?>
				<div class="email-wrap">
					<?php echo arrival_get_icon_svg('email',14); ?>
					<span>
						<?php esc_html_e('Mail Us:','arrival'); ?>
						<a href="mailto:<?php echo sanitize_email($arrival_top_header_email)?>">
							<?php echo sanitize_email($arrival_top_header_email); ?>
						</a>
					</span>
				</div>
			<?php endif; ?>

			<?php if( $arrival_top_header_phone ): ?>
			<div class="phone-wrap">
				<?php echo arrival_get_icon_svg('phone',14); ?>
				<span>
					<?php esc_html_e('Call Us:','arrival'); ?>
				</span>
				<a href="<?php echo esc_url('tel:'.$arrival_top_header_phone);?>">
					<?php echo esc_html($arrival_top_header_phone); ?>
				</a>
			</div>
			<?php endif;
		}else if( 'text' == $_top_left_content_type ){ ?>
			<div class="text-wrap"><?php echo esc_html($_top_header_txt);?></div>
		<?php 
		}
	}
}

//top right
add_action('arrival_top_header','arrival_top_header_right',15);
if( ! function_exists('arrival_top_header_right')){
	function arrival_top_header_right(){

		$prefix = 'arrival';
		$default = arrival_get_default_theme_options();
		$arrival_top_right_header_content = get_theme_mod($prefix.'_top_right_header_content',$default[$prefix.'_top_right_header_content']);
		$arrival_top_right_header_menus = get_theme_mod($prefix.'_top_right_header_menus',$default[$prefix.'_top_right_header_menus']);
	
		if( 'menus' == $arrival_top_right_header_content ){
			?>
			<div class="top-nav-wrap">
				<?php 
					wp_nav_menu(
						array(
							'theme_location' => $arrival_top_right_header_menus,
							'menu_id'        => 'top-header-menu',
							'container'      => 'ul',
							'menu_class'	 => 'arrival-top-navigation',
						)
					);
				 ?>
			</div>
			<?php
		}else{
			do_action('arrival_social_icons');
		}
	}
}

/**
* After top header
* @since 1.0.8
*
*/
apply_filters('arrival_after_top_header','arrival_after_top_header');

add_action('arrival_after_top_header_content','arrival_after_top_header',5);

if(! function_exists('arrival_after_top_header')){
	function arrival_after_top_header(){
		$default = arrival_get_default_theme_options();
		$_after_top_header_enable = get_theme_mod('arrival_after_top_header_enable',$default['arrival_after_top_header_enable']);

		if( 'no' == $_after_top_header_enable ){
			return;
		}
		$sidebar_count = arrival_count_widgets('top-header-after');
		?>
		<div class="after-top-header-wrapp <?php echo esc_attr($sidebar_count);?>">
			<div class="container">
				<?php dynamic_sidebar( 'top-header-after' ); ?>
			</div>
		</div>
		<?php 
	}
}

/**
* Mobile navigation
*
*/
add_action('arrival_mob_nav','arrival_mob_nav');
if(! function_exists('arrival_mob_nav')){
	function arrival_mob_nav(){

	$default 						= arrival_get_default_theme_options();
	$arrival_main_nav_right_content = get_theme_mod('arrival_main_nav_right_content',$default['arrival_main_nav_right_content']);
	$_cart_display_position 		= get_theme_mod('arrival_cart_display_position',$default['arrival_cart_display_position']);
	$arrival_top_header_enable 		= get_theme_mod('arrival_top_header_enable',$default['arrival_top_header_enable']);

	?>
	<div class="mob-outer-wrapp <?php echo esc_attr($arrival_top_header_enable)?>">
	<div class="container clearfix">
		<?php arrival_site_logo(); ?>
		<button class="toggle toggle-wrapp">
		<span class="toggle-wrapp-inner">
			<span class="toggle-box">
			<span class="menu-toggle"></span>
			</span>
		</span>
		</button>
		
	</div>
		<div class="mob-nav-wrapp">
			<button class="toggle close-wrapp toggle-wrapp">
				<span class="text"><?php esc_html_e('Close Menu','arrival'); ?></span>
				<span class="icon-wrapp"><?php echo arrival_get_icon_svg('cross',18); ?></span>
			</button>
			<nav  class="avl-mobile-wrapp clear clearfix" arial-label="Mobile" role="navigation" tabindex="1">
				<?php 
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'container'      => 'ul',
						'show_toggles'   => true,
						'menu_class'	 => 'mob-primary-menu clear'
					)
				);
				?>
				<?php
				if( 'search' == $arrival_main_nav_right_content ){ ?>
					<div class="header-last-item search-wrap">
						<div class="search-wrap">
							<?php echo arrival_get_icon_svg('search'); ?>
						</div>
						<?php if( 'main' == $_cart_display_position ){
							do_action('arrival_header_cart_disp');
						} ?>
					</div>
				<?php }elseif( 'button' == $arrival_main_nav_right_content){ ?>
				<div class="header-last-item search-wrap header-btn">
					<?php do_action('arrival_header_cta_btn_info'); ?>
					
					<?php if( 'main' == $_cart_display_position ){
							do_action('arrival_header_cart_disp');
					} ?>
				</div>
				<?php } 
				do_action('arrival_social_icons'); ?>
		</nav>
		<div class="menu-last"></div>
		</div>


	</div>
<?php
	}
}

/**
* All header wrapp inside a function
*
*/
add_action('arrival_main_header_wrapp','arrival_main_header_wrapp');
if( ! function_exists('arrival_main_header_wrapp')){
	function arrival_main_header_wrapp(){
		$default 					= arrival_get_default_theme_options();
		$_page_header_layout 		= get_theme_mod('arrival_page_header_layout',$default['arrival_page_header_layout']);
		$arrival_top_header_enable 	= get_theme_mod('arrival_top_header_enable',$default['arrival_top_header_enable']);
		$arrival_main_nav_layout 	= get_theme_mod('arrival_main_nav_layout',$default['arrival_main_nav_layout']);
		$_menu_hover_styles 		= get_theme_mod('arrival_menu_hover_styles',$default['arrival_menu_hover_styles']);
		$_main_nav_disable_logo 	= get_theme_mod('arrival_main_nav_disable_logo',$default['arrival_main_nav_disable_logo']);
		$arrival_main_nav_right_content = get_theme_mod('arrival_main_nav_right_content',$default['arrival_main_nav_right_content']);
		$_transparent_header_enable 	= get_theme_mod('arrival_transparent_header_enable',$default['arrival_transparent_header_enable']);
		$_breadcrumb_enable 			= get_theme_mod('arrival_breadcrumb_enable',$default['arrival_breadcrumb_enable']);

		if( $_transparent_header_enable == true ){
			$transparent_hdr = 'arrival-transparent-header';
		}else{
			$transparent_hdr = '';
		}

		$hdr_class = 'seperate-breadcrumb';
		if( $_page_header_layout == 'default' ){
			$hdr_class = 'hdr-breadcrumb';
		}else if( $_page_header_layout == 'layout-two' && $_breadcrumb_enable == 'no' ){
			$hdr_class = 'hdr-breadcrumb breadcrumb-off';
		}

		if( 'empty' == $arrival_main_nav_right_content ){
			$arrival_main_nav_right_content = 'yes';
		}

		$enabled_settings = array(
			$_main_nav_disable_logo,
			$arrival_main_nav_right_content,
		);
		
		$grid_class = 'op-grid-three';
		if( ('yes' == $_main_nav_disable_logo)  && ('none' == $arrival_main_nav_right_content) ){
			$grid_class = 'op-grid-one';
		}elseif( ('yes' == $_main_nav_disable_logo) && ('none' != $arrival_main_nav_right_content) ){
			$grid_class = 'op-grid-two';
		}elseif( ('yes' == $_main_nav_disable_logo) || ('none' == $arrival_main_nav_right_content) ) {
			$grid_class = 'op-grid-two';
		}
		
		$grid_class_filter = apply_filters('arrival_header_main_grid_filter',$grid_class);

		?>
		<header id="masthead" class="site-header <?php echo esc_attr($hdr_class.' '.$_menu_hover_styles.' '.$transparent_hdr);?>">
			<?php do_action('arrival_mob_nav'); ?>
			<?php if( function_exists('arrival_top_header')):
				arrival_top_header();
			endif; ?>
			
			<?php if ( has_header_image() ) : ?>
				<figure class="header-image">
					<?php the_header_image_tag(); ?>
				</figure>
			<?php endif; ?>

			

			<div class="main-header-wrapp <?php echo esc_attr($arrival_main_nav_layout.' '.$arrival_top_header_enable)?>">
				<div class="container <?php echo esc_attr($grid_class_filter);?>">
				<?php do_action('arrival_main_nav'); ?>
				</div>
			</div>

			<?php if( $_page_header_layout == 'default' && $_breadcrumb_enable == 'yes' ){
				
				arrival_header_title_display();

			}?>
			
		</header><!-- #masthead -->
		<?php 
	}
}


/**
* Header cart icon
* @since 1.1.0
*/
add_action('arrival_header_cart_disp','arrival_header_cart_disp');
function arrival_header_cart_disp(){
	$default 					= arrival_get_default_theme_options();
	$_cart_display_position 	= get_theme_mod('arrival_cart_display_position',$default['arrival_cart_display_position']);

	if( 'none' == $_cart_display_position ){
		return;
	}

	if( class_exists('woocommerce') ) { ?>
		<div class="cart-wrapper"><?php arrival_header_cart(); ?></div>
	<?php }
}