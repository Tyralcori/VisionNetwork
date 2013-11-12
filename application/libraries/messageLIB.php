<?php
/**
 * MessageLib Class
 * Handles messages 
 * @author Alexander Czichelski <a.czichelski@elitecoder.eu> | NO PRIVATE SUPPORT
 * @version "soon"
 * @todo 
 * => TEST THIS!!! 
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class messageLIB {
    /**
     * Get CI Instance in magic construct function
     */
    public function __construct() {
        $this->ci = & get_instance();
    }
}