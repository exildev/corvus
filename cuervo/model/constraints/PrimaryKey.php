<?php

/**
 * Description of PrimaryKey
 *
 * @author exile sas
 */
require_once Constraint_php;

class PrimaryKey extends Constraint {

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
        return $database->primarykey($this->columns);
    }

}

?>
