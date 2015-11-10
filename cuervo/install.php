<?php

require_once './cuervo.php';
require_once Connection_php;
require_once PostgresType_php;
require_once RelationFactory_php;
require_once ProcedureFactory_php;

function install_all($install) {
    $connection = Connection::prepare(new Config(new PostgresType(), host, port, user, pass));
    $connection->connect();
    $connection->begin();
    install_packages($connection, $install);
    $connection->commit();
    $connection->close();
}

function install_packages(Connection $connection, $install) {
    foreach ($install as $package => $datas) {
        $models = $datas['model'];
        $contr = $datas['controller'];
        if (!install_package($connection, $package, $contr, $models)) {
            return false;
        }
    }
    return true;
}

function install_package(Connection $connection, $package, $contr, $models) {
    $class = ucfirst($contr);
    require_once "../packs/$package/contr/$class.php";
    $object = new $class();
    $procedures = ProcedureFactory::getProcedures($object);
    if (install_models($connection, $package, $models)) {
        if (install_procedures($connection, $procedures)) {
            return true;
        }
    }
    return false;
}

function install_procedures(Connection $connection, $procedures) {
    foreach ($procedures as $procedure) {
        if (!install_procedure($connection, $procedure)) {
            return false;
        }
    }
    return true;
}

function install_models(Connection $connection, $package, $models) {
    $factory = RelationFactory::getInstance();
    $factory->prepareRelations($package, $models);
    $models = $factory->getRelations($connection->getConfig()->getType());
    foreach ($models as $model) {
        if (!install_model($connection, $model)) {
            return false;
        }
    }
    return true;
}

function install_model(Connection $connection, $model) {
    $result = $connection->excecute($model);
    $sql = $connection->getLastQuery();

    if (!$result) {
        $connection->rollback();
        error($sql);
        return false;
    }
    ok($sql);
    return true;
}

function install_procedure(Connection $connection, $procedure) {
    $result = $connection->excecute($procedure);
    $sql = $connection->getLastQuery();

    if (!$result) {
        $connection->rollback();
        error($sql);
        return false;
    }
    ok($sql);
    return true;
}

function ok($sql) {
    echo "<p style='background-color: #BFB; border: solid 1px #0F0;padding: 5px;'>$sql</p>";
}

function error($sql) {
    echo "<p style='background-color: #FBB; border: solid 1px #F00;padding: 5px;'>$sql</p>";
}

install_all($install);
?>