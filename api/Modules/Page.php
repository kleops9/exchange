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
 * An interface for the Pages
 *
 * @package Controllers
 */
interface Page
{
    /**
     * Constructor 
     */
    public function __construct();
    
    /**
     * Loads the component
     */
    public function loadComponent();
    
    /**
     * Loads the template
     */
    public function loadTemplate();
    
}
