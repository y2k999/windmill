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
 * Inspired by Luxeritas WordPress Theme
 * @link https://thk.kanzae.net/
 * @author LunaNuko
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
if(class_exists('_env_json_ld') === FALSE) :
class _env_json_ld
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_author()
 * 	set_prefix()
 * 	set_suffix()
 * 	set_hook()
 * 	__the_WPHeader()
 * 	__the_Article()
 * 	__the_Organization()
 * 	__the_BreadcrumbList()
 * 	__the_SiteNavigationElement()
 * 	__the_Person()
 * 	invoke_hook()
 * 	__the_output()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var(string) $jsonld
		@var(mixed) $org_id
			the ID of the currently queried object.
		@var(string) $org_url
			the canonical URL for a post.
		@var(string) $author
			Author Name
		@var(string) $prefix
		@var(string) $suffix
		@var(array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private $jsonld = '';
	private $org_id = '';
	private $org_url = '';
	private $author = '';
	private $prefix = '';
	private $suffix = '';
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

		$this->jsonld = '';

		/**
		 * @reference (WP)
		 * 	Retrieves the ID of the currently queried object.
		 * 	https://developer.wordpress.org/reference/functions/get_queried_object_id/
		 * 	Returns the canonical URL for a post.
		 * 	https://developer.wordpress.org/reference/functions/wp_get_canonical_url/
		*/
		$this->org_id = get_queried_object_id();
		$this->org_url = wp_get_canonical_url($this->org_id);

		$this->author = $this->set_author();
		$this->prefix = $this->set_prefix();
		$this->suffix = $this->set_suffix();

		$this->__the_WPHeader();
		$this->__the_Article();
		$this->__the_Organization();
		$this->__the_BreadcrumbList();
		$this->__the_SiteNavigationElement();
		$this->__the_Person();

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook($this->hook);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_author()
	{
		/**
			@access (private)
			@return (string)
				_filter[_env_json_ld][author]
			@reference
				[Parent]/inc/trait/singleton.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$return = 'Anonymous';

		// Get current post data.
		global $post;
		if(empty($post)){
			$post = __utility_get_post_object();
		}

		/**
		 * @reference (WP)
		 * 	Retrieve user info by user ID.
		 * 	https://developer.wordpress.org/reference/functions/get_userdata/
		 * 	Retrieves the requested data of the author of the current post.
		 * 	https://developer.wordpress.org/reference/functions/get_the_author_meta/
		*/
		if(is_singular()){
			$author = isset($post->post_author) ? get_userdata($post->post_author) : '';
			if(isset($author->ID)){
				$return = get_the_author_meta('display_name',$author->ID);
			}
		}

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
	private function set_prefix()
	{
		/**
			@access (private)
			@return (string)
				_filter[_env_json_ld][prefix]
			@reference
				[Parent]/inc/trait/singleton.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$return = '<script type="application/ld+json">';
		$return .= "\n";

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
	private function set_suffix()
	{
		/**
			@access (private)
			@return (string)
				_filter[_env_json_ld][suffix]
			@reference
				[Parent]/inc/trait/singleton.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$suffix = '</script>';
		$suffix = "\n" . $suffix . "\n";

		$return = '<script type="application/ld+json">';
		$return .= "\n";

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
	private function set_hook()
	{
		/**
			@access (private)
				The collection of hooks that is being registered (that is, actions or filters).
			@return (array)
				_filter[_env_json_ld][hook]
			@reference (WP)
				Prints scripts or data before the closing body tag on the front end.
				https://developer.wordpress.org/reference/hooks/wp_footer/
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
		return apply_filters("_filter[{$class}][{$function}]",$this->set_parameter_callback(array(
			'__the_output' => array(
				'tag' => 'add_action',
				'hook' => 'wp_footer'
			),
		)));

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_output()
	{
		/**
			@access (public)
			@return (string)
				_filter[_env_json_ld][output]
			@reference (WP)
				Prints scripts or data before the closing body tag on the front end.
				https://developer.wordpress.org/reference/hooks/wp_footer/
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
		echo apply_filters("_filter[{$class}][{$function}]",$this->jsonld);

	}// Method


	/* Method
	_________________________
	*/
	private function __the_WPHeader()
	{
		/**
			@access (private)
				WPHeader
			@return (void)
		*/
		$return = array(
			"@context" => "https://schema.org",
			"@type" => "WPHeader",
		);

		if(is_singular()){
			$title = get_the_title($this->org_id);
			$return += array(
				"about" => $title,
				"headline" => $title,
				// "alternativeHeadline" => apply_filters('thk_create_description',''),
				"alternativeHeadline" => '',
				"datePublished" => get_the_time('Y/m/d',$this->org_id),
				"dateModified" => get_the_modified_time('Y/m/d',$this->org_id),
				"author" => array(
					"@type" => "Person",
					"name" => $this->author,
				),
			);
		}
		else{
			$title = wp_get_document_title();
			$return += array(
				"about" => $title,
				"headline" => $title,
			);
		}
		$this->jsonld .= $this->prefix . @json_encode($return) . $this->suffix;


	}// Method


	/* Method
	_________________________
	*/
	private function __the_Article()
	{
		/**
			@access (private)
				Article
			@return (void)
		*/
		if(is_singular() && ($this->org_url !== FALSE)){

			$publisher = 'Organization';
			$logo = '';
			$thumb = '';

			$logo .= trailingslashit(get_template_directory_uri()) . 'screenshot.png';
			$logo_w = 600;
			$logo_h = 60;

			$thumb_w = 696;
			$thumb_h = 696;

			$thumb_id = get_post_thumbnail_id($this->org_id);
			$thumb_url = wp_get_attachment_image_src($thumb_id,TRUE);
			$thumb = isset($thumb_url[0]) ? $thumb_url[0] : '';

			if(empty($thumb)){
				$thumb = __utility_get_option('media_nopost') ? __utility_get_option('media_nopost') : URI['image'] . 'nopost.jpg';
			}

			$headline = get_the_title($this->org_id);
			if(empty($headline)){
				$headline = 'No title';
			}

			$return = array(
				"@context" => "https://schema.org",
				"@type" => "Article",
				"mainEntityOfPage" => array(
					"@type" => "WebPage",
					"@id" => $this->org_url,
				),
				"headline" => $headline,
				"image" => array(
					"@type" => "ImageObject",
					"url" => $thumb,
					"width" => $thumb_w,
					"height" => $thumb_h,
				),
				"datePublished" => get_the_time('Y/m/d',$this->org_id),
				"dateModified" => get_the_modified_time('Y/m/d',$this->org_id),
				"author" => array(
					"@type" => "Person",
					"name" => $this->author,
				),
				"publisher" => array(
					"@type" => $publisher,
					"name" => get_bloginfo('name','display'),
					"description" => get_bloginfo('description','display'),
					"logo" => array(
						"@type" => "ImageObject",
						"url" => $logo,
						"width" => $logo_w,
						"height" => $logo_h,"\n",
					),
				),
				"description" => _env_head::__get_description(),
			);
			$this->jsonld .= $this->prefix . @json_encode($return) . $this->suffix;
		}

	}// Method


	/* Method
	_________________________
	*/
	private function __the_Organization()
	{
		/**
			@access (private)
				Organization
			@return (void)
		*/
		$return = array(
			"@context" => "https://schema.org",
			"@type" => 'Organization',
			"url" => home_url('/'),
			"name" => get_bloginfo('name','display'),
			"description" => _env_head::__get_description(),
			"brand" => array(
				"@type" => "Thing",
				"name" => get_bloginfo('name','display'),
			),
		);

		$logo_w = 0;
		$logo_h = 0;
		$logo_info = trailingslashit(get_template_directory_uri()) . 'screenshot.png';
		if(is_array($logo_info) === TRUE){
			$logo_w = 600;
			$logo_h = 60;
		}

		$return += array(
			"image" => array(
				"@type" => "ImageObject",
				"url" => $logo_info,
				"width" => $logo_w,
				"height" => $logo_h,
			),
		);
		$this->jsonld .= $this->prefix . @json_encode($return) . $this->suffix;


	}// Method


	/* Method
	_________________________
	*/
	private function __the_BreadcrumbList()
	{
		/**
			@access (private)
				BreadcrumbList
			@return (void)
		*/

		// Get current post data.
		global $post;
		if(empty($post)){
			$post = __utility_get_post_object();
		}

		/**
			BreadcrumbList
		*/
		$itemListElement[] = array(
			"@type" => "ListItem",
			"name" => "Home",
			"position" => 1,
			"item"	 => home_url('/'),
		);

		if(is_page() && !is_home() && !is_front_page()){
			$i = 2;
			$parents = array_reverse(get_post_ancestors($post->ID));

			if(empty($parents)){
				$title = get_the_title();
				if(empty($title)){
					$title = 'No title';
				}
				$itemListElement[] = [
					"@type" => "ListItem",
					"name" => $title,
					"position" => 2,
					"item" => get_the_permalink(),
				];
			}
			else{
				foreach($parents as $p_id){
					$title = get_page($p_id)->post_title;
					if(empty($title)){
						$title = 'No title';
					}
					$itemListElement[] = [
						"@type" => "ListItem",
						"name" => $title,
						"position" => $i,
						"item"	 => get_page_link($p_id),
					];
					++$i;
				}

				$title = get_the_title();
				if(empty($title)){
					$title = 'No title';
				}
				$itemListElement[] = array(
					"@type" => "ListItem",
					"name" => $title,
					"position" => $i,
					"item" => get_the_permalink(),
				);
			}
		}
		elseif(is_attachment()){
			$title = get_the_title();
			if(empty($title)){
				$title = 'No title';
			}
			$itemListElement[] = array(
				"@type" => "ListItem",
				"name" => $title,
				"position" => 2,
				"item" => get_the_permalink(),
			);
		}
		elseif(is_single() || is_category()){
			global $cat;
			$cat_obj = is_single() ? get_the_category() : array(get_category($cat));

			if(!empty($cat_obj) && (is_wp_error($cat_obj) === FALSE)){
				$i = 2;
				$html = NULL;
				$sort_array = array();
				$pars = isset($cat_obj[0]->parent) ? get_category($cat_obj[0]->parent) : '';

				while($pars && !is_wp_error($pars) && ($pars->cat_ID != 0)){
					$sort_array[] = array(
						"@type" => "ListItem",
						"name" => $pars->name,
						"position" => "<!--position-->",
						"item"	 => get_category_link($pars->cat_ID),
					);
					$pars = get_category($pars->parent);
				}
				if(!empty($sort_array)){
					$sort_array = array_reverse($sort_array);
				}

				if(isset($cat_obj[0]->name) && isset($cat_obj[0]->cat_ID)){
					$sort_array[] = array(
						"@type" => "ListItem",
						"name" => $cat_obj[0]->name,
						"position" => "<!--position-->",
						"item"	 => get_category_link($cat_obj[0]->cat_ID),
					);
				}

				if(is_single()){
					$title = get_the_title();
					if(empty($title)){
						$title = 'No title';
					}
					$sort_array[] = array(
						"@type" => "ListItem",
						"name" => $title,
						"position" => "<!--position-->",
						"item" => get_the_permalink(),
					);
				}

				foreach((array)$sort_array as $key => $value){
					$sort_array[$key]['position'] = str_replace('<!--position-->',$i,$value['position']);
					++$i;
				}
				$itemListElement[] = $sort_array;
			}
			elseif(isset($post->post_type) && ($post->post_type !== 'post')){
				if(get_post_type_archive_link($post->post_type) !== FALSE){
					$i = 2;
					$post_type_obj = get_post_type_object($post->post_type);
					$sort_array[] = array(
						"@type" => "ListItem",
						"name" => $post_type_obj->label,
						"position" => 2,
						"item" => get_post_type_archive_link($post->post_type),
					);
					$itemListElement[] = $sort_array;
				}
			}

		}
		elseif(is_tag() || is_tax() || is_date() || is_month() || is_year() || is_author() || is_search() || is_post_type_archive()){
			if(is_tag()){
				$name = single_tag_title('',FALSE);
			}
			elseif(is_tax()){
				$name = single_term_title('',FALSE);
			}
			elseif(is_date()){
				$name = get_the_date(__('F j, Y','windmill'));
			}
			elseif(is_month()){
				$name = get_the_date(__('F Y','windmill'));
			}
			elseif(is_year()){
				$name = get_the_date(__('Y','windmill'));
			}
			elseif(is_author()){
				$name = esc_html(get_queried_object()->display_name);
			}
			elseif(is_search()){
				if(!empty($s)){
					$name = sprintf(__('Search results of [%s]','windmill'),esc_html($s));
				}
				else{
					$name = 'Search results';
				}
			}
			elseif(is_post_type_archive()){
				$name = post_type_archive_title('',FALSE);
			}
			$http = is_ssl() ? 'https' : 'http' . '://';

			$itemListElement[] = array(
				"@type" => "ListItem",
				"name" => $name,
				"position" => 2,
				"item"	 => $http . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"],
			);
		}

		$return = array(
			"@context" => "https://schema.org",
			"@type" => "BreadcrumbList",
			"itemListElement" => $itemListElement
		);
		$this->jsonld .= $this->prefix . @json_encode($return) . $this->suffix;

	}// Method


	/* Method
	_________________________
	*/
	private function __the_SiteNavigationElement()
	{
		/**
			@access (private)
				SiteNavigationElement
			@return (void)
		*/
		$nav_menu = wp_nav_menu(
			array(
				'theme_location' => 'primary_navigation',
				'container' => '',
				'menu_class' => '',
				'depth' => '3',
				'echo' => FALSE,
			)
		);
		$nav_array = explode("<li",$nav_menu);

		foreach($nav_array as $key => $value){
			if(stripos($value,'href=') === FALSE){
				unset($nav_array[$key]);
				continue;
			}
			$value = strstr($value,'</a>',TRUE);
			$nav_array[$key] = explode('>',str_replace(array('"',"'",'href=','</a>'),'',stristr($value,'href=')));
		}

		$SiteNavigationElement = array();

		foreach($nav_array as $val){
			$SiteNavigationElement[] = array(
				"@context" => "https://schema.org",
				"@type" => "SiteNavigationElement",
				"name" => $val[1],
				"url" => $val[0],
			);
		}

		$return = array(
			"@context" => "https://schema.org",
			"@graph" => $SiteNavigationElement,
		);

		$this->jsonld .= $this->prefix . @json_encode($return) . $this->suffix;

	}// Method


	/* Method
	_________________________
	*/
	private function __the_Person()
	{
		/**
			@access (private)
				Person
			@return (void)
		*/
		if(is_singular()){
			$this->url = home_url('/');
			$this->url = get_author_posts_url(get_the_author_meta('ID'));

			$return = array(
				"@context" => "https://schema.org",
				"@type" => "Person",
				"name" => $this->author,
				"url" => $this->url,
			);
			$this->jsonld .= $this->prefix . @json_encode($return) . $this->suffix;
		}

	}// Method


}// Class
endif;
// new _env_json_ld();
_env_json_ld::__get_instance();
