<?php
	$domain = 'http://socialweb.localhost';

	// Database Configuration
	$_db['host'] = 'localhost:3808';
	$_db['user'] = 'socialweb';
	$_db['pass'] = 'X0tr.u21';
	$_db['name'] = 'socialweb';

	$site_name = 'Social Web';
	$meta['keywords'] = '';
	$meta['description'] = '';

	// Facebook Login Configuration
	$fb_app_id = ''; 
	$fb_secret_key = ''; 

	// Misc Configuration
	$minimum_age = '16'; 

	// Units of Measurement
	$unit['height'] = 'cm';
	$unit['weight'] = 'kg';
	
	$db = new mysqli($_db['host'], $_db['user'], $_db['pass'], $_db['name']) or die('MySQL Error');

	error_reporting(0);
	