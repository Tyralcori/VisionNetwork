<?php

/**
 * Avatar lib
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class avatarLIB {

    /**
     * Get CI Instance in magic construct function
     */
    public function __construct() {
        $this->ci = & get_instance();
    }

    /**
     * Dump session 
     * @return boolean
     */
    public function index() {
        // Make new name if exists
        if (!empty($_GET)) {
            $newName = htmlspecialchars($_GET['user']) ? htmlspecialchars($_GET['user']) : '';
        }
        // Call function, if new name
        if (!empty($newName)) {
            // Return picture, if exists
            $picturePretty = $this->getImageByName(strtolower(htmlspecialchars($_GET['user'])));
            if (!empty($picturePretty)) {
                return $picturePretty;
            }
        }
        // Whyever, return false.
        return false;
    }

    public function getImageByName($name = null) {
        // Empty name is not allowed
        // May return default picture?
        if (empty($name)) {
            return false;
        }

        // Get hashed name
        $specName = $this->getHashedName($name);

        // Get config for reciving picture path & extensions
        $config = $this->ci->globalconfig->getConfig();

        // Picture path
        $profilePicturePath = $config['profilePictures']['profilePicturesPATH'] ? $config['profilePictures']['profilePicturesPATH'] : '';

        // Get allowed extensions
        $allowedExtensions = $config['profilePictures']['allowedPictureExtension'] ? $config['profilePictures']['allowedPictureExtension'] : '';

        // Check, if extensions given and path too
        if ((!is_array($allowedExtensions) && empty($allowedExtensions)) || empty($profilePicturePath)) {
            return false;
        }

        // Deny double slash
        $tryLocateFileName = str_replace('//', '', $profilePicturePath . '/' . $specName);
        
        // Placeholder
        $foundFile = '';
        
        if (is_array($allowedExtensions)) {
            // Foreach given extension
            foreach ($allowedExtensions as $key => $extension) {
                if (is_file($tryLocateFileName . '.' . $extension)) {
                    $foundFile = $tryLocateFileName . '.' . $extension;
                }
                continue;
            }
        } else {
            // just one extension
            if (is_file($tryLocateFileName . '.' . $allowedExtensions)) {
                $foundFile = $tryLocateFileName . '.' . $allowedExtensions;
            }
        }
        
        // No image to the requested user
        if(empty($foundFile)) {
            return false;
        }
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