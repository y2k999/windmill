<?php
/**
 * Set environmental configurations which enhance the theme by hooking into WordPress.
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
if(class_exists('_env_foot') === FALSE) :
class _env_foot
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_handle()
 * 	set_hook()
 * 	invoke_hook()
 * 	javascript_to_footer()
 * 	dequeue_css_header()
 * 	enqueue_css_footer()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $handle
			Collection of handles for wp_enqueue_script.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private $handle = array();
	private $hook = array();

	/**
	 * Traits.
	*/
	use _trait_hook;
	use _trait_singleton;


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
		$this->handle = $this->set_handle();

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook($this->hook);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_handle()
	{
		/**
			@access (private)
				Set the handle for wp_enqueue_script.
			@return (array)
				_filter[_env_foot][handle]
			@reference
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",array(
			'dashicons',
			'admin-bar',
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
				_filter[_env_foot][hook]
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/trait/hook.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",$this->set_parameter_callback(array(
			'javascript_to_footer' => array(
				'tag' => 'add_action',
				'hook' => 'wp_enqueue_scripts',
				'priority' => PRIORITY['mid-high']
			),
			'dequeue_css_header' => array(
				'tag' => 'add_action',
				'hook' => 'wp_enqueue_scripts',
				'priority' => PRIORITY['mid-high']
			),
			'enqueue_css_footer' => array(
				'tag' => 'add_action',
				'hook' => 'wp_footer',
				'priority' => PRIORITY['mid-high']
			),
		)));

	}// Method


	/* Hook
	_________________________
	*/
	public function javascript_to_footer()
	{
		/**
			@access (public)
				Move your JS files in the footer.
			@return (void)
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/general.php
		*/

		/**
		 * @reference (WP)
		 * 	Determines whether the current request is for an administrative interface page.
		 * 	https://developer.wordpress.org/reference/functions/is_admin/
		 * 	Whether the site is being previewed in the Customizer.
		 * 	https://developer.wordpress.org/reference/functions/is_customize_preview/
		*/
		if(is_admin() || is_customize_preview()){return;}

		/**
		 * @reference (WP)
		 * 	Prints scripts or data in the head tag on the front end.
		 * 	https://developer.wordpress.org/reference/hooks/wp_head/
		*/
		remove_action('wp_head','wp_print_scripts');
		remove_action('wp_head','wp_print_head_scripts',PRIORITY['mid-low']);
		remove_action('wp_head','wp_enqueue_scripts',PRIORITY['min']);

		/**
		 * @reference (WP)
		 * 	Prints scripts or data before the closing body tag on the front end.
		 * 	https://developer.wordpress.org/reference/hooks/wp_footer/
		*/
		add_action('wp_footer','wp_print_scripts',5);
		add_action('wp_footer','wp_print_head_scripts',5);
		add_action('wp_footer','wp_enqueue_scripts',5);

	}// Method


	/* Hook
	_________________________
	*/
	public function dequeue_css_header()
	{
		/**
			@access (public)
				Remove a previously enqueued CSS stylesheet.
				https://developer.wordpress.org/reference/functions/wp_dequeue_style/
				Remove a registered stylesheet.
				https://developer.wordpress.org/reference/functions/wp_deregister_style/
			@return (void)
		*/

		/**
		 * @reference (WP)
		 * 	Determines whether the current visitor is a logged in user.
		 * 	https://developer.wordpress.org/reference/functions/is_user_logged_in/
		*/
		if(!is_user_logged_in()){
			foreach($this->handle as $handle){
				wp_dequeue_style($handle);
				wp_deregister_style($handle);
			}
		}
		// wp_dequeue_style('wp-block-library');
		// wp_dequeue_style('wp-block-library-theme');

	}// Method


	/* Hook
	_________________________
	*/
	public function enqueue_css_footer()
	{
		/**
			@access (public)
				Enqueue a CSS stylesheet.
				https://developer.wordpress.org/reference/functions/wp_enqueue_style/
			@return (void)
		*/
		foreach($this->handle as $handle){
			wp_enqueue_style($handle);
		}
		// wp_enqueue_style('wp-block-library');
		// wp_enqueue_style('wp-block-library-theme');

	}// Method


}// Class
endif;
// new _env_foot();
_env_foot::__get_instance();
