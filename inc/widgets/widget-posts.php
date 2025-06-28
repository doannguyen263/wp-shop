<?php

/**
 * Adds Foo_Widget widget.
 */
class DnWidget_Posts extends WP_Widget
{

	/**
	 * Register widget with WordPress.
	 */
	function __construct()
	{
		parent::__construct(
			'dnwidget_posts', // Base ID
			esc_html__('DN Widget Posts', 'dntheme'), // Name
			array('description' => esc_html__('DN Widget Posts', 'dntheme'),) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget($args, $instance)
	{
		echo $args['before_widget'];
		if (! empty($instance['title'])) {
			echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
		}
		$the_query = new WP_Query(array(
			'post_type' => 'service',
			'posts_per_page' => -1
		));
		if ($the_query->have_posts()) { ?>
			<div class="widget-content">
				<?php while ($the_query->have_posts()) {
					$the_query->the_post(); ?>
					<?php get_template_part('template-parts/content', 'post-widget'); ?>
				<?php } ?>
			</div>
		<?php }
		wp_reset_postdata();
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form($instance)
	{
		// outputs the options form on admin
		$defaults = array(
			'title' => 'Show Posts',
			'number' => 10,
			'post_type' => '',
			'choose_post' => '',
		);

		$instance = extract(wp_parse_args((array) $instance, $defaults));
		?>
		<!-- Title -->
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'dntheme'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
		</p>
		<!-- Post type -->
		<p>
			<?php
			$args       = array(
				'public' => true,
			);
			$post_types = get_post_types($args, 'objects');
			unset($post_types['attachment']);
			?>
			<label for="<?php echo esc_attr($this->get_field_id('post_type')); ?>"><?php esc_attr_e('Post type:', 'dntheme'); ?></label>
			<select name="<?php echo esc_attr($this->get_field_name('post_type')); ?>" id="<?php echo esc_attr($this->get_field_id('post_type')); ?>" class="js-post_type">
				<?php foreach ($post_types as $object) {
					$checked = ($post_type == $object->name) ? 'selected' : '';
				?>
					<option value="<?= $object->name ?>" <?= $checked ?>><?= $object->label ?></option>
				<?php } ?>
			</select>
		</p>
		<!-- Show post -->
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_attr_e('Show post:', 'dntheme'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="number" value="<?php echo esc_attr($number); ?>">
		</p>
		<p> or </p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('choose_post')); ?>"><?php esc_attr_e('Choose post:', 'dntheme'); ?></label>


			<input class="widefat js-post_type_post" id="<?php echo esc_attr($this->get_field_id('choose_post')); ?>" name="<?php echo esc_attr($this->get_field_name('choose_post')); ?>" type="text" value="<?php echo esc_attr($choose_post); ?>" data-post_type="<?= $post_type ?>">
		</p>

		<script>
			jQuery(document).ready(function() {

				jQuery('.js-post_type').on("change", function(e) {
					jQuery('.js-post_type_post').attr('data-post_type', jQuery(this).val())
				});

			});
		</script>
<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update($new_instance, $old_instance)
	{
		$instance = array();
		$instance['title'] 			= (! empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['number'] 		= (! empty($new_instance['number'])) ? strip_tags($new_instance['number']) : '';
		$instance['post_type'] 		= (! empty($new_instance['post_type'])) ? strip_tags($new_instance['post_type']) : '';
		$instance['choose_post'] 	= (! empty($new_instance['choose_post'])) ? strip_tags($new_instance['choose_post']) : '';

		return $instance;
	}
} // class Foo_Widget


function register_dnwidget_posts()
{
	register_widget('DnWidget_Posts');
}
add_action('widgets_init', 'register_dnwidget_posts');
