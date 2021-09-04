<?php
/**
 * Setup theme customizer.
 * @package Windmill
 * @license GPL3.0+
 * @since 1.0.1
*/

/**
 * Inspired by Beans Framework WordPress Theme
 * @link https://www.getbeans.io
 * @author Thierry Muller
 * 
 * Inspired by WeCodeArt WordPress Theme
 * @link https://www.wecodeart.com/
 * @author Bican Marian Valeriu
 * 
 * Inspired by f(x) Share WordPress Plugin
 * @link http://genbu.me/plugins/fx-share/
 * @author David Chandra Purnama
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
if(class_exists('_customizer_setup') === FALSE) :
class _customizer_setup
{
/**
 * [NOTE]
 * 	Move enqueueing customizer scripts and styles from _env_enqueue() class.
 * 	[Parent]/inc/env/enqueue.php
 * 
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_default()
 * 	set_panel()
 * 	set_section()
 * 	set_setting()
 * 	set_hook()
 * 	invoke_hook()
 * 	register()
 * 	enqueue()
 * 	theme_mod()
 * 	register_panel()
 * 	register_section()
 * 	register_setting()
 * 	register_control()
 * 	get_callback_name()
 * 
 * @reference
 * 	[Parent]/inc/customizer/callback.php
 * 	[Parent]/inc/customizer/default.php
 * 	[Parent]/inc/customizer/option.php
 * 	[Parent]/inc/customizer/panel/panel.php
 * 	[Parent]/inc/customizer/section/xxx.php
 * 	[Parent]/inc/customizer/setting/xxx/xxx.php
*/

	/**
		@access(private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
		@var (array) $default
			Default values of Theme Customizer.
		@var (array) $configuration
			Configuration values for building WP_Customize_Manager instance.
	*/
	private static $_class = '';
	private static $_index = '';
	private $hook = array();
	private $default = array();
	private $configuration = array();

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
			@global (array) $_customizer_default
				Theme Customizer default value.
			@return (void)
			@reference
				[Parent]/inc/customizer/default.php
				[Parent]/inc/trait/singleton.php
				[Parent]/inc/utility/general.php
		*/

		// Init properties
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);
		$this->default = $this->set_default();

		$this->configuration = $this->set_panel();
		$this->configuration = $this->set_section();
		$this->configuration = $this->set_setting();

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook($this->hook);

		// Reflect on globals.
		global $_customizer_default;
		$_customizer_default = $this->default;

/*
		print_r('<pre>');
		print_r($this->configuration);
		print_r('</pre>');
*/

	}// Method


	/* Setter
	_________________________
	*/
	private function set_default()
	{
		/**
			@access (private)
				Set the default values for the Theme Customizer.
			@return (array)
				_filter[_customizer_setup][default]
			@reference
				[Parent]/inc/customizer/default.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",_customizer_default::__get_setting());

	}// Method


	/* Setter
	_________________________
	*/
	private function set_panel()
	{
		/**
			@access (private)
				Set the WordPress Customizer Panel.
				https://developer.wordpress.org/reference/classes/wp_customize_panel/
			@return (array)
				_filter[_customizer_setup][panel]
			@reference
				[Parent]/inc/customizer/panel.php
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
		get_template_part(SLUG['customizer'] . $function . DIRECTORY_SEPARATOR . $function);
		if(is_callable(['_customizer_panel','__get_setting'])){
			return apply_filters("_filter[{$class}][{$function}]",_customizer_panel::__get_setting());
		}
		else{
			return apply_filters("_filter[{$class}][{$function}]",array());
		}

	}// Method


	/* Setter
	_________________________
	*/
	private function set_section()
	{
		/**
			@access (private)
				Set the WordPress Customizer Section.
				https://developer.wordpress.org/reference/classes/wp_customize_section/
			@return (array)
				_filter[_customizer_setup][section]
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$return = array();
		foreach($this->configuration as $configuration){
			if($configuration['type'] === 'panel'){
				get_template_part(SLUG['customizer'] . $function . DIRECTORY_SEPARATOR . $configuration['name']);
				$method = '__get_customizer_panel_' . $configuration['name'];
				if(is_callable($method)){
					/**
					 * @reference (WP)
					 * 	Merges user defined arguments into defaults array.
					 * 	https://developer.wordpress.org/reference/functions/wp_parse_args/
					 * @param (string)|(array)|(object) $args
					 * 	Value to merge with $defaults.
					 * @param (array) $defaults
					 * 	Array that serves as the defaults.
					*/
					$return = wp_parse_args(call_user_func($method),$return);
				}
			}
		}

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",wp_parse_args($return,$this->configuration));

	}// Method


	/* Setter
	_________________________
	*/
	private function set_setting()
	{
		/**
			@access (private)
				Set the WordPress Customizer Setting.
				https://developer.wordpress.org/reference/classes/wp_customize_control/
			@return (array)
				_filter[_customizer_setup][setting]
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$return = array();
		foreach($this->configuration as $configuration){
			if($configuration['type'] === 'section'){
				get_template_part(SLUG['customizer'] . $function . DIRECTORY_SEPARATOR . $configuration['panel'] . DIRECTORY_SEPARATOR . $configuration['name']);
				$method = '__get_customizer_' . $configuration['panel'] . '_' . $configuration['name'];
				if(is_callable($method)){
					/**
					 * @reference (WP)
					 * 	Merges user defined arguments into defaults array.
					 * 	https://developer.wordpress.org/reference/functions/wp_parse_args/
					 * @param (string)|(array)|(object) $args
					 * 	Value to merge with $defaults.
					 * @param (array) $defaults
					 * 	Array that serves as the defaults.
					*/
					$return = wp_parse_args(call_user_func($method),$return);
				}
			}
		}

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",wp_parse_args($return,$this->configuration));

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
				_filter[_customizer_setup][hook]
			@reference
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
			'register' => array(
				'tag' => 'add_action',
				'hook' => 'customize_register'
			),
			'enqueue' => array(
				'tag' => 'add_action',
				'hook' => 'customize_controls_enqueue_scripts'
			),
			'theme_mod' => array(
				'tag' => 'add_action',
				'hook' => 'customize_register'
			),
		)));

	}// Method


	/* Hook
	_________________________
	*/
	public function register($wp_customize)
	{
		/**
			@access (public)
				Fires once WordPress has loaded, allowing scripts and styles to be initialized.
				https://developer.wordpress.org/reference/hooks/customize_register/
			@param (WP_Customize_Manager) $wp_customize
				Instance of WP_Customize_Manager.
				https://developer.wordpress.org/reference/classes/wp_customize_manager/
			@return (void)
		*/
		foreach((array)$this->configuration as $configuration){
			switch($configuration['type']){
				case 'panel' :
					unset($configuration['type']);
					$this->register_panel($configuration,$wp_customize);
					break;

				case 'section' :
					unset($configuration['type']);
					$this->register_section($configuration,$wp_customize);
					break;

				case 'control' :
					unset($configuration['type']);
					$this->register_setting($configuration,$wp_customize);
					$this->register_control($configuration,$wp_customize);
					break;
			}
		}

	}// Method


	/* Hook
	_________________________
	*/
	public function enqueue()
	{
		/**
			@access (public)
				Enqueue Customizer control scripts.
				https://developer.wordpress.org/reference/hooks/customize_controls_enqueue_scripts/
			@return (void)
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/general.php
		*/
		wp_enqueue_style(self::__make_handle(self::$_index),URI['style'] . 'admin/customizer.min.css',__utility_get_theme_version(),'all');

		wp_enqueue_script(self::__make_handle(self::$_index),URI['script'] . 'admin/customizer.min.js',array('jquery','jquery-ui-sortable','customize-controls'),__utility_get_theme_version(),TRUE);

	}// Method


	/* Hook
	_________________________
	*/
	public function theme_mod($wp_customize)
	{
		/**
			@access (public)
				Set the initial value for the Theme Customizer.
			@param (WP_Customize_Manager) $wp_customize
				Instance of WP_Customize_Manager.
				https://developer.wordpress.org/reference/classes/wp_customize_manager/
			@return (void)
			@reference
				[Parent]/inc/setup/constant.php
		*/

		/**
		 * @reference (WP)
		 * 	Retrieves all theme modifications.
		 * 	https://developer.wordpress.org/reference/functions/get_theme_mods/
		*/
		$theme_mods = get_theme_mods();

		foreach($this->default as $key => $value){
			if(!array_key_exists(PREFIX['setting'] . $key,$theme_mods)){
				/**
				 * @reference (WP)
				 * 	Updates theme modification value for the current theme.
				 * 	https://developer.wordpress.org/reference/functions/set_theme_mod/
				*/
				set_theme_mod(PREFIX['setting'] . $key,$value);
			}
		}

	}// Method


	/* Method
	_________________________
	*/
	private function register_panel($configuration,$wp_customize)
	{
		/**
			@access (private)
				Add a customize panel.
				https://developer.wordpress.org/reference/classes/wp_customize_manager/add_panel/
			@param (array) $configuration
			@param (WP_Customize_Manager) $wp_customize
				Instance of WP_Customize_Manager.
				https://developer.wordpress.org/reference/classes/wp_customize_manager/
			@return (void)
			@reference
				[Parent]/inc/setup/constant.php
		*/
		$wp_customize->add_panel(PREFIX['panel'] . $configuration['name'],$configuration);

	}// Method


	/* Method
	_________________________
	*/
	private function register_section($configuration,$wp_customize)
	{
		/**
			@access (private)
				Add a customize section.
				https://developer.wordpress.org/reference/classes/wp_customize_manager/add_section/
			@param (array) $configuration
			@param(WP_Customize_Manager) $wp_customize 
				Instance of WP_Customize_Manager.
				https://developer.wordpress.org/reference/classes/wp_customize_manager/
			@return (void)
			@reference
				[Parent]/inc/setup/constant.php
		*/
		$configuration['panel'] = PREFIX['panel'] . $configuration['panel'];
		$wp_customize->add_section(PREFIX['section'] . $configuration['name'],$configuration);

	}// Method


	/* Method
	_________________________
	*/
	private function register_setting($configuration,$wp_customize)
	{
		/**
			@access (private)
				Add a customize setting.
				https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
			@param (array) $configuration
			@param(WP_Customize_Manager) $wp_customize 
				Instance of WP_Customize_Manager.
				https://developer.wordpress.org/reference/classes/wp_customize_manager/
			@return (void)
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/sanitize.php
		*/
		$configuration['type'] = 'theme_mod';

		// Transport postMessage variable set.
		$configuration['transport'] = isset($wp_customize->selective_refresh) ? 'refresh' : 'postMessage';
		$configuration['capability'] = 'edit_theme_options';

		switch($configuration['control']){
			case 'number' :
				$configuration['sanitize_callback'] = '__utility_sanitize_number';
				break;

			case 'integer' :
			case 'dropdown-pages' :
				$configuration['sanitize_callback'] = '__utility_sanitize_integer';
				break;

			case 'image' :
				$configuration['sanitize_callback'] = '__utility_sanitize_upload';
				break;

			case 'checkbox' :
				$configuration['sanitize_callback'] = '__utility_sanitize_checkbox';
				break;

			case 'text' :
				$configuration['sanitize_callback'] = '__utility_sanitize_text';
				break;

			case 'textarea' :
				$configuration['sanitize_callback'] = '__utility_sanitize_textarea';
				break;

			case 'sortable' :
				$configuration['sanitize_callback'] = '__utility_sanitize_sortable';
				break;

			case 'url' :
				/**
				 * @reference (WP)
				 * 	Checks and cleans a URL.
				 * 	https://developer.wordpress.org/reference/functions/esc_url/
				*/
				$configuration['sanitize_callback'] = 'esc_url';
				break;

			case 'select' :
			default :
				/**
				 * @reference (WP)
				 * 	Sanitizes a string from user input or from the database.
				 * 	https://developer.wordpress.org/reference/functions/sanitize_text_field/
				*/
				$configuration['sanitize_callback'] = 'sanitize_text_field';
				break;
		}
		$needle = PREFIX['setting'] . $configuration['name'];
		$wp_customize->add_setting("{$needle}",$configuration);

	}// Method


	/* Method
	_________________________
	*/
	private function register_control($configuration,$wp_customize)
	{
		/**
			@access (private)
				Add a customize control.
				https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
			@param (array) $configuration
			@param(WP_Customize_Manager) $wp_customize
				Instance of WP_Customize_Manager.
				https://developer.wordpress.org/reference/classes/wp_customize_manager/
			@return (void)
			@reference
				[Parent]/inc/customizer/callback.php
				[Parent]/inc/customizer/control/sortable.php
				[Parent]/inc/setup/constant.php
				[Plugin]/beans_extension/api/customizer/control.php
		*/

		// Control Args.
		$configuration['setting'] = PREFIX['setting'] . $configuration['name'];
		$configuration['section'] = PREFIX['section'] . $configuration['section'];

		$configuration['type'] = $configuration['control'];

		switch($configuration['type']){
			case 'number' :
				if(!isset($configuration['input_attrs'])){
					$method = $this->get_callback_name($configuration['name']);
					if(is_callable(['_customizer_callback',$method])){
						$configuration['input_attrs'] = call_user_func(['_customizer_callback',$method]);
					}
				}
				/**
				 * @reference (WP)
				 * 	This class is used with the Theme Customization API to render an input control on the Theme Customizer in WordPress 3.4 or newer.
				 * 	https://developer.wordpress.org/reference/classes/wp_customize_control/
				*/
				$wp_customize->add_control(new WP_Customize_Control($wp_customize,$configuration['setting'],$configuration));
				break;

			case 'select' :
				if(!isset($configuration['choices'])){
					$method = $this->get_callback_name($configuration['name']);
					if(is_callable(['_customizer_callback',$method])){
						$configuration['choices'] = call_user_func(['_customizer_callback',$method]);
					}
				}
				// Register Control.
				$wp_customize->add_control($configuration['setting'],$configuration);
				break;

			case 'sortable' :
				if(!isset($configuration['choices'])){
					$method = $this->get_callback_name($configuration['name']);
					if(is_callable(['_customizer_callback',$method])){
						$configuration['choices'] = call_user_func(['_customizer_callback',$method]);
					}
				}
				// Register Control.
				get_template_part(SLUG['customizer'] . 'control/sortable');
				$wp_customize->add_control(new _customizer_control_sortable($wp_customize,$configuration['setting'],$configuration));
				break;

			case 'radio' :
				if(!isset($configuration['choices'])){
					$method = $this->get_callback_name($configuration['name']);
					if(is_callable(['_customizer_callback',$method])){
						$configuration['choices'] = call_user_func(['_customizer_callback',$method]);
					}
				}
				// Register Control.
				$wp_customize->add_control(new \Beans_Extension\_beans_control_customizer($wp_customize,$configuration['setting'],$configuration));
				break;

			case 'image' :
				/**
				 * @reference (WP)
				 * 	Customize Image Control class.
				 * 	https://developer.wordpress.org/reference/classes/wp_customize_image_control/
				*/
				$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,$configuration['setting'],$configuration));
				break;

			case 'checkbox' :
			default :
				// Register Control
				$wp_customize->add_control($configuration['setting'],$configuration);
				break;
		}

	}// Method


	/**
		@access (private)
			Get the callback to filter a customize setting value in un-slashed form.
		@param (string) $needle
			Theme Customizer modification name.
		@return (string)
			The name of sanitize callback.
		@reference
			[Parent]/inc/customizer/callback.php
			[Parent]/inc/setup/constant.php
	*/
	private function get_callback_name($needle)
	{
		if(!isset($needle)){return;}

		$method = PREFIX['get'] . str_replace('-','_',$needle);
		if(is_callable(['_customizer_callback',$method])){
			return $method;
		}
		else{
			return PREFIX['get'] . 'dummy';
		}

	}// Method


}// Class
endif;
// new _customizer_setup();
_customizer_setup::__get_instance();
