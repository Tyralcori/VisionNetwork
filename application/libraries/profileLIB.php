<?php

/**
 * default lib
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class profileLIB {

    /**
     * Get CI Instance in magic construct function
     */
    public function __construct() {
        $this->ci =& get_instance();
    }
    
    /**
     * Get user
     * @return boolean
     */
    public function show() {
        // If post user
        if (!empty($_POST) && !empty($_POST['user'])) {
            // Nice user
            $username = htmlspecialchars($_POST['user']);
            
            // Get some infos about the user
            // ..
            
            // Return infos
            // ..
        }
    }
}