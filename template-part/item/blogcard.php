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
 * 
 * Inspired by yStandard WordPress Theme
 * @link https://wp-ystandard.com
 * @author yosiakatsuki
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
 * 	Display blogcard.
 * @reference (Uikit)
 * 	https://getuikit.com/docs/card
 * 	https://getuikit.com/docs/grid
 * 	https://getuikit.com/docs/width
 * @reference
 * 	[Parent]/inc/env/blogcard.php
 * 	[Parent]/inc/setup/constant.php
*/
?>
<div class="<?php echo apply_filters("_class[{$index}][unit]",esc_attr('uk-card uk-card-default uk-card-hover uk-padding-small uk-margin-medium-top uk-margin-medium-bottom ' . $index)); ?>" style="border: solid 1px <?php echo COLOR['border']; ?>;">

	<div class="<?php echo apply_filters("_class[{$index}][grid]",esc_attr('uk-position-relative uk-grid-small uk-grid-match')); ?>"<?php echo apply_filters("_attribute[grid]",''); ?>>

		<figure class="<?php echo apply_filters("_class[{$index}][media]",esc_attr('uk-card-media uk-width-1-3@m uk-padding-small')); ?>">
			<?php if($args['img_src']) : ?>
				<a href="<?php echo esc_url_raw($args['url']); ?>"<?php echo $args['target']; ?> rel="noopener noreferrer" aria-label="<?php echo esc_html($args['title']); ?>"><?php echo $args['img_src']; ?></a>
			<?php endif; ?>
		</figure><!-- .media -->

		<div class="<?php echo apply_filters("_class[{$index}][body]",esc_attr('uk-card-body uk-width-expand uk-padding-remove')); ?>">

			<p class="<?php echo apply_filters("_class[{$index}][title]",esc_attr('uk-card-title uk-text-default uk-margin-remove uk-padding-small')); ?>">
				<a href="<?php echo esc_url_raw($args['url']); ?>"<?php echo $args['target']; ?> rel="noopener noreferrer" aria-label="<?php echo esc_html($args['title']); ?>"><?php echo esc_html($args['title']); ?></a>
			</p>

			<?php if($args['description']) : ?>
				<p class="<?php echo apply_filters("_class[{$index}][description]",esc_attr('uk-text-small uk-margin-remove')); ?>">
					<?php echo esc_html($args['description']); ?>
				</p>
			<?php endif; ?>

			<?php if($args['domain']) : ?>
				<span class="<?php echo apply_filters("_class[{$index}][domain]",esc_attr('uk-padding-small uk-padding-remove-bottom uk-text-meta uk-text-right')); ?>"><a href="<?php echo esc_url_raw($args['url']); ?>"<?php echo $args['target']; ?> rel="noopener noreferrer" aria-label="favicon"><?php echo esc_html($args['domain']); ?></a></span>
			<?php endif; ?>

		</div><!-- .body -->

	</div>
</div><!-- .card -->
