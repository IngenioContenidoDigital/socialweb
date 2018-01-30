<?php
class System {

	public $domain;
	public $db;

	public function getDomain() {
		return $this->domain;
	}

	public function getProfilePicture($user) {
		if(filter_var($user->profile_picture,FILTER_VALIDATE_URL)) {
			return $user->profile_picture;
		} else {
			return $this->domain.'/uploads/'.$user->profile_picture;
		}
	}

	public function getUserInfo($id) {
		$user = $this->db->query("SELECT * FROM users WHERE id='".$id."'");
		$user = $user->fetch_object();
		return $user;
	}

	public function getFirstName($full_name) {
		$full_name = explode(' ',$full_name);
		return $full_name[0];
	}

	public function isOnline($last_active) {
		if(time()-$last_active <= 300) {
			return true;
		} else {
			return false;
		}
	}

	public function timeAgo($lang,$ptime) {
		$etime = time() - $ptime;
		if ($etime < 1)
		{
			return $lang['just_now'];
		}
		$a = array( 365 * 24 * 60 * 60  =>  $lang['year'],
			30 * 24 * 60 * 60  =>  $lang['month'],
			24 * 60 * 60  =>  $lang['day'],
			60 * 60  =>  $lang['hour'],
			60  =>  $lang['minute'],
			1  =>  $lang['second']
			);
		$a_plural = array( 'year'   => $lang['years'],
			'month'  => $lang['months'],
			'day'    => $lang['days'],
			'hour'   => $lang['hours'],
			'minute' => $lang['minutes'],
			'second' => $lang['seconds']
			);

		foreach ($a as $secs => $str)
		{
			$d = $etime / $secs;
			if ($d >= 1)
			{
				$r = round($d);
				return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str).' '.$lang['ago'];
			}
		}
	}

	public function secureField($value) {
		return htmlspecialchars(strip_tags($value));
	}

	public function smart_wordwrap($string) {
		return wordwrap($string, 44, "<br>");
	}

	public function truncate($str, $max) {
		if(strlen($str) > $max) {
			return substr($str,0,$max).'...';
		} else {
			return $str;
		}
	}

	public function ifComma($var) {
		if(!empty($var)) {
			return ',';
		}
	}

	public function setUserActive($id) {
		$this->db->query("UPDATE users SET last_active='".time()."' WHERE id='".$id."'");
	}

	public function isActivePlugin($dir,$name) {
		if(file_exists($dir.'/'.$name.'/'.'status.lock')) {
			return true;
		} else {
			return false;
		}
	}

	public function beenBlocked($user1,$user2) {
		$is_blocked = $this->db->query("SELECT * FROM blocked_users WHERE (user2='".$user1."' AND user1='".$user2."')");
		if($is_blocked->num_rows >= 1) {
			return true;
		} else {
			return false;
		}
	}

	public function hasBlocked($user1,$user2) {
		$is_blocked = $this->db->query("SELECT * FROM blocked_users WHERE (user2='".$user2."' AND user1='".$user1."')");
		if($is_blocked->num_rows >= 1) {
			return true;
		} else {
			return false;
		}
	}

	public function getSettings() {
		$settings = $this->db->query("SELECT * FROM settings LIMIT 1");
		return $settings->fetch_object();
	}

	public function getPageName() {
		return basename($_SERVER['PHP_SELF']);
	}

	public function getScore($user_id) {
		$likes = $this->db->query("SELECT * FROM profile_likes WHERE profile_id='".$user_id."'");
		$likes = $likes->num_rows;
		$dislikes = $this->db->query("SELECT * FROM profile_dislikes WHERE profile_id='".$user_id."'");
		$dislikes = $dislikes->num_rows;
		$total = $likes+$dislikes;
		$percentage = round(($likes/$total)*100);
		$result = new stdClass();
		$result->likes = $likes;
		$result->dislikes = $dislikes;
		$result->total = $total;
		$result->percentage = $percentage;
		return $result;
	}

	public function updateLastEncounter($user_id, $encounter_id) {
		$this->db->query("UPDATE users SET last_encounter='".$encounter_id."' WHERE id='".$user_id."'");
	}

	public function getUserPhotos($user_id, $limit) {
		if(!is_numeric($limit)) { $limit = ''; } else { $limit = 'LIMIT '.$limit; }
		return $this->db->query("SELECT * FROM uploaded_photos WHERE user_id='".$user_id."' ".$limit." ");
	}

	public function getUserBadges($user) {
		if($user->is_verified == 1) {
			echo '<a class="btn btn-info btn-xs btn-icon profile-badge"><i class="ti-check text-info"></i></a>';
		}
		if($user->is_vip == 1 || $user->vip_expiration >= time()) {
			echo '<a class="btn btn-warning btn-xs btn-icon profile-badge"><i class="ti-crown text-warning"></i></a>';
		}
	}

	public function getCountriesSelect() {
		$countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
		echo '<option value="All Countries"> All Countries </option>';
		foreach($countries as $country) {
			echo '<option value="'.$country.'"> '.$country.' </option>';
		}
	}

	public function getPageError($page) {
		if($page == 'encounters' || $page == 'people') {
			echo '
			<div class="col-lg-6 col-md-6 col-sm-12 col-centered" style="padding-top:70px;margin-bottom:190px;">
			<div class="well bg-white overflow-auto text-center" style="padding:30px;">
			<img src="'.$this->domain.'/img/icons/user-minus.png" class="img-responsive" style="height:100px;width:100px;margin:0 auto;">
			<h3> Expand your search </h3>
			<p>
			Sorry, no one fits your search criteria. <br>
			Please, adjust your filters and try again.
			</p>
			<br>
			<a href="#" data-toggle="modal" data-target="#filter-results" class="btn btn-theme btn-block pull-right"> <i class="fa fa-fw fa-sliders"></i> Filter </a>
			</div>
			</div>
			';
		}
	}

}

// Multi-Language
if(!isset($_SESSION['language'])) {
	$language = 'english';
} else {
	$language = $_SESSION['language'];
}
if(defined('IS_AJAX')) {
	$path = '../languages/'.strtolower($language).'/language.php';
} elseif(defined('IS_MOBILE')) {
	$path = '../languages/'.strtolower($language).'/language.php';
} elseif(defined('IS_MOBILE_AJAX')) {
	$path = '../../languages/'.strtolower($language).'/language.php';
} else {
	$path = 'languages/'.strtolower($language).'/language.php';
}
require($path);
