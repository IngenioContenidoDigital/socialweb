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

$messages = $db->query("SELECT * FROM messages WHERE (user1='".$user->id."' OR user2='".$user->id."') AND is_sticker='0' GROUP by user1,user2 ORDER BY is_promoted DESC,id DESC");
$occurrences = array();
while($message = $messages->fetch_object()) {
	if($message->user1 != $user->id) { $other_user = $system->getUserInfo($message->user1); } 
	elseif($message->user2 != $user->id) { $other_user = $system->getUserInfo($message->user2); }
	if(!in_array($other_user->id, $occurrences)) {
	$occurrences[] = $other_user->id;
	echo '
	<a href="#" onclick="loadChat('.$other_user->id.'); return false;">
	<div class="chat-sidebar-user chat-open-'.$other_user->id.'">
	<img src="'.$system->getProfilePicture($other_user).'" class="chat-sidebar-thumb img-circle">
	<div class="chat-sidebar-username"> 
	'.$system->getFirstName($other_user->full_name).'';
	if($system->isOnline($other_user->last_active)) { echo '<i class="online-status online"></i>'; } else { echo '<i class="online-status offline"></i>'; }
	echo ' 
	</div>
	<p class="chat-sidebar-usermsg text-muted"> 
	'.$message->message.'
	</p>
	</div>
	</a>
	';
	$a = '';
}
}