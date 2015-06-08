<?php


$targetFolder = '/uploadify/uploads/'; // Relative to the root

if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath =  $_SERVER['DOCUMENT_ROOT'].$targetFolder;
	
	if(isset($_POST['id'])){
$targetFile =  str_replace('//','/',$targetPath).$_POST['id']. 
        substr($_FILES['Filedata']['name'],-4);
 } else{
    $targetFile =  str_replace('//','/',$targetPath).$_FILES['Filedata']['name'];
 }
	
	//$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];

	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);

	if (in_array($fileParts['extension'],$fileTypes)) {
		move_uploaded_file($tempFile,$targetFile);
		echo $targetFolder.$_POST['id'];
	} else {
		echo 'Invalid file type.';
	}
} 