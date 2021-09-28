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
	'toggle-target' => '',
));


/* Exec
______________________________
*/
?>
<?php
/**
 * @since 1.0.1
 * 	Display search form in overlay format.
 * @reference (Beans)
 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
 * 	https://www.getbeans.io/code-reference/functions/beans_selfclose_markup_e/
 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
 * @reference (Uikit)
 * 	https://getuikit.com/docs/navbar
 * 	https://getuikit.com/docs/form
 * 	https://getuikit.com/docs/animation
 * @reference
 * 	[Parent]/model/app/search.php
*/
beans_open_markup_e("_wrap[{$index}]",'div',array(
	'class' => 'uk-navbar-item uk-width-expand',
	'itemscope' => 'itemscope',
	'itemtype' => 'https://schema.org/WebSite',
	'url' => esc_url(home_url('/')),
));
/*
	beans_output_e("_meta[{$index}][url]",sprintf(
		'<meta itemprop="url" content="%1$s" />',
		esc_url(home_url('/'))
	));
*/
	beans_open_markup_e("_form[{$index}]",'form',array(
		'itemprop' => 'potentialAction',
		'itemscope' => 'itemscope',
		'itemtype' => 'https://schema.org/SearchAction',
		'method' => 'get',
		'class' => 'uk-search uk-width-1-1',
		/**
		 * @reference (WP)
		 * 	Retrieves the URL for the current site where the front end is accessible.
		 * 	https://developer.wordpress.org/reference/functions/home_url/
		*/
		'action' => esc_url(home_url('/')),
		'target' => esc_url(home_url('/')) . '?s={s}',
		'role' => 'search',
	));
/*
		beans_output_e("_meta[{$index}][target]",sprintf(
			'<meta itemprop="target" content="%1$s?s={s}" />',
			esc_url(home_url('/'))
		));
*/
		beans_selfclose_markup_e("_input[{$index}]",'input',array(
			'class' => 'uk-input uk-search-input',
			'name' => 's',
			'value' => get_search_query(),
			'placeholder' => esc_attr('Search...'),
			'itemprop' => 'query-input',
		));

	beans_close_markup_e("_form[{$index}]",'form');

	beans_open_markup_e("_link[{$index}]",'a',array(
		'href' => '#',
		'class' => 'uk-navbar-toggle',
		'uk-toggle' => 'target: .' . $args['toggle-target'] . '; animation: uk-animation-fade',
		'uk-close' => 'uk-close',
	));
	beans_close_markup_e("_link[{$index}]",'a');

beans_close_markup_e("_wrap[{$index}]",'div');
