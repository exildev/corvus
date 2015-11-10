<?php

/**
 * Description of ForeignKey
 *
 * @author exile sas
 */
require_once Constraint_php;

class ForeignKey extends Constraint {

    private $columns;
    private $references;
    private $relation;

    function __construct($columns, $references, $relation) {
        $this->columns = $columns;
        $this->references = $references;
        $this->relation = $relation;
    }

    public function getColumns() {
        return $this->columns;
    }

    public function setColumns($columns) {
        $this->columns = $columns;
    }

    public function getReferences() {
        return $this->references;
    }

    public function setReferences($references) {
        $this->references = $references;
    }

    public function getRelation() {
        return $this->relation;
    }

    public function setRelation($relation) {
        $this->relation = $relation;
    }

    public function getQuery(Database $database) {
        return $database->foreignkey($this->columns, $this->relation, $this->references);
    }

}

?>
