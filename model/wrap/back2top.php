<?php
/**
 * Render wrapper markups for applications.
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
 * @param (string)|(array)|(object) $args
 * 	Value to merge with $defaults.
 * @param (array) $defaults
 * 	Array that serves as the defaults.
*/
$args = wp_parse_args($args,array(
	'class' => '',
));


/* Exec
______________________________
*/
?>
<?php
if($args['class'] === 'footer'){

	beans_add_smart_action(HOOK_POINT['model'][$index]['prepend'],'__wrap_back2top_prepend');
	/**
		@access (public)
			Render opening markups.
		@return (void)
		@reference
			[Parent]/controller/structure/footer.php
			[Parent]/inc/utility/theme.php
			[Parent]/model/app/back2top.php
	*/
	if(function_exists('__wrap_back2top_prepend') === FALSE) :
	function __wrap_back2top_prepend()
	{
		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * @reference (Uikit)
		 * 	https://getuikit.com/docs/column
		 * 	https://getuikit.com/docs/visibility
		*/
		beans_open_markup_e("_column[_structure_footer][back2top]",'div',__utility_get_column('default',array('class' => 'uk-padding-small uk-padding-remove-top uk-padding-remove-bottom uk-visible@m')));

	}// Method
	endif;


	beans_add_smart_action(HOOK_POINT['model'][$index]['append'],'__wrap_back2top_append');
	/**
		@access (public)
			Render closing markups.
		@return (void)
		@reference
			[Parent]/controller/structure/footer.php
			[Parent]/model/app/back2top.php
	*/
	if(function_exists('__wrap_back2top_append') === FALSE) :
	function __wrap_back2top_append()
	{
		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_close_markup_e("_column[_structure_footer][back2top]",'div');

	}// Method
	endif;

}// endif
