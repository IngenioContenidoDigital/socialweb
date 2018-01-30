<div class="wrapper">
	<div class="section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="vip-page-heading"><div class="credits-page-counter btn-tooltip" data-toggle="tooltip" data-placement="bottom" title="<?=$lang["Credit_Balance"]?>"><i class="ti-server"></i> <?=number_format($user->credits)?></div></div>
					<div class="well bg-white vip-page-body overflow-auto">

						<div class="credits-page-center">
							<h4><?=sprintf($lang['Meet_More_People'],$site_name)?></h4>
							<a href="#" data-toggle="modal" data-target="#buy-credits" class="btn btn-danger"> <?=$lang["Buy_Credits"]?> </a>
						</div>
						<div class="credits-features">
							<form action="" method="post">
							<div class="credit-feature-1">
								<img src="<?=$system->getProfilePicture($user)?>" class="img-thumbnail">
								<?php
								if($user->is_increased_exposure == 0) {
								if($user->credits <= $settings->feature_price) {
									echo '<a href="#" data-toggle="modal" data-target="#buy-credits" class="btn btn-default btn-sm btn-block"> '.$lang['Get_Featured'].' </a>';
								} else {
									echo '<button type="submit" name="add_spotlight" class="btn btn-default btn-sm btn-block"> '.$lang['Get_Featured'].' </button>';
								}
								} else {
									echo '<span class="btn-tooltip" data-toggle="tooltip" data-placement="bottom" title="'.$lang['Already_Featured'].'">';
									echo '<a href="#" data-toggle="modal" data-target="#buy-credits" class="btn btn-default btn-sm btn-block disabled"> '.$lang['Get_Featured'].' </a>';
									echo '</span>';
								}
								?>
								<p><?=$lang["VIP_Feature_2"]?><p>
								</div>
								<div class="credit-feature-2">
								<img src="<?=$system->getDomain()?>/img/gift-user.png" class="img-thumbnail">
								<?php
								if($user->credits <= $settings->gift_price) {
									echo '<a href="#" class="btn btn-default btn-sm btn-block" data-toggle="modal" data-target="#buy-credits"> '.$lang['Credit_Feature_2_Btn'].' </a>';
								} else {
									echo '<a href="'.$system->getDomain().'/encounters" class="btn btn-default btn-sm btn-block"> '.$lang['Credit_Feature_2_Btn'].' </a>';
								}
								?>
								<p><?=$lang['Credit_Feature_2']?><p>
							</div>
							<div class="credit-feature-3">
								<img src="<?=$system->getDomain()?>/img/sticker.png" class="img-thumbnail">
								<a href="#" class="btn btn-default btn-sm btn-block"> <?=$lang['Credit_Feature_3_Btn']?> </a>
								<p><?=$lang['Credit_Feature_3']?><p>
							</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Buy Credits Modal -->
	<div class="modal fade" id="buy-credits" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-important">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title"><?=$lang['Buy_Credits']?></h4>
				</div>
				<div class="modal-body no-padding">
					<form action="" method="post">
						<script src="https://checkout.stripe.com/checkout.js"></script>
						<div class="payment-gateways">
							<div id="payment-result"></div>
							<?php if(!empty($settings->paypal_email)) { ?>
							<div class="payment-gateway-select">
								<input type="radio" name="payment_gateway[]" value="1" onclick="selectGateway(1)" checked>
								<img src="<?=$system->getDomain()?>/img/paypal.png">
								<?=$lang['PayPal']?>
							</div>
							<? } ?>
							<?php if(!empty($settings->stripe_secret_key) || !empty($settings->stripe_publishable_key)) { ?>
							<div class="payment-gateway-select">
								<input type="radio" name="payment_gateway[]" value="2" onclick="selectGateway(2)">
								<img src="<?=$system->getDomain()?>/img/visa.png">
								<?=$lang['Credit_Card']?>
							</div>
							<? } ?>
							<?php if(!empty($settings->fortumo_service_id)) { ?>
							<div class="payment-gateway-select">
								<input type="radio" name="payment_gateway[]" onclick="selectGateway(3)">
								<img src="<?=$system->getDomain()?>/img/smartphone.png">
								<?=$lang['Mobile']?>
							</div>
							<? } ?>
						</div>
						<div class="clearfix"></div>
						<span class="package-select-area">
						<hr class="divider">
						<div class="package-select">
							<p class="text-muted"> <?=$lang['Choose_Amount']?> </p>
							<div class="clearfix"></div>
							<span class="vip-duration">
								<select name="amount" id="credit_amount" class="selectpicker" data-style="no-style form-control" data-menu-style="">
								<option value="100" selected> 100 - <?=$settings->credits_price_100?> <?=$settings->currency?> </option>
								<option value="500"> 500 - <?=$settings->credits_price_500?> <?=$settings->currency?> </option>
								<option value="1000"> 1000 - <?=$settings->credits_price_1000?> <?=$settings->currency?>  </option>
								<option value="1500"> 1500 - <?=$settings->credits_price_1500?> <?=$settings->currency?> </option>
								</select>
							</span>
						</div>
						</span>
						<hr class="divider">
						<div class="payment-button-area">
							<button type="submit" id="stripe_pay" name="pay" class="btn btn-danger payment-btn"> <i class="ti-lock"></i> <?=$lang['Pay_Securely']?> </button>
							<span class="mobile-payment-btn" style="display:none;"> <a href="#" id="fmp-button" name="pay" class="btn btn-danger" rel="<?=$settings->fortumo_service_id?>/<?=$user->id?>"> <i class="ti-lock"></i> <?=$lang["Pay_Securely"]?> </a> </span>
						</div>
						<input type="hidden" id="credit_amount" name="credit_amount" value="100">
						<input type="hidden" id="payment_gateway" name="payment_gateway" value="1">
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Messages Modal -->
<div class="modal fade" id="messages" tabindex="-1" role="dialog">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content chat-modal">
<div class="modal-body-xl no-padding" style="overflow:hidden;">
<div class="chat-container">
	<div class="chat-left pull-left">
		<div class="chat-sidebar-top">
			&nbsp
		</div>
		<div class="chats-list"></div>
	</div>
	<div class="chat-area pull-left">
		<div class="chat-top-right"></div>
		<div class="chat-content-wrap">
			<div class="chat-content"></div>
		</div>
		<div class="emoji-menu" style="display:none;">
			<div class="emoji-top">
				<span class="emoji-top-link emj" onclick="loadEmojis(); setActiveEmojiLink('.emoji-top-link');">
					<i class="ti-face-smile"></i>
				</span>
				<span class="emoji-sticker-packs">
				</span>
			</div>
			<div class="emoji-content-wrap">
				<div class="emoji-content"></div>
			</div>
		</div>
		<div class="gift-menu" style="display:none;">
			<div class="gift-content-wrap">
				<div class="gift-content"></div>
			</div>
		</div>
		<div class="chat-bottom">
			<div class="chat-addons">
                <a href="#" onclick="toggleEmojiMenu(); return false;"> <i class="ti-face-smile emoji-toggle"></i></a>
                <a href="#" onclick="toggleChatGifts(); return false;"> <i class="ti-gift"></i></a>
			</div>
			<div class="chat-input">
				<input type="text" id="message" name="message" class="form-control input-sm">
				<a href="#" class="btn btn-default btn-icon btn-sm btn-fill chat-message-send" onclick="sendMessage()"> <i class="ti-angle-right"></i> </a>
			</div>
		</div>
	</div>
</div>
</div>
</div>
</div>
</div>

<!-- Send Gift Modal -->
<div class="modal fade" id="chat-send-gift" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<form action="<?=$system->getDomain?>/send-gift.php" method="post">
<div class="modal-content">
<div class="modal-body text-center gift-modal-container">
</div>
</div>
</form>
</div>
</div>

<input type="hidden" id="profile_id" value="<?=$profile->id?>">
<input type="hidden" id="receiver_id">
<input type="hidden" id="gift_id">
