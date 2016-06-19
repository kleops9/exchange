<?php
/**
 *
 * This file is part of Exchange project.
 *
 * @author Klearchos Douvantzis, <douvantzisklearhos@gmail.com>
 * @package Controllers
 */

namespace Controllers\State;

/**
 * An extended Json class that returns the product info of a specified item
 * 
 * @package Controllers
 */
class ProductInfo extends \Modules\Json implements \Modules\Page
{    
    /**
     * 
     * Constructor of the class validated the input
     * 
     * @access public
     */
    public function __construct(){
        $this->_validation();
    }
    
    /**
     * 
     * Loads the component of this page/state
     * 
     * @access public
     */
    public function loadComponent(){
        if(count($this->_arrErrors) == 0){
            $this->_arrResults = \Models\Item::getItems($this->_arrParams['id']);
        }
    }

    /**
     * 
     * Loads and returns the template of this page/state
     * 
     * @access public
     * @return string
     */    
    public function loadTemplate(){
        return $this->getResponse();
    }

    /**
     * 
     * Validates the request parameters
     *
     * @return boolean
     */
    protected function _validation()
    {
        if (!isset($_REQUEST['id'])){
            $this->_arrErrors[] = "Parameter 'id' is mandatory";
        } else {
            $this->_arrParams['id'] = $_REQUEST['id'];
            if(!ctype_digit($this->_arrParams['id'])) { // only integers allowed
                $this->_arrErrors[] = "Parameter 'id' does not exist";
            }
        }
        return (count($this->_arrErrors) > 0) ? false : true;
    }
    
}
