<?php
class Zend_View_Helper_FormTime extends Zend_View_Helper_FormElement {
	public function formTime($name, $value = null, $attribs = null, $options = null ){
		$html =  '<input type="time" name="'.$name.'" id="'.$name.'" ';
		//var_dump($value, $name, $attribs, $options); 
		if ($value != null )
			$html .= ' value="'. $value .'" '; 
		$html .= '>' ; 
		return $html ;  
	}
}