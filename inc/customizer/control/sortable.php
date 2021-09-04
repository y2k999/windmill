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
// if(class_exists('_customizer_control_sortable') === FALSE) :
if(!class_exists('_customizer_control_sortable')) :
class _customizer_control_sortable extends WP_Customize_Control
{
/**
 * [TOC]
 * 	__construct()
 * 	render_content()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $type
			WordPress theme customizer control type.
	*/
	public $type = 'windmill-multicheck-sortable';


	/* Method
	_________________________
	*/
	public function render_content()
	{
		/**
			@access (public)
				Render settings
			@return (void)
			@reference (WP)
				Customize Control class.
				https://developer.wordpress.org/reference/classes/wp_customize_control/
			@reference
				Sortable multi check boxes custom control.
				[Parent]/inc/customizer/setup.php
		*/

		// if no choices, bail.
		if(empty($this->choices)){return;}

		if(!empty($this->label)){
		?><span class="customize-control-title"><?php echo $this->label; ?></span><?php
		}

		if(!empty($this->description)){
		?><span class="description customize-control-description"><?php echo $this->description; ?></span><?php
		}

		// Data
		$values = explode(',',$this->value());
		$choices = $this->choices;

		// If values exist, use it.
		$options = array();

		if($values){
			// get individual item
			foreach($values as $value){
				// separate item with option
				$value = explode(':',$value);

				// build the array. remove options not listed on choices.
				if(array_key_exists($value[0],$choices)){
					$options[$value[0]] = $value[1] ? '1' : '0'; 
				}
			}
		}

		// if there's new options (not saved yet), add it in the end.
		foreach($choices as $key => $val){
			// if not exist, add it in the end.
			if(!array_key_exists($key,$options)){
				// use zero to deactivate as default for new items.
				$options[$key] = '0';
			}
		}
		?><ul class="windmill-multicheck-sortable-list"><?php
			foreach($options as $key => $value) :
				?><li>
					<label>
						<input name="<?php echo esc_attr($key); ?>" class="windmill-multicheck-sortable-item" type="checkbox" value="<?php echo esc_attr($value); ?>" <?php checked($value); ?> /> 
						<?php echo $choices[$key]; ?>
					</label>
					<i class="dashicons dashicons-menu windmill-multicheck-sortable-handle"></i>
				</li>
			<?php endforeach; ?>

			<li class="windmill-hideme">
				<input type="hidden" class="windmill-multicheck-sortable" <?php $this->link(); ?> value="<?php echo esc_attr($this->value()); ?>" />
			</li>
		</ul>

	<?php
	}// Method


}// Class
endif;
// new _customizer_control_sortable();
// _customizer_control_sortable::__get_instance();
