<?php
/**
 * Setup theme.
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
if(class_exists('_theme_loadup') === FALSE) :
class _theme_loadup
{
/**
 * 	[TOC]
 * 	__construct()
 * 	plugin()
 * 	admin()
 * 	customizer()
 * 	option()
 * 	data()
 * 	env()
 * 	controller()
 * 	widget()
*/


	/* Constructor
	_________________________
	*/
	public function __construct()
	{
		/**
			@access (public)
				Class Constructor.
			@return (void)
		*/

		/**
		 * @since 1.0.1
		 * 	Load initial components.
		*/
		$this->theme_support();
		$this->widget_area();
		$this->gutenberg();
		$this->plugin();
		$this->admin();
		$this->customizer();
		$this->option();
		$this->data();
		$this->env();
		$this->controller();
		$this->widget();

/*
		// add_action('template_redirect',[$this,'controller']);
		// add_action('after_setup_theme',[$this,'controller']);
		add_action('windmill/root/before',[$this,'theme_support']);
		add_action('windmill/root/before',[$this,'widget_area']);
		add_action('windmill/root/before',[$this,'gutenberg']);
		add_action('windmill/root/before',[$this,'plugin']);
		add_action('windmill/root/before',[$this,'admin']);
		add_action('windmill/root/before',[$this,'customizer']);
		add_action('windmill/root/main',[$this,'option']);
		add_action('windmill/root/main',[$this,'data']);
		add_action('windmill/root/main',[$this,'env']);
		add_action('windmill/root/main',[$this,'controller']);
		add_action('windmill/root/main',[$this,'widget']);
*/
		/**
		 * @since 1.0.1
		 * 	If you want to do anything during the start of the theme,use this hook.
		 * 	You can also use this hook to remove any of the hooks or filters called during this phase.
		*/
		do_action('windmill/root/before');
		do_action('windmill/root/main');
		do_action('windmill/root/after');

	}// Method


	/* Hook
	_________________________
	*/
	public function theme_support()
	{
		/**
			@access(private)
				Include theme support files.
			@return (void)
			@reference (WP)
				Retrieves template directory path for current theme.
				https://developer.wordpress.org/reference/functions/get_template_directory/
		*/
		require_once (trailingslashit(get_template_directory()) . 'inc/setup/theme-support.php');

	}// Method


	/* Hook
	_________________________
	*/
	public function gutenberg()
	{
		/**
			@access(private)
				Include Gutenberg setup files.
			@return (void)
			@reference (WP)
				Retrieves template directory path for current theme.
				https://developer.wordpress.org/reference/functions/get_template_directory/
		*/
		require_once (trailingslashit(get_template_directory()) . 'inc/setup/gutenberg.php');

	}// Method


	/* Hook
	_________________________
	*/
	public function widget_area()
	{
		/**
			@access(private)
				Include register sidebar files.
			@return (void)
			@reference (WP)
				Retrieves template directory path for current theme.
				https://developer.wordpress.org/reference/functions/get_template_directory/
		*/
		require_once (trailingslashit(get_template_directory()) . 'inc/setup/widget-area.php');

	}// Method


	/* Hook
	_________________________
	*/
	public function admin()
	{
		/**
			@access(public)
				Include admin files.
			@return (void)
			@reference (WP)
				Retrieves template directory path for current theme.
				https://developer.wordpress.org/reference/functions/get_template_directory/
		*/

		/**
		 * @reference (WP)
		 * 	Determines whether the current request is for an administrative interface page.
		 * 	https://developer.wordpress.org/reference/functions/is_admin/
		*/
		if(is_admin()){
			require_once (trailingslashit(get_template_directory()) . 'inc/setup/admin.php');
		}

	}// Method


	/* Hook
	_________________________
	*/
	public function plugin()
	{
		/**
			@access(public)
				Include admin files.
			@return (void)
			@reference (WP)
				Retrieves template directory path for current theme.
				https://developer.wordpress.org/reference/functions/get_template_directory/
		*/

		/**
		 * @reference (WP)
		 * 	Determines whether the current request is for an administrative interface page.
		 * 	https://developer.wordpress.org/reference/functions/is_admin/
		*/
		if(is_admin()){
			require_once (trailingslashit(get_template_directory()) . 'inc/plugin/tgm/plugin-install.php');

			if(!class_exists('All_in_One_SEO_Pack')){
				require_once (trailingslashit(get_template_directory()) . 'inc/plugin/aioseop/aioseop.php');
			}
		}

		if(class_exists('Jetpack')){
			require_once (trailingslashit(get_template_directory()) . 'inc/plugin/jetpack/jetpack.php');
		}

	}// Method


	/* Hook
	_________________________
	*/
	public function customizer()
	{
		/**
			@access(public)
				Include customizer files.
			@return (void)
			@reference (WP)
				Retrieves template directory path for current theme.
				https://developer.wordpress.org/reference/functions/get_template_directory/
		*/

		/**
		 * @reference (WP)
		 * 	Determines whether the current request is for an administrative interface page.
		 * 	https://developer.wordpress.org/reference/functions/is_admin/
		 * 	Whether the site is being previewed in the Customizer.
		 * 	https://developer.wordpress.org/reference/functions/is_customize_preview/
		*/
		if(is_admin() || is_customize_preview()){
			foreach(array(
				'callback',
				'setup',
				'color',
			) as $item){
				require_once (trailingslashit(get_template_directory()) . 'inc/customizer/' . $item . '.php');
			}
		}

	}// Method


	/* Hook
	_________________________
	*/
	public function option()
	{
		/**
			@access(public)
				Include customizer setting option.
			@return (void)
			@reference (WP)
				Retrieves template directory path for current theme.
				https://developer.wordpress.org/reference/functions/get_template_directory/
		*/
		require_once (trailingslashit(get_template_directory()) . 'inc/customizer/option.php');

	}// Method


	/* Hook
	_________________________
	*/
	public function data()
	{
		/**
			@access (public)
				Include theme data files.
			@return (void)
			@reference (WP)
				Retrieves template directory path for current theme.
				https://developer.wordpress.org/reference/functions/get_template_directory/
			@reference
				[Parent]/inc/utility/general.php
		*/
		foreach(array(
			trailingslashit(get_template_directory()) . 'model/data',
		) as $item){
			__utility_glob($item);
		}

	}// Method


	/* Hook
	_________________________
	*/
	public function env()
	{
		/**
			@access (public)
				Include theme environment files.
			@return (void)
			@reference (WP)
				Retrieves template directory path for current theme.
				https://developer.wordpress.org/reference/functions/get_template_directory/
			@reference
				[Parent]/inc/utility/general.php
		*/
		foreach(array(
			trailingslashit(get_template_directory()) . 'inc/env',
		) as $item){
			__utility_glob($item);
		}

	}// Method


	/* Hook
	_________________________
	*/
	public function controller()
	{
		/**
			@access (public)
			@return (void)
			@reference (WP)
				Retrieves template directory path for current theme.
				https://developer.wordpress.org/reference/functions/get_template_directory/
			@reference
				[Parent]/inc/utility/general.php
		*/
		foreach(array(
			trailingslashit(get_template_directory()) . 'controller',
		) as $item){
			__utility_glob($item);
		}

	}// Method


	/* Hook
	_________________________
	*/
	public function widget()
	{
		/**
			@access (public)
				Include widget files.
			@return (void)
			@reference (WP)
				Retrieves template directory path for current theme.
				https://developer.wordpress.org/reference/functions/get_template_directory/
			@reference
				[Parent]/inc/utility/general.php
		*/
		foreach(array(
			trailingslashit(get_template_directory()) . 'model/widget',
		) as $item){
			__utility_glob($item);
		}

	}// Method


}// Class
endif;
new _theme_loadup();
// _theme_loadup::__get_instance();
