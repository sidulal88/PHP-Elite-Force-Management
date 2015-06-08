<?php  require_once('../settings.php');


	try

	{	$mode = $_REQUEST['mode'];
		if($_REQUEST['unit_id']!='')
		{
			$_POST['unit_id'] = $_REQUEST['unit_id'];
		}
		$Unit = new Unit();
		if( $mode=='save' )
		{
			$Unit->add();
		}
		else
		{
			$Unit->delete($_POST['unit_id']);
		}

	}

	catch(Exception $e)

	{

		echo $e->getMessage();

	}

Common::displayMsg();

?>	

