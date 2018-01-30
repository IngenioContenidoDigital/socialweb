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
$receiver_name = $db->real_escape_string($_GET['receiver_name']);
$gift_id = $db->real_escape_string($_GET['gift_id']);

$settings = $system->getSettings();

echo 
'
<h4> '.sprintf($lang['Send_Gift_To'],$receiver_name).' </h4>
<img src="'.$system->getDomain().'/img/gifts/'.$gift_id.'.png" class="chat-gift-selected">
<a href="#" class="btn btn-default btn-fill gift-send-btn" onclick="sendChatGift()"> '.$lang['Send_Now'].' </a> <br>
<small class="text-muted send-gift-diclaimer"> '.sprintf($lang['Service_Cost'],$settings->gift_price).' </small>
';