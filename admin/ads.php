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

$menu['ads'] = 'active';
$page['name'] = 'Manage Encounters';

$user = $system->getUserInfo($_SESSION['user_id']);

if(!$auth->isLogged() || ($user->is_admin != 1 || $user->is_admin != 3)) {
	header('Location: index.php');
	exit;
}

$encounters = $db->query("SELECT
rq.id,
rq.user1,
u1.full_name,
u1.email,
rq.user2,
u2.full_name AS requests,
rq.time,
rq.accepted,
rq.encounter_date
FROM
friend_requests AS rq
INNER JOIN users AS u1 ON rq.user1 = u1.id
INNER JOIN (SELECT * FROM users) AS u2 ON rq.user2=u2.id");
//$encounters = $encounters->fetch_object();

/*if(isset($_POST['save'])) {
	$ad_1 = $_POST['ad_1'];
	$ad_2 = $_POST['ad_2'];
	$db->query("UPDATE ads SET ad_1='".$ad_1."',ad_2='".$ad_2."'");
	header('Location: ads.php');
	exit;
}*/

require('../inc/admin/top.php');
require('../layout/admin/ads.php');
require('../inc/admin/bottom.php');