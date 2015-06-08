<?php  require_once('../../settings.php');


	try

	{	$mode = $_REQUEST['mode'];
		if($_REQUEST['primery_key']!='')
		{
			$_POST['id'] = $_REQUEST['primery_key'];
		}
		$Category = new Category();
		if( $mode=='save' )
		{
			$Category->add();
			echo json_encode(array('success' => true));
		}
		else if( $mode=='edit' )
		{
			$Category->edit();
		}
		else
		{
			$Category->delete($_POST['id']);
			echo json_encode(array('success' => true));
		}

	}

	catch(Exception $e)

	{

		echo json_encode(array('msg' => 'Some errors occured.'));

	}

?>	

