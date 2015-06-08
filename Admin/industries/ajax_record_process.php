<?php  require_once('../../settings.php');


	try

	{	$mode = $_REQUEST['mode'];
		if($_REQUEST['primery_key']!='')
		{
			$_POST['industry_id'] = $_REQUEST['primery_key'];
		}
		$Industry = new Industry();
		if( $mode=='save' )
		{
			$Industry->add();
			echo json_encode(array('success' => true));
		}
		else
		{
			$Industry->delete($_POST['industry_id']);
			echo json_encode(array('success' => true));
		}

	}

	catch(Exception $e)

	{

		echo $e->getMessage();

	}

Common::displayMsg();

?>	

