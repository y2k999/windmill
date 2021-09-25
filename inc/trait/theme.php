<?php
/**
 * Shared traits.
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
if(trait_exists('_trait_theme') === FALSE) :
trait _trait_theme
{
/**
 * [TOC]
 * 	set_icon()
 * 	set_param()
 * 	set_color()
 * 	minify()
 * 	__activate_application()
 * 	__the_title()
 * 	__the_nopost()
 * 	__make_handle()
*/


	/* Setter
	_________________________
	*/
	public function set_icon($needle = '')
	{
		/**
			@access (public)
				Set the icon html for the application component.
			@param (string) $needle
				The name of the application.
			@return (string)
				Return the designated icon html.
			@reference
				[Parent]/controller/structure/header.php
				[Parent]/inc/utility/theme.php
				[Parent]/model/data/icon.php
				[Parent]/model/app/breadcrumb.php
				[Parent]/model/app/follow.php
				[Parent]/model/app/meta.php
				[Parent]/model/app/share.php

		*/
		if(!isset($needle)){return;}
		return __utility_get_icon($needle);

	}// Method


	/* Setter
	_________________________
	*/
	public function set_param($needle = '')
	{
		/**
			@access (public)
				Set the icon html for the application component.
			@param (string) $needle
				The name of the application.
			@return (array)
				Return the designated application param.
			@reference
				[Parent]/model/data/param.php
				[Parent]/model/app/amp.php
				[Parent]/model/app/back2top.php
				[Parent]/model/app/branding.php
				[Parent]/model/app/breadcrumb.php
				[Parent]/model/app/comments.php
				[Parent]/model/app/credit.php
				[Parent]/model/app/dynamic-sidebar.php
				[Parent]/model/app/excerpt.php
				[Parent]/model/app/follow.php
				[Parent]/model/app/html-sitemap.php
				[Parent]/model/app/image.php
				[Parent]/model/app/meta.php
				[Parent]/model/app/nav.php
				[Parent]/model/app/pagination.php
				[Parent]/model/app/post-link.php
				[Parent]/model/app/search.php
				[Parent]/model/app/share.php
				[Parent]/model/app/title.php
				[Parent]/model/shortcode/embed-card.php
				[Parent]/model/shortcode/hatena-card.php
				[Parent]/model/shortcode/ogp-card.php
				[Parent]/model/shortcode/toc.php
		*/
		if(!isset($needle)){return;}
		return _data_param::__get_setting($needle);

	}// Method


	/* Setter
	_________________________
	*/
	public function set_color()
	{
		/**
			@access (public)
				Set theme colors from theme customizer settings.
			@return (array)
				Return the registerd colors.
			@reference
				[Parent]/asset/inline/base.php
				[Parent]/asset/inline/button.php
				[Parent]/asset/inline/follow.php
				[Parent]/asset/inline/heading.php
				[Parent]/asset/inline/image.php
				[Parent]/asset/inline/nav.php
				[Parent]/asset/inline/pagination.php
				[Parent]/asset/inline/share.php
				[Parent]/inc/customizer/color.php
				[Parent]/inc/setup/gutenberg.php
				[Parent]/inc/utility/general.php
		*/
		return array(
			'text' => __utility_get_option('color_text'),
			'link' => __utility_get_option('color_link'),
			'hover' => __utility_get_option('color_hover'),
		);

	}// Method


	/* Method
	_________________________
	*/
	public function minify($data,$type = 'css')
	{
		/**
			@access (public)
				Minify Res.
			@param (string) $style
				The data value to be minified.
			@return (string)
				Minified value.
			@reference
				[Parent]/asset/inline/base.php
				[Parent]/asset/inline/button.php
				[Parent]/asset/inline/follow.php
				[Parent]/asset/inline/heading.php
				[Parent]/asset/inline/image.php
				[Parent]/asset/inline/nav.php
				[Parent]/asset/inline/pagination.php
				[Parent]/asset/inline/share.php
		*/
		if(!isset($data)){return;}

		switch($type){
			case 'css' :
			default :
				// Remove comments.
				$data = preg_replace('#/\*[^!][^*]*\*+([^/][^*]*\*+)*/#','',$data);

				// Remove space after colon.
				$data = str_replace(': ',':',$data);

				// Remove tab, space, newline etc.
				$data = str_replace(["\r\n","\r","\n","\t",'  ','    '],'',$data);
		}
		return $data;

	}// Method


	/* Method
	_________________________
	*/
	public static function __activate_application($needle = '',$args = array())
	{
		/**
			@access (public)
				Call the application component.
			@param (string) $needle
				The name of the application.
			@param (array) $args
				Additional arguments passed to the application.
			@return (void)
			@reference
				[Parent]/controller/structure/archive.php
				[Parent]/controller/structure/footer.php
				[Parent]/controller/structure/header.php
				[Parent]/controller/structure/page.php
				[Parent]/controller/structure/sidebar.php
				[Parent]/controller/structure/single.php
				[Parent]/controller/fragment/excerpt.php
				[Parent]/controller/fragment/image.php
				[Parent]/controller/fragment/meta.php
				[Parent]/controller/fragment/share.php
				[Parent]/inc/setup/constant.php
				[Parent]/model/data/map.php
		*/
		if(!$needle){return;}
		$needle = strtolower($needle);
		$class = str_replace('-','_',$needle);
		$file = str_replace('_','-',$needle);

		$map = _data_map::__get_setting($file);

		switch($map){
			case 'widget' :
				/**
				 * @reference (WP)
				 * 	Output an arbitrary widget as a template tag.
				 * 	https://developer.wordpress.org/reference/functions/the_widget/
				*/
				the_widget(PREFIX['widget'] . $class,$args);
				break;

			case 'app' :
				call_user_func([PREFIX['app'] . $class,'__the_template'],$args);
				break;

			case 'shortcode' :
				/**
				 * @reference (WP)
				 * 	Loads a template part into a template.
				 * 	https://developer.wordpress.org/reference/functions/get_template_part/
				*/
				get_template_part(SLUG['shortcode'] . $file);
				break;

			default :
				get_template_part(SLUG['app'] . $file,NULL,$args);
				break;
		}

	}// Method


	/* Method
	_________________________
	*/
	public static function __the_title($text = '')
	{
		/**
			@access (public)
				Echo the title.
			@param (string) $text
				Title text to render.
			@return (void)
			@reference
				[Parent]/inc/customizer/option.php
				[Parent]/inc/utility/general.php
				[Parent]/model/app/comments.php
				[Parent]/model/app/html-sitemap.php
				[Parent]/model/app/share.php
				[Parent]/model/widget/profile.php
				[Parent]/model/widget/recent.php
				[Parent]/model/widget/relation.php
		*/
		if(!$text){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_tag[{$class}][{$function}]",__utility_get_option('tag_widget-title'),array('class' => 'uk-margin-medium-top uk-text-center widget-title'));
			beans_output_e("_output[{$class}][{$function}]",$text);
		beans_close_markup_e("_tag[{$class}][{$function}]",__utility_get_option('tag_widget-title'));

	}// Method


	/* Method
	_________________________
	*/
	public static function __the_nopost()
	{
		/**
			@access (public)
				Echo the no post message.
			@return (void)
			@reference
				[Parent]/inc/customizer/option.php
				[Parent]/inc/utility/general.php
				[Parent]/model/widget/recent.php
				[Parent]/model/widget/relation.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		 * @reference (Uikit)
		 * 	https://getuikit.com/docs/alert
		*/
		beans_open_markup_e("_paragraph[{$class}][{$function}]",__utility_get_option('tag_site-description'),array('class' => 'uk-alert-warning'));
			beans_output_e("_output[{$class}][{$function}]",__utility_get_option('message_nopost'));
		beans_close_markup_e("_paragraph[{$class}][{$function}]",__utility_get_option('tag_site-description'));

	}// Method


	/* Method
	_________________________
	*/
	public static function __make_handle($additional = '')
	{
		/**
			@access (public)
				Returns script handle
			@param (string) $additional
				Additional string. Must be unique.
			@return (string)
				Name of the script. Should be unique.
			@reference
				[Parent]/inc/env/enqueue.php
				[Parent]/inc/env/inline-style.php
				[Parent]/inc/setup/gutenberg.php
				[Parent]/inc/trait/theme.php
		*/
		if(isset($additional)){
			$handle = __utility_make_handle($additional);
		}
		else{
			$class = str_replace('_','-',self::$_class);
			$handle = __utility_make_handle($class);
		}

		return $handle;

	}// Method


}// Trait
endif;
