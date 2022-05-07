<?php

if (!class_exists('TSSTemplate')):

    /**
     *
     */
    class TSSTemplate {

        function __construct()
        {            
            add_action('wp_enqueue_scripts', array($this, 'loadTemplateScript'));
        } 

        public function loadTemplateScript()
        {
            if (get_post_type() == TSSPro()->post_type || is_post_type_archive(TSSPro()->post_type)) {
                wp_enqueue_style(array(
                    'tlp-fontawsome',
                    'tlp-owl-carousel-css',
                    'tlp-owl-carousel-theme-css',
                    'rt-tpg-css'
                ));
                wp_enqueue_script(array(
                    'jquery',
                    'tlp-bootstrap-js',
                    'tlp-image-load-js',
                    'tlp-owl-carousel-js',
                    'tlp-team-js'
                ));
            }
        }


    }

endif;
