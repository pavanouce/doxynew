<?php include 'includes/header.php'; ?>
<?php
	$nid = "";
	if(isset($node->nid)) {
		$nid = $nid;
	} 
?>
<div class="content">
	<form method="POST" class="promo-list-form" id="promo-list-form" action="promo_list_services.php">
			<input id="promo_list_nid" type="hidden" name="promo_list_nid" value="<?php print $nid; ?>"></input>
			<input type="hidden" name="promo-list-content-nids" id="promo-list-content-nids" value=""></input>
			<div class="form-item list-save-wrapper">
				<input src="images/save.gif" title="Save this list" type="image" class="list-save"></img>
			</div>
			<div class="form-item promo-list-title-wrapper">
				<label class="promo-list-title">Title</label>
				<input class="required" type="text" name="promo-list-title" id="promo-list-title"></input>	
			</div>
			<div class="form-item promo-list-publish-on-wrapper">
				<label class="promo-list-title">Scheduled Publish</label>
				<input type="text" name="promo-list-publish-on" id="promo-list-publish-on"></input>
			</div>
			
			<div class="form-item promo-list-unpublish-on-wrapper">
				<label class="promo-list-title">Scheduled Unpublish</label>
				<input type="text" name="promo-list-unpublish-on" id="promo-list-unpublish-on"></input>
			</div>
			
		</form>
	<div class="promos-list">
		
		<div style="clear:both"></div>
		<?php if(empty($nodes)):?>
			<ul class="list-tabs-container">
				<li class="list-element"><a href="#node-promo-1" data-tab-id="1" data-nid="1">Promo 1</a></li>
				<li class="list-actions">
					<span title="Add another promo" class="list-add"></span>
				</li>
			</ul>
			
			<?php 
				$node = new stdClass();
				print render_file('includes'.DIRECTORY_SEPARATOR.'node-form.php', 
					array('node' => $node,'data_nid'=>1,'data_tab_id'=>1)); 
			?>
		<?php else: ?>
			<ul class="list-tabs-container">
			<?php foreach($nodes as $node): ?>
			<?php $nid = $node->nid; ?>
				<li class="list-element"><a href="#node-promo-<?php print $nid; ?>">Promo (nid: <?php print $nid; ?>)</a></li>
			<?php endforeach; ?>
				<li class="list-actions">
					<span title="Add another promo" class="list-add"></span>
				</li>
			</ul>
			<?php foreach($nodes as $node): ?>
				<?php print render_file('includes/node-form.php', 
					array('node' => $node,'data_nid'=>$node->nid,'data_tab_id'=>$node->nid)); ?>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
	<div class="promo-contents"></div>
	<div class="promo-list-form">
		
	</div>
	<div class="dialog"></div>
</div>
<?php include 'includes/images_uploader.php'; ?>
<?php include 'includes/footer.php'; ?>