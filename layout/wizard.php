<div class="wrapper">
	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
				<h3 style="margin-bottom:25px;"> Welcome </h3>
				<div class="well bg-white">
					<p class="text-muted"> Help us match you with the right people </p>
					<form action="" method="post">
						<div class="form-group">
							<label style="font-size:14px;">City</label>
							<input type="text" name="city" class="city-autocomplete form-control" style="border:none;" autocomplete="off">
						</div>
						<div class="form-group">
							<label style="font-size:14px;"><?=$lang['Age']?></label>
							<br>
							<input type="text" name="age" class="form-control">
						</div>
						<div class="form-group">
							<label style="font-size:14px;"><?=$lang['Gender']?></label>
							<select name="gender" class="selectpicker" data-style="no-style form-control" data-menu-style="">
								<option value="Male"> <?=$lang['Male']?> </option>
								<option value="Female"> <?=$lang['Female']?> </option>
							</select>
						</div>
						<div class="form-group">
							<label style="font-size:14px;"><?=$lang['Sexual_Orientation']?></label>
							<select name="sexual_orientation" class="selectpicker" data-style="no-style form-control" data-menu-style="">
								<option value="1"> <?=$lang['Straight']?> </option>
								<option value="2"> <?=$lang['Gay']?> </option>
								<option value="3"> <?=$lang['Lesbian']?> </option>
								<option value="4"> <?=$lang['Bisexual']?> </option>
							</select>
						</div>
						<div class="form-group">
							<label style="font-size:14px;"><?=$lang['Height']?> <span class="text-muted"><?=$unit['height']?></span> </label>
							<br>
							<input type="text" name="height" class="form-control">
						</div>
						<div class="form-group">
							<label style="font-size:14px;"><?=$lang['Weight']?> <span class="text-muted"><?=$unit['weight']?></span></label>
							<br>
							<input type="text" name="weight" class="form-control">
						</div>
						<hr>
						<div class="overflow-auto">
							<a href="<?=$system->getDomain()?>/encounters" class="btn btn-default pull-left"> Skip </a>
							<button type="submit" name="save" class="btn btn-danger pull-right"> Save </button>
						</div>
					</form>
				</div>
				<br>
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
