<?php

/**
 * Description of Controller
 *
 * @author ubuntu
 */
class Persistence {

    private $controller;

    function __construct($controller) {
        $this->controller = new ReflectionObject($controller);
    }

    public function __call($name, $arguments) {
        $method = $this->controller->getMethod($name);
        if ($method) {
            $connection = Connection::getConnection();
            return $connection->call($name, $arguments);
        }
    }

}

?>
