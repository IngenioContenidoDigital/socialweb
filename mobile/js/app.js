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

function newEncounter(id) {
	$.get(base+'/ajax/newEncounter.php', function(data) { 
		$('.encounters').html(data);
		if($('#encounterGallery').length) {
			$('#encounterGallery').lightSlider({
				gallery: false,
				pager: false,
				item: 1,
				loop: true,
				thumbItem: 9,
				slideMargin:0,
				enableTouch: true,
				enableDrag: true,
				currentPagerPosition: 'left',
				vertical: false,
				verticalHeight: 500,
				vThumbWidth: 60,
				controls: true,
				onSliderLoad: function(el) {
					el.lightGallery({
						selector: '#encounterGallery .lslide'
					});
				}
			});
		}
	});
}

function sendMessage() {
	var receiver_id = $('#receiver_id').val();
	var message = $('#message');
	if(message.val() != '' && message.val() != ' ') {
		$.get(base+'/ajax/sendMessage.php?receiver_id='+receiver_id+'&msg='+encodeURIComponent(message.val()), function(data) {
			$('.list-chats').html(data);
			message.val('');
		});
	}
}

function refreshChat() {
	var receiver_id = $('#receiver_id').val();
	$.get(base+'/ajax/refreshChat.php?receiver_id='+receiver_id, function(data) {
		$('.list-chats').html(data);
	});
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

$(document).keypress(function(e) {
	if(e.which == 13) {
		sendMessage();
	}
});

$(document).ready(function () {

	var parts = window.location.search.substr(1).split("&");
	var params = {};
	for (var i = 0; i < parts.length; i++) {
		var temp = parts[i].split("=");
		params[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
	}

	if(page == 'people') {
		$.get(base+'/ajax/getPeople.php', function(data) {
			$('.people-list').html(data);
		});
	}

	if(page == 'profile') {
		$('.profile-gallery').bxSlider({
			minSlides: 2,
			maxSlides: 4,
			slideWidth: 70,
			slideMargin: 2,
			pager: false,
			preloadImages: 'all',
			controls: false,
			infiniteLoop: false,
			responsive: true,
			touchEnabled: true,
			mode: 'horizontal'
		});
		$('.swipebox').swipebox();
	}

	if(page == 'visitors') {
		$.get(base+'/ajax/getVisitors.php', function(data) {
			$('.visitors-list').html(data);
		});
	}

	if(page == 'likes') {
		$.get(base+'/ajax/getLikes.php', function(data) {
			$('.likes-list').html(data);
		});
	}

	if(page == 'encounters') {
		if($('#encounterGallery').length) {
			$('#encounterGallery').lightSlider({
				gallery: false,
				pager: false,
				item:1,
				loop: true,
				thumbItem: 9,
				slideMargin:0,
				enableTouch: true,
				enableDrag: true,
				currentPagerPosition: 'left',
				vertical: false,
				verticalHeight: 500,
				vThumbWidth: 60,
				controls: true,
				onSliderLoad: function(el) {
					el.lightGallery({
						selector: '#encounterGallery .lslide'
					});
				}
			});
		}
	}

	if(page == 'settings') {
		if($('.city-autocomplete').length) {
			new TeleportAutocomplete({ el: '.city-autocomplete', maxItems: 5 });
		}
	}

});

setInterval(function(){ refreshChat() }, 2000);