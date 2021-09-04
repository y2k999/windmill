<?php
/**
 * Template Name: Toppage Template
 *
 * This is the template that displays specific Toppage.
 * Please note that this is the WordPress construct of pages and that other pages on your WordPress site will use a different template.
 * 
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/
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
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<!-- ====================
	<head>
 ==================== -->
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php do_action(HOOK_POINT['head']['before']); ?>
	<?php wp_head(); ?>
	<?php do_action(HOOK_POINT['head']['after']); ?>
</head>

<!-- ====================
	<body>
 ==================== -->
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php do_action(HOOK_POINT['site']['before']); ?>

<div id="page" class="<?php echo apply_filters("_class[root][site]",esc_attr('hfeed site')); ?>">

<?php if(apply_filters("_filter[root][skiplink]",TRUE)) : ?>
	<a class="screen-reader-text skip-link" href="#content"><?php echo apply_filters("_output[root][skip-link]",esc_html__('Skip to Content.','windmill')); ?></a>
<?php endif; ?>

<!-- ====================
	<masthead>
 ==================== -->
<section<?php echo apply_filters("_property[section][masthead]",''); ?>>
<header id="masthead" class="uk-container uk-container-expand uk-padding-remove-horizontal site-header" role="banner" itemscope="itemscope" itemtype="https://schema.org/WPHeader" itemprop="publisher" uk-sticky>
	<nav class="uk-navbar-transparent" uk-navbar>
		<div class="uk-navbar-left uk-padding-small">
			<?php __utility_app_branding(); ?>
		</div><!-- .navbar-left -->
	
		<div class="uk-navbar-right uk-visible@m">
			<?php
			/* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped -- Echoes HTML output. */
			if(__utility_is_beans('widget')){
				if(beans_has_widget_area('header_primary')){
					echo beans_get_widget_area_output('header_primary');
				}
			}
			else{
				if(is_active_sidebar('header_primary')){
					dynamic_sidebar('header_primary');
				}
			}
			?>

		</div><!-- .navbar-right -->
	</nav>

	<div class="uk-width-auto uk-padding-remove-horizontal uk-background-secondary">
		<ul class="uk-subnav uk-padding-small uk-flex uk-flex-center">
			<li class="uk-visible@s"><a href="#">Home</a></li>
			<li class="uk-visible@s"><a href="#">About Us</a></li>
			<li class="uk-visible@s"><a href="#">Contact</a></li>
			<li class="uk-visible@s"><a href="#">Blog</a></li>
			<li class="uk-visible@s"><a href="#">Privacy</a></li>
		</ul>
	</div>

</header>
</section>


<!-- ====================
	<site-content>
==================== -->
<div id="content" class="uk-container uk-container-expand site-content">
	<div class="uk-grid-small" uk-grid>

		<div class="uk-width-1-2">
			<?php do_action('windmill/template/toppage/one'); ?>
		</div><!-- .uk-width -->

		<div class="uk-width-1-2">
			<?php do_action('windmill/template/toppage/two'); ?>
		</div><!-- .uk-width -->

	</div><!-- .grid -->

	<div class="uk-grid-small" uk-grid="uk-grid">

		<!-- ====================
			<primary>
		==================== -->
		<main id="primary" class="uk-width-1-1@s uk-width-2-3@m site-main" role="main" itemscope="itemscope" itemtype="https://schema.org/Blog" itemprop="mainEntityOfPage" tabindex="-1">

			<?php do_action('windmill/template/toppage/three'); ?>

			<?php do_action('windmill/template/toppage/four'); ?>

			<?php do_action('windmill/template/toppage/five'); ?>

		</main>

		<!-- ====================
			<secondary>
		==================== -->
		<?php
		/**
		 * @reference (WP)
		 * 	Load sidebar template.
		 * 	https://developer.wordpress.org/reference/functions/get_sidebar/
		*/
		get_sidebar();
		?>

	</div><!-- .grid -->

</div><!-- #content -->

<?php get_footer(); ?>
