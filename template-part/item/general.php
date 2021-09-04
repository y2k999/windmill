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


/* Exec
______________________________
*/
?>
<?php
/**
 * @since 1.0.1
 * 	Display post in general format.
 * @reference
 * 	[Parent]/inc/setup/constant.php
 * 	[Parent]/model/data/css.php
 * 	[Parent]/model/data/scheme.php
 * 	[Parent]/model/widget/xxx.php
*/

/**
 * @reference (Uikit)
 * 	https://getuikit.com/docs/card
*/
?>
<!-- =============== 
	<item-general>
 =============== -->
<div class="<?php echo apply_filters("_class[{$index}][item][unit]",esc_attr('uk-card')); ?>">

	<?php if(has_action(HOOK_POINT['item'][$index]['image'])) : ?>
		<div class="<?php echo apply_filters("_class[{$index}][item][image]",esc_attr('uk-card-media-left')); ?>">
			<?php
			/**
				@hooked
					_fragment_image::__the_general()
				@reference
					[Parent]/controller/fragment/image.php
			*/
			?>
			<?php do_action(HOOK_POINT['item'][$index]['image']); ?>
		</div><!-- .media -->
	<?php endif; ?>

	<?php if(has_action(HOOK_POINT['item'][$index]['header'])) : ?>
		<div class="<?php echo apply_filters("_class[{$index}][item][header]",esc_attr('uk-card-header')); ?>">
			<?php
			/**
				@hooked
					_fragment_meta::__the_general()
					_fragment_title::__the_general()
				@reference
					[Parent]/controller/fragment/meta.php
					[Parent]/controller/fragment/title.php
			*/
			?>
			<?php do_action(HOOK_POINT['item'][$index]['header']); ?>
		</div><!-- .header -->
	<?php endif; ?>

	<?php if(has_action(HOOK_POINT['item'][$index]['body'])) : ?>
		<div class="<?php echo apply_filters("_class[{$index}][item][body]",esc_attr('uk-card-body')); ?>">
			<?php
			/**
				@hooked
					_fragment_excerpt::__the_general()
				@reference
					[Parent]/controller/fragment/excerpt.php
			*/
			?>
			<?php do_action(HOOK_POINT['item'][$index]['body']); ?>
		</div><!-- .body -->
	<?php endif; ?>

	<?php if(has_action(HOOK_POINT['item'][$index]['footer'])) : ?>
		<div class="<?php echo apply_filters("_class[{$index}][item][footer]",esc_attr('uk-card-footer')); ?>">
			<?php do_action(HOOK_POINT['item'][$index]['footer']); ?>
		</div><!-- .footer -->
	<?php endif; ?>

</div><!-- .general -->
