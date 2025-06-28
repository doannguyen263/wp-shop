<?php
/**
 * Performance Optimization Functions
 * 
 * @package WP-Shop
 * @author Đoàn Nguyễn
 */

if (!function_exists('dn_load_cf7')) {
    /**
     * Tối ưu contact form
     * @author Đoàn Nguyễn
     */
    function dn_load_cf7($arr)
    {
        if (is_page_template('page-contact.php')) {
            return $arr;
        } else {
            return false;
        }
    }
}
// add_filter( 'wpcf7_load_js', 'dn_load_cf7' );
// add_filter( 'wpcf7_load_css', 'dn_load_cf7' );

if (!function_exists('stop_loading_wp_embed')) {
    /**
     * Remove WP Embed Script
     * @author Đoàn Nguyễn
     */
    function stop_loading_wp_embed()
    {
        if (!is_admin()) {
            wp_deregister_script('wp-embed');
        }
    }
}
add_action('init', 'stop_loading_wp_embed');

// Remove the REST API endpoint.
remove_action('rest_api_init', 'wp_oembed_register_route');
// Turn off oEmbed auto discovery.
add_filter('embed_oembed_discover', '__return_false');
// Don't filter oEmbed results.
remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
// Remove oEmbed discovery links.
remove_action('wp_head', 'wp_oembed_add_discovery_links');
// Remove oEmbed-specific JavaScript from the front-end and back-end.
remove_action('wp_head', 'wp_oembed_add_host_js');
//Remove WordPress Version Number
remove_action('wp_head', 'wp_generator');

if (!function_exists('remove_emoji_scripts')) {
    /**
     * Remove emoji
     * @author Đoàn Nguyễn
     */
    function remove_emoji_scripts()
    {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
    }
}
add_action('init', 'remove_emoji_scripts');

if (!function_exists('dntheme_remove_default_image_sizes')) {
    /**
     * Remove Thumbnails default
     * @author Đoàn Nguyễn
     */
    function dntheme_remove_default_image_sizes($sizes)
    {
        // unset( $sizes['thumbnail']);
        // unset( $sizes['medium']);
        // unset( $sizes['large']);

        return $sizes;
    }
}
remove_image_size('1536x1536');
remove_image_size('2048x2048');
// add_filter('intermediate_image_sizes_advanced', 'dntheme_remove_default_image_sizes');

if (!function_exists('smartwp_remove_wp_block_library_css')) {
    //Remove Gutenberg Block Library CSS from loading on the frontend
    function smartwp_remove_wp_block_library_css()
    {
        wp_dequeue_style('classic-theme-styles'); // Remove WooCommerce block CSS
    }
}
add_action('wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100);

if (!function_exists('disable_wp_blocks')) {
    function disable_wp_blocks()
    {
        $wstyles = array(
            'wp-block-library',
            'wc-blocks-style',
            'wc-blocks-style-active-filters',
            'wc-blocks-style-add-to-cart-form',
            'wc-blocks-packages-style',
            'wc-blocks-style-all-products',
            'wc-blocks-style-all-reviews',
            'wc-blocks-style-attribute-filter',
            'wc-blocks-style-breadcrumbs',
            'wc-blocks-style-catalog-sorting',
            'wc-blocks-style-customer-account',
            'wc-blocks-style-featured-category',
            'wc-blocks-style-featured-product',
            'wc-blocks-style-mini-cart',
            'wc-blocks-style-price-filter',
            'wc-blocks-style-product-add-to-cart',
            'wc-blocks-style-product-button',
            'wc-blocks-style-product-categories',
            'wc-blocks-style-product-image',
            'wc-blocks-style-product-image-gallery',
            'wc-blocks-style-product-query',
            'wc-blocks-style-product-results-count',
            'wc-blocks-style-product-reviews',
            'wc-blocks-style-product-sale-badge',
            'wc-blocks-style-product-search',
            'wc-blocks-style-product-sku',
            'wc-blocks-style-product-stock-indicator',
            'wc-blocks-style-product-summary',
            'wc-blocks-style-product-title',
            'wc-blocks-style-rating-filter',
            'wc-blocks-style-reviews-by-category',
            'wc-blocks-style-reviews-by-product',
            'wc-blocks-style-product-details',
            'wc-blocks-style-single-product',
            'wc-blocks-style-stock-filter',
            'wc-blocks-style-cart',
            'wc-blocks-style-checkout',
            'wc-blocks-style-mini-cart-contents',
        );

        foreach ($wstyles as $wstyle) {
            wp_deregister_style($wstyle);
        }

        $wscripts = array(
            'wc-blocks-middleware',
            'wc-blocks-data-store'
        );

        foreach ($wscripts as $wscript) {
            wp_deregister_script($wscript);
        }
    }
}
add_action('init', 'disable_wp_blocks', 100);

// Remove unwanted SVG filter injection WP
remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');

if (!function_exists('remove_recent_comments_widget')) {
    // Remove unwanted Widget
    function remove_recent_comments_widget()
    {
        unregister_widget('WP_Widget_Recent_Comments');
        unregister_widget('WP_Widget_Media_Audio');
        unregister_widget('WP_Widget_Calendar'); // Loại bỏ widget lịch
        unregister_widget('WP_Widget_Meta'); // Loại bỏ widget meta
        unregister_widget('WP_Widget_Media_Video'); // Loại bỏ widget video
        unregister_widget('WP_Widget_Archives'); // Loại bỏ widget lưu trữ
        unregister_widget('WP_Widget_RSS'); // Loại bỏ widget dòng thông tin RSS
        unregister_widget('WP_Widget_Tag_Cloud');
        unregister_widget('WP_Widget_Pages');
    }
}
add_action('widgets_init', 'remove_recent_comments_widget');

// ===== THÊM CÁC FUNCTION TỐI ƯU MỚI =====

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

if (!function_exists('dntheme_lazy_load_images')) {
    /**
     * Lazy load images
     */
    function dntheme_lazy_load_images($content)
    {
        // Thêm loading="lazy" cho tất cả images
        $content = preg_replace('/<img(.*?)>/', '<img$1 loading="lazy">', $content);
        return $content;
    }
}
add_filter('the_content', 'dntheme_lazy_load_images');

if (!function_exists('dntheme_optimize_images')) {
    /**
     * Optimize images with srcset
     */
    function dntheme_optimize_images($content)
    {
        // Thêm srcset cho responsive images
        $content = preg_replace('/<img(.*?)src="([^"]*)"([^>]*)>/', '<img$1src="$2"$3 srcset="$2 1x, $2 2x">', $content);
        return $content;
    }
}
add_filter('the_content', 'dntheme_optimize_images');

if (!function_exists('dntheme_remove_unnecessary_requests')) {
    /**
     * Remove unnecessary WordPress requests
     */
    function dntheme_remove_unnecessary_requests()
    {
        // Remove RSD link
        remove_action('wp_head', 'rsd_link');
        
        // Remove wlwmanifest link
        remove_action('wp_head', 'wlwmanifest_link');
        
        // Remove shortlink
        remove_action('wp_head', 'wp_shortlink_wp_head');
        
        // Remove adjacent posts links
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    }
}
add_action('init', 'dntheme_remove_unnecessary_requests');

if (!function_exists('dntheme_optimize_queries')) {
    /**
     * Optimize database queries
     */
    function dntheme_optimize_queries()
    {
        // Disable autosave
        if (!defined('AUTOSAVE_INTERVAL')) {
            define('AUTOSAVE_INTERVAL', 300);
        }
    }
}
add_action('init', 'dntheme_optimize_queries');

if (!function_exists('dntheme_minify_html')) {
    /**
     * Minify HTML output
     */
    function dntheme_minify_html($html)
    {
        if (!WP_DEBUG) {
            // Remove comments
            $html = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $html);
            
            // Remove extra whitespace
            $html = preg_replace('/\s+/', ' ', $html);
            
            // Remove whitespace between tags
            $html = preg_replace('/>\s+</', '><', $html);
        }
        return $html;
    }
}
add_filter('wp_get_custom_css', 'dntheme_minify_html');

// ===== THÊM CÁC FUNCTION TỐI ƯU MỚI =====

if (!function_exists('dntheme_remove_more_requests')) {
    /**
     * Remove more unnecessary requests
     */
    function dntheme_remove_more_requests()
    {
        // Remove adjacent posts links
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
        
        // Remove feed links
        remove_action('wp_head', 'feed_links', 2);
        remove_action('wp_head', 'feed_links_extra', 3);
        
        // Remove pingback
        remove_action('wp_head', 'pingback_link');
        
        // Remove canonical links (nếu không cần SEO)
        // remove_action('wp_head', 'rel_canonical');
        
        // Remove wlwmanifest
        remove_action('wp_head', 'wlwmanifest_link');
        
        // Remove RSD
        remove_action('wp_head', 'rsd_link');
    }
}
add_action('init', 'dntheme_remove_more_requests');

if (!function_exists('dntheme_disable_embeds')) {
    /**
     * Disable embeds completely
     */
    function dntheme_disable_embeds()
    {
        // Remove oEmbed discovery links
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        
        // Remove oEmbed-specific JavaScript from the front-end and back-end
        remove_action('wp_head', 'wp_oembed_add_host_js');
        
        // Remove REST API endpoint
        remove_action('rest_api_init', 'wp_oembed_register_route');
        
        // Turn off oEmbed auto discovery
        add_filter('embed_oembed_discover', '__return_false');
        
        // Don't filter oEmbed results
        remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
    }
}
add_action('init', 'dntheme_disable_embeds');

if (!function_exists('dntheme_optimize_images_further')) {
    /**
     * Further optimize images
     */
    function dntheme_optimize_images_further($content)
    {
        // Thêm decoding="async" cho images
        $content = preg_replace('/<img(.*?)>/', '<img$1 decoding="async">', $content);
        
        // Thêm fetchpriority="high" cho images above the fold
        $content = preg_replace('/<img(.*?)class="([^"]*)"([^>]*)>/', '<img$1class="$2"$3 fetchpriority="high">', $content);
        
        return $content;
    }
}
add_filter('the_content', 'dntheme_optimize_images_further');

if (!function_exists('dntheme_optimize_database_further')) {
    /**
     * Further optimize database
     */
    function dntheme_optimize_database_further()
    {
        // Disable autosave
        if (!defined('AUTOSAVE_INTERVAL')) {
            define('AUTOSAVE_INTERVAL', 300);
        }
        
        // Disable trash
        if (!defined('EMPTY_TRASH_DAYS')) {
            define('EMPTY_TRASH_DAYS', 7);
        }
        
        // Disable pingbacks
        if (!defined('PINGBACK_DELAY')) {
            define('PINGBACK_DELAY', 0);
        }
    }
}
add_action('init', 'dntheme_optimize_database_further');

if (!function_exists('dntheme_remove_woo_scripts')) {
    /**
     * Remove unnecessary WooCommerce scripts
     */
    function dntheme_remove_woo_scripts()
    {
        if (class_exists('WooCommerce')) {
            // Remove WooCommerce scripts on non-WooCommerce pages
            if (!is_woocommerce() && !is_cart() && !is_checkout() && !is_account_page()) {
                wp_dequeue_script('woocommerce');
                wp_dequeue_script('wc-cart-fragments');
                wp_dequeue_script('wc-add-to-cart');
                wp_dequeue_script('wc-single-product');
                wp_dequeue_script('wc-checkout');
                wp_dequeue_script('wc-cart');
                wp_dequeue_script('wc-chosen');
                wp_dequeue_script('woocommerce_admin');
                wp_dequeue_script('wc-address-i18n');
                wp_dequeue_script('wc-password-strength-meter');
                wp_dequeue_script('select2');
                wp_dequeue_script('wc-credit-card-form');
                wp_dequeue_script('wc-enhanced-select');
                wp_dequeue_script('wc-geolocation');
                wp_dequeue_script('wc-lost-password');
                wp_dequeue_script('wc-order-attribution');
                wp_dequeue_script('wc-password-strength-meter');
                wp_dequeue_script('wc-product-search');
                wp_dequeue_script('wc-single-product');
                wp_dequeue_script('wc-sortable');
                wp_dequeue_script('wc-terms-and-conditions');
                wp_dequeue_script('wc-user-profile');
            }
        }
    }
}
add_action('wp_enqueue_scripts', 'dntheme_remove_woo_scripts', 99);

// ===== THÊM CÁC FUNCTION TỐI ƯU CUỐI CÙNG =====

if (!function_exists('dntheme_optimize_finish_time')) {
    /**
     * Optimize finish time
     */
    function dntheme_optimize_finish_time()
    {
        // Remove unnecessary WordPress features
        remove_action('wp_head', 'wp_resource_hints', 2);
        
        // Remove REST API links
        remove_action('wp_head', 'rest_output_link_wp_head');
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        
        // Remove XML-RPC
        add_filter('xmlrpc_enabled', '__return_false');
        
        // Disable heartbeat API
        wp_deregister_script('heartbeat');
    }
}
add_action('init', 'dntheme_optimize_finish_time');

if (!function_exists('dntheme_optimize_loading_order')) {
    /**
     * Optimize loading order
     */
    function dntheme_optimize_loading_order()
    {
        // Move non-critical CSS to footer
        add_filter('style_loader_tag', function($html, $handle) {
            $non_critical_styles = array('animate', 'flickity', 'fancybox-v4');
            
            if (in_array($handle, $non_critical_styles)) {
                return str_replace("rel='stylesheet'", "rel='stylesheet' media='print' onload=\"this.media='all'\"", $html);
            }
            
            return $html;
        }, 10, 2);
    }
}
add_action('wp_enqueue_scripts', 'dntheme_optimize_loading_order', 20);

if (!function_exists('dntheme_remove_more_woo_styles')) {
    /**
     * Remove more WooCommerce styles
     */
    function dntheme_remove_more_woo_styles()
    {
        if (class_exists('WooCommerce')) {
            // Remove WooCommerce styles on non-WooCommerce pages
            if (!is_woocommerce() && !is_cart() && !is_checkout() && !is_account_page()) {
                wp_dequeue_style('woocommerce-general');
                wp_dequeue_style('woocommerce-layout');
                wp_dequeue_style('woocommerce-smallscreen');
                wp_dequeue_style('woocommerce_frontend_styles');
                wp_dequeue_style('woocommerce_fancybox_styles');
                wp_dequeue_style('woocommerce_chosen_styles');
                wp_dequeue_style('woocommerce_prettyPhoto_css');
                wp_dequeue_style('select2');
            }
        }
    }
}
add_action('wp_enqueue_scripts', 'dntheme_remove_more_woo_styles', 99);

if (!function_exists('dntheme_optimize_fonts')) {
    /**
     * Optimize font loading
     */
    function dntheme_optimize_fonts()
    {
        // Preload critical fonts
        if (!is_admin() && is_front_page()) {
            echo '<link rel="preload" href="' . get_theme_file_uri('/assets/libs/font-awesome/fonts/fontawesome-webfont.woff2') . '" as="font" type="font/woff2" crossorigin>' . "\n";
        }
    }
}
add_action('wp_head', 'dntheme_optimize_fonts', 1); 