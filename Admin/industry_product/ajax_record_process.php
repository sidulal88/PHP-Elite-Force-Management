<?php  require_once('../../settings.php');


	try

	{	$mode = $_REQUEST['mode'];
		if($_REQUEST['primery_key']!='')
		{
			$_POST['productid'] = $_REQUEST['primery_key'];
		}
		$Product = new Product();
		if( $mode=='save' )
		{
			$Product->add();
			echo json_encode(array('success' => true));
		}
		else
		{
			$Product->delete($_POST['productid']);
			echo json_encode(array('success' => true));
		}

	}

	catch(Exception $e)

	{

		echo $e->getMessage();

	}

Common::displayMsg();

?>	

