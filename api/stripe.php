<?php
define('IS_AJAX', true);
session_set_cookie_params(172800);
session_start();
require('../core/config.php');
require('../core/system.php');
require('../core/stripe/init.php');
$system = new System;

$system->domain = $domain;
$system->db = $db;

$user = $system->getUserInfo($_SESSION['user_id']);

$settings = $system->getSettings();

if(isset($_GET['t'])) {

	$stripe_token = $_GET['t'];

	\Stripe\Stripe::setApiKey($settings->stripe_secret_key);

	if(isset($_GET['type'])) {

		$type = $_GET['type'];

		if($type == 'vip') {
			// VIP Account
			switch ($_GET['duration']) {
				case 1:
				$duration = 2629743;
				$price = $settings->vip_1_month;
				break;
				case 2:
				$duration = 7889229;
				$price = $settings->vip_3_months;
				break;
				case 3:
				$duration = 15778458;
				$price = $settings->vip_6_months;
				break;
				default:
				$duration = 0;
				$price = 0;
				break;
			}

			try {

				$charge = \Stripe\Charge::create(array(
					"amount" => $price*100, 
					"currency" => strtolower($settings->currency),
					"source" => $stripe_token,
					"description" => 'MatchMe VIP Account')
				);

				$start = time();
				$expiration = time()+$duration;
				$db->query('UPDATE users SET is_vip=1 WHERE id='.$user->id.'');
				$db->query('UPDATE users SET vip_expiration='.$expiration.' WHERE id='.$user->id.'');
				$db->query("UPDATE users SET ghost_mode_start=".$start." WHERE id=".$user->id."");
				$db->query('UPDATE users SET ghost_mode_expiration='.$expiration.' WHERE id='.$user->id.'');
				$db->query("UPDATE users SET verified_badge_start=".$start." WHERE id=".$user->id."");
				$db->query('UPDATE users SET verified_badge_expiration='.$expiration.' WHERE id='.$user->id.'');
				$db->query("UPDATE users SET spotlight_start=".$start." WHERE id=".$user->id."");
				$db->query('UPDATE users SET spotlight_expiration='.$expiration.' WHERE id='.$user->id.'');
				$db->query("UPDATE users SET disable_ads_start=".$start." WHERE id=".$user->id."");
				$db->query('UPDATE users SET disable_ads_expiration='.$expiration.' WHERE id='.$user->id.'');

				echo '<div class="alert alert-success"><i class="ti-check"></i> Payment Successful</div>';

			} catch(\Stripe\Error\Card $e) {

				echo '<div class="alert alert-danger"><i class="ti-close"></i> Payment Failed</div>';

			}
		} elseif($type == 'credits') {
			// Credits
			switch ($_GET['amount']) {
				case 100:
				$price = $settings->credits_price_100;
				break;
				case 500:
				$price = $settings->credits_price_500;
				break;
				case 1000:
				$price = $settings->credits_price_1000;
				break;
				case 1500:
				$price = $settings->credits_price_1500;
				break;
				default:
				$price = 0;
				break;
			}

			try {

				$charge = \Stripe\Charge::create(array(
					"amount" => $price*100, 
					"currency" => strtolower($settings->currency),
					"source" => $stripe_token,
					"description" => 'MatchMe Credits')
				);

				$db->query('UPDATE users SET credits=credits+'.$_GET['amount'].' WHERE id='.$user->id.'');

				echo '<div class="alert alert-success"><i class="ti-check"></i> Payment Successful</div>';

			} catch(\Stripe\Error\Card $e) {

				echo '<div class="alert alert-danger"><i class="ti-close"></i> Payment Failed</div>';

			}
		}
	}
}


