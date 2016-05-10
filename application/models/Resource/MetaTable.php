<?php

/**
 * Created by PhpStorm.
 * User: professor-taha
 * Date: 5/1/16
 * Time: 10:18 AM
 */
class Application_Model_Resource_MetaTable extends  Zend_Db_Table_Abstract
{
    protected $_name = 'session_metadata';
    protected $_primary = 'id';
	protected $_sequence = false; 
    

}