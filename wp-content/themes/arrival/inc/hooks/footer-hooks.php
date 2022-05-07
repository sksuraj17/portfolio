<?php
/**
* Functions and definations required for theme footer
*
*/

//footer widgets
add_action('arrival_footer_section','arrival_theme_footer_widgets',10);
if( ! function_exists('arrival_theme_footer_widgets')){
	function arrival_theme_footer_widgets(){
		$defaults = arrival_get_default_theme_options();
		$arrival_footer_widget_enable = get_theme_mod('arrival_footer_widget_enable',$defaults['arrival_footer_widget_enable']);

		if( $arrival_footer_widget_enable == 'no' ){
			return;
		}

		if ( is_active_sidebar( 'footer-4' ) ) {
			$widget_columns = apply_filters( 'arrival_footer_widget_regions', 4 );
		}
		elseif ( is_active_sidebar( 'footer-3' ) ) {
			$widget_columns = apply_filters( 'arrival_footer_widget_regions', 3 );
		} elseif ( is_active_sidebar( 'footer-2' ) ) {
			$widget_columns = apply_filters( 'arrival_footer_widget_regions', 2 );
		} elseif ( is_active_sidebar( 'footer-1' ) ) {
			$widget_columns = apply_filters( 'arrival_footer_widget_regions', 1 );
		} else {
			$widget_columns = apply_filters( 'arrival_footer_widget_regions', 0 );
		}


	if ( $widget_columns > 0 ) : ?>
		<div class="footer-widget-wrapper clearfix col-<?php echo esc_attr($widget_columns);?>">
			<?php 
			$i = 0; 
			while ( $i < $widget_columns ) : 
			$i++;  
			if ( is_active_sidebar( 'footer-' . $i ) ) : ?>		
				<div class=" ftr-widget footer-<?php echo intval( $i ); ?>">
		        	<?php dynamic_sidebar( 'footer-' . intval( $i ) ); ?>
				</div>		
		    <?php endif; ?>		
			<?php endwhile; ?>
		</div>
	<?php
	endif;

	}
}

/*
* Bottom footer section
*
*/
add_action('arrival_footer_section','arrival_btm_footer',15);
if(! function_exists('arrival_btm_footer')){
	function arrival_btm_footer(){

		$defaults = arrival_get_default_theme_options();
		$_footer_copyright_text = get_theme_mod('arrival_footer_copyright_text');
		$_footer_icons_enable 	= get_theme_mod('arrival_footer_icons_enable',$defaults['arrival_footer_icons_enable']);
		$_footer_copyright_border_top = get_theme_mod('arrival_footer_copyright_border_top',$defaults['arrival_footer_copyright_border_top']);
		
		$footer_border = ($_footer_copyright_border_top == true) ? 'border-enable' : '';
		$ftr_def_text_value = apply_filters('arrival_footer_credit_texts','__return_true' );
	?>
	<div class="footer-btm <?php echo esc_attr($footer_border);?>">
		<div class="site-info">
			<?php if($_footer_copyright_text){ ?>
				<span class="cppyright-text"><?php echo wp_kses_post(do_shortcode($_footer_copyright_text)); ?></span>
			<?php }else{ ?>
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'arrival' ) ); ?>">
				<?php
				/* translators: %s: CMS name, i.e. WordPress. */
				printf( esc_html__( 'Proudly powered by %s', 'arrival' ), 'WordPress' );
				?>
			</a>
			<?php } 
			
			if( $ftr_def_text_value == true ): ?>

			<span class="sep"> | </span>
			<?php echo esc_html__('Theme: Arrival by','arrival'); ?>
			<a href="<?php echo esc_url( __('https://wpoperation.com/','arrival') )?>">
				<?php echo esc_html__('WPoperation','arrival'); ?>
			</a>

			<?php endif; ?>

		</div><!-- .site-info -->
		
		<?php if( $_footer_icons_enable == 'yes' ){ ?>
		<div class="social-icons-wrapp">
			<?php do_action('arrival_social_icons'); ?>
		</div>
		<?php } ?>

	</div><!-- .footer-btm -->
	<?php 
	}
}

/**
* Theme footer main contents
*
*/
add_action('arrival_footer_contents','arrival_footer_contents',10);
if(! function_exists('arrival_footer_contents')){
	function arrival_footer_contents(){
	?>
	<footer id="colophon" class="site-footer">
		<div class="container">
			<?php do_action('arrival_footer_section'); ?>
		</div>
	</footer><!-- #colophon -->
	<?php 
	}
}

/**
* Scroll to top 
*
*/
add_action('arrival_footer_contents','arrival_scroll_to_top',15);
if( ! function_exists('arrival_scroll_to_top')){
	function arrival_scroll_to_top(){

		$scroll_enable = apply_filters('arrival_scroll_to_top','__return_true');

		if( $scroll_enable == false ){
			return;
		}
	?>
	<div class="scroll-top-top">
		<?php echo arrival_get_icon_svg('angle_up'); ?>
	</div>
	<?php 
	}
}