var mobile = base;
var page = location.pathname.substring(1);
var parts = window.location.search.substr(1).split("&");
var params = {};
var redirect = '';

// Decode parameters
for (var i = 0; i < parts.length; i++) {
	var temp = parts[i].split("=");
	params[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
}

// For more complex pages
var matches = page.match(/\d+/g);
var user = page.indexOf('user');
if(user !== -1 && matches != null) {
	page = 'user'
	params.id = $('#profile_id').val();
}

if(page.toLowerCase() == 'encounters') {
	redirect = mobile+'/mobile/encounters.php';
}

if(page.toLowerCase() == 'people') {
	redirect = mobile+'/mobile/people.php';
}

if(page.toLowerCase() == 'user') {
	redirect = mobile+'/mobile/user.php?id='+params.id;
}

if(page.toLowerCase() == 'likes') {
	redirect = mobile+'/mobile/likes.php';
}

if(page.toLowerCase() == 'visitors') {
	redirect = mobile+'/mobile/visitors.php';
}

$(window).resize(function() {
	var width = $(window).width();
	if($('#messages').is(':visible')) {
  	redirect =  mobile+'/mobile/messages.php';
	}
	if(redirect == '') {
		redirect = mobile+'/mobile/index.php';
	}
	if (width <= 500) { 
		window.location = redirect;
	}
});