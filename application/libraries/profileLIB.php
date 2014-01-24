<?php

/**
 * default lib
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class profileLIB {

    /**
     * Get CI Instance in magic construct function
     */
    public function __construct() {
        $this->ci = & get_instance();
    }

    /**
     * Get user
     * @return boolean
     */
    public function show() {
        // If post user
        if (!empty($_POST) && !empty($_POST['user'])) {
            // If Ajax Request, return json format
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest") {
                $json = true;
            }

            // Default message
            $noInfos = array('message' => 'No infos about this user.');

            // Nice user
            $username = htmlspecialchars($_POST['user']);

            // Get userID
            $userID = $this->ci->db->query("SELECT `id` FROM login WHERE `username` = '{$username}'")->row()->id;

            if (!empty($userID)) {
                // Update visits +1
                $this->ci->db->query("UPDATE profiles SET visits = (visits+1) WHERE userID = '{$userID}'");

                // Get all profiles information
                $profileQuery = $this->ci->db->query("SELECT * FROM profiles WHERE userID = '{$userID}'");

                // If we have some infos
                if ($profileQuery->num_rows() > 0) {
                    // Get some infos about the user
                    // Profile Container
                    $profileContainer = array();

                    // Add some infos!
                    foreach ($profileQuery->result() as $key => $value) {
                        // Foreach Element in Object, add in container
                        foreach ($value as $keyInner => $valueInner) {
                            $profileContainer[$keyInner] = htmlspecialchars($valueInner);
                        }
                    }

                    // Return infos
                    if (!empty($profileContainer)) {
                        // Differential between json and normal request
                        if (!empty($json)) {
                            echo json_encode($profileContainer);
                            die();
                        } else {
                            return $profileContainer;
                        }
                    } else {
                        // Differential between json and normal request
                        if (!empty($json)) {
                            echo json_encode($noInfos);
                            die();
                        } else {
                            return $noInfos;
                        }
                    }

                    // No given infos
                    return false;
                }

                // Differential between json and normal request
                if (!empty($json)) {
                    echo json_encode($noInfos);
                    die();
                } else {
                    return $noInfos;
                }

                // User not found
                return false;
            }

            // Differential between json and normal request
            if (!empty($json)) {
                echo json_encode($noInfos);
                die();
            } else {
                return $noInfos;
            }
        }
    }

    /**
     * Edit your profile
     */
    public function edit() {

        $session = $this->ci->session->all_userdata();
        $userName = strtolower(htmlspecialchars($session['username']));
        $userID = $session['id'];

        // Update bio if given
        if (!empty($_POST['Bio'])) {
            $cleanBio = htmlspecialchars($_POST['Bio']);
            $this->ci->db->query("UPDATE profiles SET `bio` = '{$cleanBio}' WHERE userID = {$userID}");
        }

        // Avatar
        if (!empty($_FILES)) {
            $config = $this->ci->globalconfig->getConfig();
            $configPic = $config['profilePictures'];

            // Get image extension
            $infos = pathinfo($_FILES['avatarPicUnique']['name']);

            // Save to
            $hashedName = $this->getHashedName($userName);
            $file = $configPic['profilePicturesPATH'] . '/' . basename($hashedName) . '.' . $infos['extension'];
      
            // Invalid extension
            if (!in_array($infos['extension'], $configPic['allowedPictureExtension'])) {
                //return array('status' => 'failure', 'message' => 'Invalid extension.');
            }

            // Get filesize
            $fileSize = filesize($_FILES['avatarPicUnique']['tmp_name']);

            // Invalid filesize
            if ($fileSize > $configPic['allowedPictureSize'] && $configPic['allowedPictureSize'] != -1) {
                //return array('status' => 'failure', 'message' => 'Image is too large.');
            }

            // Move file
            if (move_uploaded_file($_FILES['avatarPicUnique']['tmp_name'], $file)) {
                //return array('status' => 'success', 'message' => 'Successfully uploaded.');
                $temp = basename($hashedName) . '.' . $infos['extension'];
                $this->ci->db->query("UPDATE profiles SET `avatar` = 'profilePic/{$temp}' WHERE userID = {$userID}");
            } else {
                //return array('status' => 'failure', 'message' => 'Whatever - something went wrong. Great.');
            }
        }
        $this->ci->load->helper('url');
        redirect('/', 'refresh'); // Attention, HTTPS LAYER!
        return true;
    }

    /**
     * Hash Username, return safe
     * @param type $name
     * @return boolean
     */
    private function getHashedName($name = null) {
        // If empty name, nothing to hash
        if (empty($name) || strlen($name) <= 0) {
            return false;
        }

        // Salt. Psst!!!
        $salt = "@oLfmæł€kgi0";
        // Hash it
        $newName = hash('sha256', $salt . $name);

        // Return hashed name
        return $newName;
    }

}