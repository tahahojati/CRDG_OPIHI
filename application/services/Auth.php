<?php

class Application_Service_Auth {
	protected $_authadapter;
	protected $_userModel ;
	protected $_auth; 
	
	public function __construct(){
		$this -> _auth = Zend_Auth :: getInstance(); 
		$this -> _userModel = new Application_Model_User(); 
		$this -> _authadapter = new Zend_Auth_Adapter_DbTable(
			Zend_Db_Table_Abstract::getDefaultAdapter(),
			'user',
			'email',
			'password',
			'SHA1(CONCAT(salt,?))'
		);
	}
	public function logOut(){
		$this -> _auth -> clearIdentity(); 	
	}
	
	public function authenticate($credentials){
				var_dump("inside authenticate"); 

		$this -> _authadapter -> setIdentity($credentials['email']) ; 
		$this -> _authadapter -> setCredential($credentials['password']); 
		$result = $this -> _auth -> authenticate ($this -> _authadapter) ; 
		if(! $result -> isValid()){
					var_dump("result aint valid"); 

			return false ;
		}
		$user = $this -> _userModel -> getUserByEmail($credentials['email'] ) ; 
		$this -> _auth -> getStorage() -> write(['email' => $user['email'], 'fname' => $user['first_name'], 'lname' => $user['last_name'] ]); 
		return true;
	}
	
}