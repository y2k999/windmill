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
 * 	Echo the structural markup for sidebar template.
 * @reference
 * 	[Parent]/sidebar.php
 * 	[Parent]/controller/layout.php
 * 	[Parent]/inc/setup/constant.php
 * 	[Parent]/model/data/attribute.php
 * 	[Parent]/model/data/style.php
*/

/**
 * @reference (Uikit)
 * 	https://getuikit.com/docs/grid
 * 	https://getuikit.com/docs/width
*/
?>

<?php do_action(HOOK_POINT['secondary']['before']); ?>

<aside id="secondary"<?php echo apply_filters("_property[column][secondary]",esc_attr('')); ?><?php echo apply_filters("_attribute[column][secondary]",''); ?>>

	<?php if(has_action(HOOK_POINT['secondary']['prepend'])) : ?>
		<?php do_action(HOOK_POINT['secondary']['prepend']); ?>
	<?php endif; ?>

	<?php if(has_action(HOOK_POINT['secondary']['main'])) : ?>
		<?php
		/**
			@hooked
				_structure_sidebar::__the_dynamic_sidebar()
				_structure_sidebar::__the_profile()
			@reference
				[Parent]/controller/structure/sidebar.php
		*/
		?>
		<?php do_action(HOOK_POINT['secondary']['main']); ?>
	<?php endif; ?>

	<?php if(has_action(HOOK_POINT['secondary']['append'])) : ?>
		<?php do_action(HOOK_POINT['secondary']['append']); ?>
	<?php endif; ?>

</aside>

<?php do_action(HOOK_POINT['secondary']['after']); ?>
