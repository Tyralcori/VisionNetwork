<?php

/**
 * Profiler class (yes, this is a singleton)
 * @author Alexander Czichelski <a.czichelski@elitecoder.eu> | NO PRIVATE SUPPORT
 * @version "soon"
 * @todo Nothing to do here
 */
class profiler {

    /**
     * Instance object
     * @var type 
     */
    private static $_object = null;

    /**
     * Get instance - set if not setted yet
     * @return type
     */
    public static function getInstance() {#
        // Are you okay?
        if (is_null(self::$_object)) {
            self::$_object = new profiler;
        }

        // Return yourself
        return self::$_object;
    }

    /**
     * Redbox listing
     * @param type $profile
     * @return boolean
     */
    public function addProfile($profile = null) {
        // No empty profiles
        if (empty($profile) || !is_array($profile)) {
            return false;
        }

        // Check is valid
        $isValid = $this->filter($profile);

        // If valid profile, insert
        if (!empty($isValid)) {
            // Add profile into redbox
            $this->db->query("INSERT INTO redbox (timeLoad,user,ip,time,site,status,port,userAgent) VALUES 
            ('{$profile['timeLoad']}','{$profile['user']}','{$profile['ip']}','{$profile['time']}','{$profile['site']}','{$profile['status']}','{$profile['port']}','{$profile['userAgent']}')");
        }
    }

    /**
     * Filter profiles
     * @param type $profile
     * @return boolean
     */
    public function filter($profile = null) {
        // No empty profiles
        if (empty($profile) || !is_array($profile)) {
            return false;
        }

        // Define filter | ToDo: DB Integration
        $filter = array(
            'timeLoad' => array(),
            'user' => array(),
            'ip' => array('127.0.0.1',),
            'time' => array('0000-00-00 00:00:00',),
            'site' => array('/favicon.ico',),
            'port' => array(),
            'status' => array(),
            'userAgent' => array(),
        );

        // Foreach filter possible
        foreach ($profile as $key => $checkFilter) {
            if (!empty($filter[$key])) {
                if (in_array($checkFilter, $filter[$key])) {
                    return false;
                }
            }
        }

        // Everything is okay
        return true;
    }

    /**
     * For special statistic
     * @return type
     */
    public function getUserIp() {
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') > 0) {
                $addr = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']);
                return trim($addr[0]);
            } else {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

}

?>
