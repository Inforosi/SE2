<?php
/**
 * Redirection Controller for the Login
 *
 * @author Andreas Ressmann
 * 23.01.2014
 */
class LoginController extends Core_AbstractController {
	
	/**
	 * initialisation of the controller
	 */
	public function init() {
		parent::init();		
	}

	/**
	 * redirecting to the index controller after authentication 
	 */
	public function indexAction() {
		$this->_redirect('/index');
		
	}
    
    
}