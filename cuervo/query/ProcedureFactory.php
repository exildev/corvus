<?php

/**
 * Description of ProcedureFactory
 *
 * @author ubuntu
 */
require_once Procedure_php;
require_once Type_php;
require_once RowVal_php;
require_once Query_php;

class ProcedureFactory {

    public static function getProcedure($object, ReflectionMethod $method) {
        $procedure = new Procedure($method->getName());
        $args = $method->getParameters();
        $list = array(&$procedure);
        foreach ($args as $key => $arg) {
            if ($key > 0) {
                $type = $arg->getClass();
                array_push($list, $type->newInstanceArgs(array($arg->getName())));
                $typ = constant($type->name);
                $procedure->args(array('name' => $arg->getName(), 'type' => $typ, 'default' => ($arg->isOptional() ? $arg->getDefaultValue() : null)));
            }
        }
        $return = $method->invokeArgs($object, $list);
        if (!($return instanceof Query)) {
            $returns = $procedure->findType($return);
            $procedure->returns($returns);
            if ($returns instanceof RowType) {
                $return = new RowVal($return);
            }
        }
        
        
        $procedure->return_val($return);
        return $procedure;
    }

    public static function getProcedures($object) {
        $reflect = new ReflectionObject($object);
        $methods = $reflect->getMethods();
        $procedures = array();
        foreach ($methods as $method) {
            if (!$method->isConstructor() && !$method->isStatic()) {
                array_push($procedures, self::getProcedure($object, $method));
            }
        }
        return $procedures;
    }

}

?>
