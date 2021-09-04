<?php
/**
 * Render Application.
 * @package Windmill
 * @license GPL3.0+
 * @since 1.0.1
*/

/**
 * Inspired by Beans Framework WordPress Theme
 * @link https://www.getbeans.io
 * @author Thierry Muller
 * 
 * Inspired by LION MEDIA WordPress Theme
 * @link http://fit-jp.com/theme/
 * @author Kota Naito
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
if(class_exists('_app_breadcrumb') === FALSE) :
class _app_breadcrumb
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_icon()
 * 	set_param()
 * 	set_hook()
 * 	invoke_hook()
 * 	__the_template()
 * 	__the_home()
 * 	__the_render()
 * 	the_single()
 * 	the_page()
 * 	the_singular()
 * 	the_tax()
 * 	the_category()
 * 	the_tag()
 * 	the_post_type_archive()
 * 	the_author()
 * 	the_date()
 * 	the_search()
 * 	the_404()
 * 	the_general()
 * 	node()
 * 	get_youngest_category()
 * 	get_youngest_taxonomy()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $icon
			Home (root) icon of breadcrumbs.
		@var (array) $_param
			Parameter for the application.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_param = array();
	private $hook = array();
	private $icon = '';

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
				[Parent]/inc/trait/theme.php
				[Parent]/inc/utility/general.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);
		self::$_param = $this->set_param(self::$_index);
		$this->icon = $this->set_icon(self::$_index);

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
				_filter[_app_breadcrumb][hook]
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/trait/hook.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);
		$index = self::$_index;

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",$this->set_parameter_callback(array(
			'__the_home' => array(
				'beans_id' => $class . '__the_home',
				'tag' => 'beans_add_action',
				'hook' => HOOK_POINT['model'][$index]['main'],
				'priority' => PRIORITY['mid-low']
			),
			'__the_render' => array(
				'beans_id' => $class . '__the_render',
				'tag' => 'beans_add_action',
				'hook' => HOOK_POINT['model'][$index]['main']
			),
		)));

	}// Method


	/* Method
	_________________________
	*/
	public static function __the_template($args = array())
	{
		/**
			@access (private)
				Load and echo this application.
			@param (array) $args
				Additional arguments passed to this application.
			@return (void)
			@reference
				[Parent]/controller/structure/footer.php
				[Parent]/controller/structure/header.php
				[Parent]/inc/setup/constant.php
		*/
		$index = self::$_index;

		/**
		 * @reference (WP)
		 * 	Determines whether the query is for the front page of the site.
		 * 	https://developer.wordpress.org/reference/functions/is_front_page/
		 * 	Determines whether the query is for the blog homepage.
		 * 	https://developer.wordpress.org/reference/functions/is_home/
		 * 	Determines whether the current request is for an administrative interface page.
		 * 	https://developer.wordpress.org/reference/functions/is_admin/
		*/
		if(is_front_page() || is_home() || is_admin()){return;}

		$class = self::$_class;
		$index = self::$_index;

		/**
		 * @reference (WP)
		 * 	Merge user defined arguments into defaults array.
		 * 	https://developer.wordpress.org/reference/functions/wp_parse_args/
		 * @param (string)|(array)|(object) $args
		 * 	Value to merge with $defaults.
		 * @param (array) $defaults
		 * 	Array that serves as the defaults.
		*/
		self::$_param = wp_parse_args($args,self::$_param);

		/**
			@hooked
				__wrap_breadcrumb_footer_prepend()
			@reference
				[Parent]/model/wrap/breadcrumb.php
		*/
		do_action(HOOK_POINT['model'][$index]['prepend']);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		 * @reference (Uikit)
		 * 	https://getuikit.com/docs/breadcrumb
		*/
		beans_open_markup_e("_list[{$class}]",'ul',array(
			'id' => 'breadcrumb',
			'class' => 'uk-breadcrumb',
			'itemprop' => 'breadcrumb',
		));
			/**
				@hooked
					_app_breadcrumb::__the_home()
					_app_breadcrumb::__the_render()
				@reference
					[Parent]/model/app/branding.php
			*/
			do_action(HOOK_POINT['model'][$index]['main']);

		beans_close_markup_e("_list[{$class}]",'ul');

		/**
			@hooked
				__wrap_breadcrumb_footer_append()
			@reference
				[Parent]/model/wrap/breadcrumb.php
		*/
		do_action(HOOK_POINT['model'][$index]['append']);

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_home()
	{
		/**
			@access (public)
				Retrieves the URL for the current site where the front end is accessible.
				https://developer.wordpress.org/reference/functions/home_url/
			@return (void)
			@hook (beans id)
				_app_breadcrumb__the_home
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_item[{$class}][root][{$function}]",'li',array(
			'itemscope' => 'itemscope',
			'itemtype' => 'http://data-vocabulary.org/Breadcrumb',
		));
			beans_open_markup_e("_link[{$class}][root][{$function}]",'a',array(
				'href' => home_url(),
			));
				beans_output_e("_output[{$class}][root][{$function}]",$this->icon);

			beans_close_markup_e("_link[{$class}][root][{$function}]",'a');
		beans_close_markup_e("_item[{$class}][root][{$function}]",'li');

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_render()
	{
		/**
			@access (public)
				Echo the nodes of the breadcrumb.
			@return (void)
			@hook (beans id)
				_app_breadcrumb__the_render
		*/
		if(is_single()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing single post.
			 * 	https://developer.wordpress.org/reference/functions/is_single/
			*/
			$this->the_single();
		}
		elseif(is_page()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing single page.
			 * 	https://developer.wordpress.org/reference/functions/is_page/
			*/
			$this->the_page();
		}
		elseif(is_singular()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing single post of any post type (post, attachment, page, custom post types).
			 * 	https://developer.wordpress.org/reference/functions/is_singular/
			*/
			$this->the_singular();
		}
		elseif(is_tax()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing custom taxonomy archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_tax/
			*/
			$this->the_tax();
		}
		elseif(is_category()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing category archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_category/
			*/
			$this->the_category();
		}
		elseif(is_tag()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing tag archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_tag/
			*/
			$this->the_tag();
		}
		elseif(is_post_type_archive()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing post type archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_post_type_archive/
			*/
			$this->the_post_type_archive();
		}
		elseif(is_author()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing author archive page.
			 * 	https://developer.wordpress.org/reference/functions/is_author/
			*/
			$this->the_author();
		}
		elseif(is_date()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for an existing date archive.
			 * 	https://developer.wordpress.org/reference/functions/is_date/
			*/
			$this->the_date();
		}
		elseif(is_search()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query is for a search.
			 * 	https://developer.wordpress.org/reference/functions/is_search/
			*/
			$this->the_search();
		}
		elseif(is_404()){
			/**
			 * @reference (WP)
			 * 	Determines whether the query has resulted in a 404 (returns no results).
			 * 	https://developer.wordpress.org/reference/functions/is_404/
			*/
			$this->the_404();
		}
		else{
			$this->the_general();
		}

	}// Method


	/**
		@access (private)
			Single item of breadcrumbs.
		@return (void)
	*/
	private function the_single()
	{
		// Get current post data.
		$post = __utility_get_post_object();

		/**
		 * @reference (WP)
		 * 	Retrieves post categories.
		 * 	https://developer.wordpress.org/reference/functions/get_the_category/
		*/
		$categories = get_the_category($post->ID);
		if(empty($categories)){return;}

		$category = $this->get_youngest_category($post->ID,$categories);
		if($category ->parent !== 0){
			/**
			 * @reference (WP)
			 * 	Get an array of ancestor IDs for a given object.
			 * 	https://developer.wordpress.org/reference/functions/get_ancestors/
			*/
			$ancestors = array_reverse(get_ancestors($category->cat_ID,'category'));
			foreach($ancestors as $ancestor){
				/**
				 * @reference (WP)
				 * 	Retrieves category link URL.
				 * 	https://developer.wordpress.org/reference/functions/get_category_link/
				 * 	Retrieves the name of a category from its ID.
				 * 	https://developer.wordpress.org/reference/functions/get_cat_name/
				*/
				$this->node('single-category-parent',get_category_link($ancestor),TRUE,get_cat_name($ancestor));
			}
		}
		$this->node('single-category-child',get_category_link($category->term_id),TRUE,$category->cat_name);
		$this->node('single','',FALSE,$post->post_title);

	}// Method


	/**
		@access (private)
			Page item of breadcrumbs.
		@return (void)
	*/
	private function the_page()
	{
		// Get current post data.
		$post = __utility_get_post_object();

		if($post->post_parent !== 0){
			/**
			 * @reference (WP)
			 * 	Retrieves the IDs of the ancestors of a post.
			 * 	https://developer.wordpress.org/reference/functions/get_post_ancestors/
			*/
			$ancestors = array_reverse(get_post_ancestors($post->ID));
			foreach($ancestors as $ancestor){
				/**
				 * @reference (WP)
				 * 	Retrieve post title.
				 * 	https://developer.wordpress.org/reference/functions/get_the_title/
				*/
				$this->node('page-parent',get_permalink($ancestor),TRUE,get_the_title($ancestor));
			}
		}
		$this->node('page','',FALSE,$post->post_title);

	}// Method


	/**
		@access (private)
			Singular item of breadcrumbs
		@return (void)
	*/
	private function the_singular()
	{
		/**
		 * @reference (WP)
		 * 	Retrieves the value of a query variable in the WP_Query class.
		 * 	https://developer.wordpress.org/reference/functions/get_query_var/
		*/
		// Get current post data.
		$post = __utility_get_post_object();
		$post_type = get_query_var('post_type');

		/**
		 * @reference (WP)
		 * 	Return the names or objects of the taxonomies which are registered for the requested object or object type, such as a post object or post type name.
		 * 	https://developer.wordpress.org/reference/functions/get_object_taxonomies/
		 * 	Checks whether the given variable is a WordPress Error.
		 * 	https://developer.wordpress.org/reference/functions/is_wp_error/
		*/
		$taxonomy_objects = get_object_taxonomies($post);
		if(is_wp_error($taxonomy_objects)){return;}

		/**
		 * @reference (WP)
		 * 	Retrieves a post type object by name.
		 * 	https://developer.wordpress.org/reference/functions/get_post_type_object/
		 * 	Checks whether the given variable is a WordPress Error.
		 * 	https://developer.wordpress.org/reference/functions/is_wp_error/
		*/
		$obj = get_post_type_object($post_type);
		if(is_wp_error($obj)){return;}

		$taxonomy = $taxonomy_objects[0];

		/**
		 * @reference (WP)
		 * 	Retrieves the permalink for a post type archive.
		 * 	https://developer.wordpress.org/reference/functions/get_post_type_archive_link/
		*/
		$this->node('singular-' . $post_type,get_post_type_archive_link($post),TRUE,$obj->label);

		/**
		 * @reference (WP)
		 * 	Retrieves the terms of the taxonomy that are attached to the post.
		 * 	https://developer.wordpress.org/reference/functions/get_the_terms/
		 * 	Checks whether the given variable is a WordPress Error.
		 * 	https://developer.wordpress.org/reference/functions/is_wp_error/
		*/
		$taxonomy_objects = get_the_terms($post->ID,$taxonomy);
		if($taxonomy_objects && !is_wp_error($taxonomy_objects)){

			$term = $this->get_youngest_taxonomy($post->ID,$taxonomy_objects,$taxonomy);
			if($term->parent !== 0){
				/**
				 * @reference (WP)
				 * 	Get an array of ancestor IDs for a given object.
				 * 	https://developer.wordpress.org/reference/functions/get_ancestors/
				*/
				$ancestors = array_reverse(get_ancestors($term->term_id,$taxonomy));
				foreach((array)$ancestors as $ancestor){
					/**
					 * @reference (WP)
					 * 	Generate a permalink for a taxonomy term archive.
					 * 	https://developer.wordpress.org/reference/functions/get_term_link/
					 * 	Get all Term data from database by Term ID.
					 * 	https://developer.wordpress.org/reference/functions/get_term/
					*/
					$this->node('singular-parent',get_term_link($ancestor,$taxonomy),TRUE,get_term($ancestor,$taxonomy)->name);
				}
			}
			$this->node('singular',get_term_link($term,$taxonomy),TRUE,$term->name);
			$this->node('singular-term','',FALSE,$post->post_title);
		}

	}// Method


	/**
		@access (private)
			Taxonomy item of breadcrumbs.
		@return (void)
	*/
	private function the_tax()
	{
		/**
		 * @reference (WP)
		 * 	Retrieves the value of a query variable in the WP_Query class.
		 * 	https://developer.wordpress.org/reference/functions/get_query_var/
		*/
		$taxonomy = get_query_var('taxonomy');
		$post_type = get_query_var('post_type');

		/**
		 * @reference (WP)
		 * 	Retrieves the currently queried object.
		 * 	https://developer.wordpress.org/reference/functions/get_queried_object/
		 * 	Checks whether the given variable is a WordPress Error.
		 * 	https://developer.wordpress.org/reference/functions/is_wp_error/
		*/
		$queried_object = get_queried_object();
		if(!$queried_object){return;}

		/**
		 * @reference (WP)
		 * 	Retrieves the taxonomy object of $taxonomy.
		 * 	https://developer.wordpress.org/reference/functions/get_taxonomy/
		 * 	Checks whether the given variable is a WordPress Error.
		 * 	https://developer.wordpress.org/reference/functions/is_wp_error/
		*/
		$tax = get_taxonomy($taxonomy)->object_type;
		if(is_wp_error($tax)){return;}

		$post_type = $tax[0];
		/**
		 * @reference (WP)
		 * 	Retrieves the permalink for a post type archive.
		 * 	https://developer.wordpress.org/reference/functions/get_post_type_archive_link/
		 * 	Retrieves a post type object by name.
		 * 	https://developer.wordpress.org/reference/functions/get_post_type_object/
		 * 	Retrieves the post type of the current post or of a given post.
		 * 	https://developer.wordpress.org/reference/functions/get_post_type/
		*/
		$this->node('tax-archive',get_post_type_archive_link($post_type),TRUE,esc_html(get_post_type_object(get_post_type())->label));

		if($queried_object->parent !== 0){
			/**
			 * @reference (WP)
			 * 	Get an array of ancestor IDs for a given object.
			 * 	https://developer.wordpress.org/reference/functions/get_ancestors/
			*/
			$ancestors = array_reverse(get_ancestors($queried_object->term_id,$queried_object->taxonomy));
			foreach((array)$ancestors as $ancestor){
				/**
				 * @reference (WP)
				 * 	Generate a permalink for a taxonomy term archive.
				 * 	https://developer.wordpress.org/reference/functions/get_term_link/
				 * 	Get all Term data from database by Term ID.
				 * 	https://developer.wordpress.org/reference/functions/get_term/
				*/
				$this->node('tax-parent',get_term_link($ancestor,$queried_object->taxonomy),TRUE,get_term($ancestor,$queried_object->taxonomy)->name);
			}
		}
		$this->node('tax','',FALSE,$queried_object->name);

	}// Method


	/**
		@access (private)
			Category item of breadcrumbs.
		@return (void)
	*/
	private function the_category()
	{
		/**
		 * @reference (WP)
		 * 	Retrieves the currently queried object.
		 * 	https://developer.wordpress.org/reference/functions/get_queried_object/
		 * 	Checks whether the given variable is a WordPress Error.
		 * 	https://developer.wordpress.org/reference/functions/is_wp_error/
		*/
		$queried_object = get_queried_object();
		if(!$queried_object){return;}

		if($queried_object->parent !== 0){
			/**
			 * @reference (WP)
			 * 	Get an array of ancestor IDs for a given object.
			 * 	https://developer.wordpress.org/reference/functions/get_ancestors/
			*/
			$ancestors = array_reverse(get_ancestors($queried_object->cat_ID,'category'));
			foreach((array)$ancestors as $ancestor){
				/**
				 * @reference (WP)
				 * 	Retrieves category link URL.
				 * 	https://developer.wordpress.org/reference/functions/get_category_link/
				 * 	Retrieves the name of a category from its ID.
				 * 	https://developer.wordpress.org/reference/functions/get_cat_name/
				*/
				$this->node('category-parent',get_category_link($ancestor),TRUE,get_cat_name($ancestor));
			}
		}
		$this->node('category','',FALSE,$queried_object->name);

	}// Method


	/**
		@access (private)
			Tag item of breadcrumbs.
		@return (void)
	*/
	private function the_tag()
	{
		/**
		 * @reference (WP)
		 * 	Display or retrieve page title for tag post archive.
		 * 	https://developer.wordpress.org/reference/functions/single_tag_title/
		*/
		$this->node('tag','',FALSE,single_tag_title('',FALSE));

	}// Method


	/**
		@access (private)
			Post type archive item of breadcrumbs.
		@return (void)
	*/
	private function the_post_type_archive()
	{
		/**
		 * @reference (WP)
		 * 	Retrieves the value of a query variable in the WP_Query class.
		 * 	https://developer.wordpress.org/reference/functions/get_query_var/
		*/
		$post_type = get_query_var('post_type');

		/**
		 * @reference (WP)
		 * 	Retrieves a post type object by name.
		 * 	https://developer.wordpress.org/reference/functions/get_post_type_object/
		*/
		$this->node('post-type-archive','',FALSE,get_post_type_object($post_type)->label);

	}// Method


	/**
		@access (private)
			Author item of breadcrumbs.
		@return (void)
	*/
	private function the_author()
	{
		/**
		 * @reference (WP)
		 * 	Retrieves the requested data of the author of the current post.
		 * 	https://developer.wordpress.org/reference/functions/get_the_author_meta/
		 * 	Retrieves the value of a query variable in the WP_Query class.
		 * 	https://developer.wordpress.org/reference/functions/get_query_var/
		*/
		$this->node('author','',FALSE,get_the_author_meta('display_name',get_query_var('author')));

	}// Method


	/**
		@access (private)
			Day item of breadcrumbs.
		@return (void)
	*/
	private function the_date()
	{
		if(get_query_var('day') !== 0){
			/**
			 * @reference (WP)
			 * 	Retrieves the permalink for the year archives.
			 * 	https://developer.wordpress.org/reference/functions/get_year_link/
			 * 	Retrieves the value of a query variable in the WP_Query class.
			 * 	https://developer.wordpress.org/reference/functions/get_query_var/
			*/
			$this->node('date-year',get_year_link(get_query_var('year')),TRUE,get_query_var('year') . __('year','windmill'));

			/**
			 * @reference (WP)
			 * 	Retrieves the permalink for the month archives with year.
			 * 	https://developer.wordpress.org/reference/functions/get_month_link/
			*/
			$this->node('date-month',get_month_link(get_query_var('year'),get_query_var('monthnum')),TRUE,get_query_var('monthnum') . __('month','windmill'));
			$this->node('date-day','',FALSE,get_query_var('day') . __('day','windmill'));
		}
		elseif(get_query_var('monthnum') !== 0){
			$this->node('date-year',get_year_link(get_query_var('year')),TRUE,get_query_var('year') . __('year','windmill'));
			$this->node('date-month','',FALSE,get_query_var('monthnum') . __('month','windmill'));
		}
		else{
			$this->node('date-year','',FALSE,get_query_var('year') . __('year','windmill'));
		}

	}// Method


	/**
		@access (private)
			Search item of breadcrumbs.
		@return (void)
	*/
	private function the_search()
	{
		/**
		 * @reference (WP)
		 * 	Retrieves the contents of the search WordPress query variable.
		 * 	https://developer.wordpress.org/reference/functions/get_search_query/
		*/
		$this->node('search','',FALSE,esc_html__('Search Results ','windmill') . get_search_query() . '.');

	}// Method


	/**
		@access (private)
			404 page item of breadcrumbs.
		@return (void)
		@reference
			[Parent]/inc/customizer/option.php
			[Parent]/inc/utility/general.php
	*/
	private function the_404()
	{
		$this->node('404','',FALSE,__utility_get_option('message_404'));

	}// Method


	/**
		@access (private)
			General item of breadcrumbs.
		@return (void)
	*/
	private function the_general()
	{
		/**
		 * @reference (WP)
		 * 	Retrieves information about the current site.
		 * 	https://developer.wordpress.org/reference/functions/get_bloginfo/
		*/
		$this->node('genera','',FALSE,get_bloginfo('name'));

	}// Method


	/* Method
	_________________________
	*/
	private function node($handle = '',$url = '',$label = TRUE,$output = '')
	{
		/**
			@access (private)
				Custom methods for printing html of the breadcrumb node.
			@param (string) $handle
			@param (string) $url
			@param (bool) $label
			@param (string) $output
			@return (void)
			@reference
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_item[{$class}][{$function}][{$handle}]",'li',array(
			'itemscope' => 'itemscope',
			'itemtype' => 'http://data-vocabulary.org/Breadcrumb',
		));
			if(!empty($url)){
				beans_open_markup_e("_link[{$class}][{$function}][{$handle}]",'a',array(
					'href' => $url,
				));
			}
				if($label){
					beans_open_markup_e("_label[{$class}][{$function}][{$handle}]",'span',array(
						'itemprop' => 'title'
					));
				}
				beans_output_e("_output[{$class}][{$function}][{$handle}]",$output);

				if($label){
					beans_close_markup_e("_label[{$class}][{$function}][{$handle}]",'span');
				}
			if(!empty($url)){
				beans_close_markup_e("_link[{$class}][{$function}][{$handle}]",'a');
			}
		beans_close_markup_e("_item[{$class}][{$function}][{$handle}]",'li');

	}// Method


	/**
		@access (private)
		@param (array) $categories
			Category ID or category row object.
		@return (string)
	*/
	private function get_youngest_category($post_id = 0,$categories)
	{
		if($post_id === 0){
			$post = __utility_get_post_object();
			$post_id = $post->ID;
		}

		if(count($categories) === 1){
			$youngest = $categories[0];
		}
		else{
			$cnt = 0;
			foreach((array)$categories as $category){
				/**
				 * @reference (WP)
				 * 	Merge all term children into a single array of their IDs.
				 * 	https://developer.wordpress.org/reference/functions/get_term_children/
				*/
				$children = get_term_children($category->term_id,'category');
				if($children){
					if($cnt < count($children)){
						$cnt = count($children);
						$lot_children = $children;

						foreach($lot_children as $child){
							/**
							 * @reference (WP)
							 * 	Checks if the current post is within any of the given categories.
							 * 	https://developer.wordpress.org/reference/functions/in_category/
							*/
							if(in_category($child,$post_id)){
								/**
								 * @reference (WP)
								 * 	Retrieves category data given a category ID or category object.
								 * 	https://developer.wordpress.org/reference/functions/get_category/
								*/
								$youngest = get_category($child);
							}
						}
					}
				}
				else{
					$youngest = $category;
				}
			}
		}
		return $youngest;

	}// Method


	/**
		@access (private)
		@param (array) $taxes
			Taxonomy name that $term is part of.
		@param (string) $mytaxonomy
		@return (string)
	*/
	private function get_youngest_taxonomy($post_id = 0,$taxes,$mytaxonomy)
	{
		if($post_id === 0){
			// Get current post data.
			$post = __utility_get_post_object();
			$post_id = $post->ID;
		}

		if(count($taxes) == 1){
			$youngest = $taxes[key($taxes)];
		}
		else{
			$cnt = 0;
			foreach($taxes as $tax){
				/**
				 * @reference (WP)
				 * 	Merge all term children into a single array of their IDs.
				 * 	https://developer.wordpress.org/reference/functions/get_term_children/
				*/
				$children = get_term_children($tax->term_id,$mytaxonomy);
				if($children){
					if($cnt < count($children)){
						$cnt = count($children);
						$lot_children = $children;

						foreach($lot_children as $child){
							/**
							 * @reference (WP)
							 * 	Merge all term children into a single array of their IDs.
							 * 	https://developer.wordpress.org/reference/functions/is_object_in_term/
							*/
							if(is_object_in_term($post->ID,$mytaxonomy)){
								/**
								 * @reference (WP)
								 * 	Get all Term data from database by Term ID.
								 * 	https://developer.wordpress.org/reference/functions/get_term/
								*/
								$youngest = get_term($child,$mytaxonomy);
							}
						}
					}
				}
				else{
					$youngest = $tax;
				}
			}
		}
		return $youngest;

	}// Method


}// Class
endif;
// new _app_breadcrumb();
_app_breadcrumb::__get_instance();
