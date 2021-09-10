<?php
/**
 * Define theme constants and global variables.
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

/**
 * @reference (WP)
 * 	Gets a WP_Theme object for a theme.
 * 	https://developer.wordpress.org/reference/functions/wp_get_theme/
*/
if(!defined('VERSION')){
	define('VERSION',wp_get_theme()->get('Version'));
}

if(!defined('DOMAIN')){
	define('DOMAIN',wp_get_theme()->get('TextDomain'));
}

/**
 * @reference
 * 	[Parent]/controller/fragment/excerpt.php
 * 	[Parent]/controller/fragment/image.php
 * 	[Parent]/controller/fragment/meta.php
 * 	[Parent]/controller/fragment/share.php
 * 	[Parent]/controller/fragment/title.php
 * 	[Parent]/controller/structure/archive.php
 * 	[Parent]/controller/structure/footer.php
 * 	[Parent]/controller/structure/header.php
 * 	[Parent]/controller/structure/home.php
 * 	[Parent]/controller/structure/page.php
 * 	[Parent]/controller/structure/sidebar.php
 * 	[Parent]/controller/structure/single.php
 * 	[Parent]/inc/env/content.php
 * 	[Parent]/inc/env/embed.php
 * 	[Parent]/inc/env/enqueue.php
 * 	[Parent]/inc/env/foot.php
 * 	[Parent]/inc/env/gutenberg.php
 * 	[Parent]/inc/env/inline-style.php
 * 	[Parent]/inc/trait/hook.php
 * 	[Parent]/model/app/breadcrumb.php
*/
if(!defined('PRIORITY')){
	define('PRIORITY',array(
		'min' => 1,
		'low' => 5,
		'mid-low' => 9,
		'default' => 10,
		'mid-high' => 11,
		'high' => 9999,
		'max' => 99999,
	));
}


/**
 * @reference
 * 	[Parent]/inc/autoloader.php
 * 	[Parent]/inc/customizer/color.php
 * 	[Parent]/inc/customizer/option.php
 * 	[Parent]/inc/customizer/setting/xxx/yyy.php
 * 	[Parent]/inc/env/inline-style.php
 * 	[Parent]/inc/trait/theme.php
 * 	[Parent]/inc/utility/general.php
 * 	[Parent]/model/app/meta.php
*/
if(!defined('PREFIX')){
	define('PREFIX',array(
		// Class name
		'app' => '_app_',
		'controller' => '_controller_',
		'customizer' => '_customizer_',
		'data' => '_data_',
		'env' => '_env_',
		'fragment' => '_fragment_',
		'inline' => '_inline_',
		'render' => '_render_',
		'setup' => '_setup_',
		'shortcode' => '_shortcode_',
		'structure' => '_structure_',
		'theme' => '_theme_',
		'trait' => '_trait_',
		'widget' => '_widget_',
		'wrap' => '_wrap_',
		// Func name & Method name.
		'hook' => '__hook_',
		'do' => '__do_',
		'get' => '__get_',
		'the' => '__the_',
		// Customizer
		'panel' => 'panel_WM_',
		'section' => 'section_WM_',
		'setting' => 'setting_WM_',
	));
}

/**
 * @reference (WP)
 * 	Retrieves template directory path for current theme.
 * 	https://developer.wordpress.org/reference/functions/get_template_directory/
*/
if(!defined('BASE_PATH')){
	define('BASE_PATH',wp_normalize_path(trailingslashit(get_template_directory())));
}

/**
 * @reference
 * 	[Parent]/controller/structure/archive.php
 * 	[Parent]/controller/structure/footer.php
 * 	[Parent]/controller/structure/header.php
 * 	[Parent]/controller/structure/home.php
 * 	[Parent]/controller/structure/page.php
 * 	[Parent]/controller/structure/sidebar.php
 * 	[Parent]/controller/structure/search.php
 * 	[Parent]/controller/structure/single.php
 * 	[Parent]/inc/autoloader.php
 * 	[Parent]/inc/env/enqueue.php
 * 	[Parent]/inc/env/inline-style.php
*/
if(!defined('PATH')){
	define('PATH',array(
		// Common
		'asset' => BASE_PATH . 'asset/',
		'controller' => BASE_PATH . 'controller/',
		'inc' => BASE_PATH . 'inc/',
		'model' => BASE_PATH . 'model/',
		'template' => BASE_PATH . 'template/',
		'template-part' => BASE_PATH . 'template-part/',
		// Asset
		'image' => BASE_PATH . 'asset/image/',
		'inline' => BASE_PATH . 'asset/inline/',
		'language' => BASE_PATH . 'asset/language/',
		'script' => BASE_PATH . 'asset/script/',
		'style' => BASE_PATH . 'asset/style/',
		// Inc
		'customizer' => BASE_PATH . 'inc/customizer/',
		'env' => BASE_PATH . 'inc/env/',
		'plugin' => BASE_PATH . 'inc/plugin/',
		'setup' => BASE_PATH . 'inc/setup/',
		'trait' => BASE_PATH . 'inc/trait/',
		'utility' => BASE_PATH . 'inc/utility/',
		// Controller
		'fragment' => BASE_PATH . 'controller/fragment/',
		'render' => BASE_PATH . 'controller/render/',
		'structure' => BASE_PATH . 'controller/structure/',
		// Model
		'app' => BASE_PATH . 'model/app/',
		'data' => BASE_PATH . 'model/data/',
		'shortcode' => BASE_PATH . 'model/shortcode/',
		'widget' => BASE_PATH . 'model/widget/',
		'wrap' => BASE_PATH . 'model/wrap/',
		// Template part
		'content' => BASE_PATH . 'template-part/content/',
		'figure' => BASE_PATH . 'template-part/figure/',
		'item' => BASE_PATH . 'template-part/item/',
		'nav' => BASE_PATH . 'template-part/nav/',
	));
}

/**
 * @reference (WP)
 * 	Retrieves template directory URI for current theme.
 * 	https://developer.wordpress.org/reference/functions/get_template_directory_uri/
 * @reference
 * 	[Parent]/inc/env/json-ld.php
*/
if(!defined('BASE_URI')){
	define('BASE_URI',trailingslashit(get_template_directory_uri()));
}


/**
 * @reference
 * 	[Parent]/inc/customizer/default.php
 * 	[Parent]/inc/customizer/option.php
 * 	[Parent]/inc/env/embed.php
 * 	[Parent]/inc/env/enqueue.php
 * 	[Parent]/inc/env/gutenberg.php
 * 	[Parent]/inc/env/inline-style.php
 * 	[Parent]/inc/setup/tab/childtheme.php
*/
if(!defined('URI')){
	define('URI',array(
		'image' => BASE_URI . 'asset/image/',
		'inline' => BASE_URI . 'asset/inline/',
		'language' => BASE_URI . 'asset/language/',
		'style' => BASE_URI . 'asset/style/',
		'script' => BASE_URI . 'asset/script/',
	));
}

/**
 * @reference (WP)
 * 	Loads a template part into a template.
 * 	https://developer.wordpress.org/reference/functions/get_template_part/
 * @reference
 * 	[Parent]/embed.php
 * 	[Parent]/controller/template.php
 * 	[Parent]/controller/structure/archive.php
 * 	[Parent]/controller/structure/footer.php
 * 	[Parent]/controller/structure/header.php
 * 	[Parent]/controller/structure/home.php
 * 	[Parent]/controller/structure/page.php
 * 	[Parent]/controller/structure/sidebar.php
 * 	[Parent]/controller/structure/search.php
 * 	[Parent]/controller/structure/single.php
 * 	[Parent]/inc/customizer/option.php
 * 	[Parent]/inc/env/inline-style.php
 * 	[Parent]/inc/plugin/google/google-analytics.php
 * 	[Parent]/inc/plugin/jetpack/jetpack.php
 * 	[Parent]/inc/setup/admin.php
 * 	[Parent]/inc/trait/theme.php
 * 	[Parent]/model/app/nav.php
 * 	[Parent]/model/shortcode/blogcard.php
 * 	[Parent]/model/widget/recent.php
 * 	[Parent]/model/widget/relation.php
 * 	[Parent]/template/content/404.php
 * 	[Parent]/template/content/archive.php
 * 	[Parent]/template/content/home.php
 * 	[Parent]/template/content/index.php
 * 	[Parent]/template/content/search.php
 * 	[Parent]/template/content/singular.php
*/
if(!defined('SLUG')){
	define('SLUG',array(
		// Common
		'asset' => 'asset/',
		'controller' => 'controller/',
		'inc' => 'inc/',
		'model' => 'model/',
		'template' => 'template/',
		'template-part' => 'template-part/',
		// Asset
		'inline' => 'asset/inline/',
		// Inc
		'customizer' => 'inc/customizer/',
		'env' => 'inc/env/',
		'plugin' => 'inc/plugin/',
		'setup' => 'inc/setup/',
		'trait' => 'inc/trait/',
		'utility' => 'inc/utility/',
		// Controller
		'fragment' => 'controller/fragment/',
		'render' => 'controller/render/',
		'structure' => 'controller/structure/',
		// Model
		'app' => 'model/app/',
		'data' => 'model/data/',
		'shortcode' => 'model/shortcode/',
		'widget' => 'model/widget/',
		'wrap' => 'model/wrap/',
		// Template part
		'content' => 'template-part/content/',
		'figure' => 'template-part/figure/',
		'item' => 'template-part/item/',
		'nav' => 'template-part/nav/',
	));
}

/**
 * @since 1.0.1
 * 	Font Size.
 * @reference
 * 	[Parent]/asset/inline/base.php
 * 	[Parent]/asset/inline/button.php
 * 	[Parent]/asset/inline/follow.php
 * 	[Parent]/asset/inline/share.php
 * 	[Parent]/inc/setup/gutenberg.php
*/
if(!defined('FONT')){
	define('FONT',array(
		'xsmall' => '12px',
		'small' => '14px',
		'medium' => '16px',
		'large' => '24px',
		'xlarge' => '32px',
	));
}

/**
 * @since 1.0.1
 * 	Break point.
 * @reference
 * 	[Parent]/asset/inline/base.php
*/
if(!defined('BREAK_POINT')){
	define('BREAK_POINT',array(
		'small' => '640px',
		'medium' => '960px',
		'large' => '1200px',
		'xlarge' => '1600px',
	));
}

/**
 * @since 1.0.1
 * 	Color.
 * @reference
 * 	[Parent]/asset/inline/base.php
 * 	[Parent]/asset/inline/button.php
 * 	[Parent]/asset/inline/follow.php
 * 	[Parent]/asset/inline/heading.php
 * 	[Parent]/asset/inline/nav.php
 * 	[Parent]/asset/inline/pagination.php
 * 	[Parent]/asset/inline/share.php
 * 	[Parent]/inc/customizer/color.php
 * 	[Parent]/inc/setup/gutenberg.php
*/
if(!defined('COLOR')){
	define('COLOR',array(
		'white' => '#fff',
		'vl-grey' => '#d3d3d3',
		'vd-grey' => '#050505',
		'vd-greyish' => '#313541',
		'vd-metal' => '#303440',
		'light-blue' => '#5c9ee7',
		'soft-blue' => '#59b1eb',
		'moderate_blue' => '#325a8c',
		'bright-blue' => '#3498db',
		'pale-red' => '#3498db',
		'soft-red' => '#fff0f0',
		'strong-red' => '#ff0000',
		'pale-pink' => '#ff69b4',
		'soft-pink' => '#ff1493',
		'yellow' => '#ffff00',
		'pale-yellow' => '#ffff9a',
		'bright-yellow' => '#fed136',
		'vivid-yellow' => '#f6bf01',
		'soft-green' => '#2ec8a6',
		'moderate-green' => '#6cbe42',
		'lime-green' => '#effff7',
		'dark-lime-green' => '#228b22',
		// ranking
		'gold' => '#ecd357',
		'silver' => '#a9c6d5',
		'bronz' => '#c58459',
		// alert
		'alert-yellow' => '#e77776',
		'alert-red' => '#6cbe42',
		'alert-green' => '#6cbe42',
		'alert-blue' => '#59b1eb',
		// uikit3
		// 'text' => '#18191a',
		'text' => '#444',
		'link' => '#5c9ee7',
		// 'link' => '#59b1eb',
		'hover' => '#6cbe42',
		'border' => '#e5e5e5',
		'label' => '#408c40',
		// background
		'background' => '#fff',
		'header' => 'transparent',
		'footer' => '#050505',
		'topbar' => '#313541',
		'overlay' => 'rgba(0,0,0,0.6)',
		// sns
		'twitter' => '#2b97f0',
		'twitter-hover' => '#55acee',
		'line' => '#2cbf13',
		'line-hover' => '#3ae81d',
		'facebook' => '#3b5998',
		'facebook-hover' => '#4e71bb',
		'instagram' => '#003569',
		'instagram-hover' => '#3f729b',
		'github' => '#fb8501',
		'github-hover' => '#fe9d31',
		'youtube' => '#EE4056',
		'youtube-hover' => '#f03e51',
		'getpocket' => '#EE4056',
		'getpocket-hover' => '#f03e51',
		'hatena' => '#007ad2',
		'hatena-hover' => '#00a5de',
		'pinterest' => '#fb8501',
		'pinterest-hover' => '#fe9d31',
		'wordpress' => '#59b1eb',
		'wordpress-hover' => '#325a8c',
		'google' => '#dd4b39',
		'google-hover' => '#bb4237',
		'mail' => '#dd4b39',
		'mail-hover' => '#bb4237',
	));
}

/**
 * @since 1.0.1
 * 	Hook points.
*/
if(!defined('HOOK_POINT')){
	define('HOOK_POINT',array(

	/* Template
	_________________________
	*/
		'root' => array(
			'before' => 'windmill/root/before',
			'main' => 'windmill/root/main',
			'after' => 'windmill/root/after',
		),
		/**
		 * @reference (Beans)
		 * 	Fires in the head.
		 * 	This hook fires in the head HTML section, not in wp_header().
		 * 	https://www.getbeans.io/code-reference/hooks/beans_head/
		 * @reference
		 * 	[Parent]/header.php
		 * 	[Parent]/inc/env/head.php
		*/
		'head' => array(
			'before' => 'windmill/template/head/before',
			'after' => 'windmill/template/head/after',
		),

		/**
		 * @reference
		 * 	[Parent]/footer.php
		 * 	[Parent]/header.php
		*/
		'site' => array(
			'before' => 'windmill/template/site/before',
			'after' => 'windmill/template/site/after',
		),

		/**
		 * @reference (Beans)
		 * 	Fires in the header.
		 * 	https://www.getbeans.io/code-reference/hooks/beans_header/
		 * @reference
		 * 	[Parent]/controller/structure/header.php
		 * 	[Parent]/template/header/header.php
		*/
		'masthead' => array(
			'before' => 'windmill/template/masthead/before',
			'prepend' => 'windmill/template/masthead/prepend',
			'main' => 'windmill/template/masthead',
			'append' => 'windmill/template/masthead/append',
			'after' => 'windmill/template/masthead/after',
		),

		/**
		 * @reference (Beans)
		 * 	Fires in the main content.
		 * 	https://www.getbeans.io/code-reference/hooks/beans_content/
		 * @reference
		 * 	[Parent]/template/content/404.php
		 * 	[Parent]/template/content/archive.php
		 * 	[Parent]/template/content/home.php
		 * 	[Parent]/template/content/index.php
		 * 	[Parent]/template/content/search.php
		 * 	[Parent]/template/content/singular.php
		*/
		'content' => array(
			'before' => 'windmill/template/content/before',
			'prepend' => 'windmill/template/content/prepend',
			'main' => 'windmill/template/content',
			'append' => 'windmill/template/content/append',
			'after' => 'windmill/template/content/after',
		),

		/**
		 * @reference
		 * 	[Parent]/controller/fragment/title.php
		 * 	[Parent]/template/content/404.php
		 * 	[Parent]/template/content/archive.php
		 * 	[Parent]/template/content/home.php
		 * 	[Parent]/template/content/index.php
		 * 	[Parent]/template/content/search.php
		 * 	[Parent]/template/content/singular.php
		*/
		'primary' => array(
			'before' => 'windmill/template/primary/before',
			'prepend' => 'windmill/template/primary/prepend',
			'main' => 'windmill/template/primary',
			'append' => 'windmill/template/primary/append',
			'after' => 'windmill/template/primary/after',
		),

		/**
		 * @reference (Beans)
		 * 	Fires in the primary sidebar.
		 * 	https://www.getbeans.io/code-reference/hooks/beans_sidebar_primary/
		 * @reference
		 * 	[Parent]/controller/structure/sidebar.php
		 * 	[Parent]/template/sidebar/sidebar.php
		*/
		'secondary' => array(
			'before' => 'windmill/template/secondary/before',
			'prepend' => 'windmill/template/secondary/prepend',
			'main' => 'windmill/template/secondary',
			'append' => 'windmill/template/secondary/append',
			'after' => 'windmill/template/secondary/after',
		),

		/**
		 * @reference
		 * 	[Parent]/controller/structure/footer.php
		 * 	[Parent]/template/footer/footer.php
		*/
		'colophone' => array(
			'before' => 'windmill/template/colophone/before',
			'prepend' => 'windmill/template/colophone/prepend',
			'main' => 'windmill/template/colophone',
			'append' => 'windmill/template/colophone/append',
			'after' => 'windmill/template/colophone/after',
		),

		/**
		 * @reference (Beans)
		 * 	Fires in the comment body.
		 * 	https://www.getbeans.io/code-reference/hooks/beans_comment_content/
		 * @reference
		 * 	[Parent]/comments.php
		 * 	[Parent]/model/app/comments.php
		*/
		'comments' => array(
			'before' => 'windmill/template/comments/before',
			'prepend' => 'windmill/template/comments/prepend',
			'main' => 'windmill/template/comments',
			'append' => 'windmill/template/comments/append',
			'after' => 'windmill/template/comments/after',
		),


	/* Content
	_________________________
	*/
		/**
		 * @reference
		 * 	[Parent]/controller/fragment/image.php
		 * 	[Parent]/controller/fragment/meta.php
		 * 	[Parent]/controller/fragment/title.php
		 * 	[Parent]/controller/structure/home.php
		 * 	[Parent]/template-part/content/content-home.php
		*/
		'home' => array(
			'header' => array(
				'before' => 'windmill/content/home/header/before',
				'prepend' => 'windmill/content/home/header/prepend',
				'main' => 'windmill/content/home/header',
				'append' => 'windmill/content/home/header/append',
				'after' => 'windmill/content/home/header/after',
			),
			'body' => array(
				'before' => 'windmill/content/home/body/before',
				'prepend' => 'windmill/content/home/body/prepend',
				'main' => 'windmill/content/home/body',
				'append' => 'windmill/content/home/body/append',
				'after' => 'windmill/content/home/body/after',
			),
			'footer' => array(
				'before' => 'windmill/content/home/footer/before',
				'prepend' => 'windmill/content/home/footer/prepend',
				'main' => 'windmill/content/home/footer',
				'append' => 'windmill/content/home/footer/append',
				'after' => 'windmill/content/home/footer/after',
			),
		),

		/**
		 * @reference
		 * 	[Parent]/controller/fragment/image.php
		 * 	[Parent]/controller/fragment/meta.php
		 * 	[Parent]/controller/fragment/title.php
		 * 	[Parent]/controller/structure/search.php
		 * 	[Parent]/template-part/content/content-search.php
		*/
		'search' => array(
			'header' => array(
				'before' => 'windmill/content/search/header/before',
				'prepend' => 'windmill/content/search/header/prepend',
				'main' => 'windmill/content/search/header',
				'append' => 'windmill/content/search/header/append',
				'after' => 'windmill/content/search/header/after',
			),
			'body' => array(
				'before' => 'windmill/content/search/body/before',
				'prepend' => 'windmill/content/search/body/prepend',
				'main' => 'windmill/content/search/body',
				'append' => 'windmill/content/search/body/append',
				'after' => 'windmill/content/search/body/after',
			),
			'footer' => array(
				'before' => 'windmill/content/search/footer/before',
				'prepend' => 'windmill/content/search/footer/prepend',
				'main' => 'windmill/content/search/footer',
				'append' => 'windmill/content/search/footer/append',
				'after' => 'windmill/content/search/footer/after',
			),
		),

		/**
		 * @reference
		 * 	[Parent]/controller/fragment/image.php
		 * 	[Parent]/controller/fragment/meta.php
		 * 	[Parent]/controller/fragment/title.php
		 * 	[Parent]/controller/structure/archive.php
		 * 	[Parent]/template-part/content/content-archive.php
		*/
		'archive' => array(
			'header' => array(
				'before' => 'windmill/content/archive/header/before',
				'prepend' => 'windmill/content/archive/header/prepend',
				'main' => 'windmill/content/archive/header',
				'append' => 'windmill/content/archive/header/append',
				'after' => 'windmill/content/archive/header/after',
			),
			'body' => array(
				'before' => 'windmill/content/archive/body/before',
				'prepend' => 'windmill/content/archive/body/prepend',
				'main' => 'windmill/content/archive/body',
				'append' => 'windmill/content/archive/body/append',
				'after' => 'windmill/content/archive/body/after',
			),
			'footer' => array(
				'before' => 'windmill/content/archive/footer/before',
				'prepend' => 'windmill/content/archive/footer/prepend',
				'main' => 'windmill/content/archive/footer',
				'append' => 'windmill/content/archive/footer/append',
				'after' => 'windmill/content/archive/footer/after',
			),
		),

		/**
		 * @reference
		 * 	[Parent]/controller/fragment/meta.php
		 * 	[Parent]/controller/fragment/share.php
		 * 	[Parent]/controller/fragment/title.php
		 * 	[Parent]/controller/structure/single.php
		 * 	[Parent]/template-part/content/content.php
		*/
		'single' => array(
			'header' => array(
				'before' => 'windmill/content/single/header/before',
				'prepend' => 'windmill/content/single/header/prepend',
				'main' => 'windmill/content/single/header',
				'append' => 'windmill/content/single/header/append',
				'after' => 'windmill/content/single/header/after',
			),
			'body' => array(
				'before' => 'windmill/content/single/body/before',
				'prepend' => 'windmill/content/single/body/prepend',
				'main' => 'windmill/content/single/body',
				'append' => 'windmill/content/single/body/append',
				'after' => 'windmill/content/single/body/after',
			),
			'footer' => array(
				'before' => 'windmill/content/single/footer/before',
				'prepend' => 'windmill/content/single/footer/prepend',
				'main' => 'windmill/content/single/footer',
				'append' => 'windmill/content/single/footer/append',
				'after' => 'windmill/content/single/footer/after',
			),
		),

		/**
		 * @reference
		 * 	[Parent]/controller/fragment/share.php
		 * 	[Parent]/controller/fragment/title.php
		 * 	[Parent]/controller/structure/page.php
		 * 	[Parent]/template-part/content/content-page.php
		*/
		'page' => array(
			'header' => array(
				'before' => 'windmill/content/page/header/before',
				'prepend' => 'windmill/content/page/header/prepend',
				'main' => 'windmill/content/page/header',
				'append' => 'windmill/content/page/header/append',
				'after' => 'windmill/content/page/header/after',
			),
			'body' => array(
				'before' => 'windmill/content/page/body/before',
				'prepend' => 'windmill/content/page/body/prepend',
				'main' => 'windmill/content/page/body',
				'append' => 'windmill/content/page/body/append',
				'after' => 'windmill/content/page/body/after',
			),
			'footer' => array(
				'before' => 'windmill/content/page/footer/before',
				'prepend' => 'windmill/content/page/footer/prepend',
				'main' => 'windmill/content/page/footer',
				'append' => 'windmill/content/page/footer/append',
				'after' => 'windmill/content/page/footer/after',
			),
		),

		/**
		 * @reference
		 * 	[Parent]/template-part/content/content-none.php
		*/
		'none' => array(
			'header' => array(
				'before' => 'windmill/content/none/header/before',
				'prepend' => 'windmill/content/none/header/prepend',
				'main' => 'windmill/content/none/header',
				'append' => 'windmill/content/none/header/append',
				'after' => 'windmill/content/none/header/after',
			),
			'body' => array(
				'before' => 'windmill/content/none/body/before',
				'prepend' => 'windmill/content/none/body/prepend',
				'main' => 'windmill/content/none/body',
				'append' => 'windmill/content/none/body/append',
				'after' => 'windmill/content/none/body/after',
			),
			'footer' => array(
				'before' => 'windmill/content/none/footer/before',
				'prepend' => 'windmill/content/none/footer/prepend',
				'main' => 'windmill/content/none/footer',
				'append' => 'windmill/content/none/footer/append',
				'after' => 'windmill/content/none/footer/after',
			),
		),

	/* Item/Format
	_________________________
	*/
		'item' => array(
			/**
			 * @reference
			 * 	[Parent]/controller/fragment/excerpt.php
			 * 	[Parent]/controller/fragment/image.php
			 * 	[Parent]/controller/fragment/meta.php
			 * 	[Parent]/controller/fragment/title.php
			 * 	[Parent]/template-part/item/general.php
			*/
			'general' => array(
				'image' => 'windmill/item/general/image',
				'header' => 'windmill/item/general/header',
				'body' => 'windmill/item/general/body',
				'footer' => 'windmill/item/general/footer',
			),

			/**
			 * @reference
			 * 	[Parent]/controller/fragment/excerpt.php
			 * 	[Parent]/controller/fragment/image.php
			 * 	[Parent]/controller/fragment/meta.php
			 * 	[Parent]/controller/fragment/title.php
			 * 	[Parent]/template-part/item/card.php
			*/
			'card' => array(
				'image' => 'windmill/item/card/image',
				'header' => 'windmill/item/card/header',
				'body' => 'windmill/item/card/body',
				'footer' => 'windmill/item/card/footer',
			),

			/**
			 * @reference
			 * 	[Parent]/controller/fragment/image.php
			 * 	[Parent]/controller/fragment/meta.php
			 * 	[Parent]/template-part/item/gallery.php
			*/
			'gallery' => array(
				'image' => 'windmill/item/gallery/image',
				'header' => 'windmill/item/gallery/header',
			),

			/**
			 * @reference
			 * 	[Parent]/controller/fragment/image.php
			 * 	[Parent]/controller/fragment/meta.php
			 * 	[Parent]/controller/fragment/title.php
			 * 	[Parent]/template-part/item/list.php
			*/
			'list' => array(
				'image' => 'windmill/item/list/image',
				'header' => 'windmill/item/list/header',
			),
		),

		/**
		 * @reference
		 * 	[Parent]/model/app/image.php
		*/
		'figure' => array(
			'title' => 'windmill/caption/title',
			'meta' => 'windmill/caption/meta',
		),

		/**
		 * @reference
		 * 	[Parent]/model/app/nav.php
		*/
		'nav' => array(
			'offcanvas' => array(
				'prepend' => 'windmill/nav/offcanvas/prepend',
				'main' => 'windmill/nav/offcanvas/main',
				'append' => 'windmill/nav/offcanvas/append',
			),
			'primary' => array(
				'prepend' => 'windmill/nav/primary/prepend',
				'main' => 'windmill/nav/primary/main',
				'append' => 'windmill/nav/primary/append',
			),

			/**
			 * @reference
			 * 	[Parent]/model/wrap/nav.php
			*/
			'secondary' => array(
				'prepend' => 'windmill/nav/secondary/prepend',
				'main' => 'windmill/nav/secondary/main',
				'append' => 'windmill/nav/secondary/append',
			),
		),

	/* Model/Application
	_________________________
	*/
		'model' => array(
			/**
			 * @reference
			 * 	[Parent]/model/app/amp.php
			*/
			'amp' => array(
				'prepend' => 'windmill/model/amp/prepend',
				'main' => 'windmill/model/amp/main',
				'append' => 'windmill/model/amp/append',
			),

			/**
			 * @reference
			 * 	[Parent]/model/app/back2top.php
			*/
			'back2top' => array(
				'prepend' => 'windmill/model/back2top/prepend',
				'main' => 'windmill/model/back2top/main',
				'append' => 'windmill/model/back2top/append',
			),

			/**
			 * @reference
			 * 	[Parent]/model/app/branding.php
			*/
			'branding' => array(
				'prepend' => 'windmill/model/branding/prepend',
				'main' => 'windmill/model/branding/main',
				'append' => 'windmill/model/branding/append',
			),

			/**
			 * @reference
			 * 	[Parent]/model/app/breadcrumb.php
			*/
			'breadcrumb' => array(
				'prepend' => 'windmill/model/breadcrumb/prepend',
				'main' => 'windmill/model/breadcrumb/main',
				'append' => 'windmill/model/breadcrumb/append',
			),
/*
			'comments' => array(
				'prepend' => 'windmill/model/comments/prepend',
				'main' => 'windmill/model/comments/main',
				'append' => 'windmill/model/comments/append',
			),
*/
			/**
			 * @reference
			 * 	[Parent]/model/app/credit.php
			*/
			'credit' => array(
				'prepend' => 'windmill/model/credit/prepend',
				'main' => 'windmill/model/credit/main',
				'append' => 'windmill/model/credit/append',
			),
/*
			'dynamic_sidebar' => array(
				'prepend' => 'windmill/model/dynamic_sidebar/prepend',
				'main' => 'windmill/model/dynamic_sidebar/main',
				'append' => 'windmill/model/dynamic_sidebar/append',
			),
*/
			/**
			 * @reference
			 * 	[Parent]/model/app/excerpt.php
			*/
			'excerpt' => array(
				'prepend' => 'windmill/model/excerpt/prepend',
				'main' => 'windmill/model/excerpt/main',
				'append' => 'windmill/model/excerpt/append',
			),

			/**
			 * @reference
			 * 	[Parent]/model/app/follow.php
			*/
			'follow' => array(
				'prepend' => 'windmill/model/follow/prepend',
				'main' => 'windmill/model/follow/main',
				'append' => 'windmill/model/follow/append',
			),

			/**
			 * @reference
			 * 	[Parent]/model/app/image.php
			*/
			'image' => array(
				'prepend' => 'windmill/model/image/prepend',
				'main' => 'windmill/model/image/main',
				'append' => 'windmill/model/image/append',
			),
/*
			'meta' => array(
				'prepend' => 'windmill/model/meta/prepend',
				'main' => 'windmill/model/meta/main',
				'append' => 'windmill/model/meta/append',
			),
*/
			/**
			 * @reference
			 * 	[Parent]/model/app/nav.php
			*/
			'nav' => array(
				'prepend' => 'windmill/model/nav/prepend',
				'main' => 'windmill/model/nav/main',
				'append' => 'windmill/model/nav/append',
			),

			/**
			 * @reference
			 * 	[Parent]/model/app/pagination.php
			*/
			'pagination' => array(
				'prepend' => 'windmill/model/pagination/prepend',
				'main' => 'windmill/model/pagination/main',
				'append' => 'windmill/model/pagination/append',
			),

			/**
			 * @reference
			 * 	[Parent]/model/app/post-link.php
			*/
			'post-link' => array(
				'prepend' => 'windmill/model/post-link/prepend',
				'main' => 'windmill/model/post-link/main',
				'append' => 'windmill/model/post-link/append',
			),

			/**
			 * @reference
			 * 	[Parent]/model/app/search.php
			*/
			'search' => array(
				'prepend' => 'windmill/model/search/prepend',
				'main' => 'windmill/model/search/main',
				'append' => 'windmill/model/search/append',
			),

			/**
			 * @reference
			 * 	[Parent]/model/app/share.php
			*/
			'share' => array(
				'prepend' => 'windmill/model/share/prepend',
				'main' => 'windmill/model/share/main',
				'append' => 'windmill/model/share/append',
			),

			/**
			 * @reference
			 * 	[Parent]/model/app/sitemap.php
			*/
			'html-sitemap' => array(
				'prepend' => 'windmill/model/html-sitemap/prepend',
				'main' => 'windmill/model/html-sitemap/main',
				'append' => 'windmill/model/html-sitemap/append',
			),

			/**
			 * @reference
			 * 	[Parent]/model/app/title.php
			*/
			'title' => array(
				'prepend' => 'windmill/model/title/prepend',
				'main' => 'windmill/model/title/main',
				'append' => 'windmill/model/title/append',
			),
		),
	));
}
