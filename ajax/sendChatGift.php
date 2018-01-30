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

$user = $system->getUserInfo($_SESSION['user_id']);

$receiver_id = $db->real_escape_string($_GET['receiver_id']);
$gift_id = $db->real_escape_string($_GET['gift_id']);

$settings = $system->getSettings();

if($user->credits >= $settings->gift_price) {
	$gift_path = $gift_id.'.png';
	$db->query("INSERT INTO gifts (user1,user2,path,time) VALUES ('".$user->id."','".$receiver_id."','".$gift_path."','".time()."')");
	$db->query("UPDATE users SET credits=credits-".$settings->gift_price." WHERE id='".$user->id."'");
	echo '
	<div class="send-gift-success">
	<h4> Success </h4>
	<i class="ti-gift"></i>
	<p> You sent a gift successfully, you can view it on the user\'s profile. </p>
	</div>
	';
} else {
	echo '
	<div class="send-gift-error">
	<h4> Oops </h4>
	<i class="ti-face-sad"></i>
	<p> You don\'t have enough credits, <a href="'.$system->getDomain().'/credits"> purchase some </a> and try again. </p>
	</div>
	';
}