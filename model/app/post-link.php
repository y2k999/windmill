<?php
/**
 * Render Application.
 * @package Windmill
 * @license GPL3.0+
 * @since 1.0.1
*/

/**
 * Inspired by Beans Framework WordPress Theme
 * @link https://www.getbeans.io
 * @author Thierry Muller
*/


/* Prepare
______________________________
*/

// If this file is called directly,abort.
if(!defined('WPINC')){die;}

// Set identifiers for this template.
// $index = basename(__FILE__,'.php');


/* Exec
______________________________
*/
if(class_exists('_app_post_link') === FALSE) :
class _app_post_link
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_param()
 * 	set_hook()
 * 	invoke_hook()
 * 	__the_template()
 * 	__the_devider()
 * 	__the_render()
 * 	__get_link()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $_param
			Parameter for the application.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_param = array();
	private $hook = array();

	/**
	 * Traits.
	*/
	use _trait_hook;
	use _trait_singleton;
	use _trait_theme;


	/* Constructor
	_________________________
	*/
	private function __construct()
	{
		/**
			@access (private)
				Class constructor.
				This is only called once, since the only way to instantiate this is with the get_instance() method in trait (singleton.php).
			@return (void)
			@reference
				[Parent]/inc/trait/singleton.php
				[Parent]/inc/trait/theme.php
				[Parent]/inc/utility/general.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);
		self::$_param = $this->set_param(self::$_index);

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook($this->hook);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_hook()
	{
		/**
			@access (private)
				The collection of hooks that is being registered (that is, actions or filters).
			@return (array)
				_filter[_app_post_link][hook]
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/trait/hook.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);
		$index = str_replace('_','-',self::$_index);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",$this->set_parameter_callback(array(
			'__the_devider' => array(
				'beans_id' => $class . '__the_devider',
				'tag' => 'beans_add_action',
				'hook' => HOOK_POINT['model'][$index]['prepend']
			),
			'__the_render' => array(
				'beans_id' => $class . '__the_render',
				'tag' => 'beans_add_action',
				'hook' => HOOK_POINT['model'][$index]['main']
			),
		)));

	}// Method


	/* Method
	_________________________
	*/
	public static function __the_template($args = array())
	{
		/**
			@access (private)
				Load and echo this application.
			@param (array) $args
				Additional arguments passed to this application.
			@return (void)
			@reference
				[Parent]/controller/structure/single.php
				[Parent]/inc/setup/constant.php
				[Parent]/template/content/single.php
				[Parent]/template-part/content/content.php
		*/
		$class = self::$_class;
		$index = str_replace('_','-',self::$_index);

		/**
		 * @reference (Beans)
		 * 	Filter whether {@see beans_post_navigation()} should be short-circuit or not.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		 * @param (bool) $pre
		 * 	True to short-circuit,False to let the function run.
		*/
		if(beans_apply_filters("_filter[pre][{$class}]",!is_singular('post'))){return;}

		/**
		 * @reference (WP)
		 * 	Merge user defined arguments into defaults array.
		 * 	https://developer.wordpress.org/reference/functions/wp_parse_args/
		 * 	@param (string)|(array)|(object) $args
		 * 	Value to merge with $defaults.
		 * @param (array) $defaults
		 * 	Array that serves as the defaults.
		*/
		self::$_param = wp_parse_args($args,self::$_param);

		do_action(HOOK_POINT['model'][$index]['prepend']);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		 * @reference (Uikit)
		 * 	https://getuikit.com/docs/flex
		 * 	https://getuikit.com/docs/pagination
		*/
		beans_open_markup_e("_nav[{$class}]",'nav',array(
			'role' => 'navigation',
			/* Attributes are automatically escaped. */
			'aria-label' => esc_attr('Post Links'),
		));
			// beans_open_markup_e("_list[{$class}]",'ul',array('class' => 'uk-pagination uk-flex-center uk-flex-between uk-margin-large-top ' . $index));
			beans_open_markup_e("_list[{$class}]",'ul',array(
				'class' => 'uk-pagination uk-grid-collapse uk-child-width-auto@s uk-child-width-1-2@m ' . $index,
				'uk-grid' => 'uk-grid'
			));

			/**
				@hooked
					_app_post_link::__the_render()
				@reference
					[Parent]/model/app/post-link.php
			*/
			do_action(HOOK_POINT['model'][$index]['main']);

			beans_close_markup_e("_list[{$class}]",'ul');
		beans_close_markup_e("_nav[{$class}]",'nav');

		do_action(HOOK_POINT['model'][$index]['append']);

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_devider()
	{
		/**
			@access (public)
				Create dividers to separate content and apply different styles to them.
			@return (void)
			@hook (beans id)
				_app_post_link__the_devider
			@reference
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Echo self-close markup and attributes registered by ID.
		 * 	https://www.getbeans.io/code-reference/functions/beans_selfclose_markup_e/
		 * @reference (Uikit)
		 * 	https://getuikit.com/docs/divider
		*/
		beans_selfclose_markup_e("_devider[{$class}[{$function}]",'hr',array('class' => 'uk-devider-small uk-margin-large-top'));

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_render()
	{
		/**
			@access (public)
				Echo next or previous post.
			@return (void)
			@hook (beans id)
				_app_post_link__the_render
			@reference
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;

		// Get current post data.
		$post = __utility_get_post_object();

		/**
		 * @reference (WP)
		 * 	Determines whether the query is for an existing attachment page.
		 * 	https://developer.wordpress.org/reference/functions/is_attachment/
		 * 	Retrieves the adjacent post.
		 * 	https://developer.wordpress.org/reference/functions/get_adjacent_post/
		*/
		$previous = is_attachment() ? $post->post_parent : get_adjacent_post(FALSE,'',TRUE);
		$next = get_adjacent_post(FALSE,'',FALSE);
		if(!$next && !$previous){return;}

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		if($previous){
			/**
			 * @reference (WP)
			 * 	Retrieves the previous post link that is adjacent to the current post.
			 * 	https://developer.wordpress.org/reference/functions/get_previous_post_link/
			*/
			beans_open_markup_e("_item[{$class}][previous]",'li');
				beans_open_markup_e("_label[{$class}][previous]",'span',array('class' => 'uk-pagination-previous uk-padding-small uk-align-left'));
					/* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped -- Echoes HTML output. */
					// echo get_previous_post_link(self::$_param['previous'],beans_output("_output[{$class}][previous]",esc_html__('Previous Page','windmill')));
					echo get_previous_post_link(self::$_param['previous'],'%title');
				beans_close_markup_e("_label[{$class}][previous]",'span');
			beans_close_markup_e("_item[{$class}][previous]",'li');
		}

		if($next){
			/**
			 * @reference (WP)
			 * 	Retrieves the next post link that is adjacent to the current post.
			 * 	https://developer.wordpress.org/reference/functions/get_next_post_link/
			*/
			beans_open_markup_e("_item[{$class}][next]",'li');
				beans_open_markup_e("_label[{$class}][next]",'span',array('class' => 'uk-pagination-next uk-padding-small uk-align-right'));
					/* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped -- Echoes HTML output. */
					// echo get_next_post_link(self::$_param['next'],beans_output("_output[{$class}][next]",esc_html__('Next Page','windmill')));
					echo get_next_post_link(self::$_param['next'],'%title');
				beans_close_markup_e("_label[{$class}][next]",'span');
			beans_close_markup_e("_item[{$class}][next]",'li');
		}

	}// Method


}// Class
endif;
// new _app_post_link();
_app_post_link::__get_instance();
