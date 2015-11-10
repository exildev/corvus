<?php

/**
 * Description of View
 *
 * @author exile sas
 */
require_once Form_php;
class View {

    const VALIDATE = 'validate_';
    const SET_METHOD = 'set';

    public function setForm(Form & $form, array $request) {
        $errors = array();
        $form->befor_set();
        $reflex = new ReflectionObject($form);
        $propts = $reflex->getParentClass()->getProperties();
        foreach ($propts as $propt) {
            $name = $propt->getName();
            $exis = method_exists($form, self::VALIDATE . $name);
            $value = isset($request[$name]) ? $request[$name] : null;
            $valid = self::VALIDATE . $name;
            $setvl = self::SET_METHOD . ucfirst($name);
            $respn = ($exis?$form->{$valid}($value):true);
            if ($respn === true) {
                if (method_exists($form, $setvl)) {
                    if ($value != null) {
                        $form->{$setvl}($value);
                    }
                } else {
                    if ($value != null) {
                        $propt->setAccessible(true);
                        $propt->setValue($form, $value);
                        $propt->setAccessible(false);
                    }
                }
            } else {
                $errors[$name] = $respn;
            }
        }
        $form->after_set();
        return count($errors) > 0 ? $errors : true;
    }

}

?>
