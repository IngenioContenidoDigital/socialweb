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

if(isset($_POST['register'])) {

  $full_name = ucwords($_POST['full_name']);
  $email = $_POST['email'];
  $password = trim($_POST['password']);
  $time = time();
  $age = $_POST['age'];
  $gender = $_POST['gender'][0];

  $check_d = $db->query("SELECT id FROM users WHERE email='".$email."'");
  $check_d = $check_d->num_rows;
  if($check_d == 0) {
    $db->query("INSERT INTO users (profile_picture,full_name,email,password,registered,credits,age,gender) VALUES ('default_avatar.png','$full_name','$email','".$auth->hashPassword($password)."','$time','100','$age','$gender')");

    $_SESSION['auth'] = true;
    $_SESSION['email'] = $email;
    $_SESSION['user_id'] = $db->insert_id;
    $_SESSION['full_name'] = $full_name;
    $_SESSION['is_admin'] = 0;

    $db->query("UPDATE users SET last_login=UNIX_TIMESTAMP() WHERE email='".$email."'");

    header('Location: '.$domain.'/mobile/encounters.php');
    exit;

  }

}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>MatchMe - Sign Up</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <link rel="stylesheet" type="text/css" href="css/normalize.css">
  <link rel="stylesheet" type="text/css" href="css/framework.css">
  <link rel="stylesheet" type="text/css" href="css/theme.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="js/webfont.js"></script>
  <script>
  var base = '<?=$system->getDomain()?>/mobile';
  var page = 'register';
  </script>
  <script type="text/javascript" src="js/modernizr.js"></script>
  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
  <link rel="apple-touch-icon" href="images/favicon.png">
  <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
  <section class="w-section mobile-wrapper">
    <div class="image-bg-fixed-height">
      <div class="page-content" id="main-stack" data-scroll="0">
        <div class="w-nav navbar" data-collapse="all" data-animation="over-left" data-duration="400" data-contain="1" data-easing="ease-out-quint" data-no-scroll="1">
          <div class="w-container">
            <div class="wrapper-mask" data-ix="menu-mask"></div>
            <div class="navbar-title">Sign Up</div>
            <div class="navbar-button-icon icon" style="float:right;">
              <a href="login.php" data-load="0">
                <div class="ion-ios-close-empty text-white"></div>
              </a>
            </div>
          </div>
        </div>
        <div class="body padding">
          <div class="logo-login"></div>
          <div class="bottom-section padding">
            <div class="w-form">
              <form action="" method="post">
                <div>
                  <label class="label-form" for="full-name-field">FULL NAME</label>
                  <input class="w-input input-form" type="text" name="full_name" data-name="full-name" required="required" autocomplete="off">
                  <div class="separator-fields"></div>
                </div>
                <div>
                  <label class="label-form" for="email-field">EMAIL</label>
                  <input class="w-input input-form" type="email" name="email" data-name="email" required="required" autocomplete="off">
                  <div class="separator-fields"></div>
                </div>
                <div>
                  <label class="label-form" for="password-ield">PASSWORD</label>
                  <input class="w-input input-form" type="password" name="password" data-name="password" required="required" autocomplete="off">
                  <div class="separator-fields"></div>
                </div>
                <div>
                  <label class="label-form" for="birthday-field">AGE</label>
                  <input class="w-input input-form" type="text" name="age" data-name="birthday" required="required" autocomplete="off">
                </div>
                <div>
                  <div class="w-clearfix input-form one-line">
                    <label class="label-form middle" for="email">GENDER</label>
                    <div class="w-clearfix radios-container">
                      <div class="w-radio w-clearfix radio-button">
                        <div class="radio-bullet-replacement"></div>
                        <input class="w-radio-input radio-bullet" type="radio" name="gender[]" value="Female">
                        <label class="w-form-label text-white">Female</label>
                      </div>
                      <div class="w-radio w-clearfix radio-button">
                        <div class="radio-bullet-replacement"></div>
                        <input class="w-radio-input radio-bullet" type="radio" name="gender[]" value="Male">
                        <label class="w-form-label text-white">Male</label>
                      </div>
                    </div>
                  </div>
                  <div class="separator-fields"></div>
                </div>
                <div class="separator-button-input"></div>
                <input class="w-button action-button" type="submit" name="register" value="Sign Up" data-wait="Please wait...">
                <div class="separator-button"></div><a class="link-upper" href="login.php" data-load="1">ALREADY HAVE AN ACCOUNT? <strong class="b-link">SIGN IN</strong></a>
              </form>
              <div class="w-form-done">
                <p>Thank you! Your submission has been received!</p>
              </div>
              <div class="w-form-fail">
                <p>Oops! Something went wrong while submitting the form</p>
              </div>
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
  <script type="text/javascript" src="js/app.js"></script>
  <script type="text/javascript" src="js/mobile.js"></script>
  <!--[if lte IE 9]><script src="js/placeholders.min.js"></script><![endif]-->
</body>
</html>