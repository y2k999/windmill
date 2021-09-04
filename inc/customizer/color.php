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
if(class_exists('_customizer_color') === FALSE) :
class _customizer_color
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_color()
 * 	set_hook()
 * 	invoke_hook()
 * 	register()
 * 	update()
 * 
 * @reference
 * 	[Parent]/asset/inline/base.php
 * 	[Parent]/asset/inline/button.php
 * 	[Parent]/asset/inline/follow.php
 * 	[Parent]/asset/inline/heading.php
 * 	[Parent]/asset/inline/image.php
 * 	[Parent]/asset/inline/nav.php
 * 	[Parent]/asset/inline/pagination.php
 * 	[Parent]/asset/inline/share.php
 * 	[Parent]/inc/env/gutenberg.php
*/

	/**
		@access(private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $color
			Main colors for this theme.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private $color = array();
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

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);
		$this->color = $this->set_color();

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook($this->hook);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_color()
	{
		/**
			@access (private)
				Set main colors for parent theme.
			@return (array)
				_filter[_customizer_color][color]
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
			'text' => COLOR['text'],
			'link' => COLOR['link'],
			'hover' => COLOR['hover'],
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
				_filter[_customizer_color][hook]
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
			'update' => array(
				'tag' => 'add_action',
				'hook' => 'after_switch_theme'
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
				Define new Theme Customizer panels, sections, settings, and controls.
			@param (WP_Customize_Manager) $wp_customize
				Instance of WP_Customize_Manager.
				https://developer.wordpress.org/reference/classes/wp_customize_manager/
			@return (void)
			@reference
				[Parent]/inc/setup/constant.php
		*/

		/**
		 * @reference (WP)
		 * 	Customize Color Control class.
		 * 	https://developer.wordpress.org/reference/classes/wp_customize_color_control/
		 * 	Sanitizes a hex color.
		 * 	https://developer.wordpress.org/reference/functions/sanitize_hex_color/
		*/

		// Text color.
		$wp_customize->add_setting(PREFIX['setting'] . 'color_text',array(
			'default' => isset($this->color['text']) ? $this->color['text'] : '',
			'sanitize_callback' => 'sanitize_hex_color',
		));
		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,PREFIX['setting'] . 'color_text',array(
			'label' => esc_html__('Text Color','windmill'),
			/*'description' => esc_html__( 'Choose color to make different your website.', 'windmill' ),*/
			'section' => 'colors',
		)));

		// Link color.
		$wp_customize->add_setting(PREFIX['setting'] . 'color_link',array(
			'default' => isset($this->color['link']) ? $this->color['link'] : '',
			'sanitize_callback' => 'sanitize_hex_color',
		));
		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,PREFIX['setting'] . 'color_link',array(
			'label' => esc_html__('Link Color','windmill'),
			'section' => 'colors',
		)));

		// Hover color.
		$wp_customize->add_setting(PREFIX['setting'] . 'color_hover',array(
			'default' => isset($this->color['hover']) ? $this->color['hover'] : '',
			'sanitize_callback' => 'sanitize_hex_color',
		));
		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,PREFIX['setting'] . 'color_hover',array(
			'label' => esc_html__('Hover Color','windmill'),
			'section' => 'colors',
		)));

	}// Method


	/* Hook
	_________________________
	*/
	public function update()
	{
		/**
			@access (public)
				Updates theme modification value for the current theme. (color).
				https://developer.wordpress.org/reference/functions/set_theme_mod/
			@return (void)
			@reference
				[Parent]/inc/setup/constant.php
		*/
		if(isset($this->color['text'])){
			set_theme_mod(PREFIX['setting'] . 'color_text',$this->color['text']);
		}

		if(isset($this->color['link'])){
			set_theme_mod(PREFIX['setting'] . 'color_link',$this->color['link']);
		}

		if(isset($this->color['hover'])){
			set_theme_mod(PREFIX['setting'] . 'color_hover',$this->color['hover']);
		}

	}// Method


}// Class
endif;
// new _customizer_color();
_customizer_color::__get_instance();
