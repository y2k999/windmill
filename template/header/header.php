<?php
/**
 * The template for displaying the required page.
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
// $index = basename(__FILE__,'.php');


/* Exec
______________________________
*/
?>
<?php
/**
 * @since 1.0.1
 * 	Echo the structural markup for header template.
 * @reference
 * 	[Parent]/header.php
 * 	[Parent]/controller/layout.php
 * 	[Parent]/inc/setup/constant.php
 * 	[Parent]/model/data/attribute.php
 * 	[Parent]/model/data/style.php
 * @reference (Uikit)
 * 	https://getuikit.com/docs/container
 * 	https://getuikit.com/docs/grid
 * 	https://getuikit.com/docs/section
 * 	https://getuikit.com/docs/width
*/
?>
<?php do_action(HOOK_POINT['masthead']['before']); ?>

<!-- ====================
	<masthead>
 ==================== -->
<section<?php echo apply_filters("_property[section][masthead]",''); ?><?php echo apply_filters("_attribute[section][masthead]",''); ?>>
<header id="masthead"<?php echo apply_filters("_property[container][masthead]",esc_attr('')); ?><?php echo apply_filters("_attribute[container][masthead]",''); ?>>

	<?php if(has_action(HOOK_POINT['masthead']['prepend'])) : ?>
		<div<?php echo apply_filters("_property[grid][masthead][prepend]",''); ?><?php echo apply_filters("_attribute[grid]",''); ?>>
			<?php do_action(HOOK_POINT['masthead']['prepend']); ?>
		</div><!-- .grid -->
	<?php endif; ?>

	<?php if(has_action(HOOK_POINT['masthead']['main'])) : ?>
		<div<?php echo apply_filters("_property[grid][masthead][main]",''); ?><?php echo apply_filters("_attribute[grid]",''); ?>>
			<?php
			/**
				@hooked
					_structure_header::__the_branding()
					_structure_header::__the_icon()
				@reference
					[Parent]/controller/structure/header.php
			*/
			?>
			<?php do_action(HOOK_POINT['masthead']['main']); ?>
		</div><!-- .grid -->
	<?php endif; ?>

	<?php if(has_action(HOOK_POINT['masthead']['append'])) : ?>
		<div<?php echo apply_filters("_property[grid][masthead][append]",''); ?><?php echo apply_filters("_attribute[grid]",''); ?>>
			<?php do_action(HOOK_POINT['masthead']['append']); ?>
		</div><!-- .grid -->
	<?php endif; ?>

</header>
</section>

<?php do_action(HOOK_POINT['masthead']['after']); ?>
