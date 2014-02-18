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
        // Profiling mark start
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

        // Check factory pattern
        if(file_exists(APPPATH . 'libraries/factory.php')) {
            // Get factory pattern
            require_once APPPATH . 'libraries/factory.php';
        
            // Create factory
            $factory = new factory($executer, $subexecuter);
             
           // Get output
            $output = $factory->getOutput();

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
        // Profiling mark end
        $this->benchmark->mark('VN_END');
        
        // Check, if profiling is allowed
        if(!empty($config['main']['profiling'])) {
            // If lib exists, load
            if(file_exists(APPPATH . 'libraries/factory.php')) {
                // Load profiler
                require_once APPPATH . 'libraries/profiler.php';
                
                // Set new profiler 
                $profiler = profiler::getInstance();
                
                // Create profile
                $profile = array(
                    'timeLoad' => $this->benchmark->elapsed_time('VN_START', 'VN_END'),
                    'user' => $options['userSession']['session_id'],
                    'ip' => $profiler->getUserIp(),
                    'userAgent' => $_SERVER['HTTP_USER_AGENT'],
                    'time' => date("Y-m-d H:i:s"),
                    'site' => $_SERVER['REQUEST_URI'],
                    'status' => $_SERVER['REDIRECT_STATUS'],
                    'port' => $_SERVER['SERVER_PORT'],
                );

                // Add profile
                $profiler->addProfile($profile);
            }
        }
        // ====================== Profiling ====================== //
        
        //var_dump($options);die();
        // ====================== OPTIONS MEETS TEMPLATE ====================== //
        // Load portal view with options we've setted
        $this->load->view('index', $options);
        // ====================== OPTIONS MEETS TEMPLATE ====================== //        
    }
}
