<?php  require_once('../../settings.php');


	try

	{	$mode = $_REQUEST['mode'];
		if($_REQUEST['primery_key']!='')
		{
			$_POST['district_id'] = $_REQUEST['primery_key'];
		}
		$District = new District();
		if( $mode=='save' )
		{
			$District->add();
			echo json_encode(array('success' => true));
		}
		else
		{
			$District->delete($_POST['district_id']);
			echo json_encode(array('success' => true));
		}

	}

	catch(Exception $e)

	{

		echo $e->getMessage();

	}

Common::displayMsg();

?>	

