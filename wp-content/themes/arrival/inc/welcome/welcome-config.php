<?php
	/**
	 * Welcome Page Initiation
	*/

	include get_template_directory() . '/inc/welcome/welcome.php';

	/** Plugins **/
	$plugins = array(
		// *** Companion Plugins
		'companion_plugins' => array(),

		// *** Required Plugins
		'required_plugins' => array(
			'operation-demo-importer' => array(
				'slug' => 'operation-demo-importer',
				'name' => esc_html__('Operation Demo Importer', 'arrival'),
				'filename' =>'operation-demo-importer.php',
				'host_type' => 'wordpress', // Use either bundled, remote, wordpress
				'class' => 'WOPDI',
				'info' => esc_html__('Adds ability to theme with one click demo import feature, which will help to publish your websies within few minutes.', 'arrival'),
			),
		
		),

		// *** Recommended Plugins
		'recommended_plugins' => array(
			// Free Plugins
			'free_plugins' => array(

				'ultra-companion' => array(
					'slug' 		=> 'ultra-companion',
					'filename' 	=> 'ultra-companion.php',
					'class' 	=> 'Ultra_Companion'
				),

				'elementor' => array(
					'slug' 		=> 'elementor',
					'filename' 	=> 'elementor.php',
					'class' 	=> 'Elementor\Plugin'
				),

				'wpop-elementor-addons' => array(
					'slug' 		=> 'wpop-elementor-addons',
					'filename' 	=> 'wpop-elementor-addons.php',
					'class' 	=> 'Wpop_El_Addons'
				),
				
			),

			// Pro Plugins
			'pro_plugins' => array(
			)
		),
	);

	$strings = array(
		// Welcome Page General Texts
		'welcome_menu_text' 		=> esc_html__( 'Arrival Setup', 'arrival' ),
		'theme_short_description' 	=> esc_html__( 'Fast &nbsp; | &nbsp; Light  &nbsp; | &nbsp; Powerful', 'arrival' ),

		// Plugin Action Texts
		'install_n_activate' 	=> esc_html__('Install and Activate', 'arrival'),
		'deactivate' 			=> esc_html__('Deactivate', 'arrival'),
		'activate' 				=> esc_html__('Activate', 'arrival'),

		// Recommended Plugins Section
		'pro_plugin_title' 			=> esc_html__( 'Pro Plugins', 'arrival' ),
		'pro_plugin_description' 	=> esc_html__( 'Take Advantage of some of our Premium Plugins.', 'arrival' ),
		'free_plugin_title' 		=> esc_html__( 'Free Plugins', 'arrival' ),
		'free_plugin_description' 	=> esc_html__( 'These Free Plugins might be handy for you.', 'arrival' ),

		// Demo Actions
		'activate_btn' 		=> esc_html__('Activate', 'arrival'),
		'installed_btn' 	=> esc_html__('Activated', 'arrival'),
		'demo_installing' 	=> esc_html__('Installing Demo', 'arrival'),
		'demo_installed' 	=> esc_html__('Demo Installed', 'arrival'),
		'demo_confirm' 		=> esc_html__('Are you sure to import demo content ?', 'arrival'),
		'doc_link'			=> 'https://wpoperation.com/wp-documentation/arrival/',

		//free vs pro
		'free_vs_pro' => array(

            'features' => array(
                'Preloader Options' => array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
                'Remove Footer Copyright' => array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
                'Sticky Header'=> array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
                'Maintenance Mode'=> array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
                'Custom Elementor Addons'=> array('5+','25+'),
                'Site Header Options'=> array('Simple','Highly customizable with different navigation layouts'),
                'Typography Style & Colors' => array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
                'Unlimited Header and Footer Builder' => array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
                'Lazy Load Images' => array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
                'Newsletter Popup' => array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
                'Responsive Layout' => array('Yes', 'Yes', 'dashicons-yes', 'dashicons-yes'),
                'Translations Ready' => array('Yes', 'Yes', 'dashicons-yes', 'dashicons-yes'),
                'SEO' => array('Optimized', 'Optimized'),
                'Support' => array('Yes', 'High Priority Dedicated Support')
            ),
        ),


	);

	/**
	 * Initiating Welcome Page
	*/
	$my_theme_wc_page = new Arrival_Welcome( $plugins, $strings );
