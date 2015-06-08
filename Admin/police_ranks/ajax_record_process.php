<?php  require_once('../../settings.php');


	try

	{	$mode = $_REQUEST['mode'];
		if($_REQUEST['primery_key']!='')
		{
			$_POST['rank_id'] = $_REQUEST['primery_key'];
		}
		$Ranks = new Ranks();
		if( $mode=='save' )
		{
			$Ranks->add();
			echo json_encode(array('success' => true));
		}
		else
		{
			$Ranks->delete($_POST['rank_id']);
			echo json_encode(array('success' => true));
		}

	}

	catch(Exception $e)

	{

		echo $e->getMessage();

	}

Common::displayMsg();

?>	

