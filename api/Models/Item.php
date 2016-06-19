<?php
/**
 *
 * This file is part of Exchange project.
 *
 * @author Klearchos Douvantzis, <douvantzisklearhos@gmail.com>
 * @package Models
 */

namespace Models;

/**
 * Item class that represents the product object
 *
 * @package Models
 */
class Item
{
    /**
     * 
     * The mapping properties of the Item object
     * 
     * @access private
     * @var array
     */
    protected  $_arrMapping = array(
                                    "intId"          => "id",
                                    "strTitle"       => "title",
                                    "strDescription" => "description",
                                    "intWeight"   => "weight",
                                    "intStock"       => "stock",
                                    "fltPrice"       => "price"
                                    );
    
    /**
     * 
     * Magic getter for model properties
     * 
     * @access public
     * @param string $strProp The propery name
     * @return mixed
     * @throws exception
     */
    public function __get($strProp) {
        switch ($strProp) {
            default:
                return $this->$strProp;
        }
    }
    
    /**
     * 
     * Magic setter for model properties
     * 
     * @access public
     * @param string $strProp The property name
     * @param string $mixVal The property value
     * @throws exception
     */
     public function __set($strProp, $mixVal) {
        switch ($strProp) {
            case "lat":
            case "lon":
                $strFunction = "get".ucfirst($strProp)."FromGeoloc";
                $this->$strProp = \Assets\Models::$strFunction($mixVal);
                break;
            default:
                $this->$strProp = !empty($mixVal) ? $mixVal : '';
                break;
        }
    }
    
    /**
     * Returns the items objects or a single one if parameter is defined
     * 
     * @global object $objApp
     * @param mixed $intId The id of item to find or false to fetch all
     * @return array
     */
    public static function getItems($intId = false){
        global $objApp;
        $strSql = "SELECT * FROM items";
        $arrParams= array();
        if($intId !== false){
            $strSql .= " WHERE id = ?";
            $arrParams[] = $intId;
        }
        $arrItems = $objApp->executeQuery($strSql, $arrParams);
        $arrRes = array();
        foreach($arrItems as $arrItem){
            $objItem = new Item();
            foreach($objItem->_arrMapping as $api_key=>$db_key){
                $objItem->$api_key = $arrItem[$db_key];
            }
            $arrRes[$objItem->intId] = $objItem;
        }
        return $arrRes;
    }
    
}
