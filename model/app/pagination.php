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
if(class_exists('_app_pagination') === FALSE) :
class _app_pagination
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_param()
 * 	set_hook()
 * 	invoke_hook()
 * 	__the_template()
 * 	__the_render()
 * 	get_link()
 * 	__the_paginate_links()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $_param
			Parameter for the application.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_param = array();
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
				[Parent]/inc/trait/theme.php
				[Parent]/inc/utility/general.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);
		self::$_param = $this->set_param(self::$_index);

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
				_filter[_app_pagination][hook]
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
			'__the_render' => array(
				'beans_id' => $class . '__the_render',
				'tag' => 'beans_add_action',
				'hook' => HOOK_POINT['model'][$index]['main']
			),
/*
			'__the_paginate_links' => array(
				'beans_id' => $class . '__the_paginate_links',
				'tag' => 'beans_add_action',
				'hook' => HOOK_POINT['model'][$index]['main']
			),
*/
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
				[Parent]/controller/structure/archive.php
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/general.php
				[Parent]/template/content/archive.php
				[Parent]/template/content/index.php
		*/
		if(!__utility_is_archive()){return;}

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

		do_action(HOOK_POINT['model'][$index]['prepend']);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_nav[{$class}]",'nav',array(
			'id' => 'pagination',
			'class' => 'pagination',
			'role' => 'navigation',
			// Attributes are automatically escaped.
			'aria-label' => esc_attr('Pagination'),
		));

			/**
				@hooked
					_app_pagination::__the_render()
					_app_pagination::__the_paginate_links()
				@reference
					[Parent]/model/app/pagination.php
			*/
			do_action(HOOK_POINT['model'][$index]['main']);

		beans_close_markup_e("_nav[{$class}]",'nav');

		do_action(HOOK_POINT['model'][$index]['append']);

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_render($pages = '')
	{
		/**
			@access (public)
				Echo the content of the application.
			@global (WP_Query) $wp_query
			@global (array) $pages
				The content of the pages of the current post.
				Each page elements contains part of the content separated by the <!--nextpage--> tag.
			@global (int) $paged
				https://codex.wordpress.org/Global_Variables
			@param (array) $pages
			@return (void)
			@hook (beans id)
				_app_pagination__the_render
			@reference
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// Number of pages to be displayed.
		$range = self::$_param['range'];
		$showitems = ($range * 2) + 1;
	
		// Current
		global $paged;

		if(empty($paged)){
			// Default page.
			$paged = 1;
		}

		// Get the total num of pages.
		if($pages === ''){
			// WP global.
			global $wp_query;
			$pages = $wp_query->max_num_pages;

			// If the total number of pages is empty, set 1.
			if(!$pages){
				$pages = 1;
			}
		}

		if(1 !== $pages){

			/**
			 * @reference (Beans)
			 * 	HTML markup.
			 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
			 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
			 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
			 * @reference (Uikit)
			 * 	https://getuikit.com/docs/pagination
			*/
			beans_open_markup_e("_list[{$class}][{$function}]",'ul',array('class' => 'uk-pagination uk-flex-center uk-padding nav-links'));

				beans_open_markup_e("_item[{$class}][{$function}][page_of]",'li');
					beans_open_markup_e("_label[{$class}][{$function}][page_of]",'span',array('class' => 'page_of'));
						beans_output_e("_output[{$class}][{$function}][page_of]",esc_html__('Page ','windmill') . $paged . '/' . $pages);
					beans_close_markup_e("_label[{$class}][{$function}][page_of]",'span');
				beans_close_markup_e("_item[{$class}][{$function}][page_of]",'li');

				// First
				if(($paged > 2) && ($paged > $range + 1) && ($showitems < $pages)){
					$this->get_link('first',1);
				}

				// Previous
				if($paged > 1 && ($showitems < $pages)){
					$this->get_link('previous',$paged - 1);
				}

				// Page Number.
				for($i = 1; $i <= $pages; $i++){
					if((1 !== $pages) && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)){

						if($paged == $i){
							beans_open_markup_e("_item[{$class}][{$function}][active]",'li',array('class' => 'uk-active active'));
								beans_open_markup_e("_label[{$class}][{$function}][active]",'span');
									beans_output_e("_output[{$class}][{$function}][active]",$i);
								beans_close_markup_e("_label[{$class}][{$function}][active]",'span');
							beans_close_markup_e("_item[{$class}][{$function}][active]",'li');
						}
						else{
							beans_open_markup_e("_item[{$class}][{$function}][inactive]",'li');
								beans_open_markup_e("_link[{$class}][{$function}][inactive]",'a',array(
									/**
									 * @reference (WP)
									 * 	Retrieves the link for a page number.
									 * 	https://developer.wordpress.org/reference/functions/get_pagenum_link/
									*/
									'href' => get_pagenum_link($i),
									'aria-label' => esc_attr('Page Number'),
								));
									beans_output_e("_output[{$class}][{$function}][inactive]",$i);
								beans_close_markup_e("_link[{$class}][{$function}][inactive]",'a');
							beans_close_markup_e("_item[{$class}][{$function}][inactive]",'li');
						}
					}
				}

				// Next.
				if(($paged < $pages) && ($showitems < $pages)){
					$this->get_link('next',$paged + 1);
				}

				// Last.
				if(($paged < $pages - 1) && ($paged + $range - 1 < $pages) && ($showitems < $pages)){
					$this->get_link('last',$pages);
				}
		}

		beans_close_markup_e("_list[{$class}][{$function}]",'ul');

	}// Method


	/**
		@access (private)
			Retrieves the link for a page number.
		@param (string) $position
		@param (string) $pages
			Page number.
		@return (string)
			The link URL for the given page number.
		@reference
			[Parent]/inc/utility/general.php
	*/
	private function get_link($position = '',$pages)
	{
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_item[{$class}][{$function}][{$position}]",'li');
			beans_open_markup_e("_link[{$class}][{$function}][{$position}]",'a',array(
				/**
				 * @reference (WP)
				 * 	Retrieves the link for a page number.
				 * 	https://developer.wordpress.org/reference/functions/get_pagenum_link/
				*/
				'href' => get_pagenum_link($pages),
				'aria-label' => esc_attr($position),
				'class'	 => $position === '' ? 'inactive' : ''
			));
				beans_output_e("_output[{$class}][{$function}][{$position}]",self::$_param[$position]);

			beans_close_markup_e("_link[{$class}][{$function}][{$position}]",'a');
		beans_close_markup_e("_item[{$class}][{$function}][{$position}]",'li');

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_paginate_links()
	{
		/**
			@access (public)
				Echo paginated links for archive post pages.
			@return (void)
			@hook (beans id)
				_app_pagination__the_paginate_links
			@reference
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Retrieves paginated links for archive post pages.
		 * 	https://developer.wordpress.org/reference/functions/paginate_links/
		*/
		$page_links = paginate_links(array(
			// 'prev_text' => self::$_param['previous'],
			// 'prev_text' => '<',
			// 'next_text' => self::$_param['next'],
			// 'next_text' => '>',
			'type' => 'array',
		));

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		 * @reference (Uikit)
		 * 	https://getuikit.com/docs/pagination
		*/
		beans_open_markup_e("_list[{$class}][{$function}]",'ul',array('class' => 'uk-text-center'));
			beans_open_markup_e("_item[{$class}][{$function}]",'li');
				beans_output_e("_output[{$class}][{$function}]",join('</li><li>',$page_links));
			beans_close_markup_e("_item[{$class}][{$function}]",'li');
		beans_close_markup_e("_list[{$class}][{$function}]",'ul');

	}// Method


}// Class
endif;
// new _app_pagination();
_app_pagination::__get_instance();
