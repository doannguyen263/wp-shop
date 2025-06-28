<?php
/**
 * Scripts and Styles Functions
 * 
 * @package WP-Shop
 * @author Đoàn Nguyễn
 */

if (!function_exists('dntheme_javascript_detection')) {
    /**
     * Handles JavaScript detection.
     *
     * Adds a `js` class to the root `<html>` element when JavaScript is detected.
     *
     * @since dntheme
     */
    function dntheme_javascript_detection()
    {
        echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
    }
}
add_action('wp_head', 'dntheme_javascript_detection', 0);

if (!function_exists('dntheme_scripts')) {
    /**
     * Enqueue scripts and styles.
     */
    function dntheme_scripts()
    {
        // Theme version - chỉ dùng cho theme files
        $theme_version = defined('DISABLE_CACHE') && DISABLE_CACHE ? time() : '1.0.0';
        
        // Library versions - cố định để cache tốt hơn
        $bootstrap_version = '5.3.0';
        $fontawesome_version = '4.7.0';
        $animate_version = '4.1.1';
        $jquery_version = '3.6.0';

        // Deregister WordPress default jQuery and load local version
        wp_deregister_script('jquery');
        wp_register_script('jquery', get_theme_file_uri('/assets/js/jquery-3.6.0.min.js'), array(), $jquery_version, false);
        wp_enqueue_script('jquery');

        // Core CSS - chỉ load những gì cần thiết
        wp_enqueue_style('bootstrap', get_theme_file_uri('assets/libs/bootstrap/css/bootstrap.min.css'), array(), $bootstrap_version);
        wp_enqueue_style('fontawesome', get_theme_file_uri('assets/libs/font-awesome/css/font-awesome.min.css'), array(), $fontawesome_version);
        wp_enqueue_style('animate', get_theme_file_uri('assets/libs/animate/animate.min.css'), array(), $animate_version);

        // Core JavaScript - chỉ load những gì cần thiết
        wp_enqueue_script('bootstrap', get_theme_file_uri('assets/libs/bootstrap/js/bootstrap.bundle.js'), array('jquery'), $bootstrap_version, true);

        // Conditional loading - chỉ load khi cần
        if (is_front_page()) {
            // Chỉ load WOW và Flickity ở trang chủ
            wp_enqueue_script('wow', get_theme_file_uri('assets/libs/WOW/wow.min.js'), array('jquery'), '1.3.0', true);
            wp_enqueue_style('flickity', get_theme_file_uri('assets/libs/flickity/flickity.min.css'), array(), '2.3.0');
            wp_enqueue_script('flickity', get_theme_file_uri('assets/libs/flickity/flickity.pkgd.min.js'), array('jquery'), '2.3.0', true);
        }

        // Lightbox - chỉ load khi có gallery hoặc product
        if (is_singular('product') || is_archive('product') || has_post_thumbnail()) {
            wp_enqueue_style('fancybox-v4', get_theme_file_uri('/assets/libs/fancybox-v4/fancybox.css'), array(), '4.0.0');
            wp_enqueue_script('fancybox-v4', get_theme_file_uri('/assets/libs/fancybox-v4/fancybox.umd.js'), array('jquery'), '4.0.0', true);
        }

        // HoverIntent - chỉ load khi có menu
        if (has_nav_menu('primary')) {
            wp_enqueue_script('hoverIntent', get_theme_file_uri('assets/libs/jquery-hoverIntent/jquery.hoverIntent.min.js'), array('jquery'), '1.10.1', true);
        }

        // Theme specific files
        wp_enqueue_script('dnmain', get_theme_file_uri('/assets/js/main.js'), array('jquery'), $theme_version, true);
        
        // WooCommerce CSS - chỉ load khi cần
        if (class_exists('WooCommerce')) {
            wp_enqueue_style('shop', get_theme_file_uri('/assets/css/woocommerce.css'), array(), $theme_version);
        }
        
        wp_enqueue_style('dn-style', get_stylesheet_uri(), array(), $theme_version);

        // Localize script for AJAX - chỉ khi cần
        if (is_front_page() || is_singular()) {
            wp_localize_script('dnmain', 'dntheme_params', array(
                'dntheme_nonce' => wp_create_nonce('dntheme_nonce'),
                'ajax_url' => admin_url('admin-ajax.php'),
                'theme_url' => get_template_directory_uri(),
                'is_front_page' => is_front_page(),
            ));
        }

        // Comment reply script for single posts
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }
}
add_action('wp_enqueue_scripts', 'dntheme_scripts');

if (!function_exists('dntheme_defer_non_critical_js')) {
    /**
     * Defer non-critical JavaScript for better performance
     */
    function dntheme_defer_non_critical_js($tag, $handle, $src)
    {
        // Defer các script không quan trọng
        $defer_scripts = array('wow', 'flickity', 'fancybox-v4', 'hoverIntent');
        
        if (in_array($handle, $defer_scripts)) {
            return str_replace(' src', ' defer src', $tag);
        }
        
        return $tag;
    }
}
add_filter('script_loader_tag', 'dntheme_defer_non_critical_js', 10, 3);

if (!function_exists('dntheme_admin_scripts')) {
    /**
     * Enqueue admin scripts and styles.
     */
    function dntheme_admin_scripts($hook)
    {
        // Only load on theme options page or post editor
        if (in_array($hook, array('post.php', 'post-new.php', 'appearance_page_theme-options'))) {
            wp_enqueue_style('dntheme-admin', get_theme_file_uri('/core/admin/style-admin.css'), array(), '1.0.0');
            wp_enqueue_script('dntheme-admin', get_theme_file_uri('/core/admin/script-admin.js'), array('jquery'), '1.0.0', true);
        }
    }
}
add_action('admin_enqueue_scripts', 'dntheme_admin_scripts');

if (!function_exists('dntheme_preload_critical_assets')) {
    /**
     * Preload critical assets for better performance.
     * Chỉ preload ở trang chủ để tránh cảnh báo.
     */
    function dntheme_preload_critical_assets()
    {
        // Chỉ preload ở trang chủ và không phải admin
        if (!is_admin() && is_front_page()) {
            // Preload Bootstrap CSS
            echo '<link rel="preload" href="' . get_theme_file_uri('/assets/libs/bootstrap/css/bootstrap.min.css') . '" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">' . "\n";
            echo '<noscript><link rel="stylesheet" href="' . get_theme_file_uri('/assets/libs/bootstrap/css/bootstrap.min.css') . '"></noscript>' . "\n";
            
            // Preload jQuery
            echo '<link rel="preload" href="' . get_theme_file_uri('/assets/js/jquery-3.6.0.min.js') . '" as="script">' . "\n";
            
            // DNS prefetch cho external resources
            echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">' . "\n";
            echo '<link rel="dns-prefetch" href="//fonts.gstatic.com">' . "\n";
        }
    }
}
add_action('wp_head', 'dntheme_preload_critical_assets', 1);

if (!function_exists('dntheme_remove_unnecessary_requests')) {
    /**
     * Remove unnecessary WordPress requests
     */
    function dntheme_remove_unnecessary_requests()
    {
        // Remove emoji scripts
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
        
        // Remove embed scripts
        wp_deregister_script('wp-embed');
        
        // Remove WordPress version
        remove_action('wp_head', 'wp_generator');
        
        // Remove RSD link
        remove_action('wp_head', 'rsd_link');
        
        // Remove wlwmanifest link
        remove_action('wp_head', 'wlwmanifest_link');
        
        // Remove shortlink
        remove_action('wp_head', 'wp_shortlink_wp_head');
    }
}
add_action('init', 'dntheme_remove_unnecessary_requests'); 