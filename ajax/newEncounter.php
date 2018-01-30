<?php
define('IS_AJAX', true);
session_set_cookie_params(172800);
session_start();
require('../core/config.php');
require('../core/auth.php');
require('../core/system.php');
$auth = new Auth;
$system = new System;

$system->domain = $domain;
$system->db = $db;

$user = $system->getUserInfo($_SESSION['user_id']);

// Filter
$filter = $db->query("SELECT * FROM filters WHERE user_id='".$user->id."'");
$num_rows = $filter->num_rows;
if($num_rows >= 1) {
	$filter = $filter->fetch_object();
} else {
	$filter = new stdClass();
	$filter->sexual_preference = 3;
	$filter->sexual_orientation = 1;
	$filter->country = 'All Countries';
	$filter->city = '';
	$filter->order_by = 4;
}

// Format Query
$show = 'WHERE NOT EXISTS (SELECT id FROM profile_likes WHERE profile_id=users.id AND viewer_id='.$user->id.') AND NOT EXISTS (SELECT id FROM profile_dislikes WHERE profile_id=users.id AND viewer_id='.$user->id.')';

switch ($filter->sexual_preference) {
	case 1:
	$gender = 'AND gender=\'Male\'';
	break;
	case 2:
	$gender = 'AND gender=\'Female\'';
	break;
	case 3:
	$gender = 'AND gender IS NOT NULL';
	break;
	default:
	$gender = 'AND gender IS NOT NULL';
	break;
}

switch ($filter->sexual_orientation) {
	case 1:
	$sexual_orientation = 'AND sexual_interest=\'1\'';
	break;
	case 2:
	$sexual_orientation = 'AND sexual_interest=\'2\'';
	break;
	case 3:
	$sexual_orientation = 'AND sexual_interest=\'3\'';
	break;
	case 4:
	$sexual_orientation = 'AND sexual_interest=\'4\'';
	break;
	default:
	$sexual_orientation = 'AND country LIKE \'%'.$filter->sexual_orientation.'%\'';
	break;
}

switch ($filter->country) {
	case 'All Countries':
	$country = 'AND country IS NOT NULL';
	break;
	default:
	$country = 'AND country LIKE \'%'.$filter->country.'%\'';
	break;
}

$city = 'AND city LIKE \'%'.$filter->city.'%\'';

$order = 'ORDER BY RAND()';

$people = "SELECT * FROM users $show $gender $sexual_orientation $country $me $city AND id != ".$user->id." AND profile_picture!='default_avatar.png' $order LIMIT 5";

// Finalize Query
$people = $db->query($people);

if($people->num_rows >= 1) {
$profile = $people->fetch_object();
$media = $system->getUserPhotos($profile->id,9);
$system->updateLastEncounter($user->id, $profile->id);
$score = $system->getScore($profile->id);
?>
<div class="encounter">
<div class="row">
<div class="col-lg-9 col-md-12 col-sm-12">
<div class="well well-encounter bg-white overflow-auto mb-0">
	<div class="encounter-controls pull-left">
		<div id="heart-<?=$profile->id?>" onclick="likeProfile(<?=$profile->id?>,true)" class="pull-left">
			<?php
			$check = $db->query("SELECT id FROM profile_likes WHERE viewer_id='".$user->id."' AND profile_id='".$profile->id."' LIMIT 1"); ?>
			<?php if($check->num_rows == 0) {
				echo '<button class="btn btn-circle btn-danger btn-stroke btn-lg mr-5"><i class="icon icon-heart"></i></button>';
			} else {
				echo '<button class="btn btn-circle btn-danger btn-lg mr-5"><i class="icon icon-heart"></i></button>';
			}
			?>
		</div>
		<div id="times-<?=$profile->id?>" onclick="dislikeProfile(<?=$profile->id?>,true)" class="pull-left">
			<?php
			$check = $db->query("SELECT id FROM profile_dislikes WHERE viewer_id='".$user->id."' AND profile_id='".$profile->id."' LIMIT 1"); ?>
			<?php if($check->num_rows == 0) {
				echo '<button class="btn btn-circle btn-default btn-stroke btn-lg mr-5"><i class="ti-close"></i></button>';
			} else {
				echo '<button class="btn btn-circle btn-default btn-lg mr-5"><i class="ti-close"></i></button>';
			}
			?>
		</div>
	</div>
	<div class="encounter-info pull-left">
		<h4 class="encounters-name">
			<?php if($system->isOnline($profile->last_active)) { echo '<i class="online-status online"></i>'; } else { echo '<i class="online-status offline"></i>'; } ?>
		<a href="<?=$system->getDomain()?>/user/<?=$profile->id?>">
			<?=$system->getFirstName($profile->full_name)?>, <?=$profile->age?>
		</a>
		</h4>
		<?php $system->getUserBadges($profile); ?>
	</div>
	<br>
</div>
</div>
</div>
<div class="row">
<div class="col-lg-9 col-md-12 col-sm-12 pull-left">
<div class="well overflow-auto mb-0 text-center" style="background-color:#333333;margin-bottom:0px !important;margin-top:0px !important;">
<ul id="encounterGallery">
<?php
if($media->num_rows >= 1) {
	while($photo = $media->fetch_object()) {
	echo '
	<li data-thumb="'.$system->getDomain().'/uploads/'.$photo->path.'" data-src="'.$system->getDomain().'/uploads/'.$photo->path.'">
	<img src="'.$system->getDomain().'/uploads/'.$photo->path.'">
	</li>
	';
	}
} else {
	echo '
	<li data-thumb="'.$system->getProfilePicture($profile).'" data-src="'.$system->getProfilePicture($profile).'">
	<img src="'.$system->getProfilePicture($profile).'">
	</li>
	';
}
?>
</ul>
</div>
</div>
<div class="col-md-3 pull-right">
<div class="panel panel-default">
	<div class="panel-heading">
		<div class="panel-title"><?=$lang['Score']?></div>
	</div>
	<div class="panel-body text-center">
		<div class="easy-pie-chart easy-pie-sm">
			<div class="percentage" data-percent="<?=$percentage?>" data-size="100" data-bar-color="#E9573F">
				<span> <?=$percentage?> </span> %
				<canvas height="100" width="100"></canvas></div>
				<a class="title">
					<small><?=sprintf($lang['Score_Details'],number_format($likes),number_format($total))?></small>
				</a>
			</div>
		</div>
	</div>
</div>
<div class="col-md-3 pull-right">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="panel-title"><?=$lang['Send_Gift']?></div>
		</div>
		<div class="panel-body text-center" style="padding:20px;">
			<div id="encounter_gift_container">
				<img src="<?=$system->getDomain()?>/img/gifts/26.png" class="img-responsive" style="height:70px;width:80px;">
				<a href="#" data-toggle="modal" data-target="#send-gift" class="btn btn-circle btn-default btn-xs btn-fill encounter_gift_button"> <i class="fa fa-plus"></i> </a>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-9 col-md-12 col-sm-12" style="padding-left:30px;padding-right:20px;">
		<div class="well bg-white overflow-auto mb-0">
			<h4 class="mt-0"><?=$lang['Location']?></h4>
			<?=$profile->city?><?=$system->ifComma($profile->city)?> <?=$profile->country?>
		</div>
	</div>
	<div class="col-md-3 pull-right mb-10">
		<a href="#" data-toggle="modal" data-target="#filter-results" class="btn btn-inverse btn-block"> <i class="fa fa-fw fa-sliders"></i> <?=$lang['Filter']?> </a>
	</div>
</div>
<div class="row">
	<div class="col-lg-9 col-md-12 col-sm-12" style="padding-left:30px;padding-right:20px;">
		<div class="well bg-white overflow-auto mb-0">
			<h4 class="mt-0"><?=$lang['Interests']?></h4>
			<?php
			if(!empty($profile->interests)) {
				$interests = explode(',',$profile->interests);
				foreach($interests as $interest) {
					echo '<div class="interest-item badge">'.$interest.'</div>';
				}
			} else {
				echo $lang['Nothing_To_Show'];
			}
			?>
		</div>
	</div>
</div>
<?php
} else {
	$system->getPageError('encounters');
}
