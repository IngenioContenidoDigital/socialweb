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

// Create / Update Filter
if(isset($_POST['filter'])) {
  $sexual_preference = $_POST['sexual_preference'][0];

  $country = '';

  if(isset($_POST['order_by'])) {
    $order_by = 3;
  } else {
    $order_by = 4;
  }

  $age_range = $_POST['age_min'].','.$_POST['age_max'];

  if(isset($_POST['distance'])) {
    $distance = $_POST['distance'][0];
    if($distance == 1) {
      $distance_range = '0,100';
      $location_dating = 1;
    } elseif($distance == 2) {
      $distance_range = '0,500';
      $location_dating = 0;
      $country = $user->country;
    } else {
      $distance_range = '0,500';
      $location_dating = 0;
      $country = 'All Countries';
    }
  }

  $filter = $db->query("SELECT * FROM filters WHERE user_id='".$user->id."'");
  $num_rows = $filter->num_rows;

  if($num_rows == 0) {
    $db->query("INSERT INTO filters (user_id,sexual_preference,country,order_by,age_range,distance_range,location_dating) VALUES ('".$user->id."','".$sexual_preference."','".$country."','".$order_by."','".$age_range."','".$distance_range."','".$location_dating."')");
    header('Location: '.$system->getDomain().'/mobile/people.php');
    exit;
  } else {
    $db->query("UPDATE filters SET sexual_preference='".$sexual_preference."',country='".$country."',order_by='".$order_by."',age_range='".$age_range."',distance_range='".$distance_range."',location_dating='".$location_dating."' WHERE user_id='".$user->id."'");
    header('Location: '.$system->getDomain().'/mobile/people.php');
    exit; 
  }
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
  <script src="js/webfont.js"></script>
  <script>
  var base = '<?=$system->getDomain()?>/mobile';
  var page = 'people';
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
          <div class="navbar-title"><?=$lang['Filter']?></div>
          <div class="w-nav-button navbar-button left" id="menu-button" data-ix="hide-navbar-icons">
            <div class="navbar-button-icon home-icon">
              <div class="bar-home-icon"></div>
              <div class="bar-home-icon"></div>
              <div class="bar-home-icon"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="body padding">
        <div class="filter-container">
          <div class="w-form">
            <form action="" method="post">
              <div>
                <div class="w-clearfix input-form one-line">
                  <label class="label-form middle" for="email"><?=strtoupper($lang['Gender'])?></label>
                  <div class="w-clearfix radios-container">
                    <div class="w-radio w-clearfix radio-button">
                      <div class="radio-bullet-replacement"></div>
                      <input class="w-radio-input radio-bullet checked" type="radio" name="sexual_preference[]" value="3">
                      <label class="w-form-label"><?=$lang['All_Genders']?></label>
                    </div>
                    <div class="w-radio w-clearfix radio-button">
                      <div class="radio-bullet-replacement"></div>
                      <input class="w-radio-input radio-bullet" type="radio" name="sexual_preference[]" value="2">
                      <label class="w-form-label"><?=$lang['Female']?></label>
                    </div>
                    <div class="w-radio w-clearfix radio-button">
                      <div class="radio-bullet-replacement checked"></div>
                      <input class="w-radio-input radio-bullet" type="radio" name="sexual_preference[]" value="1">
                      <label class="w-form-label"><?=$lang['Male']?></label>
                    </div>
                  </div>
                </div>
                <div class="separator-fields"></div>
              </div>
              <div class="w-clearfix">
                <div class="row-input-list w50 left">
                  <label class="label-form active" for="age-min"><?=strtoupper($lang['Min_Age'])?></label>
                  <input class="w-input input-form" id="age-min" type="text" value="18" name="age_min" maxlength="2"  required="required">
                  <div class="separator-fields"></div>
                </div>
                <div class="row-input-list w50">
                  <label class="label-form active" for="age-max">A<?=strtoupper($lang['Max_Age'])?></label>
                  <input class="w-input input-form" id="age-max" type="text" value="23" name="age_max" maxlength="2" required="required">
                  <div class="separator-fields"></div>
                </div>        
              </div>
              <div>
                <div class="w-clearfix input-form one-line">
                  <label class="label-form middle" for="email"><?=strtoupper($lang['Distance'])?></label>
                  <div class="w-clearfix radios-container">
                   <div class="w-radio w-clearfix radio-button">
                    <div class="radio-bullet-replacement"></div>
                    <input class="w-radio-input radio-bullet" type="radio" name="distance[]" value="3">
                    <label class="w-form-label"><?=$lang['World']?></label>
                  </div>
                  <div class="w-radio w-clearfix radio-button">
                    <div class="radio-bullet-replacement"></div>
                    <input class="w-radio-input radio-bullet checked" type="radio" name="distance[]" value="2">
                    <label class="w-form-label"><?=$lang['Country']?></label>
                  </div>
                  <div class="w-radio w-clearfix radio-button">
                    <div class="radio-bullet-replacement checked"></div>
                    <input class="w-radio-input radio-bullet" type="radio" name="distance[]" value="1">
                    <label class="w-form-label"><?=$lang['City']?></label>
                  </div>
                </div>
              </div>
              <div class="separator-fields"></div>
            </div>
            <div>
              <div class="w-clearfix input-form one-line">
                <label class="label-form middle" for="email"><?=strtoupper($lang['Recently_Online'])?></label>
                <div class="w-clearfix radios-container">
                  <div class="w-checkbox w-clearfix checkbox-field">
                    <div class="checkbox-handle"></div>
                    <input class="w-checkbox-input checkbox-input" name="order_by" id="is-online" type="checkbox">
                    <label class="w-form-label checkbox-label" for="is-online"></label>
                  </div>
                </div>
              </div>
              <div class="separator-fields"></div>
            </div>
            <input class="w-button action-button" type="submit" name="filter" value="<?=$lang['Save']?>" data-wait="Please wait...">
          </form>
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
<script type="text/javascript" src="js/app.js"></script>
<script type="text/javascript" src="js/mobile.js"></script>
<!--[if lte IE 9]><script src="js/placeholders.min.js"></script><![endif]-->
</body>
</html>