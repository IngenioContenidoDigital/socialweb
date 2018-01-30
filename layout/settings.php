<div class="wrapper">
	<div class="section">
		<div class="container">

			<div class="row">
				<div class="col-lg-12">

					<div class="panel bg-white">
						<div class="panel-body" style="padding:10px;">
							<div class="col-md-5 pull-left">
								<h3>
									<span style="font-size:22px;" class="font600"><?=$lang['Profile_Tab_Title']?></span>
								</h3>
								<hr class="mt-0">
								<form action="" method="post">
									<div class="form-group">
										<label><?=$lang['Full_Name']?></label>
										<input type="text" name="full_name" value="<?=$user->full_name?>" class="form-control" required>
									</div>
									<div class="form-group">
										<label><?=$lang['Gender']?></label>
										<select name="gender" class="selectpicker" data-style="no-style form-control" data-menu-style="" required>
											<?php
											if($user->gender == 'Male') {
												echo '<option value="Male" selected> '.$lang['Male'].' </option>';
												echo '<option value="Female"> '.$lang['Female'].' </option>';
											} else {
												echo '<option value="Female" selected> '.$lang['Female'].' </option>';
												echo '<option value="Male"> '.$lang['Male'].' </option>';
											}
											?>
										</select>
									</div>
									<div class="form-group">
										<label><?=$lang['Age']?></label>
										<input type="text" name="age" value="<?=$user->age?>" class="form-control" required>
									</div>
									<div class="form-group">
										<label><?=$lang['Height']?></label>
										<div class="input-group">
											<input type="text" name="height" value="<?=$user->height?>" class="form-control" required>
											<span class="input-group-addon"><?=$unit['height']?></span>
										</div>
									</div>
									<div class="form-group">
										<label><?=$lang['Weight']?></label>
										<div class="input-group">
											<input type="text" name="weight" value="<?=$user->weight?>" class="form-control" required>
											<span class="input-group-addon"><?=$unit['weight']?></span>
										</div>
									</div>
									<div class="form-group">
										<label><?=$lang['Sexual_Orientation']?></label>
										<select name="sexual_orientation" class="selectpicker" data-style="no-style form-control" data-menu-style="" required>
											<option value="1" <?php if($user->sexual_interest == 1) { echo 'selected'; } ?>> <?=$lang['Straight']?> </option>
											<option value="2" <?php if($user->sexual_interest == 2) { echo 'selected'; } ?>> <?=$lang['Gay']?> </option>
											<option value="3" <?php if($user->sexual_interest == 3) { echo 'selected'; } ?>> <?=$lang['Lesbian']?> </option>
											<option value="4" <?php if($user->sexual_interest == 4) { echo 'selected'; } ?>> <?=$lang['Bisexual']?> </option>
										</select>
									</div>
									<div class="form-group">
										<label><?=$lang['City']?></label>
										<input type="text" name="city" value="<?=$user->city?>" class="city-autocomplete form-control" autocomplete="off" required>
									</div>
									<div class="form-group">
										<label><?=$lang['Interests']?></label>
										<input name="interests" class="tagsinput tag-default" value="<?=$user->interests?>">
										<small class="help-block text-muted">Enter your interests and press enter</small>
									</div>
									<div class="form-group">
										<label><?=$lang['Description']?></label>
										<textarea name="bio" class="form-control" required><?=$user->bio?></textarea>
									</div>
									<button type="submit" name="save_1" class="btn btn-theme"> <?=$lang['Save']?> </button>
								</form>
							</div>
							<div class="col-md-5 pull-left">
								<form action="" method="post" enctype="multipart/form-data">
									<h3>
										<span style="font-size:22px;" class="font600"><?=$lang['Account_Tab_Title']?></span>
									</h3>
									<hr class="mt-0">
									<div class="form-group">
										<label><?=$lang['Profile_Photo']?></label>
										<div class="fileinput fileinput-new input-group" data-provides="fileinput">
											<div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
											<span class="input-group-addon btn btn-inverse btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span><input type="hidden"><input type="file" name="profile_photo"></span>
											<a href="#" class="input-group-addon btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
										</div>
									</div>
									<div class="form-group">
										<label><?=$lang['Email']?></label>
										<input type="email" name="email" value="<?=$user->email?>" class="form-control" required>
									</div>
									<div class="form-group">
										<label><?=$lang['New_Password']?></label>
										<input type="password" name="new_password" class="form-control">
									</div>
									<div class="form-group">
										<label><?=$lang['Confirm_Password']?></label>
										<input type="password" name="confirm_new_password" class="form-control">
									</div>
									<div class="form-group">
										<label><?=$lang['Language']?></label>
										<select name="website_language" class="selectpicker" data-style="no-style form-control" data-menu-style="">
											<?php
											$lang_dir = scandir('languages');
											foreach($lang_dir as $file) {
												if(file_exists('languages/'.$file.'/language.php')) {
													if($user->language == $file) {
														echo '<option value="'.$file.'" selected>'.ucfirst($file).'</option>';
													} else {
														echo '<option value="'.$file.'">'.ucfirst($file).'</option>';
													}
												}
											}
											?>
										</select>
									</div>
									<div class="form-group">
										<label><?=$lang['Instagram_Username']?></label>
										<div class="input-group">
											<input type="text" name="instagram_username" value="<?=$user->instagram_username?>" class="form-control">
											<div class="input-group-btn">
												<a href="?sync" class="btn btn-default"> <i class="icon icon-loop2"></i> Sync </a>
											</div>
										</div>
										<small class="help-block text-muted"><?=$lang['Instagram_Tab_Description']?></small>
									</div>
									<button type="submit" name="save_2" class="btn btn-theme"> <?=$lang['Save']?> </button>
								</form>
							</div>

							<div class="col-md-2 pull-right">
								<img src="<?=$system->getProfilePicture($user)?>" class="img-responsive img-rounded hidden-xs hidden-sm" style="max-height:150px;max-width:150px;margin-top:108px;margin-left:10px;">
							</div>

						</div>
					</div>

				</div>
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
