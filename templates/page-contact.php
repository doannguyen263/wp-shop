<?php

/**
 * Template Name: Page Contact
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @package    WordPress
 * @subpackage Dntheme
 * @version 1.0
 */
get_header(); ?>
<?php while (have_posts()) : the_post(); ?>
  <section class="page__header text-center">
    <?php the_title('<h1 class="page-title">', '</h1>'); ?>
  </section>

  <div class="wrap__page page__contact">
    <main class="site-main" role="main">
      <div class="google__map">
        <div class="container">
          <?php the_content() ?>
        </div>
      </div>

      <div class="container">
        <div class="page__content sc__wrap entry-content -custom">
          <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12">
              <div class="info-intro">
                <div class="box__title">
                  <h3 class="entry-title title__box"><span><?php _e('Gửi liên hệ', 'dntheme'); ?></span></h3>
                </div>
                <div>
                  <?php echo do_shortcode(get_field('form')) ?>
                </div>
              </div> <!-- end info-intro -->
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 page-contact__info">
              <div class="box__title">
                <h3 class="title__box"><span><?php _e('Thông tin liên hệ', 'dntheme'); ?></span></h3>
              </div>
              <strong>TRỤ SỞ CHÍNH</strong>
              <ul>
                <li><span>Địa chỉ:</span> <?php the_field('address_address', 'option') ?></li>
                <li><span>Điện thoại:</span> <?php the_field('address_phone', 'option') ?></li>
                <li><span>Email:</span> <?php the_field('address_email', 'option') ?></li>
                <li><span>Website:</span> <?php the_field('address_website', 'option') ?></li>
              </ul>
              <?php
              if (have_rows('address_sub', 'option')): $i = 0; ?>

                <?php while (have_rows('address_sub', 'option')) : the_row();
                  $i++;
                  $title = get_sub_field('title'); ?>
                  <div class="">
                    <strong class=" mt-2"><?= $title ?></strong>
                    <?php
                    if (have_rows('address')): $j = 0; ?>
                      <ul>
                        <?php while (have_rows('address')) : the_row();
                          $j++;
                          $address = get_sub_field('address');
                          $phone = get_sub_field('phone');
                          $email = get_sub_field('email');
                          $website = get_sub_field('website');

                        ?>
                          <li><span>Địa chỉ:</span> <?= $address ?></li>
                          <li><span>Điện thoại:</span> <?= $phone ?></li>
                          <li><span>Email:</span> <?= $email ?></li>
                          <li><span>Website:</span> <?= $website ?></li>
                        <?php endwhile; ?>
                      </ul>
                    <?php endif;
                    ?>
                  </div>
                <?php endwhile; ?>
              <?php endif;
              ?>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
<?php endwhile; ?>
<?php get_footer();
