<?php
/**
 * Load applications according to the settings and conditions.
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
if(class_exists('_app_image') === FALSE) :
class _app_image
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_param()
 * 	set_hook()
 * 	invoke_hook()
 * 	__the_template()
 * 	__the_figure()
 * 	__the_figcaption()
 * 	__the_noimage()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $_param
			Parameter for the application.
		@var (array) $skin
			Smooth transitions between two states when hovering an element.
		@var (array) $media
			Available image sizes.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_param = array();
	private $skin = array();
	private $media = array();
	private $hook = array();

	/**
	 * Traits.
	*/
	use _trait_hook;
	use _trait_singleton;
	use _trait_theme;


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
				[Parent]/inc/trait/theme.php
				[Parent]/inc/utility/general.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);
		self::$_param = $this->set_param(self::$_index);

		// Smooth transitions between two states when hovering an element.
		$this->skin = $this->set_skin();

		// Get information about available image sizes.
		$this->media = __utility_get_image_size();

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook($this->hook);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_skin()
	{
		/**
			@access (private)
				The definitions of Smooth transitions between two states when hovering an element..
			@return (array)
				_filter[_app_image][skin]
			@reference (Uikit)
				https://getuikit.com/assets/uikit/tests/transition.html
				https://getuikit.com/docs/transition
			@reference
				[Parent]/inc/customizer/options.php
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
			'fade-cover' => 'uk-transition-fade uk-position-cover uk-overlay uk-overlay-primary uk-flex uk-flex-center uk-flex-middle',
			'top-cover' => 'uk-transition-slide-top uk-position-cover uk-overlay uk-overlay-primary uk-flex uk-flex-center uk-flex-middle',
			'bottom-cover' => 'uk-transition-slide-bottom uk-position-cover uk-overlay uk-overlay-primary',
			'scale-up-image' => 'uk-transition-scale-up uk-transition-opaque',
			'scale-down-image' => 'uk-transition-scale-down uk-transition-opaque',
			'small-top-bottom' => array(
				'before' => 'uk-transition-slide-top-medium',
				'after' => 'uk-transition-slide-bottom-medium',
			),
			'small-left-right' => array(
				'before' => 'uk-transition-slide-left-medium',
				'after' => 'uk-transition-slide-right-medium',
			),
		));

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
				_filter[_app_image][hook]
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/trait/hook.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);
		$index = self::$_index;

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		 */
		return beans_apply_filters("_filter[{$class}][{$function}]",$this->set_parameter_callback(array(
			'__the_figure' => array(
				'beans_id' => $class . '__the_figure',
				'tag' => 'beans_add_action',
				'hook' => HOOK_POINT['model'][$index]['main']
			),
			'__the_figcaption' => array(
				'beans_id' => $class . '__the_figcaption',
				'tag' => 'beans_add_action',
				'hook' => HOOK_POINT['model'][$index]['main']
			),
			'__the_noimage' => array(
				'beans_id' => $class . '__the_noimage',
				'tag' => 'beans_add_action',
				'hook' => HOOK_POINT['model'][$index]['main']
			),
		)));

	}// Method


	/* Method
	_________________________
	*/
	public static function __the_template($args = array())
	{
		/**
			@access (private)
				Load and echo this application.
			@param (array) $args
				Additional arguments passed to this application.
			@return (void)
			@reference
				[Parent]/inc/controller/fragment/image.php
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/theme.php
		*/
		$class = self::$_class;
		$index = self::$_index;

		/**
		 * @reference (WP)
		 * 	Merge user defined arguments into defaults array.
		 * 	https://developer.wordpress.org/reference/functions/wp_parse_args/
		 * @param (string)|(array)|(object) $args
		 * 	Value to merge with $defaults.
		 * @param (array) $defaults
		 * 	Array that serves as the defaults.
		 */
		self::$_param = wp_parse_args($args,self::$_param);

		do_action(HOOK_POINT['model'][$index]['prepend']);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		 */
		beans_open_markup_e("_figure[{$class}]",'figure',array(
			'class' => 'uk-inline-clip uk-transition-toggle',
			'tabindex' => '0',
		));
			/**
				@hooked
					_app_image::__the_render()
				@reference
					[Parent]/model/app/image.php
			 */
			do_action(HOOK_POINT['model'][$index]['main']);

		beans_close_markup_e("_figure[{$class}]",'figure');

		do_action(HOOK_POINT['model'][$index]['append']);

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_figure()
	{
		/**
			@access (public)
				Echo the content of the application.
			@return (void)
			@hook (beans id)
				_app_image__the_figure
			@reference
				[Parent]/inc/utility/general.php
				[Parent]/inc/utility/theme.php
		 */

		/**
		 * @reference (WP)
		 * 	Determines whether a post has an image attached.
		 * 	https://developer.wordpress.org/reference/functions/has_post_thumbnail/
		 * 	Checks a themefs support for a given feature.
		 * 	https://developer.wordpress.org/reference/functions/current_theme_supports/
		 */
		if(!has_post_thumbnail() || !current_theme_supports('post-thumbnails')){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$needle = self::$_param['needle'];
		$skin = self::$_param['skin'];

		// Get current post data.
		global $post;
		if(!$post){
			$post = __utility_get_post_object();
		}

		if(!__utility_is_beans('image')){
			/**
			 * @reference (Beans)
			 * 	Filter the arguments used by{@see beans_edit_image()} to edit the post image.
			 * 	https://www.getbeans.io/code-reference/functions/beans_get_post_attachment/
			 * 	https://www.getbeans.io/code-reference/functions/beans_edit_post_attachment/
			 * @param (bool)|(array) $edit_args
			 * 	Set to false to use WP large size.
			 * @reference
			 * 	[Plugin]/beans_extension/api/image.php
			 */
			$edit = beans_apply_filters("_filter[{$class}][{$needle}][edit]",array(
				'resize' => array(self::$_param['size'],FALSE),
			));
			if(empty($edit)){
				$obj = beans_get_post_attachment($post->ID,self::$_param['size']);
			}
			else{
				$obj = beans_edit_post_attachment($post->ID,self::$_param['size']);
			}

			/**
			 * @reference (Beans)
			 * 	Call the functions added to a filter hook.
			 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
			 */
			$args = beans_apply_filters("_filter[{$class}][{$needle}][args]",array(
				'src' => $obj->src,
				'data-src' => $obj->src,
				// 'width' => $this->media['medium']['width'],
				// 'height' => $this->media['medium']['height'],
				'alt' => esc_attr__('Image Source','windmill'),
				'itemprop' => 'image',
				'uk-img' => '',
			));

			if(($skin === 'scale-up-image') || ($skin === 'scale-down-image')){
				$args['class'] = $this->skin[$skin];
			}
		}

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_selfclose_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		 */
		beans_open_markup_e("_link[{$class}][{$function}][{$needle}]",'a',array(
			/* Automatically escaped. */
			'href' => get_permalink($post->ID),
			'aria-label' => esc_attr__('Post Thumbnail','windmill'),
		));
			if(!__utility_is_beans('image') && isset($obj->src)){
				beans_selfclose_markup_e("_src[{$class}][{$needle}]",'img',$args);
			}
			else{
				/**
				 * @since 1.0.1
				 * 	Beans API isn't available,use wp_get_attachment_image_attributes filter instead.
				 * @reference (WP)
				 * 	Display the post thumbnail.
				 * 	https://developer.wordpress.org/reference/functions/the_post_thumbnail/
				*/
				if(($skin === 'scale-up-image') || ($skin === 'scale-down-image')){
					the_post_thumbnail(self::$_param['size'],array('class' => $this->skin[$skin]));
				}
				else{
					the_post_thumbnail(self::$_param['size']);
				}
			}
		beans_close_markup_e("_link[{$class}][{$function}][{$needle}]",'a');

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_figcaption()
	{
		/**
			@access (public)
				Echo figcaption.
			@return (void)
			@hook (beans id)
				_app_image__the_figure
			@reference
				[Parent]/inc/customizer/option.php
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/general.php
		*/
		$skin = self::$_param['skin'];
		if(($skin === 'scale-up-image') || ($skin === 'scale-down-image')){return;}

		switch($skin){
			case 'fade-cover' :
			case 'top-cover' :
			case 'bottom-cover' :
				get_template_part(SLUG['figure'] . 'figcaption-single',NULL,array(
					'needle' => self::$_param['needle'],
					'skin' => $this->skin[$skin],
				));
				break;

			case 'small-top-bottom' :
			case 'small-left-right' :
				get_template_part(SLUG['figure'] . 'figcaption-multi',NULL,array(
					'needle' => self::$_param['needle'],
					'skin-before' => $this->skin[$skin]['before'],
					'skin-after' => $this->skin[$skin]['after'],
				));
				break;
		}

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_noimage()
	{
		/**
			@access (public)
			@return (void)
			@hook (beans id)
				_app_image__the_noimage
			@reference
				[Parent]/inc/customizer/option.php
				[Parent]/inc/utility/general.php
				[Parent]/inc/utility/theme.php
		*/

		/**
		 * @reference (WP)
		 * 	Determines whether a post has an image attached.
		 * 	https://developer.wordpress.org/reference/functions/has_post_thumbnail/
		 */
		if(has_post_thumbnail()){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// Get current post data.
		global $post;
		if(!$post){
			$post = __utility_get_post_object();
		}

		$size = self::$_param['size'];
		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_selfclose_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		 */
		beans_open_markup_e("_link[{$class}][{$function}]",'a',array(
			/* Automatically escaped. */
			'href' => get_permalink($post->ID),
			'aria-label' => esc_attr('No Image'),
		));
			if(__utility_is_uikit()){
				beans_selfclose_markup_e("_src[{$class}][{$function}]",'img',array(
					'src' => __utility_get_option('media_nopost') ? __utility_get_option('media_nopost') : URI['image'] . 'nopost.jpg',
					'data-src' => __utility_get_option('media_nopost') ? __utility_get_option('media_nopost') : URI['image'] . 'nopost.jpg',
					'width' => $this->media[$size]['width'],
					'height' => $this->media[$size]['height'],
					'alt' => esc_attr('No Image'),
					'itemprop' => 'image',
					'uk-img' => '',
				));
			}
			else{
				beans_selfclose_markup_e("_src[{$class}][{$function}]",'img',array(
					/* Automatically escaped. */
					'src' => __utility_get_option('media_nopost') ? __utility_get_option('media_nopost') : URI['image'] . 'nopost.jpg',
					'width' => $this->media[$size]['width'],
					'height' => $this->media[$size]['height'],
					'alt' => esc_attr('No Image'),
					'itemprop' => 'image',
				));
			}
		beans_close_markup_e("_link[{$class}][{$function}]",'a');

	}// Method


}// Class
endif;
// new _app_image();
_app_image::__get_instance();
