<?php  require_once('../../settings.php');


	try

	{	$mode = $_REQUEST['mode'];
		if($_REQUEST['primery_key']!='')
		{
			$_POST['security_id'] = $_REQUEST['primery_key'];
		}
		$Security_Keys = new Security_Keys();
		if( $mode=='save' )
		{
			$Security_Keys->add();
			echo json_encode(array('success' => true));
		}
		else
		{
			$Security_Keys->delete($_POST['security_id']);
			echo json_encode(array('success' => true));
		}

	}

	catch(Exception $e)

	{

		echo $e->getMessage();

	}

Common::displayMsg();

?>	

