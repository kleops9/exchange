<?php
/**
 *
 * This file is part of Exchange project.
 *
 * @author Klearchos Douvantzis, <douvantzisklearhos@gmail.com>
 * @package Controllers
 */

namespace Controllers\Page;

/**
 * A class that represents the index page
 *
 * @package Controllers
 */
class Index implements \Modules\Page
{       
    /**
     * Variable that holds the template of the page
     * @var string
     */
    protected $_strTemplate;
    
    /**
     * Variable that holds the data of the page
     * @var array
     */
    protected $_arrData;
    
    /**
     * Variable that holds the errors of the page
     * @var array
     */
    protected $_arrErrors;
    
    /**
     * Constructor of the class
     */
    public function __construct(){
        $this->_strTemplate = APP_PATH . 'Templates/Index.php';
    }
    
    /**
     * Loads the component of the page
     */
    public function loadComponent(){
        $this->_arrData = \Models\Item::getItems();
    }
    
    /**
     * Loads the template of the page including header and footer
     */
    public function loadTemplate(){
        include APP_PATH.'Templates/Header.html';
        include $this->_strTemplate;
        include APP_PATH.'Templates/Footer.html';
    }
}
