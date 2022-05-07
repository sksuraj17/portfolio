<?php
if(!class_exists('TSSItemSorting')){

    class TSSItemSorting{
        function __construct() {
            add_action('admin_init', array($this, 'refresh'));
            add_action('admin_init', array($this, 'load_script'));
            add_action('pre_get_posts', array($this, 'tss_pre_get_posts'));
            add_action('wp_ajax_tss-update-menu-order', array($this, 'update_menu_order'));
	        add_action( 'wp_ajax_tss-cat-update-order', array( $this, 'tss_cat_update_order' ) );
        }

        function tss_pre_get_posts($wp_query) {
            if (is_admin()) {
                if (isset($wp_query->query['post_type']) && !isset($_GET['orderby']) && $wp_query->query['post_type'] == TSSPro()->post_type) {
                        $wp_query->set('orderby', 'menu_order');
                        $wp_query->set('order', 'ASC');
                }
            } else {
                $active = false;
                if (isset($wp_query->query['post_type']) && $wp_query->query['post_type'] == TSSPro()->post_type) {
                            $active = true;
                }
                if (!$active)
                    return false;

                if (isset($wp_query->query['suppress_filters'])) {
                    if ($wp_query->get('orderby') == 'date')
                        $wp_query->set('orderby', 'menu_order');
                    if ($wp_query->get('order') == 'DESC')
                        $wp_query->set('order', 'ASC');
                } else {
                    if (!$wp_query->get('orderby'))
                        $wp_query->set('orderby', 'menu_order');
                    if (!$wp_query->get('order'))
                        $wp_query->set('order', 'ASC');
                }
            }
        }
        
        function load_script() {
            if (isset($_GET['orderby']) || strstr($_SERVER['REQUEST_URI'], 'action=edit') || strstr($_SERVER['REQUEST_URI'], 'wp-admin/post-new.php'))
                return false;
            if(!isset($_GET['post_type']))
                return false;

            if(isset($_GET['post_type']) && $_GET['post_type'] != TSSPro()->post_type)
                return false;
            wp_enqueue_script('jquery');
            wp_enqueue_script('jquery-ui-sortable');
            wp_enqueue_script('rt-tss-sortable');
            add_action('admin_footer', array($this, 'rt_sortable_css'));
        }
        
        function rt_sortable_css(){
            echo "<style>
                    .ui-sortable tr:hover {
                        cursor: move;
                    }
                    .ui-sortable tr.alternate {
                        background-color: #F9F9F9;
                    }
                    .ui-sortable tr.ui-sortable-helper {
                        background-color: #F9F9F9;
                        border-top: 1px solid #DFDFDF;
                    }
                </style>";
        }

        function update_menu_order() {
            global $wpdb;
            parse_str($_POST['order'], $data);
            if (!is_array($data))
                return false;

            $id_arr = array();
            foreach ($data as $key => $values) {
                foreach ($values as $position => $id) {
                    $id_arr[] = $id;
                }
            }

            $menu_order_arr = array();
            foreach ($id_arr as $key => $id) {
                $results = $wpdb->get_results("SELECT menu_order FROM $wpdb->posts WHERE ID = " . intval($id));
                foreach ($results as $result) {
                    $menu_order_arr[] = $result->menu_order;
                }
            }

            sort($menu_order_arr);

            foreach ($data as $key => $values) {
                foreach ($values as $position => $id) {
                    $wpdb->update($wpdb->posts, array('menu_order' => $menu_order_arr[$position]), array('ID' => intval($id)));
                }
            }
        }

	    /**
	     * @return bool
	     */
	    function tss_cat_update_order() {

		    $data = ( ! empty( $_POST['tag'] ) ? array_filter( $_POST['tag'] ) : array() );

		    if ( ! is_array( $data ) ) {
			    return false;
		    }

		    $id_arr = array();
		    foreach ( $data as $position => $id ) {
			    $id_arr[] = $id;
		    }
		    $order_arr = array();
		    foreach ( $id_arr as $key => $id ) {
			    $order_arr[] = get_term_meta( intval( $id ), '_order', true );
		    }
		    sort( $order_arr );

		    foreach ( $data as $position => $id ) {
			    update_term_meta( intval( $id ), '_order', $order_arr[ $position ] );
		    }
		    die();
	    }

        /**
         *
         */
        function refresh() {
            global $wpdb;

            $results = $wpdb->get_results("
            SELECT ID
            FROM $wpdb->posts
            WHERE post_type = '" . TSSPro()->post_type . "' AND post_status IN ('publish', 'pending', 'draft', 'private', 'future')
            ORDER BY menu_order ASC
        ");
            foreach ($results as $key => $result) {
                $wpdb->update($wpdb->posts, array('menu_order' => $key + 1), array('ID' => $result->ID));
            }
        }
    }

}