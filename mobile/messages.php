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

$messages = $db->query("SELECT * FROM messages WHERE (user1='".$user->id."' OR user2='".$user->id."') AND is_sticker='0' GROUP by user1,user2 ORDER BY id DESC");
$occurrences = array();
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
  <link rel="stylesheet" type="text/css" href="css/simplegrid.css">
  <script src="js/webfont.js"></script>
  <script>
  var base = '<?=$system->getDomain()?>/mobile';
  var page = 'messages';
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
            <!--<a class="w-clearfix w-inline-block nav-menu-link" href="visitors.php" data-load="1">
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
            </a>-->
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
          <div class="navbar-title"><?=$lang['Messages']?></div>
          <div class="w-nav-button navbar-button left" id="menu-button" data-ix="hide-navbar-icons">
            <div class="navbar-button-icon home-icon">
              <div class="bar-home-icon"></div>
              <div class="bar-home-icon"></div>
              <div class="bar-home-icon"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="body">
       <ul class="list list-messages">
        <?php
        while($message = $messages->fetch_object()) {
          if($message->user1 != $user->id) { $other_user = $system->getUserInfo($message->user1); } 
          elseif($message->user2 != $user->id) { $other_user = $system->getUserInfo($message->user2); }
          if(!in_array($other_user->id, $occurrences)) {
            $occurrences[] = $other_user->id;
            echo '
            <li class="list-message" data-ix="list-item">
            <a class="w-clearfix w-inline-block" href="chat.php?id='.$other_user->id.'&receiver='.$other_user->full_name.'" data-load="1">
            <div class="w-clearfix column-left">
            <div class="image-message"><img src="'.$system->getProfilePicture($other_user).'">
            </div>
            </div>
            <div class="column-right">
            <div class="message-title">'.$system->getFirstName($other_user->full_name).'</div>
            <div class="message-text">'.$message->message.'</div>
            </div>
            </a>
            </li>
            ';
          }
        }
        ?>
      </ul>
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