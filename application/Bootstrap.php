<?php
/**
 * zend bootstrap
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	/**
	 * connect to db
	 */
	protected function _initDbResource()
	{
		$this->bootstrap('db');
	}

	/**
	 * init zend registry
	 */
	protected function _initRegistry() {
		Zend_Registry::set('view', $this->getResource('view'));
		Zend_Registry::set('dbAdapter', $this->getResource('db'));
	}

	/**
	 * zend autoload classes by namespace
	 */
	protected function _initAutoloader()
	{
		$autoLoader = Zend_Loader_Autoloader::getInstance();
		$autoLoader->registerNamespace('Core_');
	}

	protected function _initSession()
	{
		/*$session = Core_Model_Session::getInstance();
		Zend_Session::start();*/
	}

    protected function _initTranslate()
    {
        
    }
    
	/**
	 * zend init frontController plugin
	 */
	protected function _initPlugins()
	{
		$this->bootstrap('frontController');
		$controller = Zend_Controller_Front::getInstance();
	}

	protected function _initAuth() {
		
	}
	
	/**
	 * initializing the config file
	 */
	protected function _initConfig()
	{
		$config = new Zend_Config($this->getOptions(), true);
	    
	    Zend_Registry::set('config', $config);
	    //Zend_Registry::set('version-app', $config->app->version . '.' . time());
	    Zend_Registry::set('version-app', $config->app->version);
	}
	
	/**
	 * zend initializing viewdata, doctype, stylesheed aso...
	 */
	protected function _initViewData()
	{
		$this->bootstrap('view');
		$view = $this->getResource('view');
		$view->addHelperPath(APPLICATION_PATH . '/views/helpers/', 'Core_View_Helper');
		$view->doctype('XHTML1_TRANSITIONAL');
		
		$v = Zend_Registry::get('version-app');
		
		$view->headLink()->appendStylesheet('/assets/css/application.min.css?v=' . $v, 'all');
		$view->headScript()->appendFile('/assets/js/jquery-1.10.2.min.js?v=' . $v);
		$view->headScript()->appendFile('/assets/js/jquery.pnotify.min.js?v=' . $v);
		$view->headScript()->appendFile('/assets/js/bootstrap.min.js?v=' . $v);
		$view->headScript()->appendFile('/assets/js/ejs.js?v=' . $v);
		$view->headScript()->appendFile('/assets/js/view.js?v=' . $v);
		$view->headScript()->appendFile('/assets/js/json2.js?v=' . $v);
		$view->headScript()->appendFile('/assets/js/application.js?v=' . $v);
        $view->headScript()->appendFile('/assets/js/apimanagement.js?v=' . $v);
	}
}
