<?php  require_once('../../settings.php');


	try

	{	$mode = $_REQUEST['mode'];
		if($_REQUEST['primery_key']!='')
		{
			$_POST['unit_id'] = $_REQUEST['primery_key'];
		}
		$Unit = new Unit();
		if( $mode=='save' )
		{
			$Unit->add();
			echo json_encode(array('success' => true));
		}
		else
		{
			$Unit->delete($_POST['unit_id']);
			echo json_encode(array('success' => true));
		}

	}

	catch(Exception $e)

	{

		echo $e->getMessage();

	}

Common::displayMsg();

?>	

