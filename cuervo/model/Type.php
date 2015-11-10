<?php

/**
 * Description of Type
 *
 * @author exile sas
 */
class Type {
    private $value;
    function __construct($value) {
        $this->value = $value;
    }
    public function __toString() {
        return $this->value;
    }
}

class int extends Type{}
class varchar extends Type {}
class numeric extends Type {}

define('int', 'INT');
define('varchar', 'VARCHAR');
define('numeric', 'NUMERIC');
?>
