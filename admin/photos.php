<?php
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

$menu['photos'] = 'active';
$page['name'] = 'Manage Photos';

$user = $system->getUserInfo($_SESSION['user_id']);

if(!$auth->isLogged() || $user->is_admin != 1) {
	header('Location: index.php');
	exit;
}

$success=false;
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $user = $_POST['user'];
    $time = time();
    $error_msg="";
    $error = false;

if($_FILES['photo_file']['name']) {
    $extension = strtolower(end(explode('.', $_FILES['photo_file']['name'])));
    if($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg') {
      if(!$_FILES['photo_file']['error']) {
        $new_file_name = md5(mt_rand()).$_FILES['photo_file']['name'];
        if($_FILES['photo_file']['size'] > (1024000)) {
          $valid_file = false;
          $error_msg = 'Oops! One of the photos you uploaded is too large';
          $success = false;
        } else {
          $valid_file = true;
        }
        if($valid_file) {
          move_uploaded_file($_FILES['photo_file']['tmp_name'], '../uploads/'.$new_file_name);
          $resize = new ResizeImage('../uploads/'.$new_file_name);
          $resize->resizeTo(640, 640);
          $resize->saveImage('/uploads/'.$new_file_name);
          $uploaded = true;
          
            $sql="INSERT INTO uploaded_photos "
                    . "(user_id, path, is_instagram, time) "
                    . "VALUES ('$user','$new_file_name', 0 ,'$time')";
            $db->query($sql);
            $db->query("UPDATE users SET uploaded_photos=uploaded_photos+1 WHERE id='".$user."'");
        }
      }else {
        $error_msg = 'Error occured:  '.$_FILES['photo_file']['error'];
        $success = false;
      }
    } 
}
    $success = true;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    echo '<br>
    <div class="row">
        <div class="col-lg-12">
        <div class="container">';
    if($success){        
        echo '<div class="alert alert-success">Image uploaded succefully</div>';
    }else{
        echo '<div class="alert alert-danger">'.$error_msg.'</div>';
    }   
    echo '</div></div></div>';
}

if(isset($_GET['delete']) && isset($_GET['delid'])) {
	$delid = $_GET['delid'];
	$path = $_GET['path'];
	$db->query("DELETE FROM uploaded_photos WHERE id='".$delid."'");
	unlink('../uploads/'.$path);
	header('Location: photos.php?success');
	exit;
}

$photos = "SELECT * FROM uploaded_photos ORDER BY id DESC";

// Pagination
$per_page = 9;
$count = $db->query($photos)->num_rows;
$last_page = ceil($count/$per_page);
if(isset($_GET['p'])) { $p = $_GET['p']; } else { $p = 1; }
if($p < 1) { $p = 1; } elseif($p > $last_page) { $p = $last_page; }
$limit = 'LIMIT ' .($p - 1) * $per_page .',' .$per_page;
$photos.= " $limit";

$photos = $db->query($photos);

require('../inc/admin/top.php');
require('../layout/admin/photos.php');
require('../inc/admin/bottom.php');