<?php
define('IS_MOBILE_AJAX',true);
session_set_cookie_params(172800);
session_start();
require('../../core/config.php');
require('../../core/auth.php');
require('../../core/system.php');
require('../../core/geo.php');
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

$people = "SELECT * FROM users $show $gender $sexual_orientation $country $me $city AND id != ".$user->id." $order LIMIT 5";

// Finalize Query
$people = $db->query($people);

if($people->num_rows >= 1) {

	$profile = $people->fetch_object();
	$media = $db->query("SELECT * FROM uploaded_photos WHERE user_id='".$profile->id."' LIMIT 9");

	// Fetch photos
	if($media->num_rows == 0) { 
		$uploaded_photos = 0;
	} else {
		$uploaded_photos = array();
		while($photo = $media->fetch_object()) {
			$photos[] = array('type'=>'uploaded','id' => $photo->id, 'path' => $photo->path);
		}
	} 

	$db->query("UPDATE users SET last_encounter='".$profile->id."' WHERE id='".$user->id."'");

	?>
	<div class="encounters">
		<ul id="encounterGallery">
			<?php
			if(!empty($photos)) {
				for($i = 0; $i < count($photos); $i++) {
					echo '
					<li data-thumb="'.$system->getDomain().'/uploads/'.$photos[$i]['path'].'" data-src="'.$system->getDomain().'/uploads/'.$photos[$i]['path'].'">
					<img src="'.$system->getDomain().'/uploads/'.$photos[$i]['path'].'">
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
		<div class="encounters-controls"> 
			<div id="heart-<?=$profile->id?>" onclick="likeProfile(<?=$profile->id?>,true)" style="display:inline;">
				<?php 
				$check = $db->query("SELECT id FROM profile_likes WHERE viewer_id='".$user->id."' AND profile_id='".$profile->id."' LIMIT 1"); ?>
				<?php if($check->num_rows == 0) { 
					echo '<button class="w-button action-button encounter-button btn-like"><i class="ion-heart"></i></button>';
				} else { 
					echo '<button class="w-button action-button encounter-button btn-like"><i class="ion-heart"></i></button>';
				} 
				?>
			</div>
			<div id="times-<?=$profile->id?>" onclick="dislikeProfile(<?=$profile->id?>,true)" style="display:inline;">
				<?php 
				$check = $db->query("SELECT id FROM profile_dislikes WHERE viewer_id='".$user->id."' AND profile_id='".$profile->id."' LIMIT 1"); ?>
				<?php if($check->num_rows == 0) { 
					echo '<button class="w-button action-button encounter-button btn-dislike"><i class="ion-close"></i></button>';
				} else {
					echo '<button class="w-button action-button encounter-button btn-dislike"><i class="ion-close"></i></button>';
				}
				?>
			</div>
		</div>
		<div class="encounter-section">
			<h5 class="encounter-sub-title"> Location </h5>
			<p> <?=$profile->city?><?=$system->ifComma($profile->city)?> <?=$profile->country?> <?php if($distance > 0 && $user->id != $profile->id) { echo '(~'.sprintf($lang['km_away'],ceil($distance)).')'; } ?> </p>
		</div>
		<div class="encounter-section">
			<h5 class="encounter-sub-title"> Interests </h5>
			<?php
			if(!empty($profile->interests)) {
				$interests = explode(',',$profile->interests);
				foreach($interests as $interest) {
					echo '<div class="interest-item">'.$interest.'</div>';
				}
			} else {
				echo '<p>'.$lang['Nothing_To_Show'].'</p>';
			}
			?>
		</div>
	</div>
	<?php } else { ?>
	<div class="page-error">
		<img src="<?=$system->getDomain()?>/img/icons/user-minus.png">
		<h4> No new users </h4>
		<p> You have rated all existing users, <br> please try again later </p>
	</div>
	<? } ?>
