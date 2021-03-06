<?php
/**
 * User entity is Auth
 * represents a User with his attributes
 *
 * @author Andreas Ressmann
 * 23.01.2014
 */
class Core_Model_User extends Core_Model_Auth {
	

	/* [PROPERTIES] */
    protected $address;
    protected $firstname;
    protected $lastname;
    protected $telnr;
    
    /* [CONSTRUCT] */
    /**
	 * initializing the parent
	 */
	public function __construct() {
		parent::init();
	}
	/**
	 * getting the database tablename
	 * 
	 * @return database tablename
	 */
	public function getTableName () {
		return 'auth_user';
	}
	/**
	 * getting the class variables of the current class
	 * 
	 * @return class properties
	 */
	public function getProperties () {
		return get_class_vars('Core_Model_User');
	}
	
	/* [GETTERS/SETTERS] */
	/**
	 * @return address
	 */
    public function getAddress() {
    	return $this->address;
    }
    
	/**
	 * setting the address
	 */
    public function setAddress($address) {
		$this->address = $address;    	
    }
    
	/**
	 * @return firstname
	 */
	public function getFirstName() {
    	return $this->firstname;
    }
    
	/**
	 * setting the firstname
	 */
    public function setFirstName ($firstName) {
    	$this->firstname = $firstName;
    }
    
	/**
	 * @return lastname
	 */
	public function getLastName() {
    	return $this->lastname;
    }
    
	/**
	 * setting the lastname
	 */
    public function setLastName($lastName) {
    	$this->lastname = $lastName;
    }
	
	/**
	 * @return telnr
	 */
    public function getTelNr () {
        return $this->telnr;
    }

	/**
	 * setting the telnr
	 */    
    public function setTelNr ($telnr) {
        $this->telnr = $telnr;
    }
    /**
	 * getting attributes of this class as array
	 *
	 * @return array with attributes
	 */
    public function getData () {
        return array_merge($this->toArray (), $this->getParent ()->getData());
    }
    
    /* [TRANSFORMERS] */
    /**
	 * transform object to array
	 * 
	 * @return array of attributes
	 */
	public function toArray() {
		
		$data = array(
			'id'					=> $this->id,
            'firstname'	    		=> $this->firstname,
			'lastname'	    		=> $this->lastname,
			'telnr'                 => $this->telnr,
			'address'	    		=> $this->address,
		);
		
		$this->data = $data;
		
		return $data;
	}
	/**
	 * function to load all objects of the current type
	 * 
	 * @return array<User>
	 */
	public function loadAll () {
		
		$results = $this->_loadAll ();
		$ret 	 = array (); 
		
		foreach ($results as $result) {
			$user = new Core_Model_User ();
			$values = array_merge($user->getParent ()->loadById($result['id']), $result);
			$user->setValues ($values);
			
			$ret[] = $user;
		}
		
		return $ret;
	}
	/**
	 * funtion to load a object of the current type
	 * 
	 * @return User 
	 */
	public function loadById ($id) {
		$values = array_merge($this->getParent ()->loadById($id), $this->_loadById($id));
		$this->setValues ($values);

		return $values;		
	}
	/**
	 * function to save a User
	 * 
	 * @return inserted id
	 */
	public function save () {
		$this->id = $this->getParent ()->save();
		$this->_save();
		
		return $this->id;
	}
	/**
	 * function to update a User
	 */
	public function update () {
		$this->getParent ()->update();
		$this->_update();
	}
	/**
	 * function to delete a User
	 */
	public function delete ($id) {
		$this->getParent ()->delete ($id);
		$this->_delete($id);
	}
}