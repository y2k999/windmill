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

/**
 * @since 1.0.1
 * 	Additional arguments passed to the template via get_template_part().
 * @reference (WP)
 * 	Merges user defined arguments into defaults array.
 * 	https://developer.wordpress.org/reference/functions/wp_parse_args/
*/
$args = wp_parse_args($args,array(
	'needle' => '',
));
$needle = $args['needle'];


/* Exec
______________________________
*/
?>
<?php
/**
 * @since 1.0.1
 * 	Display slider navigation.
 * @reference (Beans)
 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
 * @reference (Uikit)
 * 	https://getuikit.com/docs/dotnav
 * 	https://getuikit.com/docs/slider
 * @reference
 * 	[Parent]/module/widget/recent.php
 * 	[Parent]/module/widget/relation.php
*/

	beans_open_markup_e("_link[{$index}][{$needle}][previous]",'a',array(
		'href' => '#',
		'class' => 'uk-slidenav-large uk-position-center-left uk-position-small uk-hidden-hover',
		'aria-label' => esc_html('Previous'),
		'uk-slidenav-previous' => '',
		'uk-slider-item' => 'previous',

	));
	beans_close_markup_e("_link[{$index}][{$needle}][previous]",'a');

	beans_open_markup_e("_link[{$index}][{$needle}][next]",'a',array(
		'href' => '#',
		'class' => 'uk-slidenav-large uk-position-center-right uk-position-small uk-hidden-hover',
		'aria-label' => esc_html('Next'),
		'uk-slidenav-next' => '',
		'uk-slider-item' => 'next',

	));
	beans_close_markup_e("_link[{$index}][{$needle}][next]",'a');
