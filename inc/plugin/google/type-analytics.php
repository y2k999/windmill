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
<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject'] = r;i[r] = i[r] || function(){(i[r].q = i[r].q || []).push(arguments)},i[r].l = 1 * new Date(); a = s.createElement(o),m = s.getElementsByTagName(o)[0]; a.async = 1; a.src = g;m.parentNode.insertBefore(a,m)})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
	ga('create','<?php echo $ga_tracking_id; ?>','auto'<?php echo $ga_option; ?>);
	ga('send','pageview');
</script>
