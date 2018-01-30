<?php
require('../core/config.php');
require('../core/libs/src/IpnListener.php');

use wadeshuler\paypalipn\IpnListener;
$listener = new IpnListener();

$listener->use_sandbox = false;
$listener->use_curl = true;
$listener->follow_location = false;
$listener->timeout = 30;
$listener->verify_ssl = true;

$listener->processIpn();

$custom = $_POST['custom'];

$custom = explode('/',$custom);
$type  = $custom[0];

if(strrpos($listener->getTextReport(),'Completed')) {

	$user_id = $custom[2];

	if($type === 'credits') {
		$credits = $custom[1];
		$db->query('UPDATE users SET credits=credits+'.$credits.' WHERE id='.$user_id.'');
	} elseif($type === 'vip') {
		$duration = $custom[1];
		$start = time();
		$expiration = time()+$duration;
		$db->query('UPDATE users SET is_vip=1 WHERE id='.$user_id.'');
		$db->query('UPDATE users SET vip_expiration='.$expiration.' WHERE id='.$user_id.'');
		$db->query("UPDATE users SET ghost_mode_start=".$start." WHERE id=".$user_id."");
		$db->query('UPDATE users SET ghost_mode_expiration='.$expiration.' WHERE id='.$user_id.'');
		$db->query("UPDATE users SET verified_badge_start=".$start." WHERE id=".$user_id."");
		$db->query('UPDATE users SET verified_badge_expiration='.$expiration.' WHERE id='.$user_id.'');
		$db->query("UPDATE users SET spotlight_start=".$start." WHERE id=".$user_id."");
		$db->query('UPDATE users SET spotlight_expiration='.$expiration.' WHERE id='.$user_id.'');
		$db->query("UPDATE users SET disable_ads_start=".$start." WHERE id=".$user_id."");
		$db->query('UPDATE users SET disable_ads_expiration='.$expiration.' WHERE id='.$user_id.'');
	}

} 