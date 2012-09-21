<?php
require_once 'bootstrap.php';
if(isset($_GET['nid'])){
	$node = node_load($_GET['nid']);
	$tabid = $_GET['tabid'];
	if(isset($_GET['clone'])) {
		$clone = false;
	}
	else {
		$clone = true;
	}
} else {
	$tabid = $_GET['tabid'];
	$node = new stdClass();
	$clone = true;
}
print render_file('includes'.DIRECTORY_SEPARATOR.'node-summary.php',
	 array('node'=>$node,'tabid'=>$tabid,'clone'=>$clone));
?>