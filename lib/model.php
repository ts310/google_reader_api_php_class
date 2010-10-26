<?php

class Model {

    public $name = null;
    public $table = null;
    public $db = null;
    public $columns = array();

    public function __construct() {
        $this->name = get_class($this);
        $this->db = new SQLiteDatabase('greader.db');
    }

    public function query($sql) {
        return $this->db->query($sql);
    }

    public function save($data = array()) {
        if (!empty($data)) {
            $columns = array();
            $values = array();
            foreach ($data as $column => $value) {
                $columns[] = $column;
                $values[] = sprintf("'%s'", sqlite_escape_string($value));
            }
            $sql = '';
            $sql .= sprintf('INSERT INTO %s ', $this->table);
            $sql .= sprintf('(%s) VALUES (%s);', implode(', ', $columns), implode(', ', $values));
            //debug($sql);
            return $this->query($sql);
        }       
    }

    public function find($type = 'all', $options = array()) {
        $sql = sprintf('SELECT rowid, * FROM %s', $this->table);
        $result = $this->query($sql);
        $rows = array();
        if ($result) {
            while ($row = $result->fetch(SQLITE_ASSOC)) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    public function drop() {
        return $this->query(sprintf('DROP TABLE %s;', $this->table));
    }

    public function createTable() {
        $columns = '';
        foreach ($this->columns as $key => $value) {
            $columns[] = sprintf('%s %s', $key, $value); 
        }
        $sql = sprintf('CREATE TABLE %s (%s);', $this->table, implode(', ', $columns));
        //debug($sql);
        return $this->query($sql);
    }

    public function truncate() {
        return $this->query(sprintf('DELETE FROM %s WHERE 1 = 1;', $this->table));
    }

    public function tableExists() {
        $sql = sprintf('SELECT COUNT(*) AS num FROM sqlite_master WHERE type=\'table\' AND name = \'%s\';', $this->table);
        $result = $this->query($sql);
        $row = $result->fetch(SQLITE_ASSOC);
        if (!empty($row['num']) && $row['num'] > 0) return true;
        return false;
    }
}
