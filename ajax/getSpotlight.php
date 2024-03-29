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

if ($user->is_admin==2){
    $spotlight_users = $db->query("SELECT * FROM users WHERE is_admin=0 ORDER BY RAND() LIMIT 20");
}elseif($user->is_admin==0){
    $spotlight_users = $db->query("SELECT * FROM users WHERE id=".$user->id." ORDER BY RAND() LIMIT 20");
}else{
    $spotlight_users = $db->query("SELECT * FROM users WHERE id!=".$user->id." ORDER BY RAND() LIMIT 20");
}

/*if($user->is_increased_exposure == 0) {
	echo '
	<li>
	<a href="'.$system->getDomain().'/credits">
	<div class="box">  
	<img src="'.$system->getProfilePicture($user).'" class="img-circle spotlight-image-add">
	<div class="overbox">
	<div class="title overtext">
	<i class="ti-plus"></i>
	</div>
	</div>
	</div>
	</a>
	</li>
	';
}*/
while($spotlight_user = $spotlight_users->fetch_object()) { 
	echo '
	<li>
	<a href="'.$system->getDomain().'/user/'.$spotlight_user->id.'">
	<img src="'.$system->getProfilePicture($spotlight_user).'" class="img-circle spotlight-image">
	</a>
	</li>
	';
}
