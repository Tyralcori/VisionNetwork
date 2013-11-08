<?php

/**
 * UserLib Class
 * Handles user Login/Logout/Signup/ and many more
 * @author Alexander Czichelski <a.czichelski@elitecoder.eu> | NO PRIVATE SUPPORT
 * @version "soon"
 * @todo Nothing to do here
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class userLIB {

    /**
     * Get CI Instance in magic construct function
     */
    public function __construct() {
        $this->ci = & get_instance();
    }

    /**
     * Login Function
     */
    public function login() {
        // Declares 2 possible status
        $invalidLogin = array('status' => 'failure', 'message' => 'Invalid Login');
        $successLogin = array('status' => 'success', 'message' => 'Logged In');
        // Set post
        $post = $this->ci->input->post();
        // Check if is empty or not        
        if (empty($post['user']) || empty($post['pass'])) {
            return $invalidLogin;
        }
        // Hash the given password
        $post['pass'] = $this->hashPasword($post['pass']);
        // Select the user by input
        $queryUser = $this->ci->db->query("SELECT * FROM login WHERE password = '{$post['pass']}' AND (email LIKE '{$post['user']}' OR username LIKE '{$post['user']}')");
        if ($queryUser->num_rows() > 0) {
            // User found, update lastlogin
            $queryUpdate = $this->ci->db->query("UPDATE login SET lastlogin = NOW() WHERE password = '{$post['pass']}' AND (email LIKE '{$post['user']}' OR username LIKE '{$post['user']}')");
            // Set session data
            foreach ($queryUser->result() as $key => $value) {
                // Elements, we don't need in session
                $denyList = array('password', );
                // Foreach Element in Object, add in session
                foreach($value as $keyInner => $valueInner) {
                    if(!in_array($keyInner, $denyList)) {
                        $userData[$keyInner] = $valueInner;
                    }
                }
            }
            // Write session data
            $this->ci->session->set_userdata($userData);
            // Load helper for redirect
            $this->ci->load->helper('url');
            redirect('/', 'refresh'); // Attention, HTTPS LAYER!
            // Return success Login
            return $successLogin;
        } else {
            // No user found, return invalid login
            return $invalidLogin;
        }
    }

    /**
     * 
     */
    public function newAccount() {
        // Set post
        $post = $this->ci->input->post();
        // Error Collector
        $validationErrors = array();

        // Stop printing invalid messages
        if (empty($post)) {
            return false;
        }
        // Validate it
        // Make some vars sure
        $post['user'] = mysql_real_escape_string($post['user']) ? mysql_real_escape_string($post['user']) : '';
        $post['pass'] = mysql_real_escape_string($post['pass']) ? mysql_real_escape_string($post['pass']) : '';
        $post['email'] = mysql_real_escape_string($post['email']) ? mysql_real_escape_string($post['email']) : '';

        // AGBS?
        if (empty($post['agb'])) {
            $validationErrors['registration'][] = array('agb' => 'Please accept the AGBs!');
        }
        // Is email okay?
        if (empty($post['email']) || !filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
            $validationErrors['registration'][] = array('email' => 'Enter a valid E-Mail');
        }
        // Password matches second password and is not empty?
        if (empty($post['pass']) || empty($post['passConfirm']) || $post['pass'] != $post['passConfirm']) {
            $validationErrors['registration'][] = array('passwords' => 'Passwords does not match');
        }
        // Password has more than 5 Charakters?
        if (strlen($post['pass']) <= 5) {
            $validationErrors['registration'][] = array('passwordLength' => 'Password needs more than 5 Charakter');
        }
        // Is the username empty?
        if (empty($post['user'])) {
            $validationErrors['registration'][] = array('user' => 'Enter a username');
        }
        // Has the username more than 2 Charakters?
        if (strlen($post['user']) <= 2) {
            $validationErrors['registration'][] = array('userLength' => 'Username needs more than 2 Charakter');
        }
        // Is the username given?
        $queryUser = $this->ci->db->query("SELECT * FROM login WHERE username LIKE '{$post['user']}'");
        if ($queryUser->num_rows() > 0) {
            $validationErrors['registration'][] = array('userGiven' => 'Username already exists');
        }
        // Is the email given?
        $queryEmail = $this->ci->db->query("SELECT * FROM login WHERE email LIKE '{$post['email']}'");
        if ($queryEmail->num_rows() > 0) {
            $validationErrors['registration'][] = array('emailGiven' => 'E-Mail already exists');
        }
        //var_dump($validationErrors);die();
        // Errors? All okay?
        if (count($validationErrors) !== 0) {
            return $validationErrors;
        } else {
            // Hash Password before insert!
            $post['pass'] = $this->hashPasword($post['pass']);
            // Insert Account
            $queryInsert = $this->ci->db->query("INSERT INTO login (email,password,username,firstlogin,lastlogin,banned) VALUES ('{$post['email']}','{$post['pass']}','{$post['user']}',NOW(),NOW(),0)");
            // Its done
            return array('registration' => array('done' => 'Registerd successfully. You can now login!'));
        }
    }

    /**
     * This function hashes the password by input
     */
    public function hashPasword($input = null) {
        // If empty there is nothing to hash
        if (empty($input)) {
            return false;
        }
        // Salt. Psst!!!
        $salt = "NMæſđamt3qkfáw";
        // Hash it
        $pass = hash('sha256', $salt . $input);
        // Return hashed password
        return $pass;
    }

    /**
     * LOGOUT
     */
    public function logout() {
        $this->ci->session->sess_destroy();
    }

}