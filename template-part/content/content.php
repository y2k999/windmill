<?php
/**
 * Template part for displaying the required contents.
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
// $index = str_replace(substr(basename(__FILE__,'.php'),0,8),'',basename(__FILE__,'.php'));
$index = 'single';


/* Exec
______________________________
*/
?>
<?php
/**
 * @since 1.0.1
 * 	Echo single post content.
 * @reference
 * 	[Parent]/inc/setup/constant.php
 * 	[Parent]/model/data/css.php
 * 	[Parent]/model/data/schema.php
 * 	[Parent]/template/content/singular.php
*/
?>
<!-- ====================
	<article>
==================== -->
<?php
/**
 * @reference (Reference)
 * 	https://getuikit.com/docs/article
 * 
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
	<?php
	/**
		@hooked
			_fragment_share::__the_single()
		@reference
			[Parent]/controller/fragment/share.php
	*/
	?>
	<?php do_action(HOOK_POINT[$index]['header']['before']); ?>

	<header class="<?php echo apply_filters("_class[{$index}][article][header]",esc_attr('entry-header')); ?>"<?php echo apply_filters("_attribute[{$index}][article][header]",''); ?>>
		<?php do_action(HOOK_POINT[$index]['header']['prepend']); ?>
		<?php
		/**
			@hooked
				_fragment_title::__the_single()
			@reference
				[Parent]/controller/fragment/title.php
		*/
		?>
		<?php do_action(HOOK_POINT[$index]['header']['main']); ?>
		<?php
		/**
			@hooked
				_fragment_meta::__the_single()
			@reference
				[Parent]/controller/fragment/meta.php
		*/
		?>
		<?php do_action(HOOK_POINT[$index]['header']['append']); ?>
	</header>

	<?php do_action(HOOK_POINT[$index]['header']['after']); ?>

	<!-- =============== 
		<entry-content>
	=============== -->
	<?php do_action(HOOK_POINT[$index]['body']['before']); ?>

	<div class="<?php echo apply_filters("_class[{$index}][article][content]",esc_attr('entry-content')); ?>"<?php echo apply_filters("_attribute[{$index}][article][content]",''); ?>>
		<?php do_action(HOOK_POINT[$index]['body']['prepend']); ?>
		<?php
		/**
			@hooked
				_structure_single::__the_content()
				_structure_single::__the_wp_link_pages()
			@reference
				[Parent]/controller/structure/single.php
		*/
		?>
		<?php do_action(HOOK_POINT[$index]['body']['main']); ?>
		<?php
		/**
			@hooked
				_structure_single::__the_relation()
			@reference
				[Parent]/controller/structure/single.php
		*/
		?>
		<?php do_action(HOOK_POINT[$index]['body']['append']); ?>
	</div><!-- .entry-content -->

	<?php do_action(HOOK_POINT[$index]['body']['after']); ?>

	<!-- =============== 
		<entry-footer>
	=============== -->
	<?php
	/**
		@hooked
			_structure_single::__the_post_link()
		@reference
			[Parent]/controller/structure/single.php
	*/
	?>
	<?php do_action(HOOK_POINT[$index]['footer']['before']); ?>

	<footer class="<?php echo apply_filters("_class[{$index}][article][footer]",esc_attr('entry-footer')); ?>"<?php echo apply_filters("_attribute[{$index}][article][footer]",''); ?>>
		<?php do_action(HOOK_POINT[$index]['footer']['prepend']); ?>
		<?php do_action(HOOK_POINT[$index]['footer']['main']); ?>
		<?php do_action(HOOK_POINT[$index]['footer']['append']); ?>
	</footer>

	<?php
	/**
		@hooked
			_structure_single::__the_comment()
		@reference
			[Parent]/controller/structure/single.php
	*/
	?>
	<?php do_action(HOOK_POINT[$index]['footer']['after']); ?>
</article>
