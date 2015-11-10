<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RowType
 *
 * @author ubuntu
 */
require_once Database_php;

class RowType {

    private $type;

    public function __construct($type) {
        $this->type = $type;
    }

    public function getType() {
        return $this->type;
    }

}

?>
