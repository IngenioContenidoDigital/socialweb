var desktop = base.replace('/mobile','');
var parts = window.location.search.substr(1).split("&");
var params = {};
var redirect = '';

// Decode parameters
for (var i = 0; i < parts.length; i++) {
	var temp = parts[i].split("=");
	params[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
}

if(page.toLowerCase() == 'encounters') {
	redirect = desktop+'/encounters';
}

if(page.toLowerCase() == 'people') {
	redirect = desktop+'/people';
}

if(page.toLowerCase() == 'profile') {
	redirect = desktop+'/user/'+params.id;
}

if(page.toLowerCase() == 'likes') {
	redirect = desktop+'/likes';
}

if(page.toLowerCase() == 'visitors') {
	redirect = desktop+'/visitors';
}

if(page.toLowerCase() == 'chat') {
	redirect = desktop+'/encounters';
}

if(page.toLowerCase() == 'filter') {
	redirect = desktop+'/encounters';
}

if(page.toLowerCase() == 'messages') {
	redirect = desktop+'/encounters';
}

if(page.toLowerCase() == 'login') {
	redirect = desktop+'/index.php';
}

if(page.toLowerCase() == 'register') {
	redirect = desktop+'/index.php';
}

$(window).resize(function() {
	var width = $(window).width();
	if(redirect == '') {
		redirect = desktop+'/index.php';
	}
	if (width > 500) { 
		window.location = redirect;
	}
});