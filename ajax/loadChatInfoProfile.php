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
$receiver = $_GET['id'];

$receiver = $db->query("SELECT * FROM users WHERE id='".$receiver."' LIMIT 1");

$receiver = $receiver->fetch_object();

echo '
<div class="chat-receiver-info">
<h4 class="chat-receiver-name">';
if($system->isOnline($receiver->last_active)) { echo '<i class="online-status online"  style="margin-right: 5px !important;"></i>'; } else { echo '<i class="online-status offline"  style="margin-right: 5px !important;"></i>'; } 
echo ''.$system->getFirstName($receiver->full_name).', '.$receiver->age.'
</h4>
<a class="btn btn-info btn-xs btn-icon"><i class="ti-check text-info"></i></a>
<a class="btn btn-warning btn-xs btn-icon"><i class="ti-crown text-warning"></i></a>
<div class="chat-receiver-actions pull-right">
<a href="'.$system->getDomain().'/user/'.$receiver->id.'" class="btn btn-default btn-icon btn-sm"><i class="icon icon-user"></i></a>
<a class="btn btn-default btn-icon btn-sm" onclick="deleteMessages('.$user->id.','.$receiver->id.')"><i class="icon icon-bin"></i></a>
</div>
</div>
';
