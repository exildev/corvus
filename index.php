<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Cuervo</title>
    </head>
    <body>
        <?php
        require_once './cuervo/cuervo.php';
        require_once './cuervo/datab/PostgresType.php';

        require_once Connection_php;

        package('pack1');
        viewing('ViewPack1');

        Connection::prepare(new Config(new PostgresType(), host, port, user, pass));

        $view = new ViewPack1();
        $view->save_perro(array(
            'nombre' => 'rocky',
            'id' => 22,
            'persona_id' => 5
        ));
        
        function Aj(){
            class AA{
                
            }
            return new AA();
        }
        
        echo get_class(Aj());
        
        ?>
        
    </body>
</html>
