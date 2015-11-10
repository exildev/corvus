<?php

/**
 * Description of Cuervo
 *
 * @author exile sas
 */
$dir = dirname(__FILE__);
require_once "$dir/conf.php";

function package($package) {
    $GLOBALS["__PACKAGE__"] = $package;
}

function import($model) {
    $dir = dirname(__FILE__);
    $package = $GLOBALS["__PACKAGE__"];
    require_once "$dir/../packs/$package/model/$model.php";
}

function using($controller) {
    $package = $GLOBALS["__PACKAGE__"];
    $dir = dirname(__FILE__);
    require_once "$dir/../packs/$package/contr/$controller.php";
}

function viewing($view) {
    $package = $GLOBALS["__PACKAGE__"];
    $dir = dirname(__FILE__);
    require_once "$dir/../packs/$package/view/$view.php";
}
/**
 * DataB
 */
define('Config_php', "$dir/datab/Config.php");
define('Database_php', "$dir/datab/Database.php");
define('PostgresType_php', "$dir/datab/PostgresType.php");
define('Connection_php', "$dir/datab/Connection.php");
/**
 * Model
 */
define('Relation_php', "$dir/model/Relation.php");
define('Model_php', "$dir/model/Model.php");
define('Type_php', "$dir/model/Type.php");
define('Controller_php', "$dir/model/Controller.php");
define('Persistence_php', "$dir/model/Persistence.php");
define('ColumnManager_php', "$dir/model/ColumnManager.php");
define('Constraint_php', "$dir/model/Constraint.php");
define('ManyToMany_php', "$dir/model/ManyToMany.php");
/**
 * Constraints
 */
define('Check_php', "$dir/model/constraints/Check.php");
define('Unique_php', "$dir/model/constraints/Unique.php");
define('PrimaryKey_php', "$dir/model/constraints/PrimaryKey.php");
define('ForeignKey_php', "$dir/model/constraints/ForeignKey.php");
/**
 * Query
 */
define('Condition_php', "$dir/query/Condition.php");
define('Column_php', "$dir/query/Column.php");
define('Logic_php', "$dir/query/Logic.php");
define('PersistenceModel_php', "$dir/query/PersistenceModel.php");
define('Query_php', "$dir/query/Query.php");
define('Select_php', "$dir/query/Select.php");
define('Insert_php', "$dir/query/Insert.php");
define('Update_php', "$dir/query/Update.php");
define('Procedure_php', "$dir/query/Procedure.php");
define('RelationFactory_php', "$dir/query/RelationFactory.php");
define('ProcedureFactory_php', "$dir/query/ProcedureFactory.php");
define('RowType_php', "$dir/query/RowType.php");
define('RowVal_php', "$dir/query/RowVal.php");
/**
 * View
 */
define('Form_php', "$dir/view/Form.php");
define('Validation_php', "$dir/view/Validation.php");
define('View_php', "$dir/view/View.php");
?>
