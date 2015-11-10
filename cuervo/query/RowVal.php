<?php

/**
 * Description of RowVal
 *
 * @author exile sas
 */
class RowVal {
    private $value;

    public function __construct($value) {
        $this->value = $value;
    }

    public function getValue() {
        return $this->value;
    }
}

?>
