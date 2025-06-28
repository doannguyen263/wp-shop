<?php

/**
 * Adds Foo_Widget widget.
 */
class DnTheme_Widget extends WP_Widget
{

	/**
	 * Register widget with WordPress.
	 */
	function __construct()
	{
		parent::__construct(
			'dntheme_widget', // Base ID
			esc_html__('DN_Theme Widget', 'dntheme'), // Name
			array('description' => esc_html__('DN_Theme Widget', 'dntheme'),) // Args
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
		echo esc_html__('Hello, World!', 'dntheme');
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
?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'dntheme'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('sub')); ?>"><?php esc_attr_e('Nội dung', 'dntheme'); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('sub')); ?>" name="<?php echo esc_attr($this->get_field_name('sub')); ?>" cols="30" rows="10"><?php echo esc_attr($sub); ?></textarea>
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
		$instance['title'] = (! empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['sub'] = (! empty($new_instance['sub'])) ? strip_tags($new_instance['sub']) : '';

		return $instance;
	}
} // class Foo_Widget


function register_dntheme_widget()
{
	register_widget('DnTheme_Widget');
}
add_action('widgets_init', 'register_dntheme_widget');
