<?php
class DataValidator
{
	private $post;
	private $files;

	function __construct($post = '', $files = '')
	{
		$this->post = $post;
		$this->files = $files;
	}
		
	public static function isNumeric($method, $variableName, $errorMsg = '', $nullable = 0, $errorType = 1)
	{
		/*
			this method checks whether the given data is numerical (0-9) or not
		*/	
		$rt = '';
		$value = self::getData($method, $variableName);
		if($nullable==0 && ($value===false || $value==='')) {
			$rt = false;
		} else if($value!='') {
			$vData = preg_replace('/[^0-9]/', '', $value);
			if($value==$vData) {
				$rt = $vData;
			} else {
				$rt = false;
			}
		}
		return self::showMessage($rt, $errorType, $errorMsg);
	}
	
	public static function isDouble($method, $variableName, $errorMsg = '', $nullable = 0, $errorType = 1)
	{	
		$rt = '';
		$value = self::getData($method, $variableName);
		if($nullable==0 && ($value===false || $value==='')) {
			$rt = false;
		} else if($value!='') {
			$vData = preg_replace('/[^0-9|\.]/', '', $value);
			if($value==$vData) {
				$rt = $vData;
			} else {
				$rt = false;
			}
		}
		return self::showMessage($rt, $errorType, $errorMsg);
	}
	
	public static function isAlpha($method, $variableName, $errorMsg = '', $nullable = 0, $errorType = 1)
	{
		$rt = '';
		$value = self::getData($method, $variableName);
		if($nullable==0 && ($value=='' || $value==='')) {
			$rt = false;
		} else if($value!='') {
			$vData = preg_replace('/[^a-zA-Z]/', '', $value);
			if($value==$vData) {
				$rt = $vData;
			} else {
				$rt = false;
			}
		}
		return self::showMessage($rt, $errorType, $errorMsg);
	}
	
	public static function isAlphaNumeric($method, $variableName, $errorMsg = '', $nullable = 0, $errorType = 1)
	{
		$rt = '';
		$value = self::getData($method, $variableName);
		if($nullable==0 && ($value=='' || $value==='')) {
			$rt = false;
		} else if($value!='') {
			$vData = preg_replace('/[^a-zA-Z0-9]/', '', $value);
			if($value==$vData) {
				$rt = $vData;
			} else {
				$rt = false;
			}
		}
		return self::showMessage($rt, $errorType, $errorMsg);
	}
	
	public static function isIP($method, $variableName, $errorMsg = '', $nullable = 0, $errorType = 1)
	{
		$rt = '';
		$value = self::getData($method, $variableName);
		if($nullable==0 && ($value=='' || $value==='')) {
			$rt = false;
		} else if($value!='') {
			if(filter_var($value, FILTER_VALIDATE_IP)) {
				$rt = $value;
			} else {
				$rt = false;
			}
		}
		return self::showMessage($rt, $errorType, $errorMsg);
	}
	
	public static function isISBN($method, $variableName, $errorMsg = '', $nullable = 0, $errorType = 1)
	{
		$rt = '';
		$value = self::getData($method, $variableName);
		if($nullable==0 && ($value=='' || $value==='')) {
			$rt = false;
		} else if($value!='') {
			$vData = preg_replace('/[^0-9|x|X]/', '', $value);
			if($value==$vData) {
				$rt = $vData;
			} else {
				$rt = false;
			}
		}
		return self::showMessage($rt, $errorType, $errorMsg);
	}
	
	public static function sanitizeSpecialChars($method, $variableName, $errorMsg = '', $nullable = 0, $errorType = 1)
	{
		$value = self::getData($method, $variableName);
		if($nullable==0 && ($value=='' || $value==='')) {
			if($errorType===1) {
				throw new Exception($errorMsg);
			} else if($errorType===2) {
				exit($errorMsg);
			}
		} else if($value!='') {
			$string_list = array("'", "&nbsp;");
			$replace_list = array(" ", " ");
			$value = str_replace($string_list, $replace_list, $value);
			//$value = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
			return $value;
		}
		return '';
	}
	
	public static function isEmail($method, $variableName, $errorMsg = '', $nullable = 0, $errorType = 1)
	{
		$rt = '';
		$value = self::getData($method, $variableName);
		if($nullable==0 && ($value=='' || $value==='')) {
			$rt = false;
		} else if($value!='') {
			if(!filter_var($value, FILTER_VALIDATE_EMAIL)) {
				$rt = false;
			} else {
				$rt = preg_replace('/[^a-zA-z0-9|\.|@|_|\-]/', '', $value);
				if($rt!=$value) {
					$rt = false;
				}
			}
		}
		return self::showMessage($rt, $errorType, $errorMsg);
	}
	
	public static function validatePassword($password, $confirmPassword, $minLength = 6)
	{
		/*
			this methods is useful to validate password while
			->creating new password
			->reseting password
		*/
		if($password=='' || $password===false) {
			throw new Exception('Please input password.');
		} else {
			$password = self::sanitizeSpecialChars('var', $password, 'Please input password.');
			$confirmPassword = self::sanitizeSpecialChars('var', $confirmPassword, 'Please input confirm password.');
			$minLength = (int)$minLength;
			
			if(strlen($password) < $minLength) {
				throw new Exception('The length of password must be atleast '.$minLength.' characters.');
			} else if($password!==$confirmPassword) {
				throw new Exception('Password and confirm-password does not match.');
			} else {
				return md5($password);
			}
		}
	}
	
	public static function isDBTable($variableName, $errorType = 1)
	{
		if($variableName == '') {
			throw new Exception('DB table name seems to be incorrect.');
		} else {
			$vData = preg_replace('/[^a-zA-z0-9| |,|_|\.|=]/', '', $variableName); //(i.e. product AS p JOIN product_chalan AS pc ON p.barcode=pc.barcode)
			if($vData===$variableName) {
				return $vData;
			} else {
				throw new Exception('DB table name seems to be incorrect.');
			}
		}
	}
	
	public static function isDBField($variableName, $errorType = 1)
	{
		if($variableName == '') {
			throw new Exception('DB field name seems to be incorrect.');
		} else {
			$vData = preg_replace('/[^a-zA-z0-9|\.|_]/', '', $variableName); //(i.e. customer.name)
			if($vData===$variableName) {
				return $vData;
			} else {
				throw new Exception('DB field name seems to be incorrect.');
			}
		}
	}
		
	public static function getData($method, $variableName)
	{
		$value = '';
		switch ($method) {
			case 'post':
				if(isset($_POST[$variableName])) {
					$value = nl2br($_POST[$variableName]);
				}	
				break;
			case 'get':
				if(isset($_GET[$variableName])) {
					$value = $_GET[$variableName];
				}	
				break;
			case 'request':
				if(isset($_POST[$variableName])) {
					$value = $_POST[$variableName];
				} else if(isset($_GET[$variableName])) {
					$value = $_GET[$variableName];
				}
				break;
			case 'var':
				$value = $variableName;	
				break;
		}
		return trim($value);
	}
	
	private static function showMessage($returnType, $exceptionType, $errorMsg)
	{
		if($returnType===false) {
			if($exceptionType===1) {
				throw new Exception($errorMsg);
			} else if($exceptionType===2) {
				exit($errorMsg);
			}
		} else {
			return $returnType;
		}
	}
	
	public static function isValidPhoto($allowedExt, $fieldName, $nullable = 0, $maxAllowedSize = 0)
	{		
		/*
			$allowedExt = allowed file extension
			->if allowedExt > 1 then extensions must be seperated by comma (i.e. jpg, gif, swf)
		
			$fieldName is the name of the form's element that is employed to upload file
		*/
		
		if($nullable==0 && ($fieldName==='' || $fieldName===false || $_FILES[$fieldName]['tmp_name']=='')) {
			throw new Exception('Error! The file is not found / no file is selected.');
		} else if($_FILES[$fieldName]['name']!='') {
			if($allowedExt==='' || $allowedExt==false || is_array($allowedExt)) {
				throw new Exception('Error! Allowed file extension(s) is required. More then one extension should be seperated by comma.');
			} else {
				$allowedExt = explode(',', $allowedExt);
				
				if(count($allowedExt) <1) {
					throw new Exception(SE.' (data_validator::valid_photo)');
				} else if(!$imageInfo = @getimagesize($_FILES[$fieldName]['tmp_name'])) {
					throw new Exception('Error! The uploaded file seems not to be an image file.');
				} else if(count(explode('.', $_FILES[$fieldName]['name'])) > 2) {
					throw new Exception('Error! File name can not contain more than one \'.\'');
				} else if($maxAllowedSize > 0 && $imageInfo['size'] > $maxAllowedSize) {
					throw new Exception('Error!Maximum allowed size is '.$maxAllowedSize.'.');
				} else if(Uploader::mimeType($allowedExt, $imageInfo['mime'])) {
					return true;
				}
			}
		}
	}
	
	/**
	* This method designed to make sure that a file is in PDF format
	* @param String $fieldName - name of the form element/uploader
	* @param Boolean $nullable - allowed to keep null or not
	* @param Int $maxAllowedSize - maximum file size in KB
	*/
	public static function isValidPDFfile($fieldName, $nullable = 0, $maxAllowedSize = 1024)
	{
		if ($nullable==0 && ($fieldName==='' || $fieldName===false || $_FILES[$fieldName]['tmp_name']=='')) {
			throw new Exception('Error! The file is not found / no file is selected.');
		} else if ($_FILES[$fieldName]['name']!='') {
			if ((filesize($_FILES[$fieldName]['tmp_name'])/5024) > $maxAllowedSize)
			{
				throw new Exception('File is too large. Maximun allowed size is ' . $maxAllowedSize . 'KB (' .($maxAllowedSize*1024). 'Bytes)');
			}
			elseif (Uploader::mimeType(array('pdf'), mime_content_type($_FILES[$fieldName]['tmp_name']))) {
				return TRUE;
			}
		}
	}
}
?>