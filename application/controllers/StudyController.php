<?php

class StudyController extends Zend_Controller_Action
{
	public $userModel; 
	public $studyModel; 
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
        // action body
    }

    public function getTransectAction()
    {
        // action body
    }

    public function createAction()
    {
        $request = $this -> getRequest(); 
		if(! $request -> isPost() ) {
			//var_dump($this -> userModel -> _currentUser) ; 
			$this -> view -> createStudyForm = $this -> studyModel -> getCreateStudyForm($this -> userModel -> _currentUser -> island); 
			return $this -> render(); 	
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


}

















