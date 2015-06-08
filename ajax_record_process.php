<?php  require_once('settings.php');


	try

	{	$mode = $_REQUEST['mode'];
		$_POST['troops_id'] = $_REQUEST['troops_id'];
		$_POST['leave_type'] = $_REQUEST['leave_type'];
		$_POST['status'] = 'active';
		if($_REQUEST['primery_key']!='')
		{
			$_POST['leave_id'] = $_REQUEST['primery_key'];
		}
		$TroopsLeave = new TroopsLeave();
		if( $mode=='save' )
		{
			$TroopsLeave->add();
			echo json_encode(array('success' => true));
		}
		else
		{
			$TroopsLeave->delete($_POST['leave_id']);
			echo json_encode(array('success' => true));
		}

	}

	catch(Exception $e)

	{

		echo $e->getMessage();

	}

Common::displayMsg();

?>	

