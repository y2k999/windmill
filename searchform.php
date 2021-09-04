<?php
/**
 * The template for displaying search forms.
 * Used any time that get_search_form() is called.
 * @link https://developer.wordpress.org/reference/functions/get_search_form/
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
 * @reference (WP)
 * 	Generate a unique ID for each form and a string containing an aria-label if one was passed to get_search_form() in the args array.
 * 	https://developer.wordpress.org/reference/functions/wp_unique_id/
*/
$unique_id = wp_unique_id('search-form-');
$aria_label = !empty($args['aria_label']) ? 'aria-label="' . esc_attr($args['aria_label']) . '"' : '';


/* Exec
______________________________
*/
?>
<?php
/**
 * @reference (Uikit)
 * 	https://getuikit.com/docs/form
 * 	https://getuikit.com/docs/icon
 * 	https://getuikit.com/docs/search
 * @reference (WP)
 * 	Retrieves the URL for the current site where the front end is accessible.
 * 	https://developer.wordpress.org/reference/functions/home_url/
*/
?>
<?php /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above. */ ?>
<form role="search" <?php echo $aria_label; ?> method="get" class="<?php echo apply_filters("_class[{$index}][search][form]",esc_attr('uk-search uk-search-default uk-padding-small uk-width-1-1')); ?>" id="searchform" action="<?php echo esc_url(home_url('/')); ?>" itemprop="potentialAction" itemscope itemtype="https://schema.org/SearchAction">
	<span class="<?php echo apply_filters("_class[{$index}][search][icon]",esc_attr('uk-padding-small')); ?>" uk-search-icon></span>
	<input type="search" id="<?php echo esc_attr($unique_id); ?>" class="<?php echo apply_filters("_class[{$index}][search][input]",esc_attr('uk-search-input')); ?>" value="" placeholder="<?php echo esc_attr__('Search','windmill'); ?>" name="s" itemprop="query-input" />
</form>
