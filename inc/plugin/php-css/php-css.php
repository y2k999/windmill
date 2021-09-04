<?php
/**
	Creates minified css via PHP.
	@author Carlos Rios
	@package PHP_CSS
	@version 1.1
*/
// namespace CarlosRios;

class PHP_CSS
{
	/**
		@access (protected)
			The css selector that you're currently adding rules to
		@var (string)
	*/
	protected $_selector = '';

	/**
		@access (protected)
			Stores the final css output with all of its rules for the current selector.
		@var (string)
	 */
	protected $_selector_output = '';

	/**
		@access (protected)
			Can store a list of additional selector states which can be added and removed.
		@var (array)
	*/
	protected $_selector_states = array();

	/**
		@access (private)
			Stores a list of css properties that require more formating
		@var (array)
	*/
	private $_special_properties_list = array(
		'border-radius',
		'border-top-left-radius',
		'border-top-right-radius',
		'border-bottom-left-radius',
		'border-bottom-right-radius',
		'box-shadow',
		'transition',
		'transition-delay',
		'transition-duration',
		'transition-property',
		'transition-timing-function',
		'background-image',
	);

	/**
		@access (protected)
			Stores all of the rules that will be added to the selector
		@var (string)
	*/
	protected $_css = '';

	/**
		@access (protected)
			The string that holds all of the css to output
		@var (string)
	*/
	protected $_output = '';

	/**
		@access (protected)
			Stores media queries
		@var (null)
	*/
	protected $_media_query = NULL;

	/**
		@access (protected)
			The string that holds all of the css to output inside of the media query
		@var (string)
	*/
	protected $_media_query_output = '';


	/**
		@access (public)
			Sets a selector to the object and changes the current selector to a new one
		@param (string) $selector
			The css identifier of the html that you wish to target
		@return $this
	*/
	public function set_selector($selector = '')
	{
		// Render the css in the output string everytime the selector changes
		if($this->_selector !== ''){
			$this->add_selector_rules_to_output();
		}
		$this->_selector = $selector;
		return $this;
	}

	/**
		@access (public)
			Wrapper for the set_selector method, changes the selector to add new rules
		@see set_selector()
		@param (string) $selector
		@return $this
	*/
	public function change_selector($selector = '')
	{
		return $this->set_selector($selector);
	}

	/**
		@access (public)
			Adds a pseudo class to the selector ex. :hover, :active, :focus
		@param $state
			The selector state
		@param $reset
			If true the $_selector_states variable will be reset
		@return $this
	 */
	public function add_selector_state($state,$reset = true)
	{
		if($reset){
			$this->reset_selector_states();
		}
		$this->_selector_states[] = $state;
		return $this;
	}

	/**
		@access (public)
			Adds multiple pseudo classes to the selector
		@param  (array) $states
			The states you would like to add
		@return $this
	*/
	public function add_selector_states( $states = array() )
	{
		$this->reset_selector_states();
		foreach( $states as $state )
		{
			$this->add_selector_state( $state, false );
		}
		return $this;
	}

	/**
		@access (public)
			Removes the selector's pseudo classes
		@return $this
	*/
	public function reset_selector_states()
	{
		$this->add_selector_rules_to_output();
		if( !empty( $this->_selector_states ) ){
			$this->_selector_states = array();
		}
		return $this;
	}

	/**
		@access (public)
			Adds a new rule to the css output
		@param (string) $property
			The css property
		@param (string) $value
			The value to be placed with the property
		@param (string) $prefix
			Not required, but allows for the creation of a browser prefixed property
		@return $this
	*/
	public function add_rule( $property, $value, $prefix = null )
	{
		$format = is_null( $prefix ) ? '%1$s:%2$s;' : '%3$s%1$s:%2$s;';
		$this->_css .= sprintf( $format, $property, $value, $prefix );
		return $this;
	}

	/**
		@access (public)
			Adds browser prefixed rules, and other special rules to the css output
		@param  (string) $property
			The css property
		@param  (string) $value
			The value to be placed with the property
		@return $this
	*/
	public function add_special_rules( $property, $value )
	{
		// Switch through the property types and add prefixed rules
		switch ( $property ) {
			case 'border-top-left-radius':
				$this->add_rule( $property, $value );
				$this->add_rule( $property, $value, '-webkit-' );
				$this->add_rule( 'border-radius-topleft', $value, '-moz-' );
			break;
			case 'border-top-right-radius':
				$this->add_rule( $property, $value );
				$this->add_rule( $property, $value, '-webkit-' );
				$this->add_rule( 'border-radius-topright', $value, '-moz-' );
			break;
			case 'border-bottom-left-radius':
				$this->add_rule( $property, $value );
				$this->add_rule( $property, $value, '-webkit-' );
				$this->add_rule( 'border-radius-bottomleft', $value, '-moz-' );
			break;
			case 'border-bottom-right-radius':
				$this->add_rule( $property, $value );
				$this->add_rule( $property, $value, '-webkit-' );
				$this->add_rule( 'border-radius-bottomright', $value, '-moz-' );
			break;
			case 'background-image':
				$this->add_rule( $property, sprintf( "url('%s')", $value ) );
			break;
			default:
				$this->add_rule( $property, $value );
				$this->add_rule( $property, $value, '-webkit-' );
				$this->add_rule( $property, $value, '-moz-' );
			break;
		}

		return $this;
	}

	/**
		@access (public)
			Adds a css property with value to the css output
		@param (string) $property
			The css property
		@param (string) $value
			The value to be placed with the property
		@return $this
	*/
	public function add_property( $property, $value )
	{
		if( in_array( $property, $this->_special_properties_list ) ) {
			$this->add_special_rules( $property, $value );
		} else {
			$this->add_rule( $property, $value );
		}
		return $this;
	}

	/**
		@access (public)
			Adds multiple properties with their values to the css output
		@param (array) $properties
			A list of properties and values
		@return $this
	*/
	public function add_properties( $properties )
	{
		foreach( (array) $properties as $property => $value )
		{
			$this->add_property( $property, $value );
		}
		return $this;
	}

	/**
		@access (public)
			Sets a media query in the class
		@since 1.1
		@param (string) $value
		@return $this
	*/
	public function start_media_query( $value )
	{
		// Add the current rules to the output
		$this->add_selector_rules_to_output();

		// Add any previous media queries to the output
		if( $this->has_media_query() ) {
			$this->add_media_query_rules_to_output();
		}

		// Set the new media query
		$this->_media_query = $value;
		return $this;
	}

	/**
		@access (public)
			Stops using a media query.
		@see start_media_query()
		@since 1.1
		@return $this
	 */
	public function stop_media_query()
	{
		return $this->start_media_query( null );
	}

	/**
		@access (public)
			Gets the media query if it exists in the class
		@since 1.1
		@return (string)|(int)|(null)
	 */
	public function get_media_query()
	{
		return $this->_media_query;
	}

	/**
		@access (public)
			Checks if there is a media query present in the class
		@since 1.1
		@return (boolean)
	*/
	public function has_media_query()
	{
		if( ! empty( $this->get_media_query() ) ) {
			return true;
		}

		return false;
	}

	/**
		@access (private)
			Adds the current media query's rules to the class' output variable
		@since 1.1
		@return $this
	 */
	private function add_media_query_rules_to_output()
	{
		if( !empty( $this->_media_query_output ) ) {
			$this->_output .= sprintf( '@media all and %1$s{%2$s}', $this->get_media_query(), $this->_media_query_output );

			// Reset the media query output string
			$this->_media_query_output = '';
		}

		return $this;
	}

	/**
		@access (private)
			Adds the current selector rules to the output variable
		@return $this
	*/
	private function add_selector_rules_to_output()
	{
		if( !empty( $this->_css ) ) {
			$this->prepare_selector_output();
			$selector_output = sprintf( '%1$s{%2$s}', $this->_selector_output, $this->_css );
			
			if( $this->has_media_query() ) {
				$this->_media_query_output .= $selector_output;
				$this->reset_css();
			} else {
				$this->_output .= $selector_output;
			}

			// Reset the css
			$this->reset_css();
		}

		return $this;
	}

	/**
		@access (private)
			Prepares the $_selector_output variable for rendering
		@return $this
	*/
	private function prepare_selector_output()
	{
		if( ! empty( $this->_selector_states ) ) {
			// Create a new variable to store all of the states
			$new_selector = '';

			foreach( (array) $this->_selector_states as $state ){
				$format = end($this->_selector_states) === $state ? '%1$s%2$s' : '%1$s%2$s,';
				$new_selector .= sprintf( $format, $this->_selector, $state );
			}
			$this->_selector_output = $new_selector;
		}else{
			$this->_selector_output = $this->_selector;
		}
		return $this;
	}

	/**
		@access (private)
			Resets the css variable
		@since 1.1
		@return (void)
	 */
	private function reset_css()
	{
		$this->_css = '';
		return;
	}

	/**
		@access (public)
			Returns the minified css in the $_output variable
		@return (string)
	 */
	public function css_output()
	{
		// Add current selector's rules to output
		$this->add_selector_rules_to_output();

		// Output minified css
		return $this->_output;
	}

}
