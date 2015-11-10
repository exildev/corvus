<?php

/**
 * Description of Persistence
 *
 * @author ubuntu
 */
require_once Persistence_php;
require_once Procedure_php;
require_once RowType_php;

class Controller {

    private static $make = false;

    public static function getInstance() {
        $class = get_called_class();
        if (!self::$make) {
            return new Persistence(new $class());
        }
        return new $class();
    }

}

?>
