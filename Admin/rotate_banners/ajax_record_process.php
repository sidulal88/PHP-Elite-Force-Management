<?php  require_once('../../settings.php');


	try

	{	$mode = $_REQUEST['mode'];
		if($_REQUEST['primery_key']!='')
		{
			$_POST['id'] = $_REQUEST['primery_key'];
		}
		$Banner = new Banner();
		if( $mode=='save' )
		{
			$Banner->add();
			echo json_encode(array('success' => true));
		}
		else if( $mode=='edit' )
		{
			$Banner->edit();
		}
		else
		{
			$Banner->delete($_POST['id']);
			echo json_encode(array('success' => true));
		}

	}

	catch(Exception $e)

	{

		echo json_encode(array('msg' => 'Some errors occured.'));

	}

?>	

