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
 * 
 * Inspired by yStandard WordPress Theme
 * @link https://wp-ystandard.com
 * @author yosiakatsuki
*/


/* Prepare
______________________________
*/

// If this file is called directly,abort.
if(!defined('WPINC')){die;}

// Set identifiers for this template.
// $index = basename(__FILE__,'.php');

/**
 * @since 1.0.1
 * 	Additional arguments passed to the template via get_template_part().
 * @reference (WP)
 * 	Merges user defined arguments into defaults array.
 * 	https://developer.wordpress.org/reference/functions/wp_parse_args/
*/
$args = wp_parse_args($args,array(
	'ga_tracking_id' => '',
	'ga_tracking_option' => '',
));


/* Exec
______________________________
*/
?>
<?php
/**
 * @since 1.0.1
 * 	Display google analytics.
 * @reference
 * 	[Parent]/inc/plugin/google/analytics.php
*/
if($args['ga_tracking_id'] === ''){return;}
$ga_tracking_id = $args['ga_tracking_id'];

$ga_option = '';
if($args['ga_tracking_option'] !== ''){
	$ga_option = ' ,' . $args['ga_tracking_option'];
}
?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $ga_tracking_id; ?>"></script>
<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js',new Date());
	gtag('config','<?php echo $ga_tracking_id; ?>'<?php echo $ga_option; ?>);
</script>
