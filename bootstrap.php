<?php


error_reporting(E_ALL);
ini_set('display_errors', 'on');
define('DOCUMENT_ROOT',  dirname(dirname(__FILE__)));

define('APPLICATION_ROOT',  dirname(__FILE__));
define('UPLOAD_ROOT', APPLICATION_ROOT.DIRECTORY_SEPARATOR.'php_ajax_image_upload'.DIRECTORY_SEPARATOR.'uploads');
require_once 'utils.php';
chdir('../');
require_once './includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
define('FILE_ROOT',DOCUMENT_ROOT.DIRECTORY_SEPARATOR.file_directory_path());

$GLOBALS['base_path']="/";

error_reporting(E_ALL);
ini_set('display_errors', 'on');
global $user;
//print_r($user); exit;
/*
if($user->uid==0) {
	return drupal_access_denied();
	exit;
}
*/