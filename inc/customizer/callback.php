<?php
/**
 * Setup theme customizer.
 * @package Windmill
 * @license GPL3.0+
 * @since 1.0.1
*/

/**
 * Inspired by Beans Framework WordPress Theme
 * @link https://www.getbeans.io
 * @author Thierry Muller
 * 
 * Inspired by WeCodeArt WordPress Theme
 * @link https://www.wecodeart.com/
 * @author Bican Marian Valeriu
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
if(class_exists('_customizer_callback') === FALSE) :
class _customizer_callback
{
/**
 * @since 1.0.1
 * 	Callback functions for registering Theme Customizer controls.
 * 
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	__get_font()
 * 		__get_font_primary()
 * 		__get_font_secondary()
 * 		__get_font_tertiary()
 * 	__get_icon()
 * 		__get_icon_header()
 * 	__get_length()
 * 		__get_length_title()
 * 		__get_length_excerpt()
 * 	__get_blogcard_type()
 * 	__get_ga_tracking_type()
 * 	__get_meta()
 * 		__get_meta_archive()
 * 		__get_meta_post()
 * 		__get_meta_figcaption()
 * 	__get_tag()
 * 		__get_tag_site_title()
 * 		__get_tag_site_description()
 * 		__get_tag_page_title()
 * 		__get_tag_post_title()
 * 		__get_tag_widget_title()
 * 		__get_tag_item_title()
 * 	__get_social_share()
 * 	__get_social_follow()
 * 	__get_skin_nav()
 * 		__get_skin_nav_primary()
 * 		__get_skin_nav_secondary()
 * 	__get_skin_nav_pagination()
 * 	__get_skin_heading()
 * 		__get_skin_heading_site_title()
 * 		__get_skin_heading_site_description()
 * 		__get_skin_heading_page_title()
 * 		__get_skin_heading_post_title()
 * 		__get_skin_heading_widget_title()
 * 		__get_skin_heading_item_title()
 * 	__get_skin_sns_share()
 * 	__get_skin_sns_follow()
 * 	__get_skin_button()
 * 		__get_skin_button_primary()
 * 		__get_skin_button_secondary()
 * 		__get_skin_button_tertiary()
 * 	__get_skin_image()
 * 		__get_skin_image_general()
 * 		__get_skin_image_list()
 * 		__get_skin_image_gallery()
 * 		__get_skin_image_card()
 * 	__get_dummy()
 * 
 * @reference (WP)
 * 	Add a customize control.
 * 	https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
 * @reference
 * 	[Parent]/inc/customizer/setup.php
*/

	/**
		@access(private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
	*/
	private static $_class = '';
	private static $_index = '';

	/**
	 * Traits.
	*/
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

	}// Method


	/* Method
	_________________________
	*/
	private static function __get_font()
	{
		/**
			@access (private)
				Google web fonts.
			@return (array)
				_filter[_customizer_callback][font]
			@reference
				[Parent]/inc/customizer/option.php
				[Parent]/inc/env/enqueue.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",array(
			/**
			 * @since 1.0.2
			 * 	Basical San-Serif.
			*/
			'noto-sans-jp' => esc_html('Noto Sans JP'),
			'roboto' => esc_html('Roboto'),
			'open-sans' => esc_html('Open Sans'),

			/**
			 * @since 1.0.2
			 * 	Stylish San-Serif.
			*/
			'lato' => esc_html('Lato'),
			'josefin-sans' => esc_html('Josefin Sans'),
			'oswald' => esc_html('Oswald'),

			/**
			 * @since 1.0.2
			 * 	Basical Serif.
			*/
			'noto-serif-jp' => esc_html('Noto Serif JP'),
			'lora' => esc_html('Lora'),

			/**
			 * @since 1.0.2
			 * 	Stylish Serif.
			*/
			'cinzel' => esc_html('Cinzel'),
			'playfair-display' => esc_html('Playfair Display'),
		));

	}// Method

	public static function __get_font_primary()
	{
		return self::__get_font();
	}// Method

	public static function __get_font_secondary()
	{
		return self::__get_font();
	}// Method

	public static function __get_font_tertiary()
	{
		return self::__get_font();
	}// Method


	/* Method
	_________________________
	*/
	private static function __get_icon()
	{
		/**
			@access (private)
				Icons for application components.
			@return (array)
				_filter[_customizer_callback][icon]
			@reference
				[Parent]/inc/utility/general.php
				[Parent]/model/app/amp.php
				[Parent]/model/app/nav.php
				[Parent]/model/app/search.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",array(
			'nav' => esc_html__('Global Navigation','windmill'),
			'search' => esc_html__('Overlay Search','windmill'),
			'html-sitemap' => esc_html__('HTML Sitemap','windmill'),
			'amp' => esc_html('AMP'),
		));

	}// Method

	public static function __get_icon_header()
	{
		return self::__get_icon();
	}// Method


	/* Method
	_________________________
	*/
	private static function __get_length()
	{
		/**
			@access (private)
				Numeric values.
			@return (array)
				_filter[_customizer_callback][length]
			@reference
				[Parent]/inc/env/excerpt.php
				[Parent]/inc/utility/general.php
				[Parent]/model/app/excerpt.php
				[Parent]/model/data/param.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",array(
			'step' => 1,
			'min' => 1,
			'max' => 200,
		));

	}// Method

	// title
	public static function __get_length_title()
	{
		return self::__get_length();
	}// Method

	// excerpt
	public static function __get_length_excerpt()
	{
		return self::__get_length();
	}// Method


	/* Method
	_________________________
	*/
	public static function __get_blogcard_type()
	{
		/**
			@access (public)
				Blogcard type.
			@return (array)
				_filter[_customizer_callback][blogcard_type]
			@reference
				[Parent]/inc/utility/general.php
				[Parent]/model/data/param.php
				[Parent]/model/shortcode/blogcard.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",array(
			'hatena' => esc_html('Hatena Service (iframe)'),
			'ogp' => esc_html('Open Graph Library'),
			'embed' => esc_html('oEmbed API'),
		));

	}// Method


	/* Method
	_________________________
	*/
	public static function __get_ga_tracking_type()
	{
		/**
			@access (public)
				Google analytics tracking type.
			@return (array)
				_filter[_customizer_callback][ga_tracking_type]
			@reference
				[Parent]/inc/plugin/google/analytics.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",array(
			'gtag' => esc_html('Global Site Tag (gtag.js)'),
			'analytics' => esc_html('Universal Analytics (analytics.js)'),
		));

	}// Method


	/* Method
	_________________________
	*/
	private static function __get_meta()
	{
		/**
			@access (private)
				Post meta items.
			@return (array)
				_filter[_customizer_callback][meta]
			@reference
				[Parent]/controller/fragment/meta.php
				[Parent]/inc/utility/general.php
				[Parent]/model/app/meta.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",array(
			'byline' => esc_html__('Author','windmill'),
			'on' => esc_html__('Published','windmill'),
			'updated' => esc_html__('Updated','windmill'),
			'cat-links' => esc_html__('Categories','windmill'),
			'tags-links' => esc_html__('Tags','windmill'),
			'comments-link' => esc_html__('Comments','windmill'),
		));

	}// Method

	// label meta on thumbnail.
	public static function __get_meta_archive()
	{
		return self::__get_meta();
	}// Method

	// label meta on thumbnail.
	public static function __get_meta_figcaption()
	{
		return self::__get_meta();
	}// Method

	// label meta on thumbnail.
	public static function __get_meta_post()
	{
		return self::__get_meta();
	}// Method


	/* Method
	_________________________
	*/
	private static function __get_tag()
	{
		/**
			@access (private)
				Heading tags.
			@return (array)
				_filter[_customizer_callback][tag]
			@reference
				[Parent]/controller/fragment/title.php
				[Parent]/inc/env/title.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",array(
			'h1' => esc_html__('h1 Tag','windmill'),
			'h2' => esc_html__('h2 Tag','windmill'),
			'h3' => esc_html__('h3 Tag','windmill'),
			'h4' => esc_html__('h4 Tag','windmill'),
			'h5' => esc_html__('h5 Tag','windmill'),
			'h6' => esc_html__('h6 Tag','windmill'),
			'p' => esc_html__('p Tag','windmill'),
		));

	}// Method

	public static function __get_tag_site_title()
	{
		return self::__get_tag();
	}// Method

	public static function __get_tag_site_description()
	{
		return self::__get_tag();
	}// Method

	public static function __get_tag_page_title()
	{
		return self::__get_tag();
	}// Method

	public static function __get_tag_post_title()
	{
		return self::__get_tag();
	}// Method


	public static function __get_tag_widget_title()
	{
		return self::__get_tag();
	}// Method

	public static function __get_tag_item_title()
	{
		return self::__get_tag();
	}// Method


	/* Method
	_________________________
	*/
	public static function __get_social_share()
	{
		/**
			@access (public)
				SNS share services.
			@return (array)
				_filter[_customizer_callback][social_share]
			@reference
				[Parent]/controller/fragment/share.php
				[Parent]/inc/utility/general.php
				[Parent]/model/app/share.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",array(
			'twitter' => esc_html('Twitter'),
			'line' => esc_html('LINE'),
			'facebook' => esc_html('Facebook'),
			'getpocket' => esc_html('Pocket'),
			'hatena' => esc_html('Hatebu'),
			'pinterest' => esc_html('Pinterest'),
		));

	}// Method


	/* Method
	_________________________
	*/
	public static function __get_social_follow()
	{
		/**
			@access (public)
				SNS follow services.
			@return (array)
				_filter[_customizer_callback][social_follow]
			@reference
				[Parent]/controller/fragment/follow.php
				[Parent]/inc/utility/general.php
				[Parent]/model/app/follow.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",array(
			'twitter' => esc_html('Twitter'),
			'facebook' => esc_html('Facebook'),
			'instagram' => esc_html('Instagram'),
			'github' => esc_html('Github'),
			'youtube' => esc_html('YouTube'),
		));

	}// Method


	/* Method
	_________________________
	*/
	public static function __get_skin_sns_share()
	{
		/**
			@access (public)
				Styles/effects for SNS share button.
			@return (array)
				_filter[_customizer_callback][skin_sns_share]
			@reference
				[Parent]/asset/inline/share.php
				[Parent]/inc/utility/general.php
				[Parent]/model/app/share.php
				[Parent]/model/data/param.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",array(
			'shape-1' => esc_html__('Square','windmill'),
			'shape-2' => esc_html__('Circle','windmill'),
			'stylish-1' => esc_html__('Postit','windmill'),
			'stylish-2' => esc_html__('Cube','windmill'),
		));

	}// Method


	/* Method
	_________________________
	*/
	public static function __get_skin_sns_follow()
	{
		/**
			@access (public)
				Styles/effects for SNS follow button.
			@return (array)
				_filter[_customizer_callback][skin_sns_follow]
			@reference
				[Parent]/asset/inline/follow.php
				[Parent]/inc/utility/general.php
				[Parent]/model/app/follow.php
				[Parent]/model/data/param.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",array(
			'rectangle-1' => esc_html__('Rectangle','windmill'),
			'square-1' => esc_html__('Square','windmill'),
			'circle-1' => esc_html__('Circle','windmill'),
			'flat-1' => esc_html__('Flat','windmill'),
		));

	}// Method


	/* Method
	_________________________
	*/
	private static function __get_skin_nav()
	{
		/**
			@access (private)
				Styles/effects for navigation.
			@return (array)
				_filter[_customizer_callback][skin_nav]
			@reference
				[Parent]/asset/inline/nav.php
				[Parent]/inc/utility/general.php
				[Parent]/model/app/nav.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",array(
			'navbar' => esc_html__('Navbar','windmill'),
			'overlay' => esc_html__('Overlay','windmill'),
		));

	}// Method

	public static function __get_skin_nav_primary()
	{
		return self::__get_skin_nav();
	}// Method

	public static function __get_skin_nav_secondary()
	{
		return self::__get_skin_nav();
	}// Method


	/* Method
	_________________________
	*/
	public static function __get_skin_nav_pagination()
	{
		/**
			@access (public)
				Styles/effects for pagination.
			@return (array)
				_filter[_customizer_callback][skin_nav_pagination]
			@reference
				[Parent]/asset/inline/pagination.php
				[Parent]/inc/utility/general.php
				[Parent]/model/app/pagination.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",array(
			'square' => esc_html__('Square','windmill'),
			'circle' => esc_html__('Circle','windmill'),
		));

	}// Method


	/* Method
	_________________________
	*/
	private static function __get_skin_heading()
	{
		/**
			@access (private)
				Styles/effects for titles/headings.
			@return (array)
				_filter[_customizer_callback][skin_heading]
			@reference
				[Parent]/asset/inline/heading.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",array(
			'site-origin' => esc_html__('Site Origin','windmill'),
			'border-bottom' => esc_html__('Underline','windmill'),
			'border-left-bottom' => esc_html__('Left border and Underline','windmill'),
			'left-mark-1' => esc_html__('Symbol','windmill'),
			'fill-1' => esc_html__('Fill','windmill'),
			'marker-1' => esc_html__('Highlighter','windmill'),
			'fade-1' => esc_html__('Fade','windmill'),
		));

	}// Method

	// front
	public static function __get_skin_heading_site_title()
	{
		return self::__get_skin_heading();
	}// Method

	public static function __get_skin_heading_site_description()
	{
		return self::__get_skin_heading();
	}// Method

	public static function __get_skin_heading_page_title()
	{
		return self::__get_skin_heading();
	}// Method

	public static function __get_skin_heading_post_title()
	{
		return self::__get_skin_heading();
	}// Method

	public static function __get_skin_heading_widget_title()
	{
		return self::__get_skin_heading();
	}// Method

	public static function __get_skin_heading_list_title()
	{
		return self::__get_skin_heading();
	}// Method


	/* Method
	_________________________
	*/
	private static function __get_skin_button()
	{
		/**
			@access (private)
				Styles/effects for buttons.
			@return (array)
				_filter[_customizer_callback][skin_button]
			@reference
				[Parent]/asset/inline/button.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",array(
			'fade-background' => esc_html__('Fade Background','windmill'),
			'split-horizonal' => esc_html__('Sprit Horizonal','windmill'),
			'split-vertical' => esc_html__('Sprit Vertical','windmill'),
			'flip-vertical' => esc_html__('Frip Vertical','windmill'),
			'flip-horizonal' => esc_html__('Flip Horizonal','windmill'),
			'cover-close' => esc_html__('Cover Close','windmill'),
			'is-reflection' => esc_html__('Reflection','windmill'),
		));

	}// Method

	public static function __get_skin_button_primary()
	{
		return self::__get_skin_button();
	}// Method

	public static function __get_skin_button_secondary()
	{
		return self::__get_skin_button();
	}// Method

	public static function __get_skin_button_tertiary()
	{
		return self::__get_skin_button();
	}// Method


	/* Method
	_________________________
	*/
	private static function __get_skin_image()
	{
		/**
			@access (private)
				Styles/effects for post thumbnails.
			@return (array)
				_filter[_customizer_callback][skin_image]
			@reference
				[Parent]/asset/inline/image.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",array(
			'fade-cover' => esc_html('Fade Cover'),
			'scale-up-image' => esc_html('Scale Up Image'),
			'scale-down-image' => esc_html('Scale Down Image'),
			'top-cover' => esc_html('Top Cover'),
			'bottom-cover' => esc_html('Bottom Cover'),
			'small-top-bottom' => esc_html('Small Top + Bottom'),
			'small-left-right' => esc_html('Small Left + Right'),
		));

	}// Method

	public static function __get_skin_image_general()
	{
		return self::__get_skin_image();
	}// Method

	public static function __get_skin_image_list()
	{
		return self::__get_skin_image();
	}// Method

	public static function __get_skin_image_gallery()
	{
		return self::__get_skin_image();
	}// Method

	public static function __get_skin_image_card()
	{
		return self::__get_skin_image();
	}// Method


	/* Method
	_________________________
	*/
	public static function __get_dummy(){
		/**
			@access (public)
				Dummy callback.
			@return (array)
				_filter[_customizer_callback][dummy]
			@reference
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",array(
			'dummy-1' => esc_html__('Dummy No.1','windmill'),
			'dummy-2' => esc_html__('Dummy No.2','windmill'),
			'dummy-3' => esc_html__('Dummy No.3','windmill'),
		));

	}// Method


}// Class
endif;
// new _customizer_callback();
_customizer_callback::__get_instance();
