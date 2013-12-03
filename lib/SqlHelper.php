<?php

/** Utilita pro vytváření SQL dotazů. */
class SqlHelper {
    
    protected $table;
    
    /**
     * Vytvoří nový SQL helper pro zadanou tabulku.
     * @param string $table
     */
    public function __construct($table) {
        $this->table = $table;
    }
    
    /**
     * Načte data z tabulky.
     * @param string $fields seznam sloupců
     * @param string $where SQL podmínka
     * @param string $order SQL řazení
     * @param int $offset posunutí v LIMITu
     * @param int $count počet v LIMITu
     */
    public function select($fields = "*", $where = null, $order = null, $offset = null, $count = null) {
        $whereString = $where ? "WHERE $where" : "";
        $orderString = $order ? "ORDER BY $order" : "";
        $limitString = ($offset !== null && $count !== null) ? "LIMIT $offset, $count" : "";
        
        $sql = "SELECT $fields FROM $this->table $whereString $orderString $limitString";
        $result = db()->query($sql); /* @var $result mysqli_result */
        
        if (!$result) return null;
        
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        
        return $rows;
    }
    
    /**
     * Vloží data do tabulky.
     * @param mixed[] $data
     * @param boolean $returnId true, pokud se má vrátit ID
     * @return int ID nového záznamu
     */
    public function insert($data, $returnId = true) {
        $fields = "";
        $values = "";
        foreach ($data as $key => $val) {
            $escape = false;
            if (substr($key, strlen($key)-1) === "!") {
                $escape = true;
                $key = substr($key, 0, strlen($key)-1);
            }
            if ($escape) $val = "'" . db()->escape_string($val) . "'";
            if ($fields !== "") $fields .= ", ";
            if ($values !== "") $values .= ", ";
            $fields .= $key;
            $values .= $val;
        }
        $sql = "INSERT INTO $this->table ($fields) VALUES($values)";
        
        $result = db()->query($sql);
        if (!$result) return false;
        
        if ($returnId) return db()->insert_id;
        else return true;
    }
    
    /**
     * Aktualizuje data.
     * @param mixed[] $data
     * @param $where SQL podmínka
     * @return boolean true v případě úspěchu
     */
    public function update($data, $where) {
        $whereString = $where ? "WHERE $where" : "";
        $setData = "";
        foreach ($data as $key => $val) {
            $escape = false;
            if (substr($key, strlen($key)-1) === "!") {
                $escape = true;
                $key = substr($key, 0, strlen($key)-1);
            }
            if ($escape) $val = "'" . db()->escape_string($val) . "'";
            if ($setData !== "") $setData .= ", ";
            $setData .= "$key = $val";
        }
        $sql = "UPDATE $this->table SET $setData $whereString";
        
        $result = db()->query($sql);
        return $result != false;
    }
    
    /**
     * Smaže záznam.
     * @param $where SQL podmínka
     * @return boolean true v případě úspěchu
     */
    public function delete($where) {
        $whereString = $where ? "WHERE $where" : "";
        $sql = "DELETE FROM $this->table $whereString";
        $result = db()->query($sql);
        return $result != false;
    }
    
    /** Vrátí SQL podmínku pro hledání podle ID. */
    public function idWhere($id) {
        return "id = " . (int)$id;
    }
    
    
}