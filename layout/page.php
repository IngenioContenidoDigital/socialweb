<div class="wrapper">
	<div class="section">
		<div class="container" style="padding-bottom:200px;">
			<div class="row">
				<div class="col-lg-12">
					<span class="page-title" style="font-size:25px;"> <?=$_custom_page->page_title?> </span>
					<div class="panel panel-default">
						<div class="panel-body">
							<?=nl2br($_custom_page->content)?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--/ End body content -->

</section>

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
