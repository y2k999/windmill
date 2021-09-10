<?php
/**
 * Child class that extends _widget_base (parrent class).
 * @link https://codex.wordpress.org/Widgets_API
 * @package Windmill
 * @license GPL3.0+
 * @since 1.0.1
*/

/**
 * Inspired by Core class used to implement WP_Widget.
 * @link https://codex.wordpress.org/Widgets_API
 * @see WP_Widget
 * 
 * Inspired by Magazine Plus WordPress theme.
 * @link https://wenthemes.com/item/wordpress-themes/magazine-plus/
 * @see WEN Themes
 * 
 * Inspired by Eggnews WordPress theme.
 * @link https://themeegg.com/themes/eggnews/
 * @see ThemeEgg
 * 
 * Inspired by Godios WordPress theme.
 * @link https://godios.simmon.design/
 * @see Simmon
*/


/* Prepare
______________________________
*/

// If this file is called directly,abort.
if(!defined('WPINC')){die;}

// Set identifiers for this template.
// $index = basename(__FILE__,'.php');


	beans_add_smart_action('widgets_init','__register_widget_profile');
	/**
	 * @reference (Beans)
	 * 	Set beans_add_action() using the callback argument as the action ID.
	 * 	https://www.getbeans.io/code-reference/functions/beans_add_smart_action/
	 * @reference (WP)
	 * 	Fires after all default WordPress widgets have been registered.
	 * 	https://developer.wordpress.org/reference/hooks/widgets_init/
	*/
	if(function_exists('__register_widget_profile') === FALSE) :
	function __register_widget_profile()
	{
		/**
		 * @reference (WP)
		 * 	Register Widget
		 * 	https://developer.wordpress.org/reference/functions/register_widget/
		*/
		register_widget('_widget_profile');

	}// Method
	endif;


/* Exec
______________________________
*/
if(class_exists('_widget_profile') === FALSE) :
class _widget_profile extends _widget_base
{
/**
 * [TOC]
 * 	__construct()
 * 	set_user_id()
 * 	set_field()
 * 	widget()
 * 		get_param()
 * 		the_image()
 * 		the_name()
 * 		the_message()
 * 		the_icon()
 * 	form()
 * 	update()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (int) $user_id
			Author/user id of the post.
	*/
	private static $_class = '';
	private static $_index = '';
	private $user_id = 1;

	/**
	 * Traits.
	*/
	use _trait_theme;


	/* Constructor
	_________________________
	*/
	public function __construct()
	{
		/**
			@access (public)
				Sets up a new widget instance.
			@return (void)
			@reference
				[Parent]/inc/utility/general.php
				[Parent]/model/widget/base.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);

		$this->user_id = __utility_get_user_id();

		$widget_options = array(
			'classname' => 'widget' . self::$_class,
			'description' => '[Windmill]' . ' ' . ucfirst(self::$_index),
			'customize_selective_refresh' => TRUE,
		);

		parent::__construct(
			self::$_index,
			ucfirst(self::$_index),
			$widget_options,
			array(),
			$this->set_field()
		);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_field()
	{
		/**
			@access (private)
				Helper function that holds widget fields.
				Array is used in update and form functions.
			@return (array)
				_filter[_widget_profile][field]
			@reference
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'title' => array(
				'label' => esc_html__('Title','windmill'),
				'type' => 'text',
				'default' => esc_html__('Author Profile','windmill'),
			),
			/**
			 * @reference (WP)
			 * 	Retrieves the requested data of the author of the current post.
			 * 	https://developer.wordpress.org/reference/functions/get_the_author_meta/
			*/
			'name' => array(
				'label' => esc_html__('Author Name','windmill'),
				'type' => 'text',
				'default' => get_the_author_meta('display_name',$this->user_id),
			),
			'message' => array(
				'label' => esc_html__('Author Profile','windmill'),
				'type' => 'textarea',
				'default' => get_the_author_meta('description',$this->user_id),
			),
			/**
			 * @reference (WP)
			 * 	Retrieve the avatar <img> tag for a user, email address, MD5 hash, comment, or post.
			 * 	https://developer.wordpress.org/reference/functions/get_avatar/
			*/
			'image' => array(
				'label' => esc_html__('Author Avatar','windmill'),
				'type' => 'image',
				'default' => get_avatar(get_the_author_meta('ID',$this->user_id),96,'',NULL,array('class' => 'uk-border-circle')),
			),
		));

	}// Method


	/* Method
	_________________________
	*/
	public function widget($args,$instance)
	{
		/**
			@access (public)
				Echoes the widget content.
			@param (array) $args
				Display arguments including 'before_title', 'after_title','before_widget', and 'after_widget'.
			@param (object) $instance
				The settings for the particular instance of the widget.
			@return (void)
			@reference
				[Parent]/controller/widget.php
				[Parent]/controller/fragment/widget.php
				[Parent]/controller/structure/sidebar.php
				[Parent]/template/sidebar/sidebar.php
		*/
		$class = self::$_class;

		/**
		 * @since 1.0.1
		 * 	Get the widget parameters via parent class (_widget_base) method.
		 * @reference
		 * 	[Parent]/model/widget/base.php
		*/
		$param = $this->get_param($instance);

		/**
		 * @since 1.0.1
		 * 	echo $args['before_widget'];
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_section[{$class}]",'div',array('class' => self::$_index));

			/**
			 * @since 1.0.1
			 * 	echo $args['before_title'] . $param['title'] . $args['after_title'];
			 * @reference
			 * 	This filter is documented in wp-includes/widgets/class-wp-widget-pages.php
			*/
			if(!empty($param['title'])){
				self::__the_title($param['title']);
			}

			/**
				@since 1.0.1
					widget content.
				@reference (Uikit)
					https://getuikit.com/docs/card
			*/
			beans_open_markup_e("_wrapper[{$class}]",'div',array('class' => 'uk-card'));

				beans_open_markup_e("_header[{$class}]",'header',array('class' => 'uk-card-header uk-padding-remove-top'));
					beans_open_markup_e("_grid[{$class}]",'div',array(
						'class' => 'uk-grid-small uk-flex-middle',
						'uk-grid' => '',
					));
						// Avatar
						beans_open_markup_e("_column[{$class}]",'div',array('class' => 'uk-width-auto'));
							$this->the_image($param['image']);
						beans_close_markup_e("_column[{$class}]",'div');

						// Name
						beans_open_markup_e("_column[{$class}]",'div',array('class' => 'uk-width-auto'));
							$this->the_name($param['name']);
							beans_open_markup_e("_paragraph[{$class}]",__utility_get_option('tag_site-description'),array('class' => 'uk-text-meta uk-padding-remove-top'));
								echo esc_html('Lead Designer');
							beans_close_markup_e("_paragraph[{$class}]",__utility_get_option('tag_site-description'));
						beans_close_markup_e("_column[{$class}]",'div');

					beans_close_markup_e("_grid[{$class}]",'div');
				beans_close_markup_e("_header[{$class}]",'header');

				// Description
				beans_open_markup_e("_body[{$class}]",'div',array('class' => 'uk-card-body uk-padding-remove-top'));
					$this->the_message($param['message']);
				beans_close_markup_e("_body[{$class}]",'div');

				// SNS follow
				beans_open_markup_e("_footer[{$class}]",'footer',array('class' => 'uk-card-footer uk-padding-remove-top'));
					$this->the_icon();
				beans_close_markup_e("_footer[{$class}]",'footer');

			beans_close_markup_e("_wrapper[{$class}]",'div');

		/**
		 * @since 1.0.1
		 * 	echo $args['after_widget'];
		*/
		beans_close_markup_e("_section[{$class}]",'div');

	}// Method


	/**
		@access (private)
		@param (string) $image
			Author avatar.
		@return (void)
		@reference
			[Parent]/inc/customizer/option.php
			[Parent]/inc/utility/general.php
	*/
	private function the_image($image)
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_link[{$class}][{$function}]",'a',array(
			/**
			 * @reference (Uikit)
			 * 	https://getuikit.com/docs/utility
			 * @reference (WP)
			 * 	Retrieve the URL to the author page for the user with the ID provided.
			 * 	https://developer.wordpress.org/reference/functions/get_author_posts_url/
			 * 	Retrieves the requested data of the author of the current post.
			 * 	https://developer.wordpress.org/reference/functions/get_the_author_meta/
			*/
			'href' => get_author_posts_url(get_the_author_meta('ID',$this->user_id)),
			'aria-label' => esc_attr__('Author Avatar','windmill'),
			'rel' => 'author',
			'itemprop' => 'url',
		));
			// beans_open_markup_e("_figure[{$class}][{$function}]",'figure',array('class' => 'uk-border-circle'));
				if($image){
					beans_output_e("_src[{$class}][{$function}]",$image);
				}
				else{
					beans_output_e("_src[{$class}][{$function}]",get_avatar(get_the_author_meta('ID',$this->user_id)));
				}
			// beans_close_markup_e("_figure[{$class}][{$function}]",'figure');
		beans_close_markup_e("_link[{$class}][{$function}]",'a');

	}// Method


	/**
		@access (private)
		@param (string) $name
			Author name.
		@return (void)
		@reference
			[Parent]/inc/utility/general.php
	*/
	private function the_name($name)
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_wrapper[{$class}][{$function}]",'h6',array(
			'class' => 'vcard author uk-text-large',
			'itemscope' => 'itemscope',
			'itemtype' => 'http://schema.org/Person',
			'itemprop' => 'author editor creator',
		));
			beans_open_markup_e("_link[{$class}][{$function}]",'a',array(
				/**
				 * @reference (WP)
				 * 	Retrieve the URL to the author page for the user with the ID provided.
				 * 	https://developer.wordpress.org/reference/functions/get_author_posts_url/
				 * 	Retrieves the requested data of the author of the current post.
				 * 	https://developer.wordpress.org/reference/functions/get_the_author_meta/
				*/
				'href' => get_author_posts_url(get_the_author_meta('ID',$this->user_id)),
				'aria-label' => esc_attr__('Author Name','windmill'),
				'rel' => 'author',
				'itemprop' => 'url',
			));
				beans_output_e("_output[{$class}][{$function}]",$name);
			beans_close_markup_e("_link[{$class}][{$function}]",'a');
		beans_close_markup_e("_wrapper[{$class}][{$function}]",'h6');

	}// Method


	/**
		@access (private)
		@param (string) $message
			Author profile.
		@return (void)
		@reference
			[Parent]/inc/customizer/option.php
			[Parent]/inc/utility/general.php
	*/
	private function the_message($message)
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_paragraph[{$class}][{$function}]",__utility_get_option('tag_site-description'),array(
			'class' => 'uk-text-lead uk-text-small ' . $function,
			'itemscope' => 'itemscope',
			'itemtype' => 'http://schema.org/Person',
			'itemprop' => 'author editor creator copyrightHolder',
		));
			// echo nl2br($message);
			// echo __($instance['message']);
			// beans_output_e("_output[{$class}][{$function}]",wpautop($message));
			beans_output_e("_output[{$class}][{$function}]",nl2br($message));
		beans_close_markup_e("_paragraph[{$class}][{$function}]",__utility_get_option('tag_site-description'));

	}// Method


	/**
		@access (private)
			Display SNS follow icons.
		@return (void)
		@reference
			[Parent]/inc/trait/theme.php
			[Parent]/model/app/follow.php
	*/
	private function the_icon()
	{
		self::__activate_application('follow');

	}// Method


	/**
	 * [NOTE]
	 * 	form() method and update() method are defined in the parent class.
	 * @reference
	 * 	[Parent]/controller/widget.php
	 * 	[Parent]/model/widget/base.php
	*/


}// Class
endif;
new _widget_profile();
