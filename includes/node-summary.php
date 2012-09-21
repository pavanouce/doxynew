<?php if(!isset($node->nid)): ?>
	<a href="#node-promo-<?php print $tabid; ?>" 
	data-tab-id="<?php print $tabid; ?>" data-nid="<?php print $tabid; ?>">
		<span class="node-title">Promo <?php print $tabid; ?></span>
	<span title="remove" class="remove-promo"></span>
	</a>
<?php else: ?>
	<?php 
		$nid = $node->nid;
		$thumbnail_image_src= $node->field_image_promo[0]['filepath'];
		if($thumbnail_image_src) {
			//print $thumbnail_image_src; exit;
			$thumbnail_image = theme('imagecache', 'promo_image_thumbnail', 
			$thumbnail_image_src,  $node->field_short_title[0]['view'], 
			 $node->field_short_title[0]['view'], array('class' => 'image_summary'));
			  $thumbnail_image = file_directory_path().
			  				'/imagecache/promo_image_thumbnail/'.
			  				$node->field_image_promo[0]['filename'];
		}
		if($clone) {
			$nid = $tabid;
		}	
	 ?>
	 
	<a data-nid="<?php print $nid; ?>" data-tab-id="<?php print $nid; ?>"
				 href="#node-promo-<?php print $nid; ?>">
		<span class="node-title"><?php print substr($node->title,0,10); ?></span>
		<span title="remove" class="remove-promo"></span>
		<?php if($thumbnail_image_src): ?>
		<img src="/<?php print $thumbnail_image; ?>" class="image_summary"></img>
		<?php endif; ?>
		
		<?php if($node->scheduler['publish_on']): ?>
		<br/>
			<span class="summary_time"><?php print date("M d Y h:i:s A",$node->scheduler['publish_on']); ?></span>
		<?php endif; ?>
		
	</a>
<?php endif; ?>