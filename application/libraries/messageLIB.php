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
        // REDIS 
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
        $redis->subscribe(array($channel), 'f');
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