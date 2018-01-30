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

$menu['photos'] = 'active';
$page['name'] = 'Manage Photos';

$user = $system->getUserInfo($_SESSION['user_id']);

if(!$auth->isLogged() || $user->is_admin != 1) {
	header('Location: index.php');
	exit;
}

if(isset($_GET['delete']) && isset($_GET['delid'])) {
	$delid = $_GET['delid'];
	$path = $_GET['path'];
	$db->query("DELETE FROM uploaded_photos WHERE id='".$delid."'");
	unlink('../uploads/'.$path);
	header('Location: photos.php?success');
	exit;
}

$photos = "SELECT * FROM uploaded_photos ORDER BY id DESC";

// Pagination
$per_page = 9;
$count = $db->query($photos)->num_rows;
$last_page = ceil($count/$per_page);
if(isset($_GET['p'])) { $p = $_GET['p']; } else { $p = 1; }
if($p < 1) { $p = 1; } elseif($p > $last_page) { $p = $last_page; }
$limit = 'LIMIT ' .($p - 1) * $per_page .',' .$per_page;
$photos.= " $limit";

$photos = $db->query($photos);

require('../inc/admin/top.php');
require('../layout/admin/photos.php');
require('../inc/admin/bottom.php');