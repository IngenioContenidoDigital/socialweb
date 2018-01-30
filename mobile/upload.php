<?php
define('IS_MOBILE',true);
session_set_cookie_params(172800);
session_start();
require('../core/config.php');
require('../core/system.php');
require('../core/image.php');
$system = new System;

$system->domain = $domain;
$system->db = $db;

$user = $system->getUserInfo($_SESSION['user_id']);
$system->setUserActive($user->id);

// Photo Upload
if(isset($_POST['upload']) && !empty($_FILES)) {
  if($_FILES['photo_file']['name']) {
    $extension = strtolower(end(explode('.', $_FILES['photo_file']['name'])));
    if($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg') {
      if(!$_FILES['photo_file']['error']) {
        $new_file_name = md5(mt_rand()).$_FILES['photo_file']['name'];
        if($_FILES['photo_file']['size'] > (1024000)) {
          $valid_file = false;
          $error = 'Oops! One of the photos you uploaded is too large';
        } else {
          $valid_file = true;
        }
        if($valid_file) {
          move_uploaded_file($_FILES['photo_file']['tmp_name'], '../uploads/'.$new_file_name);
          $resize = new ResizeImage('../uploads/'.$new_file_name);
          $resize->resizeTo(640, 640);
          $resize->saveImage('../uploads/'.$new_file_name);
          $uploaded = true;
          $db->query("INSERT INTO uploaded_photos (user_id,path,time) VALUES ('".$user->id."','".$new_file_name."','".time()."')");
          $db->query("UPDATE users SET uploaded_photos=uploaded_photos+1 WHERE id='".$user->id."'");
        }
      }
      else {
        $error = 'Error occured:  '.$_FILES['photo_file']['error'];
      }
    } 
  }
  header('Location: '.$system->getDomain().'/mobile/user.php?id='.$user->id);
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
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="js/webfont.js"></script>
  <script>
  var base = '<?=$system->getDomain()?>/mobile';
  var page = 'upload';
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
          <div class="navbar-title"><?=$lang['Upload']?></div>
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
       <div class="alert alert-danger" id="photo-upload-error" style="display:none;"></div>
          <div class="photo-upload-area">
          <a href="#" class="photo-upload-select no-underline text-muted" onclick="selectPhoto()"> <i class="ion-image" style="margin-right:5px;"></i> <?=$lang['Select_Photo']?> </a>
          <div class="clearfix"></div>
          <img src="" class="photo-upload-preview img-rounded" style="max-height:200px;max-width:200px;border-radius:5px;">
          <form action="" method="post" enctype="multipart/form-data">
          <input type="file" id="photo_file" name="photo_file" onchange="photoChange(this)" style="display:none;">
          <input class="w-button action-button" type="submit" name="upload" value="<?=$lang['Upload']?>" data-wait="Please wait...">
        </div>
        </form>
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
  <!--[if lte IE 9]><script src="js/placeholders.min.js"></script><![endif]-->
</body>
</html>