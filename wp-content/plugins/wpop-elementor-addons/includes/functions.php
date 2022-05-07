<?php

function get_post_type_categories($taxonomy){
    $terms = get_terms( array(
        'taxonomy' => $taxonomy,
        'hide_empty' => true,
    ));

    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
    foreach ( $terms as $term ) {
        $options[ $term->term_id ] = $term->name;
    }
     return $options;
    }
}

/**
 * POst Orderby Options
 * @return array
 */
function get_post_orderby_options(){
    $orderby = array(
        'ID'            => 'Post ID',
        'author'        => 'Post Author',
        'title'         => 'Title',
        'date'          => 'Date',
        'modified'      => 'Last Modified Date',
        'parent'        => 'Parent Id',
        'rand'          => 'Random',
        'comment_count' => 'Comment Count',
        'menu_order'    => 'Menu Order',
    );

    return $orderby;
}

/**
 * Post Type Options
 * @return array
 */
function wpopea_get_post_types(){
    $post_types = get_post_types( array(
        'public'            => true,
        'show_in_nav_menus' => true
    ) );

    return $post_types;
}

/**
 * Get authors list
 * @return array
 */
function wpopea_get_auhtors() {
    $options = array();

    $users = get_users();

    foreach ( $users as $user ) {
        $options[ $user->ID ] = $user->display_name;
    }

    return $options;
}

/**
 * Get tags list
 * @return array
 */
function wpopea_get_tags() {

    $options = array();

    $tags = get_tags();

    foreach ( $tags as $tag ) {
        $options[ $tag->term_id ] = $tag->name;
    }

    return $options;
}

/**
 * Get Posts list
 * @return array
 */
function wpopea_get_posts() {

    $post_list = get_posts( array(
        'post_type'         => 'post',
        'orderby'           => 'date',
        'order'             => 'DESC',
        'posts_per_page'    => -1,
    ) );

    $posts = array();

    if ( ! empty( $post_list ) && ! is_wp_error( $post_list ) ) {
        foreach ( $post_list as $post ) {
           $posts[ $post->ID ] = $post->post_title;
        }
    }

    return $posts;
}


