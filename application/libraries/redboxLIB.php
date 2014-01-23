<?php

/**
 * RedboxLIB Class
 * For a nice backend statistic overview
 * @author Alexander Czichelski <a.czichelski@elitecoder.eu> | NO PRIVATE SUPPORT
 * @version "soon"
 * @todo 
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class redboxLIB {

    /**
     * Get CI Instance in magic construct function
     */
    public function __construct() {
        $this->ci = & get_instance();
    }

    /**
     * Create RedBox
     * @return boolean
     */
    public function index() {
        // Get session
        $session = $this->ci->session->all_userdata();

        // Check super admin
        if (empty($session) || empty($session['globalPermission']) || $session['globalPermission'] < 99) {
            $this->ci->load->helper('url');
            redirect('/', 'refresh'); // Attention, HTTPS LAYER!
        }

        // Create time elapse
        $dateToday = new DateTime('now');
        $dateToday->modify('+1 day');
        $dateWeek = new DateTime('now');
        $dateWeek->modify('-7 days');

        // Container
        $datas = array();

        $datas = $this->makeAnalyse($dateWeek->format('Y-m-d'), $dateToday->format('Y-m-d'));

        // Get all datas
        $datas['logs'] = $this->getProfiles($dateWeek->format('Y-m-d'), $dateToday->format('Y-m-d'));

        // Return
        return $datas;
    }

    /**
     * Profile GETTER
     * @param type $from
     * @param type $to
     * @param type $user
     * @param type $limit
     * @return boolean
     */
    private function getProfiles($from, $to, $user = null, $limit = null) {
        // If date empty, return
        if (empty($from) || empty($to)) {
            return false;
        }

        // Later need maybe
        $additionalSQL = '';

        // Check, if user was given
        if (!empty($user)) {
            $additionalSQL .= " AND user = '{$user}'";
        }

        // If we have an limit, add to additional
        if (!empty($limit)) {
            $additionalSQL .= " LIMIT {$limit}";
        }

        // Query for reciving logs
        $queryRedBoxData = "SELECT * FROM redbox WHERE time BETWEEN '{$from}%' AND '{$to}%'" . $additionalSQL;
        $result = $this->ci->db->query($queryRedBoxData);

        // Container for all requests
        $dataContainer = array();

        // Add result in element container
        foreach ($result->result() as $key => $value) {
            // Foreach Element in Object, add in session
            foreach ($value as $keyInner => $valueInner) {
                $dataContainer[$key][$keyInner] = $valueInner;
            }
        }

        // If !empty, and is array, return infos
        if (!empty($dataContainer) && is_array($dataContainer)) {
            return $dataContainer;
        }

        // No infos
        return false;
    }

    /**
     * Make pretty analyse dash
     * @param type $from
     * @param type $to
     * @return boolean
     */
    private function makeAnalyse($from, $to) {
        // Mark starting
        $this->ci->benchmark->mark('ANALYSE_START');
        
        $getAnalyseArray = array(
            // timeload
            'timeLoad' => array(
                'week' => array(
                    'AVG' => "SELECT AVG(timeLoad) as week_AVG_timeload FROM redbox WHERE time BETWEEN '{$from}%' AND '{$to}%'",
                    'LOWEST' => "SELECT (timeLoad) FROM redbox WHERE time BETWEEN '{$from}%' AND '{$to}%' ORDER BY timeLoad ASC LIMIT 1",
                    'HIGHEST' => "SELECT (timeLoad) FROM redbox WHERE time BETWEEN '{$from}%' AND '{$to}%' ORDER BY timeLoad DESC LIMIT 1",
                ),
                'all' => array(
                    'AVG' => "SELECT AVG(timeLoad) as week_AVG_timeload FROM redbox",
                    'LOWEST' => "SELECT (timeLoad) FROM redbox ORDER BY timeLoad ASC LIMIT 1",
                    'HIGHEST' => "SELECT (timeLoad) FROM redbox ORDER BY timeLoad DESC LIMIT 1",
                ),
            ),
            // User visits
            'userVisits' => array(
                'week' => array(
                    'byUser' => "SELECT COUNT(DISTINCT user) FROM redbox WHERE time BETWEEN '{$from}%' AND '{$to}%'",
                    'byIP' => "SELECT COUNT(DISTINCT ip) FROM redbox WHERE time BETWEEN '{$from}%' AND '{$to}%'",
                ),
                'all' => array(
                    'byUser' => "SELECT COUNT(DISTINCT user) FROM redbox",
                    'byIP' => "SELECT COUNT(DISTINCT ip) FROM redbox",
                ),
            ),
            // Popular Sites
            'sites' => array(
                'week' => array(
                    'LOWEST' => "SELECT site, COUNT(site) FROM redbox WHERE time BETWEEN '{$from}%' AND '{$to}%' GROUP BY site ORDER BY COUNT(site) ASC;",
                    'HIGHEST' => "SELECT site, COUNT(site) FROM redbox WHERE time BETWEEN '{$from}%' AND '{$to}%' GROUP BY site ORDER BY COUNT(site) DESC;",
                ),
                'all' => array(
                    'LOWEST' => "SELECT site, COUNT(site) FROM redbox GROUP BY site ORDER BY COUNT(site) ASC;",
                    'HIGHEST' => "SELECT site, COUNT(site) FROM redbox GROUP BY site ORDER BY COUNT(site) DESC;",
                ),
            ),
            // User Agents
            'userAgent' => array(
                'week' => array(
                    'LOWEST' => "SELECT userAgent, COUNT(userAgent) FROM redbox  WHERE time BETWEEN '{$from}%' AND '{$to}%' GROUP BY userAgent ORDER BY COUNT(userAgent) ASC;",
                    'HIGHEST' => "SELECT userAgent, COUNT(userAgent) FROM redbox  WHERE time BETWEEN '{$from}%' AND '{$to}%' GROUP BY userAgent ORDER BY COUNT(userAgent) DESC;",
                ),
                'all' => array(
                    'LOWEST' => "SELECT userAgent, COUNT(userAgent) FROM redbox GROUP BY userAgent ORDER BY COUNT(userAgent) ASC;",
                    'HIGHEST' => "SELECT userAgent, COUNT(userAgent) FROM redbox GROUP BY userAgent ORDER BY COUNT(userAgent) DESC;",
                ),
            ),
        );
                  
        // Save all results
        $resultContainer = array();

        // Create the damn result
        // Foreach part (timeLoad|userVisits|..)
        foreach ($getAnalyseArray as $key => $partAnalyseArray) {
            // Sort between week and all
            foreach ($partAnalyseArray as $period => $Sort) {
                // Lowest or highest
                foreach ($Sort as $high_or_low => $QUERY) {
                    // Execute string
                    $result = $this->ci->db->query($QUERY);
                    // Write foreach result into array
                    foreach ($result->result() as $resultKey => $value) {
                        // Foreach Element in Object, add in container
                        foreach ($value as $keyInner => $valueInner) {
                            $resultContainer[$key][$period][$high_or_low][$resultKey][$keyInner] = $valueInner;
                        }
                    }
                }
            }
        }
        
        // Executed
        $this->ci->benchmark->mark('ANALYSE_END');
        
        // Calculate elapsed and add into container
        $resultContainer['executedAnalyse'] = $this->ci->benchmark->elapsed_time('ANALYSE_START', 'ANALYSE_END');

        // Check if empty and is array
        if(!empty($resultContainer) && is_array($resultContainer)) {
            return $resultContainer;
        }
        
        return false;
    }

}