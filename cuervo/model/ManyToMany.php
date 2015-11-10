<?php

/**
 * Description of ManyToMany
 *
 * @author exile sas
 */
require_once Relation_php;
require_once PersistenceModel_php;

abstract class ManyToMany extends Relation {

    public static function getInstance(PersistenceModel $model1, PersistenceModel $model2, array $columns1, array $columns2) {
        $php = "";
        $name = "{$model1->getName()}_{$model2->getName()}";
        if (!class_exists($name)) {
            $php .= "class $name extends ManyToMany {";
            foreach ($columns1 as $column) {
                $php .= "/** *@var int not null **/";
                $php .= "private $" . $column->getRelation() . '_' . $column->getName() . ";";
            }
            foreach ($columns2 as $column) {
                $php .= "/** *@var int not null **/";
                $php .= "private $" . $column->getRelation() . '_' . $column->getName() . ";";
            }
            $php .= "};";
            eval($php);
        }
        $mtmc = new $name();
        $perm = $mtmc->persistence();
        $group1 = array();
        foreach ($columns1 as $column) {
            array_push($group1, $perm->{$column->getRelation() . '_' . $column->getName()});
        }
        $group2 = array();
        foreach ($columns2 as $column) {
            array_push($group2, $perm->{$column->getRelation() . '_' . $column->getName()});
        }
        $mtmc->foreignkey($group1, $model1, $columns1);
        $mtmc->foreignkey($group2, $model2, $columns2);
        return $mtmc;
    }

}

?>
