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

$menu['layout'] = 'active';
$page['name'] = 'Layout';

$user = $system->getUserInfo($_SESSION['user_id']);

if(!$auth->isLogged() || $user->is_admin != 1) {
	header('Location: index.php');
	exit;
}

$settings = $system->getSettings();

if(isset($_POST['save'])) {
	$theme = $_POST['theme'];
	$db->query("UPDATE settings SET winter_theme='".$theme."'");
	header('Location: design.php');
	exit;
}
require('../inc/admin/top.php');
require('../layout/admin/design.php');
require('../inc/admin/bottom.php');