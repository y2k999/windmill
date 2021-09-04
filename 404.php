<?php
/**
 * The template for displaying 404 pages.
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
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
 * 	Load header template.
 * 	https://developer.wordpress.org/reference/functions/get_header/
*/
?>
<?php get_header(); ?>

<?php
/**
 * @since 1.0.1
 * 	Load and render 404 page template.
 * @reference
 * 	[Parent]/template/content/404.php
 * 	[Parent]/controller/template.php
 * 	[Parent]/inc/utility/theme.php
*/
?>
<?php __utility_template_content(); ?>

<?php
/**
 * @reference (WP)
 * 	Load footer template.
 * 	https://developer.wordpress.org/reference/functions/get_footer/
*/
?>
<?php get_footer(); ?>
