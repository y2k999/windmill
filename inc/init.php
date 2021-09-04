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
?>
<?php
/**
 * @since 1.0.1
 * 	This theme requires WordPress 5.3 or later.
 * 	https://wordpress.org/themes/twentytwentyone/
 * @reference (WP)
 * 	Retrieves template directory path for current theme.
 * 	https://developer.wordpress.org/reference/functions/get_template_directory/
*/
if(
	version_compare(PHP_VERSION,'5.6','<') === TRUE ||
	version_compare($GLOBALS['wp_version'],'4.4-alpha','<') === TRUE
){
	require (trailingslashit(get_template_directory()) . 'inc/setup/back-compat.php');
}


/**
 * @since 1.0.1
 * 	Initialize theme update info.
 * 	http://w-shadow.com/
*/

/*
	require trailingslashit(get_template_directory()) . 'inc/plugin/update/theme-update-checker.php';
	$example_update_checker = new ThemeUpdateChecker(
		'windmill',
		'https://raw.githubusercontent.com/yhira/cocoon/master/update-info.json'
	);
*/


/**
 * @since 1.0.1
 * 	Check if Beans Extension plugin is active.
 * 	https://www.wecodeart.com/
 * @reference (WP)
 * 	Determines whether a plugin is active.
 * 	https://developer.wordpress.org/reference/functions/is_plugin_active/
 * 	Switches the theme.
 * 	https://developer.wordpress.org/reference/functions/switch_theme/
*/
include_once(ABSPATH . 'wp-admin/includes/plugin.php');
if(!is_plugin_active('beans-extension/beans-extension.php')){
	if(defined('WP_DEFAULT_THEME') !== FALSE){
		switch_theme(WP_DEFAULT_THEME);
	}
	else{
		$default = WP_Theme::get_core_default_theme();
		switch_theme($default);
	}
}
else{
	/**
	 * @since 1.0.1
	 * 	Include framework files.
	 * @return (void)
	*/
	require_once (trailingslashit(get_template_directory()) . 'inc/setup/constant.php');
	require_once (trailingslashit(get_template_directory()) . 'inc/utility/general.php');

	foreach(array(
		trailingslashit(get_template_directory()) . 'inc/trait',
	) as $item){
		/**
		 * @reference
		 * 	[Parent]/inc/utility/general.php
		*/
		__utility_glob($item);
	}
	require_once (trailingslashit(get_template_directory()) . 'inc/autoloader.php');
	require_once (trailingslashit(get_template_directory()) . 'inc/loadup.php');
}
