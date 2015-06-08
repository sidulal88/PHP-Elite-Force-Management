<?php  require_once('../../settings.php');


	try

	{	$mode = $_REQUEST['mode'];
		if($_REQUEST['primery_key']!='')
		{
			$_POST['bcs_officer_id'] = $_REQUEST['primery_key'];
		}
		$BCS_Officers = new BCS_Officers();
		if( $mode=='save' )
		{
			$BCS_Officers->add();
			echo json_encode(array('success' => true));
		}
		else if( $mode=='edit' )
		{
			$BCS_Officers->edit();
		}
		else
		{
			$BCS_Officers->delete($_POST['bcs_officer_id']);
			echo json_encode(array('success' => true));
		}

	}

	catch(Exception $e)

	{

		echo json_encode(array('msg' => 'Some errors occured.'));

	}

?>	

