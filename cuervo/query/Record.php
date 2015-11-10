<?php

/**
 * Description of Record
 *
 * @author exile sas
 */
class Record {
    private $rowtype;
    
    public function __construct(ReflectionClass $rowtype) {
        $this->rowtype = $rowtype;
    }
    
    
}

?>
