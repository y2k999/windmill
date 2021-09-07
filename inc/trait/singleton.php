<?php
/**
 * Shared traits.
 * @package Windmill
 * @license GPL3.0+
 * @since 1.0.1
*/

/**
 * Inspired by WeCodeArt WordPress Theme
 * @link https://www.wecodeart.com/
 * @author Bican Marian Valeriu @wecodeart
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
if(trait_exists('_trait_singleton') === FALSE) :
trait _trait_singleton
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	__initialize()
 * 	__clone()
 * 	__wakeup()
*/

	/**
	 * @var (object)
	 * 	Instance
	*/
	private static $instance;


	/* Method
	_________________________
	*/
	public static function __get_instance()
	{
		/**
			@access (public)
				Singleton.
			@return (self)
		*/
		if(is_null(self::$instance)){
			self::$instance = new self;
		}
		return self::$instance;

	}// Method


	/* Method
	_________________________
	*/
	final private function __construct()
	{
		/**
			@access (private)
				Constructor protected from the outside
			@return (void)
		*/
		$this->__initialize();

	}// Method


	/* Method
	_________________________
	*/
	protected function __initialize()
	{
		/**
			@access (protected)
				Add init function by default.
				Implement this method in your child class.
				If you want to have actions send at construct.
			@return (void)
		*/

	}// Method


	/* Method
	_________________________
	*/
	protected function __clone()
	{
		/**
			@access (protected)
				Prevent the instance from being cloned.
			@return (void)
		*/

	}// Method


	/* Method
	_________________________
	*/
	public function __wakeup()
	{
		/**
			@access (public)
				Prevent from being unserialized.
			@return (void)
		*/

	}// Method


}// Trait
endif;
