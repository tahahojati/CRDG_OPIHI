<?php
class Zend_View_Helper_FormNumber extends Zend_View_Helper_FormElement {
	public function formNumber($name, $value = null, $attribs = null, $options = null ){
		$html =  '<input type="number" name="'.$name.'" id="'.$name.'" ';
		//var_dump($value, $name, $attribs, $options); 
		if ($value != null )
			$html .= ' value="'. $value .'" '; 
		$html .= '>' ; 
		return $html ;  
	}
}