<?php

/**
 * Template part for displaying posts
 *
 * @package    WordPress
 * @subpackage Dntheme
 * @version 1.0
 */
$categories = get_the_category(get_the_ID());
$cat_name = $categories[0]->name;
$cat_link = get_category_link($categories[0]);
?>
<div class="single__wrap">
  <div class="page__header mb-3">
    <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
    <div class="single__by">
      <span class="single__date"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo get_the_time("d/m/Y"); ?></span>
    </div>
  </div>
  <div class="entry-content">
    <?php the_content() ?>
  </div>
  <div class="single__share">
    <div class="single__share__title">Chia sẻ tin tức này</div>
    <ul class="">
      <li><a href="https://www.facebook.com/sharer.php?u=<?php the_permalink() ?>" class="-fb"><span class="icon-facebook"></span></a></li>
      <li><a href="https://telegram.me/share/url?url=<?php the_permalink() ?>&text=<?php the_title() ?>" class="-tele"><span class="icon-telegram"></span></a></li>
      <li><a href="https://twitter.com/intent/tweet?&url=<?php the_permalink() ?>" class="-tw"><span class="icon-twitter"></span></a></li>
    </ul>
  </div>
</div>


<?php
related_category_fix(
  array(
    'posts_per_page'    => 6,
    'related_title'     => __('Bài viết liên quan', 'dntheme'),
    'template_type'     => '', // slider , widget
    'template'          => 'content-archive-full',
    'set_taxonomy'      => null,
    'class_item'        => 'col-md-4',
  )
);
?>