<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {	
		$auth = Zend_Auth::getInstance(); 
		$this -> view -> loggedInName = $auth -> hasIdentity()? $auth-> getIdentity() : null; 
    }

    public function indexAction()
    {

    }

    public function contactAction()
    {
        // action body
    }

    public function memberAction()
    {
        // action body
    }


}





