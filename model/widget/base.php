<?php
/**
 * Child class that extends WP_Widget.
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
 * Inspired by Eggnews WordPress theme.
 * @link https://themeegg.com/themes/eggnews/
 * @see ThemeEgg
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
if(class_exists('_widget_base') === FALSE) :
class _widget_base extends WP_Widget
{
/**
 * [TOC]
 * 	widget()
 * 	update()
 * 	form()
 * 	__construct()
 * 	render_field()
 * 	render_description()
 * 	get_param()
 * 	add_defaults()
 * 	sanitize()
*/

	/**
		@access (private)
			Class properties.
		@var (array) $fields
			Widget fields.
	*/
	private $fields = array();


	/* Constructor
	_________________________
	*/
	public function __construct($id_base,$name,$widget_options = array(),$control_options = array(),$fields = array())
	{
		/**
			@since 1.0.1
				PHP5 constructor.
				wp-includes/class-wp-widget.php
			@access (public)
			@param (string) $id_base
				[Optional].
				Base ID for the widget, lowercase and unique.
				If left empty, a portion of the widget's class name will be used.
				Has to be unique.
			@param (string) $name
				Name for the widget displayed on the configuration page.
			@param (array) $widget_options
				[Optional].
				Widget options. See wp_register_sidebar_widget() for information on accepted arguments.
				Default empty array.
			@param (array) $control_options
				[Optional].
				Widget control options.
				See wp_register_widget_control() for information on accepted arguments.
				Default empty array.
			@param (array) $fields
				Fields.
		*/

		// Init properties.
		$this->fields = $fields;

		parent::__construct(
			$id_base,
			$name,
			$widget_options,
			$control_options
		);

	}// Method


	/* Method
	_________________________
	*/
	public function widget($args,$instance)
	{
		/**
			@since 2.8.0
				Echoes the widget content.
				Subclasses should override this function to generate their widget code.
			@param (array) $args
				Display arguments including 'before_title', 'after_title', 'before_widget', and 'after_widget'.
			@param (array) $instance
				The settings for the particular instance of the widget.
		*/

	}// Method


	/* Method
	_________________________
	*/
	public function form($instance)
	{
		/**
			@since 2.8.0
				Outputs the settings update form.
			@param (array) $instance
				Current settings.
			@return (string)
				Default return is 'noform'.
		*/
		$instance = $this->set_default($instance);
		foreach($this->fields as $key => $value){
			$this->render($key,$value,$instance);
		}

	}// Method


	/* Method
	_________________________
	*/
	public function update($new_instance,$old_instance)
	{
		/**
			@since 2.8.0
				Updates a particular instance of a widget.
				This function should check that `$new_instance` is set correctly.
				The newly-calculated value of `$instance` should be returned.
				If false is returned, the instance won't be saved/updated.
			@param (array) $new_instance
				New settings for this instance as input by the user via WP_Widget::form().
			@param (array) $old_instance
				Old settings for this instance.
			@return (array)
				Settings to save or bool false to cancel saving.
		*/
		$instance = $old_instance;
		foreach($this->fields as $key => $value){
			$instance[$key] = $this->sanitize($key,$value,$new_instance[$key]);
		}
		return $instance;

	}// Method


	/**
		@since 1.0.1
			Returns widget parameters.
		@access (public)
		@param (array) $instance
			Widget instance.
		@return (array)
			Parameters.
	*/
	public function get_param($instance)
	{
		$return = array();
		if(!empty($this->fields)){
			if(isset($instance['title'])){
				/**
				 * @reference (WP)
				 * 	Filters the widget title.
				 * 	https://developer.wordpress.org/reference/hooks/widget_title/
				*/
				$instance['title'] = apply_filters('widget_title',empty($instance['title']) ? '' : $instance['title'],$instance,$this->id_base);
			}
			$return = $this->set_default($instance);
		}
		return $return;

	}// Method


	/**
		@since 1.0.1
			Return updated instance with defaults.
		@access (private)
		@param (array) $instance
			Widget instance.
		@return (array)
			Updated instance.
	*/
	private function set_default($instance)
	{
		$return = array();
		if(!empty($this->fields)){
			foreach($this->fields as $key => $value){
				$return[$key] = NULL;
				if(!isset($instance[$key]) && isset($value['default'])){
					$return[$key] = $value['default'];
				}
			}
		}
		// $instance = array_merge($return,$instance);
		$instance = wp_parse_args($return,$instance);

		return $instance;

	}// Method


	/**
		@since 1.0.1
			Sanitize field value.
		@access (private)
		@param (string) $key
			Field key.
		@param (array) $value
			Field.
		@param (array) $instance
			Widget instance.
		@return (void)
	*/
	private function render($key,$value,$instance)
	{
		$input = NULL;
		if(isset($instance[$key])){
			$input = $instance[$key];
		}

		$type = 'text';
		if(isset($value['type'])){
			$type = esc_attr($value['type']);
		}

		if(!isset($value['description'])){
			$value['description'] = '';
		}

		if(!isset($value['option'])){
			$value['option'] = array();
		}

		if(!isset($value['rows']) || absint($value['rows']) < 1){
			$value['rows'] = 5;
		}

		switch($type){
			/**
			 * @reference
			 * 	 - name： It allows the server to access each button's value when submitted.
			 * 	 - value： The value sent to the server when submitting the form.
			 * 	The name value must be unique within the context of a <form> container.
			 * 	https://www.w3schools.com/TAGS/default.ASP
			*/
			case 'text' :
			?>
				<p>
					<label for="<?php echo esc_attr($this->get_field_id($key)); ?>"><?php echo esc_html($value['label']); ?> :</label>
					<input type="<?php echo esc_attr($type); ?>" name="<?php echo esc_attr($this->get_field_name($key)); ?>" id="<?php echo esc_attr($this->get_field_id($key)); ?>" class="widefat" value="<?php echo esc_attr($input); ?>" />
					<?php if(isset($value['description'])) : ?>
						<br/>
						<small><?php echo esc_html($value['description']); ?></small>
					<?php endif; ?>
				</p>
				<?php
				break;

			/**
			 * @reference
			 * 	 - value： The value sent to the server when submitting the form.
			 * 	The input value(http://) is automatically validated before the form can be submitted.
			 * 	https://www.w3schools.com/TAGS/default.ASP
			*/
			case 'url' :
			case 'email' :
			?>
				<p>
					<label for="<?php echo esc_attr($this->get_field_id($key)); ?>"><?php echo esc_html($value['label']); ?> :</label>
					<input type="<?php echo esc_attr($type); ?>" name="<?php echo esc_attr($this->get_field_name($key)); ?>" id="<?php echo esc_attr($this->get_field_id($key)); ?>" class="widefat" value="<?php echo esc_attr($input); ?>" />
					<?php if(isset($value['description'])) : ?>
						<br/>
						<small><?php echo esc_html($value['description']); ?></small>
					<?php endif; ?>
				</p>
				<?php
				break;

			/**
			 * @reference
			 * 	 - cols： Specifies the width of the text area (in average character width). Default value is 20.
			 * 	 - rows： Specifies the height of the text area (in lines). Default value is 2.
			 * 	https://www.w3schools.com/TAGS/default.ASP
			*/
			case 'textarea' :
			?>
				<p>
					<label for="<?php echo esc_attr($this->get_field_id($key)); ?>"><?php echo esc_html($value['label']); ?></label>
					<textarea type="text" name="<?php echo esc_attr($this->get_field_name($key)); ?>" id="<?php echo esc_attr($this->get_field_id($key)); ?>" class="widefat" rows="<?php echo absint($value['rows']); ?>" ><?php echo esc_textarea($input); ?></textarea>
					<?php if(isset($value['description'])) : ?>
						<br/>
						<small><?php echo esc_html($value['description']); ?></small>
					<?php endif; ?>
				</p>
				<?php
				break;

			/**
			 * @reference
			 * 	https://www.w3schools.com/TAGS/default.ASP
			*/
			case 'number' :
				?>
				<p>
					<label for="<?php echo esc_attr($this->get_field_id($key)); ?>"><?php echo esc_html($value['label']); ?></label>
					<br/>
					<input name="<?php echo esc_attr($this->get_field_name($key)); ?>" type="<?php echo esc_attr($type); ?>" step="1" min="1" id="<?php echo esc_attr($this->get_field_id($key)); ?>" value="<?php echo esc_attr($input); ?>" />
					<?php if(isset($value['description'])) : ?>
						<br/>
						<small><?php echo esc_html($value['description']); ?></small>
					<?php endif; ?>
				</p>
				<?php 
				break;

			/**
			 * @reference
			 * 	 - value： Defines the unique value associated with each radio button.
			 * 	 - checked: Specifies that an <input> element should be pre-selected (checked) when the page loads.
			 * 	 - required: Specifies that an input field must be filled out before submitting the form.
			 * 	https://www.w3schools.com/TAGS/default.ASP
			*/
			case 'checkbox' :
				?>
				<p>
					<input type="checkbox" name="<?php echo esc_attr($this->get_field_name($key)); ?>" id="<?php echo esc_attr($this->get_field_id($key)); ?>" value="1" <?php echo checked(!empty($input)); ?> />

					<label for="<?php echo esc_attr($this->get_field_id($key)); ?>"><?php echo esc_html($value['label']); ?></label>
					<?php if(isset($value['description'])) : ?>
						<br/>
						<small><?php echo esc_html($value['description']); ?></small>
					<?php endif; ?>
				</p>
				<?php
				break;

			/**
			 * @reference
			 * 	https://www.w3schools.com/TAGS/default.ASP
			*/
			case 'radio' :
				?>
				<p>
					<label for="<?php echo esc_attr($this->get_field_id($key)); ?>"><?php echo esc_html($value['label']); ?></label>
					<br/>
					<?php if(!empty($value['option'])) : ?>
						<?php foreach($value['option'] as $k => $v) : ?>
							<label for="<?php echo esc_attr($this->get_field_id($key) . '-' . $k); ?>">
								<input type="<?php echo esc_attr($type); ?>" name="<?php echo esc_attr($this->get_field_name($key)); ?>" id="<?php echo esc_attr($this->get_field_id($key) . '-' . $k); ?>" value="<?php echo esc_attr($k); ?>" <?php checked($k,$input) ?> /><?php echo esc_html($v); ?>
							</label>&nbsp;&nbsp;
						<?php endforeach; ?>
					<?php endif; ?>
					<?php if(isset($value['description'])) : ?>
						<br/>
						<small><?php echo esc_html($value['description']); ?></small>
					<?php endif; ?>
				</p>
				<?php
				break;

			/**
			 * @reference
			 * 	https://www.w3schools.com/TAGS/default.ASP
			*/
			case 'select' :
				?>
				<p>
					<label for="<?php echo esc_attr($this->get_field_id($key)); ?>"><?php echo esc_html($value['label']); ?></label>
					<select type="text" id="<?php echo esc_attr($this->get_field_id($key)); ?>" name="<?php echo esc_attr($this->get_field_name($key)); ?>">
						<?php if(!empty($value['option'])) : ?>
							<?php foreach($value['option'] as $option_key => $label) : ?>
									<option value="<?php echo esc_attr($option_key); ?>" <?php selected($option_key,$input); ?>><?php echo esc_html($label); ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
					<?php if(isset($value['description'])) : ?>
						<br/>
						<small><?php echo esc_html($value['description']); ?></small>
					<?php endif; ?>
				</p>
				<?php
				break;

			/**
			 * @reference
			 * 	https://www.w3schools.com/TAGS/default.ASP
			*/
			case 'image' :
				?>
				<p>
					<label for="<?php echo esc_attr($this->get_field_id($key)); ?>"><?php echo esc_html($value['label']); ?></label>
					<br />
					<div class="media-uploader" id="<?php echo $this->get_field_id($key); ?>">
						<div class="custom_media_preview">
							<?php if($value != '') : ?>
								<img class="custom_media_preview_default" src="<?php echo esc_url($input); ?>" style="max-width: 100%;" />
							<?php endif; ?>
						</div>

						<input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id($key); ?>" name="<?php echo $this->get_field_name($key); ?>" value="<?php echo esc_url($input); ?>" style="margin-top:5px;" />

						<button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id($key); ?>" data-choose="<?php echo esc_attr__('Choose Media','windmill'); ?>" data-update="<?php echo esc_attr__('Update Media','windmill'); ?>" style="width: 100%; margin-top: 6px; margin-right: 30px;"><?php echo esc_html__('Upload Media','windmill'); ?></button>
					</div>
				</p>
				<?php
				break;

			/**
			 * @reference
			 * https://www.w3schools.com/TAGS/default.ASP
			*/
			default :
				break;
		}

	}// Method


	/**
		@since 1.0.1
			Sanitize field value.
		@access (private)
		@param (string) $key
			Field key.
		@param (array) $value
			Field.
		@param (mixed) $input
			Raw value.
		@return (mixed)
			Sanitized value.
	*/
	private function sanitize($key,$value,$input)
	{
		$type = 'text';

		if(isset($value['type'])){
			$type = esc_attr($value['type']);
		}

		if(!isset($value['default'])){
			$value['default'] = NULL;
		}

		$return = NULL;
		if(isset($value['sanitize_callback']) && is_callable($value['sanitize_callback'])){
			$return = call_user_func($value['sanitize_callback'],$key,$value,$input);
			return $return;
		}

		switch($type){
			case 'text' :
				/**
				 * @reference (WP)
				 * 	Sanitizes a string from user input or from the database.
				 * 	https://developer.wordpress.org/reference/functions/sanitize_text_field/
				*/
				$return = sanitize_text_field($input);
				break;

			case 'image' :
			case 'url' :
				/**
				 * @reference (WP)
				 * 	Performs esc_url() for database usage.
				 * 	https://developer.wordpress.org/reference/functions/esc_url_raw/
				*/
				$return = esc_url_raw($input);
				break;

			case 'email' :
				/**
				 * @reference (WP)
				 * 	Strips out all characters that are not allowable in an email.
				 * 	https://developer.wordpress.org/reference/functions/sanitize_email/
				*/
				$return = sanitize_email($input);
				break;

			case 'number' :
				/**
				 * @reference (WP)
				 * 	Convert a value to non-negative integer.
				 * 	https://developer.wordpress.org/reference/functions/absint/
				*/
				return absint($input);
				break;

			case 'textarea' :
				/**
				 * @reference (WP)
				 * 	Returns whether the current user has the specified capability.
				 * 	https://developer.wordpress.org/reference/functions/current_user_can/
				*/
				if(current_user_can('unfiltered_html')){
					$return = $input;
				}
				else{
					/**
					 * @reference (WP)
					 * 	Sanitizes content for allowed HTML tags for post content.
					 * 	https://developer.wordpress.org/reference/functions/wp_kses_post/
					*/
					$sanitized_value = wp_kses_post($input);

					/**
					 * @reference (WP)
					 * 	Balances tags if forced to, or if the ‘use_balanceTags’ option is set to true.
					 * 	https://developer.wordpress.org/reference/functions/balancetags/
					*/
					$return = balanceTags($sanitized_value,TRUE);
				}
				break;

			case 'select' :
			case 'radio' :
				$input = esc_attr($input);
				$choices = $value['option'];
				$return = array_key_exists($input,$choices) ? $input : $value['default'];
				break;

			case 'checkbox' :
				$return = !empty($input) ? $input : 0;
				break;

			default :
				$return = esc_attr($input);
				break;
		}
		return $return;

	}// Method


}// Class
endif;
