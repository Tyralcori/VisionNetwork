<?php

/**
 * Global Configuration
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class globalconfig {

    /**
     * Returns the config
     * @return boolean
     */
    public function getConfig($part = null) {
        // Config
        // ToDo: Into database, please
        $config = array(
            'main' => array(
                'title' => 'Vision Network',
                'maintenance' => false,
                'server_name' => $_SERVER['SERVER_NAME'],
                'assetsURL' => $_SERVER['SERVER_NAME'] . '/assets',
                'assetsIMGURL' => $_SERVER['SERVER_NAME'] . '/assets/img',
                'assetsPLUGINSURL' => $_SERVER['SERVER_NAME'] . '/assets/plugins',
                'template' => 'default',
                'allowPrivateDebug' => true,
                'version' => '0.5.2',
                'profiling' => true,
            ),
            'profilePictures' => array(
                'profilePicturesPATH' => $_SERVER['DOCUMENT_ROOT'] . '/profilePic', 
                'allowedPictureExtension' => array('jpg','png'),
                'allowedPictureSize' => -1,
            ),
        );

        // Return special config parts
        if(!empty($part) && !empty($config[$part]) && is_array($config[$part])) {
            return $config[$part];
        }
        
        // Return complete config, if no special part needed
        return $config;
    }
}