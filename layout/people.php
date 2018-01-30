<div class="wrapper">
<div class="section" style="padding:0px;">
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<h3 style="margin-bottom:25px;">
				<span class="page-title"> <?=$lang['People']?> </span>
				<?php 
				if($settings->winter_theme == 0) {
				echo '<a href="#" data-toggle="modal" data-target="#filter-results" class="btn btn-default pull-right"> <i class="icon icon-equalizer"></i> '.$lang['Filter'].' </a>';
				} else {
				echo '<a href="#" data-toggle="modal" data-target="#filter-results" class="btn btn-neutral pull-right"> <i class="icon icon-equalizer"></i> '.$lang['Filter'].' </a>';
				}
				?>
			</h3>
			<div class="clearfix"></div>
			<?php
			if($people->num_rows >= 1) {
				while($person = $people->fetch_object()) {
					echo '
					<div class="col-lg-3 col-md-3 col-sm-4">
						<div class="card card-user">
							<div class="content">
								<div class="author">
									<a href="'.$system->getDomain().'/user/'.$person->id.'">
										<img class="avatar" src="'.$system->getProfilePicture($person).'">
										<h4 class="title">'.$system->getFirstName($person->full_name).', '.$person->age.'</h4>
									</a>
								</div>
								<p class="text-center text-muted">
									';
									echo $person->city.$system->ifComma($person->city); echo ' '.$person->country.'
								</p>
							</div>
						</div>
					</div>
					';
				}
			} else {
				$system->getPageError('people');
			}
			?>
			<div class="col-lg-12 col-md-12 col-sm-12">
			<ul class="pagination pagination-lg">
			<?php
			if(($last_page >= $p) && $last_page > 1) {
				for($i=1; $i<=$last_page; $i++) {
					if($i == $p) {
						echo '<li class="active"> <a href="'.$system->getDomain().'/people/'.$i.'"> '.$i.' </a> </li>';
					} else {
						echo '<li> <a href="'.$system->getDomain().'/people/'.$i.'"> '.$i.' </a> </li>';
					}
				}
			}
			?>
			</ul>
			</div>
		</div>
	</div>
</div>
</div>
</div>
<!--/ End body content -->

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
				<label><?=$lang['Distance']?> (<span id="distance-info"><?=$distance_range[0].' - '.$distance_range[1].' km'?></span>) </label>
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
