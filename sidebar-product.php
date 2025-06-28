<?php
/**
 * The sidebar containing the main widget area
 *
 * @package    WordPress
 * @subpackage Dntheme
 * @version 1.0
 */

// if ( ! is_active_sidebar( 'sidebar-1' ) ) {
// 	return;
// }
?>

<aside class="widget-area dnsticky" role="complementary">
	<?php dynamic_sidebar( 'product' ); ?>
</aside><!-- #secondary -->
