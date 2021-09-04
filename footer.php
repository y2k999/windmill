<?php
/**
 * The template for displaying the footer.
 * Contains the closing of the #content div and all content after.
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
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
 * @reference (WP)
 * 	Load and render footer template.
 * @reference
 * 	[Parent]/template/footer/footer.php
 * 	[Parent]/controller/template.php
 * 	[Parent]/inc/utility/theme.php
*/
?>
<?php __utility_template_footer(); ?>

</div><!-- #page -->

<?php do_action(HOOK_POINT['site']['after']); ?>

<?php
/**
 * @reference (WP)
 * 	Fire the wp_footer action.
 * 	https://developer.wordpress.org/reference/functions/wp_footer/
*/
wp_footer();
?>

</body>
</html>
