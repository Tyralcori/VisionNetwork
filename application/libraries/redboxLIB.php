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

        // Containers
        $seoData = array();
        $techData = array();

        $seoData = $this->makeAnalyse($dateWeek->format('Y-m-d'), $dateToday->format('Y-m-d'));

        // Get seo datas
        $seoData['logs'] = $this->getProfiles($dateWeek->format('Y-m-d'), $dateToday->format('Y-m-d'));

        // Get technical datas
        $techData['current'] = $this->getStats();

        // Returncontainer
        $return = array(
            'seo' => $seoData,
            'tech' => $techData,
        );
        
        // Return
        return $return;
    }

    // ================================== SEO PROFILING ================================== //
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
                    'AVG' => "SELECT AVG(timeLoad) as timeLoad FROM redbox WHERE time BETWEEN '{$from}%' AND '{$to}%'",
                    'LOWEST' => "SELECT (timeLoad) FROM redbox WHERE time BETWEEN '{$from}%' AND '{$to}%' ORDER BY timeLoad ASC LIMIT 1",
                    'HIGHEST' => "SELECT (timeLoad) FROM redbox WHERE time BETWEEN '{$from}%' AND '{$to}%' ORDER BY timeLoad DESC LIMIT 1",
                ),
                'all' => array(
                    'AVG' => "SELECT AVG(timeLoad) as timeLoad FROM redbox",
                    'LOWEST' => "SELECT (timeLoad) FROM redbox ORDER BY timeLoad ASC LIMIT 1",
                    'HIGHEST' => "SELECT (timeLoad) FROM redbox ORDER BY timeLoad DESC LIMIT 1",
                ),
            ),
            // User visits
            'userVisits' => array(
                'week' => array(
                    'byUser' => "SELECT COUNT(DISTINCT user) as count FROM redbox WHERE time BETWEEN '{$from}%' AND '{$to}%'",
                    'byIP' => "SELECT COUNT(DISTINCT ip) as count FROM redbox WHERE time BETWEEN '{$from}%' AND '{$to}%'",
                ),
                'all' => array(
                    'byUser' => "SELECT COUNT(DISTINCT user) as count FROM redbox",
                    'byIP' => "SELECT COUNT(DISTINCT ip) as count FROM redbox",
                ),
            ),
            // Popular Sites
            'sites' => array(
                'week' => array(
                    'LOWEST' => "SELECT site, COUNT(site) as count FROM redbox WHERE time BETWEEN '{$from}%' AND '{$to}%' GROUP BY site ORDER BY COUNT(site) ASC;",
                    'HIGHEST' => "SELECT site, COUNT(site) as count FROM redbox WHERE time BETWEEN '{$from}%' AND '{$to}%' GROUP BY site ORDER BY COUNT(site) DESC;",
                ),
                'all' => array(
                    'LOWEST' => "SELECT site, COUNT(site) as count FROM redbox GROUP BY site ORDER BY COUNT(site) ASC;",
                    'HIGHEST' => "SELECT site, COUNT(site) as count FROM redbox GROUP BY site ORDER BY COUNT(site) DESC;",
                ),
            ),
            // User Agents
            'userAgent' => array(
                'week' => array(
                    'LOWEST' => "SELECT userAgent, COUNT(userAgent) as count FROM redbox  WHERE time BETWEEN '{$from}%' AND '{$to}%' GROUP BY userAgent ORDER BY COUNT(userAgent) ASC;",
                    'HIGHEST' => "SELECT userAgent, COUNT(userAgent) as count FROM redbox  WHERE time BETWEEN '{$from}%' AND '{$to}%' GROUP BY userAgent ORDER BY COUNT(userAgent) DESC;",
                ),
                'all' => array(
                    'LOWEST' => "SELECT userAgent, COUNT(userAgent) as count FROM redbox GROUP BY userAgent ORDER BY COUNT(userAgent) ASC;",
                    'HIGHEST' => "SELECT userAgent, COUNT(userAgent) as count FROM redbox GROUP BY userAgent ORDER BY COUNT(userAgent) DESC;",
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
        if (!empty($resultContainer) && is_array($resultContainer)) {
            return $resultContainer;
        }

        return false;
    }

    // ================================== SEO PROFILING ================================== //
    // ================================== SERVER PROFILING ================================== //
    /**
     * Get stats from server / host
     * @param type $part
     * @return type
     */
    public function getStats($part = null) {
        // Tech stat container
        $statContainer = array();

        // JSON Request?
        $json = false;

        // If Ajax Request, return json format
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest") {
            $json = true;
        }

        // Execute special function, if parameter was given
        if (!empty($part)) {
            if (!function_exists($part)) {
                // Error message
                $message = "Function $part does'nt exists!";

                // Return message
                if (!$json) {
                    return $message;
                }
                echo json_encode(array('message' => $message));
                die();
            }

            // Function given, execute
            $statContainer[$part] = $this->$part();

            // Return message
            if (!$json) {
                return $message;
            }
            echo json_encode(array('message' => $message));
            die();
        }

        // If no parameter was given, execute ALL
        $functions = get_class_methods(new redboxLIB());

        // Foreach function
        foreach ($functions as $counter => $function) {
            // Check if server prefix is given
            if (substr_count($function, 'server_')) {
                // No function exists check need
                $statContainer[$function] = $this->$function();
            }
        }
        
        // All stats about the server
        return $statContainer;
    }

    /**
     * Return Hostname
     * @return type
     */
    private function server_getHostname() {
        return shell_exec('/bin/hostname');
    }

    /**
     * Return IP (internal, external, eth Adapter)
     * @return string
     */
    private function server_getIP() {
        // Internal IP Try
        exec('/bin/ip -oneline link show | /usr/bin/awk \'{print $2}\' | /bin/sed "s/://"', $result, $error);

        // If error, exec new command
        if ($error) {
            exec('/sbin/ifconfig | /bin/grep -B1 "inet addr" | /usr/bin/awk \'' .
                    '{ if ( $1 == "inet" ) { print $2 } else if ( $2 == "Link" ) { printf "%s:",$1 } }\' | /usr/bin/awk' .
                    ' -F: \'{ print $1","$3 }\'', $result);
        } else {
            // Explode on space (Expected lo,eth0)
            $result = implode(' ', $result);

            // Now use that list to get the ip-adresses
            exec(
                    'for interface in ' . $result . ';do for family in inet inet6;do /bin/ip -oneline -family $family addr show $interface | /bin/grep -v fe80 | /usr/bin/awk \'{print $2","$4}\';done;done'
                    , $result, $return_value);
        }

        // Get external adress by curl this adress
        exec('curl http://ipecho.net/plain; echo', $result2);

        // Set external ip
        $return = "externalIP=" . $result2[0];

        // Foreach result create return
        foreach ($result as $key => $value) {
            // Explode on , for recive parts pattern 
            $returnTemp = explode(',', $result[$key]);
            // Add to return
            $return .= ',' . $returnTemp[0] . '=' . $returnTemp[1];
            // Unset the result (clean)
            unset($result[$key], $value);
        }

        // Return the result
        return $return;
    }

    /**
     * Get System and Version
     * @return type
     */
    private function server_getSystem() {
        return shell_exec('/usr/bin/lsb_release -ds;/bin/uname -r');
    }

    /**
     * Get loadAVG foreach core
     * @param type $cores
     * @return type
     */
    private function server_getLoadAVG() {
        // First, get core count
        exec('/bin/grep -c ^processor /proc/cpuinfo', $getCores);
        $cores = $getCores[0];

        // Get loadAVG
        exec('/bin/cat /proc/loadavg | /usr/bin/awk \'{print $1","$2","$3}\'', $getAVG);
        $loadAvg = explode(',', $getAVG[0]);

        // Get avg by core
        return array_map(function($value, $cores) {
                    return array($value, (int) ($value * 100 / $cores));
                }, $loadAvg, array_fill(0, count($loadAvg), $cores));
    }

    /**
     * Get memory usage
     * @return type
     */
    private function server_getMemory() {
        // Get memory
        exec('/usr/bin/free -tmo | /usr/bin/awk \'{print $1","$2","$3-$6-$7","$4+$6+$7}\'', $result);

        // Set result
        $currentStats = explode(',', $result[1]);

        // Return pretty stats
        return array('all' => $currentStats[1], 'used' => $currentStats[2], 'free' => $currentStats[3]);
    }

    /**
     * Who is online?
     * @return type
     */
    private function server_online() {
        // Set env var - limit to 20 user
        putenv("PROCPS_USERLEN=20");

        // Get who - from - at - idle
        exec('/usr/bin/w -h | /usr/bin/awk \'{print $1","$3","$4","$5}\'', $users);

        // Container result
        $result = array();

        // Foreach user put into container
        foreach ($users as $user) {
            $result[] = explode(",", $user);
        }

        // Return the result
        return $result;
    }

    /**
     * Return process list
     * @return type
     */
    private function server_psAux() {
        // Get pxaus list
        exec('/bin/ps aux | /usr/bin/awk ' . "'NR>1{print " . '$1","$2","$3","$4","$5","$6","$7","$8","$9","$10","$11' . "}'", $result);

        // Container
        $processContainer = array();

        // Foreach result
        foreach ($result as $key => $process) {
            // Set into container
            $processContainer[] = explode(',', $result[$key]);
            // Unset
            unset($result[$key], $process);
        }

        // Return the process
        return $processContainer;
    }

    /**
     * Get serverspeed
     * @return type
     */
    private function server_getSpeed() {
        // Data to download
        $target = $_SERVER['HTTP_HOST'] . '/speedCheck.zip';

        // Create curl request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $target);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout = 10);

        // Execute
        curl_exec($ch);

        // Return speed
        return curl_getinfo($ch, CURLINFO_SPEED_DOWNLOAD);
    }

    /**
     * Return uptime
     * @return type
     */
    private function server_uptime() {
        $uptimeInMilliSeconds = shell_exec('/usr/bin/awk \'{print $1*1000}\' /proc/uptime');
        return ((int) $uptimeInMilliSeconds / (1000 * 60 * 60));
    }

    /**
     * Get all software
     * @return type
     */
    private function server_software() {
        // Get user
        exec('/usr/bin/awk -F: \'{ if ($3<=499) print "system,"$1","$6; else print "user,"$1","$6; }\' < /etc/passwd', $result);

        // User container
        $softwareContainer = array();

        // Foreach software result
        foreach ($result as $key => $user) {
            // Explode for pretty
            $line = explode(',', $user);

            // Add software in container
            $softwareContainer[] = $line;
        }

        // Return user list
        return $softwareContainer;
    }

    /**
     * Check software
     * @return type
     * @ToDo: Softwarelist by userinput?
     */
    private function server_checkSoftware() {
        // Get whereIs
        exec('/usr/bin/whereis php node mysql vim python ruby java apache2 nginx openssl vsftpd make' . '| /usr/bin/awk \'{ split($1, a, ":");if (length($2)==0) print a[1]",Not Installed"; else print a[1]","$2;}\'', $result);

        // Where container
        $whereIsContainer = array();
        
        // Foreach result
        foreach ($result as $key => $value) {
            // Set exlplode
            $currentValue = explode(',', $result[$key]);
            
            // Add into container
            $whereIsContainer[] = $currentValue;
            
            // Unset
            unset($result[$key]);
        }
        
        // Return container
        return $whereIsContainer;
    }

    // ================================== SERVER PROFILING ================================== //
}