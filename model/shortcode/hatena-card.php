<?php
/**
 * Adds a new post shortcode.
 * @package Windmill
 * @license GPL3.0+
 * @since 1.0.1
*/

/**
 * Inspired by Beans Framework WordPress Theme
 * @link https://www.getbeans.io
 * @author Thierry Muller
 * 
 * Inspired by White Tiger WordPress Theme
 * @link https://wp-white-tiger.fun-net.biz/
 * @author kenji
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
if(class_exists('_shortcode_hatena_card') === FALSE) :
class _shortcode_hatena_card
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_param()
 * 	__the_render()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/identifier with prefix.
		@var (string) $_index
			Name/identifier without prefix.
		@var (array) $_param
			Parameter for the application.
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_param = array();

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
				[Parent]/inc/customizer/option.php
				[Parent]/inc/trait/singleton.php
				[Parent]/inc/utility/general.php
				[Parent]/model/data/param.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);
		self::$_param = $this->set_param(self::$_index);

		/**
		 * @reference (WP)
		 * 	Adds a new shortcode.
		 * 	https://developer.wordpress.org/reference/functions/add_shortcode/
		*/
		add_shortcode(self::$_param['tag'],[$this,'__the_render']);

	}// Method


	/* Method
	_________________________
	*/
	public function __the_render($atts,$content = NULL)
	{
		/**
			@access (public)
				Echo post content in blogcard format.
			@param (array) $atts
				User defined attributes in shortcode tag.
			@param (string) $content
				Post Content.
			@return (string)
			@reference
				[Parent]/controller/shortcode.php
				[Parent]/inc/customizer/option.php
				[Parent]/inc/utility/general.php
		*/
		if(!is_singular('post')){return;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Combine user attributes with known attributes and fill in defaults when needed.
		 * 	https://developer.wordpress.org/reference/functions/shortcode_atts/
		*/
		extract(shortcode_atts(array(
			'url' => '',
			'title' => '',
		),$atts));

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup/
		 * 	https://www.getbeans.io/code-reference/functions/beans_output/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup/
		*/
		$html = '';
		$html .= beans_open_markup("_paragraph[{$class}][{$function}]",__utility_get_option('tag_site-description uk-text-center'));
		if(strstr($url,'hatenablog.com')){
			$url = str_replace("entry","embed",$url);
			$html .= beans_open_markup("_iframe[{$class}][{$function}]",'iframe',array(
				'class' => 'uk-margin-small embed-card embed-blogcard',
				'style' => 'display: block; width: 100%; height: 190px; max-width: 98%;',
				'src' => $url,
				'title' => !empty($title) ? $title : esc_attr('The title of ') . $url,
				'width' => self::$_param['size_w'],
				'height' => self::$_param['size_h'],
				'frameborder' => '0',
				'scrolling' => 'no',
			));
		}
		else{
			$html .= beans_open_markup("_iframe[{$class}][{$function}]",'iframe',array(
				'class' => 'uk-margin-small',
				'style' => 'display: block; width: 100%; height: 155px; max-width: 98%;',
				'src' => 'https://hatenablog-parts.com/embed?url=' . $url,
				'title' => !empty($title) ? $title : esc_attr('The title of ') . $url,
				'width' => self::$_param['size_w'],
				'height' => self::$_param['size_h'],
				'frameborder' => '0',
				'scrolling' => 'no',
			));
		}

		$html .= beans_close_markup("_iframe[{$class}][{$function}]",'iframe');
		$html .= beans_close_markup("_paragraph[{$class}][{$function}]",__utility_get_option('tag_site-description'));

		/**
		 * [NOTE]
		 * Note that the function called by the shortcode should never produce an output of any kind.
		 * Shortcode functions should return the text that is to be used to replace the shortcode.
		 * Producing the output directly will lead to unexpected results.
		 * This is similar to the way filter functions should behave, in that they should not produce unexpected side effects from the call since you cannot control when and where they are called from.
		*/
		return $html;

	}// Method


}// Class
endif;
// new _shortcode_hatena_card();
_shortcode_hatena_card::__get_instance();
