<?php
define('IS_AJAX', true);
session_set_cookie_params(172800);
session_start();
require('../core/config.php');
require('../core/auth.php');
require('../core/system.php');
$auth = new Auth;
$system = new System;

$system->domain = $domain;
$system->db = $db;

$menu['dashboard'] = 'active';
$page['name'] = 'Dashboard';

$user = $system->getUserInfo($_SESSION['user_id']);
$system->setUserActive($user->id);

if(!$auth->isLogged() || $user->is_admin != 1) {
	header('Location: index.php');
	exit;
}

$user_count = $db->query("SELECT id FROM users");
$user_count = $user_count->num_rows;

$photo_count = $db->query("SELECT id FROM uploaded_photos");
$photo_count = $photo_count->num_rows;

$online_users = "SELECT * FROM users WHERE (".time()." - last_active) <= 300";
$online_users_count = $db->query($online_users)->num_rows;
$online_users = $db->query($online_users.' LIMIT 12');

$newest_users = $db->query("SELECT * FROM users ORDER BY id DESC LIMIT 12");

$quotes = array();
$quotes[] = array('author' => 'Winston Churchil', 'quote' => 'Success is not final, failure is not fatal: it is the courage to continue that counts');
$quotes[] = array('author' => 'Napoleon Hill', 'quote' => 'The starting point of all achievement is desire');
$quotes[] = array('author' => 'Pablo Picasso', 'quote' => 'Action is the foundational key to all success');
$quotes[] = array('author' => 'Steve Jobs', 'quote' => 'Sometimes life hits you in the head with a brick. Don\'t lose faith');
$quotes[] = array('author' => 'Steve Jobs', 'quote' => 'Stay hungry, stay foolish');
$quotes[] = array('author' => 'Buddha', 'quote' => 'What we think, we become');
$quotes[] = array('author' => 'Ernest Hemingway', 'quote' => 'But man is not made for defeat. A man can be destroyed but not defeated.');
shuffle($quotes);
$quote = $quotes[0];

require('../inc/admin/top.php');
require('../layout/admin/dashboard.php');
require('../inc/admin/bottom.php');