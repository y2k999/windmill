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
if(class_exists('_env_title') === FALSE) :
class _env_title
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_hook()
 * 	invoke_hook()
 * 	document_title_separator()
 * 	document_title_parts()
 * 	get_the_archive_title()
 * 	the_title()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var(array) $hook
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
				_filter[_env_title][hook]
			@reference
				[Parent]/inc/trait/hook.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Determines whether the current request is for an administrative interface page.
		 * 	https://developer.wordpress.org/reference/functions/is_admin/
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		if(is_admin()){
			return apply_filters("_filter[{$class}][{$function}]",array());
		}
		else{
			return apply_filters("_filter[{$class}][{$function}]",$this->set_parameter_callback(array(
				'document_title_separator' => array(
					'tag' => 'add_filter',
					'hook' => 'document_title_separator'
				),
				'document_title_parts' => array(
					'tag' => 'add_filter',
					'hook' => 'document_title_parts'
				),
				'get_the_archive_title' => array(
					'tag' => 'add_filter',
					'hook' => 'get_the_archive_title'
				),
				'the_title' => array(
					'tag' => 'add_filter',
					'hook' => 'the_title'
				),
			)));
		}

	}// Method


	/* Hook
	_________________________
	*/
	public function the_title($title)
	{
		/**
			@access (public)
				Filters the post title.
				https://developer.wordpress.org/reference/hooks/the_title/
			@param (string) $title
				The post title.
			@return (string)
				_filter[_env_title][the_title]
			@reference
				[Parent]/inc/utility/general.php
		*/

		/**
		 * @reference (WP)
		 * 	Determines whether the current request is for an administrative interface page.
		 * 	https://developer.wordpress.org/reference/functions/is_admin/
		*/
		if(is_admin()){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Trims text to a certain number of words.
		 * 	https://developer.wordpress.org/reference/functions/wp_trim_words/
		*/
		// $title = mb_strimwidth($title,0,40,'Åc','UTF-8');
		$title = wp_trim_words($title,36,'...');

		return $title;

	}// Method


	/* Hook
	_________________________
	*/
	public function document_title_separator($sep)
	{
		/**
			@access (public)
				Filters the separator for the document title.
				https://developer.wordpress.org/reference/hooks/document_title_separator/
			@param (string) $sep
				Document title separator.
				Default '-'.
			@return (string)
				_filter[_env_title][document_title_separator]
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
		return apply_filters("_filter[{$class}][{$function}]",$sep = ' | ');

	}// Method


	/* Hook
	_________________________
	*/
	public function document_title_parts($title)
	{
		/**
			@access (public)
				Filters the parts of the document title.
				https://developer.wordpress.org/reference/hooks/document_title_parts/
			@param (array) $title
				The document title parts.
			@return (array)
				_filter[_env_title][document_title_parts]
			@reference
				[Parent]/inc/customizer/option.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// Title of the viewed page.
		$title['title'] = '';

		// Page number if paginated.
		$title['page'] = '';

		// Site description when on home page.
		$title['tagline'] = '';

		// Site title when not on home page.
		$title['site'] = '';

		if(is_front_page() || is_home()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for the front page of the site.
			 * 	https://developer.wordpress.org/reference/functions/is_front_page/
			 * 	Retrieve post title.
			 * 	https://developer.wordpress.org/reference/functions/get_the_title/
			*/
			$title['title'] = trim(get_the_title());
		}
		elseif(is_singular()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing single post of any post type (post, attachment, page, custom post types).
			 * 	https://developer.wordpress.org/reference/functions/is_singular/
			*/
			$title['title'] = trim(get_the_title());
		}
		elseif(is_archive()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_archive/
			*/
			$title['title'] = esc_html__('Archive','windmill');
		}
		elseif(is_post_type_archive()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing post type archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_post_type_archive/
			 * 	Display or retrieve title for a post type archive.
			 * 	https://developer.wordpress.org/reference/functions/post_type_archive_title/
			*/
			$title['title'] = sprintf(esc_html__('Post Type Archive','windmill') . ': %s',post_type_archive_title('',FALSE));
		}
		elseif(is_search()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for a search.
			 * 	https://developer.wordpress.org/reference/functions/is_search/
			 * 	Retrieves the contents of the search WordPress query variable.
			 * 	https://developer.wordpress.org/reference/functions/get_search_query/
			*/
			$title['title'] = sprintf(esc_html__('Search Results','windmill') . ': %s',get_search_query());
		}
		elseif(is_404()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query has resulted in a 404 (returns no results).
			 * 	https://developer.wordpress.org/reference/functions/is_404/
			*/
			$title['title'] = __utility_get_option('title_404');
		}

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",$title);

	}// Method


	/* Hook
	_________________________
	*/
	public function get_the_archive_title($title)
	{
		/**
			@access (public)
				Filters the archive title.
				https://developer.wordpress.org/reference/hooks/get_the_archive_title/
			@param (string) $title
				Archive title to be displayed.
			@return (string)
				_filter[_env_title][get_the_archive_title]
			@reference
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// Default format.
		$title_format = esc_html__('Archive','windmill') . ': %s';

		if(is_category()){
			/**
			 * @since 1.0.1
			 * 	Display or retrieve page title for category archive.
			 * 
			 * @reference (WP)
			 * 	Determines whether the query is for an existing category archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_category/
			 * 	Display or retrieve page title for category archive.
			 * 	https://developer.wordpress.org/reference/functions/single_cat_title/
			*/
			$title = single_cat_title(esc_html__('Category','windmill') . ' : ',FALSE);
		}
		elseif(is_tag()){
			/**
			 * @since 1.0.1
			 * 	Display or retrieve page title for tag post archive.
			 * 
			 * @reference (WP)
			 * 	Determines whether the query is for an existing tag archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_tag/
			 * 	Display or retrieve page title for tag post archive.
			 * 	https://developer.wordpress.org/reference/functions/single_tag_title/
			*/
			$title = single_tag_title(esc_html__('Tag','windmill') . ' : ',FALSE);
		}
		elseif(is_author()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing author archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_author/
			 * 	Retrieve the author of the current post.
			 * 	https://developer.wordpress.org/reference/functions/get_the_author/
			*/
			$user_id = __utility_get_user_id();

			$title_format = esc_html__('Author','windmill') . ' : %s';
			$title = sprintf($title_format,get_the_author_meta('display_name',$user_id));
		}
		elseif(is_search()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for a search.
			 * 	https://developer.wordpress.org/reference/functions/is_search/
			 * 	Retrieves the contents of the search WordPress query variable.
			 * 	https://developer.wordpress.org/reference/functions/get_search_query/
			*/
			$title_format = esc_html__('Search Result','windmill') . ' : %s';
			$title = sprintf($title_format,get_search_query(FALSE));
		}
		elseif(is_post_type_archive()){
			/**
			 * @since 1.0.1
			 * 	Display or retrieve title for a post type archive.
			 * 
			 * @reference (WP)
			 * 	Determines whether the query is for an existing post type archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_post_type_archive/
			 * 	Display or retrieve title for a post type archive.
			 * 	https://developer.wordpress.org/reference/functions/post_type_archive_title/
			*/
			$title = post_type_archive_title(esc_html__('Post Type','windmill') . ' : ',FALSE);
		}
		elseif(is_tax()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing custom taxonomy archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_tax/
			 * 	Display or retrieve page title for taxonomy term archive.
			 * 	https://developer.wordpress.org/reference/functions/single_term_title/
			*/
			$title = single_term_title(esc_html__('Term','windmill') . ' : ',FALSE);
		}
		elseif(is_year()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing year archive.
			 * 	https://developer.wordpress.org/reference/functions/is_year/
			 * 	Retrieves the value of a query variable in the WP_Query class.
			 * 	https://developer.wordpress.org/reference/functions/get_query_var/
			*/
			$title_format = '%s' . esc_html__('year','windmill');
			$title = sprintf($title_format,get_query_var('year'));
		}
		elseif(is_month()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing month archive.
			 * 	https://developer.wordpress.org/reference/functions/is_month/
			*/
			$title_format = '%1$s' . esc_html__('year','windmill') . '%2$s' . esc_html__('month','windmill');
			$title = sprintf($title_format,get_query_var('year'),get_query_var('monthnum'));
		}
		elseif(is_day()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing day archive.
			 * 	https://developer.wordpress.org/reference/functions/is_day/
			*/
			$title_format = '%1$s' . esc_html__('year','windmill') . '%2$s' . esc_html__('month','windmill') . '%3$s' . esc_html__('day','windmill');
			$title = sprintf($title_format,get_query_var('year'),get_query_var('monthnum'),get_query_var('day'));
		}
		else{
			// $title = esc_html__('List of Article','windmill');
		}

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",$title);

	}// Method


}// Class
endif;
// new _env_title();
_env_title::__get_instance();
