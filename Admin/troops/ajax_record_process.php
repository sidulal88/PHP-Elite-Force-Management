<?php  require_once('../../settings.php');


	try

	{	$mode = $_REQUEST['mode'];
		if($_REQUEST['primery_key']!='')
		{
			$_POST['troops_id'] = $_REQUEST['primery_key'];
		}
		$Troops = new Troops();
		if( $mode=='save' )
		{
			$Troops->add();
			echo json_encode(array('success' => true));
		}
		else if( $mode=='edit' )
		{
			$Troops->edit();
		}
		else
		{
			$Troops->delete($_POST['troops_id']);
			echo json_encode(array('success' => true));
		}

	}

	catch(Exception $e)

	{

		echo json_encode(array('msg' => 'Some errors occured.'));

	}

?>	

