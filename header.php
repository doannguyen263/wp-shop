<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package    WordPress
 * @subpackage Dntheme
 * @version 1.0
 */
global $woocommerce;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

</head>

<body <?php body_class(); ?>>
  <div id="fb-root"></div>
  <?php wp_body_open(); ?>
  <div class="wrapper">
    <div class="header__top">
      <div class="container d-flex">
        <div class="d-flex align-items-center">
          <span class="">
            <a href="tel:<?php echo dntheme_remove_space(get_field('address_phone', 'option')); ?>"><i class="fa fa-phone mr-1" aria-hidden="true"></i> <?php the_field('address_phone', 'option'); ?></a>
          </span> <span class="mx-1 mx-sm-3">|</span>
          <span class=""><i class="fa fa-envelope-o mr-1" aria-hidden="true"></i> <?php the_field('address_email', 'option'); ?></span>
        </div>
        <div class="ms-auto d-none d-md-block">
          <div class="social__box -s1 ml-auto">
            <a href="<?php the_field('fb', 'option'); ?>" class="ic--fbz" target="_blank"><i class="fa fa-facebook-square" aria-hidden="true"></i></a>
            <a href="<?php the_field('tw', 'option'); ?>" class="ic--twz" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
            <a href="<?php the_field('ytb', 'option'); ?>" class="ic--ytbz" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
          </div>
        </div>
      </div>
    </div>

    <header class="header" data-toggle="sticky-onscroll">
      <div class="container">
        <div class="sc__wrap d-flex justify-content-between align-items-center">
          <div class="header__brand">
            <?php
            $logo_img = get_field('logo', 'option');
            if (is_front_page()): ?>
              <h1 class="logo">
                <a href="<?php echo site_url(); ?>">
                  <?php echo wp_get_attachment_image($logo_img, 'full'); ?>
                </a>
              </h1>
            <?php else: ?>
              <p class="logo">
                <a href="<?php echo site_url(); ?>">
                  <?php echo wp_get_attachment_image($logo_img, 'full'); ?>
                </a>
              </p>
            <?php endif;
            ?>

          </div>
          <!--start main nav-->
          <nav class="main__nav d-flex align-items-center">

            <?php
            wp_nav_menu(
              array(
                'theme_location'  => 'primary',
                'container'       => 'ul',
                'container_class' => '',
                'menu_id'         => '',
                'menu_class'      => 'dn__menu d-none d-lg-flex',
              )
            );
            ?>
            <a href="#menu__mobile" class="mburger d-flex d-lg-none ms-3">
              <span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></span>
            </a>
          </nav>
          <!--end main nav-->

          <nav class="main__nav d-flex align-items-center ml-auto nav-right">
          <ul class="dn__menu d-flex">
            <li class="menu-item">
              <?php if(is_user_logged_in()): ?>
                <a href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>"><span>Tài khoản</span></a>
              <?php else: ?>
                <a href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>"><span>Login</span></a>
              <?php endif; ?>
              <!-- <ul class="sub-menu">
                <li class="menu-item"><a href="<?php echo site_url('/tai-khoan/'); ?>">
                  <i class="fa fa-calendar-minus-o" aria-hidden="true"></i> <span>Đơn hàng</span></a></li>
                <li class="menu-item"><a href="<?php echo site_url('/tai-khoan/'); ?>">
                  <i class="fa fa-sign-out" aria-hidden="true"></i> <span>Đăng xuất</span></a></li>
              </ul> -->
            </li>
            <li class="menu-item">

              <a href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="d-none d-md-inline">Cart</span> <span class="total-cart">(<?php echo $woocommerce->cart->cart_contents_count; ?>)</span>
              </a>
            </li>
          </ul>
        </nav>
        </div>
      </div>
    </header><!--end header-->

    <?php if (!is_front_page()): ?>
      <div class="dn__breadcrumb <?php echo is_page_template('page-contact.php') ? 'd-none' : '' ?>" typeof="BreadcrumbList" vocab="https://schema.org/">
        <div class="container">
          <?php if (function_exists('bcn_display')) {
            bcn_display();
          } ?>
        </div>
      </div>

    <?php endif; ?>