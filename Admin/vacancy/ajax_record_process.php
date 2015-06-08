<?php  require_once('../../settings.php');


	try

	{	$mode = $_REQUEST['mode'];
		if($_REQUEST['primery_key']!='')
		{
			$_POST['vacancy_id'] = $_REQUEST['primery_key'];
		}
		$Carrer_Vacancy = new Carrer_Vacancy();
		if( $mode=='save' )
		{
			$Carrer_Vacancy->add();
			echo json_encode(array('success' => true));
			
		}
		else if( $mode=='edit' )
		{
			$Carrer_Vacancy->edit();
		}
		else
		{
			$Carrer_Vacancy->delete($_POST['vacancy_id']);
			echo json_encode(array('success' => true));
		}

	}

	catch(Exception $e)

	{

		echo json_encode(array('msg' => 'Some errors occured.'));

	}
?>	

