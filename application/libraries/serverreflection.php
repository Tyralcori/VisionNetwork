<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Serverreflection Class
 * This is the "simple" launcher class.
 * @author Alexander Czichelski <a.czichelski@elitecoder.eu> | NO PRIVATE SUPPORT
 * @version "soon"
 * @todo
 * => GET Function
 * ==> Server / Nodes from database
 */
class serverreflection {

    /**
     * Get CI Instance in magic construct function
     */
    public function __construct() {
        $this->ci = & get_instance();
    }

    /**
     * Returns the current serverlist
     * @return boolean
     */
    public function get() {
        // Serverlist
        $servers = array(
            0 => 'dev.ghost.de',
        );

        return $servers;
    }

    /**
     * pings all servers in the serverlist
     * @param type $servers
     * @return boolean
     * @version PROGRESS!
     */
    /** IN PROGRESS FUNCTION
    public function ping($servers = null) {
        // Check empty
        if (empty($servers) || !is_array($servers)) {
            return false;
        }

        // curl all server
        $onlineServerList = array();
        foreach ($servers as $key => $server) {
            $url = "$server/pong";
            // CREATE curl
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT_MS, 1000);
            
            // Execute curl
            $report = curl_getinfo($ch);
            $result = curl_exec($ch);

            // Set response
            $onlineServerList[$key] = array(
                'server' => $server,
                'report' => $report,
                'result' => $result,
            );

            curl_close($ch);
        }
        // return array
        return $onlineServerList;
    }
    */

}