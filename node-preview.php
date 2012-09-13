<?php
	require_once 'bootstrap.php';
	$node = node_load($_GET['nid']); 
	print render_file('../sites/all/themes/oxygenhomepage/node-promo_homepage.tpl.php'
		,array('node'=>$node));
?>