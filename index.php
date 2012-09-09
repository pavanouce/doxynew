<?php
require_once 'bootstrap.php';
$nid = $_GET['nid'];
if(isset($_GET['nid']) && !empty($_GET['nid'])){
	$nid = $_GET['nid'];
	$nodes = array();
	$node = node_load($nid);
	$nids = explode(',',$node->content_nids);
	if(!empty($nids)) {
		foreach($nids as $nid)  {
			$nodes[] = node_load($nid);
		}
	}
	print render_file('crud.php', array('nodes' => $nodes,'node'=>$node));
} else{
	$nodes = array();
	$node = new stdClass();
	print render_file('crud.php', array('nodes' => $nodes,'node'=>$node));
}

