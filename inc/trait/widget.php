<?php
/**
 * Shared traits.
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
if(trait_exists('_trait_widget') === FALSE) :
trait _trait_widget{
/**
 * [TOC]
 * 	form()
 * 	update()
 * 	build()
 * 	sanitize()
*/


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

		// Loop through fields
		foreach((array)$this->field as $widget_field){
			// Make array elements available as variables
			extract($widget_field);
			$widget_field_value = !empty($instance[$needle]) ? wp_kses_post($instance[$needle]) : '';
			$this->build($this,$widget_field,$widget_field_value);
		}// endforeach

	}// Method


	/* Method
	_________________________
	*/
	public function update($new_instance,$old_instance)
	{
		/**
			@access (public)
				Updates a particular instance of a widget.
			@param (array) $new_instance
				New settings for this instance.
			@param (array) $old_instance
				Old settings for this instance.
			@return (array)
				Settings to save or bool false to cancel saving.
			@link https://themeegg.com/themes/eggnews/
		*/
		$instance = $old_instance;

		// Loop through fields
		foreach((array)$this->field as $widget_field){
			extract($widget_field);
			/**
				@link https://increment-log.com/widget-create-summary/
					Use helper function to get updated field values
			*/
			$instance[$needle] = $this->sanitize($widget_field,$new_instance[$needle]);
		}// endforeach

		// array Updated safe values to be saved.
		return $instance;

	}// Method


	/* Method
	_________________________
	*/
	public function build($instance = '',$widget_field = '',$widget_field_value = '')
	{
		/**
			@access (public)
			@param (array) $instance
			@param (string) $widget_field
			@param (mixed) $widget_value
			@return (void)
		*/
		extract($widget_field);

		switch($type){
			/**
			 * @reference
			 * 	 - name： It allows the server to access each button's value when submitted.
			 * 	 - value： The value sent to the server when submitting the form.
			 * 	The name value must be unique within the context of a <form> container.
			 * 	https://www.w3schools.com/TAGS/default.ASP
			*/
			case 'text' :
				if(empty($widget_field_value)){
					$widget_field_value = isset($default) ? $default : '';
				}
				?>
				<p>
					<label for="<?php echo esc_attr($instance->get_field_id($needle)); ?>"><?php echo esc_html($label); ?> :</label>
					<input type="text" name="<?php echo esc_attr($instance->get_field_name($needle)); ?>" id="<?php echo esc_attr($instance->get_field_id($needle)); ?>" class="widefat" value="<?php echo esc_attr($widget_field_value); ?>" />
					<?php if(isset($label)) : ?>
						<br/>
						<small><?php echo esc_html($label); ?></small>
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
			case 'email' :
			case 'url' :
				if(empty($widget_field_value)){
					$widget_field_value = isset($default) ? $default : '';
				}
				?>
				<p>
					<label for="<?php echo esc_attr($instance->get_field_id($needle)); ?>"><?php echo esc_html($label); ?> :</label>
					<input type="text" name="<?php echo esc_attr($instance->get_field_name($needle)); ?>" id="<?php echo esc_attr($instance->get_field_id($needle)); ?>" class="widefat" value="<?php echo esc_attr($widget_field_value); ?>" />
					<?php if(isset($label)){ ?>
						<br/>
						<small><?php echo esc_html($label); ?></small>
					<?php } ?>
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
				if(empty($widget_field_value)){
					$widget_field_value = isset($default) ? $default : '';
				}
				?>
				<p>
					<label for="<?php echo esc_attr($instance->get_field_id($needle)); ?>"><?php echo esc_html($label); ?> :</label>
					<textarea name="<?php echo esc_attr($instance->get_field_name($needle)); ?>" id="<?php echo esc_attr($instance->get_field_id($needle)); ?>" class="widefat" rows="5"><?php echo esc_html($widget_field_value); ?></textarea>
					<?php if(isset($label)){ ?>
						<br/>
						<small><?php echo esc_html($label); ?></small>
					<?php } ?>
				</p>
				<?php 
				break;

			/**
			 * @reference
			 * 	https://www.w3schools.com/TAGS/default.ASP
			*/
			case 'number' :
				if(empty($widget_field_value)){
					$widget_field_value = isset($default) ? $default : 3;
				}
				?>
				<p>
					<label for="<?php echo esc_attr($instance->get_field_id($needle)); ?>"><?php echo esc_html($label); ?> :</label>
					<br/>
					<input name="<?php echo esc_attr($instance->get_field_name($needle)); ?>" type="number" step="1" min="1" id="<?php echo esc_attr($instance->get_field_id($type)); ?>" value="<?php echo esc_attr($widget_field_value); ?>" />
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
					<input type="checkbox" name="<?php echo esc_attr($instance->get_field_name($needle)); ?>" id="<?php echo esc_attr($instance->get_field_id($needle)); ?>" value="1" <?php checked('1',$widget_field_value); ?> />
					<label for="<?php echo esc_attr($instance->get_field_id($needle)); ?>"><?php echo esc_html($label); ?></label>
					<?php if(isset($label)){ ?>
						<br/>
						<small><?php echo esc_html($label); ?></small>
					<?php } ?>
				</p>
				<?php 
				break;

			/**
			 * @reference
			 * 	https://www.w3schools.com/TAGS/default.ASP
			*/
			case 'radio' :
				if(empty($widget_field_value)){
					$widget_field_value = $default;
				}
				?>
				<p>
					<label for="<?php echo esc_attr($instance->get_field_id($needle)); ?>"><?php echo esc_html($label); ?> :</label>
					<div class="radio-wrapper">
						<?php
						foreach($option as $_key => $_value){
							if(!$_key){continue;}
							?>
							<input type= "radio" name="<?php echo esc_attr($instance->get_field_name($needle)); ?>" id="<?php echo esc_attr($instance->get_field_id($_key)); ?>" value="<?php echo esc_attr($_key); ?>" <?php checked($_key,$widget_field_value); ?> />
							<label for="<?php echo esc_attr($instance->get_field_id($_key)); ?>"><?php echo esc_html($_value); ?> :</label>
						<?php } ?>
					</div>
				</p>
				<?php
				break;

			/**
			 * @reference
			 * 	https://www.w3schools.com/TAGS/default.ASP
			*/
			case 'select' :
				if(empty($widget_field_value)){
					$widget_field_value = $default;
				}
				?>
				<p>
					<label for="<?php echo esc_attr($instance->get_field_id($needle)); ?>"><?php echo esc_html($label); ?> :</label>
					<select name="<?php echo esc_attr($instance->get_field_name($needle)); ?>" id="<?php echo esc_attr($instance->get_field_id($needle)); ?>" class="widefat">
						<?php if(!empty($option)) : ?>
							<?php foreach($option as $option_key => $option_value) : ?>
									<option value="<?php echo esc_attr($option_key); ?>" <?php selected($option_key,$widget_field_value); ?>><?php echo esc_html($option_value); ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
					<?php if(isset($label)) : ?>
						<br/>
						<small><?php echo esc_html($label); ?></small>
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
					<label for="<?php echo $instance->get_field_id($needle); ?>"> <?php echo esc_html($label); ?> </label>
					<br />
					<div class="media-uploader" id="<?php echo $instance->get_field_id($needle); ?>">
						<div class="custom_media_preview">
							<?php if($widget_field_value != '') : ?>
								<img class="custom_media_preview_default" src="<?php echo esc_url($widget_field_value); ?>" style="max-width: 100%;" />
							<?php endif; ?>
						</div>

						<input type="text" class="widefat custom_media_input" id="<?php echo $instance->get_field_id($needle); ?>" name="<?php echo $instance->get_field_name($needle); ?>" value="<?php echo esc_url($widget_field_value); ?>" style="margin-top:5px;" />

						<button class="custom_media_upload button button-secondary button-large" id="<?php echo $instance->get_field_id($needle); ?>" data-choose="<?php echo esc_attr__('Choose Media','windmill'); ?>" data-update="<?php echo esc_attr__('Update Media','windmill'); ?>" style="width: 100%; margin-top: 6px; margin-right: 30px;"><?php echo esc_html__('Upload Media','windmill'); ?></button>

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

		}// endswitch;

	}// Method


	/* Method
	_________________________
	*/
	public function sanitize($widget_field,$new_field_value)
	{
		/**
			@access (public)
			@param(array) $widget_field
			@param(array) $new_field_value
			@return (void)
		*/
		$type = '';

		extract($widget_field);

		switch($type){
			// Allow only integers in number fields
			case 'number' :
			case 'integer' :
				return absint($new_field_value);
				break;
			case 'email' :
				return sanitize_email($new_field_value);
				break;
			case 'text' :
			case 'textarea' :
			case 'checkbox' :
			case 'select' :
			case 'radio' :
				return sanitize_text_field($new_field_value);
				break;
			case 'url' :
			case 'image' :
				return esc_url_raw($new_field_value);
				break;
			default :
				return wp_kses_post(sanitize_text_field($new_field_value));
				break;
		}// endswitch

	}// Method


}// Trait
endif;
