<div class="wrapper">
	<div class="section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="vip-page-heading"></div>
					<div class="well bg-white vip-page-body overflow-auto">
						<img src="<?=$system->getProfilePicture($user)?>" class="img-responsive img-circle vip-page-user">
						<button class="btn btn-icon btn-sm btn-warning btn-fill vip-page-user-crown">
							<i class="ti-crown"></i>
						</button>
						<div class="vip-page-center">
							<h4><?=$lang['Activate_VIP_Account']?></h1>
								<a href="#" data-toggle="modal" data-target="#activate-vip" class="btn btn-danger"><?=$lang['Activate_Now']?></a>
							</div>
							<div class="vip-features">
							<div class="vip-feature-1">
								<img src="<?=$system->getDomain()?>/img/popular-user.png" class="img-thumbnail">
								<p><?=$lang['VIP_Feature_1']?></p>
								<button class="btn btn-icon btn-sm btn-warning btn-fill vip-page-popular-user">
								<img src="<?=$system->getDomain()?>/img/flame.png">
								</button>
							</div>
							<div class="vip-feature-2">
								<img src="<?=$system->getProfilePicture($user)?>" class="img-thumbnail">
								<p><?=$lang['VIP_Feature_2']?></p>
								<button class="btn btn-icon btn-sm btn-warning btn-fill vip-page-featured-user">
								<img src="<?=$system->getDomain()?>/img/eye.png">
								</button>
							</div>
							<div class="vip-feature-3">
								<img src="<?=$system->getDomain()?>/img/new-user.png" class="img-thumbnail">
								<p><?=$lang['VIP_Feature_3']?></p>
								<button class="btn btn-icon btn-sm btn-warning btn-fill vip-page-new-user">
								<img src="<?=$system->getDomain()?>/img/leaf.png">
								</button>
							</div>
							<div class="clearfix"></div>
							<div class="vip-secondary-features">
								<div class="vip-secondary-1">
									<img src="<?=$system->getDomain()?>/img/sticker.png">
									<p><?=$lang['VIP_Feature_4']?><p>
								</div>
								<div class="vip-secondary-2">
									<img src="<?=$system->getDomain()?>/img/ghost.png">
									<p><?=$lang['VIP_Feature_5']?><p>
								</div>
								<div class="vip-secondary-3">
									<img src="<?=$system->getDomain()?>/img/crown.png">
									<p><?=$lang['VIP_Feature_6']?><p>
								</div>
							</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<!-- Activate VIP Modal -->
<div class="modal fade" id="activate-vip" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header modal-important">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?=$lang['Activate_VIP_Account']?></h4>
			</div>
			<div class="modal-body overflow-auto no-padding">
				<form action="" method="post">
				<script src="https://checkout.stripe.com/checkout.js"></script>
				<div class="payment-gateways">
					<div id="payment-result"></div>
					<?php if(!empty($settings->paypal_email)) { ?>
					<div class="payment-gateway-select">
						<input type="radio" name="payment_gateway[]" value="1" onclick="selectGateway(1)" checked>
						<img src="<?=$system->getDomain()?>/img/paypal.png">
						<?=$lang["PayPal"]?>
					</div>
					<? } ?>
					<?php if(!empty($settings->stripe_secret_key) || !empty($settings->stripe_publishable_key)) { ?>
					<div class="payment-gateway-select">
						<input type="radio" name="payment_gateway[]" value="2" onclick="selectGateway(2)">
						<img src="<?=$system->getDomain()?>/img/visa.png">
						<?=$lang["Credit_Card"]?>
					</div>
					<? } ?>
				</div>
				<div class="clearfix"></div>
				<hr class="divider">
				<div class="package-select">
					<p class="text-muted"> <?=$lang["Choose_Duration"]?> </p>
					<div class="clearfix"></div>
					<span class="vip-duration">
						<input type="radio" name="vip_duration[]" value="1" onclick="selectDuration(1)" checked>
						<span class="duration-space"> <?=$lang["1_Month"]?> </span>
						<span class="duration-space"> <?=$settings->vip_1_month?> <?=strtoupper($settings->currency)?> </span>
					</span>
					<span class="vip-duration">
						<input type="radio" name="vip_duration[]" value="2" onclick="selectDuration(2)">
						<span class="duration-space"> <?=$lang["3_Month"]?> </span>
						<span class="duration-space"> <?=$settings->vip_3_months?> <?=strtoupper($settings->currency)?> </span>
					</span>
					<span class="vip-duration">
						<input type="radio" name="vip_duration[]" value="3" onclick="selectDuration(3)">
						<span class="duration-space"> <?=$lang["6_Month"]?> </span>
						<span class="duration-space"> <?=$settings->vip_6_months?> <?=strtoupper($settings->currency)?> </span>
					</span>
				</div>
				<hr class="divider">
				<div class="payment-button-area">
				<button type="submit" id="stripe_pay" name="pay" class="btn btn-danger payment-btn"> <i class="ti-lock"></i> <?=$lang["Pay_Securely"]?> </button>
				</div>
				<input type="hidden" id="vip_duration" name="vip_duration" value="1">
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
