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
            if(!empty($_POST) && !empty($_POST['message']) && !empty($_POST['channel'])) {
                $channel = $_POST['channel'];
                $message = $_POST['message'];
            } else {
                return;
            }
        }

        // Make input sql friendly
        $channel = html_entity_decode($channel);
        $message = html_entity_decode($message);
        
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

        // Create Message
        $createMessage = $this->ci->db->query("INSERT INTO `messages` (userID,channelID,message,timestamp) VALUES ('{$userID}', '{$channelID}', '{$message}', NOW())");
    }

    /**
     * Recive all messages by channel
     * @param type $channel
     * @return type
     */
    public function recive($channel = null, $json = null, $reverse = null) {
        // If empty channel, return
        if (empty($channel)) {
            $channel = "default";
            //return;
        }

        // Get channelID
        $channelID = $this->ci->db->query("SELECT `id` FROM channels WHERE name LIKE '{$channel}'")->row()->id;
        if (empty($channelID)) {
            return;
        }

        // Get messgaes
        $messageQuery = $this->ci->db->query("SELECT * FROM messages WHERE channelID LIKE '{$channelID}' ORDER BY timestamp ASC");

        // Message Container
        $messageContainer = array();

        // Add some nice messages!
        foreach ($messageQuery->result() as $key => $value) {
            // Foreach Element in Object, add in session
            foreach ($value as $keyInner => $valueInner) {
                $messageContainer[$key][$keyInner] = $valueInner;
            }
        }
        
        // If not empty reverse, reverse array (latest message at last)
        if(!empty($reverse)) {
            $messageContainer = array_reverse($messageContainer);
        }
        
        // Return all the messages in json?
        if(!empty($json)) {
            return json_encode($messageContainer);
        }
        
        // Return all the messages
        return $messageContainer;
    }

}