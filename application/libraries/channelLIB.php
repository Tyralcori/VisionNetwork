<?php

/**
 * ChannelLIB Class
 * Handles channel activitys
 * @author Alexander Czichelski <a.czichelski@elitecoder.eu> | NO PRIVATE SUPPORT
 * @version "soon"
 * @todo 
 * => Get default channel from database
 * => Refactor in more small unique functions
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class channelLIB {

    /**
     * Get CI Instance in magic construct function
     */
    public function __construct() {
        $this->ci = & get_instance();
    }

    /**
     * Return complete channels
     * @return type
     */
    public function index() {
        // Index action 
        return $this->getChannelAll();
    }

    /**
     * Function to join|create channel
     * @param type $channelName
     * @param type $userID
     * @return type
     */
    public function join($channelName = null, $userID = null) {
        // ChannelName required
        if (empty($channelName)) {
            // Default Channel! (Yes, default. Change it)
            $channelName = 'default';

            // Overwrite default
            if (!empty($_POST) && !empty($_POST['channel'])) {
                $channelName = htmlspecialchars($_POST['channel']);
            }
        }
        // Make input sql friendly
        $channelName = htmlspecialchars($channelName);

        // Get userID
        if (empty($userID)) {
            $userID = $this->ci->session->userdata('id') ? $this->ci->session->userdata('id') : 0;
            if (empty($userID)) {
                return;
            }
        }

        // Get channel ID
        $getChannelIDQuery = $this->getChannelIDByName($channelName);

        if (empty($getChannelIDQuery)) {
            // Will later need this
            $getChannelIDQuery = $this->create($channelName, $userID);

            // Insert connection
            $createConnection = $this->setConnection($getChannelIDQuery, $userID);

            // Add in session!
            $channelInfosPrivate = $this->getChannelInformations($getChannelIDQuery);

            // Add channel in session
            $currentChannels = $this->ci->session->userdata('currentChannels');
            $currentChannels[] = $channelInfosPrivate;

            // Set channels
            $this->ci->session->set_userdata(array('currentChannels' => $currentChannels));

            // Load helper for redirect
            $this->ci->load->helper('url');
            redirect('/', 'refresh'); // Attention, HTTPS LAYER!            
        }

        // Check already connected
        $connected = $this->checkConnection($getChannelIDQuery, $userID);
        if ($connected) {
            $channelInfos = $this->getChannelInformations($getChannelIDQuery);
            return $channelInfos;
        }

        // Get maximum connections
        $limitConnectionsByChannel = $this->getSlots($getChannelIDQuery);
        // Get current connections counter
        $currentConnectionsByChannelID = $this->getConnectedUser($getChannelIDQuery);

        // Get minimum join level
        $limitJoinLevelByChannel = $this->getJoinLevel($getChannelIDQuery);

        // Select Permission
        $permission = $this->getPermission($getChannelIDQuery, $userID);

        // Joining normal channel
        if ($limitJoinLevelByChannel == 1 || $channelName == 'default') {
            // If $limitConnectionsByChannel not -1 (unlimited) proof max allowed connections
            if ($limitConnectionsByChannel != -1) {
                // Is Channel full? | Master (Permission = 99) can always join
                if ($limitConnectionsByChannel < ($currentConnectionsByChannelID + 1) && $permission != 99) {
                    // Channel is full!
                    return array('state' => 'FULL');
                }
            }
        }

        // Channel is not full, join
        // Insert connection
        $createConnection = $this->setConnection($getChannelIDQuery, $userID);
        
        // Get infos
        $channelInfos = $this->getChannelInformations($getChannelIDQuery);

        // Add channel in session
        $currentChannels = $this->ci->session->userdata('currentChannels');
        $currentChannels[] = $channelInfos;

        // Set channels
        $this->ci->session->set_userdata(array('currentChannels' => $currentChannels));

        // Return Channelinfos
        return $channelInfos;
    }

    /**
     * Returns all connected user as count
     * @param type $channelID
     * @return type
     */
    public function getConnectedUser($channelID = null) {
        // If empty channelID, return
        if (empty($channelID)) {
            return;
        }
        // Get all current connected user by channel id
        $currentConnectionsByChannelIDQuery = $this->ci->db->query("SELECT COUNT(`id`) AS current FROM connections WHERE channelID = {$channelID}")->row();
        $currentConnectionsByChannelID = $currentConnectionsByChannelIDQuery->current;
        // Return current connected user
        return $currentConnectionsByChannelID;
    }

    /**
     * Get all Nicks in Channel
     * @param type $channelID
     * @return type
     */
    public function getNickList($channelID = null) {
        // If empty channelID, return
        if (empty($channelID)) {
            return;
        }

        // Query all users in channel
        $nickListQuery = $this->ci->db->query("SELECT DISTINCT login.username, login.globalPermission FROM connections, login WHERE connections.userID = login.id AND connections.channelID = {$channelID}");

        // Nick List container
        $nickList = array();

        // Fill Container
        foreach ($nickListQuery->result() as $key => $value) {
            $nickList[] = array('name' => $value->username, 'level' => $value->globalPermission);
        }

        // Return filled container
        return $nickList;
    }

    /**
     * Get Permission for channel by user
     * @param type $channelID
     * @param type $userID
     * @return int
     */
    public function getPermission($channelID = null, $userID = null) {
        // If empty channelID || $userID return
        if (empty($channelID) || empty($userID)) {
            return;
        }
        // Select Permission
        $selectPermission = $this->ci->db->query("SELECT `permissionLevel` FROM permissions WHERE userID = {$userID} AND channelID = {$channelID}")->row()->permissionLevel;
        // If emtpy permissions, insert default permission 1 - first join!
        if (empty($selectPermission)) {
            $selectPermission = 1;
            $insertPermissionQuery = $this->setPermission($channelID, $userID, $selectPermission);
        }
        return $selectPermission;
    }

    /**
     * Sets permission for a user in a channel
     * @param type $channelID
     * @param type $userID
     * @param int $permission
     * @return type
     */
    public function setPermission($channelID = null, $userID = null, $permission = null) {
        // If empty channelID || $userID return
        if (empty($channelID) || empty($userID)) {
            return;
        }
        // Default permission
        if (empty($permission)) {
            $permission = 1;
        }
        $insertPermissionQuery = $this->ci->db->query("INSERT INTO `permissions` (userID, channelID, permissionLevel) VALUES ({$userID},{$channelID},{$permission})");
        return $insertPermissionQuery;
    }

    /**
     * Returns allowed slots
     * @param type $channelID
     * @return type
     */
    public function getSlots($channelID = null) {
        // If empty channelID, return
        if (empty($channelID)) {
            return;
        }
        // Get slot count by channel id
        $limitConnectionsByChannel = $this->ci->db->query("SELECT `slots` FROM channels WHERE id = {$channelID}")->row()->slots;
        // Return slots
        return $limitConnectionsByChannel;
    }

    /**
     * Returns join level 
     * @param type $channelID
     * @return type
     */
    public function getJoinLevel($channelID = null) {
        // If empty channelID, return
        if (empty($channelID)) {
            return;
        }
        // Get minimum join level for user
        $limitJoinLevelByChannel = $this->ci->db->query("SELECT `joinlevel` FROM channels WHERE id LIKE {$channelID}")->row()->joinlevel;
        // Return join level
        return $limitJoinLevelByChannel;
    }

    /**
     * Returns write level 
     * @param type $channelID
     * @return type
     */
    public function getWriteLevel($channelID = null) {
        // If empty channelID, return
        if (empty($channelID)) {
            return;
        }
        // Get minimum join level for user
        $limitWriteLevelByChannel = $this->ci->db->query("SELECT `writelevel` FROM channels WHERE id LIKE {$channelID}")->row()->writelevel;
        // Return join level
        return $limitWriteLevelByChannel;
    }

    /**
     * Returns channel id
     * @param type $name
     * @return type
     */
    public function getChannelIDByName($name = null) {
        // If empty name, return
        if (empty($name)) {
            return;
        }
        // Get channel id by name
        try {
            $testChannelExisting = $this->ci->db->query("SELECT `id` FROM channels WHERE name LIKE '{$name}'");
            if ($testChannelExisting->num_rows() > 0) {
                $channelID = $this->ci->db->query("SELECT `id` FROM channels WHERE name LIKE '{$name}'")->row()->id;
            } else {
                return false;
            }
        } catch (Exception $e) {
            
        }
        // returns id
        return $channelID;
    }

    /**
     * Returns channel name
     * @param type $id
     * @return type
     */
    public function getChannelNameByID($id = null) {
        // If empty name, return
        if (empty($id)) {
            return;
        }
        // Get channel id by name
        $channelName = $this->ci->db->query("SELECT `name` FROM channels WHERE id = {$id}")->row()->name;
        // reutrns name
        return $channelName;
    }

    /**
     * Creates channel
     * @param type $name
     * @param type $userID
     * @return type
     */
    public function create($name = null, $userID = null) {
        // If empty name || userID
        if (empty($name) || empty($userID)) {
            return;
        }
        // Channel does'nt exists, create
        $createChannel = $this->ci->db->query("INSERT INTO `channels` (name) VALUES ('{$name}')");

        $getChannelIDQueryTwice = $this->ci->db->query("SELECT `id` FROM channels WHERE name LIKE '{$name}'")->row()->id;
        if (empty($getChannelIDQueryTwice)) {
            // Could'nt insert channel.. some error handle here
        }
        // Insert Master Permission for channel
        $createPermission = $this->ci->db->query("INSERT INTO `permissions` (userID, channelID, permissionLevel) VALUES ({$userID},{$getChannelIDQueryTwice},99)");
        // Return channel ID
        return $getChannelIDQueryTwice;
    }

    /**
     * Check connection for user by channel
     * @param type $channelID
     * @param type $userID
     * @return boolean
     */
    public function checkConnection($channelID = null, $userID = null) {
        // If empty channelID || empty userID
        if (empty($channelID) || empty($userID)) {
            return;
        }
        // Check already connected
        $connected = $this->ci->db->query("SELECT `id` FROM connections WHERE userID = {$userID} AND channelID = {$channelID}");
        if ($connected->num_rows() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Kill connection
     * @param type $channelID
     * @param type $userID
     * @return boolean
     */
    public function killConnection($channelID = null, $userID = null) {
        // If empty channelID || empty userID
        if (empty($channelID) || empty($userID)) {
            return;
        }
        // Kill connection
        $killedConnection = $this->ci->db->query("DELETE FROM connections WHERE userID = {$userID} AND channelID = {$channelID}");
        return true;
    }

    /**
     * Get topic by channelID
     * @param type $channelID
     * @return string
     */
    public function getTopic($channelID = null) {
        // If empty channelID, return
        if (empty($channelID)) {
            return;
        }

        // Get Topic
        $getTopic = $this->ci->db->query("SELECT `topic` FROM channels WHERE id LIKE {$channelID}")->row()->topic;
        // Set default Topic, if there is no result
        if (empty($getTopic)) {
            $getTopic = "No Topic";
        }
        return $getTopic;
    }

    /**
     * Change Topic
     * @return boolean
     */
    public function changeTopic() {
        // GET topic by post form
        $newTopic = $_POST['topicName'] ? $_POST['topicName'] : '';
        $newTopicSafe = htmlspecialchars($newTopic);
        // GET channel
        $channelBy = $_POST['channelTopic'] ? $_POST['channelTopic'] : '';
        $channelBySafe = htmlspecialchars($channelBy);

        // If empty, return
        if (empty($newTopicSafe) || empty($channelBySafe)) {
            return;
        }

        // Update topic
        $setTopic = $this->ci->db->query("UPDATE channels SET topic = '{$newTopicSafe}' WHERE name = '{$channelBySafe}'");

        // Load helper for redirect
        $this->ci->load->helper('url');
        redirect('/', 'refresh'); // Attention, HTTPS LAYER!  
        return true;
    }

    /**
     * Set connection for a user in a channel
     * @param type $channelID
     * @param type $userID
     * @return boolean
     */
    public function setConnection($channelID = null, $userID = null) {
        // If empty channelID || empty userID
        if (empty($channelID) || empty($userID)) {
            return;
        }
        // Insert connection
        $this->ci->db->query("INSERT INTO `connections` (userID, channelID, lastActivity) VALUES ({$userID}, {$channelID}, NOW())");
        return true;
    }

    /**
     * Returns log by channel 
     * @param type $channelID
     * @param int $limit
     * @return type
     */
    public function getLog($channelID = null, $limit = null) {
        // If empty channelID, return
        if (empty($channelID)) {
            return;
        }

        // Default Limit
        if (empty($limit)) {
            $limit = 100;
        }

        // Get messgaes
        $messageQuery = $this->ci->db->query("SELECT messages.*, login.username AS username, login.globalPermission AS level FROM messages, login WHERE channelID LIKE '{$channelID}' AND messages.userID = login.id ORDER BY timestamp ASC LIMIT {$limit}");

        // Message Container
        $messageContainer = array();

        // Add some nice messages!
        foreach ($messageQuery->result() as $key => $value) {
            // Foreach Element in Object, add in session
            foreach ($value as $keyInner => $valueInner) {
                $messageContainer[$key][$keyInner] = $valueInner;
            }
        }

        // Return Log
        return $messageContainer;
    }

    /**
     * Return most important infos about the channel
     * @param type $channelID
     * @return type
     */
    public function getChannelInformations($channelID = null) {
        // If empty channelID, return
        if (empty($channelID)) {
            return;
        }

        // Get nicklist (current connected User in channel)
        $nickList = $this->getNickList($channelID);

        // Get current setted Topic from channel
        $topic = $this->getTopic($channelID);

        // Get last 100 Messages
        $contentLog = $this->getLog($channelID, 100);

        $channelName = $this->getChannelNameByID($channelID);

        // Return all infos
        return array('id' => $channelID, 'name' => $channelName, 'nicks' => $nickList, 'topic' => $topic, 'log' => $contentLog, 'state' => 'CONNECTED');
    }

    /**
     * Get all channel logs
     * @param type $userID
     * @return type
     */
    public function getChannelAll($userID = null) {
        // Get userID
        if (empty($userID)) {
            $userID = $this->ci->session->userdata('id') ? $this->ci->session->userdata('id') : 0;
            if (empty($userID)) {
                return;
            }
        }

        // Get all connections
        $selectAllChannels = $this->ci->db->query("SELECT DISTINCT `channelID` FROM connections WHERE userID = {$userID}");

        // Connected Channels Container
        $connectedChannels = array();

        // Fill container with all connections
        foreach ($selectAllChannels->result() as $key => $value) {
            $connectedChannels[] = $value->channelID;
        }

        // Channel Information Container
        $channelInfos = array();

        // Channel Container
        $channelIDS = array();

        // Fill channel info container
        foreach ($connectedChannels as $channelKey => $connectedChannel) {
            // Single ADD
            $channelInfos[] = $this->getChannelInformations($connectedChannel);
        }

        // Set all Channel IDS with Name into Session!
        $this->ci->session->set_userdata('currentChannels', $channelInfos);

        // Return all the infos
        return $channelInfos;
    }

}