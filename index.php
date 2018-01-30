<?php
session_set_cookie_params(172800);
session_start();
require('core/config.php');
require('core/auth.php');
require('core/system.php');
require('core/geo.php');
require('core/phpmailer/PHPMailerAutoload.php');
$auth = new Auth;
$geo = new Geo;
$system = new System;
$mail = new PHPMailer;

$system->domain = $domain;
$system->db = $db;

$ip = $_SERVER['REMOTE_ADDR'];

// Geolocation
$longitude = $_SESSION['longitude'];
$latitude = $_SESSION['latitude'];

$geo_info = $geo->getInfo($latitude,$longitude);
$city = $geo_info['geonames'][0]['name'];
$country = $geo_info['geonames'][0]['countryName'];

$settings = $system->getSettings();

if(isset($_POST['register'])) {

  $full_name = ucwords($_POST['full_name']);
  $email = $_POST['email'];
  $password = trim($_POST['password']);
  $time = time();
  $age = $_POST['age'];
  $gender = $_POST['gender'];

  $check_d = $db->query("SELECT id FROM users WHERE email='".$email."'");
  $check_d = $check_d->num_rows;
  if($check_d == 0) {
    $db->query("INSERT INTO users (profile_picture,full_name,email,password,registered,credits,age,gender,ip,country,city,longitude,latitude,sexual_interest) VALUES ('default_avatar.png','$full_name','$email','".$auth->hashPassword($password)."','$time','100','$age','$gender','$ip','".$country."','".$city."','".$longitude."','".$latitude."','1')");
    setcookie('justRegistered', 'true', time()+6);
    setcookie('mm-email',$email,time()+60*60*24*30,'/');

    $_SESSION['auth'] = true;
    $_SESSION['email'] = $email;
    $_SESSION['user_id'] = $db->insert_id;
    $_SESSION['full_name'] = $full_name;
    $_SESSION['is_admin'] = 0;

    $db->query("UPDATE users SET last_login=UNIX_TIMESTAMP(),ip='".$ip."',longitude='".$longitude."',latitude='".$latitude."' WHERE email='".$email."'");

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'in-v3.mailjet.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = '3c36d8fa42306c3e03ffbaf7aae90263';                 // SMTP username
    $mail->Password = '0461c39d64cba808dae9b7c94c2fbf6d';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom($email_sender);
    $mail->addAddress($email);

    $mail->isHTML(true);

    $code = substr(md5(uniqid()),0,10);
    $mail->Subject = sprintf($lang['Verify_Account_Title'],$site_name);
    $content = '<a href="'.$system->getDomain().'/verify-email.php?code='.$code.'">this link</a>';
    $mail->Body = sprintf($lang['Verify_Account_Content'],$content);

    if(!$mail->send()) {
      die('An error occurred, Mail could not be sent / '.$mail->ErrorInfo);
    } 

    $db->query("INSERT INTO activation_codes(user_id,code,time) VALUES (".$_SESSION['user_id'].",'".$code."',".time().")");

    header('Location: '.$domain.'/wizard');
    exit;

  }

}

if(isset($_POST['login'])) {

 $email = $_POST['email'];
 $password = trim($_POST['password']);

 $check = $db->query("SELECT * FROM users WHERE email='$email'");
 if($check->num_rows >= 1) {
  $user = $check->fetch_array();
  if($auth->hashPassword($password) == $user['password']) {

   if(isset($_POST['remember'])) {
    setcookie('mm-email',$email,time()+60*60*24*30,'/');
  } else {
    setcookie('mm-email', null, -1, '/');
    $remember = "";
  }

  $_SESSION['auth'] = true;
  $_SESSION['email'] = $user['email'];
  $_SESSION['user_id'] = $user['id'];
  $_SESSION['full_name'] = $user['full_name'];
  $_SESSION['is_admin'] = $user['is_admin'];

  $db->query("UPDATE users SET last_login=UNIX_TIMESTAMP(),ip='".$ip."',longitude='".$longitude."',latitude='".$latitude."' WHERE email='".$email."'");

  if($user['updated_preferences'] == 1) {
    header('Location: '.$domain.'/encounters');
    exit;
  } else {
    header('Location: '.$domain.'/wizard');
    exit;
  }

} else {
 $error = 'Invalid Credentials';
}

} else {
  $error = 'Invalid Credentials';
}

}

$users = $db->query("SELECT * FROM users WHERE profile_picture != 'default_avatar.png' ORDER BY RAND() LIMIT 8");
$users_count = $db->query("SELECT * FROM users");

if(isset($_GET['lang'])) {
  $_SESSION['language'] = $_GET['lang'];
}

if(!isset($_SESSION['language'])) {
  $language = 'english';
} else {
  $language = $_SESSION['language'];
}
$path = 'languages/'.strtolower($language).'/language.php';
require($path);

if(isset($_GET['login'])) {
  $current = '?login';
} elseif(isset($_GET['register'])) {
  $current = '?register';
}
if(isset($_GET['login']) || isset($_GET['register'])) {
  $combine = '&';
} else {
  $combine = '?';
}

// Get landing page ad
$ads = $db->query("SELECT * FROM ads LIMIT 1");
$ad = $ads->fetch_object();

?>
<!DOCTYPE HTML>
<!--[if lt IE 7 ]><html class="ie ie6 ie-lt10 ie-lt9 ie-lt8 ie-lt7 no-js" lang="en"><![endif]-->
<!--[if IE 7 ]><html class="ie ie7 ie-lt10 ie-lt9 ie-lt8 no-js" lang="en"><![endif]-->
<!--[if IE 8 ]><html class="ie ie8 ie-lt10 ie-lt9 no-js" lang="en"><![endif]-->
<!--[if IE 9 ]><html class="ie ie9 ie-lt10 no-js" lang="en"><![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="en"><!--<![endif]-->
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <meta charset="utf-8">
  <title><?php echo $site_name?> - Online Dating Community</title>
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
  <link href="<?=$system->getDomain()?>/assets/bootstrap3/css/bootstrap.css" rel="stylesheet">
  <link rel="stylesheet" href="<?=$system->getDomain()?>/assets/landing/bootstrap-social/bootstrap-social.css">
  <link href="<?=$system->getDomain()?>/assets/css/theme.css" rel="stylesheet">
  <link href="<?=$system->getDomain()?>/assets/css/icomoon.css" rel="stylesheet" type="text/css" />
  <link href="<?=$system->getDomain()?>/assets/landing/styles.css" rel="stylesheet">
</head>
<body>
  <!-- Full Width Image Header with Logo -->
  <!-- Image backgrounds are set within the full-width-pics.css file. -->
  <header class="image-bg-fixed-height">

    <!-- Navigation -->
    <nav class="navbar navbar-ct-transparent" role="navigation">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php"><img src="<?=$system->getDomain()?>/img/logo-small.png"></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav navbar-right">
            <li>
              <div class="dropdown">
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                  <i class="icon icon-earth"></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                  <?php
                  $lang_dir = scandir('languages');
                  foreach($lang_dir as $file) { 
                    if(file_exists('languages/'.$file.'/language.php')) {
                      if($_SESSION['language'] == $file) {
                        echo '<li><a href="'.$_SERVER['PHP_SELF'].''.$current.$combine.'lang='.$file.'" style="font-weight:400!important;">'.ucfirst($file).'</a></li>';
                      } else {
                        echo '<li><a href="'.$_SERVER['PHP_SELF'].''.$current.$combine.'lang='.$file.'" style="font-weight:500!important;">'.ucfirst($file).'</a></li>';
                      }
                    } 
                  }
                  ?>
                </ul>
              </div>
            </li>
            <?php if(!isset($_GET['login'])) { ?>
            <li>
              <a href="<?=$system->getDomain()?>/index.php?login"><?=$lang['index_3']?></a>
            </li>
            <? } else { ?>
            <li>
              <a href="<?=$system->getDomain()?>/index.php?register"><?=$lang['index_2']?></a>
            </li>
            <? } ?>
          </ul>
        </div>
        <!-- /.navbar-collapse -->
      </div>
      <!-- /.container -->
    </nav>

    <div class="intro-container">
      <?php
      while($user = $users->fetch_object()) {
        echo '<img src="'.$system->getProfilePicture($user).'" class="img-circle" style="height:50px!important;width:50px!important;margin:10px;">';
      }
      ?>
    </div>

    <div class="form-container">
      <h1><?=$lang['index_1']?></h1>
      <form action="fb-login.php" method="post">
        <button type="submit" name="fb-login" class="btn btn-subsection btn-social btn-lg btn-block btn-facebook btn-fill" style="text-align:left;"><i class="icon icon-facebook" style="font-size:21px;"></i><?=$lang['Log_In_With_Facebook']?></button> <br>
      </form>
      <div class="well">
        <?php if(!isset($_GET['login'])) { ?>
        <div class="form-title"><?=$lang['index_2']?></div>
        <div class="clearfix"></div>
        <form action="" method="post">
          <input type="text" name="full_name" placeholder="<?=$lang['Full_Name']?>" class="form-control" required>  <br>
          <input type="text" name="email" placeholder="<?=$lang['Email']?>" class="form-control" required> <br>
          <input type="password" name="password" placeholder="<?=$lang['Password']?>" class="form-control" required> <br>
          <select name="age" autocomplete="off" required class="form-control">
            <option value="" disabled selected><?=$lang['Age']?></option>
            <?php for($i = $minimum_age; $i <= 100; $i++) { ?>
            <option value="<?php echo $i?>"> <?php echo $i?> </option>
            <?php } ?>
          </select> <br>
          <select name="gender" autocomplete="off" required class="form-control">
            <option value="" disabled selected><?=$lang['Gender']?></option>
            <option value="Male"><?=$lang['Male']?></option>
            <option value="Female"><?=$lang['Female']?></option>
          </select> <br>
          <input type="submit" name="register" class="btn btn-danger btn-fill btn-block" value="<?=$lang['index_7']?>">
        </form>
        <? } else { ?>
        <div class="form-title"><?=$lang['index_4']?></div>
        <div class="clearfix"></div>
        <?php if(isset($error)) { echo '<div class="alert alert-warning">'.$error.'</div>'; } ?>
        <form action="" method="post">
          <input type="text" name="email" placeholder="<?=$lang['Email']?>" class="form-control" required> <br>
          <input type="password" name="password" placeholder="<?=$lang['Password']?>" class="form-control" required> <br>
          <input type="submit" name="login" class="btn btn-danger btn-fill btn-block" value="<?=$lang['index_3']?>">
        </form>
        <? } ?>
      </div>
    </div>
    <div class="counter"> <?=number_format($users_count->num_rows)?> <span>users</span> </div>
  </header>
  <!-- /.container -->
  <script src="<?=$system->getDomain()?>/assets/js/jquery-1.10.2.js"></script>
  <script src="<?=$system->getDomain()?>/assets/bootstrap3/js/bootstrap.js"></script>
  <script src="<?=$system->getDomain()?>/assets/js/app.js"></script>
  <script src="<?=$system->getDomain()?>/assets/js/theme.js"></script>
  <script src="<?=$system->getDomain()?>/assets/js/icomoon.js"></script>
  <script>
  navigator.geolocation.getCurrentPosition(getPosition);
  function getPosition(position) {
    $.get('<?=$system->getDomain()?>/ajax/setPosition.php?longitude='+position.coords.longitude+'&latitude='+position.coords.latitude);
  }
  setInterval(function() { 
    var width = $(window).width();
    if (width <= 500) { 
      window.location = '<?=$system->getDomain()?>/mobile';
    } 
  }, 1000);
  </script>
</body>
</html>