<div class="operation-theme-steps-list">
<div class="left-box-wrapper-outer">
<div class="op-box-wrapper operation-welcome-box-white">
	<div class="op-box-header"><?php esc_html_e('Links to Customizer Settings','arrival'); ?></div>
	<div class="op-box-content">
		<ul class="op-list clearfix">
			<?php
			 $url = admin_url( 'customize.php' );

	        $links = array(
	            array(
	                'label' => __( 'Logo & Site Identity', 'arrival' ),
	                'url' 	=> add_query_arg( array( 'autofocus' => array( 'section' => 'title_tagline' ) ), $url ),
	                'icon' 	=> 'dashicons dashicons-format-image',
	            ),
	            array(
	                'label' => __( 'Header Options', 'arrival' ),
	                'url' 	=> add_query_arg( array( 'autofocus' => array( 'section' => 'arrival_main_header_options_panel' ) ), $url ),
	                'icon' 	=> 'dashicons dashicons-align-center',
	            ),
	            array(
	                'label' => __( 'Breadcrumb Settings', 'arrival' ),
	                'url' 	=> add_query_arg( array( 'autofocus' => array( 'section' => 'arrival_breadcrumb_potions' ) ), $url ),
	                'icon' 	=> 'dashicons dashicons-layout',
	            ),
	            array(
	                'label' => __( 'General Styles', 'arrival' ),
	                'url' 	=> add_query_arg( array( 'autofocus' => array( 'section' => 'arrival_general_styling_section' ) ), $url ),
	                'icon' 	=> 'dashicons dashicons-admin-customizer',
	            ),
	            array(
	                'label' => __( 'General Settings', 'arrival' ),
	                'url' 	=> add_query_arg( array( 'autofocus' => array( 'section' => 'arrival_general_setting_section' ) ), $url ),
	                'icon' 	=> 'dashicons dashicons-admin-generic',
	            ),
	            array(
	                'label' => __( 'Blog Settings', 'arrival' ),
	                'url' 	=> add_query_arg( array( 'autofocus' => array( 'section' => 'arrival_blog_settings' ) ), $url ),
	                'icon' 	=> 'dashicons dashicons-welcome-write-blog',
	            ),
	            array(
	                'label' => __( 'Social Icons', 'arrival' ),
	                'url' 	=> add_query_arg( array( 'autofocus' => array( 'section' => 'arrival_social_icons_section' ) ), $url ),
	                'icon' 	=> 'dashicons dashicons-share',
	            ),
	            array(
	                'label' => __( 'Footer Settings', 'arrival' ),
	                'url' 	=> add_query_arg( array( 'autofocus' => array( 'section' => 'arrival_footer_settings' ) ), $url ),
	                'icon' 	=> 'dashicons dashicons-admin-generic',
	            ),
	           
	        );

	        $links = apply_filters( 'arrival/dashboard/links', $links );
	        ?> 

			<?php foreach( $links as $l ) { ?>
                <li>
                	<span class="<?php echo esc_attr($l['icon'])?>"></span>
                    <a class="op-quick-setting-link" href="<?php echo esc_url( $l['url'] ); ?>" target="_blank"><?php echo esc_html( $l['label'] ); ?></a>
                </li>
            <?php } ?>
		</ul>
	</div>
</div>

<div class="op-box-wrapper operation-welcome-box-white">
	<div class="op-box-header"><?php esc_html_e('Welcome','arrival'); ?></div>
	<div class="box-content">
		<p><?php esc_html_e('Welcome and thank you for choosing Arrival. Please install and activate all recommended plugins.','arrival'); ?></p>
	</div>
</div>	
</div>


<?php $this->admin_sidebar_contents(); ?>

</div>