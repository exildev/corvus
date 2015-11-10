<?php

/**
 * Description of Query
 *
 * @author exile sas
 */
require_once Query_php;
require_once Database_php;

class Select extends Query {

    private $select = array();
    private $from = array();
    private $where = null;
    private $group_by = array();
    private $order_by = array();
    private $limit = null;
    private $into = array();

    public function __construct($number = 0) {
        $this->__select__(!is_numeric($number) ? func_num_args() : $number);
    }

    private function __select__($number) {
        for ($i = 0; $i < $number; $i++) {
            $column = ColumnManager::getColumn();
            $this->select = array_merge(array($column), $this->select);
        }
    }

    public function select() {
        $this->__select__(func_num_args());
        return $this;
    }

    public function from() {
        $from = func_get_args();
        $this->from = array_merge($this->from, $from);
        return $this;
    }

    public function where($condition) {
        $this->where = $condition;
        return $this;
    }

    public function group_by() {
        $number = func_num_args();
        for ($i = 0; $i < $number; $i++) {
            array_push($this->group_by, ColumnManager::getColumn());
        }
        return $this;
    }

    public function order_by() {
        $number = func_num_args();
        for ($i = 0; $i < $number; $i++) {
            array_push($this->order_by, ColumnManager::getColumn());
        }
        return $this;
    }

    public function limit($index, $lenght) {
        $this->limit = array('index' => $index, 'lenght' => $lenght);
        return $this;
    }

    public function into() {
        $this->into = func_get_args();
        return $this;
    }

    public static function __join__($join, $left, $right, $condition = null) {
        return array('join' => $join, 'left' => $left, 'right' => $right, 'condition' => $condition);
    }

    public static function __aggregate__($name, $over = null) {
        $column = ColumnManager::getColumn();
        return ColumnManager::addColumn(array('name' => $name, 'column' => $column, 'over' => $over));
    }

    public static function __as__($alias) {
        $column = ColumnManager::getColumn();
        return ColumnManager::addColumn(array('column' => $column, 'alias' => $alias));
    }

    public function getQuery(Database $database) {
        return $database->select($this->from, $this->select, $this->where, $this->group_by, $this->order_by, $this->limit, $this->into);
    }

}

function j($left, $right, $condition) {
    return Select::__join__(Database::NATURAL, $left, $right, $condition);
}

function lj($left, $right, $condition) {
    return Select::__join__(Database::LEFT, $left, $right, $condition);
}

function rj($left, $right, $condition) {
    return Select::__join__(Database::RIGHT, $left, $right, $condition);
}

function cj($left, $right) {
    return Select::__join__(Database::CROSS, $left, $right);
}

function mx($column, $over = null) {
    $column = $column;
    return Select::__aggregate__("MAX", $over);
}

function mn($column, $over = null) {
    $column = $column;
    return Select::__aggregate__("MIN", $over);
}

function a($column, $alias) {
    $column = $column;
    return Select::__as__($alias);
}

?>
