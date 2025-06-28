<?php

/**
 * Template Name: Page Home
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

  <?php
  if (have_rows('slider')):  ?>
    <!--start slider-->
    <section class="slider">
      <div class="dn__slider flickity slider">
        <?php while (have_rows('slider')) : the_row();
          $title = get_sub_field('title');
          $excerpt = get_sub_field('excerpt');
          $image = get_sub_field('image');
        ?>
          <div class="slider__item">
            <div class="item__thumb dnfix__thumb">
              <?php
              echo wp_get_attachment_image($image, 'full');
              ?>
            </div>
            <div class="item__meta__wrap">
              <div class="item__box">
                <div class="item__title" data-animate="bounceInLeft"><?= $title ?></div>
                <div class="item__sub" data-animate="bounceInLeft" data-animate-delay="600"><?= $excerpt ?></div>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </section><!--end slider-->
  <?php endif; ?>


  <section class="introduce">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="introduce__box wow slideInLeft" data-wow-duration="1s">
            <header class="item__header mb-2">
              <p class="item__title"><?php _e('Giới thiệu', 'dntheme'); ?></p>
              <span class="item__sub"><?php _e('Về chúng tôi', 'dntheme'); ?></span>
            </header>
            <div class="item__content mb-2">
              <?= get_field('about_content') ?>
            </div>
            <a href="<?php the_field('about_link') ?>" class="btn btn-primary mb-3"><?php _e('Tìm hiểm thêm', 'dntheme'); ?></a>
          </div>
        </div>
        <div class="col-md-6">
          <div class="item__thumb wow slideInUp">

            <?php
            $gt_image = get_field('about_image');
            if ($gt_image) {
              echo wp_get_attachment_image($gt_image, 'large');
            }
            ?>
          </div><!-- .post-thumbnail -->
        </div>
      </div>

    </div>
  </section><!-- m_slide -->


  <section class="sc-service">
    <div class="container">
      <div class="sc__wrap">
        <header class="section-header text-center">
          <h2 class="section-header__title"><?php the_field('service_title') ?></h2>
        </header>
        <div class="sc__content">

          <?php
          if (have_rows('service_items')): $i = 0; ?>
            <div class="row g-4">
              <?php while (have_rows('service_items')) : the_row();
                $i++;
                $icon = get_sub_field('icon');
                $title = get_sub_field('title');
                $content = get_sub_field('content');
                $link = get_sub_field('link');
              ?>
                <div class="col-sm-6 col-md-4">
                  <div class="c-item position-relative">
                    <div class="c-item__thumb">
                      <?php
                      if ($icon) {
                        echo wp_get_attachment_image($icon, 'full');
                      }
                      ?>
                    </div>
                    <div class="c-item__meta">
                      <div class="c-item__title"><a href="<?= $link ?>" class="stretched-link"><?= $title ?></a></div>
                      <div class="c-item__content"><?= $content ?></div>
                    </div>
                  </div>
                </div>
              <?php endwhile; ?>
            </div>
          <?php endif;
          ?>
        </div>
      </div>
    </div>
  </section>


  <section class="home-why">
    <div class="container">

      <div class="sc-content">
        <div class="row">
          <div class="col-md-4">
            <div class="box-contact mb-4 mb-md-0">
              <div class="box-contact__title">Gửi liên hệ</div>
              <?php echo do_shortcode('[contact-form-7 id="23680d6" title="Home - Liên hệ"]') ?>
            </div>
          </div>
          <div class="col-md-8 d-flex align-items-center">
            <div class="">
              <header class="section-header text-center">
                <h2 class="section-header__title color--white"><?php the_field('why_title') ?></h2>
              </header>
              <?php
              if (have_rows('why_items')): ?>
                <div class="row g-4">
                  <?php while (have_rows('why_items')) : the_row(); ?>
                    <div class="col-md-6 item__wrap">
                      <div class="why__item">
                        <div class="c-item__title"><i class="fa fa-regular fa-star"></i> <?php the_sub_field('title') ?></div>
                        <div class="c-item__excerpt">
                          <?php the_sub_field('content') ?>
                        </div>
                      </div>
                    </div>
                  <?php endwhile; ?>
                </div>
              <?php endif;
              ?>
            </div>
          </div>
        </div>
      </div>
  </section>

  <?php
  $partner = get_field('partner');
  if ($partner): ?>
    <section class="testimonials">
      <div class="container">

        <div class="testimonials__slider slider flickity" data-flickity='{ "autoPlay": false ,"cellAlign": "left", "contain": true, "wrapAround": true, "groupCells": true, "pageDots": true,"prevNextButtons": false }'>
          <?php foreach ($partner as $image_id): ?>
            <div class="item__wrap col-6 col-sm-6 col-md-4 col-lg-2">
              <div class="c-item">
                <div class="ratio ratio--cotain">
                  <?php echo wp_get_attachment_image($image_id, $size); ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

<?php endwhile; // End of the loop.
?>

<?php get_footer();
