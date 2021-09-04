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
if(class_exists('_env_embed') === FALSE) :
class _env_embed
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_iframe()
 * 	set_hook()
 * 	invoke_hook()
 * 	cleanup()
 * 	embed_template()
 * 	enqueue_embed_scripts()
 * 	iframe_responsive()
 * 	remove()
 * 	wp_get_attachment_image_attributes()
 * 	wp_lazy_loading_enabled()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $iframe
			Iframe tags to display embedded content.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private $iframe = array();
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
				[Parent]/inc/utility/general.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);

		$this->iframe = $this->set_iframe();

		$this->cleanup();
		$this->wp_get_attachment_image_attributes();

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook($this->hook);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_iframe()
	{
		/**
			@access (private)
				Set the url patterns for <iframe>.
				The iframe tags to display embedded content.
			@return (array)
				_filter[_env_embed][iframe]
			@reference
				[Parent]/inc/utility/general.php
		*/

		/**
		 * @reference (WP)
		 * 	Determines whether the query is for an existing single post of any post type (post, attachment, page, custom post types).
		 * 	https://developer.wordpress.org/reference/functions/is_singular/
		*/
		if(!is_singular()){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		return apply_filters("_filter[{$class}][{$function}]",array(
			'youtube\.com',
			'vine\.co',
			'https:\/\/www\.google\.com\/maps\/embed'
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
				_filter[_env_embed][hook]
			@reference
				[Parent]/inc/setup/constant.php
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
		return apply_filters("_filter[{$class}][{$function}]",$this->set_parameter_callback(array(
			// Action
/*
			'enqueue_embed_scripts' => array(
				'tag' => 'add_action',
				'hook' => 'enqueue_embed_scripts'
			),
*/
			// Filter
			'wp_lazy_loading_enabled' => array(
				'tag' => 'add_filter',
				'hook' => 'wp_lazy_loading_enabled',
				'args' => 3
			),
/*
			'embed_template' => array(
				'tag' => 'add_filter',
				'hook' => 'embed_template'
			),
			'iframe_responsive' => array(
				'tag' => 'add_filter',
				'hook' => 'the_content'
			),
			'wp_get_attachment_image_attributes' => array(
				'tag' => 'add_filter',
				'hook' => 'wp_get_attachment_image_attributes'
			),
*/
		)));

	}// Method


	/* Method
	_________________________
	*/
	private function cleanup()
	{
		/**
			@access (private)
				Prints additional meta content in the embed template.
				https://developer.wordpress.org/reference/hooks/embed_content_meta/
				Prints scripts or data before the closing body tag in the embed template.
				https://developer.wordpress.org/reference/hooks/embed_footer/
			@return (void)
		*/
		remove_action('embed_content_meta','print_embed_comments_button');
		remove_action('embed_content_meta','print_embed_sharing_button');
		remove_action('embed_footer','print_embed_sharing_dialog');

		/**
		 * @since 1.0.1
		 * 	Turn off oEmbed auto discovery
		 * 
		 * @reference (WP)
		 * 	Filters whether to inspect the given URL for discoverable link tags.
		 * 	https://developer.wordpress.org/reference/hooks/embed_oembed_discover/
		*/
		add_filter('embed_oembed_discover','__return_false');

		/**
		 * @since 1.0.1
		 * 	Remove filter of the oEmbed result before any HTTP requests are made.
		 * 
		 * @reference (WP)
		 * 	Filters the oEmbed result before any HTTP requests are made.
		 * 	https://developer.wordpress.org/reference/hooks/pre_oembed_result/
		*/
		remove_filter('pre_oembed_result','wp_filter_pre_oembed_result');

		// for blogcard?
		remove_action('parse_query','wp_oembed_parse_query');
		remove_action('template_redirect','rest_output_link_header',12,0);

		/**
		 * @since 1.0.1
		 * 	Remove the REST API endpoint.
		 * 
		 * @reference (WP)
		 * 	Registers the oEmbed REST API route.
		 * 	https://developer.wordpress.org/reference/functions/wp_oembed_register_route/
		*/
		remove_action('rest_api_init','wp_oembed_register_route');


		/**
		 * @since 1.0.1
		 * 	Don't filter oEmbed results.
		 * 
		 * @reference (WP)
		 * 	Filters the returned oEmbed HTML.
		 * 	https://developer.wordpress.org/reference/hooks/oembed_dataparse/
		*/
		remove_filter('oembed_dataparse','wp_filter_oembed_result',10);

	}// Method


	/* Method
	_________________________
	*/
	private function wp_get_attachment_image_attributes()
	{
		/**
			@access (private)
				Filters the list of attachment image attributes.
				https://developer.wordpress.org/reference/hooks/wp_get_attachment_image_attributes/
			@param (array) $attr
				Array of attribute values for the image markup, keyed by attribute name. 
			@return (array)
		*/
		add_filter('wp_get_attachment_image_attributes',function($attr)
		{
			/**
			 * @reference (WP)
			 * 	Is the query for an embedded post?
			 * 	https://developer.wordpress.org/reference/functions/is_embed/
			*/
			if(is_embed()){
				$attr['data-no-lazy'] = '1';
			}
			return $attr;
		});

	}// Method


	/* Hook
	_________________________
	*/
	public function embed_template($template)
	{
		/**
			@access (public)
				Filter the template used for embedded posts.
				https://developer.wordpress.org/reference/hooks/embed_template/
			@param (string) $template
				Path to the template file.
			@return (string)
		*/
		if(file_exists(trailingslashit(get_template_directory()) . 'embed.php')){
			return trailingslashit(get_template_directory()) . 'embed.php';
		}

	}// Method


	/* Hook
	_________________________
	*/
	public function enqueue_embed_scripts()
	{
		/**
			@access (public)
				Fires when scripts and styles are enqueued for the embed iframe.
				https://developer.wordpress.org/reference/hooks/enqueue_embed_scripts/
			@return (void)
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/general.php
		*/
		wp_enqueue_style(self::__make_handle(),URI['style'] . 'theme/embed.css',[],__utility_get_theme_version());

	}// Method


	/* Hook
	_________________________
	*/
	public function iframe_responsive($the_content)
	{
		/**
			@access (public)
			@param (WP_Post) $the_content
			@return (WP_Post)
		*/

		/**
		 * @reference (WP)
		 * 	Determines whether the query is for an existing single post of any post type (post, attachment, page, custom post types).
		 * 	https://developer.wordpress.org/reference/functions/is_singular/
		*/
		if(!is_singular()){return;}

		foreach($this->iframe as $item){
			$pattern = '/<iframe[^>]+?' . $item . '[^<]+?<\/iframe>/is';
			$the_content = preg_replace($pattern,'<div class="iframe-responsive-container"><div class="iframe-responsive">${0}</div></div>',$the_content);
		}
		return $the_content;

	}// Method


	/* Hook
	_________________________
	*/
	public function wp_lazy_loading_enabled($default,$tag_name,$context)
	{
		/**
			@access (public)
				Filters whether to add the loading attribute to the specified tag in the specified context.
				https://developer.wordpress.org/reference/hooks/wp_lazy_loading_enabled/
			@param (string) $default
				Default value.
			@param (string) $tag_name
				The tag name.
			@param (string) $context
				Additional context, like the current filter name or the function name from where this was called.
			@return (string)
		*/
		if('iframe' === $tag_name && 'the_content' === $context){
			return FALSE;
		}
		return $default;

	}// Method


}// Class
endif;
// new _env_embed();
_env_embed::__get_instance();
