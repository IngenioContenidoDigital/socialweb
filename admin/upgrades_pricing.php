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
$menu['upgrades_pricing'] = 'active';
$menu['payments_display'] = 'block';
$page['name'] = 'Upgrades Pricing';

$user = $system->getUserInfo($_SESSION['user_id']);

if(!$auth->isLogged() || $user->is_admin != 1) {
	header('Location: index.php');
	exit;
}

if(isset($_POST['save'])) {
	$gift_price = $_POST['gift_price'];
	$sticker_pack_price = $_POST['sticker_pack_price'];
	$feature_price = $_POST['feature_price'];
	$db->query("
		UPDATE settings SET 
		gift_price='".$gift_price."',
		sticker_pack_price='".$sticker_pack_price."',
		feature_price='".$feature_price."'
		");
	header('Location: upgrades_pricing.php');
	exit;
}

$settings = $system->getSettings();

require('../inc/admin/top.php');
require('../layout/admin/upgrades_pricing.php');
require('../inc/admin/bottom.php');