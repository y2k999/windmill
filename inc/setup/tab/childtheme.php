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
// $index = basename(__FILE__,'.php');

/**
 * @reference (WP)
 * 	Returns whether the current user has the specified capability.
 * 	https://developer.wordpress.org/reference/functions/current_user_can/
*/
if(!current_user_can('manage_options')){
	wp_die(__('You do not have sufficient permissions to access this page.','windmill'));
}


/* Exec
______________________________
*/
?>
<?php
/**
 * @since 1.0.1
 * 	Display admin tab content of child themes.
 * @reference
 * 	[Parent]/inc/setup/admin.php
 * 	[Parent]/inc/setup/constant.php
*/
?>
<div class="tab-content">
	<table class="form-table">

		<tr>
			<!-- bbs -->
			<td>
				<a href="<?php echo esc_url('https://github.com/y2k999/windmill-bbs'); ?>" target="_blank"><img style="width: 100%; height: auto; max-width: 360px; max-height: 240px;" src="<?php echo URI['image']; ?>windmill-bbs-min.jpg"></a>
				<p><a href="<?php echo esc_url('https://github.com/y2k999/windmill-bbs'); ?>" target="_blank"><?php echo esc_html('Windmill BBS'); ?></a></p>
			</td>
			<!-- blog -->
			<td>
				<a href="<?php echo esc_url('https://github.com/y2k999/windmill-blog'); ?>" target="_blank"><img style="width: 100%; height: auto; max-width: 360px; max-height: 240px;" src="<?php echo URI['image']; ?>windmill-blog-min.jpg"></a>
				<p><a href="<?php echo esc_url('https://github.com/y2k999/windmill-blog'); ?>" target="_blank"><?php echo esc_html('Windmill Blog'); ?></a></p>
			</td>
			<!-- form -->
			<td>
				<a href="<?php echo esc_url('https://github.com/y2k999/windmill-form'); ?>" target="_blank"><img style="width: 100%; height: auto; max-width: 360px; max-height: 240px;" src="<?php echo URI['image']; ?>windmill-form-min.jpg"></a>
				<p><a href="<?php echo esc_url('https://github.com/y2k999/windmill-form'); ?>" target="_blank"><?php echo esc_html('Windmill Form'); ?></a></p>
			</td>
		</tr>

		<tr>
			<!-- parallax -->
			<td>
				<a href="<?php echo esc_url('https://github.com/y2k999/windmill-parallax'); ?>" target="_blank"><img style="width: 100%; height: auto; max-width: 360px; max-height: 240px;" src="<?php echo URI['image']; ?>windmill-parallax-min.jpg"></a>
				<p><a href="<?php echo esc_url('https://github.com/y2k999/windmill-parallax'); ?>" target="_blank"><?php echo esc_html('Windmill Parallax'); ?></a></p>
			</td>
			<!-- portfolio -->
			<td>
				<a href="<?php echo esc_url('https://github.com/y2k999/windmill-portfolio'); ?>" target="_blank"><img style="width: 100%; height: auto; max-width: 360px; max-height: 240px;" src="<?php echo URI['image']; ?>windmill-portfolio-min.jpg"></a>
				<p><a href="<?php echo esc_url('https://github.com/y2k999/windmill-portfolio'); ?>" target="_blank"><?php echo esc_html('Windmill Portfolio'); ?></a></p>
			</td>
			<!-- shop -->
			<td>
				<a href="<?php echo esc_url('https://github.com/y2k999/windmill-shop'); ?>" target="_blank"><img style="width: 100%; height: auto; max-width: 360px; max-height: 240px;" src="<?php echo URI['image']; ?>windmill-shop-min.jpg"></a>
				<p><a href="<?php echo esc_url('https://github.com/y2k999/windmill-shop'); ?>" target="_blank"><?php echo esc_html('Windmill Shop'); ?></a></p>
			</td>
		</tr>

	</table>
</div><!-- .tab-content -->
