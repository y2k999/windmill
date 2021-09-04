<?php
/**
 * Adds a new post shortcode.
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


/* Exec
______________________________
*/
if(class_exists('_shortcode_embed_card') === FALSE) :
class _shortcode_embed_card
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_param()
 * 	set_default()
 * 	wp_embed_register_handler()
 * 	get_handler_regex()
 * 	get_handler_callback()
 * 	markup()
 * 	do_shortcode()
 * 	set_site()
 * 	set_post()
 * 	get_cache()
 * 	get_title()
 * 	get_description()
 * 	get_image()
 * 	get_excerpt()
 * 	get_thumbnail()
 * 	get_link()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/identifier with prefix.
		@var (string) $_index
			Name/identifier without prefix.
		@var (array) $_param
			Parameter for the application.
		@var (array) $default
			Default arguments of this application.
		@var (array) $args
			Arguments for the application.
		@var (string) $cache_key
			Cache key for blogcard.
		@var (int) $expiration
			Time the cache expires.
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_param = array();
	private $default = array();
	private $args = array();
	private $cache_key = '';
	private $expiration = '';

	/**
	 * Traits.
	*/
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
				[Parent]/inc/customizer/option.php
				[Parent]/inc/trait/singleton.php
				[Parent]/inc/utility/general.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);
		self::$_param = $this->set_param(self::$_index);

		$this->default = $this->set_default();

		// Cache key for blogcard.
		$this->cache_key = get_template() . '_' . self::$_class;

		// Expiration date time for blogcard.
		$this->expiration = WEEK_IN_SECONDS;

		// Register hooks.
		$this->wp_embed_register_handler();

		/**
		 * @since 1.0.1
		 * 	Echo post content in blogcard format.
		 * @reference
		 * 	[Parent]/controller/shortcode.php
		 * @reference (WP)
		 * 	Adds a new shortcode.
		 * 	https://developer.wordpress.org/reference/functions/add_shortcode/
		*/
		add_shortcode(self::$_param['tag'],[$this,'do_shortcode']);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_default()
	{
		/**
			@access (private)
				Set the default parameter values for the blogcard.
			@return (array)
				_filter[_shortcode_blogcard][default]
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
			'url' => '',
			'title' => '',
			'description' => '',
			// <img src="" />
			'img_src' => '',
			'size' => 'post-thumbnail',
			'target' => '_blank',
			// 'visible' => TRUE,
			'domain' => '',
			// blank or disable.
			'cache' => '',
		));

	}// Method


	/* Method
	_________________________
	*/
	private function wp_embed_register_handler()
	{
		/**
			@access (private)
				Registers an embed handler.
				https://developer.wordpress.org/reference/functions/wp_embed_register_handler/
			@param (string) $id
				An internal ID/name for the handler.
				Needs to be unique.
			@param (string) $regex
				The regex that will be used to see if this handler should be used for a URL.
			@param (callable) $callback
				The callback function that will be called if the regex is matched.
			@param (int) $priority
				Used to specify the order in which the registered handlers will be tested.
				Default value: 10
			@return (void)
		*/
		wp_embed_register_handler(self::$_param['tag'],$this->get_handler_regex(),[$this,'get_handler_callback']);

	}// Method


	/**
		@access (private)
			The regex that will be used to see if this handler should be used for a URL.
		@return (void)
			Get url patterns for converting.
	*/
	private function get_handler_regex()
	{
		/**
		 * @reference (WP)
		 * 	Returns the initialized WP_oEmbed object.
		 * 	https://developer.wordpress.org/reference/functions/_wp_oembed_get_object/
		*/
		$oembed = _wp_oembed_get_object();
		$providers = array_keys($oembed->providers);

		// Delete delimiters
		foreach($providers as $key => $value){
			$providers[$key] = preg_replace('/^#(.+)#.*$/','$1',$value);
		}
		return '#^(?!.*(' . implode('|',$providers) . '))https?://.*$#i';

	}// Method


	/* Method
	_________________________
	*/
	public function get_handler_callback($matches,$attr,$url,$rawattr)
	{
		/**
			@access (public)
				The callback function that will be called if the regex is matched.
			@param (array) $matches
				The RegEx matches from the provided regex when calling wp_embed_register_handler().
			@param (array) $attr
				Embed attributes.
			@param (string) $url
				The original URL that was matched by the regex.
			@param (string) $rawattr
				The original unmodified attributes.
			@return (string)
				The embed HTML.
				shortcode for blogcard.
		*/
		$embed = '[' . self::$_param['tag'] . ' url="' . $url . '"]';

		/**
		 * @reference (WP)
		 * 	Determines whether the current request is for an administrative interface page.
		 * 	https://developer.wordpress.org/reference/functions/is_admin/
		*/
		if(is_admin()){
			// Extract the shortcode in the editor.
			$embed = $this->markup($url);
		}
		return $embed;

	}// Method


	/**
		@access (private)
			Extract the shortcode in the editor.
		@param (string) $url
		@return (string)
		@reference
			[Parent]/inc/utility/general.php
	*/
	private function markup($url)
	{
		/**
			@reference (WP)
				Adds a new shortcode.
				https://developer.wordpress.org/reference/functions/add_shortcode/
		*/
		add_shortcode(self::$_param['tag'],[$this,'do_shortcode']);

		$html = __utility_do_shortcode(self::$_param['tag'],array(
			'url' => $url,
			'cache' => 'disable',
		),NULL,FALSE);

		$html = str_replace('<a ','<span ',$html);
		$html = str_replace('</a>','</span>',$html);

		return $html;

	}// Method


	/* Method
	_________________________
	*/
	public function do_shortcode($atts)
	{
		/**
			@access (public)
				Search content for shortcodes and filter shortcodes through their hooks.
				https://developer.wordpress.org/reference/functions/do_shortcode/
			@param (array) $atts
				Content to search for shortcodes.
			@return (string)
				Content with shortcodes filtered out.
			@reference
				[Parent]/inc/setup/constant.php
		*/

		/**
		 * @reference (WP)
		 * 	Combine user attributes with known attributes and fill in defaults when needed.
		 * 	https://developer.wordpress.org/reference/functions/shortcode_atts/
		*/
		$this->args = shortcode_atts($this->default,$atts);
		if(empty($this->args['url'])){
			return '';
		}

		/**
		 * @reference (WP)
		 * 	Validate a URL for safe use in the HTTP API.
		 * 	https://developer.wordpress.org/reference/functions/wp_http_validate_url/
		*/
		if(!wp_http_validate_url($this->args['url'])){
			return $this->get_link($this->args['url']);
		}

		/**
		 * @reference (WP)
		 * 	Examine a URL and try to determine the post ID it represents.
		 * 	https://developer.wordpress.org/reference/functions/url_to_postid/
		*/
		$post_id = url_to_postid($this->args['url']);

		// Build link data.
		if($post_id){
			$this->set_post($post_id);
		}
		else{
			if(!$this->set_site($this->args['url'])){
				return $this->get_link($this->args['url']);
			}
		}

		if(!empty($this->args['target'])){
			$this->args['target'] = ' target="' . $this->args['target'] . '"';
		}

		ob_start();
		get_template_part(SLUG['item'] . self::$_param['tag'],NULL,$this->args);

		/**
		 * @reference (WP)
		 * 	Adds rel="noopener" to all HTML A elements that have a target.
		 * 	https://developer.wordpress.org/reference/functions/wp_targeted_link_rel/
		*/
		return wp_targeted_link_rel(ob_get_clean());

	}// Method


	/**
		@access (private)
		@param (string) $url
			Request URL.
		@return (bool)
		@reference
			[Parent]/inc/utility/theme.php
	*/
	private function set_site($url)
	{
		$this->args['post_id'] = 0;

		// Get blogcard content from cache.
		$cache = $this->get_cache(['url' => $url]);
		if('disable' === $this->args['cache']){
			$cache = FALSE;
		}

		$remote = array();
		if($cache){
			foreach($cache as $key => $value){
				$remote[$key] = $value;
			}
		}
		else{
			/**
			 * @reference (WP)
			 * 	Performs an HTTP request using the GET method and returns its response.
			 * 	https://developer.wordpress.org/reference/functions/wp_remote_get/
			*/
			$response = wp_remote_get($url);
			if(is_array($response) && (200 === $response['response']['code'])){
				$remote['title'] = $this->get_title($response['body']);
				$remote['description'] = $this->get_description($response['body']);
				$remote['image'] = $this->get_image($response['body']);
				if('disable' !== $this->args['cache']){
					__utility_set_cache(
						$this->cache_key,
						$remote,
						['url' => $url],
						$this->expiration
					);
				}
			}
		}

		// Title
		if(empty($this->args['title'])){
			$this->args['title'] = $remote['title'];
		}

		/**
		 * @reference (WP)
		 * 	Trims text to a certain number of words.
		 * 	https://developer.wordpress.org/reference/functions/wp_trim_words/
		*/
		if(empty($this->args['description'])){
			$this->args['description'] = wp_trim_words(html_entity_decode($remote['description']),75);
		}
		else{
			$this->args['description'] = '';
		}

		/**
		 * @reference (WP)
		 * 	A wrapper for PHP’s parse_url() function that handles consistency in the return values across PHP versions.
		 * 	https://developer.wordpress.org/reference/functions/wp_parse_url/
		*/
		if(empty($this->args['domain'])){
			$this->args['domain'] = wp_parse_url($this->args['url'],PHP_URL_HOST);
		}
		else{
			$this->args['domain'] = '';
		}

		// Thumbnail
		$this->args['img_src'] = $remote['image'];

		if(empty($this->args['title'])){
			return FALSE;
		}
		return TRUE;

	}// Method


	/**
		@access (private)
		@param (int)|(WP_Post)|(null) $post_id
			Post ID or post object.
		@return (void)
	*/
	private function set_post($post_id = 0)
	{
		// Get current post data.
		$post = __utility_get_post_object();
		if($post_id === 0){
			$post_id = $post->ID;
		}
		$this->args['post_id'] = $post_id;

		// Title
		if(empty($this->args['title'])){
			$this->args['title'] = $post->post_title;
		}

		// Thumbnail
		$this->args['img_src'] = $this->get_thumbnail($post_id);

		// Description
		if(empty($this->args['description'])){
			$this->args['description'] = $this->get_excerpt($post_id);
		}
		else{
			$this->args['description'] = '';
		}

		// A wrapper for PHP’s parse_url() function that handles consistency in the return values across PHP versions.
		if(empty($this->args['domain'])){
			$this->args['domain'] = wp_parse_url($this->args['url'],PHP_URL_HOST);
		}
		else{
			$this->args['domain'] = '';
		}

	}// Method


	/**
		@access (private)
		@param (array) $args
		@return (bool)|(mixed)
		@reference
			[Parent]/inc/utility/theme.php
	*/
	private function get_cache($args)
	{
		/**
		 * @reference (WP)
		 * 	Determines whether the current request is for an administrative interface page.
		 * 	https://developer.wordpress.org/reference/functions/is_admin/
		 * 	Determines whether the query is for a post or page preview.
		 * 	https://developer.wordpress.org/reference/functions/is_preview/
		 * 	Whether the site is being previewed in the Customizer.
		 * 	https://developer.wordpress.org/reference/functions/is_customize_preview/
		*/
		if(is_admin() || is_preview() || is_customize_preview()){
			__utility_delete_cache($this->cache_key,$args);
			return FALSE;
		}
		return __utility_get_cache($this->cache_key,$args);

	}// Method


	/**
		@access (private)
			Perform a regular expression match.
			https://www.php.net/manual/en/function.preg-match.php
		@param (string) $body
			The input string.
		@return (string)
	*/
	private function get_title($body)
	{
		if(1 === preg_match('/<title>(.+?)<\/title>/is',$body,$matches)){
			return $matches[1];
		}

		if(1 === preg_match('/<meta.+?property=["\']og:title["\'][^\/>]*?content=["\']([^"\']+?)["\'].*?\/?>/is',$body,$matches)){
			return $matches[1];
		}
		return '';

	}// Method


	/**
		@access (private)
			Perform a regular expression match.
			https://www.php.net/manual/en/function.preg-match.php
		@param (string) $body
			The input string.
		@return (string)
	*/
	private function get_description($body)
	{
		if(1 === preg_match('/<meta.+?name=["\']description["\'][^\/>]*?content=["\']([^"\']+?)["\'].*?\/?>/is',$body,$matches)){
			return $matches[1];
		}

		if(1 === preg_match('/<meta.+?property=["\']og:description["\'][^\/>]*?content=["\']([^"\']+?)["\'].*?\/?>/is',$body,$matches)){
			return $matches[1];
		}
		return '';

	}// Method


	/**
		@access (private)
			Filters the post thumbnail HTML.
			https://developer.wordpress.org/reference/hooks/post_thumbnail_html/
		@param (string) $body
		@return (string)
		@reference
			[Parent]/inc/customizer/option.php
			[Parent]/inc/utility/general.php
	*/
	private function get_image($body)
	{
		if(1 === preg_match('/<meta.+?property=["\']og:image["\'][^\/>]*?content=["\']([^"\']+?)["\'].*?\/?>/is',$body,$matches)){
			$image = $matches[1];
			/**
			 * @reference (WP)
			 * 	Validate a URL for safe use in the HTTP API.
			 * 	https://developer.wordpress.org/reference/functions/wp_http_validate_url/
			*/
			if(wp_http_validate_url($image)){
				$html = sprintf(
					'<img src="%s" width="%s" height="%s" alt="%s">',
					$image,
					self::$_param['size_w'],
					self::$_param['size_h'],
					$this->args['title']
				);
				return beans_apply_filters('post_thumbnail_html',$html,0,0,'small','');
			}
		}
		else{
			$image = __utility_get_option('media_nopost');
			$html = sprintf(
					'<img src="%s" width="%s" height="%s" alt="%s">',
				$image,
					self::$_param['size_w'],
					self::$_param['size_h'],
				$this->args['title']
			);
			return beans_apply_filters('post_thumbnail_html',$html,0,0,'small','');
		}
		return '';

	}// Method


	/**
		@access (private)
		@param (int)|(WP_Post)|(null) $post_id
			Post ID or post object.
		@return (string)
	*/
	private function get_excerpt($post_id = 0)
	{
		// Get current post data.
		$post = __utility_get_post_object();

		if($post_id === 0){
			$post_id = $post->ID;
		}
		if($post->post_excerpt){
			return $post->post_excerpt;
		}

		/**
		 * @reference (WP)
		 * 	Get extended entry info (<!--more-->).
		 * 	https://developer.wordpress.org/reference/functions/get_extended/
		*/
		$content = get_extended($post->post_content);

		/**
		 * @reference (WP)
		 * 	Remove all shortcode tags from the given content.
		 * 	https://developer.wordpress.org/reference/functions/strip_shortcodes/
		*/
		$content = strip_shortcodes($content);

		/**
		 * @reference (WP)
		 * 	Properly strip all HTML tags including script and style.
		 * 	https://developer.wordpress.org/reference/functions/wp_strip_all_tags/
		*/
		$content = wp_strip_all_tags($content,TRUE);
		$content = htmlspecialchars($content,ENT_QUOTES);

		/**
		 * @reference (WP)
		 * 	Trims text to a certain number of words.
		 * 	https://developer.wordpress.org/reference/functions/wp_trim_words/
		*/
		return wp_trim_words(html_entity_decode($content['main']),40);

	}// Method


	/**
		@access (private)
		@param (int)|(WP_Post)|(null) $post_id
			Post ID or post object.
		@return (string)
			The post thumbnail image tag.
		@reference
			[Parent]/inc/customizer/option.php
			[Parent]/inc/utility/general.php
	*/
	private function get_thumbnail($post_id = 0)
	{
		// Get current post data.
		$post = __utility_get_post_object();

		if($post_id === 0){
			$post_id = $post->ID;
		}
		// if(!$this->param['visible']){return '';}// endif

		/**
		 * @reference (WP)
		 * 	Determines whether a post has an image attached.
		 * 	https://developer.wordpress.org/reference/functions/has_post_thumbnail/
		*/
		if(!has_post_thumbnail($post_id)){
			return __utility_get_option('media_nopost');
		}

		if(!empty($this->args['img_src'])){
			return beans_apply_filters('post_thumbnail_html',$this->args['img_src'],$post_id,0,'','');
		}
		else{
			return __utility_get_option('media_nopost');
		}
/*
		$sizes = array(
			'large',
			'full',
			'medium',
			'small'
		);
		foreach($sizes as $size){
			$image = get_the_post_thumbnail($post_id,$size);
			if(!empty($image)){
				return $image;
			}
		}
		return '';
*/

	}// Method


	/**
		@access (private)
		@param (string) $url
			Requested url.
		@return (string)
			Converted content.
	*/
	private function get_link($url)
	{
		$target = '';
		if(!empty($this->args['target'])){
			$target = ' target="' . $this->args['target'] . '"';
		}

		/**
		 * @reference (WP)
		 * 	Adds rel="noopener" to all HTML A elements that have a target.
		 * 	https://developer.wordpress.org/reference/functions/wp_targeted_link_rel/
		*/
		return wp_targeted_link_rel("<a href=\"${url}\" ${target}>${url}</a>");

	}// Method


}// Class
endif;
// new _shortcode_embed_card();
_shortcode_embed_card::__get_instance();
