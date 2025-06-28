<?php

/**
 * The template for displaying all single posts
 *
 * @package    WordPress
 * @subpackage Dntheme
 * @version 1.0
 */
get_header(); ?>
<div class="wrap__page">
    <div class="container">
        <div class="wrap__content sc__wrap">
            <div class="row">
                <div class="col-md-8 col-lg-9">
                    <?php
                    while (have_posts()) : the_post();
                        get_template_part('template-parts/content', 'single');
                    endwhile;
                    ?>
                </div>
                <div class="col-md-4 col-lg-3">
                    <?php get_sidebar('blog'); ?>
                </div>
            </div>
        </div>
    </div><!-- .wrap -->
</div>
<?php get_footer();
