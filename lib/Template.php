<?php

/** Šablona. */
class Template {
    
    /** Cesta k souboru. */
    protected $filename;
    
    /** Parametry. */
    protected $params = array();
    
    /** Vytvoří nový objekt šablony se zadaným jménem souboru. */
    public function __construct($filename) {
        $this->filename = $filename;
        
        // nastavení výchozích parametrů
    }
    
    
    /** Nastaví parametr šablony. */
    public function setParam($name, $value) {
        $this->params[$name] = $value;
    }
    
    /** Nastaví více parametrů šablony. */
    public function setParams($params) {
        if (!$params) return;
        foreach ($params as $name => $value) {
            $this->params[$name] = $value;
        }
    }
    
    /** Vykreslí šablonu. */
    public function render() {
        // nastavíme parametry jako globální proměnné
        foreach ($this->params as $name => $value) {
            $$name = $value;
        }
        
        include $this->filename;
    }
    
}