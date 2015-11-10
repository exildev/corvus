<?php

/**
 * Description of RelationFactory
 *
 * @author ubuntu
 */
class RelationFactory {

    private static $instance;
    public $prepareds = array();

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new RelationFactory();
        }
        return self::$instance;
    }

    public function prepareRelation(Relation $relation) {
        $object = new ReflectionObject($relation);
        $properties = $object->getProperties();
        $cols = array();
        $cons = $relation->getContraints();
        foreach ($properties as $propertie) {
            $name = $propertie->getName();
            $docm = $propertie->getDocComment();
            preg_match("/@var (?P<type>\w+) (?P<null>\w+)/", $docm, $resp);
            array_push($cols, array('name' => $name, 'type' => $resp['type'], 'null' => $resp['null']));
        }
        $rname = strtolower(get_class($relation));
        array_push($this->prepareds, array('rname' => $rname, 'cols' => $cols, 'cons' => $cons));
    }

    public function prepareRelations($package, $names) {
        $relations = array();
        foreach ($names as $name) {
            $class = ucfirst($name);
            require_once "../packs/$package/model/$class.php";
            $relation = new $class();
            array_push($relations, $relation);
            self::prepareRelation($relation);
        }
        foreach ($relations as $relation) {
            $relation->weak_entity($this);
        }
    }

    public function getRelation(Database $database, array $relation) {
        $rname = $relation['rname'];
        $cols = $relation['cols'];
        $cons = $relation['cons'];
        return $database->create_table($rname, $cols, $cons);
    }

    public function getRelations(Database $database) {
        $relations = array();
        foreach ($this->prepareds as $prepared) {
            array_push($relations, self::getRelation($database, $prepared));
        }
        return $relations;
    }

}

?>
