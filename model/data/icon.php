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
if(class_exists('_data_icon') === FALSE) :
class _data_icon
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_name()
 * 	set_html()
 * 	__markup()
 * 	__get_setting()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $_name
		@var (array) $_html
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_name = array();
	private static $_html = array();


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

		self::$_name = $this->set_name();
		self::$_html = $this->set_html();

	}// Method


	/* Setter
	_________________________
	*/
	private function set_name()
	{
		/**
			@access (private)
				Set icons for each application components.
			@return (array)
				_filter[_data_icon][name]
			@reference (Uikit)
				https://getuikit.com/docs/icon
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
			'brand' => array(
				'amazon' => 'amazon',
				'android' => 'android',
				'behance' => 'behance',
				'bitbucket' => 'bitbucket',
				'codepen' => 'codepen',
				'digg' => 'digg',
				'dribbble' => 'dribbble',
				'dropbox' => 'dropbox',
				'facebook' => 'facebook',
				'rss' => 'rss',
				'flickr' => 'flickr',
				'foursquare' => 'foursquare',
				// getpocket
				'getpocket' => 'heart',
				'github' => 'github',
				'google' => 'google',
				// hatena
				'hatena' => 'bold',
				'instagram' => 'instagram',
				// LINE
				'line' => ' comments',
				'linkedin' => 'linkedin',
				'mail' => 'mail',
				'paypal' => 'paypal',
				'pinterest' => 'pinterest',
				'reddit' => 'reddit',
				'skype' => 'skype',
				'soundcloud' => 'soundcloud',
				'spotify' => 'spotify',
				'slack' => 'slack',
				'slideshare' => 'slideshare',
				'snapchat' => 'snapchat',
				'stack-overflow' => 'stack-overflow',
				'tumblr' => 'tumblr',
				'twitter' => 'twitter',
				'uikit' => 'uikit',
				'vimeo' => 'vimeo',
				'vine' => 'vine',
				'weibo' => 'weibo',
				'wordpress' => 'wordpress',
				'yahoo' => 'yahoo',
				'youtube' => 'youtube',
			),
			'component' => array(
				'amp' => 'bolt',
				'breadcrumb' => 'home',
				'credit' => 'user',
				'search' => 'search',
				'nav' => 'bars',
				'html-sitemap' => 'list',
			),
			'meta' => array(
				'byline' => 'users',
				'on' => 'clock',
				'updated' => 'calendar',
				'cat-links' => 'link',
				'cat_links' => 'link',
				'tags-links' => 'tag',
				'tags_links' => 'tag',
				'comments-link' => 'comments',
				'comments_link' => 'comments',
			),
			'page' => array(
				'home' => 'home',
				'front-page' => 'home',
				'blog' => 'pencil',
				'contact' => 'mail',
				'html-sitemap' => 'list',
				'privacy-policy' => 'info',
				'sample-page' => 'users',
				'site-policy' => 'question',
			),
		));

	}// Method


	/* Setter
	_________________________
	*/
	private function set_html()
	{
		/**
			@access (private)
				Set html of icons.
			@return (array)
				_filter[_data_icon][html]
			@reference
				[Parent]/inc/customizer/color.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$return = array();

		foreach(self::$_name as $key => $value){
			foreach($value as $needle => $icon){
				$args = array(
					'icon' => $icon,
					// 'color' => __utility_get_color($needle),
					'size' => ($key === 'page') ? 'large' : 'small',
				);
				$return[$key][$needle] = self::__markup($args);
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
			UIkit comes with its own SVG icon system and a comprehensive library, which comprises a growing number of elegant outline icons. 
		@param (array) $args
			Additional arguments passed to this method.
		@return (string)
	*/
	private static function __markup($args = array())
	{
		if(empty($args) || !isset($args['icon'])){return;}

		$needle = $args['icon'];

		$param['uk-icon'] = 'icon: ' . $needle;

/*
		if(isset($args['color'])){
			$param['style'] = 'color: ' . $args['color'] . ';';
		}
		else{
			$param['style'] = 'color: ' . __utility_get_color($needle) . ';';
		}
*/

		// $param['class'] = 'uk-margin-small-right icon';
		$param['class'] = 'icon';

		if(isset($args['size']) && ($args['size'] === 'large')){
			$param['uk-icon'] .= '; ratio: 1.5';
		}

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup/
		*/
		$html = beans_open_markup("_icon[{$needle}]",'span',$param);
		$html .= beans_close_markup("_icon[{$needle}]",'span');

		return $html;

	}// Method


	/* Method
	_________________________
	*/
	public static function __get_setting($needle = '')
	{
		/**
			@access (public)
				Returns the requested icon html.
			@param (string) $needle
				The name of the specialised icon.
				 - meta
				 - page
				 - custom
			@return (string)
			@reference
				[Parent]/controller/structure/header.php
				[Parent]/inc/env/content.php
				[Parent]/inc/utility/theme.php
				[Parent]/model/app/amp.php
				[Parent]/model/app/credit.php
				[Parent]/model/app/follow.php
				[Parent]/model/app/pagination.php
				[Parent]/model/app/share.php
		*/
		if(!$needle){return;}

		switch($needle){
			case 'meta' :
				return self::$_html['meta'];
				break;

			case 'page' :
				return self::$_html['page'];
				break;

			default :
				if(array_key_exists($needle,self::$_name['brand'])){
					return self::$_html['brand'][$needle];
					break;
				}
				elseif(array_key_exists($needle,self::$_name['component'])){
					return self::$_html['component'][$needle];
					break;
				}
				else{
					return self::__markup(['icon' => $needle]);
					break;
				}
				break;
		}

	}// Method


}// Class
endif;
// new _data_icon();
_data_icon::__get_instance();
