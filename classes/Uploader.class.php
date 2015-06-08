<?php
class Uploader
{
	private $path;
	
	function __construct()
	{
		$this->path = ROOT_DIR.UPLOAD_DIR.'/';
		if(!is_dir($this->path)) {
			throw new Exception('File directory is not found.');
		}
	}	
	
	public function photoNamer($mode, $fieldName, $maxWidth = '', $ext_path='')
	{
		/*
			-> $mode could be either 1/2 where 1 is upload and 2 is copy
			-> $fieldName :: if $mode==1 then $fieldName is the name of the form element;; else if $mode==2 then $fieldName is the name of the original files
				
				PLEASE NOTE - IF YOU NEED TO UPLOAD SAME FILE WITH DIFFERENT DIMENTION THEN USE $mode=2
				IF YOU WANT TO CREATE MULTIPLE FILES FROM A SINGLE UPLOAD THEN UPLOAD THE BIGGER SIZE PHOTO FIRST TEHN COPY IT AS MANY TIMES AS YOU NEED 
			
			-> $maxWidth is the expected width of the photo
		*/
		
		if($mode==1) {
			if($_FILES[$fieldName]['tmp_name']!='') {
				$fileName = explode('.', $_FILES[$fieldName]['name']);//ext of fileName
				$saveFileAs = md5(time().rand(0,9)).'.'.strtolower($fileName[count($fileName) - 1]);// fileName = timeRandNum.ext
				
				//upload photo
				return $this->photoUploader($fieldName, $saveFileAs, $maxWidth, $ext_path);
			}
		} else if($mode==2) {
			$fileName = explode('.', $fieldName);//ext of fileName
			$saveFileAs = md5(time().rand(0,9)).'.'.strtolower($fileName[count($fileName) - 1]);// fileName = timeRandNum.ext

			//copy file
			return $this->photoCopier($fieldName, $saveFileAs, $maxWidth, $ext_path);
		}
	}
	
	private function photoUploader($fieldName, $saveFileAs, $maxWidth, $ext_path='')
	{
		if(!move_uploaded_file($_FILES[$fieldName]['tmp_name'], $this->path.$ext_path.$saveFileAs)) {
			throw new Exception("<li>Photo could not be uploaded</li>");
		} else if($maxWidth!='') {
			$this -> resizePhoto($this->path.$ext_path.$saveFileAs, $maxWidth);
		}
		return $saveFileAs;
	}
	
	private function photoCopier($originalFileName, $saveFileAs, $maxWidth, $ext_path='')
	{
		if(!copy($this->path.$ext_path.$originalFileName, $this->path.$ext_path.$saveFileAs)) {
			throw new Exception("<li>Photo could not be copied</li>");
		} else if($maxWidth!='') {
			$this -> resizePhoto($this->path.$ext_path.$saveFileAs, $maxWidth);
		}
		return $saveFileAs;
	}
	
	private function resizePhoto($photo, $maxWidth)
	{
		if(!is_file($photo)) {
			throw new Exception('Error! Photo can not be resized (photo).');
		}
		$maxWidth = DataValidator::isNumeric('var', $maxWidth, 'Max-Width must be numeric (Uploader::resizePhoto).');
		
		$imageInfo = getimagesize($photo);		
		$width = $imageInfo[0];
		$height = $imageInfo[1];

		if($width > $maxWidth) {
			$scale = $maxWidth/$width;
		} else {
			$scale = 1;
		}
	
		$newImageWidth = $maxWidth;
		$newImageHeight = $this -> getHeightByWidth($photo, $newImageWidth);
		$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
		$source = imagecreatefromjpeg($photo);
		imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
		imagejpeg($newImage,$photo,90);
		chmod($photo, 0777);
		return $photo;
	}
	
	public function photoDelete($file, $ext_path='')
	{
		if(is_file($this->path.$ext_path.$file)) {
			if(!unlink($this->path.$ext_path.$file)) {
				throw new Exception("<li>Photo could not deleted</li>");
			}
		}
	}
	
	public function imageViewer($fileName, $width, $height, $linkTo, $alt, $side='', $title='', $ext_path='', $viewer_position='')
	{
		$this->fileName = $fileName;
		$viewer_position2 = ($viewer_position == 2 ) ? 2 : 1;
		$initial_backtrack = ($viewer_position2 == 2 ) ? '' : '../';
		$directory = $initial_backtrack.UPLOAD_DIR.'/'.$ext_path;
		
		if($fileName=='' || !is_file($this->path.$ext_path.$this->fileName)) {
			$this->fileName = 'noPhoto.jpg';
			$directory = 'images/';
		}
		
		
		if($width=='' && $height=='') {
			$width = 80;
		}
			
		if($width!='' && $height=='') {
			$height = $this->getHeightByWidth($directory.$this->fileName, $width);
		} else if($width=='' && $height!='') {
			$width = $this->getWidthByHeight($directory.$this->fileName, $height);
		}
		
		//collect file type
		$file = '';
		$fileExt = explode(".",$this->fileName);
		$fileExt = strtolower($fileExt[count($fileExt)-1]);
		if($fileExt=="swf") {
			$file .= '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="'.$width.'" height="'.$height.'"><param name="movie" value="'.$directory.$this->fileName.'"><param name="quality" value="high"><embed src="'.UPLOAD_DIR.$this->fileName.'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'"></embed></object>';
		} 
		else if($fileExt=="pdf") {
			$file .= '<a href="'.$directory.$this->fileName.'" target="_blank"><img src="'.$initial_backtrack.'images/pdf-icon.png" width="96" height="96" /></a>';
		} else {
			if($linkTo!='') {
				$file .= '<a href="'.$linkTo.'">';
			}
			$file .= '<img border="0" src="'.$directory.$this->fileName.'" width="'.$width.'" height="'.$height.'" alt="'.$alt.'"  title="'.$title.'"  />';
			if($linkTo!='') {
				$file .= '</a>';
			}
		}
		return  $file;
	}//imageViewer
	
	public function getHeightByWidth($file, $width)
	{
		$image = getimagesize($file);
		$ratio = $width / $image[0];
		$height = ceil($image[1] * $ratio);
		return $height;
	}
	
	public function getWidthByHeight($file, $height)
	{
		$image = getimagesize($file);
		$ratio = $height / $image[1];
		$width = ceil($image[0] * $ratio);
		return $width;
	}
	
	public static function mimeType($allowedExts, $mimeType)
	{
		/*
			$allowedExts is list of extension (in array) that is excepted for this upload
			$mimeType is the mime type of the selected file (requested to upload)
		*/
		
		$mimeTypes = array(
					  'bmp'    => array('image/bmp', 'image/x-windows-bmp'),
					  'doc'    => array('application/msword'),
					  'gif'    => array('image/gif'),
					  'jpe'    => array('image/jpeg', 'image/pjpeg'),
					  'jpeg'   => array('image/jpeg', 'image/pjpeg'),
					  'jpg'    => array('image/jpeg', 'image/pjpeg'),
					  'png'    => array('image/png'),
					  'ppt'    => array('application/mspowerpoint', 'application/powerpoint'),
					  'ppt'    => array('application/vnd.ms-powerpoint', 'application/x-mspowerpoint'),
					  'ppz'    => array('application/mspowerpoint'),
					  'text'   => array('application/plain', 'text/plain'),
					  'txt'    => array('text/plain'),
					  'sql'    => array('application/octet-stream'),
					  'word'   => array('application/msword'),
					  'swf'    => array('application/x-shockwave-flash', 'application/x-shockwave-flash2-preview', 'application/futuresplash', 'image/vnd.rn-realflash'),
					  'flv'    => array('video/x-flv'),
					  'png'    => array('image/png'),
					  'pdf'	   => array('application/pdf', 'application/x-pdf'));
					  
		if(!is_array($allowedExts)) {
			throw new Exception('Error! Extension(s) must be a array.');
		}
		
		foreach($allowedExts as $extension) {
			if(in_array($mimeType, $mimeTypes[trim($extension)])) {
				return true;
			}		
		}
		
		throw new Exception('Error! Requested file is not allowed to be uploaded.');
	}
	
	public function file_upload_single($targetFolder, $temp_file='', $existing_file='') {

                    if (!file_exists($targetFolder))
                       // mkdir($targetFolder);

					($existing_file)? unlink($existing_file) : '';
					
                    if (!empty($_FILES)) {
                        $random_digit = rand(000000, 999999);
						$temp_file = ($temp_file) ? $temp_file : 'file_one';
                        $tempFile = $_FILES[$temp_file]['tmp_name'];
                        $targetPath = $targetFolder; //$_SERVER['DOCUMENT_ROOT'] . $targetFolder;
                        // Validate the file type
                        $fileTypes = array('jpg', 'jpeg', 'gif', 'pdf', 'png', 'xls', 'xlsx', 'doc', 'docx', 'ppt'); // File extensions
                        $fileParts = pathinfo($_FILES[$temp_file]['name']);

                        if (in_array($fileParts['extension'], $fileTypes)) {

                            $file_name = basename($_FILES[$temp_file]['name'], '.' . $fileParts['extension']);
                            $file_name = str_replace(' ', '', $file_name);
                            $targetFile = $this->path. $targetPath . $file_name . $random_digit . '.' . $fileParts['extension'];
                            move_uploaded_file($tempFile, $targetFile);
                            $path = $file_name . $random_digit . '.' . $fileParts['extension'];
                        }
                        return $path;
                    }
                }

	
}
?>