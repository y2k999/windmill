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
 * 
 * Inspired by f(x) Share WordPress Plugin
 * @link http://genbu.me/plugins/fx-share/
 * @author David Chandra Purnama
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
if(class_exists('_customizer_default') === FALSE) :
class _customizer_default
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_user_id()
 * 	set_icon()
 * 	set_meta_single()
 * 	set_meta_archive()
 * 	set_share()
 * 	set_follow()
 * 	set_default()
 * 	__get_setting()
*/

	/**
		@access(private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (string) $icon
			Collection of icons.
		@var (string) $meta_single
			Collection of post meta items on single posts.
		@var (string) $meta_archive
			Collection of post meta items on archive posts.
		@var (string) $sns_share
			Collection of SNS share services.
		@var (string) $sns_follow
			Collection of SNS follow services.
		@var (array) $image
			Image files.
		@var (array) $_default
			Default values of theme customizer.
	*/
	private static $_class = '';
	private static $_index = '';
	private $user_id = 1;
	private $icon = '';
	private $meta_single = '';
	private $meta_archive = '';
	private $sns_share = '';
	private $sns_follow = '';
	private $image = array();
	private static $_default = array();

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
			@global (array) $_customizer_default
				Theme Customizer default value (Global).
			@return (void)
			@reference
				[Parent]/inc/customizer/default.php
				[Parent]/inc/trait/singleton.php
				[Parent]/inc/utility/general.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);

		$this->user_id = __utility_get_user_id();
		$this->icon = $this->set_icon();
		$this->meta_single = $this->set_meta_single();
		$this->meta_archive = $this->set_meta_archive();
		$this->sns_share = $this->set_sns_share();
		$this->sns_follow = $this->set_sns_follow();
		$this->image = $this->set_image();
		self::$_default = $this->set_default();

		// Reflect on global values.
		global $_customizer_default;
		$_customizer_default = self::$_default;

	}// Method


	/* Setter
	_________________________
	*/
	private function set_icon()
	{
		/**
			@access (private)
				Set default status of topbar icons.
			@return (string)
				_filter[_customizer_default][icon]
			@reference
				[Parent]/controller/structure/header.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$return = array();

		// By default, activate all icons ON.
		foreach(array(
			'nav:1',
			'search:1',
			'html-sitemap:1',
			'amp:1',
		) as $item){
			$return[] = $item;
		}

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",implode(',',$return));

	}// Method


	/* Setter
	_________________________
	*/
	private function set_meta_single()
	{
		/**
			@access (private)
				Set default status of post meta items on single posts.
			@return (string)
				_filter[_customizer_default][meta_single]
			@reference
				[Parent]/controller/fragment/meta.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$return = array();

		foreach(array(
			'byline:1',
			'on:1',
			'updated:1',
			'cat-links:1',
			'tags-links:0',
			'comments-link:0',
		) as $item){
			$return[] = $item;
		}

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",implode(',',$return));

	}// Method


	/* Setter
	_________________________
	*/
	private function set_meta_archive()
	{
		/**
			@access (private)
				Set default status of post meta items on archive posts.
			@return (string)
				_filter[_customizer_default][meta_archive]
			@reference
				[Parent]/controller/fragment/meta.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$return = array();

		foreach(array(
			'byline:0',
			'on:0',
			'updated:1',
			'cat-links:1',
			'tags-links:0',
			'comments-link:0',
		) as $item){
			$return[] = $item;
		}

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",implode(',',$return));

	}// Method


	/* Setter
	_________________________
	*/
	private function set_sns_share()
	{
		/**
			@access (private)
				Set default status of SNS share buttons/icons.
			@return (string)
				_filter[_customizer_default][sns_share]
			@reference
				[Parent]/inc/utility/general.php
				[Parent]/model/app/share.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$return = array();

		// By default, activate all SNS share services ON.
		foreach(array(
			'twitter:1',
			'line:1',
			'facebook:1',
			'getpocket:1',
			'hatena:1',
			'pinterest:1',
		) as $item){
			$return[] = $item;
		}

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",implode(',',$return));

	}// Method


	/* Setter
	_________________________
	*/
	private function set_sns_follow()
	{
		/**
			@access (private)
				Set default status of SNS follow buttons/icons.
			@return (string)
				_filter[_customizer_default][sns_follow]
			@reference
				[Parent]/inc/utility/general.php
				[Parent]/model/app/follow.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$return = array();

		// By default, activate all SNS follow services ON.
		foreach(array(
			/**
			 * @reference (WP)
			 * 	Retrieves the requested data of the author of the current post.
			 * 	https://developer.wordpress.org/reference/functions/get_the_author_meta/
			*/
			get_the_author_meta('twitter',$this->user_id) ? 'twitter:1' : 'twitter:0',
			get_the_author_meta('facebook',$this->user_id) ? 'facebook:1' : 'facebook:0',
			get_the_author_meta('instagram',$this->user_id) ? 'instagram:1' : 'instagram:0',
			get_the_author_meta('github',$this->user_id) ? 'github:1' : 'github:0',
			get_the_author_meta('youtube',$this->user_id) ? 'youtube:1' : 'youtube:0',
		) as $item){
			$return[] = $item;
		}

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",implode(',',$return));

	}// Method


	/* Setter
	_________________________
	*/
	private function set_image()
	{
		/**
			@access (private)
				Set image files for User profile and not found posts.
			@return (string)
				_filter[_customizer_default][image]
			@reference
				[Parent]/inc/utility/general.php
				[Parent]/model/app/profile.php
				[Parent]/model/widget/recent.php
				[Parent]/model/widget/relation.php
				[Parent]/templatel/content/archive.php
				[Parent]/templatel/content/home.php
				[Parent]/templatel/content/index.php
				[Parent]/templatel/content/singular.php
				[Plugin]/beans_extension/admin/tab/image.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$profile = beans_get_image_setting('profile');
		$nopost = beans_get_image_setting('nopost');

		$return = array();
		$return['profile'] = isset($profile) ? $profile : URI['image'] . 'profile.jpg';
		$return['nopost'] = isset($nopost) ? $nopost : URI['image'] . 'nopost.jpg';

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",$return);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_default()
	{
		/**
			@access (private)
				Set default value for Theme Customizer settings.
			@return (array)
				_filter[_customizer_default][default]
			@reference
				[Parent]/inc/setup/constant.php
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
			 * @since 1.0.1
			 * 	Settings in Basis section.
			 * @reference
			 * 	[Parent]/inc/customizer/setting/basis/
			*/
			// core
			'jquery' => 1,
			'async' => 1,
			'js2footer' => 1,

			// font
			'font_primary' => 'lora',
			'font_secondary' => 'playfair-display',

			/**
			 * @since 1.0.1
			 * 	Settings in Template section.
			 * @reference
			 * 	[Parent]/inc/customizer/setting/template/
			*/
			// header
			'fixed_header' => 1,
			'icon_header' => $this->icon,

			// content
			'media_profile' => $this->image['profile'],
			'media_nopost' => $this->image['nopost'],
			'message_nopost' => esc_html__('Whoops, the requested post was not found.','windmill'),

			// archive
			'excerpt_more' => esc_html__('Read More','windmill'),
			'excerpt_length' => 75,

			// singular
			'page_html-sitemap' => '',
			'blogcard_post' => 1,
			'blogcard_type' => 'hatena',
			'blogcard_tag' => '',

			// 404
			'title_404' => esc_html('404 Not Found'),
			'message_404' => esc_html('The requested URL was not found.'),

			// sidebar
			'fixed_sidebar' => 1,

			// footer
			// 'fixed_footer' => 1,
			'back2top' => 1,
			'breadcrumb' => 1,
			'credit' => '',

			/**
			 * @since 1.0.1
			 * 	Settings in SEO section.
			 * @reference
			 * 	[Parent]/inc/customizer/setting/seo/
			*/
			// google analytics
			'ga_use' => 0,
			'ga_tracking-id' => '',
			'ga_tracking-type' => 'gtag',
			'ga_exclude-login' => 1,

			// tag
			'tag_site-title' => 'h1',
			'tag_site-description' => 'p',
			'tag_page-title' => 'h2',
			'tag_post-title' => 'h2',
			'tag_item-title' => 'h4',
			'tag_widget-title' => 'h4',

			// meta
			'meta_post' => $this->meta_single,
			'meta_archive' => $this->meta_archive,
			'meta_figcaption' => 'cat-links',

			// toc
			'toc_post' => 1,
			'toc_tag' => '',
			'toc_min' => 2,

			/**
			 * @since 1.0.1
			 * 	Settings in SNS section.
			 * @reference
			 * 	[Parent]/inc/customizer/setting/sns/
			*/
			// sns
			'social_share' => $this->sns_share,
			'social_follow' => $this->sns_follow,

			/**
			 * @reference (WP)
			 * 	Retrieves the requested data of the author of the current post.
			 * 	https://developer.wordpress.org/reference/functions/get_the_author_meta/
			*/
			'url_twitter' => get_the_author_meta('twitter',$this->user_id),
			'url_facebook' => get_the_author_meta('facebook',$this->user_id),
			'url_instagram' => get_the_author_meta('instagram',$this->user_id),
			'url_github' => get_the_author_meta('github',$this->user_id),
			'url_youtube' => get_the_author_meta('youtube',$this->user_id),

			/**
			 * @since 1.0.1
			 * 	Settings in Skin (design) section.
			 * @reference
			 * 	[Parent]/inc/customizer/setting/skin/
			*/
			// button
			'skin_button_primary' => 'split-horizonal',
			'skin_button_secondary' => 'flip-vertical',
			'skin_button_tertiary' => 'is-reflection',

			// image
			'skin_image_general' => 'top-cover',
			'skin_image_list' => 'scale-up-image',
			'skin_image_gallery' => 'small-top-bottom',
			// 'skin_image_card' => 'small-left-right',
			'skin_image_card' => 'bottom-cover',

			// heading
			'skin_heading_site-title' => '',
			'skin_heading_site-description' => '',
			'skin_heading_page-title' => 'border-bottom',
			'skin_heading_post-title' => 'site-origin',
			'skin_heading_widget-title' => 'fade-1',
			'skin_heading_item-title' => '',

			// nav
			'skin_nav_primary' => '',
			'skin_nav_secondary' => '',
			'skin_nav_pagination' => 'square',

			// sns
			'skin_sns_share' => 'stylish-2',
			'skin_sns_follow' => 'rectangle-1',

		));

	}// Method


	/* Method
	_________________________
	*/
	public static function __get_setting($needle = '')
	{
		/**
			@access (public)
				Return the default values of theme customizer.
			@param (string) $needle
				Theme modification name.
			@return (array)
			@reference
				[Parent]/inc/customizer/option.php
				[Parent]/inc/customizer/setup.php
		*/

		/**
		 * @reference (WP)
		 * 	Retrieves theme modification value for the current theme.
		 * 	https://developer.wordpress.org/reference/functions/get_theme_mod/
		 * 	Retrieves all theme modifications.
		 * 	https://developer.wordpress.org/reference/functions/get_theme_mods/
		*/
		if(isset($needle) && array_key_exists($needle,self::$_default)){
			return self::$_default[$needle];
		}
		else{
			return self::$_default;
		}

	}// Method


}// Class
endif;
// new _customizer_default();
_customizer_default::__get_instance();
