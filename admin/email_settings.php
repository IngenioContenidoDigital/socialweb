<?php
define('IS_AJAX', true);
session_set_cookie_params(172800);
session_start();
require('../core/config.php');
require('../core/auth.php');
require('../core/system.php');
$auth = new Auth;
$system = new System;

$system->domain = $domain;
$system->db = $db;

$menu['email_settings'] = 'active';
$page['name'] = 'Email Settings';

$user = $system->getUserInfo($_SESSION['user_id']);

if(!$auth->isLogged() || $user->is_admin != 1) {
	header('Location: index.php');
	exit;
}

if(isset($_POST['save'])) {
	$email_sender = $_POST['email_sender'];
	$smtp_host = $_POST['smtp_host'];
	$smtp_username = $_POST['smtp_username'];
	$smtp_password = $_POST['smtp_password'];
	$smtp_encryption = $_POST['smtp_encryption'];
	$smtp_port = $_POST['smtp_port'];
	$db->query("
		UPDATE settings SET 
		email_sender='".$email_sender."',
		smtp_host='".$smtp_host."',
		smtp_username='".$smtp_username."',
		smtp_password='".$smtp_password."',
		smtp_encryption='".$smtp_encryption."',
		smtp_port='".$smtp_port."'
		");
	header('Location: email_settings.php');
	exit;
}

$settings = $system->getSettings();

require('../inc/admin/top.php');
require('../layout/admin/email_settings.php');
require('../inc/admin/bottom.php');