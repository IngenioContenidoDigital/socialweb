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

$random_users = $db->query('SELECT * FROM users ORDER BY id LIMIT 8');

while($random_user = $random_users->fetch_object()) {
	echo '
	<a href="#" onclick="loadChat('.$random_user->id.'); return false;">
	<div class="chat-sidebar-user chat-open-'.$random_user->id.'">
	<img src="'.$system->getProfilePicture($random_user).'" class="chat-sidebar-thumb img-circle">
	<div class="chat-sidebar-username"> 
	'.$system->getFirstName($random_user->full_name).'';
	if($system->isOnline($random_user->last_active)) { echo '<i class="online-status online"></i>'; } else { echo '<i class="online-status offline"></i>'; }
	echo ' 
	</div>
	<p class="chat-sidebar-usermsg text-muted"> 
	I feel like chatting
	</p>
	</div>
	</a>
	';
}