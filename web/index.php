<?php
error_reporting(E_ALL);
define('IS_DEV', false);

opcache_reset(); // stop caching
if(IS_DEV === true){   
    opcache_reset(); // stop caching
    ini_set('display_errors', 1);
} else {
    ini_set('display_errors', 0);
}

// Set the application path
define('APP_PATH', realpath('..') . '/api/');
global $objApp;

// Load all config vars
require APP_PATH . 'Config/config.php';

try{
    $objApp = new Application($arrConfig);
    
    $objApp->connectDB();
    $objApp->loadPage();
    $objApp->disconnectDb();
} catch (AppException $ex) {
    if(IS_DEV){
        echo $ex->getMessage()." from page ".$ex->getPage()." in ".$ex->getFile().":ln".$ex->getLine();
    } else {
        echo $ex->getMessage();
    }
} catch (Exception $ex) {    
    $objApp->disconnectDb();
    if(IS_DEV){
        echo $ex->getMessage()." in ".$ex->getFile().":ln".$ex->getLine();
    } else {
        echo $ex->getMessage();
    }
}

function __autoload($strClass)
{
    $strPath = preg_replace('~\\\~', '/', $strClass);
    $strPath = APP_PATH.$strPath. '.php';
    if(file_exists($strPath)){
        require $strPath;
    }
}