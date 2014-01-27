<?php

/**
 * MessageLib Class
 * Handles messages 
 * @author Alexander Czichelski <a.czichelski@elitecoder.eu> | NO PRIVATE SUPPORT
 * @version "soon"
 * @todo No.
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

    /**
     * Set a message to a specified channel
     * @param type $channel
     * @param type $message
     * @return type
     */
    public function publish($channel = null, $message = null, $userID = null) {
        // If empty channel or message, return
        if (empty($channel) || empty($message)) {
            if (!empty($_POST) && !empty($_POST['message']) && !empty($_POST['channel'])) {
                $channel = $_POST['channel'];
                $message = $_POST['message'];
            } else {
                return;
            }
        }

        // Make input sql friendly
        $channel = htmlspecialchars($channel);
        
        // Ignore system
        if(strtolower($channel) == 'system') {
            return;
        }
        
        $message = htmlspecialchars($message);
        $message = preg_replace('!(http://[a-z0-9_./?=&-]+)!i', '<a href="?out=$1" target="_blank">$1</a> ', $message . "");
        // Get userID
        if (empty($userID)) {
            $userID = $this->ci->session->userdata('id') ? $this->ci->session->userdata('id') : 0;
            if (empty($userID)) {
                return;
            }
        }

        // Get channelID
        $channelID = $this->ci->db->query("SELECT `id` FROM channels WHERE name LIKE '{$channel}'")->row()->id;
        if (empty($channelID)) {
            return;
        }

        // Check users message 
        $userReturn = $this->checkCommand($message);
        
        // If return is not emtpy, return Command return.. 
        if (!empty($userReturn)) {
            // If Ajax Request, return json format
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest") {
                $json = true;
            }

            // Return all the messages in json?
            if (!empty($json)) {
                echo json_encode($userReturn);
                die();
            }

            // Return all the messages
            return $userReturn;
        }

        // Create Message
        $createMessage = $this->ci->db->query("INSERT INTO `messages` (userID,channelID,message,timestamp) VALUES ('{$userID}', '{$channelID}', '{$message}', NOW())");
        
        // Return status
        return $createMessage;
    }

    /**
     * Recive all messages by channel
     * @param type $channel
     * @return type
     */
    public function recive($channel = null, $json = null, $reverse = null) {
        // If empty channel, return
        if (empty($channel)) {
            $channel = 'default';
        }

        // If Ajax Request, return json format
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest") {
            $json = true;
        }

        $channelIDs = array();
        // Get all channels?
        if (!empty($_POST) && isset($_POST['flushAllChannels'])) {
            // Get current user
            $session = $this->ci->session->all_userdata();
            // Get all channels
            $allChannelIDs = $this->ci->db->query("SELECT DISTINCT channelID FROM connections WHERE userID = {$session['id']}");

            // Channel Container
            $channelContainer = array();

            // Add some nice messages!
            foreach ($allChannelIDs->result() as $key => $value) {
                // Foreach Element in Object, add in session
                foreach ($value as $keyInner => $valueInner) {
                    $channelName = $this->ci->db->query("SELECT `name` FROM channels WHERE id = '{$valueInner}'")->row()->name;
                    $channelContainer[$valueInner] = $channelName;
                }
            }

            // ChannelIDs set
            $channelIDs = $channelContainer;
        } else {
            // Get channelID
            $channelID = $this->ci->db->query("SELECT `id` FROM channels WHERE name LIKE '{$channel}'")->row()->id;
            $channelIDs[$channelID] = $channel;
        }

        // Return, if we have no id(s)
        if (empty($channelIDs)) {
            return;
        }

        // Message Container
        $messageContainer = array();

        // Foreach channel
        foreach ($channelIDs as $channelID => $channelName) {
            // Get messgaes
            $messageQuery = $this->ci->db->query("SELECT m.*, l.username, l.globalPermission as level FROM messages as m, login as l WHERE m.channelID LIKE '{$channelID}' AND m.userID = l.id ORDER BY timestamp ASC");

            // Add some nice messages!
            foreach ($messageQuery->result() as $key => $value) {
                // Foreach Element in Object, add in session
                foreach ($value as $keyInner => $valueInner) {
                    $messageContainer[$channelName][$key][$keyInner] = $valueInner;
                }
            }
        }

        // If not empty reverse, reverse array (latest message on top)
        if (!empty($reverse)) {
            $messageContainer = array_reverse($messageContainer);
        }

        // Return all the messages in json?
        if (!empty($json)) {
            echo json_encode($messageContainer);
            die();
        }

        // Return all the messages
        return $messageContainer;
    }

    /**
     * Return command
     * @param type $message
     * @return boolean|string
     */
    private function checkCommand($message = null) {
        
        // Check if message match command syntax or is empty
        if(empty($message) || $message[0] != '/') {
            return false;
        }
        
        // Match command
        switch($message)
        {
            // Private commands, not visible for all users
            case '/help':
                $returnMessage = array('message' => 'HELP:');
                break;
            default:
                $returnMessage = array('message' => "Command $message not found. Please type /help for command overview.");
                break;
        }
        
        // If return message is filled
        if(!empty($returnMessage)) {
            // Timestamps for all
            $objDateTime = new DateTime('NOW');
            // Add timestamp
            $returnMessage['timestamp'] = $objDateTime->format('Y-m-d H:i:s');
            
            // Return 
            return $returnMessage;
        }
        
        // Return false, but this point should never given
        return false;
    }
}