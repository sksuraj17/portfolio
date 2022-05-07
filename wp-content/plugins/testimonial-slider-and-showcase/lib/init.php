<?php
if ( ! class_exists( 'TSSPro' ) ) {
	class TSSPro {
		public $post_type;
		public $shortCodePT;
		public $taxonomies;
		public $preSettings;

		protected static $_instance;

		function __construct() {
			$this->options        = array(
				'settings'          => 'tss_settings',
				'version'           => TSS_VERSION,
				'installed_version' => 'tss_installed_version',
				'flash'             => 'tss_flash'
			);
			$this->shortCodePT    = "tss-sc";
			$settings             = get_option( $this->options['settings'] );
			$this->post_type      = 'testimonial';
			$this->post_type_slug = ! empty( $settings['slug'] ) ? sanitize_title_with_dashes( $settings['slug'] ) : 'testimonial';
			$this->taxonomies     = array(
				'category' => $this->post_type . "-category",
				'tag'      => $this->post_type . "-tag",
			);
			$this->incPath        = dirname( __FILE__ );
			$this->proPath = untrailingslashit(plugin_dir_path(TSS_PLUGIN_ACTIVE_FILE_NAME)).'-pro';
			$this->functionsPath  = $this->incPath . '/functions/';
			$this->classesPath    = $this->incPath . '/classes/';
			$this->widgetsPath    = $this->incPath . '/widgets/';
			$this->viewsPath      = $this->incPath . '/views/';
			$this->templatePath   = $this->incPath . '/templates/';
			$this->proTemplatesPath = $this->proPath . '/templates/';
			$this->modelsPath     = $this->incPath . '/models/';

			$this->assetsUrl = TSS_PLUGIN_URL . '/assets/';
			$this->loadModel( $this->modelsPath );
			$this->loadClass( $this->classesPath );
			$this->preSettings = array(
				'slug'        => 'testimonial',
				'field'       => array(
					'client_name',
					'project_url',
					'completed_date',
					'tools',
					'categories',
					'tags'
				),
				'form_fields' => array(
					'tss_designation',
					'tss_company',
					'tss_location',
					'tss_rating',
					'tss_video',
					'tss_social_media'
				),
                'notification_email'=> get_option('admin_email')
			);

			do_action('rtts_loaded');
		}

		/**
		 * Load Model class
		 *
		 * @param $dir
		 */
		function loadModel( $dir ) {
			if ( ! file_exists( $dir ) ) {
				return;
			}
			foreach ( scandir( $dir ) as $item ) {
				if ( preg_match( "/.php$/i", $item ) ) {
					require_once( $dir . $item );
				}
			}
		}

		public function pro_version_link() {
			$proUrl = esc_url('https://www.radiustheme.com/downloads/wp-testimonial-slider-showcase-pro-wordpress/');
			return $proUrl ; 
		}

		public function demo_home_page_link() {
			$proUrl = esc_url('https://www.radiustheme.com/demo/plugins/testimonial-slider/');
			return $proUrl ; 
		}


		public function documentation_link() {
			$proUrl = esc_url('https://www.radiustheme.com/setup-wp-testimonials-slider-showcase-wordpress/');
			return $proUrl ; 
		}

		function loadClass( $dir ) {
			if ( ! file_exists( $dir ) ) {
				return;
			}

			$classes = array();

			foreach ( scandir( $dir ) as $item ) {
				if ( preg_match( "/.php$/i", $item ) ) {
					require_once( $dir . $item );
					$className = str_replace( ".php", "", $item );
					$classes[] = new $className;
				}
			}

			if ( $classes ) {
				foreach ( $classes as $class ) {
					$this->objects[] = $class;
				}
			}
		}

		function loadWidget( $dir ) {
			if ( ! file_exists( $dir ) ) {
				return;
			}
			foreach ( scandir( $dir ) as $item ) {
				if ( preg_match( "/.php$/i", $item ) ) {
					require_once( $dir . $item );
					$class = str_replace( ".php", "", $item );

					if ( method_exists( $class, 'register_widget' ) ) {
						$caller = new $class;
						$caller->register_widget();
					} else {
						register_widget( $class );
					}
				}
			}
		}


        /**
         * @param $viewName
         * @param array $args
         * @param bool $return
         * @return string|void
         */
        function render_view($viewName, $args = array(), $return = false ) {
            $path     = str_replace( ".", "/", $viewName );
            $viewPath = $this->viewsPath . $path . '.php';
            if ( ! file_exists( $viewPath ) ) {
                return;
            }
            if ( $args ) {
                extract( $args );
            }
            if ( $return ) {
                ob_start();
                include $viewPath;

                return ob_get_clean();
            }
            include $viewPath;
        }

        /**
         * @param $viewName
         * @param array $args
         * @param bool $return
         * @return string|void
         */
        function render($viewName, $args = array(), $return = true ) {

            $path = str_replace( ".", "/", $viewName );
            if ( $args ) {
                extract( $args );
            }
            $template = array(
                "testimonial-slider-showcase/{$path}.php"
            );

			$pro_path = $this->proTemplatesPath . $viewName . '.php';
			if ( locate_template($template) ) {
				$template_file = locate_template($template);
			} else if ( function_exists( 'rttsp' ) && file_exists($pro_path) ) {
				$template_file = $pro_path;
			} else {
				$template_file = $this->templatePath . $path . '.php';
			}  

            if ( ! file_exists( $template_file ) ) {
                return;
            }
            if ( $return ) {

                ob_start();
                include $template_file;

                return ob_get_clean();
            } else {

                include $template_file;
            }
        } 

		/**
		 * Dynamicaly call any  method from models class
		 * by pluginFramework instance
		 */
		function __call( $name, $args ) {
			if ( ! is_array( $this->objects ) ) {
				return;
			}
			foreach ( $this->objects as $object ) {
				if ( method_exists( $object, $name ) ) {
					$count = count( $args );
					if ( $count == 0 ) {
						return $object->$name();
					} elseif ( $count == 1 ) {
						return $object->$name( $args[0] );
					} elseif ( $count == 2 ) {
						return $object->$name( $args[0], $args[1] );
					} elseif ( $count == 3 ) {
						return $object->$name( $args[0], $args[1], $args[2] );
					} elseif ( $count == 4 ) {
						return $object->$name( $args[0], $args[1], $args[2], $args[3] );
					} elseif ( $count == 5 ) {
						return $object->$name( $args[0], $args[1], $args[2], $args[3], $args[4] );
					} elseif ( $count == 6 ) {
						return $object->$name( $args[0], $args[1], $args[2], $args[3], $args[4], $args[5] );
					}
				}
			}
		}

		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}
	}

	function TSSPro() {
		return TSSPro::instance();
	}

	TSSPro();
}