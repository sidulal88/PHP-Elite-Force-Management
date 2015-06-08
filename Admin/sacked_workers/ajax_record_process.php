<?php  require_once('../../settings.php');


	try

	{	$mode = $_REQUEST['mode'];
		if($_REQUEST['primery_key']!='')
		{
			$_POST['sacked_worker_id'] = $_REQUEST['primery_key'];
		}
		$Sacked_Workers = new Sacked_Workers();
		if( $mode=='save' )
		{
			$Sacked_Workers->add();
			echo json_encode(array('success' => true));
			
		}
		else if( $mode=='edit' )
		{
			$Sacked_Workers->edit();
		}
		else
		{
			$Sacked_Workers->delete($_POST['sacked_worker_id']);
			echo json_encode(array('success' => true));
		}

	}

	catch(Exception $e)

	{

		echo json_encode(array('msg' => 'Some errors occured.'));

	}
?>	

