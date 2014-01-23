<?php

/**
 * RedboxLIB Class
 * For a nice backend statistic overview
 * @author Alexander Czichelski <a.czichelski@elitecoder.eu> | NO PRIVATE SUPPORT
 * @version "soon"
 * @todo 
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class redboxLIB {

    /**
     * Get CI Instance in magic construct function
     */
    public function __construct() {
        $this->ci = & get_instance();
    }

    /**
     * Create RedBox
     * @return boolean
     */
    public function index() {
        // Get session
        $session = $this->ci->session->all_userdata();
        
        // Check super admin
        if (empty($session) || empty($session['globalPermission']) || $session['globalPermission'] < 99) {
            $this->ci->load->helper('url');
            redirect('/', 'refresh'); // Attention, HTTPS LAYER!
        }
        
        // Return
        return;
    }

}