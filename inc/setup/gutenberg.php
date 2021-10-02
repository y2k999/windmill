<?php
/**
 * Setup theme.
 * @package Windmill
 * @license GPL3.0+
 * @since 1.0.1
*/

/**
 * Inspired by Gutenberg Starter Theme WordPress Theme
 * @link https://github.com/WordPress/gutenberg-theme/
 * @author wordpressdotorg
 * 
 * Inspired by Celtis Speedy WordPress Theme
 * @link https://celtislab.net/wordpress-theme-celtis-speedy/
 * @author enomoto@celtislab
 * 
 * Inspired by Gutenberg CSS Summary WordPress Column
 * @link https://qiita.com/TetsuakiHamano/items/a71eae47e444a31b8b8e
 * @author Tetsuaki Hamano
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
if(class_exists('_setup_gutenberg') === FALSE) :
class _setup_gutenberg
{
/**
 * [NOTE]
 * 	Move web_font() method to [Parent_Theme]/include/env/enqueue.php
 * 
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_dependency()
 * 	set_style_both()
 * 	set_hook()
 * 	invoke_hook()
 * 	autosaveInterval()
 * 	add_theme_support()
 * 	enqueue_block_assets()
 * 	wp_dequeue_style()
 * 	add_editor_style()
 * 	enqueue_block_editor_assets()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $dependency
			Array of registered script handles.
		@var (array) $style_both
			Styles loaded in both front-end and back-end(editor).
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private $dependency = array();
	private $style_both = array();
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
		$this->dependency = $this->set_dependency();
		$this->style_both = $this->set_style_both();

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook($this->hook);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_dependency()
	{
		/**
			[NOTE]
				For custom block scripts implementation.
			@access (private)
				Set an array of registered script handles this script depends on.
			@return (array)
				_filter[_setup_gutenberg][dependency]
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
			'wp-blocks',
			'wp-components',
			'wp-element',
			'wp-i18n',
			'wp-editor',
			'wp-rich-text',
		));

	}// Method


	/* Setter
	_________________________
	*/
	private function set_style_both()
	{
		/**
			@access (private)
				Set the styles loaded in both front-end and back-end(editor).
			@return (array)
				_filter[_setup_gutenberg][style_both]
			@reference
				[Parent]/asset/style/theme/xxx-editor.css
				[Parent]/inc/setup/constant.php
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
			'custom-style-base' => URI['style'] . 'editor/base.css',
			'custom-style-blockquote' => URI['style'] . 'editor/blockquote.css',
			'custom-style-heading' => URI['style'] . 'editor/heading.css',
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
				_filter[_setup_gutenberg][hook]
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
			// Filter
			'autosaveInterval' => array(
				'tag' => 'add_filter',
				'hook' => 'block_editor_settings_all'
			),
			// Action
			'add_theme_support' => array(
				'tag' => 'add_action',
				'hook' => 'after_setup_theme'
			),
			'enqueue_block_assets' => array(
				'tag' => 'add_action',
				'hook' => 'enqueue_block_assets',
			),
/*
			'wp_block_library' => array(
				'tag' => 'add_action',
				'hook' => 'wp_enqueue_scripts'
			),
			'add_editor_style' => array(
				'tag' => 'add_action',
				'hook' => 'after_setup_theme'
			),
			'enqueue_block_editor_assets' => array(
				'tag' => 'add_action',
				'hook' => 'enqueue_block_editor_assets',
			),
*/

		)));

	}// Method


	/* Hook
	_________________________
	*/
	public function autosaveInterval($editor_settings)
	{
		/**
			@access (public)
				block_editor_settings_all
				[Depreciated]
				Filters the settings to pass to the block editor.
				https://developer.wordpress.org/reference/hooks/block_editor_settings/
			@param (array) $editor_settings
				Default editor settings.
			@return (array)
		*/
		$editor_settings['autosaveInterval'] = 360;
		return $editor_settings;

	}// Method


	/* Hook
	_________________________
	*/
	public function add_theme_support()
	{
		/**
			@access (public)
				The new Blocks include baseline support in all themes, enhancements to opt-in to and the ability to extend and customize.
				https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/
			@return (void)
		*/

		/**
			@reference
				Load theme.min.css (Front-end block styles loaded Secondary).
				https://github.com/WordPress/WordPress/blob/master/wp-includes/css/dist/block-library/theme.css
		*/
		add_theme_support('wp-block-styles');

		// Full and wide align images.
		add_theme_support('align-wide');

		// Responsive embedded content.
		add_theme_support('responsive-embeds');

		// Custom line height controls.
		add_theme_support('custom-line-height');

		// Experimental link color control.
		add_theme_support('experimental-link-color');

		// Experimental cover block spacing.
		add_theme_support('custom-spacing');

		// This was removed in WordPress 5.6 but is still required to properly support WP 5.5.
		add_theme_support('custom-units','px','rem','em','percentages','vh','vw');

	}// Method


	/* Hook
	_________________________
	*/
	public function enqueue_block_assets()
	{
		/**
			@access (public)
				Fires after enqueuing block assets for both editor and front-end.
				https://developer.wordpress.org/reference/hooks/enqueue_block_assets/
			@return (void)
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/general.php
				[Parent]/inc/utility/theme.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		if(!empty($this->style_both)){
			foreach($this->style_both as $key => $value){
				wp_enqueue_style(__utility_make_handle($key),$value,__utility_get_theme_version(),'all');
			}
		}

	}// Method


	/* Hook
	_________________________
	*/
	public function wp_block_library()
	{
		/**
			[NOTE]
				If you are using Gutenberg Editor, you won’t want to add this snippet to your site.
			@access (public)
				Remove style.min.css (Front-end block styles loaded Firstly).
			@return (void)
			@reference
				https://github.com/WordPress/WordPress/blob/master/wp-includes/css/dist/block-library/style.css
		*/
		if(!is_admin()){
			global $template;
			if(!empty($template) && !empty(basename($template))){
				// FrontendならGutenberg関連のCSS読み込まない(干渉するので基本的にテーマのCSSに記述)
				if(wp_style_is('wp-block-library')){
					wp_dequeue_style('wp-block-library');
				}
			}
		}

	}// Method


	/* Hook
	_________________________
	*/
	public function add_editor_style()
	{
		/**
			@access (public)
				Back-end styles for Gutenberg Editor ( this is also used in Classic Editor).
			@return (void)
		*/
		// Add support for editor styles.
		add_theme_support('editor-styles');

		/**
		 * @reference (WP)
		 * 	Adds callback for custom TinyMCE editor stylesheets.
		 * 	https://developer.wordpress.org/reference/functions/add_editor_style/
		 * @param (array)|(string) $stylesheet
		 * 	Stylesheet name or array thereof, relative to theme root.
		 * 	Defaults to 'editor-style.css'
		*/
		add_editor_style();

	}// Method


	/* Hook
	_________________________
	*/
	public function enqueue_block_editor_assets()
	{
		/**
			@access (public)
				Fires after block assets have been enqueued for the editing interface.
				https://developer.wordpress.org/reference/hooks/enqueue_block_editor_assets/
			@return (void)
		*/

		/**
			[NOTE]
				For the purpose for custom block stylings within back-end (editor).
					e.x. Admin panel styles of user custom block on right side of editor.
		*/

	}// Method


}// Class
endif;
// new _setup_gutenberg();
_setup_gutenberg::__get_instance();
