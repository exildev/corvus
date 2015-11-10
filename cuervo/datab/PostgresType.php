<?php

/**
 * Description of PostgresType
 *
 * @author exile sas
 */
require_once Database_php;
require_once RowType_php;
require_once Select_php;

class PostgresType extends Database {

    public function call($name, array $args) {
        $args = implode(', ', $args);
        return "SELECT * FROM $name($args);";
    }

    public function begin() {
        return "BEGIN";
    }

    public function commit() {
        return "COMMIT;";
    }

    public function rollback() {
        return "ROLLBACK;";
    }

    public function insert($relation, array $columns, $values, array $returning = null, $into = null) {
        $columns = implode(", ", $columns);
        if (is_array($values)) {
            $values = implode(", ", $values);
        } else
        if ($values instanceof Select) {
            $values = $values->getQuery($this);
        } else {
            $values = "VALUES ($values)";
        }
        $sql = "INSERT INTO $relation ($columns) $values";
        if ($returning) {
            $returning = implode(', ', $returning);
            $sql .= " RETURNING $returning";
        }
        if ($into) {
            $into = implode(', ', $into);
            $sql .= " INTO $into";
        }
        return "$sql";
    }

    public function update($relation, $values, $conditions) {
        foreach ($values as $key => $value) {
            $values[$key] = $value->getQuery($this);
        }
        $values = implode(', ', $values);
        $conditions = $conditions->getQuery($this);
        return "UPDATE $relation SET $values WHERE $conditions";
    }

    public function select($relations, array $columns, $conditions = null, array $group_by = null, array $order_by = null, array $limit = null, array $into = null) {
        foreach ($columns as $key => $column) {
            if (is_array($column)) {
                if (is_array($column['column'])) {
                    $column['column'] = $this->aggregate($column['column']['name'], $column['column']['column'], isset($column['column']['over']) ? $column['column']['over'] : null);
                }
                $columns[$key] = $this->_as($column['column'], $column['alias']);
            }
        }

        $columns = implode(', ', $columns);
        foreach ($relations as $key => $relation) {
            if (is_array($relation)) {
                $relations[$key] = $this->join($relation['join'], $relation['left'], $relation['right'], isset($relation['condition']) ? $relation['condition'] : null);
            }
        }
        $relations = implode(', ', $relations);
        $sql = "SELECT $columns";
        if ($relations) {
            $sql .= " FROM $relations";
        }
        if ($conditions) {
            $sql .= " WHERE {$conditions->getQuery($this)}";
        }
        if ($into) {
            $into = implode(', ', $into);
            $sql .= " INTO $into";
        }
        if ($group_by) {
            $group_by = implode(', ', $group_by);
            $sql .= " GROUP BY $group_by";
        }
        if ($order_by) {
            $order_by = implode(', ', $order_by);
            $sql .= " ORDER BY $order_by";
        }
        if ($limit) {
            $sql .= " LIMIT {$limit['index']}, {$limit['lebght']}";
        }
        return "$sql";
    }

    public function join($join, $left, $right, $condition = null) {
        return "($left $join JOIN $right" .
                ($condition ? " ON({$condition->getQuery($this)}))" : "");
    }

    public function natural_join($left, $right, $condition = null) {
        return $this->join(self::NATURAL, $left, $right, $condition);
    }

    public function left_join($left, $right, $condition = null) {
        return $this->join(self::LEFT, $left, $right, $condition);
    }

    public function right_join($left, $right, $condition = null) {
        return $this->join(self::RIGHT, $left, $right, $condition);
    }

    public function cross_join($left, $right) {
        return $this->join(self::CROSS, $left, $right);
    }

    public function aggregate($name, $column, $over = null) {
        return "$name($column)" . ($over ? " OVER($over)" : "");
    }

    public function _as($column, $alias) {
        return "$column as $alias";
    }

    public function limit($index, $lenght) {
        return "$index, $lenght";
    }

    public function procedure($name, array $arguments, $returns, array $declare, array $body, $return) {
        foreach ($arguments as $key => $parameter) {
            $arguments[$key] = "{$parameter['name']} {$parameter['type']}";
        }
        $args = implode(", ", $arguments);
        foreach ($body as $key => $query) {
            $body[$key] = $query->getQuery($this) . ";";
        }
        $body = implode(' ', $body);
        $declares = "";
        foreach ($declare as $key => $declar) {
            if ($declar['type'] instanceof RowType) {
                $declar['type'] = $this->define_rowtype($declar['type']);
            }
            $declares .= "DECLARE {$declar['name']} {$declar['type']}" . ($declar['default'] ? " := {$declar['default']};" : "") . ";";
        }
        if ($returns instanceof RowType) {
            $returns = $this->define_setof($returns);
        }
        if ($return instanceof RowVal) {
            $return = $this->return_rowval($return);
        } else
        if ($return instanceof Query) {
            $return = $this->return_query($return);
        } else {
            $return = "$return;";
        }
        return "CREATE OR REPLACE FUNCTION $name ($args) RETURNS $returns AS \$BODY\$ $declares BEGIN $body RETURN $return;END;\$BODY\$ LANGUAGE plpgsql;";
    }

    public function define_rowtype($type) {
        return "{$type->getType()}%ROWTYPE";
    }

    public function define_setof($type) {
        return "SETOF {$type->getType()}";
    }

    public function return_rowval($value) {
        return "NEXT {$value->getValue()}";
    }

    public function return_query($value) {
        return "QUERY {$value->getQuery($this)}";
    }

    public function check($condition) {
        $condition = $condition->getQuery($this);
        return "CHECK ($condition)";
    }

    public function foreignkey($columns, $relation, $references) {
        foreach ($columns as $key => $column) {
            $columns[$key] = $column->getName();
        }
        foreach ($references as $key => $reference) {
            $references[$key] = $reference->getName();
        }
        $columns = implode(', ', $columns);
        $references = implode(', ', $references);
        return "FOREIGN KEY ($columns) REFERENCES $relation ($references)";
    }

    public function notnull() {
        return "NOT NULL";
    }

    public function primarykey($columns) {
        foreach ($columns as $key => $column) {
            $columns[$key] = $column->getName();
        }
        $columns = implode(', ', $columns);
        return "PRIMARY KEY({$columns})";
    }

    public function unique($columns) {
        $columns = implode(', ', $columns);
        return "UNIQUE ({$columns->getName()})";
    }

    public function create_table($rname, array $columns, array $constraints) {
        $cols = array();
        $contrts = array();
        foreach ($columns as $column) {
            $null = $column['null']?" " . $this->notnull():"";
            array_push($cols, "{$column['name']} {$column['type']}$null");
        }
        foreach ($constraints as $constraitn) {
            array_push($contrts, $constraitn->getQuery($this));
        }
        $cls = implode(', ', $cols);
        $cts = implode(', ', $contrts);
        $sql = "CREATE TABLE $rname ($cls, $cts);";
        return $sql;
    }

    public function create_view($name, $query) {
        return "CREATE VIEW $name AS " . $query->getQuery($this);
    }

}

?>
