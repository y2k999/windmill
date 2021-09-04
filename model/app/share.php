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
if(class_exists('_app_share') === FALSE) :
class _app_share
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_param()
 * 	set_icon()
 * 	set_url()
 * 	set_hook()
 * 	invoke_hook()
 * 	__the_template()
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
		@var (array) $icon
			Icons for SNS services.
		@var (array) $url
			Urls for SNS services.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_param = array();
	private $icon = array();
	private $url = array();
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

		$this->icon = $this->set_icon();
		$this->url = $this->set_url();

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook($this->hook);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_icon()
	{
		/**
			@access (private)
				Set icons for the SNS share services.
			@return (array)
				_filter[_app_share][icon]
			@reference
				[Parent]/inc/customizer/option.php
				[Parent]/inc/utility/general.php
				[Parent]/inc/utility/theme.php
				[Parent]/model/data/icon.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$return = array();
		foreach(__utility_get_value(self::$_index) as $item){
			$return[$item] = __utility_get_icon($item);
		}

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",$return);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_url()
	{
		/**
			@access (private)
				Set urls for the SNS share services.
				'twitter' => 'http://twitter.com/share?text=' . $share_title . '&url=' . $share_url,
				'line' => 'http://line.me/R/msg/text/?' . $share_title . '%0A' . $share_url,
				'facebook' => 'http://www.facebook.com/sharer.php?src=bm&u=' . $share_url . '&t=' . $share_title,
			@return (array)
				_filter[_app_share][url]
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
			'twitter' => 'http://twitter.com/share?text=',
			'line' => 'http://line.me/R/msg/text/?',
			'facebook' => 'http://www.facebook.com/sharer.php?src=bm&u=',
			'getpocket' => 'http://getpocket.com/edit?url=',
			'hatena' => 'http://b.hatena.ne.jp/add?mode=confirm&url=',
			'pinterest' => 'https://pinterest.com/pin/create/button/?url=',
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
				_filter[_app_share][hook]
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
				[Parent]/controller/fragment/share.php
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/theme.php
				[Parent]/template-part/content/content.php
				[Parent]/template-part/content/content-page.php
		*/
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
		beans_open_markup_e("_section[{$class}]",'div',array('class' => self::$_index));

			/**
			 * @since 1.0.1
			 * 	Widget title.
			 * @reference
			 * 	[Parent]/inc/trait/theme.php
			*/
			if(isset(self::$_param['title'])){
				self::__the_title(self::$_param['title'],'div');
			}

			/**
			 * @since 1.0.1
			 * 	Widget content.
			 * @reference
			 * 	[Parent]/asset/inline/share.php
			 * 	[Parent]/inc/customizer/default.php
			 * 	[Parent]/inc/env/enqueue.php
			 * 	[Parent]/model/data/icon.php
			*/
			beans_open_markup_e("_wrapper[{$class}]",'div',array('class' => self::$_param['skin']));
				switch(self::$_param['skin']){
					case 'shape-1' :
						beans_open_markup_e("_list[{$class}]",'ul',__utility_get_grid('even',array('class' => 'uk-flex-center')));
						break;

					case 'shape-2' :
						beans_open_markup_e("_list[{$class}]",'ul',__utility_get_grid('default',array('class' => 'uk-flex-center')));
						break;

					case 'stylish-1' :
					case 'stylish-2' :
						beans_open_markup_e("_list[{$class}]",'ul',__utility_get_grid('quarter',array('class' => 'uk-flex-center')));
						break;

					default :
						beans_open_markup_e("_list[{$class}]",'ul',__utility_get_grid('third',array('class' => 'uk-flex-center')));
						break;
				}

				/**
					@hooked
						_app_share::__the_render()
					@reference
						[Parent]/model/app/share.php
				*/
				do_action(HOOK_POINT['model'][$index]['main']);

				beans_close_markup_e("_list[{$class}]",'ul');
			beans_close_markup_e("_wrapper[{$class}]",'div');

		beans_close_markup_e("_section[{$class}]",'div');

		do_action(HOOK_POINT['model'][$index]['append']);

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_render()
	{
		/**
			@access (public)
				Echo the content of the application.
			@return (void)
			@hook (beans id)
				_app_share__the_render
			@reference
				[Parent]/inc/utility/theme.php
				[Parent]/model/data/icon.php
		*/
		if(empty($this->icon)){return;}

		$class = self::$_class;

		foreach((array)$this->icon as $key => $value){
			switch($key){
				case 'twitter' :
					$href = $this->url[$key] . urlencode(get_the_title()) . '&url=' . urlencode(get_permalink());
					break;

				case 'line' :
					$href = $this->url[$key] . urlencode(get_the_title()) . '%0A' . urlencode(get_permalink());
					break;

				case 'facebook' :
					$href = $this->url[$key] . urlencode(get_permalink()) . '&t=' . urlencode(get_the_title());
					break;

				case 'getpocket' :
				case 'hatena' :
				case 'pinterest' :
				default :
					$href = $this->url[$key] . urlencode(get_permalink());
					break;
			}

			/**
			 * @reference (Beans)
			 * 	HTML markup.
			 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
			 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
			 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
			*/
			beans_open_markup_e("_item[{$class}]",'li',array('class' => 'share-' . $key));
				beans_open_markup_e("_link[{$class}]",'a',array(
					'class' => 'share-' . $key,
					'href' => $href,
					'aria-label' => $key,
					'target' => '_blank',
					'rel' => 'noopener noreferrer',
					'itemprop' => 'url sameAs',
				));
					beans_output_e("_output[{$class}][icon]",__utility_get_icon($key));

					beans_open_markup_e("_label[{$class}]",'span',array('class' => 'uk-padding-small uk-padding-remove-vertical label'));
						beans_output_e("_output[{$class}][label]",ucfirst($key));
					beans_close_markup_e("_label[{$class}]",'span');

				beans_close_markup_e("_link[{$class}]",'a');
			beans_close_markup_e("_item[{$class}]",'li');
		}

	}// Method


}// Class
endif;
// new _app_share();
_app_share::__get_instance();
