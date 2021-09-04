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
if(trait_exists('_trait_hook') === FALSE) :
trait _trait_hook
{
/**
 * [TOC]
 * 	set_parameter_callback()
 * 	set_parameter_hook()
 * 	invoke_hook()
*/


	/* Setter
	_________________________
	*/
	public function set_parameter_callback($args = array())
	{
		/**
			@access (public)
				Build params for WP action/filter hooks depending on uniqueue callback names.
			@param (array) $args
				The collection to be registered with WordPress.
			@return (array)
				The actions/filters registered with WordPress to fire when the plugin loads.
			@reference
				[Parent]/inc/setup/constant.php
		*/
		if(empty($args)){return;}

		$return = array();

		foreach($args as $key => $value){
			if(!isset($value['tag']) || !isset($value['hook'])){break;}

			$return[] = array(
				'beans_id' => isset($value['beans_id']) ? $value['beans_id'] : self::$_class . $key,
				'tag' => $value['tag'],
				'hook' => $value['hook'],
				'callback' => $key,
				'priority' => isset($value['priority']) ? $value['priority'] : PRIORITY['default'],
				'args' => isset($value['args']) ? $value['args'] : 1,
			);
		}
		return $return;

	}// Method


	/* Setter
	_________________________
	*/
	public function set_parameter_hook($args = array())
	{
		/**
			@access (public)
				Build params for WP action/filter hooks depending on uniqueue tag names.
			@param (array) $args
				The collection to be registered with WordPress.
			@return (array)
				The actions/filters registered with WordPress to fire when the plugin loads.
			@reference
				[Parent]/inc/setup/constant.php
		*/
		if(empty($args)){return;}

		$return = array();

		foreach($args as $key => $value){
			if(!isset($value['tag']) || !isset($value['callback'])){break;}

			$return[] = array(
				'beans_id' => isset($value['beans_id']) ? $value['beans_id'] : self::$_class . $key,
				'tag' => $value['tag'],
				'hook' => $key,
				'callback' => $value['callback'],
				'priority' => isset($value['priority']) ? $value['priority'] : PRIORITY['default'],
				'args' => isset($value['args']) ? $value['args'] : 1,
			);
		}
		return $return;

	}// Method


	/* Hook
	_________________________
	*/
	public function invoke_hook($args)
	{
		/**
			@access (public)
				Hooks a function on to a specific actions/filters.
			@param (array) $args
				The collection to be registered with WordPress.
			@return (bool)|(void)
		*/
		if(empty($args)){return;}

		foreach($args as $item){
			/**
			 * @reference (Beans)
			 * 	Hooks a function on to a specific action.
			 * 	https://www.getbeans.io/code-reference/functions/beans_add_action/
			*/
			if($item['tag'] === 'beans_add_action'){
				$item['tag'](
					$item['beans_id'],
					$item['hook'],
					[$this,$item['callback']],
					$item['priority'],
					$item['args']
				);
			}
			else{
				$item['tag'](
					$item['hook'],
					[$this,$item['callback']],
					$item['priority'],
					$item['args']
				);
			}
		}

	}// Method


}// Trait
endif;
