<?php

/**
 * Description of View
 *
 * @author ubuntu
 */
require_once View_php;

package('pack1');
viewing('FormPerro');

class ViewPack1 extends View {

    public function save_perro($request) {
        $form = new FormPerro();
        $response = parent::setForm($form, $request);
        if ($response === true) {
            echo "Validación correcta.";
        } else {
            echo "Validación erronea.:<br>";
            var_dump($response);
        }
    }

}

?>
