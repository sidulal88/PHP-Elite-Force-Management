<?php @session_start();

	require_once('../settings.php');

	try

	{

		$action = DataValidator::isAlphaNumeric('get', 'action', SE.' (action)');

		if($action=="changeStatus") {

			$setStatus = DataValidator::sanitizeSpecialChars('get', 'setStatus', SE.' (change_status::set_status)');

			$dbTable = DataValidator::sanitizeSpecialChars('get', 'dbTable', SE.' (change_status::db_table)');

			$tabField = DataValidator::sanitizeSpecialChars('get', 'tabField', SE.' (change_status::tab_field)');

			$tabKey = DataValidator::sanitizeSpecialChars('get', 'tabKey', SE.' (change_status::tab_key)');

			$keyValue = DataValidator::sanitizeSpecialChars('get', 'keyValue', SE.' (change_status::key_value)');

			$container = DataValidator::sanitizeSpecialChars('get', 'container', SE.' (change_status::container)');

		

			Common::processStatus("edit", $setStatus, $dbTable, $tabField, $tabKey, $keyValue, $container);

		}

	}

	catch(Exception $e)

	{

		echo $e->getMessager();

	}

?>