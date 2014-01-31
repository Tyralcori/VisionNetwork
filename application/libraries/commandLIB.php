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
        return $channelID;
    }

    /**
     * Kick a user out of channel
     * @param type $username
     * @param type $channel
     * @return boolean|string
     */
    public function kick($username = null, $channel = null) {
        // If one of these are empty, return false
        if (empty($username) || empty($channel)) {
            return false;
        }

        // Channel LIB
        require_once APPPATH . 'libraries/channelLIB.php';
        $channelLIB = new channelLIB();

        // Get channelID by Name
        $channelID = $channelLIB->getChannelIDByName($channel);

        // Must not be empty channelID
        if (empty($channelID)) {
            return "Cannel $channel does not exists";
        }

        // Get userID from session (user)
        $session = $this->ci->session->all_userdata();
        $userID = $session['id'];
        // Global permission
        $globalPermission = $session['globalPermission'];

        // Must not be empty userid
        if (empty($userID)) {
            return "Invalid permission";
        }

        // Get permissionLevel by channelID, userID
        $permissionLevel = $channelLIB->getPermission($channelID, $userID);

        // Default message
        $message = "Invalid permission";

        // Check permission
        if ($permissionLevel >= 99 || $globalPermission >= 99) {

            // Channel LIB
            require_once APPPATH . 'libraries/userLIB.php';
            $userLIB = new userLIB();

            // Get userID by username
            $kickUserID = $userLIB->getUserIdByUserName($username);

            $message = "Unknown user $username in $channel";
            // if userid, kick
            if (empty($kickUserID)) {
                return $message;
            } else {
                // Kick user out of channel
                $kicked = $channelLIB->killConnection($channelID, $kickUserID);

                // If success, modify message
                if ($kicked == true) {
                    $message = "$username kicked from $channel";
                }
            }
        }

        // Return message
        return $message;
    }

}

?>