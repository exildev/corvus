<?php
/**
 * Description of Condition
 *
 * @author exile sas
 */
require_once Query_php;
class Logic extends Query{

    const __or__ = 'OR';
    const __and__ = 'AND';
    private $operator;
    private $list;

    function __construct($operator, $list) {
        $this->operator = $operator;
        $this->list = $list;
    }
    
    /**
     * 
     * @return \Logic
     */
    public static function getInstance($operator, $list) {
        return new Logic($operator, $list);
    }


    /**
     * 
     * @return \Logic
     */
    public static function __or__($list) {
        return new Logic(self::__or__, $list);
    }

    /**
     * 
     * @return \Logic
     */
    public static function __and__($list) {
        return new Logic(self::__and__, $list);
    }

    public function getQuery(Database $database) {
        $list = array();
        foreach ($this->list as $value) {
            array_push($list, (is_string($value)?$value:"(" . ($value instanceof Query?$value->getQuery($database):$value ) . ")") );
        }
        return implode(" {$this->operator} ", $list);
    }

}


?>
