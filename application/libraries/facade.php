<?php

/**
 * FACADE PATTERN
 * @author Alexander Czichelski <a.czichelski@elitecoder.eu> | NO PRIVATE SUPPORT
 * @version "soon"
 * @todo Nothing to do here
 * @notice Currently not all libs support "get" by facade pattern. Please bear with me. Will integrate this later.
 */
class facade {
    /**
     * INSTANCE
     * @var type 
     */
    private $_instance;
    
    /**
     * Instance setter
     * @param type $instance
     */
    public function setInstance($instance) {
        $this->_instance = $instance;
    }
    
    /**
     * Instance getter
     * @return type
     */
    public function getInstance() {
        return $this->_instance;
    }
    
    /**
     * Return special "key" (propertie) in instance
     * @param type $key
     * @return type
     */
    public function get($key = null) {
        return $this->_instance->get($key);
    }
}
?>
