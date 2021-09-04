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
if(class_exists('_env_enqueue') === FALSE) :
class _env_enqueue
{
/**
 * [NOTE]
 * 	Move enqueueing editor_font from _setup_gutenberg() class.
 * 	[Parent]/inc/setup/gutenberg.php
 * 	Move admin scripts and styles to _setup_admin() class.
 * 	[Parent]/inc/setup/admin.php
 * 	Move customizer scripts and styles to _customizer_setup() class.
 * 	[Parent]/inc/customizer/setup.php
 * 	Move inline_style() method to _env_inline_style() class.
 * 	[Parent]/inc/env/inline-style.php
 * 	Move async_defer() and script_loader_xxx method to _env_script_loader() class.
 * 	[Parent]/inc/env/script-loader.php
 * 
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_uikit()
 * 	set_script()
 * 	set_style()
 * 	set_font_family()
 * 	set_theme_mod()
 * 	set_user_custom()
 * 	set_hook()
 * 	invoke_hook()
 * 	jquery()
 * 	comment_reply()
 * 	font_front()
 * 	font_editor()
 * 	theme()
 * 	beans_extension()
 * 	queued_style()
 * 	queued_script()
 * 	display_handle()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (string) $uikit
			Uikit version.
		@var (string) $theme
			Name of the current theme.
		@var (array) $script
			Parameter of wp_enqueue_script.
		@var (array) $style
			Parameter of wp_enqueue_style.
		@var (array) $font_family
			Google web fonts.
		@var (array) $theme_mod
			Theme customizer settings.
		@var (array) $user_custom
			User custom scripts.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private $uikit = '';
	private $theme = '';
	private $script = array();
	private $style = array();
	private $font_family = array();
	private $theme_mod = array();
	private $user_custom = array();
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

		$this->theme = get_template();
		$this->uikit = $this->set_uikit();
		$this->script = $this->set_script();
		$this->style = $this->set_style();
		$this->font_family = $this->set_font_family();
		$this->theme_mod = $this->set_theme_mod();
		$this->user_custom = $this->set_user_custom();

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
	private function set_uikit()
	{
		/**
			@access (private)
				Set the Uikit version from the Beans Extension plugin.
				https://github.com/y2k999/beans-extension
			@return (array)
				_filter[_env_enqueue][uikit]
			@reference
				[Plugin]/beans_extension/admin/general.php
		*/
		$uikit = beans_get_general_setting('uikit');
		return isset($uikit) && ($uikit === 'uikit3') ? 'uikit3' : 'uikit2';

	}// Method


	/* Setter
	_________________________
	*/
	private function set_script()
	{
		/**
			@access (private)
				Set the parameter values for the wp_enqueue_script.
			@return (array)
				_filter[_env_enqueue][script]
			@reference
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
			/**
			 * @since 1.0.1
			 * 	Library
			*/
			'jquery' => array(
				'src' => 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js',
				'ver' => '3.6.0',
			),
		));

	}// Method


	/* Setter
	_________________________
	*/
	private function set_style()
	{
		/**
			@access (private)
				Set the parameter values for the wp_enqueue_style.
			@return (array)
				_filter[_env_enqueue][style]
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
			/**
			 * @since 1.0.1
			 * 	Root stylesheet of theme.
			*/
			'theme' => array(
				'src' => trailingslashit(get_template_directory_uri()) . 'style.css',
				'ver' => __utility_get_theme_version(),
			),
		));

	}// Method


	/* Setter
	_________________________
	*/
	private function set_font_family()
	{
		/**
			@access (private)
				Set the Google web fonts.
			@return (array)
				_filter[_env_enqueue][font_family]
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
			/**
			 * @since 1.0.2
			 * 	Basical San-Serif.
			*/
			'noto-sans-jp' => array(
				'src' => 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap',
				'ver' => __utility_get_theme_version(),
			),
			'roboto' => array(
				'src' => 'https://fonts.googleapis.com/css2?family=Roboto&display=swap',
				'ver' => __utility_get_theme_version(),
			),
			'open-sans' => array(
				'src' => 'https://fonts.googleapis.com/css2?family=Open+Sans&display=swap',
				'ver' => __utility_get_theme_version(),
			),
			/**
			 * @since 1.0.2
			 * 	Stylish San-Serif.
			*/
			'lato' => array(
				'src' => 'https://fonts.googleapis.com/css2?family=Lato&display=swap',
				'ver' => __utility_get_theme_version(),
			),
			'josefin-sans' => array(
				'src' => 'https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap',
				'ver' => __utility_get_theme_version(),
			),
			'oswald' => array(
				'src' => 'https://fonts.googleapis.com/css2?family=Oswald&display=swap',
				'ver' => __utility_get_theme_version(),
			),
			/**
			 * @since 1.0.2
			 * 	Basical Serif.
			*/
			'noto-serif-jp' => array(
				'src' => 'https://fonts.googleapis.com/css2?family=Noto+Serif+JP&display=swap',
				'ver' => __utility_get_theme_version(),
			),
			'lora' => array(
				'src' => 'https://fonts.googleapis.com/css2?family=Lora&display=swap',
				'ver' => __utility_get_theme_version(),
			),
			/**
			 * @since 1.0.2
			 * 	Stylish Serif.
			*/
			'cinzel' => array(
				'src' => 'https://fonts.googleapis.com/css2?family=Cinzel&display=swap',
				'ver' => __utility_get_theme_version(),
			),
			'playfair-display' => array(
				'src' => 'https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap',
				'ver' => __utility_get_theme_version(),
			),
		));

	}// Method


	/* Setter
	_________________________
	*/
	private function set_theme_mod()
	{
		/**
			@access (private)
				Set web fonts from theme customizer settings.
			@return (array)
				_filter[_env_enqueue][theme_mod]
			@reference
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
			__utility_get_option('font_primary'),
			__utility_get_option('font_secondary'),
			// __utility_get_option('font_tertiary'),
		));

	}// Method


	/* Setter
	_________________________
	*/
	private function set_user_custom()
	{
		/**
			@access (private)
				Set the custom javascript.
			@return (array)
				_filter[_env_enqueue][user_custom]
			@reference
				[Parent]/asset/script/xxx.js
				[Parent]/asset/style/uikit/xxx.less
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/general.php
				[Parent]/inc/utility/theme.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",array(
			'style' => array(
				PATH['style'] . 'front/back2top.less',
				PATH['style'] . 'front/blockquote.less',
				PATH['style'] . 'front/heading.less',
				// PATH['style'] . 'front/image.less',
				// PATH['style'] . 'front/sidebar.less',
			),
			'script' => array(
				// URI['script'] . 'front/back2top.min.js',
				// URI['script'] . 'front/fixed-sidebar.min.js',
			),
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
				_filter[_env_enqueue][hook]
			@reference
				[Parent]/inc/trait/hook.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$return = array(
			'theme' => ['tag' => 'add_action','hook' => 'wp_enqueue_scripts'],
			'font_editor' => ['tag' => 'add_action','hook' => 'enqueue_block_editor_assets'],
		);

		/**
		 * @reference (WP)
		 * 	Determines whether the current request is for an administrative interface page.
		 * 	https://developer.wordpress.org/reference/functions/is_admin/
		*/
		if(!is_admin()){
			// $return['jquery'] = ['tag' => 'add_action','hook' => 'wp_enqueue_scripts'];
			$return['preconnect'] = ['tag' => 'add_action','hook' => HOOK_POINT['head']['before']];
			$return['beans_extension'] = ['tag' => 'add_action','hook' => 'beans_extension_uikit_enqueue_script','priority' => PRIORITY['mid-low']];
			$return['comment_reply'] = ['tag' => 'add_action','hook' => 'wp_enqueue_scripts'];
			$return['font_front'] = ['tag' => 'add_action','hook' => 'wp_enqueue_scripts'];
			$return['queued_style'] = ['tag' => 'add_action','hook' => 'wp_enqueue_scripts'];
			$return['queued_script'] = ['tag' => 'add_action','hook' => 'wp_enqueue_scripts'];
		}

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",$this->set_parameter_callback($return));

	}// Method


	/* Hook
	_________________________
	*/
	public function preconnect()
	{
		/**
			@access (public)
				WordPress Preconnect Google Fonts.
				https://gist.github.com/gareth-gillman/b2788c3f481eb1585975093598d06f43
			@return (void)
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$gstatic = 'https://fonts.gstatic.com/';
		$googleapis = 'https://fonts.googleapis.com/';

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		echo apply_filters("_filter[{$class}][{$function}][gstatic]",sprintf('<link rel="preconnect" href="%s">',$gstatic));
		echo apply_filters("_filter[{$class}][{$function}][googleapis]",sprintf('<link rel="preconnect" href="%s" crossorigin>',$googleapis));

	}// Method


	/* Hook
	_________________________
	*/
	public function jquery()
	{
		/**
			[NOTE]
				In Beans Extension plugin, the latest jQuery library is already enqueued.
			@access (public)
				jQuery core library.
				https://developers.google.com/speed/libraries
			@return (void)
			@reference
				[Parent]/inc/customizer/data.php
				[Parent]/inc/utility/general.php
				[Plugin]/asset/beans.php
		*/
		// if(__utility_get_option('jquery')){return;}
		wp_deregister_script('jquery');
		wp_enqueue_script('jquery',$this->script['jquery']['src'],array(),$this->script['jquery']['ver'],TRUE);

	}// Method


	/* Hook
	_________________________
	*/
	public function comment_reply()
	{
		/**
			@access (public)
				Threaded comments were enabled in WordPress 2.7.
				Checks if the visitor is browsing a post and adds the JavaScript required for threaded comments if they are.
				https://peterwilson.cc/including-wordpress-comment-reply-js/
			@return (void)
		*/

		/**
		 * @reference (WP)
		 * 	Determines whether the query is for an existing single post of any post type (post, attachment, page, custom post types).
		 * 	https://developer.wordpress.org/reference/functions/is_singular/
		 * 	Determines whether the current post is open for comments.
		 * 	https://developer.wordpress.org/reference/functions/comments_open/
		*/
		if(!is_singular('post') || !comments_open() || !get_option('thread_comments')){return;}
		wp_enqueue_script('comment-reply');

	}// Method


	/* Hook
	_________________________
	*/
	public function font_front()
	{
		/**
			@access (public)
				Google Web Fonts.
				https://hirashimatakumi.com/blog/1315.html
			@return (void)
			@reference
				[Parent]/inc/customizer/option.php
				[Parent]/inc/utility/general.php
		*/
		foreach($this->theme_mod as $item){
			if($item === 'non' || !isset($item)){break;}
			wp_enqueue_style(self::__make_handle('font-' . $item),$this->font_family[$item]['src'],$this->font_family[$item]['ver'],'all');
		}

	}// Method


	/* Hook
	_________________________
	*/
	public function font_editor()
	{
		/**
			@access (public)
				Fires after block assets have been enqueued for the editing interface.
				https://developer.wordpress.org/reference/hooks/enqueue_block_editor_assets/
			@return (void)
		*/

		// Web fonts
		foreach($this->theme_mod as $item){
			if($item === 'non' || !isset($item)){break;}
			wp_enqueue_style(self::__make_handle('editor-font-' . $item),$this->font_family[$item]['src'],$this->font_family[$item]['ver'],'all');
		}

	}// Method


	/* Hook
	_________________________
	*/
	public function theme()
	{
		/**
			@access (public)
				Theme's stylesheet (style.css)
			@return (void)
			@reference (WP)
				Retrieves template directory URI for current theme.
				https://developer.wordpress.org/reference/functions/get_template_directory_uri/
			@reference
				[Parent]/inc/utility/general.php
		*/
		// $class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);
		wp_enqueue_style(self::__make_handle('base-parent'),$this->style[$function]['src'],$this->style[$function]['ver'],'all');

	}// Method


	/* Hook
	_________________________
	*/
	public function beans_extension()
	{
		/**
			@access (public)
				Fires when UIkit scripts and styles are enqueued.
				https://www.getbeans.io/code-reference/hooks/beans_uikit_enqueue_scripts/
			@return (void)
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/general.php
				[Parent]/inc/utility/theme.php
		*/
		if(!__utility_is_uikit()){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		if($this->uikit === 'uikit2'){
			/**
			 * [NOTE]
			 * 	This process is executed ONLY when Uikit2 is selected in Beans Extension plugin.
			 * @since 1.0.1
			 * 	Enqueue UIkit overwrite theme folder.
			 * @reference (Beans)
			 * 	Enqueue a UIkit theme.
			 * 	https://www.getbeans.io/code-reference/functions/beans_uikit_enqueue_theme/
			*/
			beans_uikit_enqueue_theme($this->theme . '-uikit2-overwrite',PATH['style'] . 'uikit');
		}

		/**
		 * @since 1.0.1
		 * 	Add and compile scripts to Beans Extension plugin.
		 * @reference (Beans)
		 * 	Add CSS, LESS or JS fragments to a compiler.
		 * 	https://www.getbeans.io/code-reference/functions/beans_compiler_add_fragment/
		 * 	Compile JS fragments and enqueue compiled file.
		 * 	https://www.getbeans.io/code-reference/functions/beans_compile_js_fragments/
		*/
		if(!empty($this->user_custom['style'])){
			// foreach($this->user_custom['style'] as $item){
				// beans_compiler_add_fragment('uikit',$item,'less');
			// }
			beans_compiler_add_fragment('uikit',$this->user_custom['style'],'less');
		}

		// if(!empty($this->user_custom['script'])){
			// beans_compile_js_fragments($this->theme,$this->user_custom['script']);
		// }

	}// Method


	/* Hook
	_________________________
	*/
	public function queued_style()
	{
		/**
			@access (public)
				WP_Styles is a class that helps developers interact with a theme. 
				https://developer.wordpress.org/reference/classes/wp_styles/
			@global (WP_Styles) $wp_styles
				https://codex.wordpress.org/Global_Variables
			@return (void)
		*/
		global $wp_styles;

		echo "<!-- [■■■ Style ■■■] WP_Dependencies for Styles\n";

		foreach($wp_styles->queue as $item){
			echo $this->display_handle($wp_styles->registered[$item]) . PHP_EOL;
		}
		echo "-->\n";

	}// Method


	/* Hook
	_________________________
	*/
	public function queued_script()
	{
		/**
			@access (public)
				Core class used to register scripts.
				https://developer.wordpress.org/reference/classes/wp_scripts/
			@global (WP_Scripts) $wp_scripts
				https://codex.wordpress.org/Global_Variables
			@return (void)
		*/
		global $wp_scripts;

		echo "<!-- [■■■ Script ■■■] WP_Dependencies for Scripts\n";

		foreach($wp_scripts->queue as $item){
			echo $this->display_handle($wp_scripts->registered[$item]) . PHP_EOL;
		}
		echo "-->\n";

	}// Method


	/**
		@access (private)
			Helper class to register a handle and associated data.
			https://developer.wordpress.org/reference/classes/_wp_dependency/
		@param (_WP_Dependency) $dependency
		@return (string)
	*/
	private function display_handle($dependency)
	{
		if(!is_a($dependency,'_WP_Dependency')){return;}
		return "$dependency->handle [" . implode(' ',$dependency->deps) . "] '$dependency->src' '$dependency->ver' '$dependency->args'";

	}// Method


}// Class
endif;
// new _env_enqueue();
_env_enqueue::__get_instance();
