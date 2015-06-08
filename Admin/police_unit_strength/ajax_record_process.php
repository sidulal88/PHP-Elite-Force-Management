<?php  require_once('../../settings.php');


	try

	{	$mode = $_REQUEST['mode'];
		if($_REQUEST['primery_key']!='')
		{
			$_POST['strength_id'] = $_REQUEST['primery_key'];
		}
		$UnitStrength = new UnitStrength();
		if( $mode=='save' )
		{
			$UnitStrength->add();
			echo json_encode(array('success' => true));
		}
		else
		{
			$UnitStrength->delete($_POST['strength_id']);
			echo json_encode(array('success' => true));
		}

	}

	catch(Exception $e)

	{

		echo $e->getMessage();

	}

Common::displayMsg();

?>	

