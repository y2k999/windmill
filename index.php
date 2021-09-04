<?php
/**
 * The main template file.
 * This is the most generic template file in a WordPress theme and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g.,it puts together the home page when no home.php file exists.
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
 * @reference (WP)
 * 	Load header template.
 * 	https://developer.wordpress.org/reference/functions/get_header/
*/
?>
<?php get_header(); ?>

<?php
/**
 * @since 1.0.1
 * 	Load and render content template.
 * @reference
 * 	[Parent]/template/content/index.php
 * 	[Parent]/template/content/archive.php
 * 	[Parent]/template/content/singular.php
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
