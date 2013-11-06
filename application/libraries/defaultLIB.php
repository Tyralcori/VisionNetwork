<?php

/**
 * default lib
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class defaultLIB {

    /**
     * Get CI Instance in magic construct function
     */
    public function __construct() {
        $this->ci =& get_instance();
    }
    
    /**
     * Dump session 
     * @return boolean
     */
    public function getConfig() {        
        return "LOADED";
    }
}