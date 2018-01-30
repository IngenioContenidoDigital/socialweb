<div class="wrapper">
<div class="section">
<div class="container">
<?php
if($people->num_rows >= 1) {
$profile = $people->fetch_object();
$media = $system->getUserPhotos($profile->id,9);
$system->updateLastEncounter($user->id, $profile->id);
$score = $system->getScore($profile->id);
?>
<div class="col-lg-12 col-md-12 col-sm-12">
<div class="encounter">
<div class="row">
		<div class="well well-encounter bg-white overflow-auto mb-0">
			<div class="encounter-controls pull-left">
				<div id="heart-<?=$profile->id?>" onclick="likeProfile(<?=$profile->id?>,true)" class="pull-left">
					<?php
					$check = $db->query("SELECT id FROM profile_likes WHERE viewer_id='".$user->id."' AND profile_id='".$profile->id."' LIMIT 1"); ?>
					<?php if($check->num_rows == 0) {
					echo '<button class="btn btn-circle btn-danger btn-stroke btn-lg mr-5"><i class="icon icon-heart"></i></button>';
					} else {
					echo '<button class="btn btn-circle btn-danger btn-lg mr-5"><i class="icon icon-heart"></i></button>';
					}
					?>
				</div>
				<div id="times-<?=$profile->id?>" onclick="dislikeProfile(<?=$profile->id?>,true)" class="pull-left">
					<?php
					$check = $db->query("SELECT id FROM profile_dislikes WHERE viewer_id='".$user->id."' AND profile_id='".$profile->id."' LIMIT 1"); ?>
					<?php if($check->num_rows == 0) {
					echo '<button class="btn btn-circle btn-default btn-stroke btn-lg mr-5"><i class="ti-close"></i></button>';
					} else {
					echo '<button class="btn btn-circle btn-default btn-lg mr-5"><i class="ti-close"></i></button>';
					}
					?>
				</div>
			</div>
			<div class="encounter-info pull-left">
				<h4 class="encounters-name">
					<?php if($system->isOnline($profile->last_active)) { echo '<i class="online-status online"></i>'; } else { echo '<i class="online-status offline"></i>'; } ?>
					<a href="<?=$system->getDomain()?>/user/<?=$profile->id?>">
						<span> <?=$system->getFirstName($profile->full_name)?>, <?=$profile->age?> </span>
					</a>
				</h4>
				<?php $system->getUserBadges($profile); ?>
			</div>
			<br>
		</div>
</div>
<div class="row">
		<div class="well overflow-auto mb-0 text-center" style="background-color:#4D4D4D;margin-bottom:0px !important;margin-top:0px !important;">
			<ul id="encounterGallery">
				<?php
				if($media->num_rows >= 1) {
					while($photo = $media->fetch_object()) {
						echo '
						<li data-thumb="'.$system->getDomain().'/uploads/'.$photo->path.'" data-src="'.$system->getDomain().'/uploads/'.$photo->path.'">
						<img src="'.$system->getDomain().'/uploads/'.$photo->path.'">
						</li>
						';
					}
				} else {
					echo '
					<li data-thumb="'.$system->getProfilePicture($profile).'" data-src="'.$system->getProfilePicture($profile).'">
					<img src="'.$system->getProfilePicture($profile).'">
					</li>
					';
				}
				?>
			</ul>
		</div>
	</div>
	<?php
	}
	if($no_encounters == true) {
		$system->getPageError('encounters');
	}
	?>
</div>
</div>
</div>
</div>
</div>

<!-- Send Gift Modal -->
<div class="modal fade" id="send-gift" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<form action="<?=$system->getDomain?>/send-gift.php" method="post">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title"><?=$lang['Send_Gift']?></h4>
</div>
<div class="modal-body overflow-auto">
	<div class="pull-left" style="margin-bottom:10px;font-weight:500;"> Regular </div>
	<div class="pull-right" style="margin-bottom:10px;"> <small class="text-muted"> <?=sprintf($lang['Service_Cost'],$settings->gift_price)?> </small> </div>
	<div class="clearfix"></div>
	<div class="gift-selection">
		<img src="<?=$system->getDomain()?>/img/gifts/1.png" id="gift1" class="gift-image img-responsive pull-left" onclick="selectGift(1)">
		<img src="<?=$system->getDomain()?>/img/gifts/2.png" id="gift2" class="gift-image img-responsive pull-left" onclick="selectGift(2)">
		<img src="<?=$system->getDomain()?>/img/gifts/3.png" id="gift3" class="gift-image img-responsive pull-left" onclick="selectGift(3)">
		<img src="<?=$system->getDomain()?>/img/gifts/4.png" id="gift4" class="gift-image img-responsive pull-left" onclick="selectGift(4)">
		<img src="<?=$system->getDomain()?>/img/gifts/5.png" id="gift5" class="gift-image img-responsive pull-left" onclick="selectGift(5)">
		<img src="<?=$system->getDomain()?>/img/gifts/6.png" id="gift6" class="gift-image img-responsive pull-left" onclick="selectGift(6)">
		<img src="<?=$system->getDomain()?>/img/gifts/7.png" id="gift7" class="gift-image img-responsive pull-left" onclick="selectGift(7)">
		<img src="<?=$system->getDomain()?>/img/gifts/8.png" id="gift8" class="gift-image img-responsive pull-left" onclick="selectGift(8)">
		<img src="<?=$system->getDomain()?>/img/gifts/9.png" id="gift9" class="gift-image img-responsive pull-left" onclick="selectGift(9)">
		<img src="<?=$system->getDomain()?>/img/gifts/10.png" id="gift10" class="gift-image img-responsive pull-left" onclick="selectGift(10)">
		<img src="<?=$system->getDomain()?>/img/gifts/11.png" id="gift11" class="gift-image img-responsive pull-left" onclick="selectGift(11)">
		<img src="<?=$system->getDomain()?>/img/gifts/12.png" id="gift12" class="gift-image img-responsive pull-left" onclick="selectGift(12)">
		<img src="<?=$system->getDomain()?>/img/gifts/13.png" id="gift13" class="gift-image img-responsive pull-left" onclick="selectGift(13)">
		<img src="<?=$system->getDomain()?>/img/gifts/14.png" id="gift14" class="gift-image img-responsive pull-left" onclick="selectGift(14)">
		<img src="<?=$system->getDomain()?>/img/gifts/15.png" id="gift15" class="gift-image img-responsive pull-left" onclick="selectGift(15)">
		<img src="<?=$system->getDomain()?>/img/gifts/16.png" id="gift16" class="gift-image img-responsive pull-left" onclick="selectGift(16)">
		<img src="<?=$system->getDomain()?>/img/gifts/17.png" id="gift17" class="gift-image img-responsive pull-left" onclick="selectGift(17)">
		<img src="<?=$system->getDomain()?>/img/gifts/18.png" id="gift18" class="gift-image img-responsive pull-left" onclick="selectGift(18)">
		<img src="<?=$system->getDomain()?>/img/gifts/19.png" id="gift19" class="gift-image img-responsive pull-left" onclick="selectGift(19)">
		<img src="<?=$system->getDomain()?>/img/gifts/20.png" id="gift20" class="gift-image img-responsive pull-left" onclick="selectGift(20)">
		<img src="<?=$system->getDomain()?>/img/gifts/21.png" id="gift21" class="gift-image img-responsive pull-left" onclick="selectGift(21)">
		<img src="<?=$system->getDomain()?>/img/gifts/22.png" id="gift22" class="gift-image img-responsive pull-left" onclick="selectGift(22)">
		<img src="<?=$system->getDomain()?>/img/gifts/23.png" id="gift23" class="gift-image img-responsive pull-left" onclick="selectGift(23)">
		<img src="<?=$system->getDomain()?>/img/gifts/24.png" id="gift24" class="gift-image img-responsive pull-left" onclick="selectGift(24)">
		<img src="<?=$system->getDomain()?>/img/gifts/25.png" id="gift25" class="gift-image img-responsive pull-left" onclick="selectGift(25)">
		<img src="<?=$system->getDomain()?>/img/gifts/26.png" id="gift26" class="gift-image img-responsive pull-left" onclick="selectGift(26)">
	</div>
</div>
<div class="modal-footer">
	<div class="left-side">
		<button type="button" class="btn btn-default btn-simple" data-dismiss="modal"><?=$lang['Close']?></button>
	</div>
	<div class="divider"></div>
	<div class="right-side">
		<button type="submit" name="send_gift" class="btn btn-danger btn-simple" <?=$send_gift?>><?=$lang['Continue']?></button>
	</div>
</div>
</div>
<input type="hidden" name="giftValue" id="giftValue">
<input type="hidden" name="profile_id" value="<?=$profile->id?>">
</form>
</div>
</div>

<!-- Filter Results Modal -->
<div class="modal fade" id="filter-results" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<form action="" method="post">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title"><?=$lang['Filter_Results']?></h4>
</div>
<div class="modal-body">
	<div class="form-group">
		<label><?=$lang['Gender']?></label>
		<select name="sexual_preference" class="selectpicker" data-style="no-style form-control" data-menu-style="">
			<option value="3" <?php if($filter->sexual_preference == 3) { echo 'selected'; } ?>> <?=$lang['All_Genders']?> </option>
			<option value="1" <?php if($filter->sexual_preference == 1) { echo 'selected'; } ?>> <?=$lang['Male']?> </option>
			<option value="2" <?php if($filter->sexual_preference == 2) { echo 'selected'; } ?>> <?=$lang['Female']?> </option>
		</select>
	</div>
	<div class="form-group">
		<label><?=$lang['Sexual_Orientation']?></label>
		<select name="sexual_orientation" class="selectpicker" data-style="no-style form-control" data-menu-style="">
			<option value="1" <?php if($filter->sexual_orientation == 1) { echo 'selected'; } ?>> <?=$lang['Straight']?> </option>
			<option value="2" <?php if($filter->sexual_orientation == 2) { echo 'selected'; } ?>> <?=$lang['Gay']?> </option>
			<option value="3" <?php if($filter->sexual_orientation == 3) { echo 'selected'; } ?>> <?=$lang['Lesbian']?> </option>
			<option value="4" <?php if($filter->sexual_orientation == 4) { echo 'selected'; } ?>> <?=$lang['Bisexual']?> </option>
		</select>
	</div>
	<div class="form-group">
		<label><?=$lang['Country']?></label>
		<select name="country" class="selectpicker" data-style="no-style form-control" data-menu-style="">
			<option value="<?=$filter->country?>" selected><?=$lang['Current']?>: <?=$filter->country?></option>
			<?php $system->getCountriesSelect(); ?>
		</select>
	</div>
	<div class="form-group">
		<label><?=$lang['Order_By']?></label>
		<select name="order_by" class="selectpicker" data-style="no-style form-control" data-menu-style="">
			<option value="1" <?php if($filter->order_by == 1) { echo 'selected'; } ?>> <?=$lang['Newest']?> </option>
			<option value="2" <?php if($filter->order_by == 2) { echo 'selected'; } ?>> <?=$lang['Oldest']?> </option>
			<option value="3" <?php if($filter->order_by == 3) { echo 'selected'; } ?>> <?=$lang['Last_Online']?> </option>
			<option value="4" <?php if($filter->order_by == 4) { echo 'selected'; } ?>> <?=$lang['Random']?> </option>
		</select>
	</div>
	<div class="form-group">
		<label><?=$lang['Age']?> (<span id="age-info"><?=$_age_range[0].' - '.$_age_range[1].' years'?></span>) </label>
		<br>
		<div id="age-range" class="slider-default"></div>
		<input type="hidden" id="age_range_val" name="age_range">
	</div>
	<div class="form-group">
		<label><?=$lang['Location_Dating']?></label>
		<br>
		<div class="checkbox" for="checkbox1">
			<?php if($filter->location_dating == 1) { ?>
			<input name="location_dating" type="checkbox" value="" data-toggle="checkbox" class="checkbox1" checked>
			<? } else { ?>
			<input name="location_dating" type="checkbox" value="" data-toggle="checkbox" class="checkbox1">
			<? } ?>
		</div>
		<p class="ml-30"><?=$lang['Location_Dating_Description']?></p>
	</div>
	<br>
	<div class="form-group mt-5">
		<labelz><?=$lang['Distance']?> (<span id="distance-info"><?=$distance_range[0].' - '.$distance_range[1].' km'?></span>) </label>
		<br>
		<div id="distance-range" class="slider-default"></div>
		<input type="hidden" id="distance_range_val" name="distance_range">
	</div>
</div>
<div class="modal-footer">
	<div class="left-side">
		<button type="button" class="btn btn-default btn-simple" data-dismiss="modal"><?=$lang['Close']?></button>
	</div>
	<div class="divider"></div>
	<div class="right-side">
		<button type="submit" name="filter" class="btn btn-danger btn-simple"><?=$lang['Filter']?></button>
	</div>
</div>
</div>
</form>
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
