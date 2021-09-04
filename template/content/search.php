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
 * 	Echo the structural markup for the single post/page.
 * @reference
 * 	[Parent]/index.php
 * 	[Parent]/controller/layout.php
 * 	[Parent]/controller/template.php
 * 	[Parent]/inc/setup/constant.php
*/

/**
 * @reference (Uikit)
 * 	https://getuikit.com/docs/container
 * 	https://getuikit.com/docs/grid
 * 	https://getuikit.com/docs/section
 * 	https://getuikit.com/docs/width
*/
?>
<?php do_action(HOOK_POINT['content']['before']); ?>

<!-- ====================
	<site-content>
==================== -->
<section<?php echo apply_filters("_property[section][content]",''); ?>>
<div id="content"<?php echo apply_filters("_property[container][content]",esc_attr('')); ?><?php echo apply_filters("_attribute[container][content]",''); ?>>
	<?php
	/**
		@hooked
			_fragment_title::__the_page()
		@reference
			[Parent]/controller/fragment/title.php
	*/
	?>
	<?php do_action(HOOK_POINT['content']['prepend']); ?>

	<div<?php echo apply_filters("_property[grid][default]",''); ?><?php echo apply_filters("_attribute[grid]",''); ?>>

		<?php do_action(HOOK_POINT['primary']['before']); ?>

		<!-- ====================
			<primary>
		==================== -->
		<main id="primary"<?php echo apply_filters("_property[column][primary]",esc_attr('')); ?><?php echo apply_filters("_attribute[column][primary]",''); ?>>

			<?php do_action(HOOK_POINT['primary']['prepend']); ?>

			<?php 
			/**
			 * @reference (WP)
			 * 	Determines whether current WordPress query has posts to loop over.
			 * 	https://developer.wordpress.org/reference/functions/have_posts/
			 * 	Iterate the post index in the loop.
			 * 	https://developer.wordpress.org/reference/functions/the_post/
			 * 	Loads a template part into a template.
			 * 	https://developer.wordpress.org/reference/functions/get_template_part/
			*/
			if(!have_posts()) :
				get_template_part(SLUG['content'] . 'content','none');
			endif;

			while(have_posts()) : the_post();
				get_template_part(SLUG['content'] . 'content','search');
			endwhile;
			?>

			<?php do_action(HOOK_POINT['primary']['append']); ?>
		</main>

		<?php do_action(HOOK_POINT['primary']['after']); ?>

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

	<?php do_action(HOOK_POINT['content']['append']); ?>

</div><!-- #content -->
</section>

<?php do_action(HOOK_POINT['content']['after']); ?>
