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

$id = $_SESSION['user_id'];

$notifications = $db->query("SELECT * FROM notifications WHERE receiver_id='".$id."' ORDER BY is_read ASC, id DESC LIMIT 5");

if($notifications->num_rows >= 1) {
	while($notification = $notifications->fetch_object()) {
		?>
		<li>
			<a href="<?php if($notification->url != '#') { echo $system->getDomain().'/'.$notification->url; } else { echo '#'; } ?>" class="notification-item">
				<div class="notification-text">
					<span class="label label-icon label-default"><i class="<?=$notification->icon?>"></i></span>

					<span class="message"><?=$notification->content?></span>
					<br />
					<span class="time"><?=$system->timeAgo($lang,$notification->time)?></span>
				</div>
			</a>
		</li>
		<?php
	}
} 
