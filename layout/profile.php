<div class="wrapper">
  <div class="section">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12" style="margin-left:16.8px!important;width:97.4%;">
          <div class="well well-encounter bg-white overflow-auto mb-0">
            <a href="<?=$system->getDomain()?>/user/<?=$profile->id?>" class="pull-left">
              <img src="<?=$system->getProfilePicture($profile)?>" class="img-circle pull-left mr-15" style="height:75px;width:75px;">
            </a>
            <div class="profile-info pull-left">
              <h4 class="encounters-name">
                <?php if($system->isOnline($profile->last_active)) { echo '<i class="online-status online"></i>'; } else { echo '<i class="online-status offline"></i>'; } ?>
                <span> <?=$system->getFirstName($profile->full_name)?>, <?=$profile->age?> </span>
              </h4>
              <?php $system->getUserBadges($profile); ?>
            </div>
            <?php if($profile->id != $user->id) { ?>
            <div class="profile-controls pull-right">
              <a href="#" class="btn btn-default btn-icon profile-control" onclick="messageUser(<?=$profile->id?>); return false;">
                <i class="icon icon-bubble"></i> <span><?=$lang['Chat_Now']?></span>
              <a href="#" class="btn btn-default btn-icon profile-control" data-toggle="modal" data-target="#send-gift">
                <i class="icon icon-gift"></i>
              </a>
            </div>
            <? } ?>
            <br>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12" style="margin-left:30px!important;background-color:#4D4D4D;width:95%;padding:0px;">
          <?php
          if(!empty($photos)) {
            echo '<ul class="profile-gallery" itemscope itemtype="http://schema.org/ImageGallery">';
            if($profile->id == $user->id) {
              $self = true;
              $start = -1;
            } else {
              $self = false;
              $start = 0;
            }
            for($i = $start; $i < count($photos); $i++) {
              if($i == $start && $self == true) {
                echo '
                <li>
                <a href="#" data-toggle="modal" data-target="#photo-upload">
                <img src="'.$system->getDomain().'/img/blank-photo-add.png" style="height:150px;width:150px;">
                </a>
                </li>
                ';
              } else {
                echo '
                <li>
                <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject" class="gallery-item" style="margin-bottom:0px;padding-bottom:0px;">
                <a href="'.$system->getDomain().'/uploads/'.$photos[$i]['path'].'" itemprop="contentUrl" data-size="640x640">
                <img src="'.$system->getDomain().'/uploads/'.$photos[$i]['path'].'" itemprop="thumbnail"  style="height:150px;width:150px;"/>
                ';
                if($profile->id == $user->id) {
                echo '<i class="ti-close profile-image-delete" onclick="deletePhoto('.$photos[$i]['id'].')"></i>';
                }
                echo '
                </a>
                </figure>
                </li>
                ';
              }
            }
            echo '</ul>';
          } else {
           echo '<ul class="profile-gallery">';
           for($i = 0; $i <= 20; $i++) {
            if($i == 0) {
              if($user->id == $profile->id) {
                echo '
                <li>
                <a href="#" data-toggle="modal" data-target="#photo-upload">
                <img src="'.$system->getDomain().'/img/blank-photo-add.png" style="height:150px;width:150px;">
                </a>
                </li>
                ';
              } else {
                echo '
                <li>
                <img src="'.$system->getDomain().'/img/blank-photo-first.png" style="height:150px;width:150px;">
                </li>
                ';
              }
            } else {
              echo '
              <li>
              <img src="'.$system->getDomain().'/img/blank-photo.png" style="height:150px;width:150px;">
              </li>
              ';
            }
          }
          echo '</ul>';
        }
        ?>
      </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="well bg-white overflow-auto">
        <div class="col-lg-9 col-md-9 col-sm-9">
          <h4 class="profile-section-heading"><?=$lang['Location']?></h4>
          <p class="profile-section">
            <?=$profile->city?><?=$system->ifComma($profile->city)?> <?=$profile->country?> <?php if($distance > 0 && $user->id != $profile->id) { echo '(~'.sprintf($lang['km_away'],ceil($distance)).')'; } ?>
          </p>
          <hr>
          <h4 class="profile-section-heading"><?=$lang['Description']?></h4>
          <p class="profile-section">
            <?php
            if(!empty($profile->bio)) {
              echo $profile->bio;
            } else {
              echo $lang['Nothing_To_Show'];
            }
            ?>
          </p>
          <hr>
          <h4 class="profile-section-heading"><?=$lang['Friends']?></h4>
          <p class="profile-section">
            <?php
            if($friends->num_rows >= 1) {
              while($friend = $friends->fetch_object()) {
                $friend_info = $db->query("SELECT id,profile_picture,age,full_name,last_active,city,country FROM users WHERE (id='".$friend->user1."' OR id='".$friend->user2."') AND id != '".$id."'");
                $friend_info = $friend_info->fetch_object();
                echo '
                <a href="'.$system->getDomain().'/user/'.$friend_info->id.'">
                <img src="'.$system->getProfilePicture($friend_info).'" class="img-circle btn-tooltip mb-0" style="height:50px;width:50px;" data-toggle="tooltip" data-placement="bottom" data-title="'.$system->getFirstName($friend_info->full_name).'" placeholder="" data-original-title="" title="">
                </a>
                ';
              }
            } else {
              echo $lang['Nothing_To_Show'];
            }
            ?>
          </p>
          <hr>
          <h4 class="profile-section-heading"><?=$lang['Interests']?></h4>
          <p class="profile-section">
            <?php
            if(!empty($profile->interests)) {
              $interests = explode(',',$profile->interests);
              foreach($interests as $interest) {
                echo '<div class="interest-item">'.$interest.'</div>';
              }
            } else {
              echo $lang['Nothing_To_Show'];
            }
            ?>
          </p>
          <hr>
          <h4 class="profile-section-heading"><?=$lang['About']?></h4>
          <table class="table table-responsive profile-section" style="max-width:600px;">
            <tr>
              <td align="left">
                <b><?=$lang['Gender']?></b>
              </td>
              <td>
                <?=$lang[$profile->gender]?>
              </td>
            </tr>
            <tr>
              <td align="left">
                <b><?=$lang['Sexual_Orientation']?></b>
              </td>
              <td>
                <?=$lang[$sexual_orientation]?>
              </td>
            </tr>
            <tr>
              <td align="left">
                <b><?=$lang['Height']?></b>
              </td>
              <td>
                <?=$profile->height?> <?=$unit['height']?>
              </td>
            </tr>
            <tr>
              <td align="left">
                <b><?=$lang['Weight']?></b>
              </td>
              <td>
                <?=$profile->weight?> <?=$unit['weight']?>
              </td>
            </tr>
          </table>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3">
          <h4 class="profile-section-heading"><?=$lang['Score']?></h4>
          <div class="text-center">
            <div class="easy-pie-chart easy-pie-sm text-center">
              <div class="percentage" data-percent="<?=$score->percentage?>" data-size="100" data-bar-color="#FF8F5E">
                <span> <?=$score->percentage?> </span> %
                <canvas height="100" width="100"></canvas></div>
                <p class="title">
                  <small><?=sprintf($lang['Score_Details'],number_format($score->likes),number_format($score->total))?></small>
                </p>
              </div>
            </div>
            <div class="clearfix"></div>
            <hr>
            <h4 class="profile-section-heading"><?=$lang['Gifts']?></h4>
            <p class="profile-section">
              <?php
              if($gifts->num_rows >= 1) {
                while($gift = $gifts->fetch_object()) {
                  $sender = $system->getUserInfo($gift->user1);
                  echo '<a href="'.$system->getDomain().'/user/'.$sender->id.'">';
                  echo '<img src="'.$system->getDomain().'/img/gifts/'.$gift->path.'" class="img-responsive gift-image-small pull-left btn-tooltip" data-toggle="tooltip" data-placement="bottom" data-title="'.sprintf($lang['Gift_From'],$system->getFirstName($sender->full_name)).'">';
                  echo '</a>';
                }
              } else {
                echo sprintf($lang['Has_Not_Received_Gifts'],$system->getFirstName($profile->full_name));
              }
              ?>
            </p>
            <div class="clearfix"></div>
            <hr>
            <?php
            if($profile->id != $user->id) {
              if($is_friend == 0 && $sent_request == 1) {
                if($is_sender == 1) {
                  echo '
                  <div id="friendArea" onclick="manageFriendStatus('.$user->id.','.$profile->id.',\'cancel_request\'); return false;">
                  <a href="#" class="btn btn-default btn-block text-center mb-5">
                  '.$lang['Cancel_Friend_Request'].'
                  </a>
                  </div>
                  ';
                } else {
                  echo '
                  <div id="friendArea">
                  <a href="#" class="btn btn-default btn-block text-center mb-5" onclick="manageFriendStatus('.$user->id.','.$profile->id.',\'accept_request\'); return false;">
                  '.$lang['Accept_Friend_Request'].'
                  </a>
                  <a href="#" class="btn btn-default btn-block text-center mb-5" onclick="manageFriendStatus('.$user->id.','.$profile->id.',\'cancel_request\'); return false;">
                  '.$lang['Cancel_Friend_Request'].'
                  </a>
                  </div>
                  ';
                }
              } elseif($is_friend == 1 && $sent_request == 0) {
                echo '
                <div id="friendArea" onclick="manageFriendStatus('.$user->id.','.$profile->id.',\'unfriend\'); return false;">
                <a href="#" class="btn btn-default btn-block text-center mb-5">
                <i class="ti-close pull-right lh20"></i>
                '.$lang['Unfriend'].'
                </a>
                </div>
                ';
              } elseif($is_friend == 0 && $sent_request == 0) {
                echo '
                <div id="friendArea" onclick="manageFriendStatus('.$user->id.','.$profile->id.',\'send_request\'); return false;">
                <a href="#" class="btn btn-default btn-block text-center mb-5">
                <i class="ti-plus pull-right lh20"></i>
                '.$lang['Add_As_Friend'].'
                </a>
                </div>
                ';
              }
            } else {
              echo '
              <a href="'.$system->getDomain().'/settings" class="btn btn-default btn-block text-center mb-5">
              <i class="fa fa-cog pull-right lh20"></i>
              '.$lang['Settings'].'
              </a>
              ';
            }
            ?>
          </div>
        </div>
        <?=$ad->ad_2?>
      </div>
    </div>
  </div>
</div>
<!--/ End body content -->

</section>

<!-- Photo Upload Modal -->
<div class="modal fade" id="photo-upload" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form action="" enctype="multipart/form-data" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size:24px;padding:1px;padding-top:4px;"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><?=$lang['Photo_Upload']?></h4>
        </div>
        <div class="modal-body text-center">
          <div class="alert alert-danger" id="photo-upload-error" style="display:none;"></div>
          <a href="#" class="photo-upload-select no-underline text-muted" onclick="selectPhoto()"> <?=$lang['Select_Photo']?> </a>
          <div class="clearfix"></div>
          <img src="" class="photo-upload-preview" style="display:none;margin-top:15px !important;max-width:312px;max-height:312px;">
        </div>
        <div class="modal-footer">
          <div class="left-side">
            <button type="button" class="btn btn-default btn-simple" data-dismiss="modal"><?=$lang['Close']?></button>
          </div>
          <div class="divider"></div>
          <div class="right-side">
            <button type="submit" name="upload" class="btn btn-danger btn-simple" id="upload-btn"><?=$lang['Upload']?></button>
          </div>
        </div>
      </div>
      <input type="file" id="photo_file" name="photo_file" onchange="photoChange(this)" style="display:none;">
    </form>
  </div>
</div>

<!-- Send Gift Modal -->
<div class="modal fade" id="send-gift" tabindex="-2" role="dialog">
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

<!-- Root element of PhotoSwipe. Must have class pswp. -->
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

  <div class="pswp__bg"></div>

  <div class="pswp__scroll-wrap">

    <div class="pswp__container">
      <div class="pswp__item"></div>
      <div class="pswp__item"></div>
      <div class="pswp__item"></div>
    </div>

    <div class="pswp__ui pswp__ui--hidden">

      <div class="pswp__top-bar">

        <div class="pswp__counter"></div>

        <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

        <button class="pswp__button pswp__button--share" title="Share"></button>

        <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

        <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

        <div class="pswp__preloader">
          <div class="pswp__preloader__icn">
            <div class="pswp__preloader__cut">
              <div class="pswp__preloader__donut"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
        <div class="pswp__share-tooltip"></div>
      </div>

      <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
      </button>

      <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
      </button>

      <div class="pswp__caption">
        <div class="pswp__caption__center"></div>
      </div>

    </div>

  </div>

</div>

<input type="hidden" id="profile_id" value="<?=$profile->id?>">
<input type="hidden" id="receiver_id" value="<?=$profile->id?>">
<input type="hidden" id="gift_id">
