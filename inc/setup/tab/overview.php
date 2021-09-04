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
 * 	Display admin tab content of documentations.
 * @reference
 * 	[Parent]/inc/setup/admin.php
*/
?>
<div class="tab-content">
	<table class="form-table">
		<tr>
			<td>
				<h4><span class="dashicons dashicons-format-standard"></span> <?php echo esc_html('Template Hierarchy'); ?></h4>
				<p><?php echo esc_html__('Windmill Theme folder contains a number of sub-folders. Below is a table of each folder and description.','windmill'); ?></p>
			</td>
		</tr>
	</table>

	<table class="form-table">

		<!-- asset/ -->
		<tr>
			<th>
				<p><span class="dashicons dashicons-portfolio"></span> <?php echo esc_html('asset/'); ?></p>
			</th>
			<td>
				<p><?php echo __('Stores custom <strong>CSS</strong>, <strong>LESS</strong> and <strong>Javascript</strong> files for the <a href ="https://www.getbeans.io/documentation/api/compiler/" target="_blank">Beans Compiler API</a> and <a href="https://wordpress.org/gutenberg/" target="_blank">Gutenberg</a> editor. The <strong>php</strong> codes that describes inline css are also stored here.','windmill'); ?></p>
				<p><?php echo __('Stores <strong>PO</strong> and <strong>MO</strong> files for translators to localize the theme.','windmill'); ?></p>
				<p><?php echo __('All image files that you use throughout a theme are kept in this directory.','windmill'); ?></p>
			</td>
		</tr>

		<!-- controller/ -->
		<tr>
			<th>
				<p><span class="dashicons dashicons-portfolio"></span> <?php echo esc_html('controller/'); ?></p>
			</th>
			<td>
				<p><?php echo esc_html__('The render files are where all aspects of the theme is rendered, from registering menus and widget areas to loading structural template and fragment files.','windmill'); ?></p>
			</td>
		</tr>

		<!-- inc/ -->
		<tr>
			<th>
				<p><span class="dashicons dashicons-portfolio"></span> <?php echo esc_html('inc/'); ?></p>
			</th>
			<td>
				<p><?php echo esc_html__('Contains all the utilities (tools) and functions used to build and enhance the Windmill theme environment.','windmill'); ?></p>
				<p><?php echo esc_html__('Theme Customizer settings and class autloader files are stored here.','windmill'); ?></p>
				<p><?php echo __('Also, includes third-party libraries, e.g. <a href="http://tgmpluginactivation.com/" target="_blank">TGM Plugin Activator</a>, <a href="https://analytics.google.com/analytics/web/provision/#/provision" target="_blank">Google analytics</a>, <a href="http://w-shadow.com/" target="_blank">Theme Update Checker</a>.','windmill'); ?></p>
			</td>
		</tr>

		<!-- model/ -->
		<tr>
			<th>
				<p><span class="dashicons dashicons-portfolio"></span> <?php echo esc_html('model/'); ?></p>
			</th>
			<td>
				<p><?php echo esc_html__('The application and widget files handle the theme content and are split into multiple functions (fragments). These components are attached to the structural hooks, making it easy to move them around, make changes or remove them completely.','windmill'); ?></p>
			</td>
		</tr>

		<!-- template/ -->
		<tr>
			<th>
				<p><span class="dashicons dashicons-portfolio"></span> <?php echo esc_html('template/'); ?></p>
			</th>
			<td>
				<p><?php echo esc_html__('Stores the structure files that handle the page structural markup (html, head, body etc.) and hooks.','windmill'); ?></p>
				<p><?php echo __('These files are often called by using WordPress template-tags, like <a href="https://developer.wordpress.org/reference/functions/get_header/" target="_blank">get_header()</a>, <a href="https://developer.wordpress.org/reference/functions/get_sidebar/" target="_blank">get_sidebar()</a>, <a href="https://developer.wordpress.org/reference/functions/get_footer/" target="_blank">get_footer()</a>.','windmill'); ?></p>
			</td>
		</tr>

		<!-- template-part/ -->
		<tr>
			<th>
				<p><span class="dashicons dashicons-portfolio"></span> <?php echo esc_html('template-part/'); ?></p>
			</th>
			<td>
				<p><?php echo __('Stores the partial files often called by using <a href="https://developer.wordpress.org/reference/functions/get_template_part/" target="_blank">get_template_part()</a> in WordPress, e.g. loop.php, navigation.php.','windmill'); ?></p>
			</td>
		</tr>

	</table>
</div><!-- .tab-content -->
