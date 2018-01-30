$(document).ready(function() {

  if(showControls == true) {
    $('.profile-gallery').bxSlider({
      minSlides: 2,
      maxSlides: 4,
      slideWidth: 150,
      slideMargin: 0,
      pager: false,
      preloadImages: 'all',
      controls: true,
      infiniteLoop: false,
      mode: 'horizontal'
    });
  } else {
    $('.profile-gallery').bxSlider({
      minSlides: 2,
      maxSlides: 4,
      slideWidth: 150,
      slideMargin: 0,
      pager: false,
      preloadImages: 'all',
      controls: false,
      infiniteLoop: false,
      mode: 'horizontal'
    });
  }

  $('#encounterGallery').lightSlider({
    gallery: false,
    prevHtml: '<i class="ti-angle-left encounter-control" onclick="prevSlide(); return false;"></i>',
    nextHtml: '<i class="ti-angle-right encounter-control" onclick="nextSlide(); return false;"></i>',
    item: 1,
    loop: false,
    thumbItem:9,
    slideMargin:0,
    enableDrag: false,
    currentPagerPosition:'left',
    controls: true,
    vertical: false,
    verticalHeight:640,
    vThumbWidth: 60,
    pager: false,
    enableDrag: true,
    onSliderLoad: function(el) {
      el.lightGallery({
        selector: '#encounterGallery .lslide'
      });
    }
  });

  $('.gift-selection').mCustomScrollbar({
    theme: 'light-3',
    live: 'on',
  });

  if($('.city-autocomplete').length) {
    new TeleportAutocomplete({ el: '.city-autocomplete', maxItems: 5 });
  }

  getNotifications();
  getSpotlight();
  if(random_chat == 'true') {
    getRandomChats();
  } else {
    getChats();
    loadChat(last_chatted);
  }

  window.setInterval(function(){
    screenNotifications();
    getNotificationCount();
  }, 5000);

});


function likeProfile(id,is_encounter) {
  heart = $("#heart-"+id);
  $.get(base+'/ajax/likeProfile.php?id='+id, function(data) {
    heart.html(data);
  });
  if(is_encounter == true) {
    newEncounter(id);
  }
}

function dislikeProfile(id,is_encounter) {
  heart = $("#times-"+id);
  $.get(base+'/ajax/dislikeProfile.php?id='+id, function(data) {
    heart.html(data);
  });
  if(is_encounter == true) {
    newEncounter(id);
  }
}

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('.photo-upload-preview').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}

function selectPhoto() {
  var file_input = $('#photo_file');
  file_input.trigger('click');
  $('.photo-upload-select').blur();
}

function photoChange(photo) {
  var select = $('.photo-upload-select');
  var ext = $('#photo_file').val().split('.').pop().toLowerCase();
  var error = $('#photo-upload-error');
  var upload_btn = $('#upload-btn');
  if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
    error.html('Please, upload a valid image file');
    error.show();
    upload_btn.prop('disabled',true);
  } else {
    error.hide();
    select.removeClass('text-muted');
    readURL(photo);
    $('.photo-upload-preview').show();
    upload_btn.removeAttr('disabled');
  }
}

function manageFriendStatus(user1,user2,action) {
  var friendArea = $("#friendArea");
  if(action === 'send_request') {
    $.get(base+'/ajax/manageFriendStatus.php?user1='+user1+'&user2='+user2+'&action=send_request', function(data) {
      friendArea.html(data);
      friendArea.attr('onclick',"manageFriendStatus("+user1+","+user2+",'cancel_request')");
    });
  } else if(action === 'unfriend') {
    $.get(base+'/ajax/manageFriendStatus.php?user1='+user1+'&user2='+user2+'&action=unfriend', function(data) {
      friendArea.html(data);
      friendArea.attr('onclick',"manageFriendStatus("+user1+","+user2+",'send_request')");
    });
  } else if(action === 'accept_request') {
    $.get(base+'/ajax/manageFriendStatus.php?user1='+user1+'&user2='+user2+'&action=accept_request', function(data) {
      friendArea.html(data);
      friendArea.attr('onclick',"manageFriendStatus("+user1+","+user2+",'unfriend')");
    });
  } else if(action === 'cancel_request') {
    $.get(base+'/ajax/manageFriendStatus.php?user1='+user1+'&user2='+user2+'&action=cancel_request', function(data) {
      friendArea.html(data);
      friendArea.attr('onclick',"manageFriendStatus("+user1+","+user2+",'send_request')");
    });
  }
}

function deletePhoto(photo_id) {
  $.get(base+'/ajax/deletePhoto.php?photo_id='+photo_id, function(data) {
    location.reload();
  });
}

function getNotificationCount() {
  $.get(base+'/ajax/getNotificationCount.php', function(data) {
    $('.notification-count').each(function(){
      $(this).html(data);
    });
  });
}

function getNotifications() {
  $.get(base+'/ajax/getNotifications.php', function(data) {
    $('.notification-list').html(data);
  });
}

function screenNotification(notification_id) {
  $.get(base+'/ajax/screenNotification.php?notification_id='+notification_id);
}

function screenNotifications() {
  $.get(base+'/ajax/getScreenNotifications.php', function(data) {
    var notifications = $.parseJSON(data);
    $.each(notifications, function(key, val) {
      $.gritter.add({
        title: val.title,
        text: val.text,
        image: val.image,
        sticky: false,
        time: '',
        fade_in_speed: 'medium',
        fade_out_speed: 300,
        after_open: function(e){
          screenNotification(val.id);
          document.getElementById('notification').play();
        },
        after_close: function(e, manual_close){
          screenNotification(val.id);
        },
      });
    });
  });
  refreshChat();
}

function readNotifications() {
  $.get(base+'/ajax/readNotifications.php', function(data) {
    $('.notification-count').html('0');
  });
}

function selectGateway(id) {
  var payment_gateway = $('#payment_gateway');
  var btn = $('.payment-btn');
  if(id == 1) {
    $('.mobile-payment-btn').hide();
    $('.package-select-area').show();
    $('.payment-btn').show();
    btn.attr('id','pay');
    btn.prop('type','submit');
  }
  if(id == 2) {
    $('.mobile-payment-btn').hide();
    $('.package-select-area').show();
    $('.payment-btn').show();
    btn.attr('id','stripe_pay');
    btn.attr('type','button');
  }
  if(id == 3) {
    $('.package-select-area').hide();
    $('.payment-btn').hide();
    $('.mobile-payment-btn').show();
  }
  payment_gateway.val(id);
}

function selectDuration(id) {
  var vip_duration = $('#vip_duration');
  vip_duration.val(id);
}

function selectGift(id) {
  for (var i = 1; i <= 26; i++) {
    if(id != i) {
      $('#gift'+i).css('background','none');
    } else {
      $('#gift'+i).css('background','#eee');
    }
  };
  $('#giftValue').val(id);
}

function newEncounter(id) {
  $.get(base+'/ajax/newEncounter.php', function(data) {
    $('.encounter').html(data);
    $('#encounterGallery').lightSlider({
      gallery:true,
      item:1,
      loop:true,
      thumbItem:9,
      slideMargin:0,
      enableDrag: true,
      currentPagerPosition:'left',
      vertical: true,
      verticalHeight:500,
      vThumbWidth:60,
      onSliderLoad: function(el) {
        el.lightGallery({
          selector: '#encounterGallery .lslide'
        });
      }
    });
    $('.easy-pie-chart .percentage').easyPieChart();
  });
}

function getChats() {
  $.get(base+'/ajax/getChats.php', function(data) {
    $('.chats-list').html(data);
  });
}

function getRandomChats() {
  $.get(base+'/ajax/getRandomChats.php', function(data) {
    $('.chats-list').html(data);
  });
}

function loadChat(id) {
 $.get(base+'/ajax/loadChat.php?id='+id, function(data) {
  var converted = emojione.toImage(data);
  $('.chat-content').html(converted);
  $('.chat-content-wrap').mCustomScrollbar({
    theme: 'dark-3',
    live: 'on',
  });
  if(converted.length === 0) {
    loadChatPlaceholder(id);
  }
  $('.chat-content-wrap').mCustomScrollbar('update');
  $('.chat-content-wrap').mCustomScrollbar("scrollTo","bottom",{scrollInertia:0});
});
 if(random_chat != 'true') {
  loadChatInfo(id);
} else {
  loadChatInfoProfile(id);
}
$('#receiver_id').val(id);
setActiveChat(id);
}

function loadChatInfo(id) {
  $.get(base+'/ajax/loadChatInfo.php?id='+id, function(data) {
    $('.chat-top-right').html(data);
  });
  getStickerPacks(id);
}

function loadChatInfoProfile(id) {
  $.get(base+'/ajax/loadChatInfoProfile.php?id='+id, function(data) {
    $('.chat-top-right').html(data);
  });
  getStickerPacks(id);
  if(random_chat != 'true') {
    getChats();
  } else {
    getRandomChats();
  }
}

function loadChatPlaceholder(id) {
  $.get(base+'/ajax/loadChatPlaceholder.php?id='+id, function(data) {
    $('.chat-content-wrapper').mCustomScrollbar("disable");
    $('.chat-content').html(data);
  });
}

function setActiveChat(id) {
  $('.chat-sidebar-user').each(function(){
    $(this).removeClass('active');
  });
  $('.chat-open-'+id).addClass('active');
}

function toggleEmojiMenu() {
  $('.gift-menu').hide();
  var emoji_menu = $('.emoji-menu');
  if(emoji_menu.is(':visible')) {
    $('.chat-content-wrapper').mCustomScrollbar('update');
  } else {
    $('.chat-content-wrapper').mCustomScrollbar('disable');
  }
  $('.emoji-top-link').addClass('active');
  emoji_menu.slideToggle('fast');
  loadEmojis();
}

function toggleChatGifts() {
  $('.emoji-menu').hide();
  var gift_menu = $('.gift-menu');
  if(gift_menu.is(':visible')) {
    $('.chat-content-wrapper').mCustomScrollbar('update');
  } else {
    $('.chat-content-wrapper').mCustomScrollbar('disable');
  }
  gift_menu.slideToggle('fast');
  $.get(base+'/ajax/getChatGifts.php', function(data) {
    $('.gift-content').html(data);
    $('.gift-content-wrap').mCustomScrollbar({
      theme: 'dark',
      live: 'on',
    });
  });
}

function selectChatGift(user_id,id) {
  $('#gift_id').val(id);
  var name = $('.chat-receiver-name').text();
  name = name.slice(0, -5);
  var receiver_id = $('#receiver_id').last().val();
  var gift_id = $('#gift_id').last().val();
  $.get(base+'/ajax/chatGiftModal.php?receiver_id='+receiver_id+'&gift_id='+gift_id+'&receiver_name='+name, function(data) {
    $('.gift-modal-container').html(data);
  });
  $('#chat-send-gift').modal('show');
}

function sendChatGift() {
  var receiver_id = $('#receiver_id').last().val();
  var gift_id = $('#gift_id').last().val();
  $.get(base+'/ajax/sendChatGift.php?receiver_id='+receiver_id+'&gift_id='+gift_id, function(data) {
    $('.gift-modal-container').html(data);
  });
}

function setActiveEmojiLink(id) {
  $('.emj').each(function() {
    $(this).removeClass('active');
  });
  $(id).addClass('active');
}

function getStickerPacks(receiver_id) {
  $.get(base+'/ajax/getStickerPacks.php?receiver_id='+receiver_id, function(data) {
    $('.emoji-sticker-packs').html(data);
  });
}

function loadStickers(pack_id,receiver_id,is_premium) {
  $.get(base+'/ajax/getStickers.php?pack_id='+pack_id+'&receiver_id='+receiver_id+'&is_premium='+is_premium, function(data) {
    $('.emoji-content').html(data);
  });
}

function loadEmojis() {
  $.get(base+'/ajax/getEmoji.php', function(data) {
    $('.emoji-content').html(data);
    $('.emoticon').each(function() {
      var original = $(this).html();
      var converted = emojione.toImage(original);
      $(this).html(converted);
    });
    $('.emoji-content-wrap').mCustomScrollbar({
      theme: 'dark',
      live: 'on',
    });
    $('.emoji-content-wrap').mCustomScrollbar('update');
  });
}

function sendSticker(sticker_id,receiver_id) {
  $.get(base+'/ajax/sendSticker.php?sticker_id='+sticker_id+'&receiver_id='+receiver_id);
  $('.chat-content-wrap').mCustomScrollbar('update');
  $('.chat-content-wrap').mCustomScrollbar("scrollTo","bottom",{scrollInertia:0});
}

function appendToMessage(str) {
  var message = $('#message');
  message.val(message.val()+' '+str);
}

function refreshChat() {
  var receiver_id = $('#receiver_id').val();
  $.get(base+'/ajax/refreshChat.php?receiver_id='+receiver_id, function(data) {
    var converted = emojione.toImage(data);
    if(converted.length === 0) {
      loadChatPlaceholder(receiver_id);
    } else {
    $('.chat-content').html(converted);
    }
  });
}

function sendMessage() {
  var receiver_id = $('#receiver_id').val();
  var message = $('#message');
  if(message.val() != '' && message.val() != ' ') {
    $.get(base+'/ajax/sendMessage.php?receiver_id='+receiver_id+'&msg='+encodeURIComponent(message.val()), function(data) {
      var converted = emojione.toImage(data);
      $('.chat-content').html(converted);
       $('.chat-content-wrap').mCustomScrollbar('update');
      $('.chat-content-wrap').mCustomScrollbar("scrollTo","bottom",{scrollInertia:0});
      message.val('');
    });
  }
}

function unlockStickers(pack_id,receiver_id,is_premium) {
  document.getElementById("darkLayer-"+pack_id).style.display = "none";
  $.get(base+'/ajax/unlockStickerPack.php?pack_id='+pack_id, function(data) {
    loadStickers(pack_id,receiver_id,is_premium);
  });
}

function deleteMessages(user1,user2) {
  $.get(base+'/ajax/deleteMessages.php?user1='+user1+'&user2='+user2, function(data) {
    console.log('Messages deleted');
  });
}

function messageUser(id) {
  getChats();
  loadChat(id);
  loadChatInfoProfile(id);
  $('#messages').modal('show');
}

function getSpotlight() {
  $.get(base+'/ajax/getSpotlight.php', function(data) {
    $('.spotlight').html(data);
    $('.spotlight').bxSlider({
      minSlides: 2,
      maxSlides: 10,
      slideWidth: 65,
      slideMargin: 0,
      pager: false,
      preloadImages: 'all',
      controls: true,
      infiniteLoop: false,
      mode: 'horizontal',
      hideControlOnEnd: true
    });
  });
}

$(document).keypress(function(e) {
  if(e.which == 13) {
    sendMessage();
  }
});

$(document).on('show.bs.modal', '.modal', function () {
  var zIndex = 1040 + (10 * $('.modal:visible').length);
  $(this).css('z-index', zIndex);
  setTimeout(function() {
    $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
  }, 0);
});
