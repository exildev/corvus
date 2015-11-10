<?php

/**
 * Description of Update
 *
 * @author exile sas
 */
require_once Query_php;
class Update extends Query{
    private $relation;
    private $conditions;
    private $values = array();
    
    function __construct($relation) {
        $this->relation = $relation;
    }
    
    public function values() {
        $number = func_num_args();
        for($i = 0; $i < $number; $i++){
            array_push($this->values, PersistenceModel::getCondition());
        }
        return $this;
    }
    
    public function where($condition) {
        $this->conditions = $condition;
        return $this;
    }
    
    public function getQuery(Database $database) {
        return $database->update($this->relation, $this->values, $this->conditions);
    }

}

?>
