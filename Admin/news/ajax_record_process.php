<?php  require_once('../../settings.php');


	try

	{	$mode = $_REQUEST['mode'];
		if($_REQUEST['primery_key']!='')
		{
			$_POST['id'] = $_REQUEST['primery_key'];
		}
		$News = new News();
		if( $mode=='save' )
		{
			$News->add();
			echo json_encode(array('success' => true));
		}
		else if( $mode=='edit' )
		{
			$News->edit();
		}
		else
		{
			$News->delete($_POST['id']);
			echo json_encode(array('success' => true));
		}

	}

	catch(Exception $e)

	{

		echo json_encode(array('msg' => 'Some errors occured.'));

	}

?>	

