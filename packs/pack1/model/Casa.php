<?php

/**
 * Description of Casa
 *
 * @author ubuntu
 */
require_once Model_php;
package('pack1');
class Casa extends Model {

    /** * @var int not null * */
    private $id;

    /** * @var varchar not null * */
    private $barrio;

    /** * @var varchar not null * */
    private $direccion;

    public function constraint($self) {
        parent::primarykey($self->id);
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getBarrio() {
        return $this->barrio;
    }

    public function setBarrio(varchar $barrio) {
        $this->barrio = $barrio;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function setDireccion(varchar $direccion) {
        $this->direccion = $direccion;
    }

}

?>
