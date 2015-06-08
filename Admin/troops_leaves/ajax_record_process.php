<?php  require_once('../../settings.php');


	try

	{	$mode = $_REQUEST['mode'];
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

