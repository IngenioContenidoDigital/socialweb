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
$menu['credits_pricing'] = 'active';
$menu['payments_display'] = 'block';
$page['name'] = 'Credits Pricing';

$user = $system->getUserInfo($_SESSION['user_id']);

if(!$auth->isLogged() || $user->is_admin != 1) {
	header('Location: index.php');
	exit;
}

if(isset($_POST['save'])) {
	$credits_price_100 = $_POST['credits_price_100'];
	$credits_price_500 = $_POST['credits_price_500'];
	$credits_price_1000 = $_POST['credits_price_1000'];
	$credits_price_1500 = $_POST['credits_price_1500'];
	$db->query("
		UPDATE settings SET 
		credits_price_100='".$credits_price_100."',
		credits_price_500='".$credits_price_500."',
		credits_price_1000='".$credits_price_1000."',
		credits_price_1500='".$credits_price_1500."'
		");
	header('Location: credits_pricing.php');
	exit;

}

$settings = $system->getSettings();

require('../inc/admin/top.php');
require('../layout/admin/credits_pricing.php');
require('../inc/admin/bottom.php');