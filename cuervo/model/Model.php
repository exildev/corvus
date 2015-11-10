<?php

/**
 * Description of Model
 *
 * @author exile sas
 */
require_once Relation_php;
require_once ManyToMany_php;
require_once RelationFactory_php;

abstract class Model extends Relation {

    private $weaks_entitys = array();

    public function __construct() {
        $this->constraint(self::persistence());
    }

    public abstract function constraint($self);

    public function weak_entity(RelationFactory & $factory) {
        foreach ($this->weaks_entitys as $weak) {
            $factory->prepareRelation($weak);
        }
    }
    
    public function many_to_many(Model $reference) {
        $columns1 = parent::findConstraitn('PrimaryKey')->getColumns();
        $columns2 = $reference->findConstraitn('PrimaryKey')->getColumns();
        $mtm = ManyToMany::getInstance(parent::persistence(), $reference->persistence(), $columns1, $columns2);
        $this->weaks_entitys[get_class($mtm)] =  $mtm;
    }
    
    public function __call($name, $arguments) {
        if (isset($this->weaks_entitys["get_$name"])){
            return $this->weaks_entitys["get_$name"];
        }
    }
    
}

?>
