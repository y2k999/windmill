<?php
/**
 * Set environmental configurations which enhance the theme by hooking into WordPress.
 * @package Windmill
 * @license GPL3.0+
 * @since 1.0.1
*/

/**
 * Inspired by Beans Framework WordPress Theme
 * @link https://www.getbeans.io
 * @author Thierry Muller
 * 
 * Inspired by Luxeritas WordPress Theme
 * @link https://thk.kanzae.net/wp/
 * @author LunaNuko
 * 
 * Inspired by Celtis Speedy WordPress Theme
 * @link https://celtislab.net/wordpress-theme-celtis-speedy/
 * @author enomoto@celtislab
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
if(class_exists('_env_secure') === FALSE) :
class _env_secure
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_hook()
 * 	invoke_hook()
 * 	redirect_author()
 * 	is_ssl()
 * 	wp_rest_api()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private $hook = array();

	/**
	 * Traits.
	*/
	use _trait_hook;
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
			@return (void)
			@reference
				[Parent]/inc/trait/singleton.php
				[Parent]/inc/utility/general.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook($this->hook);

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
				_filter[_env_secure][hook]
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/trait/hook.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",$this->set_parameter_callback(array(
			'redirect_author' => array(
				'tag' => 'add_action',
				'hook' => 'init',
			),
			'wp_replace_insecure_home_url' => array(
				'tag' => 'add_action',
				'hook' => 'init',
			),
			'is_ssl' => array(
				'tag' => 'add_action',
				'hook' => 'admin_notices',
			),
			'wp_rest_api' => array(
				'tag' => 'add_filter',
				'hook' => 'rest_pre_dispatch',
				'args' => 3,
			),
		)));

	}// Method


	/* Hook
	_________________________
	*/
	public function redirect_author()
	{
		/**
			@access (public)
				Redirect Author Archive Link to top page.
				http://wordpress/archives/author/admin/
				http://wordpress/?author=1
			@global $wp_query
				https://codex.wordpress.org/Global_Variables
			@return (void)
			@reference
				https://celtislab.net/wordpress-theme-celtis-speedy/
				https://www.webdesignleaves.com/pr/wp/wp_user_enumeration.html
		*/
		if(is_admin()){return;}

		if(!empty($_SERVER['REQUEST_URI'])){
			if(strpos($_SERVER['REQUEST_URI'],'/author/') !== FALSE || strpos($_SERVER['REQUEST_URI'],'author=') !== FALSE){
				/**
				 * @reference (WP)
				 * 	Set HTTP status header.
				 * 	https://developer.wordpress.org/reference/functions/status_header/
				*/
				global $wp_query;
				$wp_query->set_404();
				status_header(404);
			}
		}

	}// Method


	/* Hook
	_________________________
	*/
	public function wp_replace_insecure_home_url()
	{
		/**
			@access (public)
				Stop WP5.7 or later home url http -> https on the fly replace filter.
			@return (void)
		*/

		/**
			@reference (WP)
				Replaces insecure HTTP URLs to the site in the given content, if configured to do so.
				https://developer.wordpress.org/reference/functions/wp_replace_insecure_home_url/
		*/
		remove_filter('the_content','wp_replace_insecure_home_url');
		remove_filter('the_excerpt','wp_replace_insecure_home_url');
		remove_filter('widget_text_content','wp_replace_insecure_home_url');
		remove_filter('wp_get_custom_css','wp_replace_insecure_home_url');

	}// Method


	/* Hook
	_________________________
	*/
	public function is_ssl()
	{
		/**
			@access (public)
				Redirect Author Archive Link to top page.
			@return (void)
			@reference
				https://celtislab.net/wordpress-theme-celtis-speedy/
		*/

		/**
			@reference (WP)
				Determines if SSL is used.
				https://developer.wordpress.org/reference/functions/is_ssl/
		*/
		if(is_ssl() === TRUE){
			if(stripos(home_url(),'https://') === FALSE || stripos(site_url(),'https://') === FALSE){
				echo '<div class="notice"><p>',__('Address (URL) of &quot;Settings -&gt; General&quot; is not set to SSL (https://). Please check the setting.','windmill'), '</p></div>';
			}
		}

	}// Method


	/* Hook
	_________________________
	*/
	public function wp_rest_api($result,$wp_rest_server,$request)
	{
		/**
			@access (public)
				Require authentication for all REST API requests by adding an is_user_logged_in check to the rest_authentication_errors filter.
				https://developer.wordpress.org/rest-api/frequently-asked-questions/
			@return (mixed) $result
				Response to replace the requested version with.
				Can be anything a normal endpoint can return, or null to not hijack the request.
			@return (WP_REST_Server) $server
				Server instance.
			@return (WP_REST_Request) $request
				Request used to generate the response.
			@return (void)
			@reference
				https://www.webdesignleaves.com/pr/wp/wp_user_enumeration.html
		*/

		// Permit the specific/restricted components.
		$permitted = array(
			'oembed',
			'akismet'
		);

		$route = $request->get_route();

		foreach($permitted as $r){
			if(strpos($route,"/$r/") === 0){
				return $result;
			}
		}

		// Permit Gutenberg
		if(current_user_can('edit_posts') || current_user_can('edit_pages')){
			return $result;
		}

		/**
			@reference (WP)
				Returns a contextual HTTP error code for authorization failure.
				https://developer.wordpress.org/reference/functions/rest_authorization_required_code/
		*/
		return new WP_Error('rest_disabled',__('The REST API on this site has been disabled.','windmill'),array('status' => rest_authorization_required_code()));

	}// Method


}// Class
endif;
// new _env_secure();
_env_secure::__get_instance();
