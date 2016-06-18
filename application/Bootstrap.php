<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	public $frontController ;
	public $loader;
    public $_logger;
	protected function _initLogging(){
		$this -> bootstrap ('frontController');
		$logger = new Zend_Log(); 
		$writer = new Zend_Log_Writer_Firebug(); 
		$logger -> addWriter($writer); 
		$this -> _logger = $logger; 
	}
	protected function _initDbProfiler(){
		$this -> bootstrap('db');
		$this -> _db_profiler = new Zend_Db_Profiler_Firebug('All DB Queries'); 
		$this -> _db_profiler -> setEnabled(true);
		$this -> getPluginResource ('db') -> getDbAdapter() -> setProfiler($this -> _db_profiler); 
	}
	protected function _initLocale(){
		$locale = new Zend_Locale('en_US');
		Zend_Registry::set('Zend_Locale', $locale);
	}
	protected function _initViewSettings(){
		$this -> bootstrap('view');
		$this -> _view = $this -> getResource('view');
		$this -> _view -> setEncoding('UTF-8');
		$this -> _view -> doctype('HTML5');
		$this -> _view -> headMeta() -> appendHttpEquiv ('Content-Type', 'text/html; charset=UTF-8');
		//$this -> _view -> headMeta('utf-8', 'charset', 'utf-8');   
		$this -> _view -> headMeta() -> setCharset('utf-8');
		//line below: refresh the page every 10 seconds. For developement onyl 
		//$this -> _view -> headMeta() -> appendHttpEquiv( "refresh", "7" ); 
		$this -> _view -> headMeta() -> appendHttpEquiv ('Content-Language', 'en-US');
		$this -> _view -> headLink() -> appendStylesheet('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'); 
		$this -> _view -> headLink() -> appendStylesheet('/css/main.css');
		$this -> _view -> headScript() -> appendFile('https://code.jquery.com/jquery-2.2.3.min.js', 'text/javascript', array('integrity' => 'sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=' )); 
		$this -> _view -> headScript() -> appendFile('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js');
		$this -> _view -> headScript() -> appendFile('https://ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular.min.js');  
		$this -> _view -> headTitle() -> setSeparator(' - ');
		$this -> _view -> headTitle('OPIHI');
		$this -> _view -> headMeta() -> appendName('viewport', 'width=device-width, initial-scale=1') ; 
	}
}
