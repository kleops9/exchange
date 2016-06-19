<?php
/**
 *
 * This file is part of Exchange project.
 *
 * @author Klearchos Douvantzis, <douvantzisklearhos@gmail.com>
 * @package Controllers
 */

/**
 * Short description of class Application.
 * This object is base of the application which holds db connections, page 
 * types and is responsible of loading the correct pages/states
 *
 * @package Controllers
 */
class Application
{      
    /**
     * 
     * Variable that holds the config settings of the application
     * 
     * @access private
     * @var array
     */
    protected $_arrConfig;
    
    /**
     * 
     * Variable that holds the namge of page
     * 
     * @access private
     * @var string
     */
    protected $_strPage;
    
    /**
     * 
     * Variable that holds the type of page
     * 
     * @access private
     * @var string
     */
    protected $_strType;
    
    /**
     * 
     * Variable that holds the db connection
     * 
     * @access private
     * @var PDOobject
     */
    protected $_objDb;
    
    /**
     * 
     * Variable for cheching if a db connection has been successfully made
     * 
     * @access private
     * @var bool
     */
    protected $_blnDbConnected;

    /**
     * 
     * The constructor of the class
     * 
     * @access public
     * @param array $arrConfig
     */
    public function __construct($arrConfig){
        $this->_arrConfig = $arrConfig;
    }
    
    /**
     * 
     * Set ups a new db connection with mysql server from given credentials.
     * Throws an exception if is not successfull otherwise returns the db connection
     * 
     * @access public
     * @return mixed
     * @throws AppException
     */
    public function connectDB(){
        try {
            $this->_objDb = new PDO("mysql:host={$this->_arrConfig['db']['host']};dbname={$this->_arrConfig['db']['name']};charset=utf8",$this->_arrConfig['db']['username'], $this->_arrConfig['db']['password']);
            $this->_objDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->_objDb->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch(PDOException $e) {
        	$this->_blnDbConnected = false;
        	throw new AppException($this->_strPage.'\\'.$this->_strType, "Could not connect to DB");
        }
        $this->_blnDbConnected = true;
        return $this->_objDb; 
    }
    
    /**
     * 
     * Returns the results from given query and parameters
     * 
     * @access public
     * @param sting $strSql
     * @param array $arrParams
     * @return array
     * @throws AppException
     */
    public function executeQuery($strSql, $arrParams){
	    if($this->_blnDbConnected){
            try{
                $statement = $this->_objDb->prepare($strSql);
                $statement->execute($arrParams);    
            } catch(PDOException $e) {
                throw new AppException($this->_strPage.'\\'.$this->_strType, "Error executing query".$e->getMessage());
           }
           return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    
    /**
     * 
     * Drops db connection if exists
     * 
     * @access public
     */
    public function disconnectDB(){
        if($this->_blnDbConnected){
            $this->_objDb = null;
        }
    }
    
    /**
     * 
     * Loads the page component and template type and name of page that has 
     * been requested. If not successfull throws an exception
     * 
     * @access public
     * @throws AppException
     */
    public function loadPage(){
        $this->_strPage = isset($_REQUEST['page']) ? $_REQUEST['page'] : 'index';
        $this->_strType = 'Page';
        
        // check if state name is set and contains only letters
        if(isset($_REQUEST['state']) && ctype_alpha($_REQUEST['state'])){
            $this->_strPage = isset($_REQUEST['state']) ? $_REQUEST['state'] : false;
            $this->_strType = 'State';
        }
        
        // check if page name contains only letters
        if(ctype_alpha($this->_strPage)){
            $strClass = "Controllers\\".$this->_strType."\\".ucfirst($this->_strPage);
            if(class_exists($strClass)){
                $objPage = new $strClass;
                $objPage->loadComponent();
                echo $objPage->loadTemplate();
            } else {
                throw new AppException($this->_strPage.'\\'.$this->_strType, 'Page Not Found');
            }
        }
        
    }
    
}
