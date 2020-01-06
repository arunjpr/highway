<?php  
$REQUEST_URI='http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$REQUEST_URI = str_replace("upload/upload.php","",$REQUEST_URI);
$REQUEST_URI = strtok($REQUEST_URI, "?");




if(isset($_FILES['upload'])){
    
	$filen = $_FILES['upload']['tmp_name']; 
	$con_images = "../assets/frontend/upload/".$_FILES['upload']['name'];
	$imgpath = $REQUEST_URI."/assets/frontend/upload/".$_FILES['upload']['name'];

	move_uploaded_file($filen, $con_images );
	$url = $imgpath;

   $funcNum = $_GET['CKEditorFuncNum'] ;
   $CKEditor = $_GET['CKEditor'] ;
   
   $langCode = $_GET['langCode'] ;
    
  
   $message = '';
   echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
}

?>