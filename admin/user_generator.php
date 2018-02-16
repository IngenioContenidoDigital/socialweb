<?php
error_reporting(E_ALL);
define('IS_AJAX', true);
session_set_cookie_params(172800);
session_start();
require('../core/config.php');
require('../core/auth.php');
require('../core/system.php');
require('../core/image.php');
$auth = new Auth;
$system = new System;

$system->domain = $domain;
$system->db = $db;

$menu['user_generator'] = 'active';
$page['name'] = 'User Generator';

$user = $system->getUserInfo($_SESSION['user_id']);

if(!$auth->isLogged() || $user->is_admin != 1) {
	header('Location: index.php');
	exit;
}

$success=false;
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $full_name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $sexual_orientation = $_POST['sexual_orientation'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $bio = $_POST['bio'];
    $email = $_POST['email'];
    //$new_password = trim($_POST['new_password']);
    //$confirm_new_password = trim($_POST['confirm_new_password']);
    $website_language = $_POST['website_language'];
    $is_admin = $_POST["is_admin"];
    $time = time();
    $error_msg="";
    $error = false;
    
    $check_d = $db->query("SELECT id FROM users WHERE full_name='".$full_name."'");
    $check_d = $check_d->num_rows;
    if($check_d == 0) {
        $sql="INSERT INTO users "
                . "(full_name, email, country, city, age, bio, gender, sexual_interest, registered, is_admin, is_verified, has_disabled_ads, language, height, weight) "
                . "VALUES ('$full_name','$email', '".$country."' ,'$city','$age','$bio','$gender','$sexual_orientation','".$time."','".$is_admin."',1,1,'$website_language','$height','$weight')";
        $db->query($sql);
        $new_user = mysqli_insert_id($db);
        if($_FILES['profile_photo']['name']) {
            $extension = strtolower(end(explode('.', $_FILES['profile_photo']['name'])));
            if($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg') {
              if(!$_FILES['profile_photo']['error']) {
                $new_file_name = md5(mt_rand()).$_FILES['profile_photo']['name'];
                if($_FILES['profile_photo']['size'] > (1024000)) {
                  $valid_file = false;
                  $error_msg = 'Oops! One of the photos you uploaded is too large';
                  $success = false;
                } else {
                  $valid_file = true;
                }
                if($valid_file) {
                  move_uploaded_file($_FILES['profile_photo']['tmp_name'], '../uploads/'.$new_file_name);
                  $resize = new ResizeImage('../uploads/'.$new_file_name);
                  $resize->resizeTo(640, 640);
                  $resize->saveImage('/uploads/'.$new_file_name);
                  $uploaded = true;
                  $db->query("INSERT INTO uploaded_photos (user_id,path,time) VALUES ('".$user->id."','".$new_file_name."','".time()."')");
                  $db->query("UPDATE users SET profile_picture='".$new_file_name."' , uploaded_photos=uploaded_photos+1 WHERE id='".$new_user."'");
                }
              }
              else {
                $error_msg = 'Error occured:  '.$_FILES['photo_file']['error'];
                $success = false;
              }
            } 
        }   
        $success = true;
     }else{
        $error_msg='Another user with that name already exists';
        $success = false;
     }
}

require('../inc/admin/top.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    echo '<br><section id="page-content">
    <div class="row">
        <div class="col-lg-12">
        <div class="container">';
    if($success){        
        echo '<div class="alert alert-success">Usuario Creado con &Eacute;xito</div>';
    }else{
        echo '<div class="alert alert-danger">'.$error_msg.'</div>';
    }   
    echo '</section></div></div></div>';
}
require('../layout/admin/user_generator.php');
require('../inc/admin/bottom.php');