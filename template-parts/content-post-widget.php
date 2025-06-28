<?php

/**
 * Template part for displaying posts with excerpts
 *
 * Used in Search Results and for Recent Posts in Front Page panels.
 *
 *
 * @package    WordPress
 * @subpackage Dntheme
 * @version 1.0
 */
$categories = get_the_category();

?>
<article class="archive__item widget__item mb-2">
  <div class="row g-3">
    <div class="col-4 col-lg-4">
      <div class="item__thumb">
        <a href="<?php the_permalink(); ?>" class="dnfix__thumb">
          <?php the_post_thumbnail('medium', array('class' => 'img-fluid', 'alt'   => get_the_title())); ?>
        </a>
      </div><!-- .post-thumbnail -->
    </div>
    <div class="col-8 col-lg-8">
      <h3 class="entry-title item__title">
        <a href="<?php echo esc_url(get_permalink()); ?>" title="<?php the_title(); ?>" rel="bookmark">
          <?php the_title(); ?>
        </a>
      </h3>
    </div>
  </div>
</article><!-- #post-## -->