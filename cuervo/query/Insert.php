<?php

/**
 * Description of Insert
 *
 * @author exile sas
 */
require_once ColumnManager_php;

class Insert extends Query {

    private $relation;
    private $columns = array();
    private $values = array();
    private $returning = array();
    private $into = array();

    public function __construct($relation) {
        $this->relation = $relation;
    }

    public function columns() {
        $number = func_num_args();
        for ($i = 0; $i < $number; $i++) {
            $column = ColumnManager::getColumn();
            $this->columns = array_merge(array($column), $this->columns);
        }
        return $this;
    }

    public function values() {
        $args = func_get_args();
        foreach ($args as $value) {
            $value = preg_replace("/(.)'(.)/i", '$1\\\'$2', $value);
            array_push($this->values, $value);
        }
        return $this;
    }

    /**
     * 
     * @return Select
     */
    public function select() {
        $this->values = new Select(func_num_args());
        return $this->values;
    }

    public function returning() {
        $number = func_num_args();
        for ($i = 0; $i < $number; $i++) {
            array_push($this->returning, ColumnManager::getColumn());
        }
        return $this;
    }

    public function into() {
        $this->into = array_merge($this->into, func_get_args());
        return $this;
    }

    public function getQuery(Database $database) {
        return $database->insert($this->relation, $this->columns, $this->values, $this->returning, $this->into);
    }

}

?>
