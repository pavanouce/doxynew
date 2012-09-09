<?php
$nid = "";
$node_num = 1;

if(isset($node->nid)) {
	$nid = $node->nid;
	$node_num = $nid;
} 

?>
<div id="node-promo-<?php print $node_num; ?>" class="promo-node">
	<form data-nid="<?php print $data_nid; ?>" action="promo_node_services.php" method="post" name="promo_list"
		class="promo_list" enctype="multipart/form-data">
		<input type="hidden" value="<?php print $nid; ?>" name="nid" class="node-id"></input>
		<div class="tabs">
			<ul>
				<li><a href="#tabs-fields-<?php print $data_tab_id; ?>">Promo Fields</a>
				</li>
				<li><a href="#tabs-image-main-<?php print $data_tab_id; ?>">Main Image</a>
				</li>
				<li><a href="#tabs-image-thumbnail-<?php print $data_tab_id; ?>">Thumbnail Image</a>
				</li>
				<li><a href="#tabs-scheduling-<?php print $data_tab_id; ?>">Scheduling</a>
				</li>
				<li><a href="#tabs-url-<?php print $data_tab_id; ?>">URL</a>
				</li>
			</ul>
			<div id="tabs-fields-<?php print $data_tab_id; ?>">
				<div class="form-item promo-title-wrapper">
					<label>Title</label> <input type="text" class="required"
						name="promo-title"></input>
				</div>
				<div class="form-item  promo-big-title-wrapper">
					<label>Big Title</label> <input type="text" class="required"
						name="promo-big-title"></input>
				</div>
				<div class="form-item promo-short-title-wrapper">
					<label>Short Title</label> <input type="text" class="required"
						name="promo-short-title"></input>
				</div>
				<div class="form-item promo-link-text-wrapper">
					<label>Promo Link Text</label> <input type="text" class="required"
						name="promo-link-text"></input>
				</div>
				<div class="form-item promo-short-desc-wrapper">
					<label>Short Description</label> <input type="text"
						class="required" name="promo-short-desc"></input>
				</div>
				<div class="form-item promo-tunein-text-wrapper">
					<label>Tune in Text</label> <input type="text" class="required"
						name="promo-tunein-text"></input>
				</div>
				<div class="form-item promo-sub-header-wrapper">
					<label>Sub Header</label> <input type="text" class="required"
						name="sub-header"></input>
				</div>


			</div>
			<div class="image_upload" id="tabs-image-main-<?php print $data_tab_id; ?>">
				<button data-form-id="main_image_upload">Upload Image</button>
				<input data-id="main_image_upload_area" class="required main-image-field"
					type="hidden" name="main-image-field" value="" /> 
				<input data-value-id="main_image_upload_area"
					type="hidden" name="main-image-field-changed" value="false" />
				<div class="main_image_upload_area"></div>
				<div class="image_crop_info x1_area">
					x1: <span></span>
				</div>
				<div class="image_crop_info y1_area">
					y1: <span></span>
				</div>
				<div class="image_crop_info x2_area">
					x2: <span></span>
				</div>
				<div class="image_crop_info y2_area">
					y2: <span></span>
				</div>
				<div class="image_crop_info width_area">
					w: <span></span>
				</div>
				<div class="image_crop_info height_area">
					h: <span></span>
				</div>
			</div>
			<div class="image_upload" id="tabs-image-thumbnail-<?php print $data_tab_id; ?>">
				<button data-form-id="thumbnail_image_upload">Upload Image</button>
				<input data-id="thumbnail_image_upload_area" 
					class="required thumbnail-image-field" type="hidden"
					name="thumbnail-image-field" value="" /> 
				<input
					data-value-id="thumbnail_image_upload_area" type="hidden"
					name="thumbnail-image-field-changed" value="false" />
				<div class="thumbnail_image_upload_area"></div>
				<div class="image_crop_info x1_area">
					x1: <span></span>
				</div>
				<div class="image_crop_info y1_area">
					y1: <span></span>
				</div>
				<div class="image_crop_info x2_area">
					x2: <span></span>
				</div>
				<div class="image_crop_info y2_area">
					y2: <span></span>
				</div>
				<div class="image_crop_info width_area">
					w: <span></span>
				</div>
				<div class="image_crop_info height_area">
					h: <span></span>
				</div>
			</div>
			<div id="tabs-scheduling-<?php print $data_tab_id; ?>">
				<div class="form-item promo-publish">
					<label>Publish Date:</label> <input type="text" id="edit-publish"
						name="publish"></input>
				</div>
				<div class="form-item promo-unpublish">
					<label>Un-Publish Date:</label> <input type="text"
						id="edit-unpublish" name="unpublish"></input>
				</div>
			</div>
			<div id="tabs-url-<?php print $data_tab_id; ?>">
				<div class="form-item url-link">
					<label>URL Link</label> <input type="text" name="url-link"></input>
					<input class="new-window-check" class="check-<?php print $nid; ?>" type="checkbox" name="url-link-new"></input>
					<label class="new-window" for="check-<?php print $nid; ?>">Open in New Window?</label>
				</div>
				<div class="form-item promo-seo-wrapper">
					<label>SEO</label> <input type="text" name="seo"></input>
				</div>
				<div class="form-item promo-type-wrapper">
					<label>Promo Type</label> <select name="promo-type">
						<option value="10">THE GLEE PROJECT</option>
						<option value="11">BAD GIRLS CLUB</option>
						<option value="12">WHATEVER</option>
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
			<input type="submit" value="Save Promo"></input>
		</div>
	</form>
	<div class="preview">
		<div class="preview-label">Live Preview</div>
		<img src="images/oxy1.png" />
	</div>
</div>
