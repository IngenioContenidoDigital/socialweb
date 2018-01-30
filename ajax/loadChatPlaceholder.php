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
$user2 = $system->getUserInfo($_GET['id']);

echo
'
<div class="chat-placeholder">
<h4 class="start-conversation"> Say Hi to <span>'.$system->getFirstName($user2->full_name).'</span> </h4>
<img src="'.$system->getProfilePicture($user2).'" class="chat-placeholder-image">
<div class="photo-count">
'.$user2->uploaded_photos. '<small>';
if($user2->uploaded_photos > 1) { echo 'photos'; } else { echo 'photo'; } echo
'</small> </div>
</div>
';
