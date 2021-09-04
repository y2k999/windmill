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
 * 	Echo the structural markup for footer template.
 * @reference
 * 	[Parent]/footer.php
 * 	[Parent]/controller/layout.php
 * 	[Parent]/inc/setup/constant.php
 * 	[Parent]/model/data/attribute.php
 * 	[Parent]/model/data/style.php
*/

/**
 * @reference (Uikit)
 * 	https://getuikit.com/docs/container
 * 	https://getuikit.com/docs/grid
 * 	https://getuikit.com/docs/section
 * 	https://getuikit.com/docs/width
*/
?>

<?php
/**
	@hooked
		_structure_footer::__the_breadcrumb()
	@reference
		[Parent]/controller/structure/footer.php
*/
?>
<?php do_action(HOOK_POINT['colophone']['before']); ?>

<!-- ====================
	<colophone>
 ==================== -->
<section<?php echo apply_filters("_property[section][colophone]",''); ?>>
<footer id="colophone"<?php echo apply_filters("_property[container][colophone]",esc_attr('')); ?><?php echo apply_filters("_attribute[container][colophone]",''); ?>>
	<?php if(has_action(HOOK_POINT['colophone']['prepend'])) : ?>
		<div<?php echo apply_filters("_property[grid][colophone][prepend]",''); ?><?php echo apply_filters("_attribute[grid]",''); ?>>
			<?php
			/**
				@hooked
					_structure_footer::__the_back2top()
					_structure_footer::__the_nav()
				@reference
					[Parent]/controller/structure/footer.php
			*/
			?>
			<?php do_action(HOOK_POINT['colophone']['prepend']); ?>
		</div><!-- .grid -->
	<?php endif; ?>

	<?php if(has_action(HOOK_POINT['colophone']['main'])) : ?>
		<div<?php echo apply_filters("_property[grid][colophone][main]",''); ?><?php echo apply_filters("_attribute[grid]",''); ?>>
			<?php
			/**
				@hooked
					_structure_footer::__the_dynamic_sidebar()
				@reference
					[Parent]/footer.php
					[Parent]/controller/structure/footer.php
			*/
			?>
			<?php do_action(HOOK_POINT['colophone']['main']); ?>
		</div><!-- .grid -->
	<?php endif; ?>

	<?php if(has_action(HOOK_POINT['colophone']['append'])) : ?>
		<div<?php echo apply_filters("_property[grid][colophone][append]",''); ?><?php echo apply_filters("_attribute[grid]",''); ?>>
			<?php
			/**
				@hooked
					_structure_footer::__the_credit()
				@reference
					[Parent]/controller/structure/footer.php
			*/
			?>
			<?php do_action(HOOK_POINT['colophone']['append']); ?>
		</div><!-- .grid -->
	<?php endif; ?>

</footer>
</section>

<?php do_action(HOOK_POINT['colophone']['after']); ?>
