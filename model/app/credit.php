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
if(class_exists('_app_credit') === FALSE) :
class _app_credit
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_credit()
 * 	set_poweredby()
 * 	set_param()
 * 	set_hook()
 * 	invoke_hook()
 * 	__the_template()
 * 	__the_render()
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
		@var (string) $copyright
			Copyright of your blog.
		@var (string) $poweredby
			WordPress lisence.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_param = array();
	private $copyright = '';
	private $poweredby = '';
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

		$this->copyright = $this->set_copyright();
		$this->poweredby = $this->set_poweredby();

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook($this->hook);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_copyright()
	{
		/**
			@access (private)
				Set html for the copyright.
			@return (array)
				_filter[_app_credit][copyright]
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
		return beans_apply_filters("_filter[{$class}][{$function}]",sprintf(
			// 'Copyright &copy; %1$s <a href="%2$s" rel="home">%3$s</a> All Rights Reserved.',
			'<span itemprop="copyrightYear">Copyright &copy; %1$s </span><a href="%2$s" itemprop="copyrightHolder name" rel="home">%3$s</a> All Rights Reserved.',
			/**
			 * @reference (WP)
			 * 	Retrieves the date, in localized format.
			 * 	https://developer.wordpress.org/reference/functions/wp_date/
			 * 	Retrieves the URL for the current site where the front end is accessible.
			 * 	https://developer.wordpress.org/reference/functions/home_url/
			 * 	Retrieves information about the current site.
			 * 	https://developer.wordpress.org/reference/functions/get_bloginfo/
			*/
			// date_i18n(get_option('date_format')),
			esc_attr(wp_date(get_option('date_format'))),
			esc_url(home_url('/')),
			get_bloginfo('name')
		));

	}// Method


	/* Setter
	_________________________
	*/
	private function set_poweredby()
	{
		/**
			@access (private)
				Set html for the powerdby.
			@return (string)
				_filter[_app_credit][poweredby]
			@reference
				[Parent]/inc/utility/general.php
				[Parent]/inc/utility/theme.php
				[Parent]/model/data/icon.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",sprintf(
			/* translators: %s: WordPress. */
			'Powered by <a href="%1$s" target="_blank" aria-label="WordPress" rel="nofollow noopener noreferrer">%2$s</a>',
			esc_url('https://wordpress.org/'),
			__utility_get_icon('wordpress')
		));

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
				_filter[_app_credit][hook]
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
				[Parent]/footer.php
				[Parent]/controller/structure/footer.php
				[Parent]/inc/setup/constant.php
				[Parent]/model/wrap/credit.php
				[Parent]/template/footer/footer.php
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

		/**
			@hooked
				__wrap_credit_prepend()
			@reference
				[Parent]/model/wrap/credit.php
		*/
		do_action(HOOK_POINT['model'][$index]['prepend']);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_label[{$class}]",'span');

		/**
			@hooked
				_app_credit::__the_render()
			@reference
				[Parent]/model/app/credit.php
		*/
			do_action(HOOK_POINT['model'][$index]['main']);

		beans_close_markup_e("_label[{$class}]",'span');

		/**
			@hooked
				__wrap_credit_append()
			@reference
				[Parent]/model/wrap/credit.php
		*/
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
			@return (void)
			@hook (beans id)
				_app_credit__the_render
			@reference
				[Parent]/inc/customizer/option.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		*/
		if(!empty(__utility_get_option(self::$_index))){
			beans_output_e("_output[{$class}]",__utility_get_option(self::$_index));
		}
		else{
			beans_output_e("_output[{$class}]",$this->copyright . (isset($this->poweredby) ? ' ' . DIRECTORY_SEPARATOR . ' ' . $this->poweredby : ''));
		}

	}// Method


}// Class
endif;
// new _app_credit();
_app_credit::__get_instance();
