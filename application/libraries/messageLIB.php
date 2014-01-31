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
        if (strtolower($channel) == 'system') {
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
        
        // Channel LIB
        require_once APPPATH . 'libraries/channelLIB.php';
        $channelLIB = new channelLIB();

        // Get channel permission
        $permissionLevel = $channelLIB->getPermission($channelID, $userID);

        // If permissionlevel lower than 1, return, you are maybe devoiced
        if ($permissionLevel <= 0) {
            echo json_encode(array('message' => "Can not write in $channel, you are devocied."));
            die();
        }
        
        // Check users message 
        $userReturn = $this->checkCommand($message, $channel);

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
    private function checkCommand($message = null, $channel = null) {
        // Command LIB
        require_once APPPATH . 'libraries/commandLIB.php';
        $commandLIB = new commandLIB();

        // Check if message match command syntax or is empty
        if (empty($message) || $message[0] != '/') {
            return false;
        }

        // Try to explode this
        $explodeLimitMessage = explode(" ", $message);

        // Match command
        switch ($explodeLimitMessage[0]) {
            // =========================== PRIVATE COMMANDS =========================== //
            case '/help':
                $returnMessage = array('message' => '
<pre>
<h4>HELP:</h4>
<label>[Channel commands]</label>
/join CHANNELNAME - join a channel
/leave CHANNELNAME - leave a channel (You can type /leave for leaving current channel)
/nextFeatures - list next version features

<label>[Moderator commands]</label>
/kick CHANNELNAME USERNAME - kicks user out of channel

/voice CHANNELNAME USERNAME - voice a user - allowed to write in channel
/devoice CHANNELNAME USERNAME - devoice a user - not allowed to write in channel anymore

/ban CHANNELNAME USERNAME - ban a user - not allowed to join anymore
/unban CHANNELNAME USERNAME - unbans user - allows banned user to join
</pre>');
                break;
            case '/nextFeatures':
                $returnMessage = array('message' => '
<pre>
<h4>Next features (0.6.0):</h4>
<label>Interfaces</label>
Twitter & Facebook API connection for post / get

<label>Channel handling</label>
Ignore, kick, ban user
Write in some nice colors (colorpicker?)
Channelsettings (How many slots allowed, Link posting, etc. for channel owner)

<label>Redbox</label>
API for import & export stats?

<label>Bots</label>
Channelbots for creating games (Quizbot, e.g.)

So many new features planned...
You have ideas to improve VisionNetwork? Write me!
a.czichelski@elitecoder.eu
</pre>');
                break;
            case '/leave':
                // Overwrite current channel, if given
                if (!empty($explodeLimitMessage[1])) {
                    $channel = $explodeLimitMessage[1];
                }

                // Call command leave
                $returningFunction = $commandLIB->leave($channel);

                // Create returning message
                $returningFunctionMessage = "Can't left channel $channel";
                if ($returningFunction == true) {
                    $returningFunctionMessage = "Left channel $channel";
                }

                // Return message
                $returnMessage = array('message' => $returningFunctionMessage);
                break;
            case '/join':
                // Set default channel
                $channel = "default";

                // Overwrite default channel, if given
                if (!empty($explodeLimitMessage[1])) {
                    $channel = $explodeLimitMessage[1];
                }

                // Call command join
                $returningFunction = $commandLIB->join($channel);

                // Create returning message
                $returningFunctionMessage = "Can't join channel $channel";
                if ($returningFunction == true && strlen($returningFunction) < 20) {
                    $returningFunctionMessage = "Joined channel $channel";
                } else {
                    $returningFunctionMessage = $returningFunction;
                }

                // Return message
                $returnMessage = array('message' => $returningFunctionMessage);
                break;
            case '/ignore':
                break;
            // =========================== PRIVATE COMMANDS END =========================== //
            
            
            // =========================== MODERATOR COMMANDS =========================== //
            case '/kick':
                // Get current user 
                if (!empty($explodeLimitMessage[2])) {
                    $user = $explodeLimitMessage[2];
                }

                // Get channel
                if (!empty($explodeLimitMessage[1])) {
                    $channel = $explodeLimitMessage[1];
                }

                // If one of these are empty, return message
                if (empty($user) || empty($channel)) {
                    $returnMessage = array('message' => "User and channel must be given for the command /kick");
                } else {
                    // Call command kick
                    $returningFunction = $commandLIB->kick($user, $channel);

                    // Return message
                    $returnMessage = array('message' => $returningFunction);
                }
                break;
            case '/ban':
                // Get current user 
                if (!empty($explodeLimitMessage[2])) {
                    $user = $explodeLimitMessage[2];
                }

                // Get channel
                if (!empty($explodeLimitMessage[1])) {
                    $channel = $explodeLimitMessage[1];
                }

                // If one of these are empty, return message
                if (empty($user) || empty($channel)) {
                    $returnMessage = array('message' => "User and channel must be given for the command /ban");
                } else {
                    // Call command kick
                    $returningFunction = $commandLIB->ban($user, $channel);

                    // Return message
                    $returnMessage = array('message' => $returningFunction);
                }
                break;
            case '/unban':
            case '/voice':
                // Get current user
                if (!empty($explodeLimitMessage[2])) {
                    $user = $explodeLimitMessage[2];
                }

                // Get channel
                if (!empty($explodeLimitMessage[1])) {
                    $channel = $explodeLimitMessage[1];
                }

                // If one of these are empty, return message
                if (empty($user) || empty($channel)) {
                    $returnMessage = array('message' => "User and channel must be given for the command $explodeLimitMessage[1]");
                } else {
                    // Call command kick
                    $returningFunction = $commandLIB->voice($user, $channel);

                    // Return message
                    $returnMessage = array('message' => $returningFunction);
                }
                break;
            case '/devoice':
                // Get current user to kick
                if (!empty($explodeLimitMessage[2])) {
                    $user = $explodeLimitMessage[2];
                }

                // Get channel
                if (!empty($explodeLimitMessage[1])) {
                    $channel = $explodeLimitMessage[1];
                }

                // If one of these are empty, return message
                if (empty($user) || empty($channel)) {
                    $returnMessage = array('message' => "User and channel must be given for the command /devoice");
                } else {
                    // Call command kick
                    $returningFunction = $commandLIB->devoice($user, $channel);

                    // Return message
                    $returnMessage = array('message' => $returningFunction);
                }
                break;
            // =========================== MODERATOR COMMANDS END =========================== //
   
            
            // =========================== MISC =========================== //
            default:
                // Whoops, something wrong?
                $returnMessage = array('message' => "Command $message not found. Please type /help for command overview.");
                break;
            // =========================== MISC END=========================== //
        }

        // If return message is filled
        if (!empty($returnMessage)) {
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