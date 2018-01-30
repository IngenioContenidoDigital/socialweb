<div class="wrapper">
	<div class="container" style="padding-bottom:100px;">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2" style="padding-top:70px;">
				<div class="well bg-white text-center well-round" style="padding:50px;">
					<img src="<?=$system->getDomain()?>/img/icons/verified.png" style="height:100px;width:100px;">
					<br><br>
					<p style="padding:20px;padding-top:15px;"> <?=sprintf($lang['Verify_Email_Help'],$user->email)?> </p>
					<form action="" method="post">
					<button type="submit" name="resend" class="btn btn-danger"> <?=$lang["Resend_Email"]?> </a>
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
