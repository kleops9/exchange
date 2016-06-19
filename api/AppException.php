<?php
/**
 *
 * This file is part of Exchange project.
 *
 * @author Klearchos Douvantzis, <douvantzisklearhos@gmail.com>
 * @package Controllers
 */

/**
 * A custom exception class for the application
 *
 * @package Controllers
 */
class AppException extends Exception
{      
    /**
     * the page where the error was generated
     * @var string
     */
    protected $_strPage;

    /**
     * Constructor of the class
     * 
     * @param string $strPage
     * @param string $strMessage
     * @param integer $intCode
     * @param Exception $previous
     * 
     */
    public function __construct($strPage, $strMessage, $intCode = 0, Exception $previous = null) {
        $this->_strPage = $strPage;
        parent::__construct($strMessage, $intCode, $previous);
    }
     
    /**
     * Returns the page name where the exception occured
     * 
     * @return string
     */
    public function getPage() {
        return $this->_strPage;
    }

 
}
