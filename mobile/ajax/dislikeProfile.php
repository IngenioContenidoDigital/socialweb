<?php
define('IS_MOBILE_AJAX',true);
session_set_cookie_params(172800);
session_start();
require('../../core/config.php');
require('../../core/auth.php');
require('../../core/system.php');
$auth = new Auth;
$system = new System;

$system->domain = $domain;
$system->db = $db;

$id = $db->real_escape_string($_GET['id']);
$user = $system->getUserInfo($_SESSION['user_id']);

$check = $db->query("SELECT id FROM profile_dislikes WHERE viewer_id='".$user->id."' AND profile_id='".$id."' LIMIT 1");

if($check->num_rows == 0) {
	$db->query("INSERT INTO profile_dislikes (profile_id,viewer_id,time) VALUES ('".$id."','".$user->id."','".time()."')");
	echo '<button class="w-button action-button encounter-button btn-dislike-fill"><i class="ion-close"></i></button>';
} else {
	$db->query("DELETE FROM profile_dislikes WHERE profile_id='".$id."' AND viewer_id='".$user->id."'");
	echo '<button class="w-button action-button encounter-button btn-dislike"><i class="ion-close"></i></button>';
}
