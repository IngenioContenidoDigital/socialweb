<?php
define('IS_MOBILE',true);
session_set_cookie_params(172800);
session_start();
require('../core/config.php');
require('../core/auth.php');
require('../core/system.php');
$auth = new Auth;
$system = new System;

$system->domain = $domain;
$system->db = $db;

if(isset($_POST['login'])) {

$email = trim($_POST['email']);
$password = trim($_POST['password']);

$check = $db->query("SELECT * FROM users WHERE email='".$email."'");
if($check->num_rows >= 1) {
  $user = $check->fetch_object();
  if($auth->hashPassword($password) == $user->password) {

  $_SESSION['auth'] = true;
  $_SESSION['email'] = $user->email;
  $_SESSION['user_id'] = $user->id;
  $_SESSION['full_name'] = $user->full_name;
  $_SESSION['is_admin'] = $user->is_admin;

  $error = false;

  header('Location: encounters.php');
  
} else {

  $error = true;

}

} else {

   $error = true;

}

}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>MatchMe - Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <link rel="stylesheet" type="text/css" href="css/normalize.css">
  <link rel="stylesheet" type="text/css" href="css/framework.css">
  <link rel="stylesheet" type="text/css" href="css/theme.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="js/webfont.js"></script>
  <script>
  var base = '<?=$system->getDomain()?>/mobile';
  var page = 'login';
  </script>
  <script type="text/javascript" src="js/modernizr.js"></script>
  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
  <link rel="apple-touch-icon" href="images/favicon.png">
  <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
  <section class="w-section mobile-wrapper">
    <div class="page-content" id="main-stack" data-scroll="0">
      <div class="image-bg-fixed-height">
        <div class="logo-login"></div>
        <p class="text-white"> The best place to meet new people </p>
        <div class="bottom-section padding">
          <div class="w-form">
            <form action="" method="post">
              <div>
                <label class="label-form" for="email-field">USERNAME</label>
                <input class="w-input input-form" id="email" type="email" name="email" data-name="email" required="required" autocomplete="off" value="">
                <div class="separator-fields"></div>
              </div>
              <div>
                <label class="label-form" for="email">PASSWORD</label>
                <div class="w-clearfix block-input-combined">
                  <input class="w-input input-form left" id="password" type="password" name="password" data-name="password" required="required" autocomplete="off" value=""><!--<a class="right-input-link" href="forgot.html" data-load="1">Forgot Password</a>-->
                </div>
                <div class="separator-button-input"></div>
              </div>
              <input class="w-button action-button" type="submit" name="login" value="Sign In" data-wait="Please wait...">
              <div class="separator-button"></div><a class="link-upper" href="register.php" data-load="1">YOU DON’T HAVE AN ACCOUNT? <strong class="b-link">SIGN UP</strong></a>
            </form>
            <?php if(isset($error) && $error == true) { ?>
            <div class="w-form-fail" style="display:block;">
              <p>Invalid Credentials</p>
            </div>
            <? } ?>
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