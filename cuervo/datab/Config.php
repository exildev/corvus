<?php

/**
 * Description of Config
 *
 * @author exile sas
 */
require_once Database_php;

class Config {

    private $type;
    private $host;
    private $port;
    private $user;
    private $pass;

    function __construct(Database $type, $host, $port, $user, $pass) {
        $this->type = $type;
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->pass = $pass;
    }

    /**
     * 
     * @return Database
     */
    public function getType() {
        return $this->type;
    }

    public function setType(Database $type) {
        $this->type = $type;
    }

    public function getHost() {
        return $this->host;
    }

    public function setHost($host) {
        $this->host = $host;
    }

    public function getPort() {
        return $this->port;
    }

    public function setPort($port) {
        $this->port = $port;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function getPass() {
        return $this->pass;
    }

    public function setPass($pass) {
        $this->pass = $pass;
    }

    public function __toString() {
        return "host={$this->getHost()} port={$this->getPort()} user={$this->getUser()} password={$this->getPass()} ";
    }

}

?>
