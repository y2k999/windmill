<?php 
/**
 * Stores data for applications.
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
if(class_exists('_data_param') === FALSE) :
class _data_param
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_image_size()
 * 	set_component()
 * 	set_default()
 * 	get_amp()
 * 	get_back2top()
 * 	get_branding()
 * 	get_breadcrumb()
 * 	get_comments()
 * 	get_credit()
 * 	get_dynamic_sidebar()
 * 	get_excerpt()
 * 	get_follow()
 * 	get_html_sitemap()
 * 	get_image()
 * 	get_nav()
 * 	get_pagination()
 * 	get_post_link()
 * 	get_search()
 * 	get_share()
 * 	get_title()
 * 	get_embed_card()
 * 	get_hatena_card()
 * 	get_ogp_card()
 * 	get_toc()
 * 	__get_setting()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $_default
			default parameter values for each application components.
		@var (array) $image_size
			Registerd image sizes.
		@var (array) $component
			Application components that use parameter values.
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_default = array();
	private $image_size = array();
	private $component = array();

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

		$this->image_size = $this->set_image_size();
		$this->component = $this->set_component();

		self::$_default = $this->set_default();

	}// Method


	/* Setter
	_________________________
	*/
	private function set_image_size()
	{
		/**
			@access (private)
				Register a new image size.
				https://developer.wordpress.org/reference/functions/add_image_size/
			@return (array)
				_filter[_setup_theme_support][size]
			@reference
				[Parent]/inc/setup/theme-support.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",_setup_theme_support::__get_image_size());

	}// Method


	/* Setter
	_________________________
	 */
	public function set_component()
	{
		/**
			@access (private)
				Set application components that use parameter values.
			@return (array)
				_filter[_data_param][component]
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
			'amp' => 'amp',
			'back2top' => 'back2top',
			'branding' => 'branding',
			'breadcrumb' => 'breadcrumb',
			'comments' => 'comments',
			'credit' => 'credit',
			'dynamic-sidebar' => 'dynamic_sidebar',
			'excerpt' => 'excerpt',
			'follow' => 'follow',
			'html-sitemap' => 'html_sitemap',
			'image' => 'image',
			'nav' => 'nav',
			'pagination' => 'pagination',
			'post-link' => 'post_link',
			'search' => 'search',
			'share' => 'share',
			'title' => 'title',
			'embed-card' => 'embed_card',
			'hatena-card' => 'hatena_card',
			'ogp-card' => 'ogp_card',
			'toc' => 'toc',
		));

	}// Method


	/* Setter
	_________________________
	*/
	private function set_default()
	{
		/**
			@access (private)
				Build the default parameter values for each application components.
			@return (string)
				_filter[_data_param][default]
			@reference
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$return = array();

		foreach($this->component as $key => $value){
			// $item = str_replace('-','_',$item);
			$method = 'get_' . $value;
			if(is_callable([$this,$method])){
				$return[$key] = call_user_func([$this,$method]);
			}
		}

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",$return);

	}// Method


	/**
		@access (private)
		@return (array)
			_filter[_data_param][amp]
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/model/app/amp.php
	*/
	private function get_amp()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array());

	}// Method


	/**
		@access (private)
		@return (array)
			_filter[_data_param][back2top]
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/model/app/back2top.php
	*/
	private function get_back2top()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array());

	}// Method


	/**
		@access (private)
		@return (array)
			_filter[_data_param][branding]
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/model/app/branding.php
	*/
	private function get_branding()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array());

	}// Method


	/**
		@access (private)
		@return (array)
			_filter[_data_param][breadcrumb]
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/model/app/breadcrumb.php
	*/
	private function get_breadcrumb()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array());

	}// Method


	/**
		@access (private)
		@return (array)
			_filter[_data_param][comments]
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/model/app/comments.php
	*/
	private function get_comments()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'title' => esc_html('Comment Form'),
		));

	}// Method


	/**
		@access (private)
		@return (array)
			_filter[_data_param][credit]
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/model/app/credit.php
	*/
	private function get_credit()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array());

	}// Method


	/**
		@access (private)
		@return (array)
			_filter[_data_param][dynamic_sidebar]
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/model/app/dynamic-sidebar.php
	*/
	private function get_dynamic_sidebar()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'class' => 'sidebar',
		));

	}// Method


	/**
		@access (private)
			Set parameters for the application component.
		@return (array)
			_filter[_data_param][excerpt]
		@reference
			[Parent]/inc/customizer/option.php
			[Parent]/inc/utility/general.php
			[Parent]/model/app/excerpt.php
	*/
	private function get_excerpt()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @since 1.0.1
		 * 	Icon for prefix.
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		$icon = beans_apply_filters("_icon[{$class}][{$function}]",sprintf(' <span uk-icon="icon: %s"></span> ',' chevron-double-right'));

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'skin' => __utility_get_option('skin_button_primary') ? __utility_get_option('skin_button_primary') : '',
			'length' => __utility_get_option('excerpt_length') ? __utility_get_option('excerpt_length') : 75,
			'readmore' => __utility_get_option('excerpt_more') ? __utility_get_option('excerpt_more') . $icon : '...',
		));

	}// Method


	/**
		@access (private)
			Set parameters for the application component.
		@return (array)
			_filter[_data_param][follow]
		@reference
			[Parent]/inc/customizer/option.php
			[Parent]/inc/utility/general.php
			[Parent]/model/app/follow.php
	*/
	private function get_follow()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'skin' => __utility_get_option('skin_sns_follow') ? __utility_get_option('skin_sns_follow') : '',
		));

	}// Method


	/**
		@access (private)
			Set parameters for the application component.
		@return (array)
			_filter[_data_param][html_sitemap]
		@reference
			[Parent]/inc/customizer/option.php
			[Parent]/inc/utility/general.php
			[Parent]/model/app/html-sitemap.php
	*/
	private function get_html_sitemap()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'class' => 'header',
			// 'href' => 'contact/sitemap',
			'href' => !empty(__utility_get_option('page_html-sitemap')) ? __utility_get_option('page_html-sitemap') : '',
			'icon' => 'album',
		));

	}// Method


	/**
		@access (private)
			Set parameters for the application component.
		@return (array)
			_filter[_data_param][image]
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/model/app/image.php
	*/
	private function get_image()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'size' => 'medium',
			'skin' => '',
			'needle' => '',
		));

	}// Method


	/**
		@access (private)
			Set parameters for the application component.
		@return (array)
			_filter[_data_param][nav]
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/model/app/nav.php
	*/
	private function get_nav()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'class'	 => 'footer',
		));

	}// Method


	/**
		@access (private)
			Set parameters for the application component.
		@return (array)
			_filter[_data_param][pagination]
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/inc/utility/theme.php
			[Parent]/model/data/icon.php
			[Parent]/model/app/pagination.php
	*/
	private function get_pagination()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'range' => 5,
			'first' => __utility_get_icon('angle-double-left'),
			'previous' => __utility_get_icon('angle-left'),
			'next' => __utility_get_icon('angle-right'),
			'last' => __utility_get_icon('angle-double-right'),
		));

	}// Method


	/**
		@access (private)
			Set parameters for the application component.
		@return (array)
			_filter[_data_param][post_link]
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/model/app/post-link.php
	*/
	private function get_post_link()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'previous' => '&laquo; %link',
			'next' => '%link &raquo;',
		));

	}// Method


	/**
		@access (private)
			Set parameters for the application component.
		@return (array)
			_filter[_data_param][search]
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/model/app/search.php
	*/
	private function get_search()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'class'	 => 'sidebar',
			'overlay' => TRUE,
		));

	}// Method


	/**
		@access (private)
			Set parameters for the application component.
		@return (array)
			_filter[_data_param][share]
		@reference
			[Parent]/inc/customizer/option.php
			[Parent]/inc/utility/general.php
			[Parent]/model/app/share.php
	*/
	private function get_share()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'title' => esc_html('Share This Article'),
			'skin' => __utility_get_option('skin_sns_share') ? __utility_get_option('skin_sns_share') : '',
		));

	}// Method


	/**
		@access (private)
			Set parameters for the application component.
		@return (array)
			_filter[_data_param][title]
		@reference
			[Parent]/inc/utility/general.php
			[Parent]/model/app/title.php
	*/
	private function get_title()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'needle'	 => '',
		));

	}// Method


	/**
		@access (private)
			Set parameters for the application component.
		@return (array)
			_filter[_data_param][embed_card]
		@reference
			[Parent]/inc/customizer/option.php
			[Parent]/inc/utility/general.php
			[Parent]/model/shortcode/embed-card.php
	*/
	private function get_embed_card()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'tag' => __utility_get_option('blogcard_tag') ? __utility_get_option('blogcard_tag') : 'blogcard',
			'size_w' => $this->image_size['small']['width'],
			'size_h' => $this->image_size['small']['height'],
		));

	}// Method


	/**
		@access (private)
			Set parameters for the application component.
		@return (array)
			_filter[_data_param][hatena_card]
		@reference
			[Parent]/inc/customizer/option.php
			[Parent]/inc/utility/general.php
			[Parent]/model/shortcode/hatena-card.php
	*/
	private function get_hatena_card()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'tag' => __utility_get_option('blogcard_tag') ? __utility_get_option('blogcard_tag') : 'blogcard',
			'size_w' => $this->image_size['small']['width'],
			'size_h' => $this->image_size['small']['height'],
		));

	}// Method


	/**
		@access (private)
			Set parameters for the application component.
		@return (array)
			_filter[_data_param][ogp_card]
		@reference
			[Parent]/inc/customizer/option.php
			[Parent]/inc/utility/general.php
			[Parent]/model/shortcode/ogp-card.php
	*/
	private function get_ogp_card()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'tag' => __utility_get_option('blogcard_tag') ? __utility_get_option('blogcard_tag') : 'blogcard',
			'size_w' => $this->image_size['small']['width'],
			'size_h' => $this->image_size['small']['height'],
		));

	}// Method


	/**
		@access (private)
			Set parameters for the application component.
		@return (array)
			_filter[_data_param][toc]
		@reference
			[Parent]/inc/customizer/option.php
			[Parent]/inc/utility/general.php
			[Parent]/model/shortcode/toc.php
	*/
	private function get_toc()
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'title' => esc_html__('Table of Contents','windmill'),
			'tag' => __utility_get_option('toc_tag') ? __utility_get_option('toc_tag') : 'toc',
			'min' => __utility_get_option('toc_min') ? __utility_get_option('toc_min') : 2,
		));

	}// Method


	/* Method
	_________________________
	*/
	public static function __get_setting($needle = '')
	{
		/**
			@access (public)
				Return parameter value for the application component.
			@param (string) $needle
				Application/component name.
			@return (array)
			@reference
				[Parent]/model/app/amp.php
				[Parent]/model/app/back2top.php
				[Parent]/model/app/branding.php
				[Parent]/model/app/breadcrumb.php
				[Parent]/model/app/comments.php
				[Parent]/model/app/credit.php
				[Parent]/model/app/dynamic-sidebar.php
				[Parent]/model/app/excerpt.php
				[Parent]/model/app/follow.php
				[Parent]/model/app/html-sitemap.php
				[Parent]/model/app/image.php
				[Parent]/model/app/meta.php
				[Parent]/model/app/nav.php
				[Parent]/model/app/pagination.php
				[Parent]/model/app/post-link.php
				[Parent]/model/app/search.php
				[Parent]/model/app/share.php
				[Parent]/model/app/title.php
				[Parent]/model/shortcode/embed-card.php
				[Parent]/model/shortcode/hatena-card.php
				[Parent]/model/shortcode/ogp-card.php
				[Parent]/model/shortcode/toc.php
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
// new _data_param();
_data_param::__get_instance();
