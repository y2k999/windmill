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
<?php
/**
 * @reference (WP)
 * 	Load header template.
 * 	https://developer.wordpress.org/reference/functions/get_header/
*/
?>
<?php get_header(); ?>

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
			?>
			<?php while(have_posts()) : the_post(); ?>

				<!-- ====================
					<article>
				==================== -->
				<?php
				/**
				 * @reference (WP)
				 * 	Display the ID of the current item in the WordPress Loop.
				 * 	https://developer.wordpress.org/reference/functions/the_id/
				 * 	Displays the classes for the post container element.
				 * 	https://developer.wordpress.org/reference/functions/post_class/
				*/
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<!-- =============== 
						<entry-header>
					=============== -->
					<?php __utility_app_share(); ?>

					<header class="<?php echo apply_filters("_class[page][article][header]",esc_attr('entry-header')); ?>"<?php echo apply_filters("_attribute[page][article][header]",''); ?>>
						<?php
						/**
							@hooked
								_fragment_title::__the_archive()
							@reference
								[Parent]/controller/fragment/title.php
						*/
						?>
						<?php do_action(HOOK_POINT['page']['header']['main']); ?>
					</header>

					<!-- =============== 
						<entry-content>
					=============== -->
					<div class="<?php echo apply_filters("_class[page][article][content]",esc_attr('entry-content')); ?>"<?php echo apply_filters("_attribute[page][article][content]",''); ?>>
						<?php the_content(); ?>

						<?php the_widget('_widget_recent'); ?>
					</div><!-- .entry-content -->

				</article>

			<?php endwhile; ?>

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

<?php
/**
 * @reference (WP)
 * 	Load footer template.
 * 	https://developer.wordpress.org/reference/functions/get_footer/
*/
?>
<?php get_footer(); ?>
