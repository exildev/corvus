<?php

/**
 * Description of Form
 *
 * @author ubuntu
 */

package('pack1');
using("ContrPack1");

class FormPerro extends Perro implements Form {

    public function after_set() {
        
    }

    public function validate_persona_id($persona_id) {
        Connection::getConnection()->connect();
        $resp = ContrPack1::getInstance()->getPersona($persona_id);
        if ($resp[0] != null){
            Connection::getConnection()->close();
            return true;
        }
        Connection::getConnection()->close();
        return "($persona_id) no es una persona válida";
    }

    public function befor_set() {
        
    }

}

?>
