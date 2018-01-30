<?php
define("IS_AJAX",true);
session_set_cookie_params(172800);
session_start();
require('../core/config.php');
require('../core/auth.php');
require('../core/system.php');
require('../core/geo.php');
$auth = new Auth;
$geo = new Geo;
$system = new System;

$system->domain = $domain;
$system->db = $db;

header('Location: login.php');
exit;
