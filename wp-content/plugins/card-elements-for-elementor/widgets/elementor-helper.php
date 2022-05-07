<?php

namespace Elementor;

// Create profile card category into elementor.
function init_card_elements_category() {
    Plugin::instance()->elements_manager->add_category(
            'card-elements', [
        'title' => esc_html__('Card Elements', CEE_DOMAIN),
        'icon' => 'font'
            ], 1
    );
}

add_action('elementor/init', 'Elementor\init_card_elements_category');
?>