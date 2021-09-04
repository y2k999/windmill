<?php
/**
 * Template part for displaying the required contents.
 * @link https://codex.wordpress.org/Template_Hierarchy
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
$index = basename(__FILE__,'.php');


/* Exec
______________________________
*/
?>
<?php
/**
 * @since 1.0.1
 * 	Display uikit offcanvas navigation.
 * @reference (Beans)
 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
 * @reference
 * 	[Parent]/model/app/nav.php
 * 	[Parent]/inc/plugin/navwalker/navwalker-offcanvas.php
*/
beans_open_markup_e("_nav[{$index}]",'nav',array(
	'id' => 'primary-navigation',
	'itemscope' => 'itemscope',
	'itemtype' => 'https://schema.org/SiteNavigationElement',
	'aria-label' => esc_attr('Offcanvas Navigation'),
	'role' => 'navigation',
));
	/**
	 * @reference (WP)
	 * 	Determines whether a registered nav menu location has a menu assigned to it.
	 * 	https://developer.wordpress.org/reference/functions/has_nav_menu/
	*/
	if(has_nav_menu('primary_navigation')){
		/**
		 * @reference (Uikit)
		 * 	https://getuikit.com/docs/nav
		 * @reference (WP)
		 * 	Filters the arguments used to display a navigation menu.
		 * 	https://developer.wordpress.org/reference/hooks/wp_nav_menu_args/
		 * 	Displays a navigation menu.
		 * 	https://developer.wordpress.org/reference/functions/wp_nav_menu/
		*/
		wp_nav_menu(apply_filters("_filter[wp_nav_menu][{$index}]",array(
			'theme_location' => 'primary_navigation',
			'items_wrap' => '<ul id="%1$s" class="%2$s" uk-nav>%3$s</ul>',	
			'container' => FALSE,
			'menu_class' => 'uk-nav uk-nav-default uk-nav-parent-icon',
			'echo' => TRUE,
			'walker' => new _windmill_navwalker_offcanvas(),
		)));
	}
	else{
		beans_output_e("_output[{$index}]",esc_html__('Add Menu','windmill'));
	}
beans_close_markup_e("_nav[{$index}]",'nav');
