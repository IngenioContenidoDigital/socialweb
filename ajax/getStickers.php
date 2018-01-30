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

$pack_id = $db->real_escape_string($_GET['pack_id']);
$receiver_id = $db->real_escape_string($_GET['receiver_id']);
$is_premium = $_GET['is_premium'];

$pack_info = $db->query("SELECT name FROM sticker_packs WHERE id='".$pack_id."'");
$pack_info = $pack_info->fetch_object();

$stickers = $db->query("SELECT * FROM stickers WHERE pack_id='".$pack_id."' ORDER BY id ASC");

$settings = $system->getSettings();

if($is_premium == 0) {
	while($sticker = $stickers->fetch_object()) {
		echo '<img src="'.$system->getDomain().'/img/stickers/'.$sticker->pack_id.'/'.$sticker->path.'" onclick="sendSticker('.$sticker->id.','.$receiver_id.')" class="sticker">';
	}
} else {
	$is_owned = $db->query("SELECT id FROM owned_sticker_packs WHERE pack_id='".$pack_id."' AND user_id='".$_SESSION['user_id']."' LIMIT 1");
	if($is_owned->num_rows >= 1) {
		while($sticker = $stickers->fetch_object()) {
			echo '<img src="'.$system->getDomain().'/img/stickers/'.$sticker->pack_id.'/'.$sticker->path.'" onclick="sendSticker('.$sticker->id.','.$receiver_id.')" class="sticker">';
		}	
	} else {
		echo '
		<div class="sticker-unlock-area">
		<a href="#" class="btn btn-danger btn-xs btn-fill" onclick="unlockStickers('.$pack_id.','.$receiver_id.','.$is_premium.')"> '.$lang['Unlock_Now'].' </a>
		<p class="sticker-unlock-name"> '.$pack_info->name.' <span> '.$lang['sticker_pack'].' </span> </p>
		<p class="sticker-disclaimer"> '.sprintf($lang['Service_Cost'],$settings->sticker_pack_price).' </p>
		</div>
		';
		echo '<div id="darkLayer-'.$pack_id.'" class="darkClass">';
		while($sticker = $stickers->fetch_object()) {
			echo '<img src="'.$system->getDomain().'/img/stickers/'.$sticker->pack_id.'/'.$sticker->path.'" class="sticker-disabled">';
		}
		echo '</div>';	
	}
}