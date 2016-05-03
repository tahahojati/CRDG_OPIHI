<?php

class UserController extends Zend_Controller_Action
{
    public $model ;
	public $authService; 
	public $loginForm; 
    public function init()
    {
        /* Initialize action controller here */
        $this -> model = new Application_Model_User();
		$this -> authService = new Application_Service_Auth(); 
		$this -> loginForm = $this -> model -> getLoginForm(); 
		$this -> view -> loginForm = $this -> loginForm;
    }

    public function indexAction()
    {
        // action body
    }

    public function getAction()
    {
        // action body
    }

    public function updateAction()
    {
        // action body
    }

    public function registerAction()
    {
        $this -> view -> navActive = 4;
        $post = $this -> getRequest() -> getPost() ;
        //var_dump($post);
        $rform = $this->model->getRegistrationForm();
        $this->view->registerForm = $rform;
            //var_dump($rform -> getDecorators());
        if(empty($post)) {
            return;
        }
         if($this -> model -> registerUser($post) === false){
            $this->render();
         }
         $rform -> setDefaults($post);

    }

    public function deleteAction()
    {
        // action body
    }

    public function loginAction()
    {
        // action body
    }

    public function authenticateAction()
    {
	$request = $this -> getRequest(); 
		if(! $request -> isPost())
			return $this -> _helper->redirector('login'); 
		$post = $request -> getPost(); 
		$form = $this -> loginForm;  
		if(! $form -> isValid($post) ){
			return $this -> render('login'); 	
		}
		if (false === $this -> authService -> authenticate( $form -> getValues() )){
			$form -> setDescription('Login failed.  Please try again.'); 
			return $this -> render('login'); 
		}
		return $this -> _helper -> redirector -> gotoSimple('index', 'index'); 
	}

    public function logoutAction()
    {
		$this -> authService -> logOut(); 
		return $this -> _helper ->redirector -> gotoSimple('index' ,'index'); 
    }


}















