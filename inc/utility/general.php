<?php
/**
 * Helper and utility functions.
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
/**
 * [TOC]
 * 	__utility_get_class()
 * 	__utility_get_index()
 * 	__utility_get_function()
 * 	__utility_glob()
 * 	__utility_mb_substr_replace()
 * 	__utility_markup()
 * 	__utility_do_shortcode()
 * 	__utility_get_categories()
 * 	__utility_get_terms()
 * 	__utility_get_orderby()
 * 	__utility_get_theme_version()
 * 	__utility_get_archive_url()
 * 	__utility_get_image_size()
 * 	__utility_get_format()
 * 	__utility_get_color()
 * 	__utility_get_media_query()
 * 	__utility_get_icon()
 * 	__utility_get_user_id()
 * 	__utility_get_post_type()
 * 	__utility_get_post_object()
 * 	__utility_make_handle()
 * 	__utility_is_active_plugin()
 * 	__utility_is_top_page()
 * 	__utility_is_mobile()
 * 	__utility_is_bot()
 * 	__utility_is_active_nav_menu()
 * 	__utility_is_one_column()
 * 	__utility_is_archive()
 * 	__utility_get_option()
 * 	__utility_get_value()
*/
require_once (trailingslashit(get_template_directory()) . 'inc/utility/theme.php');
require_once (trailingslashit(get_template_directory()) . 'inc/utility/sanitize.php');


	/* Method
	_________________________
	*/
	if(function_exists('__utility_get_class') === FALSE) :
	function __utility_get_class($class = '')
	{
		/**
			@access (public)
				Returns the trimmed name of the class.
			@param (string) $class
				The name of the class of an object.
				The result of get_class() PHP class.
			@return (string)
			@reference
				Used in almost all of the class files in this theme.
		*/
		if(!$class){return;}

		$exploded = explode('\\',$class);
		return strtolower(end($exploded));

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_get_index') === FALSE) :
	function __utility_get_index($class = '')
	{
		/**
			@access (public)
				Returns the name of the class without prefix.
			@param (string) $class
				The trimmed name of the class (The result of __utility_get_class()).
			@return (string)
			@reference
				Used in almost all of the class files in this theme.
				[Parent]/inc/setup/constant.php
		*/
		if(!$class){return;}

		$exploded = explode('\\',$class);
		$classname = strtolower(end($exploded));
		// $classname = str_replace('_','-',$classname);

		if(substr($classname,0,5) === PREFIX['app']){
			// return str_replace(substr($classname,0,5),'',$classname);
			$classname = str_replace(substr($classname,0,5),'',$classname);
		}
		elseif(substr($classname,0,5) === PREFIX['env']){
			$classname = str_replace(substr($classname,0,5),'',$classname);
		}
		elseif(substr($classname,0,6) === PREFIX['data']){
			$classname = str_replace(substr($classname,0,6),'',$classname);
		}
		elseif(substr($classname,0,7) === PREFIX['setup']){
			$classname = str_replace(substr($classname,0,7),'',$classname);
		}
		elseif(substr($classname,0,7) === PREFIX['theme']){
			$classname = str_replace(substr($classname,0,7),'',$classname);
		}
		elseif(substr($classname,0,7) === PREFIX['trait']){
			$classname = str_replace(substr($classname,0,7),'',$classname);
		}
		elseif(substr($classname,0,8) === PREFIX['inline']){
			$classname = str_replace(substr($classname,0,8),'',$classname);
		}
		elseif(substr($classname,0,8) === PREFIX['render']){
			$classname = str_replace(substr($classname,0,8),'',$classname);
		}
		elseif(substr($classname,0,8) === PREFIX['widget']){
			$classname = str_replace(substr($classname,0,8),'',$classname);
		}
		elseif(substr($classname,0,10) === PREFIX['fragment']){
			$classname = str_replace(substr($classname,0,10),'',$classname);
		}
		elseif(substr($classname,0,11) === PREFIX['shortcode']){
			$classname = str_replace(substr($classname,0,11),'',$classname);
		}
		elseif(substr($classname,0,11) === PREFIX['structure']){
			$classname = str_replace(substr($classname,0,11),'',$classname);
		}
		elseif(substr($classname,0,12) === PREFIX['controller']){
			$classname = str_replace(substr($classname,0,12),'',$classname);
		}
		elseif(substr($classname,0,12) === PREFIX['customizer']){
			$classname = str_replace(substr($classname,0,12),'',$classname);
		}
		else{

		}
		return str_replace('_','-',$classname);

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_get_function') === FALSE) :
	function __utility_get_function($function = '')
	{
		/**
			@access (public)
				Returns the name of the function/method without prefix.
			@param (string) $function
				The function name (__FUNCTION__).
			@return (string)
			@reference
				Used in almost all of the class files in this theme.
		*/
		if(!isset($function)){return;}

		if(preg_match("/^get_customizer_/",$function)){
			return str_replace(substr($function,0,15),'',$function);
		}
		elseif(preg_match("/^__get_customizer_/",$function)){
			return str_replace(substr($function,0,17),'',$function);
		}

		elseif(preg_match("/^do_/",$function)){
			return str_replace(substr($function,0,3),'',$function);
		}
		elseif(preg_match("/^is_/",$function)){
			return str_replace(substr($function,0,3),'',$function);
		}
		elseif(preg_match("/^get_/",$function)){
			return str_replace(substr($function,0,4),'',$function);
		}
		elseif(preg_match("/^set_/",$function)){
			return str_replace(substr($function,0,4),'',$function);
		}
		elseif(preg_match("/^the_/",$function)){
			return str_replace(substr($function,0,4),'',$function);
		}
		elseif(preg_match("/^init_/",$function)){
			return str_replace(substr($function,0,5),'',$function);
		}
		elseif(preg_match("/^check_/",$function)){
			return str_replace(substr($function,0,6),'',$function);
		}
		elseif(preg_match("/^apply_/",$function)){
			return str_replace(substr($function,0,6),'',$function);
		}
		elseif(preg_match("/^render_/",$function)){
			return str_replace(substr($function,0,7),'',$function);
		}

		elseif(preg_match("/^__do_/",$function)){
			return str_replace(substr($function,0,5),'',$function);
		}
		elseif(preg_match("/^__is_/",$function)){
			return str_replace(substr($function,0,5),'',$function);
		}
		elseif(preg_match("/^__get_/",$function)){
			return str_replace(substr($function,0,6),'',$function);
		}
		elseif(preg_match("/^__set_/",$function)){
			return str_replace(substr($function,0,6),'',$function);
		}
		elseif(preg_match("/^__the_/",$function)){
			return str_replace(substr($function,0,6),'',$function);
		}
		elseif(preg_match("/^__hook_/",$function)){
			return str_replace(substr($function,0,7),'',$function);
		}
		elseif(preg_match("/^__init_/",$function)){
			return str_replace(substr($function,0,7),'',$function);
		}
		elseif(preg_match("/^__check_/",$function)){
			return str_replace(substr($function,0,8),'',$function);
		}
		elseif(preg_match("/^__apply_/",$function)){
			return str_replace(substr($function,0,8),'',$function);
		}
		elseif(preg_match("/^__render_/",$function)){
			return str_replace(substr($function,0,9),'',$function);
		}
		else{
			return strtolower($function);
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_glob') === FALSE) :
	function __utility_glob($path)
	{
		/**
			@access (public)
			@param (string) $path
				Path to directory to glob.
			@return (bool)
				Will always return true.
			@reference
				[Parent]/inc/init.php
				[Parent]/inc/loadup.php
		*/
		$path_last = substr($path,-1);
		$path .= ($path_last !== '/') ? '/' : '';

		if(is_dir($path) && $dh = opendir($path)){
			while(($file = readdir($dh)) !== FALSE){
				if($file !== '.' && $file !== '..'){
					if(is_dir($path . $file)){
						__utility_glob($path . $file);
					}
					else{
							require_once($path . $file);
					}
				}
			}
			closedir($dh);
		}
		return TRUE;

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_mb_substr_replace') === FALSE) :
	function __utility_mb_substr_replace($str,$replace,$start,$length)
	{
		/**
			@access (public)
			@param (string) $path
				Path to directory to glob.
			@return (bool)
				Will always return true.
			@reference
				[Parent]/inc/init.php
				[Parent]/inc/loadup.php
		*/
		return mb_substr($str,0,$start) . $replace . mb_substr($str,$start + $length);

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_markup') === FALSE) :
	function __utility_markup($attr = array())
	{
		/**
			@access (public)
			@param (array) $attr
				Array of attributes.
				The array key defines the attribute name and the array value defines the attribute value.
			@return (string)
				HTML strings.
			@reference
				[Parent]/controller/layout.php
		*/
		if(empty($attr)){return;}

		$return = '';

		/**
		 * @reference
		 * 	Cycle through attributes,build tag attribute string.
		 * 	https://www.wecodeart.com/
		*/
		foreach($attr as $key => $value){
			if($value === TRUE){
				$return .= esc_html($key) . ' ';
			}
			else{
				$return .= sprintf('%s="%s" ',esc_html($key),esc_attr($value));
			}
		}
		return trim($return);

	}//Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_do_shortcode') === FALSE) :
	function __utility_do_shortcode($needle,$param = array(),$content = NULL,$echo = TRUE)
	{
		/**
			@access (public)
				Search content for shortcodes and filter shortcodes through their hooks.
				https://developer.wordpress.org/reference/functions/do_shortcode/
			@param (string) $needle
			@param (array) $param
			@param (mixed) $content
				Content to search for shortcodes.
			@param (bool) $echo
			@return (string)
			@reference
				[Parent]/inc/env/blogcard.php
		*/
		$atts = array();

		// Extract parameter.
		if(!empty($param)){
			foreach($param as $key => $value){
				if(is_array($value)){
					$value = implode(',',$value);
				}
				$atts[] = sprintf('%s="%s"',$key,$value);
			}
		}
		$atts = empty($atts) ? '' : ' ' . implode(' ',$atts);

		// Build shortcode.
		if(NULL === $content){
			$shortcode = sprintf('[%s%s]',$needle,$atts);
		}
		else{
			$shortcode = sprintf('[%s%s]%s[/%s]',$needle,$atts,$content,$needle);
		}
		$html = do_shortcode($shortcode);

		if($echo){
			echo $html;
			return '';
		}
		else{
			return $html;
		}

	}//Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_get_post_types') === FALSE) :
	function __utility_get_post_types()
	{
		/**
			@access (public)
				Get a list of all registered post type objects.
				https://developer.wordpress.org/reference/functions/get_post_types/
			@param (array)|(string) $args
				An array of key => value arguments to match against the post type objects.
			@param (string) $output
				The type of output to return.
				Accepts post type 'names' or 'objects'.
			@param (string) $operator
				The logical operation to perform.
				 - 'or' means only one element from the array needs to match;
				 - 'and' means all elements must match;
				 - 'not' means no elements may match.
			@return (string[])|(WP_Post_Type[])
				An array of post type names or objects.
			@reference
				[Parent]/inc/env/archive.php
				[Parent]/inc/env/xml-sitemap.php
		*/
		$return = array(
			'post',
			'page',
		);

		/**
		 * @since 1.0.1
		 * 	bbPress.
		 * 	https://ja.wordpress.org/plugins/bbpress/
		*/
		if(!__utility_is_active_plugin('bbpress/bbpress.php')){
			$return[] = 'forum';
			$return[] = 'topic';
		}

		/**
		 * @since 1.0.1
		 * 	WooCommerce
		 * 	https://ja.wordpress.org/plugins/woocommerce/
		*/
		if(!__utility_is_active_plugin('woocommerce/woocommerce.php')){
			$return[] = 'product';
			$return[] = 'shop_order';
			$return[] = 'shop_coupon';
			$return[] = 'shop_webhook';
		}
		return $return;

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_get_categories') === FALSE) :
	function __utility_get_categories()
	{
		/**
			@access (public)
				Retrieves a list of category objects.
				https://developer.wordpress.org/reference/functions/get_categories/
			@return (array)
				List of categories.
			@reference
				[Parent]/inc/env/xml-sitemap.php
		*/
		$return = array();
		$categories = get_categories();
		foreach($categories as $category){
			$return[$category->slug] = $category->name;
		}
		return $return;

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_get_terms') === FALSE) :
	function __utility_get_terms($taxonomy = '')
	{
		/**
			@access (public)
				Retrieves the terms in a given taxonomy or list of taxonomies.
				https://developer.wordpress.org/reference/functions/get_terms/
			@param (string) $taxonomy
			@return (array)
				List of terms.
			@reference
				[Parent]/inc/env/xml-sitemap.php
		*/
		if(!isset($taxonomy)){return;}

		$terms = get_terms($taxonomy);
		if(!empty($terms) && !is_wp_error($terms)){
			foreach($terms as $term){
				$return[$term->slug] = $term->name;
			}
		}
		return $return;

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_get_orderby') === FALSE) :
	function __utility_get_orderby()
	{
		/**
			@access (public)
				Returns column to use for ordering.
			@return (array)
			@reference (WP)
				Sort retrieved posts by parameter.
				Defaults to ‘date (post_date)’.
				https://developer.wordpress.org/reference/classes/wp_query/#order-orderby-parameters
			@reference
				[Parent]/model/widget/relation.php
		*/
		return array(
			'author' => esc_html__('Author','windmill'),
			'comment_count' => esc_html__('Number of Comments','windmill'),
			'date' => esc_html__('Date','windmill'),
			'ID' => esc_html__('Post ID','windmill'),
			'menu_order' => esc_html__('Page Order','windmill'),
			'modified' => esc_html__('Last Modified Date','windmill'),
			'name' => esc_html__('Post Name','windmill'),
			'parent' => esc_html__('Post/Page Parent ID','windmill'),
			'rand' => esc_html__('Random Order','windmill'),
			'title' => esc_html__('Title','windmill'),
			'type' => esc_html__('Post Type','windmill'),
		);

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(!function_exists('__utility_get_theme_version')) :
	function __utility_get_theme_version($template = FALSE)
	{
		/**
			@access (public)
				WP_Theme Class.
				https://developer.wordpress.org/reference/classes/wp_theme/
			@param (bool) $template
				Name of the current theme.
			@return (string)
				The version of the theme.
			@reference
				[Parent]/inc/customizer/setup.php
				[Parent]/inc/env/embed.php
				[Parent]/inc/env/enqueue.php
				[Parent]/inc/env/gutenberg.php
				[Parent]/inc/setup/admin.php
		*/

		/**
		 * @reference (WP)
		 * 	Gets a WP_Theme object for a theme.
		 * 	https://developer.wordpress.org/reference/functions/wp_get_theme/
		*/
		$theme = wp_get_theme();

		/**
		 * @reference (WP)
		 * 	Retrieves name of the current theme.
		 * 	https://developer.wordpress.org/reference/functions/get_template/
		 * 	Retrieves name of the current stylesheet.
		 * 	https://developer.wordpress.org/reference/functions/get_stylesheet/
		*/
		if($template && get_template() != get_stylesheet()){
			// Parent theme.
			$theme = wp_get_theme(get_template());
		}
		return $theme->Version;

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_get_archive_url') === FALSE) :
	function __utility_get_archive_url()
	{
		/**
			@access (public)
				http://notnil-creative.com/blog/archives/2259
				https://wemo.tech/1161
			@return (string)
				Archive page url.
			@reference
				[Parent]/model/app/title.php
		*/
		if(!is_archive()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_archive/
			*/
			return FALSE;
		}

		if(is_category()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing category archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_category/
			 * 	Retrieves the currently queried object.
			 * 	https://developer.wordpress.org/reference/functions/get_queried_object/
			*/
			$post_terms = get_queried_object();

			/**
			 * @reference (WP)
			 * 	Retrieves category link URL.
			 * 	https://developer.wordpress.org/reference/functions/get_category_link/
			*/
			return empty($post_terms) ? '#' : get_category_link($post_terms->term_id);
		}
		elseif(is_tag()){
			$post_terms = get_queried_object();
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing tag archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_tag/
			 * 	Retrieves the link to the tag.
			 * 	https://developer.wordpress.org/reference/functions/get_tag_link/
			*/
			return empty($post_terms) ? '#' : get_tag_link($post_terms->term_id);
		}
		elseif(is_tax()){
			$post_terms = get_queried_object();
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing custom taxonomy archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_tax/
			 * 	Generate a permalink for a taxonomy term archive.
			 * 	https://developer.wordpress.org/reference/functions/get_term_link/
			*/
			return empty($post_terms) ? '#' : get_term_link($post_terms,$post_terms->taxonomy);
		}
		elseif(is_post_type_archive()){
			$post_type = get_query_var('post_type');
			$post_type = (is_array($post_type)) ? reset($post_type) : $post_type;
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing post type archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_post_type_archive/
			 * 	Retrieves the permalink for a post type archive.
			 * 	https://developer.wordpress.org/reference/functions/get_post_type_archive_link/
			*/
			return get_post_type_archive_link($post_type);
		}
		elseif(is_author()){
			$author_id = get_query_var('author');
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing author archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_author/
			 * 	Retrieve the URL to the author page for the user with the ID provided.
			 * 	https://developer.wordpress.org/reference/functions/get_author_posts_url/
			 * 	Retrieves the requested data of the author of the current post.
			 * 	https://developer.wordpress.org/reference/functions/get_the_author_meta/
			*/
			return !isset($author_id) ? '#' : esc_url(get_author_posts_url(get_the_author_meta('ID',$author_id)));
		}
		elseif(is_date()){
			if(is_day()) :
				/**
				 * @reference (WP)
				 * 	Determines whether the query is for an existing day archive.
				 * 	https://developer.wordpress.org/reference/functions/is_day/
				 * 	Retrieves the permalink for the day archives with year and month.
				 * 	https://developer.wordpress.org/reference/functions/get_day_link/
				*/
				return get_day_link(get_query_var('year'),get_query_var('monthnum'),get_query_var('day'));
			elseif(is_month()) :
				/**
				 * @reference (WP)
				 * 	Determines whether the query is for an existing month archive.
				 * 	https://developer.wordpress.org/reference/functions/is_month/
				 * 	Retrieves the permalink for the month archives with year.
				 * 	https://developer.wordpress.org/reference/functions/get_month_link/
				*/
				return get_month_link(get_query_var('year'),get_query_var('monthnum'));
			elseif(is_year()) :
				/**
				 * @reference (WP)
				 * 	Determines whether the query is for an existing year archive.
				 * 	https://developer.wordpress.org/reference/functions/is_year/
				 * 	Retrieves the permalink for the year archives.
				 * 	https://developer.wordpress.org/reference/functions/get_year_link/
				*/
				return get_year_link(get_query_var('year'));
			endif;
		}
		elseif(is_search()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for a search.
			 * 	https://developer.wordpress.org/reference/functions/is_search/
			 * 	Retrieves the permalink for a search.
			 * 	https://developer.wordpress.org/reference/functions/get_search_link/
			*/
			return get_search_link();
		}
		else{
			$post_terms = get_queried_object();
			return get_permalink($post_terms->ID);
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_get_image_size') === FALSE) :
	function __utility_get_image_size($needle = '')
	{
		/**
			@access (public)
			@global (array) $_wp_additional_image_sizes
				Additional images size data.
			@param (string) $needle
				Image size.
				Accepts any registered image size name, or an array of width and height values in pixels (in that order).
				Default 'medium'.
			@return (array)
			@reference
				[Parent]/inc/setup/theme-setup.php
				[Parent]/model/app/image.php
		*/

		// WP global.
		global $_wp_additional_image_sizes;
	
		$sizes = array();

		/**
		 * @reference (WP)
		 * 	Gets the available intermediate image size names.
		 * 	https://developer.wordpress.org/reference/functions/get_intermediate_image_sizes/
		*/
		$get_intermediate_image_sizes = get_intermediate_image_sizes();
	
		// Create the full array with sizes and crop info
		foreach($get_intermediate_image_sizes as $size){
			if(in_array($size,array('thumbnail','medium','medium_large','large'))){
				$sizes[$size]['width'] = get_option($size . '_size_w');
				$sizes[$size]['height'] = get_option($size . '_size_h');
				$sizes[$size]['crop'] = (bool) get_option($size . '_crop');
			}
			elseif(isset($_wp_additional_image_sizes[$size])){
				$sizes[$size] = array( 
					'width' => $_wp_additional_image_sizes[$size]['width'],
					'height' => $_wp_additional_image_sizes[$size]['height'],
					'crop' => $_wp_additional_image_sizes[$size]['crop']
				);
			}
		}

		// Get only 1 size if found
		if($needle){
			if(isset($sizes[$needle])){
				return $sizes[$needle];
			}
			else{
				return FALSE;
			}
		}

		// Get all
		return $sizes;

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_get_format') === FALSE) :
	function __utility_get_format()
	{
		/**
			@access (public)
				Returns application formats used in this theme.
			@return (array)
			@reference
				[Parent]/model/widget/recent.php
				[Parent]/model/widget/relation.php
		*/
		return array(
			'general' => esc_html__('General','windmill'),
			'list' => esc_html__('List','windmill'),
			'gallery' => esc_html__('Gallery','windmill'),
			'card' => esc_html__('Card','windmill'),
		);

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_get_color') === FALSE) :
	function __utility_get_color($needle = '')
	{
		/**
			@access (public)
			@param (string) $needle
			@return (string)
				Color code.
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/customizer/color.php
				[Parent]/inc/utility/general.php
				[Parent]/model/data/icon.php
		*/
		if(!isset($needle)){
			return __utility_get_option('color_link');
		}
		else{
			if(isset(COLOR[$needle])){
				return COLOR[$needle];
			}
			else{
				$random = array_rand(COLOR,1);
				return COLOR[$random];
			}
		}

	}//Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_get_media_query') === FALSE) :
	function __utility_get_media_query($needle = '')
	{
		/**
			@access (public)
				Get our media queries.
			@param (string) $needle
				Name of the media query.
			@return (string)|(array)
				The full media query.
			@reference
				[Parent]/asset/inline/base.php
		*/
		$default = array(
			'xlarge' => '(min-width: 1601px)',
			'large' => '(min-width: 1201px) and (max-width: 1599px)',
			'medium' => '(min-width: 961px) and (max-width: 1200px)',
			'small' => '(min-width: 641px) and (max-width: 960px)',
			'xsmall' => '(max-width: 640px)',
		);

		if(!isset($needle)){
			return $default;
		}
		else{
			if($default[$needle]){
				return $default[$needle];
			}
			else{
				return FALSE;
			}
		}

	}//Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_get_icon') === FALSE) :
	function __utility_get_icon($needle = '')
	{
		/**
			@access (public)
				Get the icon html.
			@param (string) $needle
				The name of the icon.
			@return (string)
				Return the designated icon html.
			@reference
				[Parent]/model/data/icon.php
		*/
		if(is_callable(['_data_icon','__get_setting'])){
			return _data_icon::__get_setting($needle);
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_get_user_id') === FALSE) :
	function __utility_get_user_id()
	{
		/**
			@access (public)
				Get the user id.
			@global (WP_Post) $post
				https://codex.wordpress.org/Global_Variables
			@return (int)
				User ID
			@reference
				[Parent]/inc/customizer/default.php
				[Parent]/inc/env/json-ld.php
				[Parent]/model/app/meta.php
				[Parent]/model/widget/profile.php
		*/

		// WP global
		global $post;

		if($post){
			/**
			 * @reference (WP)
			 * 	Retrieve user info by user ID.
			 * 	https://developer.wordpress.org/reference/functions/get_userdata/
			*/
			$user = isset($post->post_author) ? get_userdata($post->post_author) : '';
			$user_id = isset($user->ID) ? $user->ID : 1;
		}
		else{
			$user_id = 1;
		}

		return $user_id;

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_get_post_type') === FALSE) :
	function __utility_get_post_type()
	{
		/**
			@access (public)
				Retrieves current post data.
			@global (WP_Post) $post
			@global (WP_Query) $wp_query
				https://codex.wordpress.org/Global_Variables
			@return (WP_Post)
				Current post data
			@reference
				[Parent]/controller/structure/single.php
		*/

		// WP global
		global $wp_query;

		/**
			@reference (WP)
				Retrieves the post type of the current post or of a given post.
				https://developer.wordpress.org/reference/functions/get_post_type/
		*/
		$post_type = get_post_type();
		if(!$post_type){
			if(isset($wp_query->query['post_type'])){
				$post_type = $wp_query->query['post_type'];
			}
		}
		return $post_type;

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_get_post_object') === FALSE) :
	function __utility_get_post_object()
	{
		/**
			@access (public)
				Retrieves current post data.
			@global (WP_Post) $post
			@global (WP_Query) $wp_query
				https://codex.wordpress.org/Global_Variables
			@return (WP_Post)
				Current post data
			@reference
				[Parent]/controller/structure/single.php
		*/

		// WP global
		global $post;

		if(!$post){
			global $wp_query;
			/**
			 * @reference (WP)
			 * 	Retrieves post data given a post ID or post object.
			 * 	https://developer.wordpress.org/reference/functions/get_post/
			*/
			if($wp_query->post){
				$post = get_post($wp_query->post->ID);
			}
		}
		return $post;

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_make_handle') === FALSE) :
	function __utility_make_handle($additional = '')
	{
		/**
			@access (public)
				Returns script handle
			@param (string) $additional
				Additional string. Must be unique.
			@return (string)
				Name of the script. Should be unique.
			@reference
		*/
		$handle = get_stylesheet();

		/**
		 * @reference (WP)
		 * 	Whether a child theme is in use.
		 * 	https://developer.wordpress.org/reference/functions/is_child_theme/
		*/
		if(is_child_theme()){
			$handle = get_template();
		}

		if(isset($additional)){
			if($additional === $handle){
				// $handle = $additional;
			}
			else{
				$additional = str_replace('_','-',$additional);
				$handle .= '-' . $additional;
				// $handle .= $class . '-' . $additional;
				// $handle .= '-' . self::$_index . '-' . $additional;
			}
		}
		else{
			$handle .= chr(mt_rand(97,122));
			// $handle .= '-' . self::$_index;
		}

		return $handle;

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(!function_exists('__utility_is_active_plugin')) :
	function __utility_is_active_plugin($file)
	{
		/**
			@access (public)
				Determines whether a plugin is active.
				https://developer.wordpress.org/reference/functions/is_plugin_active/
			@usage
				__is_plugin_active('hello.php');
				__is_plugin_active('akismet/akismet.php');
			@param (string) $file
				Path to the plugin file relative to the plugins directory.
			@return (bool)
				True, if in the active plugins list. False, not in the list.
			@reference
				[Parent]/inc/env/archive.php
				[Parent]/inc/plugin/google/analytics.php
				[Parent]/inc/setup/admin.php
				[Parent]/model/app/amp.php
		*/
		$return = FALSE;

		/**
		 * @reference (WP)
		 * 	Retrieve an array of active and valid plugin files.
		 * 	https://developer.wordpress.org/reference/functions/wp_get_active_and_valid_plugins/
		*/
		foreach((array)get_option('active_plugins') as $item){
			if(preg_match('/' . preg_quote($file,'/') . '/i',$item)){
				$return = TRUE;
				break;
			}
		}
		return $return;

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_is_top_page') === FALSE) :
	function __utility_is_top_page()
	{
		/**
			@access (public)
				What to show on the front page.
				https://codex.wordpress.org/Option_Reference
			@return (bool)
			@reference
				[Parent]/controller/structure/page.php
		*/
		if('page' === get_option('show_on_front')){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for the front page of the site.
			 * 	https://developer.wordpress.org/reference/functions/is_front_page/
			*/
			if(is_front_page()){
				return TRUE;
			}
		}

		/**
		 * @reference (WP)
		 * 	Determines whether the query is for the blog homepage.
		 * 	https://developer.wordpress.org/reference/functions/is_home/
		 * 	Determines whether the query is for a paged result and not for the first page.
		 * 	https://developer.wordpress.org/reference/functions/is_paged/
		*/
		if((is_home() || is_front_page()) && !is_paged()){
			return TRUE;
		}
		return FALSE;

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_is_mobile') === FALSE) :
	function __utility_is_mobile()
	{
		/**
			@access (public)
				 - iPhone
				 - iPod touch
				 - 1.5+ Android *** Only mobile
				 - *** Windows Phone
				 - Pre 1.5 Android
				 - 1.5+ Android
				 - Storm
				 - Storm v2
				 - Torch
				 - Palm Pre Experimental
				 - Other iPhone browser
			@global HTTP_USER_AGENT
				Contents of the User-Agent: header from the current request, if there is one.
				https://www.php.net/manual/en/reserved.variables.server.php
			@return (bool)
		*/
		$useragent[] = 'iPhone';
		$useragent[] = 'iPod';
		$useragent[] = 'Android.*Mobile';
		$useragent[] = 'Windows.*Phone';
		$useragent[] = 'dream';
		$useragent[] = 'CUPCAKE';
		$useragent[] = 'blackberry9500';
		$useragent[] = 'blackberry9530';
		$useragent[] = 'blackberry9520';
		$useragent[] = 'blackberry9550';
		$useragent[] = 'blackberry9800';
		$useragent[] = 'webOS';
		$useragent[] = 'incognito';
		$useragent[] = 'webmate';

		$pattern = '/' . implode('|',$useragent) . '/i';
		return preg_match($pattern,$_SERVER['HTTP_USER_AGENT']);

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_is_bot') === FALSE) :
	function __utility_is_bot()
	{
		/**
			@access (public)
				https://f-af.com/ninki-kiji-widget-get-pv/
			@global HTTP_USER_AGENT
				Contents of the User-Agent: header from the current request, if there is one.
				https://www.php.net/manual/en/reserved.variables.server.php
			@return (bool)
		*/
		foreach(array(
			'Googlebot',
			'Yahoo! Slurp',
			'Mediapartners-Google',
			'msnbot',
			'bingbot',
			'MJ12bot',
			'Ezooms',
			'pirst; MSIE 8.0;',
			'Google Web Preview',
			'ia_archiver',
			'Sogou web spider',
			'Googlebot-Mobile',
			'AhrefsBot',
			'YandexBot',
			'Purebot',
			'Baiduspider',
			'UnwindFetchor',
			'TweetmemeBot',
			'MetaURI',
			'PaperLiBot',
			'Showyoubot',
			'JS-Kit',
			'PostRank',
			'Crowsnest',
			'PycURL',
			'bitlybot',
			'Hatena',
			'facebookexternalhit',
			'NINJA bot',
			'YahooCacheSystem',
		) as $item){
			if(stripos($_SERVER['HTTP_USER_AGENT'],$item) !== FALSE){
				return TRUE;
				break;
			}
		}
		return FALSE;

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_is_active_nav_menu') === FALSE) :
	function __utility_is_active_nav_menu($location)
	{
		/**
			@access (public)
			@param (string) $location
				Menu location identifier.
			@return (bool)
		*/

		/**
		 * @reference (WP)
		 * 	Determines whether a registered nav menu location has a menu assigned to it.
		 * 	https://developer.wordpress.org/reference/functions/has_nav_menu/
		*/
		if(has_nav_menu($location)){
			/**
			 * @reference (WP)
			 * 	Retrieves all registered navigation menu locations and the menus assigned to them.
			 * 	https://developer.wordpress.org/reference/functions/get_nav_menu_locations/
			*/
			$locations = get_nav_menu_locations();

			/**
			 * @reference (WP)
			 * 	Retrieves all menu items of a navigation menu.
			 * 	https://developer.wordpress.org/reference/functions/wp_get_nav_menu_items/
			*/
			$menu = wp_get_nav_menu_items($locations[$location]);
			if(!empty($menu)){
				return TRUE;
			}
		}
		return FALSE;

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_is_one_column') === FALSE) :
	function __utility_is_one_column()
	{
		/**
			@access (public)
			@return (bool)
			@reference
				[Parent]/controller/structure/sidebar.php
				[Parent]/inc/setup/widget-area.php
				[Parent]/inc/utility/theme.php
				[Plugin]/beans_extension/admin/tab/layout.php
		*/
		$return = FALSE;

		/**
		 * @reference (WP)
		 * 	Test if the current browser runs on a mobile device (smart phone, tablet, etc.)
		 * 	https://developer.wordpress.org/reference/functions/wp_is_mobile/
		*/
		if(wp_is_mobile()){
			$return = TRUE;
		}

		if(__utility_is_beans('widget')){
			/**
			 * @reference (Beans)
			 * 	Check whether a widget area is in use.
			 * 	https://www.getbeans.io/code-reference/functions/beans_is_active_widget_area/
			*/
			if(!beans_is_active_widget_area('sidebar_primary') && !beans_is_active_widget_area('sidebar_secondary')){
				$return = TRUE;
			}
		}
		else{
			/**
			 * @reference (WP)
			 * 	Determines whether a sidebar contains widgets.
			 * 	https://developer.wordpress.org/reference/functions/is_active_sidebar/
			*/
			if(!is_active_sidebar('sidebar_primary') && !is_active_sidebar('sidebar_secondary')){
				$return = TRUE;
			}
		}
		return $return;

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_is_archive') === FALSE) :
	function __utility_is_archive()
	{
		/**
			@access (public)
				https://meshikui.com/2018/06/26/279/
				https://web-kiwami.com/wordpress-is_search-true.html
			@return (bool)
			@reference
				[Parent]/asset/inline/base.php
				[Parent]/controller/fragment/excerpt.php
				[Parent]/controller/fragment/meta.php
				[Parent]/controller/fragment/share.php
				[Parent]/controller/fragment/title.php
				[Parent]/controller/structure/archive.php
				[Parent]/inc/env/inline-style.php
				[Parent]/model/app/pagination.php
		*/

		/**
		 * @since 1.0.1
		 * 	Destroys the previous query and sets up a new query.
		 * 
		 * @reference (WP)
		 * 	Destroys the previous query and sets up a new query.
		 * 	https://developer.wordpress.org/reference/functions/wp_reset_query/
		*/
		wp_reset_query();

		/**
		 * @reference (WP)
		 * 	Determines whether the query is for the blog homepage.
		 * 	https://developer.wordpress.org/reference/functions/is_home/
		 * 	Determines whether the query is for an existing post type archive page.
		 * 	https://developer.wordpress.org/reference/functions/is_post_type_archive/
		 * 	Determines whether the query is for an existing archive page.
		 * 	https://developer.wordpress.org/reference/functions/is_archive/
		*/
		if(is_home() || is_search() || is_post_type_archive() || is_archive()){
			return TRUE;
		}
		else{
			return FALSE;
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(!function_exists('__utility_get_option')) :
	function __utility_get_option($needle = '',$prefix = PREFIX['setting'])
	{
		/**
			@access (public)
				Retrieves theme modification value for the current theme.
				https://developer.wordpress.org/reference/functions/get_theme_mod/
			@global (array) $_customizer_option
				Custom global variables of this theme.
			@param (string) $needle
				Theme modification name.
			@return (mixed)
				Theme modification value.
			@reference
				Used in almost all of the class files in this theme.
				[Parent]/inc/customizer/option.php
				[Parent]/inc/setup/constant.php
		*/
		if(!isset($needle)){return;}

		if(get_theme_mod($prefix . $needle)){
			return get_theme_mod($prefix . $needle);
		}
		else{
			// User custom global value.
			global $_customizer_option;

			if(strpos($needle,'_') !== FALSE){
				$exploded = explode('_',$needle);
				switch(count($exploded)){
					case 2 :
						if(isset($_customizer_option[$exploded[0]][$exploded[1]])){
							return $_customizer_option[$exploded[0]][$exploded[1]];
						}
						break;
					case 3 :
						if(isset($_customizer_option[$exploded[0]][$exploded[1]][$exploded[2]])){
							return $_customizer_option[$exploded[0]][$exploded[1]][$exploded[2]];
						}
						break;
					case 4 :
						if(isset($_customizer_option[$exploded[0]][$exploded[1]][$exploded[2]][$exploded[3]])){
							return $_customizer_option[$exploded[0]][$exploded[1]][$exploded[2]][$exploded[3]];
						}
						break;
				}
			}
			else{
				if(isset($_customizer_option[$needle])){
					return $_customizer_option[$needle];
				}
			}
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(!function_exists('__utility_get_value')) :
	function __utility_get_value($needle = '')
	{
		/**
			@access (public)
			@global (array) $_customizer_value
				Custom global variables of this theme.
			@param (string) $needle
				Theme modification name.
			@return (array)
			@reference
				Used in almost all of the class files in this theme.
				[Parent]/inc/customizer/option.php
		*/
		if(!isset($needle)){return;}

		// User custom global value.
		global $_customizer_value;

		if(!empty($_customizer_value[$needle])){
			return $_customizer_value[$needle];
		}
		else{
			return array();
		}

	}// Method
	endif;
