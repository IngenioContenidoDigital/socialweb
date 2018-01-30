<?php
define('IS_MOBILE',true);
session_set_cookie_params(172800);
session_start();
require('../core/config.php');
require('../core/auth.php');
require('../core/system.php');
$system = new Auth;
$system = new System;

$system->domain = $domain;
$system->db = $db;

$user = $system->getUserInfo($_SESSION['user_id']);
$system->setUserActive($user->id);

$settings = $system->getSettings();

if(isset($_POST['save_1'])) {

  $full_name = $system->secureField($_POST['full_name']);
  $gender = $system->secureField($_POST['gender'][0]);
  $age = $system->secureField($_POST['age']);
  $city = $system->secureField($_POST['city']);
  $explode = explode(',', $city);
  $country = $explode[2];
  $city = $explode[0];
  $bio = $system->secureField($db->real_escape_string($_POST['bio']));
  $new_pasword = $system->secureField($_POST['new_pasword']);
  $confirm_new_password = $system->secureField($_POST['confirm_new_password']);
  $sexual_interest = $system->secureField($_POST['sexual_orientation']);
  $height = $system->secureField($db->real_escape_string($_POST['height']));
  $weight = $system->secureField($db->real_escape_string($_POST['weight']));

  $db->query("
    UPDATE users SET 
    full_name='".$full_name."',
    gender='".$gender."',
    age='".$age."',
    bio='".$bio."',
    city='".$city."',
    country='".$country."',
    sexual_interest='".$sexual_interest."',
    height='".$height."',
    weight='".$weight."',
    updated_preferences='1'
    WHERE id='".$user->id."'");

  header('Location: settings.php');
  exit;
}

if(isset($_POST['save_2'])) {

  $email = $system->secureField($_POST['email']);
  $language = $system->secureField($_POST['language']);

  $db->query("
    UPDATE users SET 
    email='".$email."',
    language='".$language."',
    updated_preferences='1'
    WHERE id='".$user->id."'");

  $_SESSION['language'] = $language;

  if(!empty($_POST['new_password']) && !empty($_POST['confirm_new_password'])) { 

    if($new_password === $confirm_new_password) {
      $new_password = $auth->hashPassword($new_password);
      $db->query("
        UPDATE users SET 
        password='".$new_password."'
        WHERE id='".$user->id."'");
    }
  }
  header('Location: settings.php');
  exit;
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
  <link href="<?=$system->getDomain()?>/assets/css/autocomplete.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="js/webfont.js"></script>
  <script>
  var base = '<?=$system->getDomain()?>/mobile';
  var page = 'settings';
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
          <div class="navbar-title"><?=$lang['Settings']?></div>
          <div class="w-nav-button navbar-button left" id="menu-button" data-ix="hide-navbar-icons">
            <div class="navbar-button-icon home-icon">
              <div class="bar-home-icon"></div>
              <div class="bar-home-icon"></div>
              <div class="bar-home-icon"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="body no-padding">
        <div class="grey-header">
          <h2 class="grey-heading-title"><?=$lang['Profile_Tab_Title']?></h2>
        </div>
        <div class="text-new no-borders">
          <div class="w-form settings-form">
            <form action="" method="post">
              <div>
                <label class="label-form"><?=strtoupper($lang['Full_Name'])?></label>
                <input class="w-input input-form" type="text" name="full_name" required="required" value="<?=$user->full_name?>">
                <div class="separator-fields"></div>
              </div>
              <div>
                <label class="label-form"><?=strtoupper($lang['Age'])?></label>
                <input class="w-input input-form" type="text" name="age" required="required" value="<?=$user->age?>">
                <div class="separator-fields"></div>
              </div>
              <div>
                <label class="label-form"><?=strtoupper($lang['City'])?></label>
                <input class="w-input input-form city-autocomplete" type="text" name="city" required="required" value="<?=$user->city?>" autocomplete="off">
                <div class="separator-fields"></div>
              </div>
              <div>
                <div class="w-clearfix input-form one-line">
                  <label class="label-form middle"><?=strtoupper($lang['Gender'])?></label>
                  <div class="w-clearfix radios-container">
                    <div class="w-radio w-clearfix radio-button">
                      <div class="radio-bullet-replacement <?php if($user->gender === 'Female') { echo 'checked'; } ?>"></div>
                      <input class="w-radio-input radio-bullet" type="radio" name="gender[]" value="Female">
                      <label class="w-form-label"><?=$lang['Female']?></label>
                    </div>
                    <div class="w-radio w-clearfix radio-button">
                      <div class="radio-bullet-replacement <?php if($user->gender === 'Male') { echo 'checked'; } ?>"></div>
                      <input class="w-radio-input radio-bullet" type="radio" name="gender[]" value="Male">
                      <label class="w-form-label"><?=$lang['Male']?></label>
                    </div>
                  </div>
                </div>
                <div class="separator-fields"></div>
              </div>
              <div>
                <label class="label-form"><?=strtoupper($lang['Sexual_Orientation'])?></label>
                <select class="w-input input-form" name="sexual_orientation" required="required">
                  <option value="1" <?php if($user->sexual_interest == 1) { echo 'selected'; } ?>> <?=$lang['Straight']?> </option>
                  <option value="2" <?php if($user->sexual_interest == 2) { echo 'selected'; } ?>> <?=$lang['Gay']?> </option>
                  <option value="3" <?php if($user->sexual_interest == 3) { echo 'selected'; } ?>> <?=$lang['Lesbian']?> </option>
                  <option value="4" <?php if($user->sexual_interest == 4) { echo 'selected'; } ?>> <?=$lang['Bisexual']?> </option>
                </select>
                <div class="separator-fields"></div>
              </div>
              <div>
                <label class="label-form"><?=strtoupper($lang['Height'])?> - <?=$unit['height']?></label>
                <input class="w-input input-form" type="text" name="height" value="<?=$user->height?>" autocomplete="off">
                <div class="separator-fields"></div>
              </div>
              <div>
                <label class="label-form"><?=strtoupper($lang['Weight'])?> - <?=$unit['weight']?></label>
                <input class="w-input input-form" type="text" name="weight" value="<?=$user->weight?>" autocomplete="off">
                <div class="separator-fields"></div>
              </div>
              <div>
                <label class="label-form"><?=strtoupper($lang['Self-summary'])?></label>
                <textarea class="w-input input-form" name="bio" required="required"><?=$user->bio?></textarea>
                <div class="separator-fields"></div>
              </div>
              <input class="w-button action-button" type="submit" name="save_1" value="<?=$lang['Save']?>" data-wait="Please wait...">
            </form>
            <div class="w-form-done">
              <p>Thank you! Your submission has been received!</p>
            </div>
            <div class="w-form-fail">
              <p>Oops! Something went wrong while submitting the form</p>
            </div>
          </div>
        </div>
        <div class="grey-header">
          <h2 class="grey-heading-title"><?=$lang['Account_Tab_Title']?></h2>
        </div>
        <div class="text-new no-borders">
          <div class="w-form settings-form">
            <form action="" method="post">
              <div>
                <label class="label-form"><?=strtoupper($lang['Email'])?></label>
                <input class="w-input input-form" type="email" name="email" required="required" value="<?=$user->email?>">
                <div class="separator-fields"></div>
              </div>
              <div>
                <label class="label-form"><?=strtoupper($lang['New_Password'])?></label>
                <input class="w-input input-form" type="password" name="new_password">
                <div class="separator-fields"></div>
              </div>
              <div>
                <label class="label-form"><?=strtoupper($lang['Confirm_Password'])?></label>
                <input class="w-input input-form" type="password" name="confirm_new_password">
                <div class="separator-fields"></div>
              </div>
              <div>
                <label class="label-form"><?=strtoupper($lang['Language'])?></label>
                <select class="w-input input-form" name="language">
                 <?php
                 $lang_dir = scandir('../languages');
                 foreach($lang_dir as $file) { 
                  if(file_exists('../languages/'.$file.'/language.php')) {
                    if($user->language == $file) {
                      echo '<option value="'.$file.'" selected>'.ucfirst($file).'</option>';
                    } else {
                      echo '<option value="'.$file.'">'.ucfirst($file).'</option>';
                    }
                  } 
                }
                ?>
              </select>
              <div class="separator-fields"></div>
            </div>
            <input class="w-button action-button" type="submit" name="save_2" value="<?=$lang['Save']?>" data-wait="Please wait...">
          </form>
        </div>
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
<script src="<?=$system->getDomain()?>/assets/js/autocomplete.js"></script>
<script type="text/javascript" src="js/app.js"></script>
<!--[if lte IE 9]><script src="js/placeholders.min.js"></script><![endif]-->
</body>
</html>