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
$index = str_replace(substr(basename(__FILE__,'.php'),0,8),'',basename(__FILE__,'.php'));


/* Exec
______________________________
*/
?>
<?php
/**
 * @since 1.0.1
 * 	Echo nopost content.
 * @reference
 * 	[Parent]/inc/setup/constant.php
 * 	[Parent]/model/data/css.php
 * 	[Parent]/model/data/schema.php
 * 	[Parent]/template/content/404.php
*/
?>
<!-- ====================
	<article>
 ==================== -->
<?php
/**
 * @reference (WP)
 * 	Displays the classes for the post container element.
 * 	https://developer.wordpress.org/reference/functions/post_class/
*/
?>
<section <?php post_class('no-results not-found'); ?>>

	<!-- =============== 
		<entry-header>
	 =============== -->
	<?php do_action(HOOK_POINT[$index]['header']['before']); ?>

	<header class="<?php echo apply_filters("_class[{$index}][article][header]",esc_attr('entry-header')); ?>"<?php echo apply_filters("_attribute[{$index}][article][header]",''); ?>>
		<?php do_action(HOOK_POINT[$index]['header']['prepend']); ?>
		<?php
		/**
			@hooked
				_fragment_title::__the_archive()
			@reference
				[Parent]/controller/fragment/title.php
		*/
		?>
		<?php do_action(HOOK_POINT[$index]['header']['main']); ?>
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
		 * @reference (WP)
		 * 	Determines whether the query is for the blog homepage.
		 * 	https://developer.wordpress.org/reference/functions/is_home/
		 * 	Returns whether the current user has the specified capability.
		 * 	https://developer.wordpress.org/reference/functions/current_user_can/
		*/
		if(is_home() && current_user_can('publish_posts')){
			/**
			 * @reference (WP)
			 * 	Filters text content and strips out disallowed HTML.
			 * 	https://developer.wordpress.org/reference/functions/wp_kses/
			 * 	Retrieves the URL to the admin area for the current site.
			 * 	https://developer.wordpress.org/reference/functions/admin_url/
			*/
			printf('<p>' . wp_kses(
				/* translators: 1: Link to WP admin new post page. */
				apply_filters("_output[content][{$index}][is_home]",__('Ready to publish your first post? <a href="%1$s">Get started here</a>.','windmill')),
				array(
					'a' => array(
						'href' => array(),
					),
				)) . '</p>',esc_url(admin_url('post-new.php'))
			);

		/**
		 * @reference (WP)
		 * 	Determines whether the query is for a search.
		 * 	https://developer.wordpress.org/reference/functions/is_search/
		 * 	Display search form.
		 * 	https://developer.wordpress.org/reference/functions/get_search_form/
		*/
		}
		elseif(is_search()){
			echo apply_filters("_output[content][{$index}][is_search]",__('Sorry, but nothing matched your search terms. Please try again with some different keywords.','windmill'))
			get_search_form();
		}
		else{
			echo apply_filters("_output[content][{$index}][general]",__('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.','windmill'))
			get_search_form();
		}
		?>
		<?php do_action(HOOK_POINT[$index]['body']['main']); ?>
		<?php do_action(HOOK_POINT[$index]['body']['append']); ?>
	</div><!-- .entry-content -->

	<?php do_action(HOOK_POINT[$index]['body']['after']); ?>

	<!-- =============== 
		<entry-footer>
	=============== -->
	<?php do_action(HOOK_POINT[$index]['footer']['before']); ?>

	<footer class="<?php echo apply_filters("_class[{$index}][article][footer]",esc_attr('entry-footer')); ?>"<?php echo apply_filters("_attribute[{$index}][article][footer]",''); ?>>
		<?php do_action(HOOK_POINT[$index]['footer']['prepend']); ?>
		<?php do_action(HOOK_POINT[$index]['footer']['main']); ?>
		<?php do_action(HOOK_POINT[$index]['footer']['append']); ?>
	</footer>

	<?php do_action(HOOK_POINT[$index]['footer']['after']); ?>
</section>
