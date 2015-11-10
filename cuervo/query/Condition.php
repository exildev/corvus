<?php

/**
 * Description of Condition
 *
 * @author exile sas
 */
require_once Query_php;
require_once Type_php;
class Condition extends Query{
    
    const __equ__ = '=';
    const __min__ = '<';
    const __may__ = '>';
    const __miq__ = '<=';
    const __maq__ = '>=';
    private $operator;
    private $left;
    private $right;

    function __construct($operator, $left, $right) {
        $this->operator = $operator;
        $this->left = $left;
        $this->right = $right;
    }
    
    public static function is_operator($operator){
        return $operator == self::__equ__ || $operator == self::__min__ || $operator == self::__may__ ||$operator == self::__miq__ ||$operator == self::__maq__ ;
    }
    
    /**
     * 
     * @return \Logic
     */
    public static function getInstance($operator, $left, $right) {
        return new Condition($operator, $left, $right);
    }

    /**
     * 
     * @return \Logic
     */
    public static function __equ__($left, $right) {
        return new Condition(self::__equ__, $left, $right);
    }

    /**
     * 
     * @return \Logic
     */
    public static function __min__($left, $right) {
        return new Condition(self::__min__, $left, $right);
    }
    /**
     * 
     * @return \Logic
     */
    public static function __may__($left, $right) {
        return new Condition(self::__may__, $left, $right);
    }
    /**
     * 
     * @return \Logic
     */
    public static function __miq__($left, $right) {
        return new Condition(self::__miq__, $left, $right);
    }
    /**
     * 
     * @return \Logic
     */
    public static function __maq__($left, $right) {
        return new Condition(self::__maq__, $left, $right);
    }
   
    
    public function getQuery(Database $database) {
        return ($this->left instanceof Query? $this->left->getQuery($database): $this->left) . " " . $this->operator . " " . ($this->is_object($this->right)?"(": "") . ($this->right instanceof Query? $this->right->getQuery($database): $this->right) . ($this->is_object($this->right)?")": "");
    }
    
    private function is_object($value){
        return is_object($value) && ! ($value instanceof Type);
    }

}

?>
