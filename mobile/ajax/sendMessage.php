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

$user = $system->getUserInfo($_SESSION['user_id']);
$user2 = $db->real_escape_string($_GET['receiver_id']);
$message = $db->real_escape_string($_GET['msg']);

$system->setUserActive($user->id);

$db->query("INSERT INTO messages (message,user1,user2,is_sticker,is_photo,sticker_id,time) VALUES ('".$message."','".$user->id."','".$user2."','0','0','0','".time()."')");

$messages = $db->query("SELECT * FROM messages WHERE (user1='".$user->id."' AND user2='".$user2."') OR (user1='".$user2."' AND user2='".$user->id."') ORDER BY id ASC");

while($message = $messages->fetch_object()) {
	$sender = $system->getUserInfo($message->user1);
	if($message->is_sticker == 1) {
		$sticker = $db->query("SELECT id,pack_id,path FROM stickers WHERE id='".$message->sticker_id."'");
		$sticker = $sticker->fetch_object();
		if($sender->id == $user->id) {
			echo '
			<li class="list-chat right">
			<div class="w-clearfix column-right chat right">
			<div class="arrow-globe right"></div>
			<div class="chat-text right"><img src="'.$system->getDomain().'/img/stickers/'.$sticker->pack_id.'/'.$sticker->path.'" class="sticker-chat"></div>
			<div class="chat-time right">'.$system->timeAgo($lang,$message->time).'</div>
			</div>
			</li>
			';
		} else {
			echo '
			<li class="w-clearfix list-chat">
			<div class="column-left chat">
			<div class="image-message chat"><img src="'.$system->getProfilePicture($sender).'">
			</div>
			</div>
			<div class="w-clearfix column-right chat">
			<div class="arrow-globe"></div>
			<div class="chat-text"><img src="'.$system->getDomain().'/img/stickers/'.$sticker->pack_id.'/'.$sticker->path.'" class="sticker-chat"></div>
			<div class="chat-time">'.$system->timeAgo($lang,$message->time).'</div>
			</div>
			</li>
			';
		} 
	} else {
		if($sender->id == $user->id) {
			echo '
			<li class="list-chat right">
			<div class="w-clearfix column-right chat right">
			<div class="arrow-globe right"></div>
			<div class="chat-text right">'.$message->message.'</div>
			<div class="chat-time right">'.$system->timeAgo($lang,$message->time).'</div>
			</div>
			</li>
			';
		} else {
			echo '
			<li class="w-clearfix list-chat">
			<div class="column-left chat">
			<div class="image-message chat"><img src="'.$system->getProfilePicture($sender).'">
			</div>
			</div>
			<div class="w-clearfix column-right chat">
			<div class="arrow-globe"></div>
			<div class="chat-text">'.$message->message.'</div>
			<div class="chat-time">'.$system->timeAgo($lang,$message->time).'</div>
			</div>
			</li>
			';
		}
	}
}


