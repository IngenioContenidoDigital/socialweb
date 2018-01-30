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

$sticker_packs = $db->query("SELECT * FROM sticker_packs ORDER BY id ASC");
$receiver_id = $db->real_escape_string($_GET['receiver_id']);

while($sticker_pack = $sticker_packs->fetch_object()) {
	echo '
	<span class="emoji-top-img sticker-pack-'.$sticker_pack->id.' emj" onclick="loadStickers('.$sticker_pack->id.','.$receiver_id.','.$sticker_pack->is_premium.'); setActiveEmojiLink(\'.sticker-pack-'.$sticker_pack->id.'\');">
	<img src="'.$system->getDomain().'/img/stickers/'.$sticker_pack->id.'/'.$sticker_pack->cover.'">
	</span>
	';
}