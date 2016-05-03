<?php

class UserController extends Zend_Controller_Action
{
    public $model ;
    public function init()
    {
        /* Initialize action controller here */
        $this -> model = new Application_Model_User();
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
        // action body
    }

    public function logoutAction()
    {
        // action body
    }


}















