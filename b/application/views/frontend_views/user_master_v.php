<?php
$ver = '1.0.0';
?>
<!DOCTYPE html>
<html lang="en">
<!--<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php  if($seo_title){ echo $seo_title; }else{ echo $settings_info['seo_title']; } ?></title>
	<meta name="description" content="<?php  if($seo_description){ echo $seo_description; }else{ echo $settings_info['seo_description']; } ?>"/>
	<meta name="keywords" content="<?php  if($seo_tags){ echo $seo_tags; }else{ echo $settings_info['seo_tags']; } ?>"/>	
	<link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/frontend/images/favicon.ico">
	<link href="<?php echo base_url(); ?>assets/frontend/css/style.css?ver=<?php echo $ver; ?>" rel="stylesheet">	
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">  
	
</head>
	<body class="<?php if($class!=''){ echo $class; }else if($this->router->fetch_class()=='home'){  echo 'home';  }else{ echo 'page job-post no-back'; } ?>">  
	
	<?php echo $main_content; ?>  


 
	
	<script src="<?php echo base_url(); ?>assets/frontend/js/script.js?ver=<?php echo $ver; ?>"></script>
  </body>-->
</html>