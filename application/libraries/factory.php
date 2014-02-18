<?php

/**
 * FACTORY PATTERN
 * @author Alexander Czichelski <a.czichelski@elitecoder.eu> | NO PRIVATE SUPPORT
 * @version "soon"
 * @todo Nothing to do here
 */
class factory {
    /**
     * Output
     * @var type 
     */
    private $_output;
    
    /**
     * Output setter
     * @param string $value
     */
    public function setOutput($value = null) {
        if(empty($value)) {
            $value = 'No return';
        }
        $this->_output = $value;
    }
    
    /**
     * Output getter
     * @return type
     */
    public function getOutput() {
        return $this->_output;
    }
    
    /**
     * Construct function - calls initLib for load and execute class
     * @param type $executer
     * @param string $subExecuter
     * @return boolean
     */
    public function __construct($executer = null, $subExecuter = null) {        
        // Must not be emtpy
        if(empty($executer)) {
            return false;
        }
        
        // Default action 'index'
        if(empty($subExecuter)) {
            $subExecuter = 'index';
        }
        
        // Start init
        $this->setOutPut(self::initLib($executer, $subExecuter));
    }
    
    /**
     * initLib function - execute a lib
     * @param type $executer
     * @param type $subExecuter
     * @return boolean
     */
    public static function initLib($executer, $subExecuter) {
        // Check if file exists
        if(!file_exists(APPPATH . 'libraries/' . $executer . '.php')) {
            return false;
        }
        
        // Load, if exists
        require_once APPPATH . 'libraries/' . $executer . '.php';
        
        // Declare class
        $internal = new $executer;

        // Execute lib, if subExecuter exists
        if(method_exists($internal, $subExecuter)) {
            return $internal->$subExecuter();
        // No subexecuter Execute index
        } elseif(method_exists($internal, 'index')) {
            return $internal->index();
        }
        
        // Return false, something went wrong
        return false;
    }
}
?>
