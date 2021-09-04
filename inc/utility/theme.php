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
 * 	__utility_is_beans()
 * 	__utility_is_uikit()
 * 	__utility_get_section()
 * 	__utility_get_container()
 * 	__utility_get_grid()
 * 	__utility_get_column()
 * 	__utility_template_header()
 * 	__utility_template_content()
 * 	__utility_template_sidebar()
 * 	__utility_template_footer()
 * 	__utility_set_cache()
 * 	__utility_delete_cache()
 * 	__utility_get_cache()
 * 	__utility_app_amp()
 * 	__utility_app_back2top()
 * 	__utility_app_branding()
 * 	__utility_app_breadcrumb()
 * 	__utility_app_comment()
 * 	__utility_app_credit()
 * 	__utility_app_excerpt()
 * 	__utility_app_follow()
 * 	__utility_app_meta()
 * 	__utility_app_nav()
 * 	__utility_app_pagination()
 * 	__utility_app_post_link()
 * 	__utility_app_search()
 * 	__utility_app_share()
 * 	__utility_app_sitemap()
*/


	/* Method
	_________________________
	*/
	if(!function_exists('__utility_is_beans')) :
	function __utility_is_beans($api = '')
	{
		/**
			@access (public)
				Check if the Beans API component is active.
			@param (string) $api
				[Optional]
				The name of the Beans API component.
			@return (bool)
			@reference
				[Parent]/inc/setup/theme-support.php
				[Parent]/inc/setup/widget-area.php
				[Parent]/model/app/dynamic-sidebar.php
				[Parent]/model/app/image.php
				[Plugin]/beans_extension/include/constant.php
				[Plugin]/beans_extension/admin/tab/general.php
		*/
		$image = beans_get_general_setting('stop_image');
		$widget = beans_get_general_setting('stop_widget');

		switch($api){
			case 'widget' :
				if(class_exists('\Beans_Extension\_beans_widget') === TRUE){
					if(isset($widget) && $widget){
						return FALSE;
						// return TRUE;
					}
					else{
						return TRUE;
						// return FALSE;
					}
				}
				else{
					return FALSE;
					// return TRUE;
				}
				break;
			case 'uikit' :
				if(class_exists('\Beans_Extension\_beans_uikit') === TRUE){
					return TRUE;
				}
				else{
					return FALSE;
				}
				break;
			case 'image' :
				if(class_exists('\Beans_Extension\_beans_image') === TRUE){
					if(isset($image) && $image){
						return FALSE;
					}
					else{
						return TRUE;
					}
				}
				else{
					return FALSE;
				}
				break;
			default :
					return TRUE;
				break;
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(!function_exists('__utility_is_uikit')) :
	function __utility_is_uikit()
	{
		/**
			@access (public)
				Check if the Beans Extension plugin (that's default css is Uikit) is active.
			@return (bool)
			@reference
				[Parent]/asset/inline/nav.php
				[Parent]/controller/render/grid.php
				[Parent]/controller/layout.php
				[Parent]/controller/widget.php
				[Parent]/inc/env/enqueue.php
				[Parent]/inc/env/content.php
				[Parent]/inc/setup/theme-support.php
				[Parent]/inc/utility/general.php
				[Parent]/model/app/image.php
				[Parent]/model/app/nav.php
				[Parent]/model/data/icon.php
		*/
		$return = FALSE;

		if(__utility_is_active_plugin('beans-extension/beans-extension.php')){
			$return = TRUE;
		}
		else{
			$return = TRUE;
		}
		return $return;

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_get_section') === FALSE) :
	function __utility_get_section($needle = '',$args = array())
	{
		/**
			@access (public)
				Get the Uikit section definition for this theme.
			@param (string) $needle
				The name of the specialised section.
				 - masthead
				 - content
				 - colophone
			@param (array) $args
				Additional arguments passed to the layout controller.
			@return (array)
				[Parent]/controller/layout.php
		*/
		if(is_callable(['_controller_layout','__get_section'])){
			return _controller_layout::__get_section($needle,$args);
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_get_container') === FALSE) :
	function __utility_get_container($needle = '',$args = array())
	{
		/**
			@access (public)
				Get the Uikit container definition for this theme.
			@param (string) $needle
				The name of the specialised container.
				 - default
				 - masthead
				 - content
				 - colophone
			@param (array) $args
				Additional arguments passed to the layout controller.
			@return (array)
				[Parent]/controller/layout.php
				[Parent]/model/wrap/breadcrumb.php
		*/
		if(is_callable(['_controller_layout','__get_container'])){
			return _controller_layout::__get_container($needle,$args);
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_get_grid') === FALSE) :
	function __utility_get_grid($needle = '',$args = array())
	{
		/**
			@access (public)
				Get the Uikit grid definition for this theme.
			@param (string) $needle
				The name of the specialised grid.
				 - general
				 - masthead
				 - colophone
				 - secondary
			@param (array) $args
				Additional arguments passed to the layout controller.
			@return (array)
				[Parent]/controller/layout.php
				[Parent]/model/app/share.php
				[Parent]/model/widget/recent.php
				[Parent]/model/widget/relation.php
				[Parent]/model/wrap/breadcrumb.php
		*/
		if(is_callable(['_controller_layout','__get_grid'])){
			return _controller_layout::__get_grid($needle,$args);
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_get_column') === FALSE) :
	function __utility_get_column($needle = '',$args = array())
	{
		/**
			@access (public)
				Get the Uikit column/width definition for this theme.
			@param (string) $needle
				The name of the specialised column/width.
				 - default
				 - full
				 - half
				 - widget
				 - image
				 - description
				 - card
				 - button
				 - primary
				 - secondary
			@param (array) $args
				Additional arguments passed to the layout controller.
			@return (array)
				[Parent]/controller/layout.php
				[Parent]/controller/structure/header.php
				[Parent]/model/app/sitemap.php
				[Parent]/model/app/title.php
				[Parent]/model/wrap/back2top.php
				[Parent]/model/wrap/branding.php
				[Parent]/model/wrap/breadcrumb.php
				[Parent]/model/wrap/credit.php
				[Parent]/model/wrap/nav.php
		*/
		if(is_callable(['_controller_layout','__get_column'])){
			return _controller_layout::__get_column($needle,$args);
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_template_header') === FALSE) :
	function __utility_template_header($file = '')
	{
		/**
			@access (public)
				Load the header template file.
			@param (string) $file
				The filename of the template file.
				__FILE__ is usually to argument to pass.
			@return (void)
				[Parent]/controller/template.php
				[Parent]/header.php
		*/
		if(is_callable(['_controller_template','__render_header'])){
			return _controller_template::__render_header($file);
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_template_content') === FALSE) :
	function __utility_template_content($file = '')
	{
		/**
			@access (public)
				Load the content template file.
			@param (string) $file
				The filename of the template file.
				__FILE__ is usually to argument to pass.
			@return (void)
				[Parent]/controller/template.php
				[Parent]/404.php
				[Parent]/archive.php
				[Parent]/index.php
				[Parent]/singular.php
		*/
		if(is_callable(['_controller_template','__render_content'])){
			return _controller_template::__render_content($file);
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_template_sidebar') === FALSE) :
	function __utility_template_sidebar($file = '')
	{
		/**
			@access (public)
				Load the sidebar template file.
			@param (string) $file
				The filename of the template file.
				__FILE__ is usually to argument to pass.
			@return (void)
				[Parent]/controller/template.php
				[Parent]/sidebar.php
		*/
		if(is_callable(['_controller_template','__render_sidebar'])){
			return _controller_template::__render_sidebar($file);
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_template_footer') === FALSE) :
	function __utility_template_footer($file = '')
	{
		/**
			@access (public)
				Load the footer template file.
			@param (string) $file
				The filename of the template file.
				__FILE__ is usually to argument to pass.
			@return (void)
				[Parent]/controller/template.php
				[Parent]/footer.php
		*/
		if(is_callable(['_controller_template','__render_footer'])){
			return _controller_template::__render_footer($file);
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_set_cache') === FALSE) :
	function __utility_set_cache($needle,$obj,$param,$expiration,$force = FALSE)
	{
		/**
			@access (public)
				Set query cache data.
			@param (string) $needle
				Transient name.
			@param (mixed) $obj
				Transient value.
			@param (array) $param
			@param (mixed) $expiration
				Time until expiration in seconds.
			@param (bool) $force
			@return (bool)
				[Parent]/controller/cache.php
				[Parent]/inc/env/blogcard.php
		*/
		if(is_callable(['_env_cache','__set_data'])){
			return _controller_cache::__set_data($needle,$obj,$param,$expiration,$force = FALSE);
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_delete_cache') === FALSE) :
	function __utility_delete_cache($needle,$param)
	{
		/**
			@access (public)
				Delete cache data.
			@param (string) $needle
				Transient name.
			@param (array) $param
			@return (bool)
				[Parent]/controller/cache.php
				[Parent]/inc/env/blogcard.php
		*/
		if(is_callable(['_env_cache','__delete_data'])){
			return _controller_cache::__delete_data($needle,$param);
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_get_cache') === FALSE) :
	function __utility_get_cache($needle,$param)
	{
		/**
			@access (public)
				Get cache data.
			@param (string) $needle
				Transient name.
			@param (array) $param
			@return (mixed)
				[Parent]/controller/cache.php
				[Parent]/inc/env/blogcard.php
		*/
		if(is_callable(['_env_cache','__get_data'])){
			return _controller_cache::__get_data($needle,$param);
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_app_amp') === FALSE) :
	function __utility_app_amp($args = array())
	{
		/**
			@access (public)
				Call the application component.
			@param (array) $args
				[Optional]
				Additional arguments passed to the application.
			@return (mixed)
				[Parent]/model/app/amp.php
		*/
		if(is_callable(['_app_amp','__the_template'])){
			return _app_amp::__the_template($args);
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_app_back2top') === FALSE) :
	function __utility_app_back2top($args = array())
	{
		/**
			@access (public)
				Call the application component.
			@param (array) $args
				[Optional]
				Additional arguments passed to the application.
			@return (mixed)
				[Parent]/model/app/back2top.php
		*/
		if(is_callable(['_app_back2top','__the_template'])){
			return _app_back2top::__the_template($args);
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_app_branding') === FALSE) :
	function __utility_app_branding($args = array())
	{
		/**
			@access (public)
				Call the application component.
			@param (array) $args
				[Optional]
				Additional arguments passed to the application.
			@return (mixed)
				[Parent]/model/app/branding.php
		*/
		if(is_callable(['_app_branding','__the_template'])){
			return _app_branding::__the_template($args);
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_app_breadcrumb') === FALSE) :
	function __utility_app_breadcrumb($args = array())
	{
		/**
			@access (public)
				Call the application component.
			@param (array) $args
				[Optional]
				Additional arguments passed to the application.
			@return (mixed)
				[Parent]/model/app/breadcrumb.php
		*/
		if(is_callable(['_app_breadcrumb','__the_template'])){
			return _app_breadcrumb::__the_template($args);
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_app_comment') === FALSE) :
	function __utility_app_comment($args = array())
	{
		/**
			@access (public)
				Call the application component.
			@param (array) $args
				[Optional]
				Additional arguments passed to the application.
			@return (mixed)
				[Parent]/model/app/comment.php
		*/
		if(is_callable(['_app_comment','__the_template'])){
			return _app_comment::__the_template($args);
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_app_credit') === FALSE) :
	function __utility_app_credit($args = array())
	{
		/**
			@access (public)
				Call the application component.
			@param (array) $args
				[Optional]
				Additional arguments passed to the application.
			@return (mixed)
				[Parent]/model/app/credit.php
		*/
		if(is_callable(['_app_credit','__the_template'])){
			return _app_credit::__the_template($args);
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_app_excerpt') === FALSE) :
	function __utility_app_excerpt($args = array())
	{
		/**
			@access (public)
				Call the application component.
			@param (array) $args
				[Optional]
				Additional arguments passed to the application.
			@return (mixed)
				[Parent]/model/app/excerpt.php
		*/
		if(is_callable(['_app_excerpt','__the_template'])){
			return _app_excerpt::__the_template($args);
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_app_follow') === FALSE) :
	function __utility_app_follow($args = array())
	{
		/**
			@access (public)
				Call the application component.
			@param (array) $args
				[Optional]
				Additional arguments passed to the application.
			@return (mixed)
				[Parent]/model/app/follow.php
		*/
		if(is_callable(['_app_follow','__the_template'])){
			return _app_follow::__the_template($args);
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_app_meta') === FALSE) :
	function __utility_app_meta($args = array())
	{
		/**
			@access (public)
				Call the application component.
			@param (array) $args
				[Optional]
				Additional arguments passed to the application.
			@return (mixed)
				[Parent]/model/app/meta.php
		*/
		if(is_callable(['_app_meta','__the_template'])){
			return _app_meta::__the_template($args);
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_app_nav') === FALSE) :
	function __utility_app_nav($args = array())
	{
		/**
			@access (public)
				Call the application component.
			@param (array) $args
				[Optional]
				Additional arguments passed to the application.
			@return (mixed)
				[Parent]/model/app/nav.php
		*/
		if(is_callable(['_app_nav','__the_template'])){
			return _app_nav::__the_template($args);
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_app_pagination') === FALSE) :
	function __utility_app_pagination($args = array())
	{
		/**
			@access (public)
				Call the application component.
			@param (array) $args
				[Optional]
				Additional arguments passed to the application.
			@return (mixed)
				[Parent]/model/app/pagination.php
		*/
		if(is_callable(['_app_pagination','__the_template'])){
			return _app_pagination::__the_template($args);
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_app_post_link') === FALSE) :
	function __utility_app_post_link($args = array())
	{
		/**
			@access (public)
				Call the application component.
			@param (array) $args
				[Optional]
				Additional arguments passed to the application.
			@return (mixed)
				[Parent]/model/app/post_link.php
		*/
		if(is_callable(['_app_post_link','__the_template'])){
			return _app_post_link::__the_template($args);
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_app_search') === FALSE) :
	function __utility_app_search($args = array())
	{
		/**
			@access (public)
				Call the application component.
			@param (array) $args
				[Optional]
				Additional arguments passed to the application.
			@return (mixed)
				[Parent]/model/app/search.php
		*/
		if(is_callable(['_app_search','__the_template'])){
			return _app_search::__the_template($args);
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_app_share') === FALSE) :
	function __utility_app_share($args = array())
	{
		/**
			@access (public)
				Call the application component.
			@param (array) $args
				[Optional]
				Additional arguments passed to the application.
			@return (mixed)
				[Parent]/model/app/share.php
		*/
		if(is_callable(['_app_share','__the_template'])){
			return _app_share::__the_template($args);
		}

	}// Method
	endif;


	/* Method
	_________________________
	*/
	if(function_exists('__utility_app_sitemap') === FALSE) :
	function __utility_app_sitemap($args = array())
	{
		/**
			@access (public)
				Call the application component.
			@param (array) $args
				[Optional]
				Additional arguments passed to the application.
			@return (mixed)
				[Parent]/model/app/sitemap.php
		*/
		if(is_callable(['_app_sitemap','__the_template'])){
			return _app_sitemap::__the_template($args);
		}

	}// Method
	endif;
