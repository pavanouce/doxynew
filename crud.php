<?php include 'includes/header.php'; ?>
<?php
	$count = sizeof($nodes);
	if($count==0) {
		$count = 1;
	}
	$nid = "";
	$content_nids = "";
	$publish_on = "";
	$unpublish_on = "";
	$format = "m/d/Y H:i";
	$title = "";
	if(isset($node->nid)) {
		$nid = $node->nid;
		$content_nids = $node->content_nids;
		$publish_on = ($node->publish_on)?date($format,$node->publish_on):"";
		$unpublish_on = ($node->unpublish_on)?date($format,$node->unpublish_on):"";
		$title = $node->title;
	} 
?>
<div class="content">
	<form method="POST" class="promo-list-form ui-widget-header " id="promo-list-form" action="promo_list_services.php">
			<input id="promo_list_nid" type="hidden" name="promo_list_nid" value="<?php print $nid; ?>"></input>
			<input type="hidden" name="promo-list-content-nids"
			 id="promo-list-content-nids" value="<?php print $content_nids; ?>"></input>
			 <input type="hidden" name="nodes_count" 
			 value="<?php print $count; ?>" class="nodes_count"></input>
			<div class="form-item list-save-wrapper">
				<input src="images/save.gif" title="Save this list" type="image" class="list-save"></input>
			</div>
			<div class="form-item promo-list-title-wrapper">
				<label class="promo-list-title">Title</label>
				<input class="required" type="text" name="promo-list-title"
					value="<?php print $title; ?>" id="promo-list-title"></input>	
			</div>
			<div class="form-item promo-list-publish-on-wrapper">
				<label class="promo-list-title">Scheduled Publish</label>
				<input type="text" name="promo-list-publish-on"
					value="<?php print $publish_on; ?>" id="promo-list-publish-on"></input>
			</div>
			
			<div class="form-item promo-list-aply-wrapper">
				<input type="submit" name="promo-list-apply" title="Apply the date to all the items in the list"
					value="Apply" id="promo-list-apply"></input>
			</div>
			
			<div class="form-item promo-list-unpublish-on-wrapper">
				<label class="promo-list-title">Scheduled Unpublish</label>
				<input type="text" name="promo-list-unpublish-on"
				value="<?php print $unpublish_on; ?>" id="promo-list-unpublish-on"></input>
			</div>
			<input type="submit" title="Save and Preview" class="list-save-preview" value="Save and preview"></input>
			<input type="submit" title="View Old Promo Nodes" class="list-view-old" value="View Existing"></input>
		</form>
	<div class="promos-list">
		
		<div style="clear:both"></div>
		<?php if(empty($nodes)):?>
			<ul class="list-tabs-container">
				<li class="list-element">
					<?php $node = new stdClass(); ?>
					<?php print render_file('includes'.DIRECTORY_SEPARATOR.'node-summary.php', 
						array('node'=>$node,'tabid'=>1,'clone'=>false)); ?>
				</li>
				<li title="Add existing promo" class="list-actions add-existing">
					<span lass="list-add"></span>
					<span class="label">Add Existing</span>
				</li>
				<li title="Add new promo" class="list-actions add-new">
					<span class="list-add"></span>
					<span class="label">Add New</span>
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
				<li class="list-element">
					<?php print render_file('includes'.DIRECTORY_SEPARATOR.'node-summary.php', 
					array('node'=>$node,'tabid'=>$node->nid, 'clone'=>false)); ?>
				 </li>
			<?php endforeach; ?>
				<li class="list-actions add-existing">
					<span title="Add another promo" class="list-add"></span>
					<span class="label">Add Existing</span>
				</li>
				<li class="list-actions add-new">
					<span title="Add another promo" class="list-add"></span>
					<span class="label">Add New</span>
				</li>
			</ul>
			<?php foreach($nodes as $node): ?>
				<?php print render_file('includes'.DIRECTORY_SEPARATOR.'node-form.php', 
					array('node' => $node,'data_nid'=>$node->nid,'data_tab_id'=>$node->nid)); ?>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
	<div class="promo-contents"></div>
	<div class="dialog"></div>
	<div id="dialog-confirm"></div>
	<div class="old-promo-dialog">
		<div class="search-fields">
			<input type="text" class="search-list-date"></input>
			<input type="submit" value="Search" class="search-old-promo"></input>
		</div>
		<div class="results-container">
			<div class="message"></div>
			<table class="results-table">
			</table>
		</div>
	</div>
</div>
<?php include 'includes/images_uploader.php'; ?>
<?php include 'includes/footer.php'; ?>