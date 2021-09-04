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
$index = basename(__FILE__,'.php');


/* Exec
______________________________
*/
?>
<?php
/**
 * @since 1.0.1
 * 	Echo the structural markup for the 404 page.
 * @reference
 * 	[Parent]/404.php
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

	<?php do_action(HOOK_POINT['content']['prepend']); ?>

	<div<?php echo apply_filters("_property[grid][default]",''); ?><?php echo apply_filters("_attribute[grid]",''); ?>>

		<?php do_action(HOOK_POINT['primary']['before']); ?>

		<!-- ====================
			<primary>
		==================== -->
		<main id="primary"<?php echo apply_filters("_property[column][primary]",esc_attr('')); ?><?php echo apply_filters("_attribute[column][primary]",''); ?>>
			<?php
			/**
				@hooked
					_fragment_title::__the_page()
				@reference
					[Parent]/controller/fragment/title.php
			*/
			?>
			<?php do_action(HOOK_POINT['primary']['prepend']); ?>

			<div class="<?php echo apply_filters("_class[template][{$index}]",esc_attr('error-404 not-found')); ?>">

				<header class = "<?php echo apply_filters("_class[template][{$index}][header]",esc_attr('page-header')); ?>">
					<?php
					/**
						@since 1.0.1
							Echo 404 page title.
						@reference
							[Parent]/inc/customizer/option.php
							[Parent]/inc/utility/general.php
					*/
					?>
					<<?php echo __utility_get_option('tag_page-title'); ?> class = "page-title">
						<?php echo apply_filters("_output[template][{$index}][page-title]",__utility_get_option('title_404')); ?>
					</<?php echo __utility_get_option('tag_page-title'); ?>>
				</header>

				<div class = "<?php echo apply_filters("_class[template][{$index}][header]",esc_attr('page-content')); ?>">
					<?php echo apply_filters("_output[template][404][page-content]",__utility_get_option('message_404')); ?>
					<?php
					/**
					 * @reference (WP)
					 * 	Display search form.
					 * 	https://developer.wordpress.org/reference/functions/get_search_form/
					*/
					get_search_form();
					?>
				</div>

			</div><!-- .error-404 -->

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
