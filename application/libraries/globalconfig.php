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
    public function getConfig() {
        return array(
            'main' => array(
                'title' => 'Vision Network',
                'maintenance' => false,
                'server_name' => $_SERVER['SERVER_NAME'],
                'assetsURL' => $_SERVER['SERVER_NAME'] . '/assets',
                'assetsIMGURL' => $_SERVER['SERVER_NAME'] . '/assets/img',
                'assetsPLUGINSURL' => $_SERVER['SERVER_NAME'] . '/assets/plugins',
                'template' => 'default',
                'allowPrivateDebug' => true,
            ),
        );
    }
}