<?php
define('IS_MOBILE',true);
session_set_cookie_params(172800);
session_start();
require('../core/config.php');
require('../core/system.php');
$system = new System;

$system->domain = $domain;
$system->db = $db;

$user = $system->getUserInfo($_SESSION['user_id']);
$system->setUserActive($user->id);

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

// Create / Update Filter
if(isset($_POST['filter'])) {
  $sexual_preference = $_POST['sexual_preference'];
  $sexual_orientation = $_POST['sexual_orientation'];
  $country = $_POST['country'];
  $order_by = $_POST['order_by'];
  $age_range = $_POST['age_range'];
  $distance_range = $_POST['distance_range'];
  if(isset($_POST['location_dating'])) {
    $location_dating = 1;
  } else {
    $location_dating = 0;
  }

  if($num_rows == 0) {
    $db->query("INSERT INTO filters (user_id,sexual_preference,country,order_by,sexual_orientation,age_range,distance_range,location_dating) VALUES ('".$user->id."','".$sexual_preference."','".$country."','".$order_by."','".$sexual_orientation."','".$age_range."','".$distance_range."','".$location_dating."')");
    header('Location: '.$system->getDomain().'/encounters');
    exit;
  } else {
    $db->query("UPDATE filters SET sexual_preference='".$sexual_preference."',country='".$country."',order_by='".$order_by."',sexual_orientation='".$sexual_orientation."',age_range='".$age_range."',distance_range='".$distance_range."',location_dating='".$location_dating."' WHERE user_id='".$user->id."'");
    header('Location: '.$system->getDomain().'/encounters');
    exit; 
  }
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

$_age_range = explode(',',$filter->age_range);
$distance_range = explode(',',$filter->distance_range);

// Count users left
$count =  $db->query("SELECT COUNT(id) FROM users $show $gender $sexual_orientation $country $me $city AND id != ".$user->id." $order LIMIT 1");
$count = $count->fetch_row();
$count = $count[0];

if(empty($user->last_encounter) && $count >= 1) {
  $people = "SELECT * FROM users $show $gender $sexual_orientation $country $me $city AND id != ".$user->id." $order LIMIT 5";
} else {
  if($count >= 1) {
    $people = "SELECT * FROM users WHERE id='".$user->last_encounter."'";
  } else {
    $no_encounters = true;
  }
}

// Finalize Query
$people = $db->query($people);

if($people->num_rows >= 1) {

$profile = $people->fetch_object();

$media = $db->query("SELECT * FROM uploaded_photos WHERE user_id='".$profile->id."' LIMIT 9");

if($media->num_rows == 0) { 
  $uploaded_photos = 0;
} else {
  $uploaded_photos = array();
  while($photo = $media->fetch_object()) {
    $photos[] = array('type'=>'uploaded','id' => $photo->id, 'path' => $photo->path);
  }
} 

$db->query("UPDATE users SET last_encounter='".$profile->id."' WHERE id='".$user->id."'");

} 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>MatchMe Mobile</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <link rel="stylesheet" type="text/css" href="css/normalize.css">
  <link rel="stylesheet" type="text/css" href="css/framework.css">
  <link rel="stylesheet" type="text/css" href="css/theme.css">
  <link rel="stylesheet" type="text/css" href="css/lightslider.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="js/webfont.js"></script>
  <script>
  var base = '<?=$system->getDomain()?>/mobile';
  var page = 'encounters';
  </script>
  <script type="text/javascript" src="js/modernizr.js"></script>
  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
  <link rel="apple-touch-icon" href="images/favicon.png">
  <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
  <section class="w-section mobile-wrapper">
    <div class="page-content" id="main-stack" data-scroll="0">
      <div class="w-nav navbar" data-collapse="all" data-animation="over-left" data-duration="400" data-contain="1" data-no-scroll="1" data-easing="ease-out-quint">
        <div class="w-container">
          <nav class="w-nav-menu nav-menu" role="navigation">
            <div class="nav-menu-header">
              <div class="sidebar-user-area">
                <a href="user.php?id=<?=$user->id?>" data-load="1">
                  <img src="<?=$system->getProfilePicture($user)?>" class="sidebar-user-photo">
                </a>
                <h4 class="sidebar-user-name"> <?=$system->getFirstName($user->full_name)?> </h4>
                <div class="sidebar-user-credits"><?=$user->credits?> credits</div>
              </div>
            </div>
            <a class="w-clearfix w-inline-block nav-menu-link" href="encounters.php" data-load="1">
              <div class="icon-list-menu">
                <div class="icon ion-ios-photos"></div>
              </div>
              <div class="nav-menu-titles"><?=$lang['Encounters']?></div>
            </a>
            <a class="w-clearfix w-inline-block nav-menu-link" href="people.php" data-load="1">
              <div class="icon-list-menu">
                <div class="icon ion-person-stalker"></div>
              </div>
              <div class="nav-menu-titles"><?=$lang['People']?></div>
            </a>
            <a class="w-clearfix w-inline-block nav-menu-link" href="messages.php" data-load="1">
              <div class="icon-list-menu">
                <div class="icon ion-chatboxes"></div>
              </div>
              <div class="nav-menu-titles"><?=$lang['Messages']?></div>
            </a>
            <a class="w-clearfix w-inline-block nav-menu-link" href="visitors.php" data-load="1">
              <div class="icon-list-menu">
                <div class="icon ion-eye"></div>
              </div>
              <div class="nav-menu-titles"><?=$lang['Visitors']?></div>
            </a>
            <a class="w-clearfix w-inline-block nav-menu-link" href="likes.php" data-load="1">
              <div class="icon-list-menu">
                <div class="icon ion-heart"></div>
              </div>
              <div class="nav-menu-titles"><?=$lang['Likes']?></div>
            </a>
            <a class="w-clearfix w-inline-block nav-menu-link" href="settings.php" data-load="1">
              <div class="icon-list-menu">
                <div class="icon ion-ios-gear"></div>
              </div>
              <div class="nav-menu-titles"><?=$lang['Settings']?></div>
            </a>
            <a class="w-clearfix w-inline-block nav-menu-link last" href="logout.php" data-load="0">
              <div class="icon-list-menu">
                <div class="ion-android-exit"></div>
              </div>
              <div class="nav-menu-titles"><?=$lang['Logout']?></div>
            </a>
            <div class="separator-bottom"></div>
            <div class="separator-bottom"></div>
            <div class="separator-bottom"></div>
          </nav>
          <div class="wrapper-mask" data-ix="menu-mask"></div>
          <div class="navbar-title">
            <?php if(!$no_encounters) { ?>
            <a href="user.php?id=<?=$profile->id?>">
              <?=$system->getFirstName($profile->full_name)?>
            </a>
            <? } else { ?>
            <a href="#">
              <?=$lang['Encounters']?>
            </a>
            <? } ?>
          </div>
          <div class="w-nav-button navbar-button left" id="menu-button" data-ix="hide-navbar-icons">
            <div class="navbar-button-icon home-icon">
              <div class="bar-home-icon"></div>
              <div class="bar-home-icon"></div>
              <div class="bar-home-icon"></div>
            </div>
          </div>
          <div class="navbar-button right filter-button" id="filter-button">
            <a href="filter.php" data-load="1">
              <div class="navbar-button-icon">
                <div class="ion-ios-settings"></div>
              </div>
            </a>
          </div>
        </div>
      </div>
      <div class="body">
        <?php if(!$no_encounters) { ?>
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
              <p> <?=$profile->city?><?=$system->ifComma($profile->city)?> <?=$profile->country?> </p>
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
          <? } else { 
          echo '
          <div class="page-error">
          <img src="'.$system->getDomain().'/img/icons/user-minus.png">
          <h4> No new users </h4>
          <p> You have rated all existing users, <br> please try again later </p>
          </div>
          ';
          } ?>
        </div>
      </div>
    </div>
    <div class="page-content loading-mask" id="new-stack">
      <div class="loading-icon">
        <div class="navbar-button-icon icon ion-load-d"></div>
      </div>
    </div>
  </section>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/framework.js"></script>
  <script type="text/javascript" src="js/lightslider.min.js"></script>
  <script type="text/javascript" src="js/app.js"></script>
  <script type="text/javascript" src="js/mobile.js"></script>
  <!--[if lte IE 9]><script src="js/placeholders.min.js"></script><![endif]-->
</body>
</html>