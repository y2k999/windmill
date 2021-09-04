<?php
/**
 * Child class that extends _widget_base (parrent class).
 * @link https://codex.wordpress.org/Widgets_API
 * @package Windmill
 * @license GPL3.0+
 * @since 1.0.1
*/

/**
 * Inspired by Core class used to implement WP_Widget.
 * @link https://codex.wordpress.org/Widgets_API
 * @see WP_Widget
 * 
 * Inspired by Magazine Plus WordPress theme.
 * @link https://wenthemes.com/item/wordpress-themes/magazine-plus/
 * @see WEN Themes
 * 
 * Inspired by Luxeritas WordPress theme.
 * @link https://thk.kanzae.net/wp/
 * @see LunaNuko
*/


/* Prepare
______________________________
*/

// If this file is called directly,abort.
if(!defined('WPINC')){die;}

// Set identifiers for this template.
// $index = basename(__FILE__,'.php');


	beans_add_smart_action('widgets_init','__register_widget_relation');
	/**
	 * @reference (Beans)
	 * 	Set beans_add_action() using the callback argument as the action ID.
	 * 	https://www.getbeans.io/code-reference/functions/beans_add_smart_action/
	 * @reference (WP)
	 * 	Fires after all default WordPress widgets have been registered.
	 * 	https://developer.wordpress.org/reference/hooks/widgets_init/
	*/
	if(function_exists('__register_widget_relation') === FALSE) :
	function __register_widget_relation()
	{
		/**
		 * @reference (WP)
		 * 	Register Widget
		 * 	https://developer.wordpress.org/reference/functions/register_widget/
		*/
		register_widget('_widget_relation');

	}// Method
	endif;


/* Exec
______________________________
*/
if(class_exists('_widget_relation') === FALSE) :
class _widget_relation extends _widget_base
{
/**
 * [TOC]
 * 	__construct()
 * 	set_field()
 * 	widget()
 * 		get_param()
 * 		__the_nopost()
 * 		get_template_part()
 * 	get_terms_in()
 * 	form()
 * 	update()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/Identifier with prefix.
		@var (string) $_index
			Name/Identifier without prefix.
	*/
	private static $_class = '';
	private static $_index = '';

	/**
	 * Traits.
	*/
	use _trait_theme;


	/* Constructor
	_________________________
	*/
	public function __construct()
	{
		/**
			@access (public)
				Sets up a new widget instance.
			@return (void)
			@reference
				[Parent]/inc/utility/general.php
				[Parent]/model/widget/base.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);

		$widget_options = array(
			'classname' => 'widget' . self::$_class,
			'description' => '[Windmill]' . ' ' . ucfirst(self::$_index),
			'customize_selective_refresh' => TRUE,
		);

		parent::__construct(
			self::$_index,
			ucfirst(self::$_index),
			$widget_options,
			array(),
			$this->set_field()
		);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_field()
	{
		/**
			@access (private)
				Helper function that holds widget fields.
				Array is used in update and form functions.
			@return (array)
				_filter[_widget_relation][field]
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
			'title' => array(
				'label' => esc_html__('Title','windmill'),
				'type' => 'text',
				'default' => esc_html('Related Posts'),
			),
			/**
			 * @reference (WP)
			 * 	Show at most x many posts on blog pages.
			 * 	https://codex.wordpress.org/Option_Reference
			*/
			'number' => array(
				'label' => esc_html__('Number of Posts to Show','windmill'),
				'type' => 'number',
				'default' => get_option('posts_per_page'),
			),
			'format' => array(
				'label' => esc_html__('Format','windmill'),
				'type' => 'select',
				'option' => __utility_get_format(),
				'default' => 'gallery',
			),
			'autoplay' => array(
				'label' => esc_html__('Autoplay','windmill'),
				'type' => 'checkbox',
				'default' => TRUE,
			),
		));

	}// Method


	/* Method
	_________________________
	*/
	public function widget($args,$instance)
	{
		/**
			@access (public)
				The WordPress Query class.
				https://developer.wordpress.org/reference/classes/wp_query/
			@param (array) $args
				Display arguments including 'before_title', 'after_title','before_widget', and 'after_widget'.
			@param (object) $instance
				The settings for the particular instance of the widget.
			@return (void)
			@reference
				[Parent]/controller/widget.php
				[Parent]/controller/fragment/widget.php
				[Parent]/controller/structure/single.php
				[Parent]/template/content/singular.php
				[Parent]/template-part/content/content.php
		*/
		$class = self::$_class;

		/**
		 * @reference
		 * 	[Parent]/model/widget/base.php
		*/
		$param = $this->get_param($instance);

		/**
		 * @since 1.0.1
		 * 	echo $args['before_widget'];
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_open_markup_e/
		 * 	https://www.getbeans.io/code-reference/functions/beans_close_markup_e/
		*/
		beans_open_markup_e("_section[{$class}]",'div',array('class' => self::$_index));

			/**
			 * @since 1.0.1
			 * 	echo $args['before_title'] . $param['title'] . $args['after_title'];
			 * @reference
			 * 	This filter is documented in wp-includes/widgets/class-wp-widget-pages.php
			*/
			if(!empty($param['title'])){
				self::__the_title($param['title'],'div');
			}

			// Get current post data.
			$post = __utility_get_post_object();

			/**
			 * @since 3.4.0
			 * 	Filters the arguments for the Recent Posts widget.
			 * 	https://developer.wordpress.org/reference/classes/wp_query/
			 * @since 4.9.0
			 * 	Added the `$instance` parameter.
			 * @see WP_Query::get_posts()
			 * @param (array) $args
			 * 	An array of arguments used to retrieve the recent posts.
			 * @param (array) $instance
			 * 	Array of settings for the current widget.
			*/
			$r = new WP_Query(
				beans_apply_filters("_filter[{$class}][query]",array(
					'posts_per_page' => $param['number'],
					// 'post__not_in' => array($post->ID),
					'post__in' => $this->get_terms_in($post),
					'post_status' => 'publish',
					'orderby' => 'post__in',
					'ignore_sticky_posts' => TRUE,
					'no_found_rows' => TRUE,
				),$instance)
			);

			/**
			 * @reference (WP)
			 * 	Determines whether current WordPress query has posts to loop over.
			 * 	https://developer.wordpress.org/reference/functions/have_posts/
			 * @reference
			 * 	[Parent]/inc/trait/theme.php
			*/
			if(!$r->have_posts()){
				self::__the_nopost();
			}

			/**
			 * @since 1.0.1
			 * 	Widget content.
			 * @reference (Uikit)
			 * 	https://getuikit.com/docs/slider
			 * @reference
			 * 	[Parent]/controller/layout.php
			 * 	[Parent]/inc/utility/theme.php
			*/
			if($param['autoplay']){
				beans_open_markup_e("_container[{$class}]",'div',array('class' => 'uk-position-relative uk-dark'));
					beans_open_markup_e("_effect[{$class}]",'div',array('uk-slider' => 'autoplay: true autoplay-interval: 4500 pause-on-hover: true'));
						beans_open_markup_e("_wrapper[{$class}]",'div',array(
							'class' => 'uk-slider-items',
						));
			}
			else{
				beans_open_markup_e("_wrapper[{$class}]",'div',array('class' => 'uk-padding-small'));
			}

			/**
			 * @reference (WP)
			 * 	Iterate the post index in the loop.
			 * 	https://developer.wordpress.org/reference/functions/the_post/
			 * @reference
			 * 	[Parent]/inc/setup/constant.php
			 * 	[Parent]/template-part/item/xxx.php
			*/
			while($r->have_posts()) :	$r->the_post();
				get_template_part(SLUG['item'] . $param['format']);
			endwhile;

			/**
			 * @since 1.0.1
			 * 	Only reset the query if a filter is set.
			 * @reference (WP)
			 * 	After looping through a separate query, this function restores the $post global to the current post in the main query.
			 * 	https://developer.wordpress.org/reference/functions/wp_reset_postdata/
			*/
			wp_reset_postdata();

			if($param['autoplay']){
					beans_close_markup_e("_wrapper[{$class}]",'div');
					// Carousel Pagination
					get_template_part(SLUG['nav'] . 'slider-default');
					// get_template_part(SLUG['nav'] . 'slider-dotnav');
					beans_close_markup_e("_effect[{$class}]",'div');
				beans_close_markup_e("_container[{$class}]",'div');
			}
			else{
				beans_close_markup_e("_wrapper[{$class}]",'div');
			}

		/**
		 * @since 1.0.1
		 * 	echo $args['after_widget'];
		*/
		beans_close_markup_e("_section[{$class}]",'div');

	}// Method


	/**
		@access (private)
			Get the post_id that belong to the same categories/tags.
		@global (WP_Query) $wp_query
		@global (wpdb) $wpdb
			https://codex.wordpress.org/Global_Variables
		@param (int) $post
			Current post.
		@return (WP_Term[])
			Array of WP_Term objects, one for each category assigned to the post.
	*/
	private function get_terms_in($post)
	{

		// Get current post data.
		$post = __utility_get_post_object();

		// WP global.
		global $wpdb;

		$cat_post_id = array();
		$tag_post_id = array();

		if(isset($post->ID)){
			/**
			 * @reference (WP)
			 * 	Retrieves post categories.
			 * 	https://developer.wordpress.org/reference/functions/get_the_category/
			 * 	Retrieves the tags for a post.
			 * 	https://developer.wordpress.org/reference/functions/get_the_tags/
			*/
			$categories = get_the_category($post->ID);
			$tags = get_the_tags($post->ID);
		}
		else{
			// WP global.
			global $wp_query;
			/**
			 * @reference (WP)
			 * 	Retrieves post data given a post ID or post object.
			 * 	https://developer.wordpress.org/reference/functions/get_post/
			*/
			$post = get_post($wp_query->post->ID);
			$categories = get_the_category($post->ID);
			$tags = get_the_tags($post->ID);
		}

		/**
		 * [NOTE]
		 * 	関数使うより直接 SELECT 文発行した方が速い
		*/
		if(!empty($categories)){
			foreach((array)$categories as $item){
				// $cat_post_id = wp_parse_args($cat_post_id, $wpdb->get_col("SELECT object_id FROM $wpdb->term_relationships WHERE term_taxonomy_id = $item->cat_ID AND object_id != $post->ID"));
				$cat_post_id = wp_parse_args($cat_post_id,$wpdb->get_col("SELECT object_id FROM $wpdb->term_relationships, $wpdb->term_taxonomy WHERE $wpdb->term_taxonomy.term_id = $item->cat_ID AND $wpdb->term_taxonomy.term_taxonomy_id = $wpdb->term_relationships.term_taxonomy_id AND object_id != $post->ID"));
			}
			shuffle($cat_post_id);
		}

		if(!empty($tags)){
			foreach((array)$tags as $item){
				// $tag_post_id = wp_parse_args($tag_post_id, $wpdb->get_col("SELECT object_id FROM $wpdb->term_relationships WHERE term_taxonomy_id = $item->term_taxonomy_id AND object_id != $post->ID"));
				$tag_post_id = wp_parse_args($tag_post_id,$wpdb->get_col("SELECT object_id FROM $wpdb->term_relationships, $wpdb->term_taxonomy WHERE $wpdb->term_taxonomy.term_taxonomy_id = $item->term_taxonomy_id AND $wpdb->term_taxonomy.term_taxonomy_id = $wpdb->term_relationships.term_taxonomy_id AND object_id != $post->ID"));
			}
			shuffle($tag_post_id);
		}

		/**
		 * [NOTE]
		 * 	同じタグに属する記事を優先表示させるため wp_parse_args 使わない( wp_parse_args だと同じ値があった時に、配列の後ろが残る形になるため )
		 * 		$post_in = wp_parse_args( $tag_post_id, $cat_post_id );
		 * 	key は使わず単なる連番なので、array_merge で結合するより + 演算子で結合しちゃった方が速い
		 * 		$post_in = array_unique( $tag_post_id + $cat_post_id );
		 * 	と思ったけど、array_merge じゃないと要素が消えるパターンがあるから、やっぱり array_merge にしたｗ
		*/
		$post_in = array_unique(array_merge($tag_post_id,$cat_post_id));

		return $post_in;

	}// Method


	/**
	 * [NOTE]
	 * 	form() method and update() method are defined in the parent class.
	 * @reference
	 * 	[Parent]/controller/widget.php
	 * 	[Parent]/model/widget/base.php
	*/


}// Class
endif;
new _widget_relation();
