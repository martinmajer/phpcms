<?php

/** Utilita pro stránkování. */
class Paginator {
    
    const PAGINATOR_KEY = "_page";
    
    private $count;
    
    private $itemsPerPage;
    
    public function __construct($itemsPerPage = 20) {
        $this->itemsPerPage = $itemsPerPage;
    }
    
    public function getCurrentPage() {
        $page = (int)param_get(self::PAGINATOR_KEY, false);
        if (!$page) $page = 1;
        return $page;
    }
    
    public function setCount($count) {
        $this->count = $count;
    }
    
    public function getSqlOffset() {
        return ($this->getCurrentPage() -1 ) * $this->itemsPerPage;
    }
    
    public function getSqlCount() {
        return $this->itemsPerPage;
    }
    
    public function getTotalPages() {
        return (int)((int)($this->count + $this->itemsPerPage - 1) / (int)$this->itemsPerPage);
    }
    
}