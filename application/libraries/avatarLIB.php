<?php

/**
 * AvatarLIB Class
 * Recreates the given image
 * @author Alexander Czichelski <a.czichelski@elitecoder.eu> | NO PRIVATE SUPPORT
 * @version "soon"
 * @todo 
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

    /**
     * Get image by name and recreates the image
     * @param type $name
     * @return boolean
     */
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
        if (empty($foundFile)) {
            return false;
        }

        // Get infos about the image
        $imageInfos = $this->getImageInfos($foundFile);

        $size = array(
            'height' => (int) ($imageInfos[0] ? $imageInfos[0] : 150),
            'width' => (int) ($imageInfos[1] ? $imageInfos[1] : 150),
        );

        // Set mime
        $mime = $imageInfos['mime'] ? $imageInfos['mime'] : 'image/' . $extension;

        // Get extension
        $finalExtension = explode('/', $mime);

        // Set mime
        header("Content-type: $mime");

        // Switch on extension
        switch ($finalExtension[1]) {
            case 'jpeg':
            case 'jpg':
                $im = imagecreatefromjpeg($foundFile);
                imagecopy($im, $im, $size['height'], $size['width'], 10, 10, 40, 40);
                imagejpeg($im);
                break;
            case 'png':
            default:
                $im = imagecreatefrompng($foundFile);
                imagecopy($im, $im, $size['height'], $size['width'], 10, 10, 40, 40);
                imagepng($im);
                break;
        }
        // Destroy image
        imagedestroy($im);
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

    /**
     * Return infos about image (Currently size and mime only)
     * @param type $pathToImage
     * @return boolean
     */
    private function getImageInfos($pathToImage = null) {
        // Image must not be empty and must be found
        if (empty($pathToImage) || !file_exists($pathToImage)) {
            return false;
        }

        // Get image size
        $imageSize = getimagesize($pathToImage);

        // Check and return
        if (!empty($imageSize) && is_array($imageSize)) {
            return $imageSize;
        }

        return false;
    }

}