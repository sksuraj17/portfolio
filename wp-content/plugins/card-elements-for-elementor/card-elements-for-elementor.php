<?php
/**
 * Plugin Name: Card Elements for Elementor
 * Description: Showcase useful card elements like display team profiles, testimonials and post with card style for Elementor page builder.
 * Plugin URI: https://www.techeshta.com/product/card-elements-for-elementor/
 * Author: Techeshta
 * Version: 1.1.5
 * Author URI: https://www.techeshta.com
 *
 * Text Domain: card-elements-for-elementor
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Define Plugin URL and Directory Path
 */
define('CARD_ELEMENTS_ELEMENTOR_URL', plugins_url('/', __FILE__));  // Define Plugin URL
define('CARD_ELEMENTS_ELEMENTOR_PATH', plugin_dir_path(__FILE__));  // Define Plugin Directory Path
define('CEE_DOMAIN', 'card-elements-for-elementor');

/*
 * Load the plugin Category
 */
require_once CARD_ELEMENTS_ELEMENTOR_PATH . 'widgets/elementor-helper.php';

/*
 * Register the widgtes file in elementor widgtes.
 */
if (!function_exists('card_elements_widget_register')) {

    function card_elements_widget_register() {
        require_once CARD_ELEMENTS_ELEMENTOR_PATH . 'widgets/profile-card-widget.php';
        require_once CARD_ELEMENTS_ELEMENTOR_PATH . 'widgets/testimonial-card-widget.php';
        require_once CARD_ELEMENTS_ELEMENTOR_PATH . 'widgets/post-card-widget.php';
        require_once CARD_ELEMENTS_ELEMENTOR_PATH . 'include/post-card/functions-post-card.php';
    }

}
add_action('elementor/widgets/widgets_registered', 'card_elements_widget_register');

/*
 * Load profile card scripts and styles
 * @since v1.0.0
 */
if (!function_exists('card_elements_widget_script_register')) {

    function card_elements_widget_script_register() {
        wp_register_style('cee-common-card-style', CARD_ELEMENTS_ELEMENTOR_URL . 'assets/css/common-card-style.css', false);
        wp_enqueue_style('cee-common-card-style');

        wp_register_style('cee-profile-card-style', CARD_ELEMENTS_ELEMENTOR_URL . 'assets/css/profile-card-style.css', false);
        wp_enqueue_style('cee-profile-card-style');

        wp_register_style('cee-testimonial-card-style', CARD_ELEMENTS_ELEMENTOR_URL . 'assets/css/testimonial-card-style.css', false);
        wp_enqueue_style('cee-testimonial-card-style');

        wp_register_style('cee-post-card-style', CARD_ELEMENTS_ELEMENTOR_URL . 'assets/css/post-card-style.css', false);
        wp_enqueue_style('cee-post-card-style');

        // Register and call font awesome style
        wp_register_style('cee-font-awesome', CARD_ELEMENTS_ELEMENTOR_URL . 'assets/css/font-awesome.css');
        wp_enqueue_style('cee-font-awesome');
    }

}
add_action('wp_enqueue_scripts', 'card_elements_widget_script_register');

/*
* Load elementor editor script and styles
*/
if (!function_exists('cee_elements_widget_script_backend')) {

    function cepe_elements_widget_script_backend() {
        wp_register_style('cee-font-awesome', CEPE_URL . 'assets/css/font-awesome.css');
        wp_enqueue_style('cee-font-awesome');
    }

}
add_action('elementor/editor/after_enqueue_scripts', 'cee_elements_widget_script_backend');

/**
 * Check current version of Elementor
 */
if (!function_exists('card_elements_plugin_load')) {

    function card_elements_plugin_load() {
        // Load plugin textdomain
        load_plugin_textdomain('CEE_DOMAIN');

        // Add image size for post card
        add_image_size('post_card_thumb', 680, 460, true);

        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', 'card_elements_widget_fail_load');
            return;
        }
        $elementor_version_required = '1.1.2';
        if (!version_compare(ELEMENTOR_VERSION, $elementor_version_required, '>=')) {
            add_action('admin_notices', 'card_elements_elementor_update_notice');
            return;
        }
    }

}
add_action('plugins_loaded', 'card_elements_plugin_load');

/**
 * This notice will appear if Elementor is not installed or activated or both
 */
if (!function_exists('card_elements_widget_fail_load')) {

    function card_elements_widget_fail_load() {
        $screen = get_current_screen();
        if (isset($screen->parent_file) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id) {
            return;
        }

        $plugin = 'elementor/elementor.php';

        if (card_elements_elementor_installed()) {
            if (!current_user_can('activate_plugins')) {
                return;
            }
            $activation_url = wp_nonce_url('plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin);

            $message = '<p>' . __('<strong>Card Elements<strong> widgets not working because you need to activate the Elementor plugin.', CEE_DOMAIN) . '</p>';
            $message .= '<p>' . sprintf('<a href="%s" class="button-primary">%s</a>', $activation_url, __('Activate Elementor Now', CEE_DOMAIN)) . '</p>';
        } else {
            if (!current_user_can('install_plugins')) {
                return;
            }

            $install_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=elementor'), 'install-plugin_elementor');

            $message = '<p>' . __('<strong>Card Elements</strong> widgets not working because you need to install the Elemenor plugin', CEE_DOMAIN) . '</p>';
            $message .= '<p>' . sprintf('<a href="%s" class="button-primary">%s</a>', $install_url, __('Install Elementor Now', CEE_DOMAIN)) . '</p>';
        }

        echo '<div class="error"><p>' . $message . '</p></div>';
    }

}

/**
 * Display admin notice for Elementor update if Elementor version is old
 */
if (!function_exists('card_elements_elementor_update_notice')) {

    function card_elements_elementor_update_notice() {
        if (!current_user_can('update_plugins')) {
            return;
        }

        $file_path = 'elementor/elementor.php';

        $upgrade_link = wp_nonce_url(self_admin_url('update.php?action=upgrade-plugin&plugin=') . $file_path, 'upgrade-plugin_' . $file_path);
        $message = '<p>' . __('<strong>Card Elements</strong> widgets not working because you are using an old version of Elementor.', CTW_DOMAIN) . '</p>';
        $message .= '<p>' . sprintf('<a href="%s" class="button-primary">%s</a>', $upgrade_link, __('Update Elementor Now', CTW_DOMAIN)) . '</p>';
        echo '<div class="error">' . $message . '</div>';
    }

}

/**
 * Action when plugin installed
 */
if (!function_exists('card_elements_elementor_installed')) {

    function card_elements_elementor_installed() {

        $file_path = 'elementor/elementor.php';
        $installed_plugins = get_plugins();

        return isset($installed_plugins[$file_path]);
    }

}

/**
 * Add reviews metadata  on plugin activation
 */
if (!function_exists('card_elements_plugin_activation')) {

    function card_elements_plugin_activation() {
        $notices = get_option('card_elements_reviews', array());
        $notices[] = '<p>Hi, you are now using <strong>Card Elements</strong> plugin. I would really appreciate it if you could give me the five star to our plugin. </p><p><a href="https://wordpress.org/support/plugin/card-elements-for-elementor/reviews/?filter=5#new-post" target="_blank" class="rating-link"><strong> Okay, you deserve it </strong></a></p>';
        update_option('card_elements_reviews', $notices);

        // Deactivate card elements for elementor (Pro) plugin than activate card elements free for elementor plugin
        deactivate_plugins('card-elements-pro-for-elementor/card-elements-pro-for-elementor.php');
    }

}
register_activation_hook(__FILE__, 'card_elements_plugin_activation');

/**
 * Display admin notice on Card Elements activation for ratings
 */
if (!function_exists('card_elements_reviews_notices')) {

    function card_elements_reviews_notices() {
        if ($notices = get_option('card_elements_reviews')) {
            foreach ($notices as $notice) {
                echo "<div class='notice notice-success is-dismissible'><p>$notice</p></div>";
            }
            delete_option('card_elements_reviews');
        }
    }

    add_action('admin_notices', 'card_elements_reviews_notices');
}

/**
 * Remove reviews metadata on plugin deactivation.
 */
if (!function_exists('card_elements_plugin_deactivation')) {

    function card_elements_plugin_deactivation() {
        delete_option('card_elements_reviews');
    }

}
register_deactivation_hook(__FILE__, 'card_elements_plugin_deactivation');
