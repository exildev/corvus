<?php

/**
 * Description of Procedure
 *
 * @author exile sas
 */
require_once Select_php;
require_once Insert_php;
require_once Update_php;

class Procedure extends Query {

    private $name;
    private $arguments = array();
    private $returns;
    private $declare = array();
    private $body = array();
    private $return;

    public function __construct($name) {
        $this->name = $name;
    }

    private function next() {
        if (!isset($this->return)) {
            return $this;
        }
    }

    public function args() {
        $this->arguments = array_merge($this->arguments, func_get_args());
        return $this->next();
    }

    public function returns($returns) {
        if ($returns != null) {
            $this->returns = $returns;
        }
        return $this->next();
    }

    public function declare_var($name, $type, $default = null) {
        array_push($this->declare, array('name' => $name, 'type' => $type, 'default' => $default));
        return $name;
    }

    public function findType($name) {
        foreach ($this->declare as $value) {
            if ($value['name'] == $name) {
                return $value['type'];
            }
        }
        return null;
    }

    private function body(Query $query) {
        array_push($this->body, $query);
        return $query;
    }

    public function return_val($var) {
        foreach ($this->body as $key => $body) {
            if ($body == $var) {
                array_splice($this->body, $key);
            }
        }
        $this->return = $var;
    }

    public function getQuery(Database $database) {
        return $database->procedure($this->name, $this->arguments, $this->returns, $this->declare, $this->body, $this->return);
    }

    /**
     * @param column column1, column2, ...
     * @return Select
     */
    public function select() {
        return $this->body(new Select(func_num_args()));
    }

    /**
     * 
     * @param type $relation
     * @return Insert
     */
    public function insert($relation) {
        return $this->body(new Insert($relation));
    }

    /**
     * 
     * @param type $relation
     * @return Update
     */
    public function update($relation) {
        return $this->body(new Update($relation));
    }

    /**
     * 
     * @param string $name
     * @return Procedure
     */
    public function procedure($name) {
        return $this->body(new Procedure($name));
    }

}

?>