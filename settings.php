 <?php
 	include_once('includes/site_level.inc.php');
	error_reporting(0);
	date_default_timezone_set('Asia/Dhaka');
	@ob_start();
	@session_start();
	
	define('ROOT_DIR', dirname(__FILE__).'/'); //www
	
	/*
		define local folder name to help the developer while developing the
		system in the local machine
	*/
	define('ADMIN_DIR', 'Admin_eit');
	define('GF_DIR', 'gf');
	define('IMAGE_DIR', 'images');
	define('UPLOAD_DIR', 'uploads');
	define('INCLUDE_DIR', 'includes');
	//define('CLASS_DIR', dirname(dirname(__FILE__)).'/classes');
	//define('CLASS_DIR', 'classes');
	define('POLL_DIR', 'poll');
	define('CLASS_DIR', ROOT_DIR.'classes');
	define('CURRENT_DOMAIN_NAME', $_SERVER['SERVER_NAME']);
	define('CSS_DIR', 'css');
	define('JS_DIR', 'js');
	define('ADD_ONS', 'addOns');
	define('LOG_DIR', 'log');
	define('ERROR_LOG', 'error_log');
	define('TMP_DIR', 'temp');
	define('LOGGED_IN_PATH', ROOT_DIR.'Admin/admin_default');
	define('LOGGED_OUT_PATH', ROOT_DIR.'Admin/index.php');
	//define the current file name-------------//
	define('PHP_SELF', $_SERVER['PHP_SELF']);
	$curUrlArray = explode('/', PHP_SELF);
	$curPageName = $curUrlArray[count($curUrlArray) - 1];
	$curFolderName = $curUrlArray[count($curUrlArray) - 2];
	define('CURRENT_FILE_NAME', $curPageName);
	define('CURRENT_FOLDER_NAME', $curFolderName);
	//database variables
	
	define('HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', '');	
	define('DATABASE', 'ipolice_website');
	
	/*
	define('HOST', '172.18.18.18');
	define('DB_USER', 'industrialpolice');
	define('DB_PASS', 'I@n$d#P@Bc@C@2021');	
	define('DATABASE', 'industrialpolice_db');
	*/
	define('TABLE_PREFIX', 'ipb_');
	define('POLL_PREFIX', 'poll_');
	
	//invoke method wiothout including class file
	//----------------------------------------------------//
	define('WIDTH_RANGE', 450);
	define('HEIGHT_RANGE', 253);	
	define('WIDTH_RANGE_SMALL', 150);
	define('HEIGHT_RANGE_SMALL', 84);	
	define('WIDTH_RANGE_LARGE', 750);
	define('HEIGHT_RANGE_LARGE', 420);	
	define('WIDTH_GALLERY_VIEW', 150);
	define('HEIGHT_GALLERY_VIEW', 130);
	define('BANNER_WIDTH', 685);
	define('BANNER_HEIGHT', 295);
	//----------------Company Info-----------------//
	
	define('SITE_URL', $_SERVER['SERVER_NAME']);
	
	function __autoload($className)
	{
		/*
			This function load classes on-call
		*/
        if(is_file(CLASS_DIR.'/'.$className.'.class.php'))
		{
			require_once(CLASS_DIR.'/'.$className.'.class.php');
		}
		elseif(is_file(CLASS_DIR.'/'.$className.'.class.php'))
		{
			require_once(CLASS_DIR.'/'.$className.'.class.php');
		}
	}
	//connect to db
	
	try
	{
		$Database = new Database();
		$Database->getConnection();
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
		exit();
	}
	
?>