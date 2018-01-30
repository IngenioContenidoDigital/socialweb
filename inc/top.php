<?php

$ucount = $db->query("SELECT id FROM notifications WHERE receiver_id='".$user->id."' AND is_read='0'");
$ucount = $ucount->num_rows;
$custom_pages = $db->query("SELECT * FROM pages ORDER BY id DESC");
$last_chatted = $db->query("SELECT * FROM messages WHERE (user1='".$user->id."' OR user2='".$user->id."')  ORDER BY id DESC LIMIT 1");
$last_chatted = $last_chatted->fetch_object();
if($user->id != $last_chatted->user1) {
    $last_chatted = $last_chatted->user1;
} else {
    $last_chatted = $last_chatted->user2;
}
if(empty($last_chatted)) {
    $last_chatted = 0;
    $random_chat = 'true';
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->

<head>
	<meta charset="utf-8">
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'>
    <meta name="viewport" content="width=device-width" />
    <title><?=$page['name']?></title>
    <link rel="shortcut icon" type="image/png" href="<?=$system->getDomain()?>/img/favicon.png">
    <!-- Plugins -->
    <link href="<?=$system->getDomain()?>/assets/bootstrap3/css/bootstrap.css" rel="stylesheet">
    <link href="<?=$system->getDomain()?>/assets/css/bxslider.css" rel="stylesheet">
    <link href="<?=$system->getDomain()?>/assets/css/lightslider.min.css" rel="stylesheet">
    <link href="<?=$system->getDomain()?>/assets/css/jquery.gritter.css" rel="stylesheet">
    <link href="<?=$system->getDomain()?>/assets/css/plugins.css" rel="stylesheet">
    <link href="<?=$system->getDomain()?>/assets/css/autocomplete.css" rel="stylesheet">
    <link href="<?=$system->getDomain()?>/assets/css/jquery.mCustomScrollbar.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700" rel="stylesheet">
    <!-- Main CSS -->
    <?php 
    if($settings->winter_theme == 0) {
    echo '<link href="'.$system->getDomain().'/assets/css/theme.css" rel="stylesheet">';
    echo '<link href="'.$system->getDomain().'/assets/css/style.css" rel="stylesheet">';
    } else { 
    echo '<link href="'.$system->getDomain().'/assets/css/winter/theme.css" rel="stylesheet">';
    echo '<link href="'.$system->getDomain().'/assets/css/winter/style.css" rel="stylesheet">';
    }
    ?>
    <!--  Fonts and icons     -->
    <link href="<?=$system->getDomain()?>/assets/css/icomoon.css" rel="stylesheet" type="text/css" />
    <link href="<?=$system->getDomain()?>/assets/css/themify-icons.css" rel="stylesheet" type="text/css" />
    <?=$page['css']?>
    <script>
    var base = '<?=$system->getDomain()?>';
    var showControls = <?php if(empty($photos)) { echo 'false'; } else { echo 'true'; } ?>;
    var last_chatted = <?=$last_chatted?>;
    var random_chat = '<?=$random_chat?>';
    </script>
</head>
<body>
    <nav class="navbar navbar-ct-danger" role="navigation-demo">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#"><img src="<?=$system->getDomain()?>/img/logo-small.png"></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="navigation-example-2">
      <ul class="nav navbar-nav">
        <li>
            <a href="<?=$system->getDomain()?>/encounters">
                <?=$lang['Encounters']?>
            </a>
        </li>
        <li>
            <a href="<?=$system->getDomain()?>/people">
                <?=$lang['People']?>
            </a>
        </li>
        <li>
            <a href="#" data-toggle="modal" data-target="#messages" style="outline:none;">
                <?=$lang['Messages']?>
            </a>
        </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
        <li>
            <a href="<?=$system->getDomain()?>/vip" class="btn btn-icon btn-sm btn-warning btn-fill">
                <i class="ti-crown" style="padding-right:3px;"></i>
                VIP
            </a>
        </li>
        <li>
            <a href="<?=$system->getDomain()?>/credits" class="btn btn-icon btn-sm btn-default btn-fill">
                <i class="ti-server" style="padding-right:3px;"></i>
                <?=$lang['Credits']?>
            </a>
        </li>
        <li class="dropdown">
            <a class="btn btn-sm btn-danger btn-fill notification-count" data-toggle="dropdown">
                <?=$ucount?>
            </a>

            <ul class="dropdown-menu dropdown-menu-right dropdown-wide dropdown-notification">
                <li class="dropdown-header">
                    <?=$lang['Notifications']?>
                </li>
                <li>
                    <ul class="dropdown-notification-list scroll-area notification-list">
                    </ul>
                </li>
                <li class="dropdown-footer">
                    <ul class="dropdown-footer-menu">
                        <li>
                            <a href="#" onclick="readNotifications(); return false;">Mark all as read</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="#" class="profile-photo dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <div class="profile-photo-small">
                    <img src="<?=$system->getProfilePicture($user)?>" class="img-circle img-responsive img-no-padding">
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-right">
                <li><a href="<?=$system->getDomain()?>/user/<?=$user->id?>">Me</a></li>
                <li><a href="<?=$system->getDomain()?>/likes"><?=$lang['Profile_Likes']?></a></li>
                <li><a href="<?=$system->getDomain()?>/visitors"><?=$lang['Profile_Visitors']?></a></li>
                <li><a href="<?=$system->getDomain()?>/settings"><?=$lang['Settings']?></a></li>
                <?php 
                if($user->is_admin == 1) {
                    echo '<li class="divider"></li>';
                    echo '<li><a href="'.$system->getDomain().'/admin">'.$lang['Admin'].'</a></li>';
                    echo '<li class="divider"></li>';
                } 
                ?>
                <li class="divider"></li>
                <li><a href="<?=$system->getDomain()?>/logout.php"><?=$lang['Logout']?></a></li>
            </ul>
        </li>
    </ul>
</div><!-- /.navbar-collapse -->
</div><!-- /.container-->
</nav>
<div class="container-fluid no-padding">
    <div class="spotlight-container well">
        <div class="spotlight-inner">
            <ul class="spotlight"></ul>
    </div>
</div>
</div>