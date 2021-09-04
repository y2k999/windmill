<?php
/**
 * Setup theme customizer.
 * @package Windmill
 * @license GPL3.0+
 * @since 1.0.1
*/

/**
 * Inspired by Beans Framework WordPress Theme
 * @link https://www.getbeans.io
 * @author Thierry Muller
 * 
 * Inspired by WeCodeArt WordPress Theme
 * @link https://www.wecodeart.com/
 * @author Bican Marian Valeriu
 * 
 * Inspired by f(x) Share WordPress Plugin
 * @link http://genbu.me/plugins/fx-share/
 * @author David Chandra Purnama
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
if(class_exists('_customizer_option') === FALSE) :
class _customizer_option
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_option()
 * 	set_value()
*/

	/**
		@access(private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $option
			Collection of Theme Customizer settings.
		@var (array) $value
			Array of specific Theme Customizer settings.
	*/
	private static $_class = '';
	private static $_index = '';
	private $option = array();
	private $value = array();

	/**
	 * Traits.
	*/
	use _trait_singleton;


	/* Constructor
	_________________________
	*/
	private function __construct()
	{
		/**
			@access (private)
				Class constructor.
				This is only called once, since the only way to instantiate this is with the get_instance() method in trait (singleton.php).
			@global (array) $_customizer_option
				Theme Customizer option.
			@global (array) $_customizer_value
				Theme Customizer value.
			@return (void)
			@reference
				[Parent]/inc/customizer/default.php
				[Parent]/inc/customizer/option.php
				[Parent]/inc/customizer/setup.php
				[Parent]/inc/trait/singleton.php
				[Parent]/inc/utility/general.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);

		$this->option = $this->set_option();
		$this->value = $this->set_value();

		// Build global option values from Theme Customizer settings/default data source.
		global $_customizer_option;
		global $_customizer_value;
		$_customizer_option = $this->option;
		$_customizer_value = $this->value;

	}// Method


	/* Setter
	_________________________
	*/
	private function set_option()
	{
		/**
			@access (private)
				Set global options from Theme Customizer or default data.
			@global (array) $_customizer_default
				Theme Customizer default value.
			@return (array)
				_filter[_customizer_option][option]
			@reference
				[Parent]/inc/customizer/default.php
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$return = array();

		/**
		 * @reference (WP)
		 * 	Retrieves all theme modifications.
		 * 	https://developer.wordpress.org/reference/functions/get_theme_mods/
		*/
		$mods = get_theme_mods();

		// Custom global value.
		global $_customizer_default;
		if(empty($_customizer_default)){
			$_customizer_default = _customizer_default::__get_setting();
		}

		foreach((array)$_customizer_default as $key => $value){
			if(array_key_exists(PREFIX['setting'] . $key,$mods)){
				if(strpos($key,'_') !== FALSE){
					$exploded = explode('_',$key);
					switch(count($exploded)){
						case 2 :
							$return[$exploded[0]][$exploded[1]] = $mods[PREFIX['setting'] . $key];
							break;
						case 3 :
							$return[$exploded[0]][$exploded[1]][$exploded[2]] = $mods[PREFIX['setting'] . $key];
							break;
						case 4 :
							$return[$exploded[0]][$exploded[1]][$exploded[2]][$exploded[3]] = $mods[PREFIX['setting'] . $key];
							break;
					}
				}
				else{
					$return[$key] = $mods[PREFIX['setting'] . $key];
				}
			}
			else{
				if(strpos($key,'_') !== FALSE){
					$exploded = explode('_',$key);
					switch(count($exploded)){
						case 2 :
							$return[$exploded[0]][$exploded[1]] = $value;
							break;
						case 3 :
							$return[$exploded[0]][$exploded[1]][$exploded[2]] = $value;
							break;
						case 4 :
							$return[$exploded[0]][$exploded[1]][$exploded[2]][$exploded[3]] = $value;
							break;
					}
				}
				else{
					$return[$key] = $value;
				}
			}
		}

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",$return);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_value()
	{
		/**
			@access (private)
				Set global values of groups from theme customizer or default data.
			@return (array)
				_filter[_customizer_option][value]
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		$return = array();

		/**
		 * @reference (WP)
		 * 	Retrieves all theme modifications.
		 * 	https://developer.wordpress.org/reference/functions/get_theme_mods/
		*/
		$mods = get_theme_mods();

		/**
		 * @since 1.0.1
		 * 	Topbar icon Group.
		*/
		if(isset($mods[PREFIX['setting'] . 'icon_header']) && !empty($mods[PREFIX['setting'] . 'icon_header'])){
			// Make array
			$icon_header = explode(',',$mods[PREFIX['setting'] . 'icon_header']);
		}
		elseif(isset($this->option['icon']['header']) && !empty($this->option['icon']['header'])){
			$icon_header = explode(',',$this->option['icon']['header']);
		}

		// Loop load
		foreach($icon_header as $_icon_header){
			$_icon_header = explode(':',$_icon_header);
			if(isset($_icon_header[0]) && isset($_icon_header[1]) && ('1' == $_icon_header[1])){
				$return['icon_header'][] = $_icon_header[0];
			}
		}

		/**
		 * @since 1.0.1
		 * 	SNS share Group.
		*/
		if(isset($mods[PREFIX['setting'] . 'social_share']) && !empty($mods[PREFIX['setting'] . 'social_share'])){
			// Make array
			$share = explode(',',$mods[PREFIX['setting'] . 'social_share']);
		}
		elseif(isset($this->option['social']['share']) && !empty($this->option['social']['share'])){
			$share = explode(',',$this->option['social']['share']);
		}

		// Loop load
		foreach($share as $_share){
			$_share = explode(':',$_share);
			if(isset($_share[0]) && isset($_share[1]) && ('1' == $_share[1])){
				$return['share'][] = $_share[0];
			}
		}

		/**
		 * @since 1.0.1
		 * 	SNS follow Group.
		*/
		if(isset($mods[PREFIX['setting'] . 'social_follow']) && !empty($mods[PREFIX['setting'] . 'social_follow'])){
			// Make array
			$follow = explode(',',$mods[PREFIX['setting'] . 'social_follow']);
		}
		elseif(isset($this->option['social']['follow']) && !empty($this->option['social']['follow'])){
			$follow = explode(',',$this->option['social']['follow']);
		}

		// Loop load
		foreach($follow as $_follow){
			$_follow = explode(':',$_follow);
			if(isset($_follow[0]) && isset($_follow[1]) && ('1' == $_follow[1])){
				$return['follow'][] = $_follow[0];
			}
		}

		/**
		 * @since 1.0.1
		 * 	Post meta Group.
		*/
		if(isset($mods[PREFIX['setting'] . 'meta_post']) && !empty($mods[PREFIX['setting'] . 'meta_post'])){
			// Make array
			$meta_post = explode(',',$mods[PREFIX['setting'] . 'meta_post']);
		}
		elseif(isset($this->option['meta']['post']) && !empty($this->option['meta']['post'])){
			$meta_post = explode(',',$this->option['meta']['post']);
		}

		// Loop load
		foreach($meta_post as $_meta_post){
			$_meta_post = explode(':',$_meta_post);
			if(isset($_meta_post[0]) && isset($_meta_post[1]) && ('1' == $_meta_post[1])){
				$return['meta_post'][] = $_meta_post[0];
			}
		}

		/**
		 * @since 1.0.1
		 * 	Archive meta Group.
		*/
		if(isset($mods[PREFIX['setting'] . 'meta_archive']) && !empty($mods[PREFIX['setting'] . 'meta_archive'])){
			// Make array
			$meta_archive = explode(',',$mods[PREFIX['setting'] . 'meta_archive']);
		}
		elseif(isset($this->option['meta']['archive']) && !empty($this->option['meta']['archive'])){
			$meta_archive = explode(',',$this->option['meta']['archive']);
		}

		// Loop load
		foreach($meta_archive as $_meta_archive){
			$_meta_archive = explode(':',$_meta_archive);
			if(isset($_meta_archive[0]) && isset($_meta_archive[1]) && ('1' == $_meta_archive[1])){
				$return['meta_archive'][] = $_meta_archive[0];
			}
		}

		/**
		 * @since 1.0.1
		 * 	Google Fonts Group.
		*/
		if(isset($mods[PREFIX['setting'] . 'font_primary'])){
			// Make array
			$font['font_primary'] = $mods[PREFIX['setting'] . 'font_primary'];
		}
		elseif(isset($this->option['font']['primary'])){
			$font['font_primary'] = $this->option['font']['primary'];
		}

		if(isset($mods[PREFIX['setting'] . 'font_secondary'])){
			// Make array
			$font['font_secondary'] = $mods[PREFIX['setting'] . 'font_secondary'];
		}
		elseif(isset($this->option['font']['secondary'])){
			$font['font_secondary'] = $this->option['font']['secondary'];
		}

		foreach($font as $font_key => $font_value){
			switch($font_value){
				/**
				 * @since 1.0.2
				 * 	Basical San-Serif.
				*/
				case 'noto-sans-jp' :
					$return[$font_key] = '"Noto Sans JP", sans-serif';
					break;
				case 'roboto' :
					$return[$font_key] = '"Roboto", sans-serif';
					break;
				case 'open-sans' :
					$return[$font_key] = '"Open Sans", sans-serif';
					break;

				/**
				 * @since 1.0.2
				 * 	Stylish San-Serif.
				*/
				case 'lato' :
					$return[$font_key] = '"Lato", sans-serif';
					break;
				case 'josefin-sans' :
					$return[$font_key] = '"Josefin Sans", sans-serif';
					break;
				case 'oswald' :
					$return[$font_key] = '"Oswald", sans-serif';
					break;

				/**
				 * @since 1.0.2
				 * 	Basical Serif.
				*/
				case 'noto-serif-jp' :
					$return[$font_key] = '"Noto Serif JP", serif';
					break;
				case 'lora' :
					$return[$font_key] = '"Lora", serif';
					break;

				/**
				 * @since 1.0.2
				 * 	Stylish Serif.
				*/
				case 'cinzel' :
					$return[$font_key] = '"Cinzel", serif';
					break;
				case 'playfair-display' :
					$return[$font_key] = '"Playfair Display", serif';
					break;

				default :
					break;
			}
		}

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",$return);

	}// Method


}// Class
endif;
// new _customizer_option();
_customizer_option::__get_instance();
