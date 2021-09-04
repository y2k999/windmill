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
if(class_exists('_customizer_panel') === FALSE) :
class _customizer_panel
{
/**
 * [TOC]
 * 	__get_instancet()
 * 	__construct()
 * 	set_priority()
 * 	set_definition()
 * 	__get_setting()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/identifier with prefix.
		@var (string) $_index
			Name/identifier without prefix.
		@var (array) $priority
			Priority of the panel, defining the display order of panels and sections.
		@var (array) $_definition
			Collection of theme customizer panel's parameters.
	*/
	private static $_class = '';
	private static $_index = '';

	private $priority = array();
	private static $_definition = array();

	/**
	 * Traits.
	*/
	use _trait_singleton;


	/* Constructor
	_________________________
	*/
	private function __construct()
	{
		/**
			@access (private)
				Send to Constructor.
			@return (void)
			@reference
				[Parent]/inc/trait/singleton.php
				[Parent]/inc/utility/general.php
		*/

		// Init properties
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);

		$this->priority = $this->set_priority();
		self::$_definition = $this->set_definition();

	}// Method


	/* Setter
	_________________________
	*/
	private function set_priority()
	{
		/**
			@access (private)
				Priority of the panel, defining the display order of panels and sections.
			@return (void)
				_filter[_customizer_panel][priority]
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
			'basis' => 1001,
			'template' => 1101,
			'seo' => 1201,
			'sns' => 1301,
			'skin' => 1401,
		));

	}// Method


	/* Setter
	_________________________
	*/
	private function set_definition()
	{
		/**
			@access (private)
				Set the WordPress Customizer Panel.
			@return (void)
				_filter[_customizer_panel][definition]
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
			array(
				'name' => 'basis',
				'title' => esc_html('[Windmill] Basis'),
				'type' => 'panel',
				'priority' => $this->priority['basis'],
			),
			array(
				'name' => 'template',
				'title' => esc_html('[Windmill] Template'),
				'type' => 'panel',
				'priority' => $this->priority['template'],
			),
			array(
				'name' => 'seo',
				'title' => esc_html('[Windmill] SEO','windmill'),
				'type' => 'panel',
				'priority' => $this->priority['seo'],
			),
			array(
				'name' => 'sns',
				'title' => esc_html('[Windmill] SNS','windmill'),
				'type' => 'panel',
				'priority' => $this->priority['sns'],
			),
			array(
				'name' => 'skin',
				'title' => esc_html('[Windmill] Design','windmill'),
				'type' => 'panel',
				'priority' => $this->priority['skin'],
			),
		));

	}// Method


	/* Method
	_________________________
	*/
	public static function __get_setting()
	{
		/**
			@access (public)
				Return theme customizer panels settings.
				https://developer.wordpress.org/reference/classes/wp_customize_panel/
			@return (array)
			@reference
				[Parent]/inc/customizer/setup.php
		*/
		return self::$_definition;

	}// Method


}// Class
endif;
// new _customizer_panel();
_customizer_panel::__get_instance();
