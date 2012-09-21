<?php
$base_path = '/oxypromo'; 
?>
<html>
	<head>
		<title>New Promo Page Design</title>
		<script src="<?php print $base_path; ?>/js/jquery-1.8.0.min.js" type="text/javascript"></script>
		<script src="<?php print $base_path; ?>/js/jquery-ui-1.8.23.custom.min.js" type="text/javascript"></script>
		<script src="<?php print $base_path; ?>/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
		<script src="<?php print $base_path; ?>/js/jquery.validate.js" type="text/javascript"></script>
		<script src="<?php print $base_path; ?>/js/jquery.Jcrop.min.js" type="text/javascript"></script>
		<script src="<?php print $base_path; ?>/js/jquery.form.js" type="text/javascript"></script>
		<script src="<?php print $base_path; ?>/js/jquery.jgrowl.js" type="text/javascript"></script>
		<script src="<?php print $base_path; ?>/php_ajax_image_upload/scripts/ajaxupload.js" type="text/javascript"></script>
		<script src="<?php print $base_path; ?>/js/promo.js?<?php print rand(); ?>" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="<?php print $base_path; ?>/css/jquery-ui-1.8.23.custom.css"></link>
		<link rel="stylesheet" type="text/css" href="<?php print $base_path; ?>/css/promo.css?<?php print rand(); ?>"></link>
		<link rel="stylesheet" type="text/css" href="<?php print $base_path; ?>/css/jquery.Jcrop.css"></link>
		<link rel="stylesheet" type="text/css" href="<?php print $base_path; ?>/css/jquery.jgrowl.css"></link>
		
		<!--  Promo preview css/js -->
		<link rel="stylesheet" type="text/css" href="/<?php print drupal_get_path('module','homepage_promo')."/css/promo.css"; ?>"></link>
		<link rel="stylesheet" type="text/css" href="/<?php print drupal_get_path('module','homepage_promo')."/css/promo-node-view.css"; ?>"></link>
		<link rel="stylesheet" type="text/css" href="<?php print $base_path; ?>/css/jquery.jgrowl.css"></link>
		<script type="text/javascript" src="http://fast.fonts.com/jsapi/03088502-7de4-47f9-9df2-1271bd959096.js"></script>
		<!-- 
		<script type="text/javascript" src="/sites/all/themes/oxygenhomepage/js/jquery.cycle.all.js"></script>
		<script src="/<?php print drupal_get_path('module','homepage_promo')."/js/promo-block.js"; ?>" type="text/javascript"></script>
		 -->

	</head>
	<body>