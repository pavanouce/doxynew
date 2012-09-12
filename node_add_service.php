<?php
	require 'bootstrap.php';
	if(isset($_GET['nid'])) {
		$node = node_load($_GET['nid']);	
		print render_file('includes/node-form.php', 
		array('node' => $node,'data_nid'=>$node->nid,'data_tab_id'=>$node->nid)); 
	}
	else {
		$tab_id = $_GET['tabid'];
		$node = new stdClass();
		$node = new stdClass();
				print render_file('includes'.DIRECTORY_SEPARATOR.'node-form.php', 
		array('node' => $node,'data_nid'=>$tab_id,'data_tab_id'=>$tab_id)); 
	}
	
?>