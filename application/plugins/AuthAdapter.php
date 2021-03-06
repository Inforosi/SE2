<?php
/**
 * Authentication Adapter authenticate a user
 * check if user is logged in
 * 
 * @author Andreas Ressmann
 * 22.01.2014
 */
class Core_Plugin_AuthAdapter {
	
	private $session;
	
	/**
	 * initializing the Adapter
	 */
	public function __construct() 
	{
		$this->session = new Zend_Session_Namespace("Core");
	}
	
	/**
	 * authenticate the user by the given identifier and password
	 * 
	 * @return true or false
	 */
	public function authenticate($auth, $credentials) 
	{
		$passwdToCompare = md5($credentials['password']);
		
		if($auth->getPassword() === $passwdToCompare) { 
			$this->session->auth = $auth;
			$this->session->auth_role = $auth->getRoleId();
			return true;
		} else {
			$this->session->auth_role = Core_Plugin_Acl::ROLE_GUEST;
			return false;
		}
	}

	/**
	 * check if the current authenticationrole not is guest
	 */
    public function isLoggedIn()
    {
        return $this->session->auth_role !== Core_Plugin_Acl::ROLE_GUEST;
    }
    
	/**
	 * check if the current authentication is admin
	 */
    public function isAdmin()
    {
    	return $this->session->auth_role === Core_Plugin_Acl::ROLE_ADMIN;
    }
}