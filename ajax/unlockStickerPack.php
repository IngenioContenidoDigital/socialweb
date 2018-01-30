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

$pack_id = $db->real_escape_string($_GET['pack_id']);

if($user->credits >= $settings->sticker_pack_price) {
$db->query("INSERT INTO owned_sticker_packs(pack_id,user_id) VALUES ('".$pack_id."','".$_SESSION['user_id']."')");
$db->query("UPDATE users SET credits=credits-".$settings->sticker_pack_price." WHERE id='".$user->id."'");
}