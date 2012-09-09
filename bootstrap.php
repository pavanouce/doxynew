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

error_reporting(E_ALL);
ini_set('display_errors', 'on');