<?php 
/**
 * Set environmental configurations which enhance the theme by hooking into WordPress.
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


/* Exec
______________________________
*/
if(class_exists('_env_comments') === FALSE) :
class _env_comments
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_hook()
 * 	invoke_hook()
 * 	cleanup()
 * 	text()
 * 	pre_ping()
 * 	pre_approved()
 * 	wp_list_args()
 * 	get_callback()
 * 	comment_reply_link()
 * 	form_default_fields()
 * 	form_defaults()
 * 	form_field()
 * 	cancel_reply_link()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private $hook = array();

	/**
	 * Traits.
	*/
	use _trait_hook;
	use _trait_singleton;


	/* Constructor
	_________________________
	*/
	private function __construct()
	{
		/**
			@access (private)
				Class constructor.
				This is only called once, since the only way to instantiate this is with the get_instance() method in trait (singleton.php).
			@return (void)
			@reference
				[Parent]/inc/trait/singleton.php
				[Parent]/inc/utility/general.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);

		$this->cleanup();

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook($this->hook);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_hook()
	{
		/**
			@access (private)
				The collection of hooks that is being registered (that is, actions or filters).
			@return (array)
				_filter[_env_comments][hook]
			@reference
				[Parent]/inc/trait/hook.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		if(is_admin()){
			/**
			 * @reference (WP)
			 * 	Determines whether the current request is for an administrative interface page.
			 * 	https://developer.wordpress.org/reference/functions/is_admin/
			*/
			return apply_filters("_filter[{$class}][{$function}]",array());
		}
		else{
			return apply_filters("_filter[{$class}][{$function}]",$this->set_parameter_hook(array(
				// Filter
/*
				'comment_text' => array(
					'tag' => 'add_filter',
					'callback' => 'text'
				),
*/
				'pre_comment_approved' => array(
					'tag' => 'add_filter',
					'callback' => 'pre_approved'
				),
				'comments_open' => array(
					'tag' => 'add_filter',
					'callback' => 'pre_approved'
				),
				'wp_list_comments_args' => array(
					'tag' => 'add_filter',
					'callback' => 'wp_list_args'
				),
				'comment_form_default_fields' => array(
					'tag' => 'add_filter',
					'callback' => 'form_default_fields'
				),
				'comment_form_defaults' => array(
					'tag' => 'add_filter',
					'callback' => 'form_defaults'
				),
/*
				'comment_reply_link' => array(
					'tag' => 'add_filter',
					'callback' => 'comment_reply_link'
				),
*/
				// Action
				'pre_ping' => array(
					'tag' => 'add_action',
					'callback' => 'pre_ping'
				),
				// Filters the content of the comment textarea field for display.
				'comment_form_field_comment'	 => array(
					'tag' => 'add_action',
					'callback' => 'form_field'
				),
				// Filters the cancel comment reply link HTML.
				'cancel_comment_reply_link' => array(
					'tag' => 'add_action',
					'callback' => 'cancel_reply_link',
					'args' => 3
				),
			)));
		}

	}// Method


	/* Method
	_________________________
	*/
	private function cleanup()
	{
		/**
			@access (private)
				Filters the text of a comment to be displayed.
				https://developer.wordpress.org/reference/hooks/comment_text/
				comment_form_logged_in
				https://developer.wordpress.org/reference/hooks/comment_form_logged_in/
			@return (void)
		*/

		/**
		 * @reference (WP)
		 * 	Replaces common plain text characters with formatted entities.
		 * 	https://developer.wordpress.org/reference/functions/wptexturize/
		*/
		add_filter('comment_text','wptexturize');

		/**
		 * @reference (WP)
		 * 	Converts lone & characters into &#038; (a.k.a. &amp;)
		 * 	https://developer.wordpress.org/reference/functions/convert_chars/
		*/
		add_filter('comment_text','convert_chars');

		/**
		 * @reference (WP)
		 * 	Converts URI, www and ftp, and email addresses. Finishes by fixing links within links.
		 * 	https://developer.wordpress.org/reference/functions/make_clickable/
		*/
		add_filter('comment_text','make_clickable',9);

		/**
		 * @reference (WP)
		 * 	Balances tags of string using a modified stack.
		 * 	https://developer.wordpress.org/reference/functions/force_balance_tags/
		*/
		add_filter('comment_text','force_balance_tags',25);

		/**
		 * @reference (WP)
		 * 	Convert text equivalent of smilies to images.
		 * 	https://developer.wordpress.org/reference/functions/convert_smilies/
		*/
		add_filter('comment_text','convert_smilies',20);

		/**
		 * @reference (WP)
		 * 	Replaces double line breaks with paragraph elements.
		 * 	https://developer.wordpress.org/reference/functions/wpautop/
		*/
		add_filter('comment_text','wpautop',30);

		/**
		 * @reference (WP)
		 * 	Returns an empty string.
		 * 	https://developer.wordpress.org/reference/functions/__return_empty_string/
		*/
		add_filter('comment_form_logged_in','__return_empty_string');

	}// Method


	/* Hook
	_________________________
	*/
	public function text($comment_content)
	{
		/**
			@access (public)
				Retrieves the comment type of the current comment.
				https://developer.wordpress.org/reference/functions/get_comment_type/
			@param (WP_Comment)|(null) $comment_content
				The comment object.
				Null if not found.
			@return (WP_Comment)|(null)
		*/
		if(get_comment_type() === 'comment'){
			/**
			 * @reference (PHP)
			 * 	Convert special characters to HTML entities
			 * 	https://www.php.net/manual/en/function.htmlspecialchars.php
			 * 	Will convert both double and single quotes.
			*/
			$comment_content = htmlspecialchars($comment_content,ENT_QUOTES);
		}
		return $comment_content;

	}// Method


	/* Hook
	_________________________
	*/
	public function pre_ping(&$links)
	{
		/**
			@access (public)
				Fires just before pinging back links found in a post.
				https://developer.wordpress.org/reference/hooks/pre_ping/
			@param (string[]) &$links
				Array of link URLs to be checked (passed by reference).
			@return (void)
		*/

		/**
		 * @reference (WP)
		 * 	Retrieves the URL for the current site where the front end is accessible.
		 * 	https://developer.wordpress.org/reference/functions/home_url/
		*/
		$home = home_url();
		foreach($links as $l => $link){
			if(0 === strpos($link,$home)){
				unset($links[$l]);
			}
		}

	}// Method


	/* Hook
	_________________________
	*/
	public function pre_approved($data)
	{
		/**
			@access (public)
				Filters a comment’s approval status before it is set.
				https://developer.wordpress.org/reference/hooks/pre_comment_approved/
			@global (array) $allowedtags
				https://codex.wordpress.org/Global_Variables
			@param (array) $data
				Comment data.
			@return (int)|(string)|(WP_Error)
				The approval status.
				Accepts 1, 0, 'spam', 'trash', or WP_Error.
			@reference
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// WP global.
		global $allowedtags;

		$tags = array(
			'a',
			'abbr',
			'acronym',
			'b',
			'div',
			'cite',
			'code',
			'del',
			'em',
			// 'i',
			'q',
			'strike',
			'strong',
			'blockquote',
			's',
		);
		$tags = apply_filters("_filter[{$class}][{$function}]",$tags);

		foreach($tags as $item){
			unset($allowedtags[$item]);
		}
		return $data;

	}// Method


	/* Hook
	_________________________
	*/
	public function wp_list_args($r)
	{
		/**
			@access (public)
				Filters the arguments used in retrieving the comment list.
				https://developer.wordpress.org/reference/hooks/wp_list_comments_args/
			@param (array) $r
				An array of arguments for displaying comments.
			@return (array)
				_filter[_env_comments][wp_list_args]
			@reference
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$avatar_size = __utility_get_image_size('avatar');
		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",wp_parse_args(array(
			'style' => 'ol',
			'short_ping' => TRUE,
			//'per_page' => 3,
			'avatar_size' => $avatar_size['width'],
			'reverse_top_level' => TRUE,
			'callback' => [$this,'get_callback'],
			'echo' => TRUE,
		),$r));

	}// Method


	/* Method
	_________________________
	*/
	public function get_callback($comment,$args,$depth)
	{
		/**
			@access (public)
				Callback function to use.
				https://developer.wordpress.org/reference/functions/wp_list_comments/
			@param (WP_Comment[]) $comment
				https://codex.wordpress.org/Global_Variables
			@param (array) $args
				Formatting options.
			@param (int) $depth
				Comments depth.
			@return (void)
			@reference
				[Parent]/inc/utility/theme.php
		*/
		$class = self::$_class;

		$GLOBALS['comment'] = $comment;
		extract($args,EXTR_SKIP);

		// Render the opening <li> tag.
		$comment_class = empty($args['has_children']) ? '' : 'parent';
		printf(
			'<li id="comment-%d" %s>',
			/**
			 * @reference (WP)
			 * 	Retrieves the comment ID of the current comment.
			 * 	https://developer.wordpress.org/reference/functions/get_comment_id/
			 * 	Generates semantic classes for each comment element.
			 * 	https://developer.wordpress.org/reference/functions/comment_class/
			*/
			(int)get_comment_ID(),
			comment_class($comment_class,$comment,NULL,FALSE)
		);

			/**
			 * @reference (Beans)
			 * 	HTML markup.
			 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
			 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
			 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
			 * 
			 * @reference (Uikit)
			 * 	https://getuikit.com/docs/comment
			*/
			beans_open_markup_e("_wrapper[{$class}][article]",'article',array(
				/* Automatically escaped. */
				'id' => 'div-comment-' . get_comment_ID(),
				'class' => 'uk-comment uk-flex',
				'itemprop' => 'comment',
				'itemscope' => 'itemscope',
				'itemtype' => 'https://schema.org/UserComments',
			));
				// Comment Header
				beans_open_markup_e("_wrapper[{$class}][header]",'header',array(
					'class' => 'uk-comment-header uk-padding-small uk-padding-remove-bottom',
				));
					beans_open_markup_e("_wrapper[{$class}][author]",'div',array(
						'class' => 'uk-comment-title uk-text-small uk-clearfix'
					));
						if(get_option('show_avatars') == 1){
							if($args['avatar_size'] != 0){
								/* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped -- Echoes get_avatar(). */
								beans_open_markup_e("_wrapper[{$class}][avatar]",'div',array('class' => 'uk-comment-avatar'));
									/**
									 * @reference (WP)
									 * 	Retrieve the avatar <img> tag for a user, email address, MD5 hash, comment, or post.
									 * 	https://developer.wordpress.org/reference/functions/get_avatar/
									*/
									echo get_avatar($comment,$args['avatar_size'],'',NULL,array('class' => 'uk-border-circle'));
								beans_close_markup_e("_wrapper[{$class}][avatar]",'div');
							}
						}

						/**
						 * @reference (WP)
						 * 	Retrieves the HTML link to the URL of the author of the current comment.
						 * 	https://developer.wordpress.org/reference/functions/get_comment_author_link/
						*/
						printf('<cite class="fn" itemprop="creator name">%s</cite>',get_comment_author_link($comment));

						if($comment->comment_approved == '0'){
							beans_open_markup_e("_label[{$class}][author]",'span',array('class' => 'comment-awaiting-moderation'));
								beans_output_e("_output[{$class}][author]",__('Your Comment is Awaiting Moderation.','windmill'));
							beans_close_markup_e("_label[{$class}][author]",'span');
						}

						beans_open_markup_e("_wrapper[{$class}][meta]",'div',array(
							'class' => 'uk-comment-meta commentmetadata'
						));
							beans_open_markup_e("_link[{$class}][meta]",'a',array(
								/**
								 * @reference (WP)
								 * 	Retrieves the link to a given comment.
								 * 	https://developer.wordpress.org/reference/functions/get_comment_link/
								*/
								'href' => htmlspecialchars(get_comment_link($comment->comment_ID)),
								'itemprop' => 'commentTime',
							));
								printf(
									/* translators: 1: date, 2: time */
									'%1$s at %2$s',
									/**
									 * @reference (WP)
									 * 	Retrieves the comment date of the current comment.
									 * 	https://developer.wordpress.org/reference/functions/get_comment_date/
									 * 	Retrieves the comment time of the current comment.
									 * 	https://developer.wordpress.org/reference/functions/get_comment_time/
									*/
									get_comment_date(),
									get_comment_time()
								);
							beans_close_markup_e("_link[{$class}][meta]",'a');
							// edit_comment_link(__('Edit','windmill'),'  ','');
						beans_close_markup_e("_wrapper[{$class}][meta]",'div');
					beans_close_markup_e("_wrapper[{$class}][author]",'div');
				beans_close_markup_e("_wrapper[{$class}][header]",'header');

				// Comment Body
				beans_open_markup_e("_wrapper[{$class}][body]",'div',array(
					'class' => 'uk-comment-body uk-padding-small uk-padding-remove-bottom',
					'itemprop' => 'commentText',
				));
					/**
					 * @reference (WP)
					 * 	Displays the text of the current comment.
					 * 	https://developer.wordpress.org/reference/functions/comment_text/
					*/
					comment_text();

					/**
					 * @reference (WP)
					 * 	Retrieves HTML content for reply to comment link.
					 * 	https://developer.wordpress.org/reference/functions/get_comment_reply_link/
					*/
					$reply = get_comment_reply_link(array_merge($args,array('depth' => $depth,'max_depth' => $args['max_depth'])));
					if($reply != ''){
						beans_open_markup_e("_wrapper[{$class}][reply]",'div',array(
							'class' => 'uk-margin-right uk-float-right reply',
							'itemprop' => 'replyToUrl',
						));
							beans_output_e("_output[{$class}][reply]",$reply);
						beans_close_markup_e("_wrapper[{$class}][reply]",'div');
					}

				beans_close_markup_e("_wrapper[{$class}][body]",'div');
			beans_close_markup_e("_wrapper[{$class}][article]",'article');

	}// Method


	/* Hook
	_________________________
	*/
	public function comment_reply_link($link)
	{
		/**
			@access (public)
				Filters the comment reply link.
				https://developer.wordpress.org/reference/hooks/comment_reply_link/
			@param (string) $link
				The HTML markup for the comment reply link.
			@param (array) $args
				An array of arguments overriding the defaults.
			@param (WP_Comment) $comment
				The object of the comment being replied.
			@param (WP_Post) $post
				The WP_Post object.
			@reference
				https://wordpress.stackexchange.com/questions/12767/add-class-to-reply-button-in-comments-area
		*/
		$link = str_replace("class='comment-reply-link","class='uk-button uk-button-secondary uk-button-small reply",$link);
		return $link;

	}// Method


	/* Hook
	_________________________
	*/
	public function form_default_fields($fields)
	{
		/**
			@access (public)
				Filters the default comment form fields.
				https://developer.wordpress.org/reference/hooks/comment_form_default_fields/
			@param (array) $fields
				Array with main fields for comment form
			@return (array)
				Filter for main fields
		*/
		// Remove the email field
		unset($fields['email']);

		// Remove the url field
		unset($fields['url']);

		return $fields;

	}// Method


	/* Hook
	_________________________
	*/
	public function form_defaults($defaults)
	{
		/**
			@access (public)
				Filters the comment form default arguments.
				https://developer.wordpress.org/reference/hooks/comment_form_defaults/
			@param (array) $defaults
				The default comment form arguments.
			@return (array)
				_filter[_env_comment][form_defaults]
			@reference (Uikit)
				https://getuikit.com/docs/button
				https://getuikit.com/docs/form
				https://getuikit.com/docs/width
			@reference
				[Parent]/inc/customizer/option.php
				[Parent]/inc/utility/general.php
				[Parent]/inc/utility/theme.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// Hide the default text before the form
		$defaults['comment_notes_before'] = '';

		// Hide the default text after the form
		$defaults['comment_notes_after'] = '';

		$defaults['id_form'] = 'comment-form';
		$defaults['id_submit'] = 'comment-submit';

		$defaults['class_form'] = 'uk-form uk-padding comment-form';
		// $defaults['class_container'] = 'uk-text-center comment-respond';
		$defaults['class_submit'] = 'uk-button uk-button-primary uk-margin-small-top uk-width-1-1 submit ' . __utility_get_option('skin_button_tertiary');

		$defaults['title_reply_before'] = '<div id="reply-title" class="comment-reply-title uk-text-center">';
		$defaults['title_reply_after'] = '</div>';
		$defaults['submit_field'] = '<div class="comment-form-submit">%1$s %2$s</div>';

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",$defaults);

	}// Method


	/* Hook
	_________________________
	*/
	public function form_field()
	{
		/**
			@access (public)
				Filters the content of the comment textarea field for display.
				This function replaces the default WordPress comment textarea field.
				https://developer.wordpress.org/reference/hooks/comment_form_field_comment/
			@return (string)
			@reference (Uikit)
				https://getuikit.com/docs/form
			@reference
				[Parent]/inc/utility/general.php
				[Parent]/inc/utility/theme.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup/
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup/
		*/
		$html = beans_open_markup("_textarea[{$class}][{$function}]",'textarea',array(
			'id' => 'comment',
			'class' => 'uk-textarea uk-width-1-1',
			'name' => 'comment',
			'aria-required' => 'true',
			'aria-label' => esc_html__('Comment Form','windmill'),
			// 'cols' => '',
			'rows' => 10,
		));
		$html .= beans_close_markup("_textarea[{$class}][{$function}]",'textarea');

		return $html;

	}// Method


	/* Hook
	_________________________
	*/
	public function cancel_reply_link($formatted_link,$link,$text)
	{
		/**
			@access (public)
				Filters the cancel comment reply link HTML.
				This function replaces the default WordPress comment cancel reply link.
				https://developer.wordpress.org/reference/hooks/cancel_comment_reply_link/
			@param (string) $html
				HTML.
			@param (string) $link
				Cancel reply link.
			@param (string) $text
				Text to output.
			@return (string)
			@reference (Uikit)
				https://getuikit.com/docs/button
			@reference
				[Parent]/inc/utility/general.php
				[Parent]/inc/utility/theme.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup/
		 * 	https://www.getbeans.io/code-reference/functions/beans_output/
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup/
		*/
		$formatted_link = beans_open_markup("_link[$class][{$function}]",'a',array(
			'id' => 'cancel-comment-reply-link',
			'class' => 'uk-button uk-button-small uk-button-danger uk-paddin-small uk-margin-left',
			/* phpcs:ignore WordPress.CSRF.NonceVerification.NoNonceVerification -- Used to determine inline style. */
			'style' => isset($_GET['replytocom']) ? '' : 'display: none;',
			/* Automatically escaped. */
			'href' => $link,
		));
		$formatted_link .= beans_output("_output[$class][{$function}]",$text);
		$formatted_link .= beans_close_markup("_link[$class][{$function}]",'a');

		return $formatted_link;

	}// Method


}// Class
endif;
// new _env_comments();
_env_comments::__get_instance();
