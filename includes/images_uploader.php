<div class="dialogboxeshtml" style="display: none">
	<form action="php_ajax_image_upload/scripts/ajaxupload.php"
		method="post" name="main_image_upload" id="main_image_upload"
		enctype="multipart/form-data">
		<p>
			<input type="file" name="filename" id="main_file_upload" />
		</p>
		<button
			onclick="ajaxUpload(this.form,'php_ajax_image_upload/scripts/ajaxupload.php?filename=filename&amp;maxSize=9999999999&amp;maxW=1200&amp;fullPath=http://<?php print $_SERVER['HTTP_HOST']; ?><?php print $_SERVER['REQUEST_URI']; ?>/php_ajax_image_upload/uploads/&amp;relPath=../uploads/&amp;colorR=255&amp;colorG=255&amp;colorB=255&amp;maxH=1200','main_image_upload_area','File Uploading Please Wait...&lt;br /&gt;&lt;img src=\'images/loader_light_blue.gif\' width=\'128\' height=\'15\' border=\'0\' /&gt;','&lt;img src=\'images/error.gif\' width=\'16\' height=\'16\' border=\'0\' /&gt; Error in Upload, check settings and path info in source code.'); return false;">Upload
			Image</button>
	</form>
	<form action="php_ajax_image_upload/scripts/ajaxupload.php"
		method="post" name="thumbnail_image_upload"
		id="thumbnail_image_upload" enctype="multipart/form-data">
		<p>
			<input type="file" name="filename" id="thumbnail_file_upload" />
		</p>
		<button
			onclick="ajaxUpload(this.form,'php_ajax_image_upload/scripts/ajaxupload.php?filename=filename&amp;maxSize=9999999999&amp;maxW=1200&amp;fullPath=http://<?php print $_SERVER['HTTP_HOST']; ?><?php print $_SERVER['REQUEST_URI']; ?>/php_ajax_image_upload/uploads/&amp;relPath=../uploads/&amp;colorR=255&amp;colorG=255&amp;colorB=255&amp;maxH=1200','thumbnail_image_upload_area','File Uploading Please Wait...&lt;br /&gt;&lt;img src=\'images/loader_light_blue.gif\' width=\'128\' height=\'15\' border=\'0\' /&gt;','&lt;img src=\'images/error.gif\' width=\'16\' height=\'16\' border=\'0\' /&gt; Error in Upload, check settings and path info in source code.'); return false;">Upload
			Image</button>
	</form>
	<div class="saving-box">
		<div class="progress">
			<div class="bar"></div>
			<div class="percent">0%</div>
		</div>
	</div>
</div>