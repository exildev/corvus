<?php

/**
 * Description of Persistence
 *
 * @author exile sas
 */
require_once Config_php;
require_once Query_php;

class Connection {

    /**
     *
     * @var Config
     */
    private $config;
    private static $current = null;
    private $connection = null;
    private $last_query;

    function __construct(Config $config) {
        $this->config = $config;
    }

    /**
     * 
     * @return Connection
     */
    public static function prepare(Config $config) {
        return self::$current = new Connection($config);
    }

    public function connect() {
        $this->connection = pg_connect($this->config);
    }

    public function close() {
        pg_close($this->connection);
    }

    public function getLastQuery() {
        return $this->last_query;
    }

    public function getConfig() {
        return $this->config;
    }

    /**
     * 
     * @return Connection
     */
    public static function getConnection() {
        return self::$current;
    }

    public function excecute($sql) {
        if ($sql instanceof Query) {
            $sql = $sql->getQuery($this->config->getType());
        }
        $this->last_query = $sql;
        return pg_exec($this->connection, $sql);
    }
    
    public function excecute_fetch($sql) {
        $result = $this->excecute($sql);
        $response = array();
        while ($row = pg_fetch_row($result)) $response[] = $row[0];
        return $response;
    }

    public function call($name, array $args) {
        $database = $this->config->getType();
        return $this->excecute_fetch($database->call($name, $args));
    }

    public function begin() {
        $database = $this->config->getType();
        return $this->excecute($database->begin());
    }

    public function commit() {
        $database = $this->config->getType();
        return $this->excecute($database->commit());
    }

    public function rollback() {
        $database = $this->config->getType();
        return $this->excecute($database->rollback());
    }

    public function insert($relation, array $columns, array $values) {
        $database = $this->config->getType();
        return $this->excecute($database->insert($relation, $columns, $values));
    }

    public function update($relation, $conditions, array $values) {
        $database = $this->config->getType();
        return $this->excecute($database->update($relation, $conditions, $values));
    }

    public function select($relations, $columns, $conditions = null, $group_by = null, $order_by = null, $limit = null, $into = null) {
        $database = $this->config->getType();
        return $this->excecute($database->select($relations, $columns, $conditions, $group_by, $order_by, $limit, $into));
    }

}

?>
