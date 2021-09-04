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
	'skin-before' => '',
	'skin-after' => '',
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
 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
 */
beans_open_markup_e("_effect[{$index}][{$needle}]",'div',array('class' => 'uk-overlay uk-overlay-primary uk-light uk-position-cover image-overlay'));
	beans_open_markup_e("_wrap[{$index}][{$needle}]",'div',array('class' => 'uk-position-center'));

		beans_open_markup_e("_figcaption[{$index}][{$needle}][before]",'figcaption',array('class' => $args['skin-before']));

			do_action(HOOK_POINT['figure']['title']);
			// the_title('<h4 class="uk-heading-divider">','</h4>');
		beans_close_markup_e("_figcaption[{$index}][{$needle}][before]",'figcaption');

		/**
			@hooked
				_fragment_meta::__the_caption()
			@reference
				[Parent]/controller/fragment/meta.php
		*/
		beans_open_markup_e("_figcaption[{$index}][{$needle}][after]",'figcaption',array('class' => $args['skin-after']));
			do_action(HOOK_POINT['figure']['meta']);
		beans_close_markup_e("_figcaption[{$index}][{$needle}][after]",'figcaption');

	beans_close_markup_e("_wrap[{$index}][{$needle}]",'div');
beans_close_markup_e("_effect[{$index}][{$needle}]",'div');
