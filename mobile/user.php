<?php
define('IS_MOBILE',true);
session_set_cookie_params(172800);
session_start();
require('../core/config.php');
require('../core/auth.php');
require('../core/system.php');
require('../core/geo.php');
$auth = new Auth;
$system = new System;
$geo = new Geo;

$system->domain = $domain;
$system->db = $db;

$user = $system->getUserInfo($_SESSION['user_id']);
$system->setUserActive($user->id);

$id = $_GET['id'];

$profile = $system->getUserInfo($id);

// Get dynamic content
$media = $db->query("SELECT * FROM uploaded_photos WHERE user_id='".$profile->id."' LIMIT 20");
$friends = $db->query("SELECT * FROM friend_requests WHERE accepted='1' AND (user1='".$id."' OR user2='".$id."') ORDER BY id DESC");
$gifts = $db->query("SELECT * FROM gifts WHERE user2='".$profile->id."'");

// Check friend Status
$check = $db->query("SELECT id,user1 FROM friend_requests WHERE ((user1='".$user->id."' AND user2='".$profile->id."') OR (user1='".$profile->id."' AND user2='".$user->id."')) AND accepted='0' LIMIT 1");
if($check->num_rows == 0) {
  $sent_request = 0;
} else {
  $sent_request = 1;
}
$check = $check->fetch_object();
if($check->user1 == $user->id) {
  $is_sender = 1;
} else {
  $is_sender = 0;
}
$check = $db->query("SELECT id FROM friend_requests WHERE ((user1='".$user->id."' AND user2='".$profile->id."') OR (user1='".$profile->id."' AND user2='".$user->id."')) AND accepted='1' LIMIT 1");
if($check->num_rows == 0) {
  $is_friend = 0;
} else {
  $is_friend = 1;
}

$photos = array();

// Fetch photos
if($media->num_rows == 0) { 
  $uploaded_photos = 0;
} else {
  $uploaded_photos = array();
  while($photo = $media->fetch_object()) {
    $photos[] = array('type'=>'uploaded','id' => $photo->id, 'path' => $photo->path);
  }
} 

// Record Profile View
if($user->is_incognito == 0 || $user->vip_expiration >= time()) {
  $check = $db->query("SELECT id FROM profile_views WHERE
    viewer_id='".$user->id."' AND profile_id='".$profile->id."' LIMIT 1");
  if($check->num_rows == 0) {
    $db->query("INSERT INTO profile_views (profile_id,viewer_id,time) VALUES ('".$profile->id."','".$user->id."','".time()."')");
  }
}

// Sexual Orientation
switch ($profile->sexual_interest) {
  case 1:
  $sexual_orientation = 'Straight';
  break;
  case 2: 
  $sexual_orientation = 'Gay';
  break;
  case 3:
  $sexual_orientation = 'Lesbian';
  break;
  case 4: 
  $sexual_orientation = 'Bisexual';
  break;
  default:
  $sexual_orientation = 'Straight';
  break;
}

// Private Profile
if($profile->private_profile == 1) {
  if($user->id != $profile->id) {
    $private_profile = true;
  } else {
    $private_profile = false;
  }
} else {
  $private_profile = false;
}

// Calculate distance
if($user->country == $profile->country) {
  $distance = $geo->coordsToKm($user->latitude,$user->longitude,$profile->latitude,$profile->longitude);
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
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/bxslider.css">
  <link rel="stylesheet" type="text/css" href="css/swipebox.min.css">
  <script src="js/webfont.js"></script>
  <script>
  var base = '<?=$system->getDomain()?>/mobile';
  var page = 'profile';
  </script>
  <script type="text/javascript" src="js/modernizr.js"></script>
  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
  <link rel="apple-touch-icon" href="images/favicon.png">
  <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
  <link href="css/themify-icons.css" rel="stylesheet" type="text/css" />
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
          <div class="navbar-title"><?=$system->getFirstName($profile->full_name)?></div>
          <div class="w-nav-button navbar-button left" id="menu-button" data-ix="hide-navbar-icons">
            <div class="navbar-button-icon home-icon">
              <div class="bar-home-icon"></div>
              <div class="bar-home-icon"></div>
              <div class="bar-home-icon"></div>
            </div>
          </div>
          <?php if($profile->id == $user->id) { ?>
          <a href="upload.php" class="w-inline-block navbar-button right" data-load="0">
            <div class="navbar-button-icon icon message-user">
              <div class="ion-camera"></div>
            </div>
          </a>
          <? } ?>
          <?php if($profile->id != $user->id) { ?>
          <a href="chat.php?id=<?=$profile->id?>&receiver=<?=$system->getFirstName($profile->full_name)?>" class="w-inline-block navbar-button right" data-load="1">
            <div class="navbar-button-icon icon message-user">
              <div class="ion-ios-chatbubble"></div>
            </div>
          </a>
          <? } ?>
        </div>
      </div>
      <div class="body">
        <div class="profile-top">
          <img class="profile-photo" style="background-image:linear-gradient(rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.7)),url('<?=$system->getProfilePicture($profile)?>')">
          <div class="profile-info">
            <?php if($system->isOnline($profile->last_active)) { echo '<i class="online-status online"></i>'; } else { echo '<i class="online-status offline"></i>'; } ?>
            <?=$system->getFirstName($profile->full_name)?>, <?=$profile->age?>
          </div>
        </div>
        <div class="profile-content">
          <div class="profile-section">
            <h2> <?=$lang['Location']?> </h2>
            <p> <?=$profile->city?><?=$system->ifComma($profile->city)?> <?=$profile->country?> <?php if($distance > 0 && $user->id != $profile->id) { echo '(~'.sprintf($lang['km_away'],ceil($distance)).')'; } ?> </p>
          </div>
          <div class="profile-section">
            <h2> <?=$lang['Self-summary']?> </h2>
            <?php
            if(!empty($profile->bio)) {
              echo '<p>'.$profile->bio.'</p>';
            } else {
              echo '<p>'.$lang['Nothing_To_Show'].'</p>';
            }
            ?>
          </div>
          <div class="profile-section">
            <h2> <?=$lang['Interests']?> </h2>
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
          <div class="profile-section">
            <h2> <?=count($photos)?> Photos </h2>
            <ul class="profile-gallery">
              <?php
              if(!empty($photos)) { 
                for($i = 0; $i < count($photos); $i++) {
                  echo '
                  <li>
                  <a rel="gallery-1" href="'.$system->getDomain().'/uploads/'.$photos[$i]['path'].'" class="swipebox">
                  <img src="'.$system->getDomain().'/uploads/'.$photos[$i]['path'].'" style="height:70px;width:70px;border-radius:5px;"/>
                  </a>
                  </li>
                  ';
                }
              } else {
                echo '<p>'.$lang['Nothing_To_Show'].'</p>';
              }
              ?>
            </ul>
          </div>
          <div class="profile-section">
            <h2> <?=$lang['Description']?> </h2>
            <table class="table table-border" style="width:100%;text-align:center;">
              <tr>
                <td align="left">
                  <b style="font-weight:500;"><?=$lang['Gender']?></b>
                </td>
                <td>
                  <?=$lang[$profile->gender]?>
                </td>
              </tr>
              <tr>
                <td align="left">
                  <b style="font-weight:500;"><?=$lang['Sexual_Orientation']?></b>
                </td>
                <td>
                  <?=$lang[$sexual_orientation]?>
                </td>
              </tr>
              <tr>
                <td align="left">
                  <b style="font-weight:500;"><?=$lang['Height']?></b>
                </td>
                <td>
                  <?=$profile->height?> <?=$unit['height']?> 
                </td>
              </tr>
              <tr>
                <td align="left">
                  <b style="font-weight:500;"><?=$lang['Weight']?></b>
                </td>
                <td>
                  <?=$profile->weight?> <?=$unit['weight']?>
                </td>
              </tr>
            </table>
          </div>
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
  <script type="text/javascript" src="js/bxslider.min.js"></script>
  <script type="text/javascript" src="js/app.js"></script>
  <script type="text/javascript" src="js/mobile.js"></script>
  <script type="text/javascript" src="js/jquery.swipebox.min.js"></script>
  <!--[if lte IE 9]><script src="js/placeholders.min.js"></script><![endif]-->
</body>
</html>