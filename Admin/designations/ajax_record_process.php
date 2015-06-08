<?php  require_once('../../settings.php');


	try

	{	$mode = $_REQUEST['mode'];
		if($_REQUEST['primery_key']!='')
		{
			$_POST['designation_id'] = $_REQUEST['primery_key'];
		}
		$Designation = new Designation();
		if( $mode=='save' )
		{
			$Designation->add();
			echo json_encode(array('success' => true));
		}
		else
		{
			$Designation->delete($_POST['designation_id']);
			echo json_encode(array('success' => true));
		}

	}

	catch(Exception $e)

	{

		echo $e->getMessage();

	}

Common::displayMsg();

?>	

