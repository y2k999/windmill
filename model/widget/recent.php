<?php
/**
 * Child class that extends WP_Widget (parrent class).
 * @link https://codex.wordpress.org/Widgets_API
 * @package Windmill
 * @license GPL3.0+
 * @since 1.0.1
*/

/**
 * Inspired by Core class used to implement WP_Widget.
 * @link https://codex.wordpress.org/Widgets_API
 * @see WP_Widget
 * 
 * Inspired by Eggnews WordPress theme.
 * @link https://themeegg.com/themes/eggnews/
 * @see ThemeEgg
*/


/* Prepare
______________________________
*/

// If this file is called directly,abort.
if(!defined('WPINC')){die;}

// Set identifiers for this template.
// $index = basename(__FILE__,'.php');


	beans_add_smart_action('widgets_init','__register_widget_recent');
	/**
	 * @reference (Beans)
	 * 	Set beans_add_action() using the callback argument as the action ID.
	 * 	https://www.getbeans.io/code-reference/functions/beans_add_smart_action/
	 * @reference (WP)
	 * 	Fires after all default WordPress widgets have been registered.
	 * 	https://developer.wordpress.org/reference/hooks/widgets_init/
	*/
	if(function_exists('__register_widget_recent') === FALSE) :
	function __register_widget_recent()
	{
		/**
		 * @reference (WP)
		 * 	Register Widget
		 * 	https://developer.wordpress.org/reference/functions/register_widget/
		*/
		register_widget('_widget_recent');

	}// Method
	endif;


/* Exec
______________________________
*/
if(class_exists('_widget_recent') === FALSE) :
class _widget_recent extends WP_Widget
{
/**
 * [TOC]
 * 	__construct()
 * 	set_field()
 * 	widget()
 * 		__the_title()
 * 		__the_nopost()
 * 		get_template_part()
 * 	form()
 * 	update()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $field
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_param = array();
	private $field = array();

	/**
	 * Traits.
	*/
	use _trait_theme;
	use _trait_widget;


	/* Constructor
	_________________________
	*/
	public function __construct()
	{
		/**
			@access (public)
				Sets up a new widget instance.
			@return (void)
			@reference
				[Parent]/inc/utility/general.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);

		$this->field = $this->set_field(self::$_param);

		$widget_options = array(
			'classname' => 'widget' . self::$_class,
			'description' => '[Windmill] ' . ucfirst(self::$_index),
			'customize_selective_refresh' => TRUE,
		);

		parent::__construct(
			self::$_index,
			'[Windmill] ' . ucfirst(self::$_index),
			$widget_options,
		);
		$this->alt_option_name = 'widget' . self::$_class;

	}// Method


	/* Setter
	_________________________
	*/
	private function set_field()
	{
		/**
			@access (private)
				Helper function that holds widget fields.
				Array is used in update and form functions.
			@return (array)
				_filter[_widget_recent][field]
			@reference
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'title' => array(
				'needle' => 'title',
				'label' => esc_html__('Title','windmill'),
				'type' => 'text',
				'default' => esc_html('Recent Posts'),
			),
			/**
			 * @reference (WP)
			 * 	Show at most x many posts on blog pages.
			 * 	https://codex.wordpress.org/Option_Reference
			*/
			'number' => array(
				'needle' => 'number',
				'label' => esc_html__('Number of Posts to Show','windmill'),
				'type' => 'number',
				'default' => get_option('posts_per_page'),
			),
			'format' => array(
				'needle' => 'format',
				'label' => esc_html__('Format','windmill'),
				'type' => 'select',
				'option' => __utility_get_format(),
				'default' => 'card',
			),
		));

	}// Method


	/* Method
	_________________________
	*/
	public function widget($args,$instance)
	{
		/**
			@since 2.8.0
				The WordPress Query class.
				https://developer.wordpress.org/reference/classes/wp_query/
			@param (array) $args
				Display arguments including 'before_title', 'after_title', 'before_widget', and 'after_widget'.
			@param (array) $instance
				Settings for the current Recent Posts widget instance.
			@return (void)
			@reference
				[Parent]/controller/widget.php
				[Parent]/controller/fragment/widget.php
				[Parent]/controller/structure/page.php
				[Parent]/template/content/singular.php
				[Parent]/template-part/content/content-page.php
		*/
		$class = self::$_class;

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		self::$_param['title'] = apply_filters('widget_title',empty($instance['title']) ? $this->field['title']['default'] : $instance['title'],$instance,$this->id_base);
		self::$_param['number'] = (!empty($instance['number'])) ? absint($instance['number']) : $this->field['number']['default'];
		self::$_param['format'] = isset($instance['format']) ? $instance['format'] : $this->field['format']['default'];

		/**
		 * @since 3.4.0
		 * 	Filters the arguments for the Recent Posts widget.
		 * 	https://developer.wordpress.org/reference/classes/wp_query/
		 * @since 4.9.0
		 * 	Added the `$instance` parameter.
		 * @see WP_Query::get_posts()
		 * @param (array) $args
		 * 	An array of arguments used to retrieve the recent posts.
		 * @param (array) $instance
		 * 	Array of settings for the current widget.
		*/
		$r = new WP_Query(
			beans_apply_filters("_filter[{$class}][query]",array(
				'posts_per_page' => self::$_param['number'],
				'post_status' => 'publish',
				'ignore_sticky_posts' => TRUE,
			),$instance));


		/**
		 * @since 1.0.1
		 * 	echo $args['before_widget'];
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_section[{$class}]",'section',__utility_get_column('widget',array('class' => self::$_index)));

			/**
			 * @since 1.0.1
			 * 	echo $args['before_title'] . $param['title'] . $args['after_title'];
			 * @reference
			 * 	This filter is documented in wp-includes/widgets/class-wp-widget-pages.php
			*/
			if(!empty(self::$_param['title'])){
				self::__the_title(self::$_param['title'],'div');
			}

			/**
			 * @reference (WP)
			 * 	Determines whether current WordPress query has posts to loop over.
			 * 	https://developer.wordpress.org/reference/functions/have_posts/
			 * @reference
			 * 	[Parent]/inc/trait/theme.php
			*/
			if(!$r->have_posts()){
				self::__the_nopost();
			}

			/**
				@description
					Widget content.
			*/
			$format = self::$_param['format'];
			switch($format){
				case 'card' :
				case 'gallery' :
					beans_open_markup_e("_wrapper[{$class}]",'div',__utility_get_grid('general','half',array('class' => 'uk-padding-small')));
					break;
				default :
					beans_open_markup_e("_list[{$class}]",'ul');
					beans_add_filter("_class[{$format}][item][unit]",'uk-flex');
					beans_add_filter("_class[{$format}][item][image]",'uk-width-2-5');
					beans_add_filter("_class[{$format}][item][header]",'uk-width-3-5');
					break;
			}
				/**
					@description
						Start the loop.
				*/
				while($r->have_posts()){
					$r->the_post();
					get_template_part(SLUG['item'] . $format,NULL,array('needle' => self::$_index));
				}
				// Only reset the query if a filter is set.
				wp_reset_query();

			switch($format){
				case 'card' :
				case 'gallery' :
					beans_close_markup_e("_wrapper[{$class}]",'div');
					break;
				default :
					beans_close_markup_e("_list[{$class}]",'ul');
					break;
			}
		/**
			@description
				echo $args['after_widget'];
		*/
		beans_close_markup_e("_section[{$class}]",'section');

	}// Method


	/**
	 * [NOTE]
	 * 	form() method and update() method are defined in the trait file.
	 * @reference
	 * 	[Parent]/inc/trait/widget.php
	*/


}// Class
endif;
new _widget_recent();
