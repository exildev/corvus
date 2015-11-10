<?php

/**
 * Description of Unique
 *
 * @author exile sas
 */
require_once Constraint_php;

class Unique extends Constraint {

    private $columns;

    function __construct($columns) {
        $this->columns = $columns;
    }

    public function getColumns() {
        return $this->columns;
    }

    public function setColumn($columns) {
        $this->columns = $columns;
    }

    public function getQuery(Database $database) {
        return $database->unique($this->columns);
    }

}

?>
