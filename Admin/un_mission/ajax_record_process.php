<?php  require_once('../../settings.php');


	try

	{	$mode = $_REQUEST['mode'];
		if($_REQUEST['primery_key']!='')
		{
			$_POST['mission_id'] = $_REQUEST['primery_key'];
		}
		$Carrer_Mission = new Carrer_Mission();
		if( $mode=='save' )
		{
			$Carrer_Mission->add();
			echo json_encode(array('success' => true));
			
		}
		else if( $mode=='edit' )
		{
			$Carrer_Mission->edit();
		}
		else
		{
			$Carrer_Mission->delete($_POST['mission_id']);
			echo json_encode(array('success' => true));
		}

	}

	catch(Exception $e)

	{

		echo json_encode(array('msg' => 'Some errors occured.'));

	}
?>	

