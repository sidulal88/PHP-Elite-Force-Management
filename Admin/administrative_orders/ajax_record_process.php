<?php  require_once('../../settings.php');


	try

	{	$mode = $_REQUEST['mode'];
		if($_REQUEST['primery_key']!='')
		{
			$_POST['order_id'] = $_REQUEST['primery_key'];
		}
		$Administrative_Orders = new Administrative_Orders();
		if( $mode=='save' )
		{
			$Administrative_Orders->add();
			echo json_encode(array('success' => true));
			
		}
		else if( $mode=='edit' )
		{
			$Administrative_Orders->edit();
		}
		else
		{
			$Administrative_Orders->delete($_POST['order_id']);
			echo json_encode(array('success' => true));
		}

	}

	catch(Exception $e)

	{

		echo json_encode(array('msg' => 'Some errors occured.'));

	}
?>	

