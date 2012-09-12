<?php
function render_file($template_file, $variables) {
	extract($variables, EXTR_SKIP);  // Extract the variables to a local namespace
	$path = APPLICATION_ROOT.DIRECTORY_SEPARATOR.$template_file;
	if(!file_exists($path)) {
		throw new Exception("File at $path not found", 403);
	}
	ob_start();                      // Start output buffering
	require $path;      // Include the template file
	$contents = ob_get_contents();   // Get the contents of the buffer
	ob_end_clean();                  // End buffering and discard
	return $contents;                // Return the contents
}

function getValueFromRequest($key) {
	if(isset($_POST[$key])) {
		if(empty($_POST[$key])) {
			return "";
		} else {
			return $_POST[$key];
		}
	}
	return null;
}

function getFieldValues($field) {
	//field-promo-type
	if(!isset($_GLOBAL['field_'.$field])) {
		$promo_props = db_result(db_query("select global_settings from content_node_field where field_name='$field' "));
		$promo_props =   unserialize($promo_props);
		$allowed_values = explode("\n",$promo_props['allowed_values']);
		$options = array();
		$i = 0;
		foreach($allowed_values as $item) {
			$item_value = trim($item);
			if($i==0 && !$required) {
				$options[""] = "- None -";
			}
			$options[$item_value] = $item_value;
		}
		$promo_one_options = $options;
		$_GLOBAL['field_'.$field] = $promo_one_options;
	}
	return $_GLOBAL['field_'.$field];
}