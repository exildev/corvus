<?php

/**
 * Description of Relation
 *
 * @author exile sas
 */
require_once PersistenceModel_php;
require_once ColumnManager_php;
require_once Constraint_php;

abstract class Relation {

    private $contraints = array();

    public static function persistence() {
        return new PersistenceModel("", get_called_class());
    }

    public function check($condition) {
        array_push($this->contraints, Constraint::check($condition));
    }

    public function foreignkey($columns, $relation, $references) {
        array_push($this->contraints, Constraint::foreignkey($columns, $relation, $references));
    }

    public function primarykey() {
        array_push($this->contraints, Constraint::primarykey(func_num_args()));
    }

    public function unique() {
        array_push($this->contraints, Constraint::unique(func_num_args()));
    }

    public function getContraints() {
        return $this->contraints;
    }
    
    /**
     * 
     * @param string $class
     * @return Constraint
     */
    public function findConstraitn($class){
        foreach ($this->contraints as $contraint) {
            if (get_class($contraint) == $class){
                return $contraint;
            }
        }
        return null;
    }

}

?>
