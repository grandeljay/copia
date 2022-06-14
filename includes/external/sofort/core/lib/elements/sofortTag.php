<?php
/**
 * Sofort Tag Element
 * 
 * @author SOFORT AG (integration@sofort.com)
 *
 * @copyright 2010-2014 SOFORT AG
 *
 * @license Released under the GNU LESSER GENERAL PUBLIC LICENSE (Version 3)
 * @license http://www.gnu.org/licenses/lgpl.html
 *
 * @version SofortLib 2.1.1
 *
 * @link http://www.sofort.com/ official website
 */

/**
 *
 * Implementation of a simple tag
 *
 */
class SofortTag extends SofortElement {
	
	public $tagname = '';
	
	public $attributes = array();
	
	public $children = array();


	/**
	 * Constructor for SofortTag
	 *
	 * @param string $tagname
	 * @param array $attributes (optional)
	 * @param array $children (optional)
	 * @return \SofortTag
	 */
	public function __construct($tagname, array $attributes = array(), $children = array()) {
		$this->tagname = $tagname;
		$this->attributes = $attributes;
		$this->children = is_array($children) ? $children : array($children);
	}
	
	
	/**
	 * Renders the element (override)
	 * 
	 * @see SofortElement::render()
	 * @return string
	 */
	public function render() {
		$output = '';
		$attributes = '';
		
		foreach ($this->children as $child) {
			$output .= is_object($child) ? $child->render() : $child;
		}
		
		foreach ($this->attributes as $key => $value) {
			$attributes .= " $key=\"$value\"";
		}
		
		return $this->_render($output, $attributes);
	}
	
	
	/**
	 * Render the output
	 * 
	 * @param string $output
	 * @param string $attributes
	 * @return string
	 */
	protected function _render($output, $attributes) {
		return $output !== ''
			? "<{$this->tagname}{$attributes}>{$output}</{$this->tagname}>"
			: "<{$this->tagname}{$attributes} />";
	}
}