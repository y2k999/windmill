<?php
/**
 * Configure the integration with third-party libraries.
 * @link https://jetpack.com/
 * @package Windmill
 * @license GPL3.0+
 * @since 1.0.1
*/

/**
 * Inspired by Beans Framework WordPress Theme
 * @link https://www.getbeans.io
 * @author Thierry Muller
 * 
 * Inspired by All in One SEO WordPress Plugin
 * @link https://aioseo.com/
 * @author All in One SEO Team
 * 
 * Inspired by AD5 WordPress Lab
 * @link http://wordpress.ad5.jp/column/replace-all-in-one-seo-pack/
 * @author AD5
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
if(class_exists('_windmill_aioseop') === FALSE) :
class _windmill_aioseop
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_field()
 * 	set_post_type()
 * 	set_hook()
 * 	invoke_hook()
 * 	add_meta_boxes()
 * 	save_post()
 * 	__the_render()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/identifier with prefix.
		@var (string) $_index
			Name/identifier without prefix.
		@var (array) $field
			Custom fields for SEO.
		@param (string) $meta_key
			Meta box ID (used in the 'id' attribute for the meta box).
		@param (string) $meta_nonce
			Nonce value that was used for verification, usually via a form field.
		@var (array) $post_type
			Registered post types.
		@var (array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private $field = array();
	private $meta_key = '';
	private $meta_nonce = '';
	private $post_type = array();
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

		$this->field = $this->set_field();
		$this->meta_key = 'windmill_seo';
		$this->meta_nonce = 'windmill_seo_nonce';

		$this->post_type = $this->set_post_type();

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook($this->hook);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_field()
	{
		/**
			@access (private)
				Setup SEO admin instead of All In One SEO Pack.
			@return (array)
				_filter[_windmill_aioseop][field]
			@reference
				[Parent]/inc/env/head.php
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
			'title' => '_aioseop_title',
			'keywords' => '_aioseop_keywords',
			'description' => '_aioseop_description',
		));

	}//Method


	/* Setter
	_________________________
	*/
	private function set_post_type()
	{
		/**
			@access (private)
				Set post types to add seo fields on editor.
			@return (array)
				_filter[_windmill_aioseop][post_type]
			@reference
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
			'post',
			'page',
		));

	}//Method


	/* Setter
	_________________________
	*/
	private function set_hook()
	{
		/**
			@access (private)
				The collection of hooks that is being registered (that is, actions or filters).
			@return (array)
				_filter[_windmill_aioseop][hook]
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
			'add_meta_boxes' => array(
				'tag' => 'add_action',
				'hook' => 'add_meta_boxes'
			),
			'save_post' => array(
				'tag' => 'add_action',
				'hook' => 'save_post'
			),
		)));

	}// Method


	/* Hook
	_________________________
	*/
	public function add_meta_boxes($post_type)
	{
		/**
			@access (public)
				Fires after all built-in meta boxes have been added.
				https://developer.wordpress.org/reference/hooks/add_meta_boxes/
			@return (void)
		 */
		if(in_array($post_type,$this->post_type)){
			/**
			 * @reference (WP)
			 * 	Adds a meta box to one or more screens.
			 * 	https://developer.wordpress.org/reference/functions/add_meta_box/
			 * @param (string) $id
			 * 	Meta box ID (used in the 'id' attribute for the meta box).
			 * @param (string) $title
			 * 	Title of the meta box.
			 * @param (callable) $callback
			 * 	Function that fills the box with the desired content. The function should echo its output.
			 * @param (string)|(array)|(WP_Screen) $screen
			 * 	The screen or screens on which to show the box (such as a post type, 'link', or 'comment').
			 * @param (string) $context
			 * 	The context within the screen where the box should display. 
			 * @param (string) $priority
			 * 	The priority within the context where the box should show.
			 * 	Accepts 'high', 'core', 'default', or 'low'.
			*/
			add_meta_box(
				$this->meta_key,
				esc_html__('SEO Settings','windmill'),
				[$this,'__the_render'],
				$this->post_type,
				'advanced',
				'high'
			);
		}

	}// Method


	/* Hook
	_________________________
	*/
	public function save_post($post_id)
	{
		/**
			@access (public)
				Fires once a post has been saved.
				https://developer.wordpress.org/reference/hooks/save_post/
				Save the inputs of metaboxes as custom field values.
			@param (int) $post_id
				Post id.
			@return (void)
		 */

		// Check the nonce.
		if(!isset($_POST[$this->meta_nonce])){
			return $post_id;
		}

		$nonce = $_POST[$this->meta_nonce];
		/**
		 * @reference (WP)
		 * 	Verifies that a correct security nonce was used with time limit.
		 * 	https://developer.wordpress.org/reference/functions/wp_verify_nonce/
		*/
		if(!wp_verify_nonce($nonce,$this->meta_key)){
			return $post_id;
		}

		// Ignore WP autosave.
		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
			return $post_id;
		}

		// Check the capability.
		$post_type = $_POST['post_type'];
		$cap = $GLOBALS['wp_post_types'][$post_type]->cap->edit_post;

		/**
		 * @reference (WP)
		 * 	Returns whether the current user has the specified capability.
		 * 	https://developer.wordpress.org/reference/functions/current_user_can/
		*/
		if(!current_user_can($cap,$post_id)){
			return $post_id;
		}

		/**
		 * @since 1.0.1
		 * 	Save
		 * @reference (WP)
		 * 	Sanitizes a string from user input or from the database.
		 * 	https://developer.wordpress.org/reference/functions/sanitize_text_field/
		*/
		$title = sanitize_text_field($_POST[$this->field['title']]);
		$keywords = sanitize_text_field($_POST[$this->field['keywords']]);
		$description = sanitize_text_field($_POST[$this->field['description']]);

		/**
		 * @reference (WP)
		 * 	Updates a post meta field based on the given post ID.
		 * 	https://developer.wordpress.org/reference/functions/update_post_meta/
		*/
		update_post_meta($post_id,$this->field['title'],$title);
		update_post_meta($post_id,$this->field['keywords'],$keywords);
		update_post_meta($post_id,$this->field['description'],$description);

	}// Method


	/* Method
	_________________________
	*/
	public function __the_render()
	{
		/**
			@access (public)
				Function that fills the box with the desired content.
				The function should echo its output.
			@return (void)
			@reference (WP)
				Adds a meta box to one or more screens.
				https://developer.wordpress.org/reference/functions/add_meta_box/
		*/

		/**
		 * @reference (WP)
		 * 	Retrieve or display nonce hidden field for forms.
		 * 	https://developer.wordpress.org/reference/functions/wp_nonce_field/
		*/
		wp_nonce_field($this->meta_key,$this->meta_nonce);

		// Get current post data.
		$post = __utility_get_post_object();

		/**
		 * @reference (WP)
		 * 	Retrieves a post meta field for the given post ID.
		 * 	https://developer.wordpress.org/reference/functions/get_post_meta/
		*/
		$title = get_post_meta($post->ID,$this->field['title'],TRUE);
		$keywords = get_post_meta($post->ID,$this->field['keywords'],TRUE);
		$description = get_post_meta($post->ID,$this->field['description'],TRUE);
		?>
		<table class="form-table">
			<tr>
				<th><?php echo esc_html__('Meta Title','windmill'); ?></th>
				<td><input type="text" name="_aioseop_title" value="<?php echo $title; ?>" style="width:100%; padding:5px;"></td>
			</tr>
			<tr>
				<th><?php echo esc_html__('Meta Keyword','windmill'); ?></th>
				<td><input type="text" name="_aioseop_keywords" value="<?php echo $keywords; ?>" style="width:100%; padding:5px;"></td>
			</tr>
			<tr>
				<th><?php echo esc_html__('Meta Description','windmill'); ?></th>
				<td><textarea name="_aioseop_description" style="width:100%; height:100px; padding:5px;"><?php echo $description; ?></textarea></td>
			</tr>
		</table>

	<?php
	}// Method


}// Class
endif;
// new _windmill_aioseop();
_windmill_aioseop::__get_instance();
