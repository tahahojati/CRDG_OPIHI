<?php

class StudyController extends Zend_Controller_Action
{

    public $userModel = null;

    public $studyModel = null;

    public function init()
    {
        /* Initialize action controller here */
		$this -> userModel =  Application_Model_User::getInstance(); 
		$this -> studyModel = Application_Model_Study::getInstance(); 
    }

    public function indexAction()
    {
        // action body
    }

    public function getSummaryAction()
    {
        // action body
    }

    public function getAction()
    {
        $request = $this -> getRequest();
		$session_id = $request->getParam('id');
		if($session_id == null ) {
			$studies = $this -> studyModel -> getStudy()->toArray(); 
			var_dump($request, $studies); 
			$studyLinks = []; 
			foreach($studies as $study){
				$mylink=[];
				$mylink['location'] = $this -> studyModel -> getLocationById($study['location_id']); 
				$mylink['date'] = $study['date'];
				$mylink['id'] = $study['id'];
				$studyLinks[] = $mylink; 
			}
			$this -> view -> studyLinks = $studyLinks; 
			$this -> render();
		}
		else {
			$study = $this -> studyModel -> getStudy($session_id); 	
			$transectLinks = [];
			//$transects = $this -> studyModel -> getTransectsBySessionId($session_id);
			for($i =0 ; $i< $study['num_transect_lines']; ++$i){
				$link = []; 
				$link['transect_num'] = $i +1;
				$link['session_id'] = $session_id;
				$link['location'] = $this -> studyModel -> getLocationById($study['location_id']); 
				$link ['date'] = $study['date'];
				$transectLinks[] = $link; 
			}
			$this -> view -> transectLinks = $transectLinks; 
			var_dump($this -> view -> transectLinks); 
			return $this->render();
		}
		
    }

    public function getTransectAction()
    {
        $request = $this -> getRequest();
		$transectForm = $this -> studyModel -> getTransectForm($request -> getParam('session_id'),
															 $request-> getParam('transect_num')
															 ); 
	    $this-> view -> transectForm = $transectForm; 
		return $this -> render(); 
			
    }

    public function createAction()
    {
        $request = $this -> getRequest(); 
		if(! $request -> isPost() ) {
			//var_dump($this -> userModel -> _currentUser) ; 
			$this -> view -> createStudyForm = $this -> studyModel -> getCreateStudyForm($this -> userModel -> _currentUser -> island); 
			return $this -> render(); 	
		}
		else {
			$form = $this -> studyModel -> getCreateStudyForm($this -> userModel -> _currentUser -> island); 
			$post = $request -> getPost();
			if( ! $form -> isValid ($post)){	
				$this -> view -> createStudyForm = $form; 
				return $this -> render(); 
			}
			else {
				//create appropriate transect forms and share the links. 
				$links = $this -> studyModel -> createStudy($post); 	
				$this -> view -> reportLinks = $links; 
			}
		}
    }

    public function deleteAction()
    {
        // action body
    }

    public function updateAction()
    {
        // action body
    }

    public function analyzeAction()
    {
        // action body
    }

    public function downloadAction()
    {
        // action body
    }

    public function updateTransectAction()
    {
		$transect = [];
       $transect[] =  'homo sapian' ;
       $transect[] =  'rock' ;
       $transect[] =  '3rd species' ;
       $transect[] =  'rock' ;
       $transect[] =  'worm hole' ;
       $transect[] =  '3rd species' ;
	   var_dump($this -> getRequest() -> getPost()); 
    }


}



















