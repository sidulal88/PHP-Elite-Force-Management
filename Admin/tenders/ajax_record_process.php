<?php  require_once('../../settings.php');


	try

	{	$mode = $_REQUEST['mode'];
		if($_REQUEST['primery_key']!='')
		{
			$_POST['tender_id'] = $_REQUEST['primery_key'];
		}
		$Tenders = new Tenders();
		if( $mode=='save' )
		{
			$Tenders->add();
			echo json_encode(array('success' => true));
			
		}
		else if( $mode=='edit' )
		{
			$Tenders->edit();
		}
		else
		{
			$Tenders->delete($_POST['tender_id']);
			echo json_encode(array('success' => true));
		}

	}

	catch(Exception $e)

	{

		echo json_encode(array('msg' => 'Some errors occured.'));

	}
?>	

