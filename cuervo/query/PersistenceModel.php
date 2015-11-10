<?php

/**
 * Description of PersistenceModel
 *
 * @author exile sas
 */
require_once Condition_php;
require_once Logic_php;
require_once ColumnManager_php;

class PersistenceModel {

    private static $conditions = array();
    private $relation;
    private $name;

    function __construct($relation, $name) {
        $this->relation = strtolower($relation);
        $this->name = strtolower($name);
    }

    public static function addCondition($condition) {
        array_push(self::$conditions, $condition);
        return $condition;
    }

    public static function getCondition() {
        return array_pop(self::$conditions);
    }

    public function setRelation($relation) {
        $this->relation = strtolower($relation);
    }

    public static function __or__($number) {
        $list = array();
        for ($i = 0; $i < $number; $i++) {
            array_push($list, self::getCondition());
        }
        return self::addCondition(Logic::__or__($list));
    }

    public static function __and__($number) {
        $list = array();
        for ($i = 0; $i < $number; $i++) {
            array_push($list, self::getCondition());
        }
        return self::addCondition(Logic::__and__($list));
    }

    public static function __c__() {
        $right = self::getCondition();
        return self::addCondition($right);
    }

    public function __set($name, $value) {
        if ($value instanceof PersistenceModel) {
            $value = ColumnManager::getColumn();
        } else
        if (is_string($value)) {
            $value = preg_replace("/(.)'(.)/i", '$1\\\'$2', $value);
        }


        if (Condition::is_operator($name)) {
            self::addCondition(Condition::getInstance($name, $this->relation_name, $value));
        } else {
            $fullname = ($this->relation ? "{$this->relation}." : "") . ($this->name ? "{$this->name}." : "") . $name;
            self::addCondition(Condition::__equ__($fullname, $value));
        }
    }

    public function __get($name) {
        $fullname = ($this->relation ? "{$this->relation}." : "") . ($this->name ? "{$this->name}" : "");
        return ColumnManager::addColumn(new PersistenceModel($fullname, $name));
    }

    public function __toString() {
        $fullname = ($this->relation ? "{$this->relation}." : "") . ($this->name ? "{$this->name}" : "");
        return $fullname;
    }

    public function getRelation() {
        return $this->relation;
    }

    public function getName() {
        return $this->name;
    }

}

function o($left, $right) {
    $left = $right;
    return PersistenceModel::__or__(func_num_args());
}

function y($left, $right) {
    $left = $right;
    return PersistenceModel::__and__(func_num_args());
}

function c($right) {
    $right = $right;
    return PersistenceModel::__c__();
}

?>