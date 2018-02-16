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
$menu['vip_pricing'] = 'active';
$menu['payments_display'] = 'block';
$page['name'] = 'VIP Account Pricing';

$user = $system->getUserInfo($_SESSION['user_id']);

if(!$auth->isLogged() || $user->is_admin != 1) {
	header('Location: index.php');
	exit;
}

if(isset($_POST['save'])) {
	$vip_1_month = $_POST['vip_1_month'];
	$vip_3_months = $_POST['vip_3_months'];
	$vip_6_months = $_POST['vip_6_months'];
	$db->query("
		UPDATE settings SET 
		vip_1_month='".$vip_1_month."',
		vip_3_months='".$vip_3_months."',
		vip_6_months='".$vip_6_months."'
		");
	header('Location: vip_pricing.php');
	exit;
}

$settings = $system->getSettings();

require('../inc/admin/top.php');
require('../layout/admin/vip_pricing.php');
require('../inc/admin/bottom.php');