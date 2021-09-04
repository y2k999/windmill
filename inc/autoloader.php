<?php
/**
 * Setup theme.
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
if(class_exists('_theme_autoloader') === FALSE) :
class _theme_autoloader
{
/**
 * [TOC]
 * 	__construct()
 * 	register()
 * 	get_path()
*/

	/**
		@access (private)
			Class properties.
		@var (array) $cached_path
			Cached FilePaths.
		@var (string) $sep
			Separator.
			Default '_'.
	*/
	private $cached_path = array();
	private $sep = '_';


	/* Constructor
	_________________________
	*/
	public function __construct()
	{
		/**
			@access (public)
				Class Constructor.
			@return (void)
		*/

		// Register given function as __autoload() implementation
		spl_autoload_register([$this,'register']);

	}// Method


	/* Method
	_________________________
	*/
	protected function register($classname)
	{
		/**
			@access (protected)
				SPL class autoloader for this theme.
			@param (string)$class_name
				The name of the class we're trying to load.
			@return (bool)|(void)
		*/

		// Not a Windmill file, early exit.
		if(FALSE === strpos($classname,'Windmill')){
			// return FALSE;
		}

		if(TRUE === strpos($classname,'Beans_Extension')){
			return FALSE;
		}

		// if(in_array($classname,array('WP_Site_Health','WP_Service_Workers','_beans_anonymous_filter'),TRUE)){
		if(in_array($classname,array('_beans_anonymous_filter'),TRUE)){
			return;
		}

		// Check if we've got it cached and ready.
		if(isset($this->cached_path[$classname]) && file_exists($this->cached_path[$classname])){
			require_once $this->cached_path[$classname];
			return;
		}

		// If no chach, run get_paths, set cache and include.
		$path = $this->get_path($classname);

		if(file_exists($path)){
			$this->cached_path[$classname] = $path;
			require_once $path;
			return;
		}

	}// Method


	/**
		@access (protected)
			Get an array of possible paths for the file.
		@param (string) $class_name
			The name of the class we're trying to load.
		@return (string)
			File path that the requested class resides.
		@reference
			[Parent]/inc/setup/constant.php
	*/
	protected function get_path($classname)
	{
		// Trim namespace
		$classname = ltrim($classname,'\\');

		// Build the filename
		$exploded = explode($this->sep,$classname);

		$filename = strtolower(end($exploded));

		$path = '';

		if(substr($classname,0,5) === PREFIX['app']){
			$filename = str_replace(substr($classname,0,5),'',$classname);
			$filename = str_replace('_','-',$filename);
			$path = PATH['app'] . $filename . '.php';
		}
		elseif(substr($classname,0,5) === PREFIX['env']){
			$filename = str_replace(substr($classname,0,5),'',$classname);
			$filename = str_replace('_','-',$filename);
			$path = PATH['env'] . $filename . '.php';
		}
		elseif(substr($classname,0,6) === PREFIX['data']){
			$filename = str_replace(substr($classname,0,6),'',$classname);
			$filename = str_replace('_','-',$filename);
			$path = PATH['data'] . $filename . '.php';
		}
		elseif(substr($classname,0,6) === PREFIX['wrap']){
			$filename = str_replace(substr($classname,0,6),'',$classname);
			$filename = str_replace('_','-',$filename);
			$path = PATH['wrap'] . $filename . '.php';
		}
		elseif(substr($classname,0,7) === PREFIX['setup']){
			$filename = str_replace(substr($classname,0,7),'',$classname);
			$filename = str_replace('_','-',$filename);
			$path = PATH['setup'] . $filename . '.php';
		}
		elseif(substr($classname,0,7) === PREFIX['theme']){
			$filename = str_replace(substr($classname,0,7),'',$classname);
			$filename = str_replace('_','-',$filename);
			$path = PATH['inc'] . $filename . '.php';
		}
		elseif(substr($classname,0,7) === PREFIX['trait']){
			$filename = str_replace(substr($classname,0,7),'',$classname);
			$filename = str_replace('_','-',$filename);
			$path = PATH['trait'] . $filename . '.php';
		}
		elseif(substr($classname,0,8) === PREFIX['inline']){
			$filename = str_replace(substr($classname,0,8),'',$classname);
			$filename = str_replace('_','-',$filename);
			$path = PATH['inline'] . $filename . '.php';
		}
		elseif(substr($classname,0,8) === PREFIX['render']){
			$filename = str_replace(substr($classname,0,8),'',$classname);
			$filename = str_replace('_','-',$filename);
			$path = PATH['render'] . $filename . '.php';
		}
		elseif(substr($classname,0,8) === PREFIX['widget']){
			$filename = str_replace(substr($classname,0,8),'',$classname);
			$filename = str_replace('_','-',$filename);
			$path = PATH['widget'] . $filename . '.php';
		}
		elseif(substr($classname,0,10) === PREFIX['fragment']){
			$filename = str_replace(substr($classname,0,10),'',$classname);
			$filename = str_replace('_','-',$filename);
			$path = PATH['fragment'] . $filename . '.php';
		}
		elseif(substr($classname,0,11) === PREFIX['shortcode']){
			$filename = str_replace(substr($classname,0,11),'',$classname);
			$filename = str_replace('_','-',$filename);
			$path = PATH['shortcode'] . $filename . '.php';
		}
		elseif(substr($classname,0,11) === PREFIX['structure']){
			$filename = str_replace(substr($classname,0,11),'',$classname);
			$filename = str_replace('_','-',$filename);
			$path = PATH['structure'] . $filename . '.php';
		}
		elseif(substr($classname,0,12) === PREFIX['controller']){
			$filename = str_replace(substr($classname,0,12),'',$classname);
			$filename = str_replace('_','-',$filename);
			$path = PATH['controller'] . $filename . '.php';
		}
		elseif(substr($classname,0,12) === PREFIX['customizer']){
			$filename = str_replace(substr($classname,0,12),'',$classname);
			$filename = str_replace('_','-',$filename);
			$path = PATH['customizer'] . $filename . '.php';
		}

		// Return Paths
		return $path;

	}// Method


}// Class
endif;
new _theme_autoloader();
// _theme_autoloader::__get_instance();
