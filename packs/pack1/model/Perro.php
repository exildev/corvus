<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Perro
 *
 * @author ubuntu
 */
require_once Model_php;
package('pack1');
import('Persona');
class Perro extends Model {

    /** *@var int notnull **/
    private $id;
    /** *@var varchar notnull **/
    private $nombre;
    /** *@var int notnull **/
    private $persona_id;

    function __construct() {
        parent::__construct();
    }
    /**
     * 
     * @param Perro $self
     */
    public function constraint($self) {
        self::primarykey($self->id);
        self::foreignkey(g($self->persona_id), $per = Persona::persistence(), g($per->id));
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

    public function getPersona_id() {
        return $this->persona_id;
    }

    public function setPersona_id($persona_id) {
        $this->persona_id = $persona_id;
    }

}

?>
