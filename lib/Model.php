<?php

/** Abstraktní třída pro záznamy v databázi. */
abstract class Model {
    
    /** 
     * ID prvku. Nulové ID znamená, že prvek ještě nebyl zapsaný do databáze.
     * @var int
     */
    public $id = 0;
    
    
    /** Naplní záznam surovými daty z databáze. */
    public abstract function load($rawData);
    
    
    /**
     * Uloží záznam do databáze. Pokud neexistuje, vytvoří nový, jinak provede aktualizaci.
     */
    public function save() {
        if ($this->id == 0) return $this->saveNew();
        else return $this->update();
    }
    
    /**
     * Vytvoří nový záznam v databázi.
     */
    public abstract function saveNew();
    
    /**
     * Aktualizuje stávající záznam v databázi.
     */
    public abstract function update();
    
    /**
     * Odstraní záznam z databáze.
     */
    public abstract function delete();
    
}


/** Pomocná továrna pro záznamy v databázi. */
abstract class ModelFactory {
    
    /** 
     * Vytvoří nový prázdný záznam.
     * @return Model
     */
    public abstract function makeNew();
    
    /** 
     * Načte záznam z databáze podle ID.
     * @return Model
     */
    public abstract function loadSingle($id);
    
    /**
     * Načte kolekci záznamů podle zadaných parametrů.
     * @param string $where SQL kód podmínky
     * @param string $order SQL řazení (sloupec a způsob)
     * @param int $offset posunutí v MySQL LIMITu
     * @param int $count počet záznamů v MySQL LIMITu
     * @return Model[]
     */
    public abstract function loadCollection($where = null, $order = null, $offset = null, $count = null);
    
    /**
     * Vrátí počet záznamů v kolekci.
     * @param string $where SQL kód podmínky
     * @return int
     */
    public abstract function getCount($where = null);
    
}

/** Pomocná třída pro načítání dat. */
class ModelFactoryHelper {
    
    protected $factory;
    protected $table;
    
    public function __construct($factory, $table) {
        $this->factory = $factory;
        $this->table = $table;
    }
    
    /** Základní implementace načítání kolekce dat. */
    public function simpleLoadCollection($where = null, $order = null, $offset = null, $count = null) {
        $sqlHelper = new SqlHelper($this->table);
        $rows = $sqlHelper->select("*", $where, $order, $offset, $count);
        if ($rows === null) return null;
        $entries = array();
        foreach ($rows as $row) {
            $newEntry = $this->factory->makeNew();
            $newEntry->load($row);
            $newEntry->id = $row['id'];
            $entries[$row['id']] = $newEntry;
        }
        return $entries;
    }
    
    /** Základní implementace načítání jednoho řádku. */
    public function simpleLoadSingle($id) {
        $sqlHelper = new SqlHelper($this->table);
        $rows = $sqlHelper->select("*", "id = " . (int)$id);
        if (!$rows) return null;
        $row = $rows[0];
        $newEntry = $this->factory->makeNew();
        $newEntry->load($row);
        $newEntry->id = $row['id'];
        return $newEntry;
    }
    
    /** Základní implementace načítání počtu. */
    public function simpleGetCount($where = null) {
        $sqlHelper = new SqlHelper($this->table);
        $rows = $sqlHelper->select("COUNT(*) AS _cnt", $where);
        if (!$rows) return false;
        $row = $rows[0];
        return (int)$row['_cnt'];
    }
    
}