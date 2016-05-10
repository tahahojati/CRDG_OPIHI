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
	public function getTransectForm($session_id = null, $transect_num = null){
		if($session_id == null || $transect_num == null){
			if(isset($this -> forms['transect']))
				return $this -> forms['transect']; 
			else throw new Zend_Exception ("You must supply the session_id and transect_num"); 
		}
		$select = $this -> transectTable -> select();
		$select -> where('session_id = ?', $session_id) -> where('transect_num = ?', $transect_num); 
		$res= $select -> query() -> fetchAll(); 
		return $res; 
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
	public function createStudy($post) {
		$data = $post ;
		$umodel = Application_Model_User::getInstance()-> _currentUser; 
		$data ['user_id'] = $umodel -> id ;
		unset($data['submit']); 
		$sessionId = $this -> transectTable -> getAdapter() -> fetchAll('select * from random_id order by id limit 1;')[0]['random']; 
		$this -> transectTable -> getAdapter() -> delete('random_id', 'random = '.$sessionId ); 	
		$data['id'] = $sessionId; 
		var_dump($data); 
		$this -> metaTable -> insert($data);
		//var_dump($res); 
		$numTransects =(int) $data['num_transect_lines'];
		$numTransectPoints = $data['length_transect_lines'];
		//gotta calculate the number from point spacing
		$pointSpacingArray= ['1/4 meter' => 0.25, '1/2 meter' => 0.5, '3/4 meter' => 0.75, '1 meter' => 1] ; 
		if(! isset($pointSpacingArray[$data['point_spacing']])) {
			throw new Zend_Exception("the point spacing is not valid") ;
		}
		$numTransectPoints /= $pointSpacingArray[$data['point_spacing']]; 
		var_dump($numTransectPoints); 
		
		$numQuadrants = (int) $data['num_quadrants_per_transect'];
		//now create the rows in transect and quadrant tables. 	
		//var_dump($randomIds); 
		for($i = 0 ; $i < $numTransects; ++$i) {
			for($j = 0; $j < $numTransectPoints; ++$j){
				$data=[
					'session_id' => $sessionId,
					'transect_num' => $i +1,
					'transect_point' => $j +1,
				];
				$this -> transectTable -> insert($data); 
			}
		}
		
	}
	public function getStudy($id = null){
	//if id == unll return all study names and ids; 
		if($id == null){ 
			return $this -> metaTable -> fetchAll(); 
		}
		else {
			return $this -> metaTable -> find($id)[0];	
		}
	}
	public function getLocationById($id){
		return $this -> locationTable -> find($id)[0]['location_name'];	
	}
	public function getTransectsBySessionId($sessionId){
		$select = $this -> metaTable -> select();
		$select -> where('session_id = ?',$sessionId); 
		$res = $select -> query() -> fetchAll() -> toArray(); 
		return $res; 
	}
}

