<?php
/**
 * Content Functions
 * 
 * @package WP-Shop
 * @author Đoàn Nguyễn
 */

if (!function_exists('dntheme_excerpt_more')) {
    /**
     * Replaces "[...]" (appended to automatically generated excerpts) with ... and
     * a 'Continue reading' link.
     */
    function dntheme_excerpt_more($link)
    {
        return ' [&hellip;] ';
    }
}
add_filter('excerpt_more', 'dntheme_excerpt_more');

if (!function_exists('custom_excerpt_length')) {
    function custom_excerpt_length($length)
    {
        return 300;
    }
}
// add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

if (!function_exists('dn_excerpt')) {
    // Custom the_excerpt
    function dn_excerpt($limit = 450, $echo = true, $more = ' [&hellip;]')
    {
        if (has_excerpt(get_the_ID())) {
            the_excerpt();
        } else {
            if ($echo) echo wp_html_excerpt(get_the_excerpt(), $limit, $more);
            else return wp_html_excerpt(get_the_excerpt(), $limit, $more);
        }
    }
}

if (!function_exists('dn_excerpt_words')) {
    function dn_excerpt_words($limit = 25, $more = ' [&hellip;]')
    {
        if (has_excerpt(get_the_ID())) {
            the_excerpt();
        } else {
            echo wp_trim_words(get_the_excerpt(), $limit, $more);
        }
    }
}

if (!function_exists('dn_thumbnail_html_null')) {
    //Check post thumbnail
    function dn_thumbnail_html_null($html)
    {
        if (empty($html))
            $html = '<img src="' . get_theme_file_uri() . '/assets/images/not-images.png" class="img-fluid" alt="Error Image" />';
        return $html;
    }
}
add_filter('post_thumbnail_html', 'dn_thumbnail_html_null');

if (!function_exists('dn_get_attachment_image_src_null')) {
    function dn_get_attachment_image_src_null($image)
    {
        if (empty($image)) {
            $image = array();
            $image[] = get_theme_file_uri() . '/assets/images/not-images.png';
            $image[] = 512; // width
            $image[] = 512; //height
        }
        return $image;
    }
}
add_filter('wp_get_attachment_image_src', 'dn_get_attachment_image_src_null');

if (!function_exists('give_linked_images_class')) {
    /**
     * Attach a class to linked images' parent anchors
     * Works for existing content
     */
    function give_linked_images_class($content)
    {
        $classes = 'img'; // separate classes by spaces - 'img image-link'

        // check if there are already a class property assigned to the anchor
        if (preg_match('/<a.*? class=".*?"><img/', $content)) {
            // If there is, simply add the class
            $content = preg_replace('/(<a.*? class=".*?)(".*?><img)/', '$1 ' . $classes . '$2', $content);
        } else {
            // If there is not an existing class, create a class property
            $content = preg_replace('/(<a.*?)><img/', '$1 class="' . $classes . '" data-fancybox="single-gallery"><img', $content);
        }
        return $content;
    }
}
// add_filter('acf_the_content','give_linked_images_class');

if (!function_exists('dntheme_get_the_archive_title')) {
    /**
     * Filters the default archive titles.
     */
    function dntheme_get_the_archive_title()
    {
        if (is_category()) {
            $title = '<h1 class="page-title">' . single_term_title('', false) . '</h1>';
        } elseif (is_tag()) {
            $title = '<span class="page-description">' . single_term_title('', false) . '</span>';
        } elseif (is_author()) {
            $title = '<span class="page-description">' . get_the_author_meta('display_name') . '</span>';
        } elseif (is_year()) {
            $title = '<span class="page-description">' . get_the_date(_x('Y', 'yearly archives date format', 'dntheme')) . '</span>';
        } elseif (is_month()) {
            $title = '<span class="page-description">' . get_the_date(_x('F Y', 'monthly archives date format', 'dntheme')) . '</span>';
        } elseif (is_day()) {
            $title = '<span class="page-description">' . get_the_date() . '</span>';
        } elseif (is_post_type_archive()) {
            $title = '<h1 class="page-title">' . post_type_archive_title('', false) . '</h1>';
        } elseif (is_tax()) {
            // $tax = get_taxonomy( get_queried_object()->taxonomy );
            /* translators: %s: Taxonomy singular name */
            $title = '<h1 class="page__header__title">' . sprintf(esc_html__('%s', 'dntheme'), single_term_title('', false)) . '</h1>';
        } else {
            $title = __('Archives:', 'dntheme');
        }
        return $title;
    }
}
add_filter('get_the_archive_title', 'dntheme_get_the_archive_title'); 