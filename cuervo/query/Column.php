<?php

/**
 * Description of Column
 *
 * @author ubuntu
 */
class Column {

    private $parent;
    private $name;

    function __construct($parent, $name) {
        $this->parent = $parent;
        $this->name = $name;
    }

    public function getParent() {
        return $this->parent;
    }

    public function setParent($parent) {
        $this->parent = $parent;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }
    
    public function __toString() {
        return "{$this->parent}.{$this->name}";
    }

}

?>
