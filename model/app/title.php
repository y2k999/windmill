<?php
/**
 * Load applications according to the settings and conditions.
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
if(class_exists('_app_title') === FALSE) :
class _app_title
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_param()
 * 	set_hook()
 * 	invoke_hook()
 * 	__the_template()
 * 	__the_render()
 * 	the_page_title()
 * 	the_post_title()
 * 	the_item_title()
 * 	the_default_title()
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

		/**
		 * @reference (WP)
		 * 	Determines whether the current request is for an administrative interface page.
		 * 	https://developer.wordpress.org/reference/functions/is_admin/
		*/
		if(is_admin()){return;}

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
				_filter[_app_title][hook]
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/trait/hook.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);
		$index = self::$_index;

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",$this->set_parameter_callback(array(
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
				[Parent]/controller/fragment/image.php
				[Parent]/inc/setup/constant.php
		*/
		$class = self::$_class;
		$index = self::$_index;

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

		do_action(HOOK_POINT['model'][$index]['prepend']);

		/**
			@hooked
				_app_title::__the_render()
			@reference
				[Parent]/model/app/title.php
		*/
		do_action(HOOK_POINT['model'][$index]['main']);

		do_action(HOOK_POINT['model'][$index]['append']);

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_render()
	{
		/**
			@access (public)
				Echo the content of the application.
			@hook (beans id)
				_app_title__the_render
			@return (void)
		*/
		switch(self::$_param['needle']){
			case 'page' :
				$this->the_page_title();
				break;

			case 'general' :
			case 'card' :
			case 'gallery' :
			case 'list' :
				$this->the_item_title(self::$_param['needle']);
				break;

			case 'single' :
			case 'archive' :
			case 'home' :
			case 'search' :
				$this->the_post_title(self::$_param['needle']);
				break;

			case 'figcaption' :
			default :
				$this->the_default_title(self::$_param['needle']);
				break;
		}

	}// Method


	/**
		@access (private)
			Echo the page title.
		@global (WP_Query) $wp_query
			https://developer.wordpress.org/reference/classes/wp_query/
		@return (void)
		@reference
			[Parent]/inc/customizer/option.php
			[Parent]/inc/utility/general.php
			[Parent]/inc/utility/theme.php
	*/
	private function the_page_title()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		if(is_404()){
			/**
			 * @reference (Beans)
			 * 	HTML markup.
			 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
			 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
			*/
			beans_open_markup_e("_tag[{$class}][{$function}][404]",__utility_get_option('tag_page-title'),array(
				'class' => 'uk-heading-primary uk-padding-small uk-text-truncate page-title',
				'itemprop' => 'headline name',
			));
				echo __('Nothing Found','windmill');
			beans_close_markup_e("_tag[{$class}][{$function}][404]",__utility_get_option('tag_page-title'));
		}
		elseif(is_front_page()){

		}
		elseif(__utility_is_archive() || is_home() || is_search()){
			/**
			 * @reference (Beans)
			 * 	HTML markup.
			 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup/
			 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup/
			 * @reference (Uikit)
			 * 	https://getuikit.com/docs/heading
			*/
			$before = beans_open_markup("_tag[{$class}][{$function}][archive]",__utility_get_option('tag_page-title'),array(
				'class' => 'uk-heading-line uk-text-center uk-padding-small uk-text-truncate page-title',
				'itemprop' => 'headline name',
			));
			$before .= beans_open_markup("_label[{$class}][{$function}][archive]",'span',array('class' => 'uk-margin-small-bottom'));

				// WP global.
				global $wp_query;
				$after = '：' . $wp_query->found_posts;

			$after .= beans_close_markup("_label[{$class}][{$function}][archive]",'span');
			$after .= beans_close_markup("_tag[{$class}][{$function}][archive]",__utility_get_option('tag_page-title'));

			beans_open_markup_e("_grid[{$class}][{$function}][archive]",'div',__utility_get_grid());
			beans_open_markup_e("_column[{$class}][{$function}][archive]",'div',__utility_get_column('full'));

				/**
				 * @since 1.0.1
				 * 	For Centering display: inline-block
				 * @reference (WP)
				 * 	Display the archive title based on the queried object.
				 * 	https://developer.wordpress.org/reference/functions/the_archive_title/
				*/
				the_archive_title($before,$after);

			beans_close_markup_e("_column[{$class}][{$function}][archive]",'div');
			beans_close_markup_e("_grid[{$class}][{$function}][archive]",'div');
		}
		elseif(is_singular()){

		}

	}// Method


	/**
		@access (private)
			Echo the post title.
		@param (string) $needle
		@return (void)
		@reference
			[Parent]/inc/customizer/option.php
			[Parent]/inc/utility/general.php
	*/
	private function the_post_title($needle = '')
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// Get current post data.
		$post = __utility_get_post_object();

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup/
		 * @reference (Uikit)
		 * 	https://getuikit.com/docs/article
		*/
		$before = beans_open_markup("_tag[{$class}][{$function}][{$needle}]",__utility_get_option('tag_post-title'),array(
			'class' => 'uk-article-title uk-padding-small uk-text-truncate post-title',
			'itemprop' => 'headline name',
		));
		$after = beans_close_markup("_tag[{$class}][{$function}][{$needle}]",__utility_get_option('tag_post-title'));

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_link[{$class}][{$function}][{$needle}]",'a',array(
			'href' => get_permalink($post->ID),
			'title' => the_title_attribute('echo=0'),
			'itemprop' => 'url',
		));
			/**
			 * @reference (WP)
			 * 	Display or retrieve the current post title with optional markup.
			 * 	https://developer.wordpress.org/reference/functions/the_title/
			*/
			the_title($before,$after);

		beans_close_markup_e("_link[{$class}][{$function}][{$needle}]",'a');

	}// Method


	/**
		@access (private)
			Echo the archive list title.
		@param (string) $needle
		@return (void)
		@reference
			[Parent]/inc/customizer/option.php
			[Parent]/inc/utility/general.php
	*/
	private function the_item_title($needle = '')
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// Get current post data.
		$post = __utility_get_post_object();

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup/
		*/
		$before = beans_open_markup("_tag[{$class}][{$function}][{$needle}]",__utility_get_option('tag_item-title'),array(
			'class' => 'uk-heading-bullet',
			'itemprop' => 'headline name',
		));
		$after = beans_close_markup("_tag[{$class}][{$function}][{$needle}]",__utility_get_option('tag_item-title'));

		/**
		 * @reference (WP)
		 * 	https://developer.wordpress.org/reference/functions/the_title/
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_link[{$class}][{$function}][{$needle}]",'a',array(
			'href' => get_permalink($post->ID),
			'title' => the_title_attribute('echo=0'),
			'itemprop' => 'url',
		));
			/**
			 * @reference (WP)
			 * 	Display or retrieve the current post title with optional markup.
			 * 	https://developer.wordpress.org/reference/functions/the_title/
			*/
			the_title($before,$after);
		beans_close_markup_e("_link[{$class}][{$function}][{$needle}]",'a');

	}// Method


	/**
		@access (private)
			Echo the title.
		@param (string) $needle
		@return (void)
	*/
	private function the_default_title($needle = '')
	{
		$class = self::$_class;
		// $function = __utility_get_function(__FUNCTION__);

		// Get current post data.
		$post = __utility_get_post_object();

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup/
		*/
		$before = beans_open_markup("_tag[{$class}][{$needle}]",'h5',array(
			'class' => 'uk-heading-divider',
			'itemprop' => 'headline name',
		));
		$after = beans_close_markup("_tag[{$class}][{$needle}]",'h5');

		/**
		 * @reference (WP)
		 * 	https://developer.wordpress.org/reference/functions/the_title/
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_link[{$class}][{$needle}]",'a',array(
			'href' => get_permalink($post->ID),
			'title' => the_title_attribute('echo=0'),
			'itemprop' => 'url',
		));
			/**
			 * @reference (WP)
			 * 	Display or retrieve the current post title with optional markup.
			 * 	https://developer.wordpress.org/reference/functions/the_title/
			*/
			the_title($before,$after);
		beans_close_markup_e("_link[{$class}][{$needle}]",'a');

	}// Method


}//Class
endif;
// new _app_title();
_app_title::__get_instance();
