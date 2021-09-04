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
if(class_exists('_env_inline_style') === FALSE) :
class _env_inline_style
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_src()
 * 	set_hook()
 * 	invoke_hook()
 * 	wp_add_inline_style()
 * 	delete_dummy()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (string) $theme
			Name of the current theme.
		@var (array) $src
			Files that includes the inline css.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private $theme = '';
	private $src = array();
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
				[Parent]/inc/utility/general.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);

		$this->src = $this->set_src();

		/**
		 * Register hooks.
		 * wp_print_styles() and wp_print_scripts() are not recommended since WP 3.3.
		*/
		$this->hook = $this->set_hook();
		$this->invoke_hook($this->hook);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_src()
	{
		/**
			@access (private)
				Set the inline css.
			@return (array)
				_filter[_env_inline_style][src]
			@reference
				[Parent]/asset/inline/base.php
				[Parent]/asset/inline/button.php
				[Parent]/asset/inline/follow.php
				[Parent]/asset/inline/heading.php
				[Parent]/asset/inline/image.php
				[Parent]/asset/inline/nav.php
				[Parent]/asset/inline/pagination.php
				[Parent]/asset/inline/share.php
				[Parent]/inc/customizer/option.php
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
			'base',
			// 'image',
			'heading',
			'button',
			'nav',
			!empty(__utility_get_value('share')) ? 'share' : '',
			!empty(__utility_get_value('follow')) ? 'follow' : '',
			!empty(__utility_get_option('skin_nav_pagination')) ? 'pagination' : '',
			// __utility_is_archive() ? 'pagination' : '',
			// __utility_get_post_type() === 'archive' ? 'pagination' : '',
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
				_filter[_env_inline_style][hook]
			@reference
				[Parent]/inc/trait/hook.php
				[Parent]/inc/utility/general.php
		*/

		/**
		 * @reference (WP)
		 * 	Determines whether the current request is for an administrative interface page.
		 * 	https://developer.wordpress.org/reference/functions/is_admin/
		*/
		if(is_admin()){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",$this->set_parameter_callback(array(
			'wp_add_inline_style' => array(
				'tag' => 'add_action',
				'hook' => 'wp_enqueue_scripts'
			),
		)));

	}// Method


	/* Hook
	_________________________
	*/
	public function wp_add_inline_style()
	{
		/**
			@access (public)
				Print innline styles.
				https://developer.wordpress.org/reference/functions/wp_add_inline_style/
			@return (void)
			@reference
				https://www.mirucon.com/2017/06/29/wordpress-enqueue-inline-scripts/
				[Parent]/asset/inline/base.php
				[Parent]/asset/inline/button.php
				[Parent]/asset/inline/follow.php
				[Parent]/asset/inline/heading.php
				[Parent]/asset/inline/image.php
				[Parent]/asset/inline/nav.php
				[Parent]/asset/inline/pagination.php
				[Parent]/asset/inline/share.php
				[Parent]/inc/setup/constant.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$return = '';

		foreach($this->src as $item){
			if(file_exists(PATH['inline'] . $item . '.php')){
				get_template_part(SLUG['inline'] . $item);
				$class = PREFIX['inline'] . $item;
				$return .= $class::__get_setting();
			}
		}
		wp_enqueue_style(self::__make_handle('inline'),URI['style'] . 'dummy.min.css');
		wp_add_inline_style(self::__make_handle('inline'),$return);

		/**
		 * @reference (WP)
		 * 	Filters the HTML link tag of an enqueued style.
		 * 	Register dummy hook for delete the temporary inline css file.
		 * 	https://developer.wordpress.org/reference/hooks/style_loader_tag/
		*/
		add_filter('style_loader_tag',[$this,'delete_dummy'],PRIORITY['default'],2);

		/**
		 * @since 1.0.1
		 * 	Reset
		 * @reference (Beans)
		 * 	Echo output registered by ID.
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		*/
		$style = '';
		beans_output_e("_output[{$class}][{$function}]",$style);

	}// Method


	/**
		@access (public)
			Delete dummy css.
			http://ystandard.net
		@param (string) $html
		@param (string) $handle
		@return (string)
	*/
	public function delete_dummy($html,$handle)
	{
		return self::__make_handle('inline') === $handle ? '' : $html;

	}// Method


}// Class
endif;
// new _env_inline_style();
_env_inline_style::__get_instance();
