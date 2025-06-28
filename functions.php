<?php
require_once get_template_directory() . '/core/init.php';

// Bật/tắt cache - Thay đổi thành false để bật cache
define('DISABLE_CACHE', false);

/**
 * Include all theme functions
 */
require get_parent_theme_file_path('/inc/theme-setup.php');
require get_parent_theme_file_path('/inc/scripts-styles.php');
require get_parent_theme_file_path('/inc/content-functions.php');
require get_parent_theme_file_path('/inc/utilities.php');
require get_parent_theme_file_path('/inc/custom-post-types.php');
require get_parent_theme_file_path('/inc/template-tags.php');
require get_parent_theme_file_path('/inc/performance.php');
require get_parent_theme_file_path('/inc/woocommerce.php');
require get_parent_theme_file_path('/inc/widgets/widget-posts.php');
