<?php

/**
 * Description of ContrPerro
 *
 * @author ubuntu
 */
require_once Controller_php;

package("pack1");
import("Perro");

class ContrPack1 extends Controller {

    /**
     * 
     * @return Pack1
     */
    public static function getInstance() {
        return parent::getInstance();
    }

    public function getPerro(Procedure & $pro, int $perroid) {
        $p = Perro::persistence();
        $perro = $pro->declare_var('per', new RowType($p));
        $pro->select($p->id, $p->nombre, $p->persona_id)->from($p)->where(c($p->id = $perroid))->into($perro);
        return $perro;
    }

    public function getPerros(Procedure & $pro) {
        $p = Perro::persistence();
        $pro->returns(new RowType($p));
        return $pro->select($p->id, $p->nombre, $p->persona_id)->from($p);
    }

    public function getPersona(Procedure & $pro, int $personaid) {
        $p = Persona::persistence();
        $persona = $pro->declare_var('per', new RowType($p));
        $pro->select($p->id, $p->nombre, $p->apellido)->from($p)->where(c($p->id = $personaid))->into($persona);
        return $persona;
    }

}

?>
