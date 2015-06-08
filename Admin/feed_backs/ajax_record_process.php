<?php  require_once('../../settings.php');


	try

	{	$mode = $_REQUEST['mode'];
		if($_REQUEST['primery_key']!='')
		{
			$_POST['id'] = $_REQUEST['primery_key'];
		}
		$Feedback = new Feedback();
		if( $mode=='save' )
		{
			$Feedback->add();
			echo json_encode(array('success' => true));
		}
		else
		{
			$Feedback->delete($_POST['id']);
			echo json_encode(array('success' => true));
		}

	}

	catch(Exception $e)

	{

		echo $e->getMessage();

	}

Common::displayMsg();

?>	

