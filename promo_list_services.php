<?php
/**
 * Handles node save ajax call 
 */

require_once 'bootstrap.php';

saveNode($_POST);

/** 
 * Saves node with give form data
 * @param form $_POST $data
 */

function saveNode($data) {
	global $user;
	if(empty($user->uid)) {
		$user = user_load(1);
	}
	$title = getValueFromRequest('promo-list-title');
	$content_nids = getValueFromRequest('promo-list-content-nids');
	$publish = strtotime(getValueFromRequest('promo-list-publish-on'));
	$unpublish = strtotime(getValueFromRequest('promo-list-unpublish-on'));
	$nid = getValueFromRequest('promo_list_nid');
	
	if(!$nid) {
		$node = new stdClass();
		$node->nid = $nid;
		$node->created = time();
	} else {
		$node = node_load($nid);
	}
	
	$node->type = 'promo_node_list'; 
    $node->uid = $user->uid;
    $node->status = 1;
    $node->changed = time();
    $node->title = $promo_title;
    $node->name = $user->name;
    $node->title = $title;
    $node->old_content_nids = $node->content_nids; 
    $node->content_nids = $content_nids;

	$node->publish_on = $publish;
    $node->unpublish_on = $unpublish;
    $node->scheduler = Array (
    	'publish_on' => $publish,
        'unpublish_on' => $unpublish,
    );
	//print_r($node);
	node_save($node);
	print_r(drupal_to_js(node_load($node->nid)));
	exit;
}