<?php
/**
 *
 * This file is part of Exchange project.
 *
 * @author Klearchos Douvantzis, <douvantzisklearhos@gmail.com>
 * @package Controllers
 */

namespace Modules;

/**
 * A simple class that handles json request/response
 *
 * @package Controllers
 */
class Json
{
    /**
     *
     * Variable that holds the request parameters
     * 
     * @access private
     * @var array
     */
    protected $_arrParams;
    
    /**
     *
     * Variable that holds the results
     * 
     * @access private
     * @var array
     */
    protected $_arrResults;
    
    /**
     *
     * Variable that holds the errors
     * 
     * @access private
     * @var array
     */
    protected $_arrErrors;
    
    /**
     * 
     * Constructor of the class
     * 
     * @access public
     */
    public function __construct()
    {
        $this->_arrParams           = array();
        $this->_arrResults          = array();
        $this->_arrErrors           = array();
    } 
    
    /**
     * 
     * Returns a json response either with results or errors
     *
     * @access public
     * @return string
     */
    public function getResponse()
    {
        if(count($this->_arrErrors) > 0){
            $arrData['status'] = false;
            $arrData['errors'] = $this->_arrErrors;
        } else {
             $arrData['status'] = true;
             $arrData['data'] = $this->_arrResults;
        }
        return json_encode($arrData);
    }
    
    /**
     * Validates the request parameters
     *
     * @access private
     * @return boolean
     */
    protected function _validation(){}
    
}
