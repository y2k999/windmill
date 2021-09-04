<?php
/**
 * Load applications according to the settings and conditions.
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
if(class_exists('_structure_archive') === FALSE) :
class _structure_archive
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_param()
 * 	set_hook()
 * 	invoke_hook()
 * 	__the_excerpt()
 * 	__the_pagination()
*/

	/**
		@access(private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $_param
			Parameter for applications.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private $param = array();
	private $hook = array();

	/**
	 * Traits.
	*/
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
				[Parent]/inc/utility/general.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);
		$this->param = $this->set_param();

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook();

	}// Method


	/* Setter
	_________________________
	*/
	private function set_param()
	{
		/**
			@access (private)
				Configure the parameter for applications.
			@return (array)
				_filter[_structure_archive][param]
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
			'class' => self::$_index
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
				_filter[_structure_archive][hook]
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/general.php
				[Parent]/template/content/archive.php
				[Parent]/template-part/content/content-archive.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",array(
			'pagination' => array(
				'beans_id' => $class . '__the_pagination',
				'hook' => HOOK_POINT['primary']['append'],
				'callback' => '__the_pagination',
				'priority' => PRIORITY['default'],
			),
			'excerpt' => array(
				'beans_id' => $class . '__the_excerpt',
				'hook' => HOOK_POINT['archive']['body']['main'],
				'callback' => '__the_excerpt',
				'priority' => PRIORITY['default'],
			),
		));

	}// Method


	/* Method
	_________________________
	 */
	private function invoke_hook()
	{
		/**
			@access (private)
				Hooks a function on to a specific action.
				https://www.getbeans.io/code-reference/functions/beans_add_action/
			@return (bool)
				Will always return true(Validate action arguments?).
		*/
		if(empty($this->hook)){return;}

		foreach((array)$this->hook as $key => $value){
			/**
			 * @param (string) $id
			 * 	The action's Beans ID,a unique string(ID) tracked within Beans for this action.
			 * @param (string) $hook
			 * 	The name of the action to which the `$callback` is hooked.
			 * @param (callable) $callable
			 * 	The name of the function|method you wish to be called when the action event fires.
			 * @param (int) $priority
			 * 	Used to specify the order in which the functions associated with a particular action are executed.
			*/
			beans_add_action($value['beans_id'],$value['hook'],array($this,$value['callback']),$value['priority']);
		}

	}// Method


	/**
		@access (public)
			Display the post excerpt in the archive.php.
		@return (void)
		@hook (beans id)
			_structure_archive__the_excerpt
		@reference
			[Parent]/inc/utility/general.php
	*/
	public function __the_excerpt()
	{
		if(!__utility_is_archive()){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_wrap[{$class}][{$function}]",'div',array('class' => 'uk-height-small'));
			/**
			 * @reference (WP)
			 * 	Display the post excerpt.
			 * 	https://developer.wordpress.org/reference/functions/the_excerpt/
			*/
			self::__activate_application('excerpt');
			// the_excerpt();
		beans_close_markup_e("_wrap[{$class}][{$function}]",'div');

	}// Method


	/**
		@access (public)
			Display paginated links for archive post pages.
		@return (void)
		@hook (beans id)
			_structure_archive__the_pagination
		@reference
			[Parent]/inc/setup/constant.php
			[Parent]/inc/trait/theme.php
			[Parent]/inc/utility/general.php
			[Parent]/model/app/pagination.php
	*/
	public function __the_pagination()
	{
		/**
		 * @reference (WP)
		 * 	Determines whether the query is for the blog homepage.
		 * 	https://developer.wordpress.org/reference/functions/is_home/
		*/
		if(!__utility_is_archive() && !is_home()){return;}
		$function = __utility_get_function(__FUNCTION__);

		if(file_exists(PATH['wrap'] . $function . '.php')){
			/**
			 * @since 1.0.1
			 * 	Render wrapper around the model (application).
			 * @reference (WP)
			 * 	Loads a template part into a template.
			 * 	https://developer.wordpress.org/reference/functions/get_template_part/
			*/
			get_template_part(SLUG['wrap'] . $function,NULL,$this->param);
		}
		self::__activate_application($function,$this->param);

	}// Method


}// Class
endif;
// new _structure_archive();
_structure_archive::__get_instance();
