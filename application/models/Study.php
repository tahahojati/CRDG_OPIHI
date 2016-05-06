<?php

class Application_Model_Study
{
	private static $_instance = null; 
	public $metaTable; 
	public $transectTable;
	public $quadrantTable;
	public $substrateTable; 
	public $organismTable; 
	public $locationTable; 
	public $stressTable; 
	
	public $forms = [] ; 

	public static function getInstance(){
		if(self ::$_instance === null){
			self:: $_instance = new self(); 
		}
		return self :: $_instance; 
	}
	private function __construct(){
		$this -> metaTable= new Application_Model_Resource_MetaTable(); 
		$this -> transectTable= new Application_Model_Resource_TransectTable();
		$this -> quadrantTable= new Application_Model_Resource_QuadrantTable();
		$this -> substrateTable= new Application_Model_Resource_SubstrateTable();
		$this -> organismTable= new Application_Model_Resource_OrganismTable();
		$this -> locationTable= new Application_Model_Resource_LocationTable();
		$this -> stressTable= new Application_Model_Resource_StressTable();
	}
	
	public function getCreateStudyForm($island){
		if(! isset($this -> forms['createStudy']))
			$this -> forms['createStudy'] = new Application_Form_CreateStudy(['studyModel' => $this, 'island' => $island] );	
		return $this -> forms['createStudy']; 
	}
	public function getLocations($island){
		$select = $this -> locationTable-> select(); 
		if($island != null ) 
			$select -> where('island = ?' , $island); 
		$res = $select -> query() -> fetchAll(); 
		return $res;
	}
	public function getEnumValues($col){
		$res = $this -> metaTable -> getAdapter() -> query('show columns from session_metadata like "'.$col.'"; ') -> fetchAll();
		$res = explode("'", $res[0]['Type'],2 );
		$res = $res[1]; 
		$res = explode("','", $res) ; 
		$res [count($res)-1] = (explode ("'" , $res[count($res) -1 ] ,2))[0]; 
		//$res [count($res) -1 ] = $res[count($res) -1] [0]; 
		return $res; 	
	}

}

