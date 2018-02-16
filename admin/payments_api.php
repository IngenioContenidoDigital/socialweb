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

$menu['payments'] = 'active';
$menu['payments_api'] = 'active';
$menu['payments_display'] = 'block';
$page['name'] = 'Payments API';

$user = $system->getUserInfo($_SESSION['user_id']);

if(!$auth->isLogged() || $user->is_admin != 1) {
	header('Location: index.php');
	exit;
}

if(isset($_POST['save'])) {
	$fortumo_service_id = $_POST['fortumo_service_id'];
	$paypal_email = $_POST['paypal_email'];
	$stripe_secret_key = $_POST['stripe_secret_key'];
	$stripe_publishable_key = $_POST['stripe_publishable_key'];
	$currency = $_POST['currency'];
	$db->query("
		UPDATE settings SET 
		fortumo_service_id='".$fortumo_service_id."',
		paypal_email='".$paypal_email."',
		stripe_secret_key='".$stripe_secret_key."',
		stripe_publishable_key='".$stripe_publishable_key."',
		currency='".$currency."'");
	header('Location: payments_api.php');
	exit;
}

$settings = $system->getSettings();

require('../inc/admin/top.php');
require('../layout/admin/payments_api.php');
require('../inc/admin/bottom.php');