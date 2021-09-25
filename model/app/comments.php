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
if(class_exists('_app_comments') === FALSE) :
class _app_comments
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_param()
 * 	set_hook()
 * 	invoke_hook()
 * 	__the_template()
 * 		__the_title()
 * 	__the_status()
 * 	__the_number()
 * 	__the_navigation()
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
				_filter[_app_comments][hook]
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/trait/hook.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$index = self::$_index;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",$this->set_parameter_callback(array(
			'__the_status' => array(
				'beans_id' => $class . '__the_status',
				'tag' => 'beans_add_action',
				'hook' => HOOK_POINT[$index]['prepend']
			),
			'__the_number' => array(
				'beans_id' => $class . '__the_number',
				'tag' => 'beans_add_action',
				'hook' => HOOK_POINT[$index]['prepend']
			),
			'__the_navigation' => array(
				'beans_id' => $class . '__the_navigation',
				'tag' => 'beans_add_action',
				'hook' => HOOK_POINT[$index]['main']
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
				[Parent]/comments.php
				[Parent]/controller/structure/single.php
				[Parent]/inc/env/comment.php
		*/
		$class = self::$_class;

		/**
		 * @reference (WP)
		 * 	Merge user defined arguments into defaults array.
		 * 	https://developer.wordpress.org/reference/functions/wp_parse_args/
		 * @param (string)|(array)|(object) $args
		 * 	Value to merge with $defaults.
		 * @param (array) $defaults
		 * 	Array that serves as the defaults.
		*/
		self::$_param = wp_parse_args($args,self::$_param);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_section[{$class}]",'section',array(
			'id' => self::$_index,
			'class' => self::$_index,
		));

			/**
			 * @since 1.0.1
			 * 	Echo the title.
			 * @reference
			 * 	[Parent]/inc/trait/theme.php
			*/
			if(isset(self::$_param['title'])){
				self::__the_title(self::$_param['title']);
			}

			/**
			 * @reference (WP)
			 * 	Determines whether the current post is open for comments.
			 * 	https://developer.wordpress.org/reference/functions/comments_open/
			 * 	Loads the comment template specified in $file.
			 * 	https://developer.wordpress.org/reference/functions/comments_template/
			*/
			if(comments_open()){
				comments_template();
			}

		beans_close_markup_e("_section[{$class}]",'section');

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_status(){
		/**
			@access (public)
				Echo whether the current post is open for comments.
			@return (void)
			@hook (beans id)
				_app_comments__the_status
			@reference
				[Parent]/inc/utility/general.php
		*/

		// Get current post data.
		$post = __utility_get_post_object();

		/**
		 * @reference (WP)
		 * 	Determines whether the current post is open for comments.
		 * 	https://developer.wordpress.org/reference/functions/comments_open/
		*/
		if(comments_open($post->ID)){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_label[{$class}][{$function}]",'span',array('class' => 'comments-status'));
			beans_output_e("_output[label][{$class}][{$function}]",esc_html__('Comments are Closed!','windmill'));
		beans_close_markup_e("_label[{$class}][{$function}]",'span');

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_number(){
		/**
			@access (public)
				Echo the number of comments the post has.
			@return (void)
			@hook (beans id)
				_app_comments__the_number
			@reference
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$post = __utility_get_post_object();

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_label[{$class}][{$function}]",'div',array('class' => 'uk-margin-auto uk-text-center comments-number'));
			beans_output_e("_output[{$class}][{$function}]",sprintf(
				'Number of Comments : <span class="uk-link">%s</span>',
				/**
				 * @reference (WP)
				 * 	Retrieves the amount of comments a post has.
				 * 	https://developer.wordpress.org/reference/functions/get_comments_number/
				*/
				get_comments_number($post->ID))
			);
		beans_close_markup_e("_label[{$class}][{$function}]",'div');

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_navigation()
	{
		/**
			@access (public)
				Echo the navigation to next/previous set of comments, when applicable.
			@return (void)
			@hook (beans id)
				_app_comments__the_navigation
			@reference (Uikit)
				https://getuikit.com/docs/icon
				https://getuikit.com/docs/pagination
			@reference
				[Parent]/inc/utility/general.php
		*/

		/**
		 * @reference (WP)
		 * 	Calculate the total number of comment pages.
		 * 	https://developer.wordpress.org/reference/functions/get_comment_pages_count/
		 * 	Break comments into pages
		 * 	https://codex.wordpress.org/Option_Reference
		*/
		if(get_comment_pages_count() <= 1 && !get_option('page_comments')){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_wrapper[{$class}][{$function}]",'nav',array(
			'role' => 'navigation',
			'aria-label' => esc_attr('Comments Navigation'),
		));
			beans_open_markup_e("_list[{$class}][{$function}]",'ul',array(
				'class' => 'uk-pagination uk-flex-center',
			));
				/**
				 * @reference (WP)
				 * 	Retrieves the link to the previous comments page.
				 * 	https://developer.wordpress.org/reference/functions/get_previous_comments_link/
				*/
				if(get_previous_comments_link()){
					beans_open_markup_e("_item[{$class}][{$function}][previous]",'li',array('class' => 'uk-pagination-previous'));
						$previous_icon = beans_open_markup("_icon[{$class}][{$function}][previous]",'span',array(
							'class' => 'uk-margin-small-right',
							'uk-icon' => 'icon: chevron-left; ratio: 1.5',
							'aria-hidden' => 'true',
						));
						$previous_icon .= beans_close_markup("_icon[{$class}][{$function}][previous]",'span');
						/* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped -- Echoes HTML output. */
						echo get_previous_comments_link($previous_icon . beans_output("_output[{$class}][{$function}][previous]",esc_html__(' Previous','windmill')));
					beans_close_markup_e("_item[{$class}][{$function}][previous]",'li');
				}

				/**
				 * @reference (WP)
				 * 	Retrieves the link to the next comments page.
				 * 	https://developer.wordpress.org/reference/functions/get_next_comments_link/
				*/
				if(get_next_comments_link()){
					beans_open_markup_e("_item[{$class}][{$function}][next]",'li',array('class' => 'uk-pagination-next'));
						$next_icon  = beans_open_markup("_icon[{$class}][{$function}][next]",'span',array(
							'class' => 'margin-small-right',
							'uk-icon' => 'icon: chevron-right; ratio: 1.5',
							'aria-hidden' => 'true',
						));
						$next_icon .= beans_close_markup("_icon[{$class}][{$function}][next]",'span');
						/* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped -- Echoes HTML output. */
						echo get_next_comments_link(beans_output("_output[{$class}][{$function}][next]",esc_html__('Next ','windmill')) . $next_icon);
					beans_close_markup_e("_item[{$class}][{$function}][next]",'li');
				}

			beans_close_markup_e("_list[{$class}][{$function}]",'ul');
		beans_close_markup_e("_wrapper[{$class}][{$function}]",'nav');

	}// Method


}// Class
endif;
// new _app_comments();
_app_comments::__get_instance();
