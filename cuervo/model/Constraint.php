<?php

/**
 * Description of Constraint
 *
 * @author exile sas
 */
require_once Query_php;
require_once Database_php;
require_once Check_php;
require_once ForeignKey_php;
require_once PrimaryKey_php;
require_once Unique_php;

abstract class Constraint extends Query {

    public static function check($condition) {
        return new Check($condition);
    }

    public static function foreignkey($columns, $relation, $references) {
        return new ForeignKey($columns, $references, $relation);
    }

    public static function primarykey($columns) {
        return new PrimaryKey(g($columns));
    }

    public static function unique($columns){
        return new Unique(g($columns));
    }
}


?>
