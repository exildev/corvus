<?php

/**
 * Description of Persona
 *
 * @author ubuntu
 */
require_once Model_php;
package('pack1');
import('Casa');
class Persona extends Model {

    /** *@var int not null **/
    private $id ;
    /** *@var varchar not null **/
    private $nombre;
    /** *@var varchar not null **/
    private $apellido;

    function __construct() {
        parent::__construct();
    }

    /**
     * 
     * @param Persona $self
     */
    public function constraint($self) {
        self::primarykey($self->id);
        parent::many_to_many(new Casa());
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

}

?>
