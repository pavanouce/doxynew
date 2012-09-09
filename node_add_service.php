<?php
	require 'bootstrap.php';
	$node = node_load($_GET['nid']); 
	print render_file('includes/node-form.php', 
	array('node' => $node,'data_nid'=>$node->nid,'data_tab_id'=>$node->nid)); 
?>