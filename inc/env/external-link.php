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
if(class_exists('_env_external_link') === FALSE) :
class _env_external_link
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_alink()
 * 	set_hook()
 * 	invoke_hook()
 * 	external_link()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $alink
			Parameter of <a> tag.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private $alink = array();
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
		$this->alink = $this->set_alink();

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook($this->hook);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_alink()
	{
		/**
			@access (private)
				Set the <a> tag parameters.
			@return (array)
				_filter[_env_external_link][alink]
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
			'blank' => 1,
			'nofollow' => 0,
			'img' => 0,
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
				_filter[_env_external_link][hook]
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
		return apply_filters("_filter[{$class}][{$function}]",$this->set_parameter_hook(array(
			'the_content' => array(
				'tag' => 'add_filter',
				'callback' => 'external_link'
			),
			'widget_text' => array(
				'tag' => 'add_filter',
				'callback' => 'external_link'
			),
		)));

	}// Method


	/* Hook
	_________________________
	*/
	public function external_link($content)
	{
		/**
			@access (public)
				https://thk.kanzae.net/net/wordpress/t1316/
			@param (string) $content
				Content of the current post.
			@return (string)
			@reference (WP)
				Filters the post content.
				https://developer.wordpress.org/reference/hooks/the_content/
		*/

		/**
		 * @reference (WP)
		 * 	Determines whether the current request is for an administrative interface page.
		 * 	https://developer.wordpress.org/reference/functions/is_admin/
		*/
		if(is_admin()){return;}
		// if(!is_singular()){return;}

		if(!$content){
			// Get current post data.
			$post = __utility_get_post_object();
			$content = $post->content;
		}
		preg_match_all('/<a[^>]+?href[^>]+?>/i',$content,$list);
		if(!isset($list)){return;}

		/**
		 * @reference (WP)
		 * 	Retrieves the URL for the current site where the front end is accessible.
		 * 	https://developer.wordpress.org/reference/functions/home_url/
		*/
		$url = preg_quote(rtrim(home_url(),'/') . '/','/');

		foreach(array_unique($list[0]) as $item){
			$replaced = $item;
			if(!preg_match('/href=[\'|\"]?\s?' . $url . '[^>]+?[\'|\"]/i',$item)){
				// 	target="_blank"
				if($this->alink['blank'] && !preg_match('/.+?target\s?=[\'|\"]?\s?_?blank.+?/i',$item)){
					$replaced = str_replace('>',' target="_blank">',$replaced);
				}

				// rel="nofollow"
				if($this->alink['nofollow'] && !preg_match('/.+?rel\s?=[\'|\"]?\s?nofollow\s?/i',$item)){
					$replaced = str_replace('>',' rel="nofollow">',$replaced);
				}
				$replaced = str_replace('>',' class="external ext_icon">',$replaced);

				$content = str_replace($item,$replaced,$content);
				if(!$this->alink['img']){
					$content = preg_replace('/(<a[^>]+?href[^>]+?external) ext_icon([^>]+?>\s?<\s?img[^>]+?src[^>]+?>\s?<\/a>)/is','$1$2',$content);
				}
			}
		}
		return $content;

	}// Method


}// Class
endif;
// new _env_external_link();
_env_external_link::__get_instance();
