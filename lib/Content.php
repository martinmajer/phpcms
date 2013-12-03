<?php

/** Rozhraní pro obsah. */
interface Content {
    
    /** Vykreslí obsah. */
    public function render();
    
    /** Vrátí titulek. */
    public function getTitle();
    
    /** Vrátí meta tag description. */
    public function getMeta();
    
}