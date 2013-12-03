<?php

/** Třída pro načítání šablon. */
class TemplateLoader {
    
    /**
     * Vrátí šablonu na základě jména.
     * @param type $name
     * @return Template
     */
    public function getTemplate($name) {
        $name = str_replace("..", "", $name);
        $fullPath = TEMPLATE_DIR . "/" . $name . ".php";
        if (file_exists($fullPath)) return new Template($fullPath);
        else return null;
    }
    
    /**
     * Vrátí jména souborů s šablonami.
     * @return string[]
     */
    public function listTemplateFiles() {
        $files = glob(TEMPLATE_DIR . "/*.php");
        $files2 = array();
        foreach ($files as $f) {
            $f2 = substr(basename($f), 0, strlen(basename($f))-4); // odstranění přípony .php
            if ($f2 != "footer" && $f2 != "header") $files2[] = $f2;
        }
        return $files2;
    }
    
    
}