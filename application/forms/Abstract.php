<?php

class Application_Form_Abstract extends Zend_Form{
	protected $_label_col_xs = 'col-xs-4', $_label_col_sm = 'col-sm-3', $_element_col_xs= 'col-xs-8', $_element_col_sm='col-sm-4'; 
	public function addADescription($name, $description){
		$this -> addElement('text', $name, ['validators' => [], 'filters'=>[], 'helper'=>'formNote', 'value' => '<p class="help-block">'.$description.'</p>', 'decorators'=> ['ViewHelper']]); 
		//$e -> setDecorators(['ViewHelper']);
		
	}
	
	//Use this method so the form-control class gets added to the element
	public function addElementWithClass($element){
		if(! $element instanceof Zend_Form_Element)
			throw new Zend_Exception("Pass a Zend_Element to this method"); 
		$element -> class =$element -> class .  ' form-control';
		$this -> addElement($element); 
	}
	
	public function init(){
		$this -> loadDefaultDecorators();
		$this -> setDecorators([
		'FormElements',
		//['DtDdWrapper' ,['tag' => 'div', 'class' =>'form-group']],
		['Form',['class' => 'form-horizontal']]
		]);
		$this -> setElementDecorators([
			'ViewHelper',
			'Errors',
			[['first' => 'HtmlTag'], ['class' => $this -> _element_col_xs.' '.$this->_element_col_sm]],
			['Label', ['class' => 'control-label '. $this -> _label_col_xs.' '.$this->_label_col_sm]],
			[['second' => 'HtmlTag'],['class' => 'form-group']],
		
		]);
		$e = $this -> createElement('text','text', ['label' => 'text' ]);
	}
}