<?php
define('IS_AJAX', true);
session_set_cookie_params(172800);
session_start();
require('../core/config.php');
require('../core/auth.php');
require('../core/system.php');

$system = new System;
$system->domain = $domain;
$system->db = $db;

$id = $db->real_escape_string($_GET['id']);
$user = $system->getUserInfo($_SESSION['user_id']);

$check = $db->query("SELECT id FROM profile_likes WHERE viewer_id='".$user->id."' AND profile_id='".$id."' LIMIT 1");

if($check->num_rows == 0) {
	$db->query("INSERT INTO profile_likes (profile_id,viewer_id,time) VALUES ('".$id."','".$user->id."','".time()."')");
	$db->query("INSERT INTO notifications (receiver_id,url,content,icon,time) VALUES ('".$id."','user/".$user->id."','<b>".$system->getFirstName($user->full_name)."</b> liked your profile','ti-heart', '".time()."')");
	echo '<button class="btn btn-circle btn-danger btn-lg mr-5"><i class="ti-heart"></i></button>';
} else {
	$db->query("DELETE FROM profile_likes WHERE viewer_id='".$user->id."' AND profile_id='".$id."'");
	$db->query("DELETE FROM notifications WHERE receiver_id='".$id."' AND url='user/".$user->id."'");
	echo '<button class="btn btn-circle btn-danger btn-stroke btn-lg mr-5"><i class="icon icon-heart"></i></button>';
}
