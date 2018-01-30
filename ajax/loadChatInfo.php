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
$user2 = $_GET['id'];

$messages = $db->query("SELECT * FROM messages WHERE (user1='".$user->id."' AND user2='".$user2."') OR (user1='".$user2."' AND user2='".$user->id."') GROUP BY user1,user2 ORDER BY id DESC LIMIT 1");

$message = $messages->fetch_object();

if($message->user1 != $user->id) { $other_user = $system->getUserInfo($message->user1); } 
elseif($message->user2 != $user->id) { $other_user = $system->getUserInfo($message->user2); } 
echo '
<div class="chat-receiver-info">
<h4 class="chat-receiver-name">';
if($system->isOnline($other_user->last_active)) { echo '<i class="online-status online"  style="margin-right: 5px !important;"></i>'; } else { echo '<i class="online-status offline"  style="margin-right: 5px !important;"></i>'; } 
echo ''.$system->getFirstName($other_user->full_name).', '.$other_user->age.'
</h4>
<a class="btn btn-info btn-xs btn-icon"><i class="ti-check text-info"></i></a>
<a class="btn btn-warning btn-xs btn-icon"><i class="ti-crown text-warning"></i></a>
<div class="chat-receiver-actions pull-right">
<a href="'.$system->getDomain().'/user/'.$other_user->id.'" class="btn btn-default btn-icon btn-sm"><i class="icon icon-user"></i></a>
<a class="btn btn-default btn-icon btn-sm" onclick="deleteMessages('.$message->user1.','.$message->user2.')"><i class="icon icon-bin"></i></a>
</div>
</div>
';
