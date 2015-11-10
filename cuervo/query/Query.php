<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Query
 *
 * @author exile sas
 */
abstract class Query {
    private static $numid = 0;
    private $id;
    
    public function __construct() {
        $this->id = self::$numid++;
    }
    public abstract function getQuery(Database $database);
    
    public function __toString() {
        return $this->id;
    }
}

?>
