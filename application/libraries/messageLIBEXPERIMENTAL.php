<?php
// ================= !!!THIS LIB IS EXPERIMENTAL!!! =================
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

class messageLIBEXPERIMENTAL {

    /**
     * Get CI Instance in magic construct function
     */
    public function __construct() {
        $this->ci = & get_instance();
        // REDIS 
        ini_set('default_socket_timeout', -1);
        
        $redis = new Redis();
        $redis->pconnect('127.0.0.1', 6379);
    }

    /**
     * Subscribe
     * @param type $channel
     * @return type
     */
    public function subscribe($channel = null) {
        // Channel can not be empty
        if(empty($channel)) {
            return;
        }
        // Subscribe channel
        $redis->subscribe(array($channel), 'output');
    }
    
    /**
     * Prints output
     * @param type $redis
     * @param type $chan
     * @param type $msg
     */
    public function output($redis, $chan, $msg) {
    switch($chan) {
        case 'chan-1':
            print "get $msg from $chan\n";
            break;
        case 'chan-2':
            print "get $msg FROM $chan\n";
            break;
        case 'chan-3':
            break;
    }
}
    
    /**
     * Publish
     * @param type $channel
     * @param type $message
     * @return type
     */
    public function publish($channel = null, $message = null) {
        // If empty channel or empty message, return empty.. 
        if(empty($channel) || empty($message)) {
            return;
        }
        // Publish message in channel
        $redis->publish($channel, $message);
        $redis->close();
    }
}