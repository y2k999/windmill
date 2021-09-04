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
 * 	Display admin tab content of theme customizer.
 * @reference
 * 	[Parent]/inc/setup/admin.php
*/
?>
<div class="tab-content">

	<table class="form-table">
		<tr>
			<td>
				<h4><span class="dashicons dashicons-format-standard"></span> <?php echo esc_html('Theme Customizer'); ?></h4>
				<p><?php echo esc_html__('After activating recommended plugins , now you can start customization.','windmill'); ?></p>
				<p><?php echo esc_html__('Main theme options are available via theme customizer screen.','windmill'); ?></p>
				<p>
					<ol>
							<li><strong><?php echo esc_html('Basis Section  '); ?></strong><?php echo esc_html__('jQuery version, Google Fonts.','windmill'); ?></li>
							<li><strong><?php echo esc_html('Template Section  '); ?></strong><?php echo esc_html__('Header template, Sidebar template, Footer template, Content template.','windmill'); ?></li>
							<li><strong><?php echo esc_html('SEO Section  '); ?></strong><?php echo esc_html__('Post meta, Sectioning tags, Google Analytic Code.','windmill'); ?></li>
							<li><strong><?php echo esc_html('SNS Section  '); ?></strong><?php echo esc_html__('SNS share and SNS follow.','windmill'); ?></li>
							<li><strong><?php echo esc_html('Design Section  '); ?></strong><?php echo esc_html__('Design styles and effects.','windmill'); ?></li>
					</ol>
				</p>
				<p><a href="<?php echo admin_url('customize.php'); ?>" class="button button-secondary"><?php echo esc_html('Start Customize'); ?></a></p>
			</td>
		</tr>
	</table>

	<table class="form-table">
		<tr>
			<td>
				<h4><span class="dashicons dashicons-format-standard"></span> <?php echo esc_html('Install Plugins'); ?></h4>
				<p><?php echo esc_html__('To take full advanctage of the theme features, it is recommended to install ','windmill') . '<a href="https://wordpress.org/plugins/" target="_blank">' . esc_html('Useful Plugins') . '</a>.'; ?></p>
			</td>
		</tr>
		<!-- AMP -->
		<tr>
			<td>
				<p><span class="dashicons dashicons-wordpress"></span> <?php echo esc_html__('If you need AMP page, it is recommended to install ','windmill') . '<a href="https://wordpress.org/plugins/amp/" target="_blank">' . esc_html('AMP Plugin for WordPress') . '</a>.'; ?></p>
			</td>
			<td>
				<p><a href="?page=tgmpa-install-plugins" class="button button-primary"><?php echo esc_html('Recommended Plugins'); ?></a></p>
			</td>
		</tr>
		<!-- Loco -->
		<tr>
			<td>
				<p><span class="dashicons dashicons-businessperson"></span> <?php echo esc_html__('If you need localization, it is recommended to install ','windmill') . '<a href="https://wordpress.org/plugins/loco-translate/" target="_blank">' . esc_html('Loco Translate') . '</a>.'; ?></p>
			</td>
			<td>
				<p><a href="?page=tgmpa-install-plugins" class="button button-primary"><?php echo esc_html('Recommended Plugins'); ?></a></p>
			</td>
		</tr>
		<!-- Lead Form -->
		<tr>
			<td>
				<p><span class="dashicons dashicons-button"></span> <?php echo esc_html__('If you activate Windmill Parallax Child Theme, it is recommended to install ','windmill') . '<a href="https://wordpress.org/plugins/lead-form-builder/" target="_blank">' . esc_html('Lead Form Builder') . '</a>.'; ?></p>

			</td>
			<td>
				<p><a href="?page=tgmpa-install-plugins" class="button button-primary"><?php echo esc_html('Recommended Plugins'); ?></a></p>
			</td>
		</tr>
		<!-- Woo Commerce -->
		<tr>
			<td>
				<p><span class="dashicons dashicons-cart"></span> <?php echo esc_html__('If you activate Windmill Shop Child Theme, it is recommended to install ','windmill') . '<a href="https://wordpress.org/plugins/woocommerce/" target="_blank">' . esc_html('WooCommerce') . '</a>.'; ?></p>
			</td>
			<td>
				<p><a href="?page=tgmpa-install-plugins" class="button button-primary"><?php echo esc_html('Recommended Plugins'); ?></a></p>
			</td>
		</tr>
		<!-- bbPress -->
		<tr>
			<td>
				<p><span class="dashicons dashicons-buddicons-bbpress-logo"></span> <?php echo esc_html__('If you activate Windmill BBS Child Theme, it is recommended to install ','windmill') . '<a href="https://wordpress.org/plugins/bbpress/" target="_blank">' . esc_html('bbPress') . '</a>.'; ?></p>
			</td>
			<td>
				<p><a href="?page=tgmpa-install-plugins" class="button button-primary"><?php echo esc_html('Recommended Plugins'); ?></a></p>
			</td>
		</tr>
	</table>

</div><!-- .tab-content -->
