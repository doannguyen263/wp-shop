<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
  return;
}

global $product;

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
  'woocommerce-product-gallery',
  'woocommerce-product-gallery--' . ( $product->get_image_id() ? 'with-images' : 'without-images' ),
  'woocommerce-product-gallery--columns-' . absint( $columns ),
  'images',
) );
$slider_classes = array('product-gallery-slider','slider');
?>
<div class="product-gallery">
  <div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>">
    <figure class="woocommerce-product-gallery__wrapper <?php echo implode(' ', $slider_classes); ?>"
          data-flickity='{
                  "cellAlign": "center",
                  "wrapAround": true,
                  "autoPlay": false,
                  "prevNextButtons":true,
                  "adaptiveHeight": true,
                  "imagesLoaded": true,
                  "lazyLoad": 1,
                  "dragThreshold" : 15,
                  "pageDots": false,
                  "rightToLeft": false
         }'>
      <?php

      if ( has_post_thumbnail() ) {
        $html  = flatsome_wc_get_gallery_image_html( $post_thumbnail_id, true );
      } else {
        $html  = '<div class="woocommerce-product-gallery__image--placeholder">';
        $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
        $html .= '</div>';
      }

      echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id );

      do_action( 'woocommerce_product_thumbnails' );
      ?>
    </figure>
  </div>
    
  <?php wc_get_template( 'woocommerce/single-product/product-gallery-thumbnails.php' ); ?>
</div> 