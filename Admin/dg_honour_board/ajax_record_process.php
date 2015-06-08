<?php  require_once('../../settings.php');


	try

	{	$mode = $_REQUEST['mode'];
		if($_REQUEST['primery_key']!='')
		{
			$_POST['former_dg_id'] = $_REQUEST['primery_key'];
		}
		$FormerDg = new FormerDg();
		if( $mode=='save' )
		{
			$FormerDg->add();
			echo json_encode(array('success' => true));
		}
		else
		{
			$FormerDg->delete($_POST['former_dg_id']);
			echo json_encode(array('success' => true));
		}

	}

	catch(Exception $e)

	{

		echo $e->getMessage();

	}

Common::displayMsg();

?>	

