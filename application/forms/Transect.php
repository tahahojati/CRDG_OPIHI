<?php

class Application_Form_Transect extends Application_Form_Abstract {
	
	private $studyModel; 
	private $trData;
	//private $sessionId;
	public function init(){
		parent::init();
		$this -> studyModel = $this -> getAttrib('studyModel'); 
		$this -> trData = $this -> getAttrib('trData'); 
		//$this -> sessionId = $this -> getAttrib('sessionId'); 
		$this -> removeAttrib('studyModel'); 
		$this -> removeAttrib('trData'); 
		$orgList = $this -> studyModel->getOrganismById(); 
		$subList = $this -> studyModel -> getSubstrateById(); 
		//var_dump($orgList, $subList);
		//$this -> removeAttrib('sessionId'); 
		
		//$rows = $this -> studyModel -> getTransectDataByIdNum($this -> sessionId);
		$this -> setAction('/study/update-transect/'); 
		$this -> setMethod('post'); 
		//$this -> setElementsBelongTo('transect'); 
		$this -> setDecorators([
			'FormElements',
			['HtmlTag', ['tag' => 'table', 'class' => 'table table-striped' ]],
			'Form',
		]);
		$this -> setElementDecorators([
			'ViewHelper',
			'Errors',
			['HtmlTag',['tag' => 'td']],
			//[['data' => 'HtmlTag'], ['tag' => 'td']],
			['Label', ['tag' => 'td']],
			//[['row' => 'HtmlTag'], ['tag' => 'tr']],
		]);
		foreach($this -> trData as $key => $value){
			//var_dump($value); 	
			$element1 = $this -> createElement('select', 'o'.$value['transect_point'],[
				'label' => 'Transect point '.$value['transect_point'],
				'belongsTo' => 'transectOrganism',
			]);
			$element2 = $this -> createElement('select', 's'.$value['transect_point'], [
				'belongsTo' => 'transectSubstrate',
			]); 
			$element2 -> removeDecorator('label');
			//$element2 -> removeDecorator('row');
			//$element2 -> removeDecorator('data');
			
			//$element2 -> addDecorator('HtmlTag', ['tag' => 'td']); 
			//var_dump($element2 -> getDecorators()); 
			//add multioptions
			foreach($orgList as $organism ){
				$element1 -> addMultiOption($organism['id'], $organism['genus'].' '.$organism['species']);	
			}
			foreach($subList as $substrate){
				$element2 -> addMultiOption($substrate['id'], $substrate['substrate_name']);
			}
			
			if($value['substrate_id'] != null){
				$element2 -> setValue( $value['substrate_id']);
			}
			if($value['organism_id'] != null) {
				//var_dump($value['organism_id']); 
				//$org = $this -> studyModel -> getOrganismById($value['organism_id']);
				$element1 -> setValue(  $value['organism_id']);
			}
			$this -> addDisplayGroup([$element1, $element2], $value['transect_point']);
			$dgroup = $this -> getDisplayGroup($value['transect_point']);
			$dgroup -> removeDecorator('DtDdWrapper');
			$dgroup -> removeDecorator('Fieldset');
			$dgroup -> addDecorator('HtmlTag',['tag' => 'tr']); 
			var_dump($dgroup ->getDecorators() );
			
			//$this -> addElement($element2); 
		}
		
		$this -> addElement('submit', 'update' ,[
			'label' => 'Update transect',
			'belongsTo' => null,
			'decorators' => ['ViewHelper', [['data' => 'HtmlTag'] ,['tag'=> 'td' , 'colspan' => 3]]],
		]) ;
	}
}
