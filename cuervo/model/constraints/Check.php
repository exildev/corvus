<?php

/**
 * Description of Check
 *
 * @author exile sas
 */
require_once Constraint_php;

class Check extends Constraint{

    private $condition;

    function __construct($condition) {
        $this->condition = $condition;
    }

    public function getCondition() {
        return $this->condition;
    }

    public function setCondition($condition) {
        $this->condition = $condition;
    }

    public function getQuery(Database $database) {
        return $database->check($this->condition);
    }

}

?>
