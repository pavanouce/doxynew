<html>
	<head>
		<title>New Promo Page Design</title>
		<script src="js/jquery-1.8.0.min.js" type="text/javascript"></script>
		<script src="js/jquery-ui-1.8.23.custom.min.js" type="text/javascript"></script>
		<script src="js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
		<script src="js/jquery.validate.js" type="text/javascript"></script>
		<script src="js/jquery.Jcrop.min.js" type="text/javascript"></script>
		<script src="js/jquery.form.js" type="text/javascript"></script>
		<script src="js/jquery.jgrowl.js" type="text/javascript"></script>
		<script src="php_ajax_image_upload/scripts/ajaxupload.js" type="text/javascript"></script>
		<script src="js/promo.js" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.8.23.custom.css"></link>
		<link rel="stylesheet" type="text/css" href="css/promo.css"></link>
		<link rel="stylesheet" type="text/css" href="css/jquery.Jcrop.css"></link>
		<link rel="stylesheet" type="text/css" href="css/jquery.jgrowl.css"></link>
	</head>
	<body>
		<div class="content">
			<div class="promos-list">
				<ul>
					<li><a href="#node-promo-1">Promo 1</a></li>
					<li><a href="#node-promo-2">Promo 2</a></li>
					<li><a href="#node-promo-3">Promo 3</a></li>
				</ul>
				<div id="node-promo-1" class="promo-node">
					<form action="services.php" method="post" name="promo_list" id="promo_list" enctype="multipart/form-data">
						<input type="hidden" value="" name="nid" class="node-id"></input>
						<div class="tabs">
							<ul>
								<li><a href="#tabs-fields">Promo Fields</a></li>
								<li><a href="#tabs-image-main">Main Image</a></li>
								<li><a href="#tabs-image-thumbnail">Thumbnail Image</a></li>
								<li><a href="#tabs-scheduling">Scheduling</a></li>
								<li><a href="#tabs-url">URL</a></li>
							</ul>
							<div id="tabs-fields">
								<div class="form-item promo-title-wrapper">
									<label>Title</label>
									<input type="text" class="required" name="promo-title"></input>
								</div>
								<div class="form-item  promo-big-title-wrapper">
									<label>Big Title</label>
									<input type="text" class="required" name="promo-big-title"></input>
								</div>
								<div class="form-item promo-short-title-wrapper">
									<label>Short Title</label>
									<input type="text" class="required" name="promo-short-title"></input>
								</div>
								<div class="form-item promo-link-text-wrapper">
									<label>Promo Link Text</label>
									<input type="text" class="required" name="promo-link-text"></input>
								</div>
								<div class="form-item promo-short-desc-wrapper">
									<label>Short Description</label>
									<input type="text" class="required" name="promo-short-desc"></input>
								</div>
								<div class="form-item promo-tunein-text-wrapper">
									<label>Tune in Text</label>
									<input type="text"class="required" name="promo-tunein-text"></input>
								</div>
								<div class="form-item promo-sub-header-wrapper">
									<label>Sub Header</label>
									<input type="text" class="required" name="sub-header"></input>
								</div>
								
								
							</div>
							<div class="image_upload" id="tabs-image-main">
								<button data-form-id="main_image_upload">Upload Image</button>
								<input data-id="main_image_upload_area" class="required" type="hidden" id="main-image-field" name="main-image-field" value="" />
								<input data-value-id="main_image_upload_area" type="hidden" name="main-image-field-changed"  value="false" />
								<div id="main_image_upload_area">
								</div>
								<div class="image_crop_info x1_area">x1: <span></span></div>
								<div class="image_crop_info y1_area">y1: <span></span></div>
								<div class="image_crop_info x2_area">x2: <span></span></div>
								<div class="image_crop_info y2_area">y2: <span></span></div>
								<div class="image_crop_info width_area">w: <span></span></div>
								<div class="image_crop_info height_area">h: <span></span></div>
							</div>
							<div class="image_upload" id="tabs-image-thumbnail">
								<button  data-form-id="thumbnail_image_upload">Upload Image</button>
								<input data-id="thumbnail_image_upload_area" class="required" type="hidden" id="thumbnail-image-field" name="thumbnail-image-field" value="" />
								<input data-value-id="thumbnail_image_upload_area" type="hidden" name="thumbnail-image-field-changed"  value="false" />
								<div id="thumbnail_image_upload_area">
								</div>
								<div class="image_crop_info x1_area">x1: <span></span></div>
								<div class="image_crop_info y1_area">y1: <span></span></div>
								<div class="image_crop_info x2_area">x2: <span></span></div>
								<div class="image_crop_info y2_area">y2: <span></span></div>
								<div class="image_crop_info width_area">w: <span></span></div>
								<div class="image_crop_info height_area">h: <span></span></div>
							</div>
							<div id="tabs-scheduling">
								<div class="form-item promo-publish">
									<label>Publish Date:</label>
									<input type="text" id="edit-publish" name="publish"></input>
								</div>
								<div class="form-item promo-unpublish">
									<label>Un-Publish Date:</label>
									<input type="text" id="edit-unpublish" name="unpublish"></input>
								</div>
							</div>
							<div id="tabs-url">
								<div class="form-item url-link">
									<label>URL Link</label>
									<input type="text" name="url-link"></input>
									<input type="checkbox" name="url-link-new"></input>Open in New Window?
								</div>
								<div class="form-item promo-seo-wrapper">
									<label>SEO</label>
									<input type="text" name="seo"></input>
								</div>
								<div class="form-item promo-type-wrapper">
									<label>Promo Type</label>
									<select name="promo-type">
										<option value="10">THE GLEE PROJECT</option>
										<option value="11">BAD GIRLS CLUB</option>
										<option value="12">WHATEVER</option>
									</select>
								</div>
								<div class="form-item show_id-wrapper">
									<label>Show Id</label>
									<select name="show-id">
										<option value="10">THE GLEE PROJECT</option>
										<option value="11">BAD GIRLS CLUB</option>
										<option value="12">WHATEVER</option>
									</select>
								</div>
								<div class="form-item show-css-wrapper">
									<label>Show css</label>
									<select name="show-css">
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
				<div id="node-promo-2">2nd promo</div>
				<div id="node-promo-3">3rd promo</div>
			</div>
			
			<div class="promo-contents">
			</div>
		</div>
		<div class="dialogboxeshtml" style="display:none">
			<form action="php_ajax_image_upload/scripts/ajaxupload.php" method="post" name="main_image_upload" id="main_image_upload" enctype="multipart/form-data">
				<p><input type="file" name="filename" id="main_file_upload" /></p>
				<button onclick="ajaxUpload(this.form,'php_ajax_image_upload/scripts/ajaxupload.php?filename=filename&amp;maxSize=9999999999&amp;maxW=1200&amp;fullPath=http://<?php print $_SERVER['HTTP_HOST']; ?><?php print $_SERVER['REQUEST_URI']; ?>/php_ajax_image_upload/uploads/&amp;relPath=../uploads/&amp;colorR=255&amp;colorG=255&amp;colorB=255&amp;maxH=1200','main_image_upload_area','File Uploading Please Wait...&lt;br /&gt;&lt;img src=\'images/loader_light_blue.gif\' width=\'128\' height=\'15\' border=\'0\' /&gt;','&lt;img src=\'images/error.gif\' width=\'16\' height=\'16\' border=\'0\' /&gt; Error in Upload, check settings and path info in source code.'); return false;">Upload Image</button>
			</form>
			<form action="php_ajax_image_upload/scripts/ajaxupload.php" method="post" name="thumbnail_image_upload" id="thumbnail_image_upload" enctype="multipart/form-data">
				<p><input type="file" name="filename" id="thumbnail_file_upload" /></p>
				<button onclick="ajaxUpload(this.form,'php_ajax_image_upload/scripts/ajaxupload.php?filename=filename&amp;maxSize=9999999999&amp;maxW=1200&amp;fullPath=http://<?php print $_SERVER['HTTP_HOST']; ?><?php print $_SERVER['REQUEST_URI']; ?>/php_ajax_image_upload/uploads/&amp;relPath=../uploads/&amp;colorR=255&amp;colorG=255&amp;colorB=255&amp;maxH=1200','thumbnail_image_upload_area','File Uploading Please Wait...&lt;br /&gt;&lt;img src=\'images/loader_light_blue.gif\' width=\'128\' height=\'15\' border=\'0\' /&gt;','&lt;img src=\'images/error.gif\' width=\'16\' height=\'16\' border=\'0\' /&gt; Error in Upload, check settings and path info in source code.'); return false;">Upload Image</button>
			</form>  
			<div class="saving-box">
				<div class="progress">
        			<div class="bar"></div >
        			<div class="percent">0%</div >
    			</div>
			</div>
		</div>
	</body>
</html>