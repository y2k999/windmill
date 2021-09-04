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
 * 
 * Inspired by wp_head() cleaner WordPress Plugin
 * @link https://wordpress.org/plugins/wp-head-cleaner/
 * @author Jonathan Wilsson
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
if(class_exists('_env_media') === FALSE) :
class _env_media
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_hook()
 * 	invoke_hook()
 * 	deactivate()
 * 	jpeg_quality()
 * 	delete_attachment()
 * 	intermediate_image_sizes_advanced()
 * 	add_lazy_load_attribute()
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

		$this->deactivate();

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
				_filter[_env_media][hook]
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
			// Action
			'before_delete_post' => array(
				'tag' => 'add_action',
				'callback' => 'delete_attachment'
			),
			'intermediate_image_sizes_advanced' => array(
				'tag' => 'add_action',
				'callback' => 'intermediate_image_sizes_advanced'
			),
			// Filter
			'jpeg_quality' => array(
				'tag' => 'add_filter',
				'callback' => 'jpeg_quality',
			),
			'wp_get_attachment_image_attributes' => array(
				'tag' => 'add_filter',
				'callback' => 'wp_get_attachment_image_attributes',
				'args' => 3
			),
			'the_content' => array(
				'tag' => 'add_filter',
				'callback' => 'add_lazy_load_attribute'
			),
			'post_thumbnail_html' => array(
				'tag' => 'add_filter',
				'callback' => 'add_lazy_load_attribute'
			),
			'get_avatar' => array(
				'tag' => 'add_filter',
				'callback' => 'add_lazy_load_attribute'
			),
			'widget_text' => array(
				'tag' => 'add_filter',
				'callback' => 'add_lazy_load_attribute'
			),
			'get_image_tag' => array(
				'tag' => 'add_filter',
				'callback' => 'add_lazy_load_attribute'
			),
		)));

	}// Method


	/* Method
	_________________________
	*/
	private function deactivate()
	{
		/**
			@access (private)
			@return (void)
		*/

		/**
			@reference (WP)
				Let plugins pre-filter the image meta to be able to fix inconsistencies in the stored data.
				https://developer.wordpress.org/reference/hooks/wp_calculate_image_srcset_meta/
		*/
		add_filter('wp_calculate_image_srcset_meta','__return_null');

		/**
			@reference (WP)
				Don't print tags for web robots image preview directive.
		*/
		remove_filter('wp_robots','wp_robots_max_image_preview_large');

		/**
			@reference (WP)
				Delete medium_large thumbnail size
				http://bastiendelmare.com/blog/how-to-delete-the-default-medium_large-thumbnail-size-in-wordpress/
				When you set all the media sizes to “0”,WordPress still resize the images to a medium large (called “medium_large”) size,wich is about 768px wide. 
				This size has been added to better take advantage of responsive image support.
				But what if you have no need for responsive images,or you just don’t want the images to be resized at 768px ?
			@reference
				[Parent]/inc/setup/theme-support.php
		*/
		// update_option('medium_large_size_w','0');
		// update_option('medium_large_size_h','0');

		// iPhone6 size / Retina compatible
		//add_image_size('yslistthumb',686,412,TRUE);

	}// Method


	/* Hook
	_________________________
	*/
	public function jpeg_quality($quality)
	{
		/**
			@access (public)
				Filters the JPEG compression quality for backward-compatibility.
				https://developer.wordpress.org/reference/hooks/jpeg_quality/
			@param (int) $quality
				Quality level between 0 (low) and 100 (high) of the JPEG.
			@param (string) $context
				Context of the filter.
			@return (int)
		*/
		return 100;

	}// Method


	/* Hook
	_________________________
	*/
	public function delete_attachment($post_id = 0)
	{
		/**
			@access (public)
				Fires before a post is deleted, at the start of wp_delete_post().
				https://developer.wordpress.org/reference/hooks/before_delete_post/
			@param (int) $post_id
				Post ID.
			@return (void)
		*/
		if($post_id === 0){
			// Get current post data.
			$post = __utility_get_post_object();
			$post_id = $post->ID;
		}

		/**
		 * @reference (WP)
		 * 	Retrieve all children of the post parent ID.
		 * 	https://developer.wordpress.org/reference/functions/get_children/
		*/
		$attachments = get_children(array(
			'numberposts' => -1,
			'post_parent' => $post_id,
			'post_type' => 'attachment',
			'post_status' => 'any',
			'post_mime_type' => 'image',
		));

		/**
		 * @reference (WP)
		 * 	Checks whether the given variable is a WordPress Error.
		 * 	https://developer.wordpress.org/reference/functions/is_wp_error/
		*/
		if(is_wp_error($attachments)){
			return '';
		}

		foreach((array)$attachments as $attachment){
			/**
			 * @reference (WP)
			 * 	Trash or delete an attachment.
			 * 	https://developer.wordpress.org/reference/functions/wp_delete_attachment/
			*/
			wp_delete_attachment($attachment->ID,TRUE);
		}

	}// Method


	/* Hook
	_________________________
	*/
	public function intermediate_image_sizes_advanced($sizes)
	{
		/**
			@access (public)
				Filters the image sizes automatically generated when uploading an image.
				https://developer.wordpress.org/reference/hooks/intermediate_image_sizes_advanced/
			@param (array) $sizes
				Associative array of image sizes to be created.
			@return (array)
		*/
		unset($sizes['thumbnail']);
		unset($sizes['medium']);
		unset($sizes['large']);

		return $sizes;

	}// Method


	/* Hook
	_________________________
	*/
	public function wp_get_attachment_image_attributes($attr,$attachment,$size)
	{
		/**
			@access (public)
				Filters the list of attachment image attributes.
				https://developer.wordpress.org/reference/functions/wp_get_attachment_metadata/
			@param (array) $attr
				Array of attribute values for the image markup, keyed by attribute name.
				See wp_get_attachment_image().
			@param (WP_Post) $attachment
				Image attachment post.
			@param (string)|(array) $size
				Requested size. Image size or array of width and height values (in that order).
				Default 'thumbnail'.
			@return (array)
		*/
		if(isset($attr['class']) && FALSE !== strpos($attr['class'],'custom-logo')){
			return $attr;
		}

		$width = FALSE;
		$height = FALSE;

		if(is_array($size)){
			$width = (int) $size[0];
			$height = (int) $size[1];
		}
		elseif($attachment && is_object($attachment) && $attachment->ID){
			/**
			 * @reference (WP)
			 * 	Retrieves attachment metadata for attachment ID.
			 * 	https://developer.wordpress.org/reference/functions/wp_get_attachment_metadata/
			*/
			$meta = wp_get_attachment_metadata($attachment->ID);
			if($meta['width'] && $meta['height']){
				$width = (int) $meta['width'];
				$height = (int) $meta['height'];
			}
		}
/*
		if($width && $height){
			// Add style.
			$attr['style'] = isset($attr['style']) ? $attr['style'] : '';
			$attr['style'] = 'width: 100%; height: ' . round(100 * $height / $width,2) . '%; max-width: ' . $width . 'px; ' . $attr['style'];
		}// endif
*/
		return $attr;

	}// Method


	/* Hook
	_________________________
	*/
	public function add_lazy_load_attribute($html)
	{
		/**
			@access (public)
				Filters the HTML content for the image tag.
				https://developer.wordpress.org/reference/hooks/get_image_tag/
			@param (string) $content
				HTML content for the image.
			@return (string)
		*/
		$html = preg_replace_callback('/<img([^>]*)>/',function($matches){
			$match = rtrim ($matches[1],'/');

/*
			// Check Width
			if((strpos($match,'width=') === FALSE) || (strpos($match,'width = ') === FALSE)){
				$match .= 'width="100%" ';
			}// endif
			// Check Height
			if((strpos($match,'height=') === FALSE) || (strpos($match,'height = ') === FALSE)){
				$match .= 'height="auto" ';
			}// endif
*/
			// Check "loading" attr.
			if(strpos($match,'loading=') !== FALSE){
				// Add "lazy".
				if(strpos($match,'lazy') === FALSE){
					$match = preg_replace('/loading="([^"]*)"/','loading="$1 lazy"',$match);
				}
			}else{
				// Add "loading=lazy".
				$match .= 'loading="lazy" ';
			}
			return '<img' . $match . '>';
		},$html);

		return $html;

	}// Method


}// Class
endif;
// new _env_media();
_env_media::__get_instance();
