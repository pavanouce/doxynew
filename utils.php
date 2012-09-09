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
	return $_POST[$key];
}
