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
	'skin' => '',
));
$needle = $args['needle'];


/* Exec
______________________________
*/
?>
<?php
/**
 * @reference (Beans)
 * 	HTML markup.
 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
 */
beans_open_markup_e("_figcaption[{$index}][{$needle}]",'div',array('class' => $args['skin']));

	do_action(HOOK_POINT['figure']['title']);
	// the_title('<h4 class="uk-heading-divider">','</h4>');

	beans_open_markup_e("_meta[{$index}][{$needle}]",'p',array('class' => 'uk-article-meta'));
		/**
			@hooked
				_fragment_meta::__the_caption()
			@reference
				[Parent]/controller/fragment/meta.php
		*/
		do_action(HOOK_POINT['figure']['meta']);
	beans_close_markup_e("_meta[{$index}][{$needle}]",'p');

beans_close_markup_e("_figcaption[{$index}][{$needle}]",'div');
