<?php
	$domain = 'http://socialweb.localhost';

	// Database Configuration
	$_db['host'] = 'localhost';
	$_db['user'] = 'ag1725ag';
	$_db['pass'] = 'I7JyA6yemkSJIF1';
	$_db['name'] = 'ag1725ag';

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
	
