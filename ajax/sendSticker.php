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

$sticker_id = $db->real_escape_string($_GET['sticker_id']);
$receiver_id = $db->real_escape_string($_GET['receiver_id']);

$user = $system->getUserInfo($_SESSION['user_id']);
$system->setUserActive($user->id);

$db->query("INSERT INTO messages (message,user1,user2,is_sticker,is_photo,sticker_id,time) VALUES ('','".$user->id."','".$receiver_id."','1','0','".$sticker_id."','".time()."')");
$db->query("INSERT INTO notifications (receiver_id,url,content,icon,time) VALUES ('".$receiver_id."','user/".$user->id."','Sent a sticker','icon icon-bubble', '".time()."')");