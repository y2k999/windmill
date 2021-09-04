<?php
/**
 * Third party module for enhancing theme.
 * @package Windmill
 * @license GPL3.0+
 * @since 1.0.1
*/

/**
 * Inspired by NovelLite WordPress Theme
 * @link http://www.themehunk.com/product/novellite-one-page-wordpress-theme/
 * @author ThemeHunk Team
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
if(class_exists('_setup_admin') === FALSE) :
class _setup_admin
{
/**
 * [NOTE]
 * 	Move enqueueing admin styles from _env_enqueue() class.
 * 	[Parent]/inc/env/enqueue.php
 * 
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_configuration()
 * 	set_asset()
 * 	set_hook()
 * 	invoke_hook()
 * 	enqueue_media()
 * 	theme_page()
 * 	add_theme_page()
 * 	render()
 * 	get_tab_count()
 * 	get_plugin_count()
*/


	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
		@var (array) $configuration
			Configuration data for theme admin menu.
		@var (array) $asset
			Admin scripts and styles.
		@var 	(array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private $configuration = array();
	private $asset = array();
	private $hook = array();


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
				This is only called once, since the only way to instantiate this is with the __get_instance() method in trait file (singleton.php).
			@return (void)
			@reference
				[Parent]/inc/trait/singleton.php
				[Parent]/inc/utility/general.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);
		$this->configuration = $this->set_configuration();
		$this->asset = $this->set_asset();

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook($this->hook);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_configuration()
	{
		/**
			@access (private)
				Configuration data for theme admin menu.
			@return (array)
			@reference (WP)
				Retrieves name of the current theme.
				https://developer.wordpress.org/reference/functions/get_template/
			@reference
				[Parent]/inc/utility/general.php
		*/
		return array(
			'general' => array(
				'theme_brand' => esc_html('Windmill'),
				// 'theme_brand_url' => esc_url($theme_data->get('AuthorURI')),
				'theme_brand_url' => esc_url('//www.getbeans.io/'),
				'title'=>sprintf(
					esc_html('Welcome to %s - Version %1s'),
					ucfirst(get_template()),
					__utility_get_theme_version()
				),
				'description' => sprintf(
					'%s ' . esc_html__('is a WordPress starter theme build with Uikit and Beans Framework. This theme comes with powerful features which will help you in designing amazing website for any type of niche (business, landing page, e-commerce, local business, personal website)','windmill'),
					ucfirst(get_template())
				),
			),
			'tab' => array(
				'overview' =>esc_html('Overview'),
				'customize' =>esc_html('Customize'),
				'childtheme' =>esc_html('Child Theme'),
				'support' =>esc_html('Support'),
			),
		);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_asset()
	{
		/**
			@access (private)
				Set the parameter values for the admin_enqueue_scripts.
			@return (array)
				_filter[_setup_admin][asset]
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		/**
		 * @reference (WP)
		 * 	Calls the callback functions that have been added to a filter hook.
		 * 	https://developer.wordpress.org/reference/functions/apply_filters/
		*/
		return apply_filters("_filter[{$class}][{$function}]",array(
			// Media uploader script.
			'enqueue_media' => array(
				'src' => URI['script'] . 'admin/enqueue-media.min.js',
				'ver' => __utility_get_theme_version(),
			),
			// Admin style.
			'theme_page' => array(
				'src' => URI['style'] . 'admin/theme-page.min.css',
				'ver' => __utility_get_theme_version(),
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
				_filter[_setup_admin][hook]
			@reference
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
			'add_theme_page' => array(
				'tag' => 'add_action',
				'hook' => 'admin_menu'
			),
			'enqueue_media' => array(
				'tag' => 'add_action',
				'hook' => 'admin_enqueue_scripts'
			),
			'theme_page' => array(
				'tag' => 'add_action',
				'hook' => 'admin_enqueue_scripts'
			),
		)));

	}// Method


	/* Hook
	_________________________
	*/
	public function theme_page()
	{
		/**
			@access (public)
				Enqueue scripts for all admin pages.
				https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/
			@return (void)
		*/
		wp_enqueue_style(self::__make_handle('theme-page'),$this->asset['theme_page']['src'],$this->asset['theme_page']['ver'],'all');

	}// Method


	/* Hook
	_________________________
	*/
	public function enqueue_media()
	{
		/**
			@access (public)
				Enqueues all scripts, styles, settings, and templates necessary to use all media JS APIs.
				https://developer.wordpress.org/reference/functions/wp_enqueue_media/
			@return (void)
		*/
		// Check if wp_enqueue_media() is already done in Beans Extension plugin.
		if(!__utility_is_active_plugin('beans_extension/beans_extension.php')){return;}

		if(function_exists('wp_enqueue_media')){
			wp_enqueue_media();
		}
		wp_enqueue_script(self::__make_handle('enqueue-media'),$this->asset['enqueue_media']['src'],array('jquery'),$this->asset['enqueue_media']['ver'],TRUE);

	}// Method


	/* Hook
	_________________________
	*/
	public function add_theme_page()
	{
		/**
			@access (public)
				Fires before the administration menu loads in the admin.
				https://developer.wordpress.org/reference/hooks/admin_menu/
			@return (void)
		*/
		$number_count = $this->get_plugin_count();
		$menu_title = esc_html('Windmill Theme Admin Page');
		if($number_count >0){
			/**
			 * @reference (WP)
			 * 	Convert float number to format based on the locale.
			 * 	https://developer.wordpress.org/reference/functions/number_format_i18n/
			*/
			$menu_title = sprintf(esc_html('Windmill Admin %s'),$this->get_tab_count());
		}

		/**
		 * @reference (WP)
		 * 	Add submenu page to the Appearance main menu.
		 * 	https://developer.wordpress.org/reference/functions/add_theme_page/
		 * @param (string) $page_title
		 * 	The text to be displayed in the title tags of the page when the menu is selected.
		 * @param (string) $menu_title
		 * 	The text to be used for the menu.
		 * @param (string) $capability
		 * 	The capability required for this menu to be displayed to the user.
		 * @param (string) $menu_slug
		 * 	The slug name to refer to this menu by (should be unique for this menu).
		 * @callable (string) $function
		 * 	The function to be called to output the content for this page.
		 * 	Default value: ''
		 * @callable (int) $position
		 * 	The position in the menu order this item should appear.
		 * 	Default value: null
		*/
		add_theme_page(
			esc_html('Windmill'),
			$menu_title,
			'edit_theme_options',
			'windmill_admin',
			[$this,'render']
		);

	}// Method


	/* Method
	_________________________
	*/
	public function render()
	{
		/**
			@access (public)
				The function to be called to output the content for this page.
				https://developer.wordpress.org/reference/functions/add_theme_page/
			@return (void)
		*/

		// Check for current viewing tab
		$tab = NULL;
		if(isset($_GET['tab'])){
			$tab = $_GET['tab'];
		}
		else{
			$tab = NULL;
		}
		?>
		<div class="wrap">
			<div class="wrap-content-main bx-container">
				<h1 class="bx-headline"><?php  echo $this->configuration['general']['title']; ?></h1>
				<p class="about-text"><?php echo $this->configuration['general']['description']; ?></p>

				<h2 class="nav-tab-wrapper">
					<a href="?page=windmill_admin" class="nav-tab<?php echo is_null($tab) ? ' nav-tab-active' : NULL; ?>"><?php  echo $this->configuration['tab']['overview']; ?></a>
					<a href="?page=windmill_admin&tab=action_required" class="nav-tab<?php echo $tab == 'action_required' ? ' nav-tab-active' : NULL; ?>"><?php echo $this->configuration['tab']['customize']; echo $this->get_tab_count();?></a>

					<a href="?page=windmill_admin&tab=childtheme" class="nav-tab<?php echo $tab == 'childtheme' ? ' nav-tab-active' : NULL; ?>"><?php echo $this->configuration['tab']['childtheme']; ?></span></a>
					<a href="?page=windmill_admin&tab=support" class="nav-tab<?php echo $tab == 'support' ? ' nav-tab-active' : NULL; ?>"><?php echo $this->configuration['tab']['support']; ?></span></a>
				</h2>

				<?php
				/**
				 * @reference (WP)
				 * 	Loads a template part into a template.
				 * 	https://developer.wordpress.org/reference/functions/get_template_part/
				 * @reference
				 * 	[Parent]/inc/setup/constant.php
				*/
				if(is_null($tab)){
					get_template_part(SLUG['setup'] . 'tab/overview');
				}

				if($tab == 'action_required'){
					get_template_part(SLUG['setup'] . 'tab/customize');
				}

				if($tab == 'childtheme'){
					get_template_part(SLUG['setup'] . 'tab/childtheme');
				}

				if($tab == 'support'){
					get_template_part(SLUG['setup'] . 'tab/support');
				}
				?>
			</div><!-- .wrap-content-main -->
		</div><!-- .wrap -->

	<?php
	}// Method


	/**
		@access (private)
			Convert float number to format based on the locale.
			https://developer.wordpress.org/reference/functions/number_format_i18n/
		@return (mixed)
	*/
	private function get_tab_count()
	{
		$count = '';
		$number_count = $this->get_plugin_count();
		if($number_count > 0){
			$count = '<span class="update-plugins count-' . esc_attr($number_count) . '" title="' . esc_attr($number_count) . '"><span class="update-count">' . number_format_i18n($number_count) . '</span></span>';
		}
		return $count;

	}// Method


	/**
		@access (private)
		@return (int)
		@reference
			[Parent]/inc/utility/general.php
	*/
	private function get_plugin_count()
	{
		$i = 0;

		switch(get_stylesheet()){
			case 'windmill-bbs' :
			case 'windmill-parallax' :
			case 'windmill-shop' :
				$i = 3;
				break;

			case 'windmill-blog' :
			case 'windmill-form' :
			case 'windmill-portfolio' :
			default :
				$i = 2;
				break;
		}

		if(__utility_is_active_plugin('amp/amp.php')){
			$i--;
		}

		if(__utility_is_active_plugin('loco-translate/loco.php')){
			$i--;
		}

		if(get_stylesheet() === 'windmill-parallax'){
			/**
			 * @reference (WP)
			 * 	Whether a registered shortcode exists named $tag
			 * 	https://developer.wordpress.org/reference/functions/shortcode_exists/
			*/
			if(shortcode_exists('lead-form')){
				$i--;
			}
		}

		if(get_stylesheet() === 'windmill-shop'){
			if(__utility_is_active_plugin('woocommerce/woocommerce.php')){
				$i--;
			}
		}

		if(get_stylesheet() === 'windmill-bbs'){
			if(__utility_is_active_plugin('bbpress/bbpress.php')){
				$i--;
			}
		}

		return $i;

	}// Method


}// Class
endif;
// new _setup_admin();
_setup_admin::__get_instance();
