<?php
$nid = "";
$node_num = $data_tab_id;
$promo_title = "";
$big_title = "";
$short_title = "";
$promo_link_text = "";
$short_desc = "";
$tune_in_text = "";
$sub_header = "";
$publish_date = "";
$unpublish_date = "";
$url_link = "";
$seo = "";
$promo_type= "";
$show_id = "";
$show_css = "";
$url_new_window = false;
$format = "m/d/Y H:i";
$field_values = getFieldValues('field_promo_type');
$main_image = null;
$main_image_x1 = 0;
$main_image_y1 = 0;
$main_image_width = 0;
$main_image_height = 0;
$main_image_x2 =  0;
$main_image_y2 = 0;
$main_image_src = "";

$thumbnail_image_src = "";
$thumbnail_image_x1 = 0;
$thumbnail_image_y1 = 0;
$thumbnail_image_x2 = 0;
$thumbnail_image_y2 = 0;
$thumbnail_image_width = 0;
$thumbnail_image_height = 0;
$weight = 0;
if(isset($node->nid)) {
	$nid = $node->nid;
	$node_num = $nid;
	$promo_title = $node->title;
	$big_title = $node->field_big_title[0]['value'];
	$short_title = $node->field_short_title[0]['value'];
	$promo_link_text = $node->field_promo_link_desc_text[0]['value'];
	$short_desc = $node->field_short_description[0]['value'];
	$tune_in_text = $node->field_tune_text[0]['value'];
	$sub_header = $node->field_promo_sub_header[0]['value'];
	$publish_date = ($node->scheduler['publish_on'])?date($format,$node->scheduler['publish_on']):"";
	$unpublish_date = ($node->scheduler['unpublish_on'])?date($format,$node->scheduler['unpublish_on']):"";
	$url_link = $node->field_promo_link_url[0]['url'];
	$seo =  $node->field_promo_title[0]['value'];
	$promo_type= $node->field_promo_type[0]['value'];
	$show_id = "";
	$show_css = $node->field_show_css[0]['value'];
	$url_new_window = ($node->field_promo_link_url[0]['attributes']['target'] == '_blank');
	$weight = $node->field_promo_order[0]['value'];
	//print_r($node); exit;
	$main_image = $node->field_promo_main_image;
	
	if(is_array($main_image) && isset($main_image[0])) {
		$main_image_x1 = $main_image[0]['data']['crop']['x'];
		$main_image_y1 = $main_image[0]['data']['crop']['y'];
		$main_image_width = $main_image[0]['data']['crop']['width'];
		$main_image_height = $main_image[0]['data']['crop']['height'];
		$main_image_x2 =  $main_image_width+$main_image_x1;
		$main_image_y2 = $main_image_height+$main_image_y1;
		$main_image_src = '/'.imagefield_crop_file_admin_crop_display_path($main_image[0]);
	}
	if(isset($node->field_image_promo[0])) {	
		$thumbnail_image_src= '/'.$node->field_image_promo[0]['filepath'];
		if(isset($node->field_image_promo[0]['data'])) {
			$crop_info = explode(',',$node->field_image_promo[0]['data']['focus_rect']);
			//print_r($crop_info); exit;
			$thumbnail_image_x1 = $crop_info[0];
			$thumbnail_image_y1 = $crop_info[1];
			$thumbnail_image_x2 = $crop_info[2];
			$thumbnail_image_y2 = $crop_info[3];
			$thumbnail_image_width = $thumbnail_image_x2-$thumbnail_image_x1;
			$thumbnail_image_height = $thumbnail_image_y2-$thumbnail_image_y1;
		}
		
	}
	//print $thumbnail_image_src; exit;
	/*
	[field_image_promo] => Array
        (
            [0] => Array
                (
                    [fid] => 814376
                    [list] => 1
                    [data] => Array
                        (
                            [focus_rect] => 210,196,591,394
                            [crop_rect] => 
                            [alt] => 
                            [title] => 
                        )

                    [uid] => 1
                    [filename] => desert_1347402773.jpg
                    [filepath] => sites/default/files/desert_1347402773.jpg
                    [filemime] => image/jpeg
                    [filesize] => 671912
                    [status] => 1
                    [timestamp] => 1347402899
                )

        )
        */
	//Fields Missing
	// Promo type, show id, main image, thumbnail image
}

if($clone) {
	$data_nid = $data_tab_id;
	$nid = "";
	$node_num = $data_tab_id;
}
?>
<div id="node-promo-<?php print $node_num; ?>" class="promo-node">
	<form data-nid="<?php print $data_nid; ?>"
		action="promo_node_services.php" method="post" name="promo_list"
		class="promo_list" enctype="multipart/form-data">
		<input type="hidden" value="<?php print $nid; ?>" name="nid"
			class="node-id"></input>
		<input type="hidden" value="<?php print $weight; ?>" name="weight" class="node-weight"></input>
		<div class="tabs">
			<ul>
				<li><a href="#tabs-fields-<?php print $data_tab_id; ?>">Promo Fields</a>
				</li>
				<li><a href="#tabs-image-main-<?php print $data_tab_id; ?>">Main
						Image</a>
				</li>
				<li><a href="#tabs-image-thumbnail-<?php print $data_tab_id; ?>">Thumbnail
						Image</a>
				</li>
				<li><a href="#tabs-scheduling-<?php print $data_tab_id; ?>">Scheduling</a>
				</li>
				<li><a href="#tabs-url-<?php print $data_tab_id; ?>">URL</a>
				</li>
			</ul>
			<div id="tabs-fields-<?php print $data_tab_id; ?>">
				<div class="form-item promo-title-wrapper">
					<label>Title</label> <input type="text" class="required"
						name="promo-title" value="<?php print $promo_title; ?>"></input>
				</div>
				<div class="form-item  promo-big-title-wrapper">
					<label>Big Title</label> <input type="text" 
						value="<?php print $big_title; ?>" name="promo-big-title"></input>
				</div>
				<div class="form-item promo-short-title-wrapper">
					<label>Short Title</label> <input type="text" 
						value="<?php print $short_title; ?>" name="promo-short-title"></input>
				</div>
				<div class="form-item promo-link-text-wrapper">
					<label>Promo Link Text</label> <input type="text"
						value="<?php print $promo_link_text; ?>" name="promo-link-text"></input>
				</div>
				<div class="form-item promo-short-desc-wrapper">
					<label>Short Description</label> 
					<textarea type="text"
						name="promo-short-desc"><?php print $short_desc; ?></textarea>
				</div>
				<div class="form-item promo-tunein-text-wrapper">
					<label>Tune in Text</label> <input type="text" 
						value="<?php print $tune_in_text; ?>" name="promo-tunein-text"></input>
				</div>
				<div class="form-item promo-sub-header-wrapper">
					<label>Sub Header</label> <input type="text" 
						value="<?php print $sub_header; ?>" name="sub-header"></input>
				</div>


			</div>
			<div class="image_upload"
				id="tabs-image-main-<?php print $data_tab_id; ?>">
				<button
					data-form-id="main_image_upload-<?php print $data_tab_id; ?>">Upload
					Image</button>
				<input data-id="main_image_upload_area-<?php print $data_tab_id; ?>"
					class="main-image-field" type="hidden"
					name="main-image-field" value="<?php print $main_image_src; ?>" /> <input
					data-value-id="main_image_upload_area-<?php print $data_tab_id; ?>"
					type="hidden" name="main-image-field-changed" value="false" />
				<div class="image_area" id="main_image_upload_area-<?php print $node_num; ?>">
					<?php if($main_image_src): ?>
					<img class="main_image" src="<?php echo $main_image_src; ?>" border="0"></img>
					<?php endif; ?>
				</div>
				<div class="crop-info">
					<div class="image_crop_info x1_area">
						<label>x1:</label> <input type="text" name="x1" class="x1" 
						value="<?php print $main_image_x1; ?>" /></input>
					</div>
					<div class="image_crop_info y1_area">
						<label>y1:</label> <input type="text" name="y1" class="y1"
						 value="<?php print $main_image_y1; ?>" /></input>
					</div>
					<div class="image_crop_info x2_area">
						<label>x2:</label> <input type="text" name="x2" class="x2"
						 value="<?php print $main_image_x2; ?>" /></input>
					</div>
					<div class="image_crop_info y2_area">
						<label>y2:</label> <input type="text" name="y2" class="y2" 
						value="<?php print $main_image_y2; ?>" /></input>
					</div>
					<div class="image_crop_info width_area">
						<label>w :</label> <input type="text" name="width" class="width" 
						value="<?php print $main_image_width; ?>" /></input>
					</div>
					<div class="image_crop_info height_area">
						<label>h :</label> <input type="text" name="height" class="height"
							value="<?php print $main_image_height; ?>" /></input>
					</div>
				</div>
			</div>
			<div class="image_upload"
				id="tabs-image-thumbnail-<?php print $data_tab_id; ?>">
				<button
					data-form-id="thumbnail_image_upload-<?php print $data_tab_id; ?>">Upload
					Image</button>
				<input
					data-id="thumbnail_image_upload_area-<?php print $data_tab_id; ?>"
					class="thumbnail-image-field" type="hidden"
					name="thumbnail-image-field" value="<?php echo $thumbnail_image_src; ?>" /> 
				<input
					data-value-id="thumbnail_image_upload_area-<?php print $data_tab_id; ?>"
					type="hidden" name="thumbnail-image-field-changed" value="false" />
				<div class="image_area" id="thumbnail_image_upload_area-<?php print $node_num; ?>">
					<?php if($thumbnail_image_src): ?>
					<img class="main_image" src="<?php echo $thumbnail_image_src; ?>" border="0"></img>
					<?php endif; ?>
				</div>
				<div class="crop-info">
					<div class="image_crop_info x1_area">
						<label>x1:</label> <input type="text" name="tx1" class="x1" 
						value="<?php print $thumbnail_image_x1; ?>" /></input>
					</div>
					<div class="image_crop_info y1_area">
						<label>y1:</label> <input type="text" name="ty1" class="y1" 
						value="<?php print $thumbnail_image_y1; ?>" /></input>
					</div>
					<div class="image_crop_info x2_area">
						<label>x2:</label> <input type="text" name="tx2" class="x2" 
						value="<?php print $thumbnail_image_x2; ?>" /></input>
					</div>
					<div class="image_crop_info y2_area">
						<label>y2:</label> <input type="text" name="ty2" class="y2" 
						value="<?php print $thumbnail_image_y2; ?>" /></input>
					</div>
					<div class="image_crop_info width_area">
						<label>w :</label> <input type="text" name="twidth" class="width" 
						value="<?php print $thumbnail_image_width; ?>" /></input>
					</div>
					<div class="image_crop_info height_area">
						<label>h :</label> <input type="text" name="theight" class="height"
							value="<?php print $thumbnail_image_height; ?>" /></input>
					</div>
				</div>
			</div>
			<div id="tabs-scheduling-<?php print $data_tab_id; ?>">
				<div class="form-item promo-publish">
					<label>Publish Date:</label> <input type="text"
						<?php if(!empty($publish_date)): ?>
						data-value="true"
						<?php endif; ?>
						class="edit-publish" value="<?php print $publish_date; ?>"
						name="publish"></input>
				</div>
				<div class="form-item promo-unpublish">
					<label>Un-Publish Date:</label> <input type="text"
						<?php if(!empty($unpublish_date)): ?>
						data-value="true"
						<?php endif; ?>
						value="<?php print $unpublish_date; ?>" class="edit-unpublish"
						name="unpublish"></input>
				</div>
			</div>
			<div id="tabs-url-<?php print $data_tab_id; ?>">
				<div class="form-item url-link">
					<label>URL Link</label> <input value="<?php print $url_link; ?>"
						type="text" name="url-link"></input> <input
						class="new-window-check" class="check-<?php print $nid; ?>"
						type="checkbox" <?php if($url_new_window):  ?> checked="checked"
						<?php endif; ?> name="url-link-new"></input> <label
						class="new-window" for="check-<?php print $nid; ?>">Open in New
						Window?</label>
				</div>
				<div class="form-item promo-seo-wrapper">
					<label>SEO</label> <input value="<?php print $seo; ?>" type="text"
						name="seo"></input>
				</div>
				<div class="form-item promo-type-wrapper">
					<label>Promo Type</label> <select class="required"
						name="promo-type">
						<?php foreach($field_values as $value): ?>
						<option <?php if($promo_type == $value): ?> selected="selected"
						<?php endif; ?> value="<?php print $value; ?>">
							<?php print $value; ?>
						</option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-item show_id-wrapper">
					<label>Show Id</label> <select name="show-id">
						<option value="10">THE GLEE PROJECT</option>
						<option value="11">BAD GIRLS CLUB</option>
						<option value="12">WHATEVER</option>
					</select>
				</div>
				<div class="form-item show-css-wrapper">
					<label>Show css</label> <select name="show-css">
						<option value="10">THE GLEE PROJECT</option>
						<option value="11">BAD GIRLS CLUB</option>
						<option value="12">WHATEVER</option>
					</select>
				</div>
			</div>
		</div>
		<div class="submit-promo">
			<input type="submit" value="Save Promo" class="node-save"></input>
		</div>
	</form>
	<div class="preview">
		<?php if($nid): ?>
		<?php print render_file('../sites/all/themes/oxygenhomepage/node-promo_homepage.tpl.php'
		,array('node'=>$node)); ?>
		<?php endif; ?>
	</div>
</div>
						<?php
						print render_file('includes'.DIRECTORY_SEPARATOR.'images_uploader.php',
	array('id' => $node_num));
?>