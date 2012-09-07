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
	$promo_title = getValueFromRequest('promo-title');
	$big_title = getValueFromRequest('promo-big-title');
	$short_title = getValueFromRequest('promo-short-title');
	$promo_link_text = getValueFromRequest('promo-link-text');
	$short_description = getValueFromRequest('promo-short-desc');
	$tunein_title = getValueFromRequest('promo-tunein-text');
	$sub_header_title = getValueFromRequest('sub-header');
	
	
	$promo_type = getValueFromRequest('promo-type');
	$show_id = getValueFromRequest('show-id');
	$show_css = getValueFromRequest('show-css');
	
	$main_image = getValueFromRequest('main-image-field');
	$main_image_changed = getValueFromRequest('main-image-field-changed');
	$thumbnail_image = getValueFromRequest('thumbnail-image-field');
	$thumbnail_image_changed = getValueFromRequest('thumbnail-image-field-changed');
	
	$publish = getValueFromRequest('publish');
	$unpublish = getValueFromRequest('unpublish');
	$url_link = getValueFromRequest('url-link');
	$url_link_new =  getValueFromRequest('url-link');
	$seo = getValueFromRequest('seo');
	$nid = getValueFromRequest('nid');
   
	
	
	
	if($nid) {
		$node = new stdClass();
		$node->nid = $nid;
		$node->created = time();
	} else {
		$node = node_load($nid);
	}
	
	if(!empty($main_image) && $main_image_changed && $main_image_changed="true") {
		$main_image = UPLOAD_ROOT.DIRECTORY_SEPARATOR.
					   basename(str_ireplace("http:/","",$main_image));
		$node->field_image_promo = array(getImageField($main_image, $user->uid));
	} 
	if(!empty($thumbnail_image) && $thumbnail_image_changed && $thumbnail_image_changed=="true") {
		$thumbnail_image = UPLOAD_ROOT.DIRECTORY_SEPARATOR.
					   basename(str_ireplace("http:/","",$thumbnail_image));
		$node->field_promo_main_image = array(getImageField($thumbnail_image, $user->uid));
	}
	
	$node->type = 'promo_homepage'; 
    $node->uid = $user->uid;
    $node->status = 1;
    $node->changed = time();
    $node->title = $promo_title;
    $node->name = $user->name;
    $node->field_big_title = Array(Array('value' => $big_title));
    $node->field_promo_link_desc_text = Array(Array('value' => $promo_link_text));
	$node->field_promo_link_url = Array(Array(
                    'url' => $url_link,
                    'title' => '', 
                    'attributes' => Array('target' => ($url_link_new == 'on')?'':'_blank')));
    $node->field_promo_order = Array(Array('value' => 5));
    $node->field_promo_sub_header = Array(Array('value' => $sub_header_title));
    $node->field_promo_title = Array(Array('value' => $seo));
    $node->field_short_description = Array(Array('value' => $short_description));
    $node->field_short_title = Array(Array('value' => $short_title));
	$node->field_show_css = Array(Array('value' => $show_css));
	$node->field_tune_text = Array(Array('value' => $tunein_title));
	$node->publish_on = $publish;
    $node->unpublish_on = $unpublish;
    $node->scheduler = Array (
    	'publish_on' => $publish,
        'unpublish_on' => $unpublish,
    );
    
	$promo_type_taxonomy_class = new stdClass();
	$promo_type_taxonomy_class->tid = $promo_type;
	$promo_type_taxonomy_class->vid = 4;
	
	$show_id_taxonomy_class = new stdClass();
	$show_id_taxonomy_class->tid = $show_id;
	$show_id_taxonomy_class->vid = 5;
	
    $node->taxonomy =  array($promo_type => $promo_type_taxonomy_class,
						     $show_id => $show_id_taxonomy_class);
	
	node_save($node);
	print_r(drupal_to_js(node_load($node->nid)));
	exit;
}

function getValueFromRequest($key) {
	return $_POST[$key];
}

function getImageField($file_drupal_path, $uid, $status=FILE_STATUS_PERMANENT){
	
  file_copy($file_drupal_path);
  
  $file=(object)array(
    'filename' =>basename($file_drupal_path),
    'filepath' =>$file_drupal_path,
    'filemime' =>file_get_mimetype($file_drupal_path),
    'filesize' =>filesize($file_drupal_path),
    'uid'      =>$uid,
    'status'   =>$status,
    'timestamp'=>time(),
  );
  drupal_write_record('files',$file);
  $data = field_file_load($file_drupal_path);
  return $data;
}