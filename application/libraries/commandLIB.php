<?php

/**
 * commandLIB Class
 * Handles channel Commands
 * @author Alexander Czichelski <a.czichelski@elitecoder.eu> | NO PRIVATE SUPPORT
 * @version "soon"
 * @todo 
 * => Get default channel from database
 * => Refactor in more small unique functions
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class commandLIB {

    /**
     * Get CI Instance in magic construct function
     */
    public function __construct() {
        $this->ci = & get_instance();
    }

    /**
     * Function to leave a channel
     * @param type $channel
     * @return type
     */
    public function leave($channel = null) {
        // Check if channel is empty
        if (empty($channel)) {
            return false;
        }
        
        // Channel LIB
        require_once APPPATH . 'libraries/channelLIB.php';
        $channelLIB = new channelLIB();

        // Get session and userid
        $session = $this->ci->session->all_userdata();
        $userID = $session['id'];

        // Get id by name - lazy
        $channelID = $channelLIB->getChannelIDByName($channel);

        // Can't leave unknown channels or channels you are not it
        $connected = $channelLIB->killConnection($channelID, $userID);

        // Return
        return $connected;
    }

    /**
     * Join a channel
     * @param type $channel
     * @return boolean
     */
    public function join($channel = null) {
        // Check if channel is empty
        if (empty($channel)) {
            return false;
        }
        
        // Channel LIB
        require_once APPPATH . 'libraries/channelLIB.php';
        $channelLIB = new channelLIB();

        // Get session and userid
        $session = $this->ci->session->all_userdata();
        $userID = $session['id'];

        // Get id by name - lazy
        $channelID = $channelLIB->join($channel, $userID);

        // Return
        return $connected;
    }

}

?>