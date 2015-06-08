<?php  require_once('../../settings.php');


	try

	{	$mode = $_REQUEST['mode'];
		if($_REQUEST['primery_key']!='')
		{
			$_POST['id'] = $_REQUEST['primery_key'];
		}
		$Admin = new Admin();
		if( $mode=='save' )
		{
			$Admin->addUser();
			echo json_encode(array('success' => true));
		}
		else
		{
			$Admin->deleteUser($_POST['id']);
			echo json_encode(array('success' => true));
		}

	}

	catch(Exception $e)

	{
		echo json_encode(array('msg' =>  $e->getMessage()));
	}


?>	

