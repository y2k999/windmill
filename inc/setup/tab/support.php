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
 * 	Display admin tab content of document and support forum.
 * @reference
 * 	[Parent]/inc/setup/admin.php
*/
?>
<div class="tab-content">
	<table class="form-table">

		<tr>
			<td>
				<h4><span class="dashicons dashicons-format-standard"></span> <?php echo esc_html('Learn Beans Framework'); ?></h4>
				<p><?php echo esc_html__('Windmill is based on','windmill'); ?> <a href="https://www.getbeans.io/" target="_blank"><?php echo esc_html('the Beans WordPress Theme Framework'); ?></a></p>
				<p><?php echo esc_html__(' Browse the documention for the detailed information regarding the Beans.','windmill'); ?></p>
				<p><a href="<?php echo esc_url('https://www.getbeans.io/documentation/'); ?>" class="button button-primary" target="_blank"><?php echo esc_html('Beans Documentation'); ?></a></p>
			</td>
		</tr>

		<tr>
			<td>
				<h4><span class="dashicons dashicons-format-standard"></span> <?php echo esc_html('Learn Uikit3'); ?></h4>
				<p><?php echo esc_html__('Windmill is based on','windmill'); ?> <a href="https://getuikit.com/" target="_blank"><?php echo esc_html('the Uikit3 CSS Framework'); ?></a></p>
				<p><?php echo esc_html__('Browse the documention for the detailed information regarding the Uikit.','windmill'); ?></p>
				<p><a href="<?php echo esc_url('https://getuikit.com/docs/introduction'); ?>" class="button button-secondary" target="_blank"><?php echo esc_html('Uikit3 Documentation'); ?></a></p>
			</td>
		</tr>

		<tr>
			<td>
				<h4><span class="dashicons dashicons-format-standard"></span> <?php echo esc_html('Beans Support Forum'); ?></h4>
				<p><?php echo esc_html__('Get help setting up, using, and customising Beans.','windmill'); ?></p>
				<p><a href="<?php echo esc_url('https://community.getbeans.io/forum/support/'); ?>" class="button button-primary" target="_blank"><?php echo esc_html('Support Forum'); ?></a></p>
			</td>
		</tr>

		<tr>
			<td>
				<h4><span class="dashicons dashicons-format-standard"></span> <?php echo esc_html('The Unofficial Beans learning Site'); ?></h4>
				<p><?php echo esc_html__('The unofficial Beans learning site by Paal Joachim.','windmill'); ?></p>
				<p><a href="<?php echo esc_url('https://wpbeansframework.com/'); ?>" class="button button-secondary" target="_blank"><?php echo esc_html('Useful Resources'); ?></a></p>
			</td>
		</tr>

	</table>
</div><!-- .tab-content -->
