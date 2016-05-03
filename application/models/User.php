<?php

class Application_Model_User
{
    public $table;
    /**
     * @return Application_Form_Register
     */
    public $forms =[];
    public function __construct()
    {
        $this -> table = new Application_Model_Resource_User();
    }

    public function getRegistrationForm(){
        if(!isset($this -> forms['registration']))
            $this -> forms['registration'] = new Application_Form_Register();
        return $this -> forms['registration'];
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

