<?php

class Application_Model_User
{
	private static $_instance = null; 
    public $table;
    /**
     * @return Application_Form_Register
     */
    public $forms =[];
	public $_currentUser; 
	public $_auth;
	
	public static function getInstance(){
		if(self :: $_instance ===null){
			self :: $_instance = new self(); 
		}
		return self::$_instance; 
	}
    private function __construct()
    {
        $this -> table = new Application_Model_Resource_User();
		$this -> _auth = Zend_Auth::getInstance();
		$this -> _currentUser = null ; 
		if( $this -> _auth -> hasIdentity()){
			$this -> _currentUser = $this -> _auth->getIdentity();
			$this -> _currentUser = $this -> table -> find($this -> _currentUser['id']) -> current(); 	
		}
    }

    public function getRegistrationForm(){
        if(!isset($this -> forms['registration']))
            $this -> forms['registration'] = new Application_Form_Register();
        return $this -> forms['registration'];
    }
    public function getLoginForm(){
		if(!isset($this -> forms['login']))
			$this -> forms['login'] = new Application_Form_Login(); 
		return $this -> forms['login']; 	
	}
    public function registerUser( $post ){
        $rform = $this -> getRegistrationForm();
        $rform -> populate($post);
        if(!$rform -> isValid($post))
            return false;
        else {
            $fname = $post['fname'];
            $lname = $post ['lname'];
            $school = $post['schoolname'];
			$schooladd = $post['schooladdress']; 
			$island = $post['island'] ; 
            $email = $post['email'];
            $password = $post ['password'];
			$salt = $this -> createSalt(); 
			$password = sha1($salt.$password); 

            $this -> table -> insert([
                'first_name' => $fname,
                'last_name' => $lname,
                'email' => $email,
                'school_name' => $school,
				'school_address' => $schooladd,
                'password' => $password,
                'salt' => $salt

            ]);
            return true; 

        }
    }
	
	public function getUserByEmail($email){
			$select = $this -> table -> select(); 
			$select -> where('email = ?',$email); 
			$res = $select -> query()->fetch();  
			if($res === false){
				return null ; 
			}
			else return $res;  
	}
	private function createSalt(){
		$salt = '';
        for ($i = 0; $i < 32; $i++) {
            $salt .= chr(rand(33, 126));
        }
        return $salt;
	}
	

}

