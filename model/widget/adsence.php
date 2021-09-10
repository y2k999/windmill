<?php
/**
 * Child class that extends _widget_base (parrent class).
 * @link https://codex.wordpress.org/Widgets_API
 * @package Windmill
 * @license GPL3.0+
 * @since 1.0.1
*/

/**
 * Inspired by Core class used to implement WP_Widget.
 * @link https://codex.wordpress.org/Widgets_API
 * @see WP_Widget
 * 
 * Inspired by Magazine Plus WordPress theme.
 * @link https://wenthemes.com/item/wordpress-themes/magazine-plus/
 * @see WEN Themes
 * 
 * Inspired by Eggnews WordPress theme.
 * @link https://themeegg.com/themes/eggnews/
 * @see ThemeEgg
*/


/* Prepare
______________________________
*/

// If this file is called directly,abort.
if(!defined('WPINC')){die;}

// Set identifiers for this template.
// $index = basename(__FILE__,'.php');


	beans_add_smart_action('widgets_init','__register_widget_adsence');
	/**
	 * @reference (Beans)
	 * 	Set beans_add_action() using the callback argument as the action ID.
	 * 	https://www.getbeans.io/code-reference/functions/beans_add_smart_action/
	 * @reference (WP)
	 * 	Fires after all default WordPress widgets have been registered.
	 * 	https://developer.wordpress.org/reference/hooks/widgets_init/
	*/
	if(function_exists('__register_widget_adsence') === FALSE) :
	function __register_widget_adsence()
	{
		/**
		 * @reference (WP)
		 * 	Register Widget
		 * 	https://developer.wordpress.org/reference/functions/register_widget/
		*/
		register_widget('_widget_adsence');

	}// Method
	endif;


/* Exec
______________________________
*/
if(!class_exists('_widget_adsence')) :
class _widget_adsence extends _widget_base
{
/**
 * [TOC]
 * 	__construct()
 * 	set_args()
 * 	set_code()
 * 	set_field()
 * 	set_hook()
 * 	invoke_hook()
 * 	widget()
 * 		get_param()
 * 	form()
 * 	update()
 * 	__the_render()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $args
			Parameters for this application.
		@var (array) $code
			Registerd adsence codes.
		@var(array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private $args = array();
	private $code = array();
	private $hook = array();

	/**
	 * Traits.
	*/
	use _trait_hook;


	/* Constructor
	_________________________
	*/
	public function __construct()
	{
		/**
			@access (public)
				Sets up a new widget instance.
			@return (void)
			@reference
				[Parent]/inc/utility/general.php
				[Parent]/model/widget/base.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);
		$this->args = $this->set_args();
		$this->code = $this->set_code();

		$widget_options = array(
			'classname' => 'widget' . self::$_class,
			'description' => '[Windmill]' . ' ' . ucfirst(self::$_index),
			'customize_selective_refresh' => TRUE,
		);

		parent::__construct(
			self::$_index,
			ucfirst(self::$_index),
			$widget_options,
			array(),
			$this->set_field()
		);

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook($this->hook);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_args()
	{
		/**
			@access (private)
				Set parameters for this application.
			@return (array)
				_filter[_widget_adsence][args]
			@reference
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		 * @reference
		 * 	The Lorem Ipsum for photos.
		 * 	https://picsum.photos/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'728' => array(
				'src' => 'https://picsum.photos/id/1041/728/90',
				'data-src' => 'https://picsum.photos/id/1041/728/90',
				'width' => 728,
				'height' => 90,
				'alt' => esc_attr('728px Width'),
			),
			'640' => array(
				'src' => 'https://picsum.photos/id/1022/640/100',
				'data-src' => 'https://picsum.photos/id/1022/640/100',
				'width' => 640,
				'height' => 100,
				'alt' => esc_attr('640px Width'),
			),
			'468' => array(
				'src' => 'https://picsum.photos/id/238/468/60',
				'data-src' => 'https://picsum.photos/id/238/468/60',
				'width' => 468,
				'height' => 60,
				'alt' => esc_attr('468px Width'),
			),
			'320' => array(
				'src' => 'https://picsum.photos/id/274/320/100',
				'data-src' => 'https://picsum.photos/id/274/320/100',
				'width' => 320,
				'height' => 100,
				'alt' => esc_attr('320px Width'),
			),
			'300' => array(
				'src' => 'https://picsum.photos/id/342/300/250',
				'data-src' => 'https://picsum.photos/id/342/300/250',
				'width' => 300,
				'height' => 250,
				'alt' => esc_attr('300px Width'),
			),
			'234' => array(
				'src' => 'https://picsum.photos/id/360/234/60',
				'data-src' => 'https://picsum.photos/id/360/234/60',
				'width' => 234,
				'height' => 60,
				'alt' => esc_attr('234px Width'),
			),
		));

	}// Method


	/* Setter
	_________________________
	*/
	private function set_code()
	{
		/**
			@access (private)
				Set adsence codes.
			@return (array)
				_filter[_widget_adsence][code]
			@reference
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$return = array();

		/**
		 * @reference (Beans)
		 * 	Register self-close markup and attributes by ID.
		 * 	https://www.getbeans.io/code-reference/functions/beans_selfclose_markup/
		*/
		foreach($this->args as $key => $value){
			$return[$key] = beans_selfclose_markup("_src[{$class}][{$function}][{$key}]",'img',array(
				'src' => $value['src'],
				'data-src' => $value['data-src'],
				'width' => $value['width'],
				'height' => $value['height'],
				'alt' => $value['alt'],
				'itemprop' => 'image',
				'uk-img' => '',
			));
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
	private function set_field()
	{
		/**
			@access (private)
				Helper function that holds widget fields.
				Array is used in update and form functions.
			@return (array)
				_filter[_widget_adsence][field]
			@reference
				[Parent/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'title' => array(
				'label' => esc_html__('Title','windmill'),
				'type' => 'text',
				'default' => esc_html__('Sponsored Link','windmill'),
			),
			'width' => array(
				'label' => esc_html__('Width','windmill'),
				'type' => 'select',
				'option' => array(
					'728',
					'640',
					'468',
					'320',
					'300',
					'234',
				),
				'default' => 4,
			),
			'code' => array(
				'label' => esc_html__('Code','windmill'),
				'type' => 'textarea',
				'default' => '',
			),
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
				_filter[_widget_adsence][hook]
			@reference
				[Parent]/inc/trait/hook.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",$this->set_parameter_callback(array(
			// '__the_render' => ['tag' => 'beans_add_filter','hook' => 'the_content','priority' => PRIORITY['mid-high']],
			// // '__the_render' => ['tag' => 'beans_add_filter','hook' => 'the_content'],
		)));

	}// Method


	/* Method
	_________________________
	*/
	public function widget($args,$instance)
	{
		/**
			@since 2.8.0
				Outputs the content for the current Recent Posts widget instance.
			@param (array) $args
				Display arguments including 'before_title', 'after_title', 'before_widget', and 'after_widget'.
			@param (array) $instance
				Settings for the current Recent Posts widget instance.
			@return (void)
			@reference
				[Parent]/controller/widget.php
				[Parent]/controller/fragment/widget.php
				[Parent]/controller/structure/single.php
				[Parent]/inc/customizer/option.php
				[Parent]/inc/utility/general.php
				[Parent]/template/content/singular.php
				[Parent]/template-part/content/content.php
		*/
		$class = self::$_class;

		/**
		 * @since 1.0.1
		 * 	Get the widget parameters via parent class (_widget_base) method.
		 * @reference
		 * 	[Parent]/model/widget/base.php
		*/
		$param = $this->get_param($instance);

		/**
		 * @since 1.0.1
		 * 	echo $args['before_widget'];
		*/
		echo $args['before_widget'];

		switch($param['width']){
			case 0 :
				$wrap = 'amazon-728';
				break;
			case 1 :
				$wrap = 'amazon-640';
				break;
			case 2 :
				$wrap = 'amazon-468';
				break;
			case 3 :
				$wrap = 'amazon-320';
				break;
			case 4 :
				$wrap = 'amazon-300';
				break;
			case 5 :
				$wrap = 'amazon-234';
				break;
			default :
				break;
		}

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_wrap[{$class}]",'div',array('class' => $wrap . ' uk-text-center'));

			/**
			 * @since 1.0.1
			 * 	echo $args['before_title'] . $param['title'] . $args['after_title'];
			 * @reference
			 * 	This filter is documented in wp-includes/widgets/class-wp-widget-pages.php
			*/
			if(!empty($param['title'])){
				beans_open_markup_e("_tag[{$class}]",__utility_get_option('tag_site-description'));
					beans_output_e("_output[{$class}][title]",$param['title']);
				beans_close_markup_e("_tag[{$class}]",__utility_get_option('tag_site-description'));
			}
			if(!empty($param['code'])){
				beans_output_e("_output[{$class}][code]",$param['code']);
			}

		beans_close_markup_e("_wrap[{$class}]",'div');

		/**
		 * @since 1.0.1
		 * 	echo $args['after_widget'];
		*/
		echo $args['after_widget'];

	}// Method


	/**
	 * [NOTE]
	 * 	form() method and update() method are defined in the parent class.
	 * @reference
	 * 	[Parent]/controller/widget.php
	 * 	[Parent]/model/widget/base.php
	*/


	/* Hook
	_________________________
	*/
	public function __the_render($the_content)
	{
		/**
			@access (public)
				Insert Adsense before h2 tags
				https://nelog.jp/add-ads-before-h2
			@param (string) $content
			@return (string)
		*/
		$class = self::$_class;

		if(empty($the_content)){
			// Get current post data.
			$post = __utility_get_post_object();
			$the_content = $post->post_content;
		}

		// Check if h2 headings in the content.
		if(preg_match_all('/^<h2.*?>.+?<\/h2>$/im',$the_content,$h2s)){

			if(isset($h2s[0])){
				if(isset($h2s[0][1])){
					/**
					 * @since 1.0.1
					 * 	Insert ad code before the first h2.
					 * @reference (Beans)
					 * 	HTML markup.
					 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup/
					 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup/
					*/
					$before = beans_open_markup("_wrap[{$class}]",'div',array('class' => 'amazon-728 uk-text-center'));
					$after = beans_close_markup("_wrap[{$class}]",'div');
					$the_content = str_replace(
						$h2s[0][1],
						$before . $this->code['728'] . $after . $h2s[0][1],
						$the_content
					);
				}

				if(isset($h2s[0][2])){
					// Insert ad code before the second h2.
					$before = beans_open_markup("_wrap[{$class}]",'div',array('class' => 'amazon-640 uk-text-center'));
					$after = beans_close_markup("_wrap[{$class}]",'div');
					$the_content = str_replace(
						$h2s[0][2],
						$before . $this->code['640'] . $after . $h2s[0][2],
						$the_content
					);
				}

				if(isset($h2s[0][3])){
					// Insert ad code before the third h2.
					$before = beans_open_markup("_wrap[{$class}]",'div',array('class' => 'amazon-468 uk-text-center'));
					$after = beans_close_markup("_wrap[{$class}]",'div');
					$the_content	 = 	str_replace(
						$h2s[0][3],
						$before . $this->code['468'] . $after . $h2s[0][3],
						$the_content
					);
				}
			}
		}
		return $the_content;

	}// Method


}// Class
endif;
new _widget_adsence();
