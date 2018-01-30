<?php
define('IS_AJAX', true);
session_set_cookie_params(172800);
session_start();
require('../core/config.php');
require('../core/auth.php');
require('../core/system.php');

$system = new System;
$system->domain = $domain;
$system->db = $db;

echo 
'
<img src="'.$system->getDomain().'/img/gifts/1.png" id="chat-gift1" class="chat-gift-image img-responsive pull-left" onclick="selectChatGift('.$_SESSION['user_id'].',1)">
<img src="'.$system->getDomain().'/img/gifts/2.png" id="chat-gift2" class="chat-gift-image img-responsive pull-left" onclick="selectChatGift('.$_SESSION['user_id'].',2)">
<img src="'.$system->getDomain().'/img/gifts/3.png" id="chat-gift3" class="chat-gift-image img-responsive pull-left" onclick="selectChatGift('.$_SESSION['user_id'].',3)">
<img src="'.$system->getDomain().'/img/gifts/4.png" id="chat-gift4" class="chat-gift-image img-responsive pull-left" onclick="selectChatGift('.$_SESSION['user_id'].',4)">
<img src="'.$system->getDomain().'/img/gifts/5.png" id="chat-gift5" class="chat-gift-image img-responsive pull-left" onclick="selectChatGift('.$_SESSION['user_id'].',5)">
<img src="'.$system->getDomain().'/img/gifts/6.png" id="chat-gift6" class="chat-gift-image img-responsive pull-left" onclick="selectChatGift('.$_SESSION['user_id'].',6)">
<img src="'.$system->getDomain().'/img/gifts/7.png" id="chat-gift7" class="chat-gift-image img-responsive pull-left" onclick="selectChatGift('.$_SESSION['user_id'].',7)">
<img src="'.$system->getDomain().'/img/gifts/8.png" id="chat-gift8" class="chat-gift-image img-responsive pull-left" onclick="selectChatGift('.$_SESSION['user_id'].',8)">
<img src="'.$system->getDomain().'/img/gifts/9.png" id="chat-gift9" class="chat-gift-image img-responsive pull-left" onclick="selectChatGift('.$_SESSION['user_id'].',9)">
<img src="'.$system->getDomain().'/img/gifts/10.png" id="chat-gift10" class="chat-gift-image img-responsive pull-left" onclick="selectChatGift('.$_SESSION['user_id'].',10)">
<img src="'.$system->getDomain().'/img/gifts/11.png" id="chat-gift11" class="chat-gift-image img-responsive pull-left" onclick="selectChatGift('.$_SESSION['user_id'].',11)">
<img src="'.$system->getDomain().'/img/gifts/12.png" id="chat-gift12" class="chat-gift-image img-responsive pull-left" onclick="selectChatGift('.$_SESSION['user_id'].',12)">
<img src="'.$system->getDomain().'/img/gifts/13.png" id="chat-gift13" class="chat-gift-image img-responsive pull-left" onclick="selectChatGift('.$_SESSION['user_id'].',13)">
<img src="'.$system->getDomain().'/img/gifts/14.png" id="chat-gift14" class="chat-gift-image img-responsive pull-left" onclick="selectChatGift('.$_SESSION['user_id'].',14)">
<img src="'.$system->getDomain().'/img/gifts/15.png" id="chat-gift15" class="chat-gift-image img-responsive pull-left" onclick="selectChatGift('.$_SESSION['user_id'].',15)">
<img src="'.$system->getDomain().'/img/gifts/16.png" id="chat-gift16" class="chat-gift-image img-responsive pull-left" onclick="selectChatGift('.$_SESSION['user_id'].',16)">
<img src="'.$system->getDomain().'/img/gifts/17.png" id="chat-gift17" class="chat-gift-image img-responsive pull-left" onclick="selectChatGift('.$_SESSION['user_id'].',17)">
<img src="'.$system->getDomain().'/img/gifts/18.png" id="chat-gift18" class="chat-gift-image img-responsive pull-left" onclick="selectChatGift('.$_SESSION['user_id'].',18)">
<img src="'.$system->getDomain().'/img/gifts/19.png" id="chat-gift19" class="chat-gift-image img-responsive pull-left" onclick="selectChatGift('.$_SESSION['user_id'].',19)">
<img src="'.$system->getDomain().'/img/gifts/20.png" id="chat-gift20" class="chat-gift-image img-responsive pull-left" onclick="selectChatGift('.$_SESSION['user_id'].',20)">
<img src="'.$system->getDomain().'/img/gifts/21.png" id="chat-gift21" class="chat-gift-image img-responsive pull-left" onclick="selectChatGift('.$_SESSION['user_id'].',21)">
<img src="'.$system->getDomain().'/img/gifts/22.png" id="chat-gift22" class="chat-gift-image img-responsive pull-left" onclick="selectChatGift('.$_SESSION['user_id'].',22)">
<img src="'.$system->getDomain().'/img/gifts/23.png" id="chat-gift23" class="chat-gift-image img-responsive pull-left" onclick="selectChatGift('.$_SESSION['user_id'].',23)">
<img src="'.$system->getDomain().'/img/gifts/24.png" id="chat-gift24" class="chat-gift-image img-responsive pull-left" onclick="selectChatGift('.$_SESSION['user_id'].',24)">
<img src="'.$system->getDomain().'/img/gifts/25.png" id="chat-gift25" class="chat-gift-image img-responsive pull-left" onclick="selectChatGift('.$_SESSION['user_id'].',25)">
<img src="'.$system->getDomain().'/img/gifts/26.png" id="chat-gift26" class="chat-gift-image img-responsive pull-left" onclick="selectChatGift('.$_SESSION['user_id'].',26)">
';