<?php
class Zend_View_Helper_FormDate extends Zend_View_Helper_FormElement {
	public function formDate($name, $value = null, $attribs = null, $options = null ){
		$html =  '<input type="date" name="'.$name.'" id="'.$name.'" ';
		//var_dump($value, $name, $attribs, $options); 
		if ($value != null )
			$html .= ' value="'. $value .'" '; 
		$html .= '>' ; 
		return $html ;  
	}
}