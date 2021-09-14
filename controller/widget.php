<?php
/**
 * Core class/function as application root.
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
if(class_exists('_controller_widget') === FALSE) :
class _controller_widget
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_registered()
 * 	set_hook()
 * 	invoke_hook()
 * 	__the_template()
 * 	__the_title()
 * 	__the_content()
 * 	__the_none()
 * 
 * @reference
 * 	[Parent]/controller/structure/archive.php
 * 	[Parent]/controller/structure/footer.php
 * 	[Parent]/controller/structure/header.php
 * 	[Parent]/controller/structure/home.php
 * 	[Parent]/controller/structure/page.php
 * 	[Parent]/controller/structure/sidebar.php
 * 	[Parent]/controller/structure/single.php
*/

	/**
		@access(private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $hook
			The collection of hooks that is being registered (that is,actions or filters).
		@var (array) $registered
			The sidebars stored in array by sidebar ID.
	*/
	private static $_class = '';
	private static $_index = '';
	private $hook = array();
	private $registered = array();

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
				This is only called once,since the only way to instantiate this is with the get_instance() method in trait (singleton.php).
			@return (void)
			@reference
				[Parent]/inc/trait/singleton.php
				[Parent]/inc/utility/general.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);

		$this->registered = $this->set_registered();

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook($this->hook);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_registered()
	{
		/**
			@access (private)
				Registered sidebar (widget area) registerd in setup file.
				[Default]
				 - sidebar_primary,
				 - sidebar_secondary,
				 - content_primary,
				 - content_secondary,
				 - footer_primary,
				 - footer_secondary
			@return (array)
				_filter[_controller_widget][registered]
			@reference
				[Parent]/inc/setup/widget-area.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$return = array();
		foreach(_setup_widget_area::__get_setting() as $needle => $attr){
			foreach($attr as $key => $value){
				$return[] = $key;
			}
		}

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",$return);

	}//Method


	/* Setter
	_________________________
	*/
	private function set_hook()
	{
		/**
			@access (private)
				The collection of hooks that is being registered (that is,actions or filters).
			@return (array)
				_filter[_controller_widget][hook]
			@reference
				[Parent]/inc/setup/constant.php
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
			'__the_template' => array(
				'beans_id' => $class . '__the_template',
				'tag' => 'beans_add_action',
				'hook' => 'beans_widget_area',
				'priority' => PRIORITY['min']
			),
			'__the_title' => array(
				'beans_id' => $class . '__the_title',
				'tag' => 'beans_add_action',
				'hook' => 'beans_widget'
			),
			'__the_content' => array(
				'beans_id' => $class . '__the_content',
				'tag' => 'beans_add_action',
				'hook' => 'beans_widget',
				'priority' => PRIORITY['mid-high']
			),
			'__the_none' => array(
				'beans_id' => $class . '__the_none',
				'tag' => 'beans_add_action',
				'hook' => 'beans_no_widget'
			),
		)));

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_template()
	{
		/**
			@access (public)
				Echo the widget area and widget loop structural markup.
				It also calls the widget area and widget loop action hooks.
			@return (void)
			@hook (beans id)
				_controller_widget__the_template
			@reference
				[Parent]/inc/utility/theme.php
				[Plugin]/beans_extension/api/widget/beans.php
		*/
		if(!__utility_is_beans('widget')){return;}

		$class = self::$_class;

		/**
		 * @reference (Beans)
		 * 	Retrieve data from the current widget area in use.
		 * 	https://www.getbeans.io/code-reference/functions/beans_get_widget_area/
		*/
		echo beans_get_widget_area('before_widget');

		/**
		 * @reference (Beans)
		 * 	Whether there are more widgets available in the loop.
		 * 	https://www.getbeans.io/code-reference/functions/beans_have_widgets/
		*/
		if(beans_have_widgets()){

			/**
			 * @reference (Beans)
			 * 	Fires before widgets loop.
			 * 	This hook only fires if widgets exist.
			 * 	https://www.getbeans.io/code-reference/hooks/beans_before_widgets_loop/
			*/
			do_action('beans_before_widget_loop');

			while(beans_have_widgets()){
				/**
				 * @reference (Beans)
				 * 	Sets up the current widget.
				 * 	https://www.getbeans.io/code-reference/functions/beans_setup_widget/
				*/
				beans_setup_widget();
				/**
				 * @reference (Beans)
				 * 	Fires in each widget panel structural HTML.
				 * 	https://community.getbeans.io/discussion/sidebar-widgets-add-id-attribute-to-widgets/
				 * 	Search content for shortcodes and filter shortcodes through their hooks.
				 * 	https://www.getbeans.io/code-reference/functions/beans_widget_shortcodes/
				 * 	HTML markup.
				 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
				 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
				 * 
				 * @reference (Uikit)
				 * 	https://getuikit.com/docs/width
				*/
				beans_open_markup_e("_wrapper[{$class}][beans_template]",'div',array(
					'id' => beans_widget_shortcodes('{id}'),
					'class' => beans_widget_shortcodes('uk-width-1-1 widget widget_{classname}'),
				));
					/**
					 * @reference (Beans)
					 * 	Fires in each widget panel structural HTML.
					 * 	https://www.getbeans.io/code-reference/hooks/beans_widget/
					*/
					do_action('beans_widget');
				beans_close_markup_e("_wrapper[{$class}][beans_template]",'div');
			}

			/**
			 * @reference (Beans)
			 * 	Fires after the widgets loop.
			 * 	This hook only fires if widgets exist.
			 * 	https://www.getbeans.io/code-reference/hooks/beans_after_widgets_loop/
			*/
			do_action('beans_after_widget_loop');
		}
		else{
			/**
			 * @reference (Beans)
			 * 	Fires if no widgets exist.
			 * 	https://www.getbeans.io/code-reference/hooks/beans_no_widget/
			*/
			do_action('beans_no_widget');
		}
		echo beans_get_widget_area('after_widget');

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_title()
	{
		/**
			@access (public)
				Echo widget title.
				https://www.getbeans.io/code-reference/functions/beans_widget_title/
			@return(void)
			@hook (beans id)
				_controller_widget__the_title
			@reference
				[Parent]/customizer/option.php
				[Parent]/inc/utility/general.php
				[Plugin]/beans_extension/api/widget/beans.php
		*/

		/**
		 * @reference (Beans)
		 * 	Retrieve data from the current widget in use.
		 * 	https://www.getbeans.io/code-reference/functions/beans_get_widget/
		*/
		// if(!beans_get_widget('title')){return;}
		if(!__utility_is_beans('widget')){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_tag[{$class}][beans_title]" . _beans_widget_subfilters(),__utility_get_option('tag_widget-title'),array('class' => 'widget-title'));
			beans_output_e("_output[{$class}][beans_title]",beans_get_widget('title'));
		beans_close_markup_e("_tag[{$class}][beans_title]" . _beans_widget_subfilters(),__utility_get_option('tag_widget-title'));

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_content()
	{
		/**
			@access (public)
				Echo widget content.
				https://www.getbeans.io/code-reference/functions/beans_widget_content/
			@return(void)
			@hook (beans id)
				_controller_widget__the_content
			@reference
				[Parent]/inc/utility/general.php
				[Plugin]/beans_extension/api/widget/beans.php
		*/
		if(!__utility_is_beans('widget')){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Echo output registered by ID.
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * 	Retrieve data from the current widget in use.
		 * 	https://www.getbeans.io/code-reference/functions/beans_get_widget/
		*/
		beans_output_e("_output[{$class}][beans_content]" . _beans_widget_subfilters(),beans_get_widget('content'));

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_none()
	{
		/**
			@access (public)
				Echo no widget content.
				https://www.getbeans.io/code-reference/functions/beans_no_widget/
			@return (void)
			@hook (beans id)
				_controller_widget__the_none
			@reference
				[Parent]/inc/utility/general.php
				[Plugin]/beans_extension/api/widget/beans.php
		*/
		if(!__utility_is_beans('widget')){return;}

		/**
		 * @since 1.0.1
		 * 	Only apply this notice to sidebar_primary and sidebar_secondary.
		 * 
		 * @reference (Beans)
		 * 	Retrieve data from the current widget area in use.
		 * 	https://www.getbeans.io/code-reference/functions/beans_get_widget_area/
		*/
		if(!in_array(beans_get_widget_area('id'),$this->registered,TRUE)){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_output_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_label[{$class}][beans_none]",'span');
			/* translators:Name of the widget area. */
			beans_output_e("_output[{$class}][beans_none]",sprintf(
				'<!-- %s does not have any widget assigned! -->',beans_get_widget_area('name')
			));
		beans_close_markup_e("_label[{$class}][beans_none]",'span');

	}// Method


}// Class
endif;
// new _controller_widget();
_controller_widget::__get_instance();
