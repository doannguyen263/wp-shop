<?php
/**
 * Theme Setup Functions
 * 
 * @package WP-Shop
 * @author Đoàn Nguyễn
 */

if (!function_exists('dntheme_setup')) {
    function dntheme_setup()
    {
        load_theme_textdomain('dntheme');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        add_theme_support('title-tag');

        add_post_type_support('page', 'excerpt');

        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(1600, 9999);
        add_image_size('large', 550, 350);
        add_image_size('medium', 260, 165);
        add_image_size('small', 160, 100);

        // Set the default content width.
        $GLOBALS['content_width'] = 1600;

        // This theme uses wp_nav_menu() in two locations.
        register_nav_menus(array(
            'primary'            => __('Main Menu', 'dntheme'),
            'footer'            => __('Footer Menu', 'dntheme')
        ));

        add_theme_support('html5', array(
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'script'
            // 'style'
        ));
    }
}
add_action('after_setup_theme', 'dntheme_setup');

if (!function_exists('dntheme_widgets_init')) {
    /**
     * Register widget area.
     */
    function dntheme_widgets_init()
    {
        register_sidebar(array(
            'name'          => __('Blog Sidebar', 'dntheme'),
            'id'            => 'blog',
            'description'   => __('Add widgets here to appear in your sidebar on blog posts and archive pages.', 'dntheme'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<p class="widget-title">',
            'after_title'   => '</p>',
        ));
    }
}
add_action('widgets_init', 'dntheme_widgets_init');

if (!function_exists('wps_attachment_display_settings')) {
    /**
     * Thiết lập mặc định khi upload trong bài viết
     * @author Đoàn Nguyễn
     */
    function wps_attachment_display_settings()
    {
        update_option('image_default_align', 'center');
        update_option('image_default_link_type', 'file');
        update_option('image_default_size', 'full');
    }
}
add_action('after_setup_theme', 'wps_attachment_display_settings');

if (!function_exists('dntheme_front_page_template')) {
    /**
     * Use front-page.php when Front page displays is set to a static page.
     *
     * @since dntheme
     *
     * @param string $template front-page.php.
     *
     * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
     */
    function dntheme_front_page_template($template)
    {
        return is_home() ? '' : $template;
    }
}
add_filter('frontpage_template', 'dntheme_front_page_template'); 