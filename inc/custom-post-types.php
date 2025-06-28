<?php
/**
 * Custom Post Types
 * 
 * @package WP-Shop
 * @author Đoàn Nguyễn
 */

if (!function_exists('service_post_type')) {
    /**
     * Register Custom Post Type Service
     * @author Đoàn Nguyễn
     */
    function service_post_type()
    {
        $labels = array(
            'name'                  => _x('Dịch vụ', 'Dịch vụ General Name', 'dntheme'),
            'singular_name'         => _x('Dịch vụ', 'Dịch vụ Singular Name', 'dntheme'),
            'menu_name'             => __('Dịch vụ', 'dntheme'),
            'name_admin_bar'        => __('Dịch vụ', 'dntheme'),
            'add_new_item'          => __('Thêm mới', 'dntheme'),
            'add_new'               => __('Thêm mới', 'dntheme'),
            'new_item'              => __('Thêm', 'dntheme'),
        );

        $args = array(
            'label'                 => __('Dịch vụ', 'dntheme'),
            'labels'                => $labels,
            'supports'              => array('title', 'thumbnail', 'editor', 'excerpt', 'revisions'),
            'public'                => true,
            'menu_position'         => 10,
            'can_export'            => true,
            'has_archive'           => true,
            'menu_icon' => 'dashicons-category',
            'rewrite' => array('slug' => 'dich-vu', 'with_front' => false),
        );
        register_post_type('service', $args);

        $labels = array(
            'name'              => _x('Danh mục Dịch vụ', 'Taxonomy General Name', 'dntheme'),
            'singular_name'     => _x('Danh mục Dịch vụ', 'Taxonomy Singular Name', 'dntheme'),
            'menu_name'         => __('Danh mục', 'dntheme'),
        );

        register_taxonomy(
            'service_cat',
            'service',
            array(
                'hierarchical' => true,
                'labels' => $labels,
                'show_admin_column' => true,
                'rewrite' => array('slug' => __('danh-muc'))
            )
        );
        flush_rewrite_rules();
    }
}
add_action('init', 'service_post_type', 5); 