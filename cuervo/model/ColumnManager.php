<?php

/**
 * Description of ColumnManager
 *
 * @author exile sas
 */
abstract class ColumnManager {

    private static $columns = array();

    public static function addColumn($column) {
        array_push(self::$columns, $column);
        return $column;
    }

    public static function getColumn() {
        return array_pop(self::$columns);
    }

}

function g($columns = null) {
    if ($columns instanceof PersistenceModel) {
        $columns = func_num_args();
    }
    $list = array();
    for ($i = 0; $i < $columns; $i++) {
        $col = ColumnManager::getColumn();
        array_push($list, $col);
    }
    return $list;
}

?>
