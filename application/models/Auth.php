<?php
/**
 * Auth entity
 * represents the Authentication (identity, password, etc) with his attributes
 *
 * @author Andreas Ressmann
 * 23.01.2014
 */
class Core_Model_Auth extends Core_Model_Abstract {
	

	/* [PROPERTIES] */
    protected $identity;
    protected $password;
    protected $created;
    protected $role_id;
    protected $is_active;
    protected $is_first_login;
    
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
		return 'auth';
	}
	/**
	 * getting the class variables of the current class
	 * 
	 * @return class properties
	 */
	public function getProperties () {
		return get_class_vars('Core_Model_Auth');
	}
	
	/* [GETTERS/SETTERS] */
	/**
	 * @return identity (login, email)
	 */
    public function getIdentity() {
        return $this->identity;
    }

	/**
	 * setting the identity
	 */
    public function setIdentity($identity) {
        $this->identity = $identity;
    }
    
	/**
	 * @return password
	 */
    public function getPassword() {
    	return $this->password;
    }
    
	/**
	 * setting the password encrypt as md5
	 */
    public function setPassword($password, $encode = true) {
    	
    	if($encode) {
    		$this->password = md5 ($password);
    	} else {
    		$this->password = $password;
    	}
    }

	/**
	 * @return created date
	 */    
	public function getCreated() {
    	return $this->created;
    }
    
	/**
	 * set the created date
	 */
    public function setCreated($created) {
    	if($this->created == null) $this->created = $created;
    }
    
	/**
	 * @return the role id like in acl
	 */
	public function getRoleId() {
    	return $this->role_id;
    }
    
	/**
	 * setting the roleId
	 */
    public function setRoleId($roleId) {
    	$this->role_id = $roleId;
    }
    
	/**
	 * @return active true or false
	 */
	public function getIsActive() {
    	return $this->is_active == '1' ? true : false;
    }
    
	/**
	 * set the object to active
	 */
    public function setIsActive($isActive) {
    	$this->is_active = $isActive;
    }
	
	/**
	 * @return is first login true or false
	 */
	public function getIsFirstLogin () {
		return $this->is_first_login;
	}
	
	/**
	 * set firstlogin of the object
	 */
	public function setIsFirstLogin ($val) {
		$this->is_first_login = $val;
	}
    
	/**
	 * @return authentication token for mail 
	 */
    public function getToken() {
    	return $this->id . '$' . md5( $this->id . $this->identity . $this->created . date('Y-m-d') );
    }
	
	/**
	 * getting attributes of this class as array
	 *
	 * @return array with attributes
	 */
    public function getData () {
        return $this->toArray ();
    }
    
	/**
	 * getting the authentication from the database by the given token
	 */
    public function loadByToken($token) {
    	
    	$params = explode('$', $token);
    	self::loadById($params[0]);
    	
    	if(self::getToken() != $token) {
    		self::reset();
    	}
    }
    

    /* [FUNCTIONS] */
    /**
	 * @return authentication by the given identity
	 */
    public function loadByIdentity($identity) {
    	$result = $this->loadByProperty('identity', $identity);
    	
		if (isset ($result[0])) {
	    	$this->setValues($result[0]);
	    	return $result[0];
		}
		return null;
    }
    
    /* [TRANSFORMERS] */
    /**
	 * transform object to array
	 * 
	 * @return array of attributes
	 */
	public function toArray() {
		
		$data = array(
			'id' 	    			=> $this->id,
            'identity'	    		=> $this->identity,
			'password'	    		=> $this->password,
			'created'	    		=> $this->created,
			'role_id'	    	    => $this->role_id,
			'is_active'	    		=> $this->is_active,
			'is_first_login'        => $this->is_first_login,
		);
		
		$this->data = $data;
		
		return $data;
	}
	
	/**
	 * transform object to array simple
	 * 
	 * @return array with id and identity
	 */
	public function toSimplifiedArray() {
		$data = array(
			'id' 	    			=> $this->id,
            'identity'	    		=> $this->identity,
		);
		
		return $data;
	}
	
	/**
	 * function to load all objects of the current type
	 * 
	 * @return array<Auth>
	 */
	public function loadAll () {
		
		$results = $this->_loadAll ();
		$ret 	 = array (); 
		
		foreach ($results as $result) {
			$auth = new Core_Model_Auth ();
			$auth->setValues ($result);
			
			$ret[] = $auth;
		}
		
		return $ret;
	}
	
	/**
	 * funtion to load a object of the current type
	 * 
	 * @return Auth 
	 */
	public function loadById ($id) {
		$values = $this->_loadById($id);
		$this->setValues ($values);

		return $values;
	}
	
	/**
	 * function to save a Auth
	 * 
	 * @return inserted id
	 */
	public function save () {
		$this->id = $this->_save();
		
		return $this->id;		
	}

	/**
	 * function to update a Auth
	 */
	public function update() {
		$this->_update();
	}
	
	/**
	 * function to delete a Auth
	 */
	public function delete ($id) {
		$this->_delete($id);
	}
}