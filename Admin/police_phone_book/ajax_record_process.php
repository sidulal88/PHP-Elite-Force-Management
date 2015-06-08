<?php  require_once('../../settings.php');


	try

	{	$mode = $_REQUEST['mode'];
		if($_REQUEST['primery_key']!='')
		{
			$_POST['book_id'] = $_REQUEST['primery_key'];
		}
		$PhoneBook = new PhoneBook();
		if( $mode=='save' )
		{
			$PhoneBook->add();
			echo json_encode(array('success' => true));
		}
		else
		{
			$PhoneBook->delete($_POST['book_id']);
			echo json_encode(array('success' => true));
		}

	}

	catch(Exception $e)

	{

		echo $e->getMessage();

	}

Common::displayMsg();

?>	

