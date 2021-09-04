<?php

/* Prepare
______________________________
*/

// If this file is called directly,abort.
if(!defined('WPINC')){die;}


/* Exec
______________________________
*/
if(class_exists('_structure_front_page') === FALSE) :
class _structure_front_page
{

	private static $_class = '';
	private static $_index = '';
	private $hook = array();

	use _trait_singleton;
	use _trait_theme;


	/* Constructor
	_________________________
	*/
	private function __construct()
	{
		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook();

	}// Method


	/* Setter
	_________________________
	*/
	private function set_hook()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'the_slideshow' => array(
				'beans_id' => $class . '__the_slideshow',
				'hook' => 'windmill/template/toppage/one',
				'callback' => '__the_slideshow',
				'priority' => PRIORITY['default'],
			),
			'the_recent' => array(
				'beans_id' => $class . '__the_recent',
				'hook' => 'windmill/template/toppage/two',
				'callback' => '__the_recent',
				'priority' => PRIORITY['default'],
			),
			'the_card' => array(
				'beans_id' => $class . '__the_card',
				'hook' => 'windmill/template/toppage/three',
				'callback' => '__the_card',
				'priority' => PRIORITY['default'],
			),
			'the_slider' => array(
				'beans_id' => $class . '__the_slider',
				'hook' => 'windmill/template/toppage/four',
				'callback' => '__the_slider',
				'priority' => PRIORITY['default'],
			),
			'the_list' => array(
				'beans_id' => $class . '__the_list',
				'hook' => 'windmill/template/toppage/five',
				'callback' => '__the_list',
				'priority' => PRIORITY['default'],
			),
		));

	}// Method


	/* Method
	_________________________
	 */
	private function invoke_hook()
	{
		if(empty($this->hook)){return;}

		foreach((array)$this->hook as $key => $value){
			beans_add_action($value['beans_id'],$value['hook'],array($this,$value['callback']),$value['priority']);
		}

	}// Method


	public function __the_list()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$r = new WP_Query(array(
			'posts_per_page' => get_option('posts_per_page'),
			'post_status' => 'publish',
			'ignore_sticky_posts' => TRUE,
			'no_found_rows' => TRUE,
		));

		beans_open_markup_e("_wrapper[{$class}][{$function}]",'div',__utility_get_grid('half',array('class' => 'uk-padding-small')));

			while($r->have_posts()) :	$r->the_post();
				get_template_part(SLUG['item'] . 'list');
			endwhile;

			wp_reset_postdata();

		beans_close_markup_e("_wrapper[{$class}][{$function}]",'div');

	}// Method


	public function __the_slider()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$r = new WP_Query(array(
			'posts_per_page' => get_option('posts_per_page'),
			'post_status' => 'publish',
			'ignore_sticky_posts' => TRUE,
			'no_found_rows' => TRUE,
		));
		beans_open_markup_e("_container[{$class}][{$function}]",'div',array('class' => 'uk-position-relative uk-dark'));
			beans_open_markup_e("_effect[{$class}][{$function}]",'div',array('uk-slider' => 'autoplay: true autoplay-interval: 4500 pause-on-hover: true'));
				beans_open_markup_e("_wrapper[{$class}][{$function}]",'div',array(
					'class' => 'uk-slider-items',
				));
				while($r->have_posts()) :	$r->the_post();
					get_template_part(SLUG['item'] . 'gallery');
				endwhile;

				wp_reset_postdata();

				beans_close_markup_e("_wrapper[{$class}][{$function}]",'div');
				// Carousel Pagination
				get_template_part(SLUG['nav'] . 'slider-default');
			beans_close_markup_e("_effect[{$class}][{$function}]",'div');
		beans_close_markup_e("_container[{$class}][{$function}]",'div');

	}// Method


	public function __the_card()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$r = new WP_Query(array(
			'posts_per_page' => get_option('posts_per_page'),
			'post_status' => 'publish',
			'ignore_sticky_posts' => TRUE,
			'no_found_rows' => TRUE,
		));

		beans_open_markup_e("_wrapper[{$class}][{$function}]",'div',__utility_get_grid('half',array('class' => 'uk-padding-small')));

			while($r->have_posts()) :	$r->the_post();
				get_template_part(SLUG['item'] . 'card');
			endwhile;

			wp_reset_postdata();

		beans_close_markup_e("_wrapper[{$class}][{$function}]",'div');

	}// Method


	public function __the_recent()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$r = new WP_Query(array(
			'posts_per_page' => get_option('posts_per_page'),
			'post_status' => 'publish',
			'ignore_sticky_posts' => TRUE,
			'no_found_rows' => TRUE,
		));

		beans_open_markup_e("_wrapper[{$class}][{$function}]",'div',__utility_get_grid('half',array('class' => 'uk-padding-small')));

			while($r->have_posts()) :	$r->the_post();
				get_template_part(SLUG['item'] . 'list');
			endwhile;

			wp_reset_postdata();

		beans_close_markup_e("_wrapper[{$class}][{$function}]",'div');

	}// Method


	public function __the_slideshow()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$r = new WP_Query(array(
			'posts_per_page' => get_option('posts_per_page'),
			'post_status' => 'publish',
			'ignore_sticky_posts' => TRUE,
			'no_found_rows' => TRUE,
		));
		beans_open_markup_e("_container[{$class}][{$function}]",'div',array('class' => 'uk-position-relative uk-dark'));
			beans_open_markup_e("_effect[{$class}][{$function}]",'div',array('uk-slider' => 'autoplay: true autoplay-interval: 4500 pause-on-hover: true'));
				beans_open_markup_e("_wrapper[{$class}][{$function}]",'div',array(
					'class' => 'uk-slider-items',
				));
				while($r->have_posts()) :	$r->the_post();
					get_template_part(SLUG['item'] . 'gallery');
				endwhile;

				wp_reset_postdata();

				beans_close_markup_e("_wrapper[{$class}][{$function}]",'div');
				// Carousel Pagination
				get_template_part(SLUG['nav'] . 'slider-default');
			beans_close_markup_e("_effect[{$class}][{$function}]",'div');
		beans_close_markup_e("_container[{$class}][{$function}]",'div');

	}// Method


}// Class
endif;
// new _structure_front_page();
_structure_front_page::__get_instance();
