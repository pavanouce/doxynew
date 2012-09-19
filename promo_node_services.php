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
	
	$publish = strtotime(getValueFromRequest('publish'));
	$unpublish = strtotime(getValueFromRequest('unpublish'));
	$url_link = getValueFromRequest('url-link');
	$url_link_new =  getValueFromRequest('url-link');
	$seo = getValueFromRequest('seo');
	$nid = getValueFromRequest('nid');
   
	$x = getValueFromRequest('x1');
	$y = getValueFromRequest('y1');
	$w = getValueFromRequest('width');
	$h = getValueFromRequest('height');
	
	$tx1 = getValueFromRequest('tx1');
	$ty1 = getValueFromRequest('ty1');
	$tx2 = getValueFromRequest('tx2');
	$ty2 = getValueFromRequest('ty2');
	
	$weight = getValueFromRequest('weight');
	
	
	if(!$nid) {
		$node = new stdClass();
		$node->nid = $nid;
		$node->created = time();
	} else {
		$node = node_load($nid);
	}

	$defaults = array(
	    'x'       => $x?$x:0,
	    'y'       => $y?$y:0,
	    'width'   => $w ? $w : 340,
	    'height'  => $h ? $h : 312,
	    'changed' => 1,
  	);
	
	if(!empty($main_image) && $main_image_changed && $main_image_changed=="true") {
		$main_image = UPLOAD_ROOT.DIRECTORY_SEPARATOR.
					   basename(str_ireplace("http:/","",
					   str_replace(".crop_display.jpg","",$main_image)));
		
		$file = array(getImageField($main_image, $user->uid));
		
		$node->field_promo_main_image = $file;
		$node->field_promo_main_image[0]['data']['crop'] = $defaults;
		imagefield_crop_file_insert((object)$file[0]);
		//print_r($file);
		$result = _imagefield_crop_resize(imagefield_crop_file_admin_original_path($file[0]),
                              $defaults,
                              null,
                              $file[0]['filepath']);
        //print_r($result); exit;
	}  else if($node->field_promo_main_image) {
		//print_r($node->field_promo_main_image);
		$crop = $node->field_promo_main_image[0]['data']['crop'];
		if(($crop['x'] !=$defaults['x']) || ($crop['y'] !=$defaults['y']) 
			|| ($crop['width'] !=$defaults['width']) || ($crop['height'] !=$defaults['height']) ) {
			$node->field_promo_main_image[0]['data']['crop'] = $defaults;
			$file = $node->field_promo_main_image;
			$result = _imagefield_crop_resize(imagefield_crop_file_admin_original_path($file[0]),
                              $defaults,
                              null,
                              $file[0]['filepath']);
		}
		
	}
	if(!empty($thumbnail_image) && $thumbnail_image_changed && $thumbnail_image_changed=="true") {
		$thumbnail_image = UPLOAD_ROOT.DIRECTORY_SEPARATOR.
					   basename(str_ireplace("http:/","",$thumbnail_image));
		$node->field_image_promo = array(getImageField($thumbnail_image, $user->uid));
	}
	if($node->field_image_promo) {
		$node->field_image_promo[0]['data']['focus_rect'] = implode(',',array($tx1,$ty1,$tx2,$ty2));
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
    $node->field_promo_order = Array(Array('value' => $weight));
    $node->field_promo_sub_header = Array(Array('value' => $sub_header_title));
    $node->field_promo_title = Array(Array('value' => $seo));
    $node->field_short_description = Array(Array('value' => $short_description));
    $node->field_short_title = Array(Array('value' => $short_title));
	$node->field_show_css = Array(Array('value' => $show_css));
	$node->field_tune_text = Array(Array('value' => $tunein_title));
	$node->field_promo_type = array(array('value'=>$promo_type));
	$node->publish_on = $publish;
    $node->unpublish_on = $unpublish;
    $node->scheduler = Array (
    	'publish_on' => $publish,
        'unpublish_on' => $unpublish,
    );
    
	$promo_type_taxonomy_class = new stdClass();
	$promo_type_taxonomy_class->tid = 1333;
	$promo_type_taxonomy_class->vid = 4;
	
	$show_id_taxonomy_class = new stdClass();
	$show_id_taxonomy_class->tid = 1339;
	$show_id_taxonomy_class->vid = 5;
	
    $node->taxonomy =  array($promo_type => $promo_type_taxonomy_class,
						     $show_id => $show_id_taxonomy_class);
	//print_r($node);
	node_save($node);
	//print_r(drupal_get_messages());
	print_r(str_replace("\\'","'",drupal_to_js(node_load($node->nid))));
	exit;
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