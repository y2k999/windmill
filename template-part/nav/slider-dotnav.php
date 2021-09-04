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
 * [NOTE]
 * 	When displaying this type of navigation (uk-dotnav), Google Lighthouse Audit points out "Links are not crawlable" message.
 * 	https://developers.google.com/search/docs/advanced/guidelines/links-crawlable

 * @since 1.0.1
 * 	Display dot navigation to operate slideshows.
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
beans_open_markup_e("_list[{$index}][{$needle}]",'ul',array('class' => 'uk-slider-nav uk-dotnav uk-flex-center uk-margin-small'));
	beans_open_markup_e("_item[{$index}][{$needle}]",'li');
	beans_close_markup_e("_item[{$index}][{$needle}]",'li');
beans_close_markup_e("_list[{$index}][{$needle}]",'ul');
