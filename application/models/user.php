<?php

/**
 * User Model
 * @author Alexander Czichelski <a.czichelski@elitecoder.eu>
 */
class User extends CI_Model {

    /**
     * simple construct - this is magic
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * returns Username
     * @return string
     */
    public function getUserName() {
        $username = $this->session->userdata('username') ? $this->session->userdata('username') : false;
        return $username;
    }

    /**
     * Returns full Session
     * @return type
     */
    public function returnSession() {
        return $this->session->all_userdata();
    }

    /**
     * Logut process
     * @return boolean
     */
    public function logout() {
        // Session Destroy
        $this->session->sess_destroy();
        return true;
    }

    /**
     * Login Process
     * @param type $user
     * @param type $pass
     * @return type
     */
    public function login($user, $pass) {
        $datas = array(
            'user' => $user,
            'pass' => $pass,
        );
        $this->session->set_userdata($datas);
        $this->returnSession();
    }

}

?>
