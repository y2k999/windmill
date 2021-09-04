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
if(class_exists('_shortcode_ogp_card') === FALSE) :
class _shortcode_ogp_card
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_param()
 * 	set_cache_dir()
 * 	__the_render()
 * 	get_wp_capture_url()
 * 	get_resized_image_from_external()
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
		@var (string) $cache_key
			Cache key for the application.
		@var (string) $cache_dir
			Cache direcotry for the image file.
		@var (bool) $clear_cache
			Cache clear setting (Default: false).
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_param = array();
	private $cache_key = '';
	private $cache_dir = '';
	private $clear_cache;

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


		// Cache clear setting (Default: false).
		$this->clear_cache = FALSE;

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
	public function __the_render($atts)
	{
		/**
			@access (public)
				Echo post content in blogcard format.
			@param (array) $atts
				User defined attributes in shortcode tag.
			@param (string) $content
				Contents.
			@return (string)
			@reference
				[Parent]/controller/shortcode.php
				[Parent]/inc/customizer/option.php
				[Parent]/inc/utility/general.php
		*/
		if(!is_singular('post')){return;}

		$class = self::$_class;
		// $function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Combine user attributes with known attributes and fill in defaults when needed.
		 * 	https://developer.wordpress.org/reference/functions/shortcode_atts/
		*/
		extract(shortcode_atts(array(
			'url' => '',
		),$atts));
	
		// Get the OGP data.
		// require_once 'OpenGraph.php';
		require_once (trailingslashit(get_template_directory()) . 'inc/plugin/opengraph/OpenGraph.php');
		// get_template_part(SLUG['plugin'] . '/opengraph/OpenGraph');
		$graph = OpenGraph::fetch($url);

		// Get the title from the OGP tag.
		$title = wp_trim_words($graph->title,32,'...');

		// Get the description from the OGP tag.
		$description = wp_trim_words($graph->description,60,'…');

		// Get the screenshot via wordpress.com API.
		$capture = 'https://s.wordpress.com/mshots/v1/'. urlencode(esc_url(rtrim($url,'/'))) . '?w=' . self::$_param['size_w'] . '&h=' . self::$_param['size_h'] . '';

		// Build the image html.
		$img_src = sprintf(
			'<img src="%1$s" width="%2$s" height="%3$s" alt="%4$s" loading="lazy" />',
			$capture,
			self::$_param['size_w'],
			self::$_param['size_h'],
			$title
		);
	
		// Get the favicon via Google API.
		$host = parse_url($url)['host'];
		$searched_favcon = 'https://www.google.com/s2/favicons?domain=' . $host;
		if($searched_favcon){
			$favicon = sprintf(
				'<img class="favicon" src="%s" width="24px" height="24px" alt="favicon" loading="lazy" />',
				$searched_favcon
			);
		}

		$html = '';
		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup/
		 * 	https://www.getbeans.io/code-reference/functions/beans_selfclose_markup/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup/
		 * @reference (Uikit)
		 * 	https://getuikit.com/docs/card
		 * 	https://getuikit.com/docs/position
		 * 	https://getuikit.com/docs/width
		*/
		$html .= beans_open_markup("_unit[{$class}]",'div',array(
			'class' => 'uk-card uk-card-default uk-card-hover uk-padding-small uk-margin-medium-top uk-margin-medium-bottom blogcard'
		));
			$html .= beans_open_markup("_grid[{$class}]",'div',array(
				'class' => 'uk-position-relative uk-grid-small uk-grid-match',
				'uk-grid' => 'uk-grid',
			));
				// Image
				$html .= beans_open_markup("_figure[{$class}]",'figure',array(
					'class' => 'uk-card-media uk-width-1-3@m uk-padding-small'
				));
					$html .= beans_open_markup("_link[{$class}]",'a',array(
						'href' => $url,
						'aria-label' => esc_attr__('Post Thumbnail','windmill'),
						'target' => '_blank',
						'rel' => 'noopener noreferrer',
					));
						$html .= beans_output("_image[{$class}]",$img_src);
					$html .= beans_close_markup("_link[{$class}]",'a');
				$html .= beans_close_markup("_figure[{$class}]",'figure');

				$html .= beans_open_markup("_body[{$class}]",'div',array(
					'class' => 'uk-card-body uk-width-expand uk-padding-remove'
				));
					// Title
					$html .= beans_open_markup("_title[{$class}]",__utility_get_option('tag_site-description'),array(
						'class' => 'uk-card-title uk-text-default uk-margin-remove uk-padding-small uk-padding-remove-horizonal'
					));
						$html .= beans_open_markup("_link[{$class}]",'a',array(
							'href' => $url,
							'aria-label' => esc_attr__('Post Title','windmill'),
							'target' => '_blank',
							'rel' => 'noopener noreferrer',
						));
							$html .= $title;
						$html .= beans_close_markup("_link[{$class}]",'a');
					$html .= beans_close_markup("_title[{$class}]",__utility_get_option('tag_site-description'));

					// Description
					$html .= beans_open_markup("_description[{$class}]",__utility_get_option('tag_site-description'),array(
						'class' => 'uk-text-small uk-margin-remove'
					));
						$html .= $description;
					$html .= beans_close_markup("_description[{$class}]",__utility_get_option('tag_site-description'));

					// Favicon
					$html .= beans_open_markup("_domain[{$class}]",'span',array('class' => 'uk-padding-small uk-padding-remove-bottom uk-text-meta uk-text-right'));
						$html .= beans_output("_favicon[{$class}]",$favicon . ' ' . $url);
					$html .= beans_close_markup("_domain[{$class}]",'span');
				$html .= beans_close_markup("_body[{$class}]",'div');

			$html .= beans_close_markup("_grid[{$class}]",'div');
		$html .= beans_close_markup("_unit[{$class}]",'div');

		return $html;	

	}// Method


}// Class
endif;
// new _shortcode_ogp_card();
_shortcode_ogp_card::__get_instance();
