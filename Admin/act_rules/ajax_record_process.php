<?php  require_once('../../settings.php');


	try

	{	$mode = $_REQUEST['mode'];
		if($_REQUEST['primery_key']!='')
		{
			$_POST['rule_id'] = $_REQUEST['primery_key'];
		}
		$Act_Rules = new Act_Rules();
		if( $mode=='save' )
		{
			$Act_Rules->add();
		}
		else if( $mode=='edit' )
		{
			$Act_Rules->edit();
		}
		else
		{
			$Act_Rules->delete($_POST['rule_id']);
		}

	}

	catch(Exception $e)

	{

		echo $e->getMessage();

	}

Common::displayMsg();

?>	

