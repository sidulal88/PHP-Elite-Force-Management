<?php  require_once('../../settings.php');


	try

	{	$mode = $_REQUEST['mode'];
		if($_REQUEST['primery_key']!='')
		{
			$_POST['industry_unit_id'] = $_REQUEST['primery_key'];
		}
		
		$IndustrialUnit = new IndustrialUnit();
		if( $mode=='save' )
		{
			$IndustrialUnit->add();
			echo json_encode(array('success' => true));
		}
		else
		{
			$IndustrialUnit->delete($_POST['industry_unit_id']);
			echo json_encode(array('success' => true));
		}

	}

	catch(Exception $e)

	{

		echo $e->getMessage();

	}

Common::displayMsg();

?>	

