<?php
/**
 * Template Name: HTML Sitemap Template
 *
 * This is the template that displays HTML Sitemap Page.
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
 * 
 * Inspired by Celtis Speedy WordPress Theme
 * @link https://celtislab.net/wordpress-theme-celtis-speedy/
 * @author enomoto@celtislab
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
			<article id="post-<?php the_ID(); ?>" <?php post_class('html-sitemap'); ?>>

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
					<div>
						<div class="uk-margin-medium-top uk-text-center widget-title">
							<?php echo esc_html__('Static Pages','windmill'); ?>
						</div>
						<ul class="uk-list uk-list-hyphen uk-padding">
							<?php wp_list_pages('title_li='); ?>
						</ul>
					</div>

					<div>
						<div class="uk-margin-medium-top uk-text-center widget-title">
							<?php echo esc_html__('Categories','windmill'); ?>
						</div>
						<ul class="uk-list uk-list-hyphen uk-padding">
							<?php
							$args = array(
								'orderby' => 'name',
								'order' => 'ASC'
							);
							$categories = get_categories($args);
							foreach($categories as $category) :
								?>
								<li class="uk-padding-small">
								<a href="<?php echo get_category_link($category->term_id); ?>" ><h6><?php echo $category->name; ?></h6></a>
								<ul class="uk-list uk-list-circle">
									<?php
									$posts = get_posts(array(
										'post_type' => 'post',
										'category' => $category->term_id,
										'numberposts' => -1,
										'post_status' => 'publish',
										'has_password' => FALSE
									));
									foreach($posts as $post){
										?><li class="uk-padding-small"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a></li><?php
									}
									?>
								</ul>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>

				</div><!-- .entry-content -->

			</article>
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
