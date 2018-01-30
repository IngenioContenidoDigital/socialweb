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

$user = $system->getUserInfo($_SESSION['user_id']);
$user2 = $_GET['id'];

$messages = $db->query("SELECT * FROM messages WHERE (user1='".$user->id."' AND user2='".$user2."') OR (user1='".$user2."' AND user2='".$user->id."') ORDER BY id ASC");
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
          <div class="navbar-title"><?=$system->getFirstName($_GET['receiver'])?></div>
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
        <ul class="list list-chats">
          <?php
          while($message = $messages->fetch_object()) {
            $sender = $system->getUserInfo($message->user1);
            if($message->is_sticker == 1) {
              $sticker = $db->query("SELECT id,pack_id,path FROM stickers WHERE id='".$message->sticker_id."'");
              $sticker = $sticker->fetch_object();
              if($sender->id == $user->id) {
                echo '
                <li class="list-chat right">
                <div class="w-clearfix column-right chat right">
                <div class="arrow-globe right"></div>
                <div class="chat-text right"><img src="'.$system->getDomain().'/img/stickers/'.$sticker->pack_id.'/'.$sticker->path.'" class="sticker-chat"></div>
                <div class="chat-time right">'.$system->timeAgo($lang,$message->time).'</div>
                </div>
                </li>
                ';
              } else {
                echo '
                <li class="w-clearfix list-chat">
                <div class="column-left chat">
                <div class="image-message chat"><img src="'.$system->getProfilePicture($sender).'">
                </div>
                </div>
                <div class="w-clearfix column-right chat">
                <div class="arrow-globe"></div>
                <div class="chat-text"><img src="'.$system->getDomain().'/img/stickers/'.$sticker->pack_id.'/'.$sticker->path.'" class="sticker-chat"></div>
                <div class="chat-time">'.$system->timeAgo($lang,$message->time).'</div>
                </div>
                </li>
                ';
              } 
            } else {
              if($sender->id == $user->id) {
                echo '
                <li class="list-chat right">
                <div class="w-clearfix column-right chat right">
                <div class="arrow-globe right"></div>
                <div class="chat-text right">'.$message->message.'</div>
                <div class="chat-time right">'.$system->timeAgo($lang,$message->time).'</div>
                </div>
                </li>
                ';
              } else {
                echo '
                <li class="w-clearfix list-chat">
                <div class="column-left chat">
                <div class="image-message chat"><img src="'.$system->getProfilePicture($sender).'">
                </div>
                </div>
                <div class="w-clearfix column-right chat">
                <div class="arrow-globe"></div>
                <div class="chat-text">'.$message->message.'</div>
                <div class="chat-time">'.$system->timeAgo($lang,$message->time).'</div>
                </div>
                </li>
                ';
              }
            }
          }
          ?>
        </ul>
        <input type="hidden" id="receiver_id" value="<?=$_GET['id']?>">
      </div>
      <div class="input-chat-block">
        <div class="w-form">
            <input class="w-input input-chat" id="message" type="text" placeholder="Your message" required="required">
            <button id="chat-send" class="w-button chat-button" data-wait="Please wait..." onclick="sendMessage()">Send</button>
          <div class="w-form-done">
            <p>Thank you! Your submission has been received!</p>
          </div>
          <div class="w-form-fail">
            <p>Oops! Something went wrong while submitting the form</p>
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