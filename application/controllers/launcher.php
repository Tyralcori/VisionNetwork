<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Berlin');

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Launcher Class
 * This is the "simple" launcher class.
 * @author Alexander Czichelski <a.czichelski@elitecoder.eu> | NO PRIVATE SUPPORT
 * @version "soon"
 * @todo Nothing to do here
 */
class launcher extends CI_Controller {

    /**
     * _globalViewOptions
     * includes all View Elements
     * @var type 
     */
    public $_globalViewOptions = array();

    /**
     * Getter Setter | _globalViewOptions
     * @param type $value
     * @return type
     */
    public function getset_globalViewOptions($value = null) {
        if (!empty($value)) {
            $this->_globalViewOptions = $value;
        }
        return $this->_globalViewOptions;
    }

    /**
     * Index Action
     * @param type $page
     */
    public function index($page = null, $subpage = null) {
        // ====================== Profiling ====================== //
        $this->benchmark->mark('VN_START');
        // ====================== Profiling ====================== //

        
        // ====================== OPTIONS ====================== //
        // Call options - give this array to the template
        $options = array();
        // ====================== OPTIONS ====================== //
        
        
        // ====================== CHECK OUTER ====================== //
        if (isset($_GET) && isset($_GET['out']) && !empty($_GET['out'])) {
            // My gawd, outer link
            $options['outerLink'] = htmlspecialchars($_GET['out']);
        }
        // ====================== CHECK OUTER ====================== //

        
        // ====================== GLOBAL CONFIG ====================== //
        // Load the config 
        $this->load->library('globalconfig');
        $config = $this->globalconfig->getConfig();
        // ====================== GLOBAL CONFIG ====================== //
        
        
        // ====================== GET SERVERLIST ====================== //
        // $this->load->library('serverreflection');
        //$onlineServer = $this->serverreflection->get();
        // ====================== GET SERVERLIST ====================== //
       
        
        // ====================== LIBS ====================== //
        // Load important LIBS
        $this->load->library('session');
        $this->load->database(); // Make sure, that you IMPORT the main.sql - without it won't work.
        // ====================== LIBS ====================== //
                

        // ====================== SET SESSION ====================== //
        // SESSION refresh and write into model
        $options['user'] = array();


        $session = $this->session->all_userdata();
        $options['userSession'] = $session ? $session : '';

        if (!empty($options['userSession']['id'])) {
            // Get channels
            if (file_exists(APPPATH . 'libraries/channelLIB.php')) {
                require_once APPPATH . 'libraries/channelLIB.php';
                // Check, if user is connected to some channels
                $channelLib = new channelLIB();
                $return = $channelLib->getChannelAll($options['userSession']['id']);
                if (!empty($return) && is_array($return) && ($page == 'user' || empty($page)) && $subpage != 'logout') {
                    // We have some channels, so show them                
                    $page = 'channel';
                }
            }
        }
        // ====================== SET SESSION ====================== //
        
        
        // ====================== TEMPLATE MANAGER ====================== //
        // Load template
        // $this->load->library('templatemanager'); # In Progress
        // ====================== TEMPLATE MANAGER ====================== //
        

        // ====================== CREATING OPTIONS ====================== //
        // Set server name / title / etc.
        foreach ($config['main'] as $key => $singleConfig) {
            $options[$key] = $singleConfig ? $singleConfig : false;
        }
        // ====================== CREATING OPTIONS ====================== //
        
        
        // ====================== SITE LOADER ====================== //
        // Set page
        $existingPage = '';
        if (!empty($page) && file_exists(APPPATH . '/views/CONTENT/' . $page . '.php')) {
            $existingPage = $page;
        }
        $options['page'] = $existingPage ? $existingPage : 'default';

        // Set subpage
        $existingSubPage = '';
        if (!empty($subpage) && file_exists(APPPATH . '/views/ELEMENTS/' . $subpage . '.php')) {
            $existingSubPage = $subpage;
        }

        $options['subpage'] = $existingSubPage ? $existingSubPage : 'norender';
        // ====================== SITE LOADER ====================== //
        
        
        // ====================== ACTION LIB LOADER ====================== //
        // Execute page lib
        $executer = $options['page'] . 'LIB';

        $subexecuter = $options['subpage'];
        if ($options['subpage'] != $subpage) {
            $subexecuter = $subpage;
        }

        // Load and execute libs | functions
        if (!empty($executer) && file_exists(APPPATH . 'libraries/' . $executer . '.php')) {
            require_once APPPATH . 'libraries/' . $executer . '.php';
            $siteAction = new $executer;
            if (!empty($subexecuter) && method_exists($siteAction, $subexecuter)) {
                $output = $siteAction->$subexecuter();
            } elseif (method_exists($siteAction, 'index')) {
                $output = $siteAction->index();
            }

            // When we have an return, put it into output
            if (!empty($output)) {
                if(!empty($subexecuter)) {
                    $options[str_replace('LIB', '', $executer)][$subexecuter] = $output;
                } else {
                    $options[str_replace('LIB', '', $executer)] = $output;
                }
                
            }
        }

        // Try session refresh after executer
        $options['userSession'] = $this->session->all_userdata();
        // ====================== ACTION LIB LOADER ====================== //
        
        
        // ====================== OPTION SETTER ====================== //
        // SET options in Public Element
        $this->getset_globalViewOptions($options);
        // ====================== OPTION SETTER ====================== //      
        
        
        // ====================== Profiling ====================== //
        $this->benchmark->mark('VN_END');

        // Create profile
        $profile = array(
            'timeLoad' => $this->benchmark->elapsed_time('VN_START', 'VN_END'),
            'user' => $options['userSession']['session_id'],
            'ip' => $this->getUserIp(),
            'userAgent' => $_SERVER['HTTP_USER_AGENT'],
            'time' => date("Y-m-d H:i:s"),
            'site' => $_SERVER['REQUEST_URI'],
            'status' => $_SERVER['REDIRECT_STATUS'],
            'port' => $_SERVER['SERVER_PORT'],
        );
        
        // Add profile
        $this->addProfile($profile);
        // ====================== Profiling ====================== //
        
        //var_dump($options);die();
        // ====================== OPTIONS MEETS TEMPLATE ====================== //
        // Load portal view with options we've setted
        $this->load->view('index', $options);
        // ====================== OPTIONS MEETS TEMPLATE ====================== //        
    }

    /**
     * Redbox listing
     * @param type $profile
     * @return boolean
     */
    private function addProfile($profile = null) {
        // No empty profiles
        if(empty($profile) || !is_array($profile)) {
            return false;
        }
        
        // Check is valid
        $isValid = $this->filter($profile);
        
        // If valid profile, insert
        if(!empty($isValid)) {
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
    private function filter($profile = null) {
        // No empty profiles
        if(empty($profile) || !is_array($profile)) {
            return false;
        }
        
        // Define filter | ToDo: DB Integration
        $filter = array(
            'timeLoad' => array(),
            'user' => array(),
            'ip' => array('127.0.0.1', ),
            'time' => array('0000-00-00 00:00:00', ),
            'site' => array('/favicon.ico', ),
            'port' => array(),
            'status' => array(),
            'userAgent' => array(),
        );
        
        // Foreach filter possible
        foreach($profile as $key => $checkFilter) {
            if(!empty($filter[$key])) {
                if(in_array($checkFilter, $filter[$key])) {
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
    private function getUserIp() {
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
