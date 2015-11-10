<?php

/**
 * Description of ConnexionType
 *
 * @author exile sas
 */
abstract class Database {

    const NATURAL = 'NATURAL';
    const LEFT = 'LEFT';
    const RIGHT = 'RGHT';
    const CROSS = 'CROSS';

    public abstract function call($name, array $args);

    public abstract function begin();

    public abstract function commit();

    public abstract function rollback();

    public abstract function insert($relation, array $columns, $values, array $returning = null, $into = null);

    public abstract function update($relation, $values, $conditions);

    public abstract function select($relations, array $columns, $conditions = null, array $group_by = null, array $order_by = null, array $limit = null, array $into = null);

    public abstract function join($join, $left, $right, $condition = null);

    public abstract function aggregate($name, $column, $over = null);

    public abstract function _as($column, $alias);

    public abstract function limit($index, $lenght);

    public abstract function procedure($name, array $arguments, $returns, array $declare, array $body, $return);

    public abstract function define_rowtype($type);

    public abstract function define_setof($type);

    public abstract function return_rowval($value);

    public abstract function check($condition);

    public abstract function foreignkey($columns, $relation, $references);

    public abstract function notnull();

    public abstract function primarykey($columns);

    public abstract function unique($columns);
    
    public abstract function create_table($name, array $columns, array $constraints);
    
    public abstract function create_view($name, $query);

    public function natural_join($left, $right, array $condition = null) {
        return $this->join(self::NATURAL, $left, $right, $condition);
    }

    public function left_join($left, $right, array $condition = null) {
        return $this->join(self::LEFT, $left, $right, $condition);
    }

    public function right_join($left, $right, array $condition = null) {
        return $this->join(self::RIGHT, $left, $right, $condition);
    }

    public function cross_join($left, $right) {
        return $this->join(self::CROSS, $left, $right);
    }

}

?>
