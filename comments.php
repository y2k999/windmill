<?php 
/**
 * The template for displaying comments.
 * This is the template that displays the area of the page that contains both the current comments and the comment form.
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

/**
 * @reference (WP)
 * 	Whether post requires password and correct password has been provided.
 * 	https://developer.wordpress.org/reference/functions/post_password_required/
*/
if(post_password_required()){
	echo esc_html__('This post is password protected. Enter the password to view comments.','windmill');
	return;
}

// Set identifiers for this template.
$index = basename(__FILE__,'.php');


/* Exec
______________________________
*/
?>
<?php
/**
	@hooked
		_app_comments::__the_status();
		_app_comment:s:__the_number();
	@reference
		[Parent]/model/app/comments.php
		[Parent]/inc/setup/constant.php
*/
?>
<?php do_action(HOOK_POINT[$index]['prepend']); ?>

<ol class="<?php echo apply_filters("_class[{$index}][list]",esc_attr('uk-comment-list uk-padding-small')); ?>">
	<?php
	/**
	 * @reference (Uikit)
	 * 	https://getuikit.com/docs/comment
	 * @reference (WP)
	 * 	Displays a list of comments.
	 * 	https://developer.wordpress.org/reference/functions/wp_list_comments/
	*/
	wp_list_comments();
	?>
</ol><!-- .comment-list -->

<?php
/**
	@hooked
		_app_comments::__the_pagination();
	@reference
		[Parent]/model/app/comments.php
		[Parent]/inc/setup/constant.php
*/
?>
<?php do_action(HOOK_POINT[$index]['main']); ?>

<?php
/**
 * @reference (WP)
 * 	Outputs a complete commenting form for use within a template.
 * 	https://developer.wordpress.org/reference/functions/comment_form/
*/
comment_form();
?>

<?php do_action(HOOK_POINT[$index]['append']); ?>
