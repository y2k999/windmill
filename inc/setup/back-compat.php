<?php
/**
 * Define back compat functionality
 * Prevents the theme from running on WordPress versions prior to 5.3, since this theme is not meant to be backward compatible beyond that and relies on many newer functions and markup changes introduced in 5.3.
 * @package Windmill
 * @license GPL3.0+
 * @since 1.0.1
*/

/**
 * Inspired by Twenty Twenty-One WordPress Theme
 * @link https://wordpress.org/themes/twentytwentyone/
 * @author WordPress team
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

	add_action('after_switch_theme','__hook_switch_theme');
	/**
		@since 1.0.1
			Display upgrade notice on theme switch.
		@reference (WP)
			Fires on the first WP load after a theme switch if the old theme still exists.
			https://developer.wordpress.org/reference/hooks/after_switch_theme/
		@return (void)
	*/
	if(function_exists('__hook_switch_theme') === FALSE) :
	function __hook_switch_theme()
	{
		/**
		 * @reference (WP)
		 * 	Prints admin screen notices.
		 * 	https://developer.wordpress.org/reference/hooks/admin_notices/
		*/
		add_action('admin_notices','__hook_admin_notices');

	}// Method
	endif;


	/**
		@since 1.0.1
			Adds a message for unsuccessful theme switch.
			Prints an update nag after an unsuccessful attempt to switch to the theme on WordPress versions prior to 5.3.
		@global (string) $wp_version
			WordPress version.
			https://codex.wordpress.org/Global_Variables
		@return (void)
	*/
	if(function_exists('__hook_admin_notices') === FALSE) :
	function __hook_admin_notices()
	{
		?><div class="error"><p><?php
		printf(
			/* translators: %s: WordPress Version. */
			esc_html__('This theme requires WordPress 5.3 or newer. You are running version %s. Please upgrade.','windmill'),
			esc_html($GLOBALS['wp_version'])
		);
		?></p></div>

	<?php
	}// Method
	endif;


	add_action('load-customize.php','__hook_load_customize');
	/**
		@since 1.0.1
			Prevents the Customizer from being loaded on WordPress versions prior to 5.3.
		@reference (WP)
			Runs when an administration menu page is loaded. 
			https://developer.wordpress.org/reference/hooks/load-page-php/
		@global (string) $wp_version
			WordPress version.
			https://codex.wordpress.org/Global_Variables
		@return (void)
	*/
	if(function_exists('__hook_load_customize') === FALSE) :
	function __hook_load_customize()
	{
		/**
		 * @reference (WP)
		 * 	Kills WordPress execution and displays HTML page with an error message.
		 * 	https://developer.wordpress.org/reference/functions/wp_die/
		*/
		wp_die(sprintf(
			/* translators: %s: WordPress Version. */
			esc_html__('This theme requires WordPress 5.3 or newer. You are running version %s. Please upgrade.','windmill'),
			esc_html($GLOBALS['wp_version'])
		),'',array(
			'back_link' => TRUE,
		));

	}// Method
	endif;


	add_action('template_redirect','__hook_template_redirect');
	/**
		@since 1.0.1
			Prevents the Theme Preview from being loaded on WordPress versions prior to 5.3.
		@reference (WP)
			Fires before determining which template to load.
			https://developer.wordpress.org/reference/hooks/template_redirect/
		@global (string) $wp_version
			WordPress version.
			https://codex.wordpress.org/Global_Variables
		@return (void)
	*/
	if(function_exists('__hook_template_redirect') === FALSE) :
	function __hook_template_redirect()
	{
		/**
		 * @reference (WP)
		 * 	Kills WordPress execution and displays HTML page with an error message.
		 * 	https://developer.wordpress.org/reference/functions/wp_die/
		*/
		if(isset($_GET['preview'])){
			/* phpcs:ignore WordPress.Security.NonceVerification */
			wp_die(sprintf(
				/* translators: %s: WordPress Version. */
				esc_html__('This theme requires WordPress 5.3 or newer. You are running version %s. Please upgrade.','windmill'),
				esc_html($GLOBALS['wp_version'])
			));
		}

	}// Method
	endif;
