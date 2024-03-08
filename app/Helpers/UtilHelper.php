<?php

function array_to_object($array) {
	$obj = new stdClass;
	foreach ($array as $k => $v) {
		if (strlen($k)) {
			if (is_array($v)) {
				$obj->{$k} = array_to_object($v); //RECURSION
			} else {
				$obj->{$k} = $v;
			}
		}
	}
	return $obj;
}

function get_time_slot_array($startTime, $endTime, $slotDuration) {
	//$slotDuration in minutes
	$slotDuration = (int) $slotDuration;
	$totalTimeSlots = array();
	$interval = 'PT' . $slotDuration . 'M';
	$period = new \DatePeriod(new \DateTime($startTime), new \DateInterval($interval), new \DateTime($endTime));
	foreach ($period as $time) {
		$totalTimeSlots[$time->format("H:i")] = $time->format("h:i A");
	}

	return $totalTimeSlots;
}

function pr($arr) {
	print_r($arr);
}

function pre($arr) {

	echo "<pre>";
	print_r($arr);
	exit();
}

function replace_relative_urls($baseURL, $str) {
	//Only use under live domain
	$result = preg_replace('/(\.\.\/)*\1/', $baseURL, $str);
	return $result;
}

function limitText($text, $limit = 65) {
	if (strlen($text) < $limit) {
		return $text;
	}
	$stringCut = substr($text, 0, $limit);
	$string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '...';
	return $string;
}

function highlight_text($text, $keyword) {
	return preg_replace("~\p{L}*?" . preg_quote($keyword) . "\p{L}*~ui", "<span class='highlight'><b>$0</b></span>", $text);
}

function getTranslatedMonthNames() {
	$translatedMonth = [];
	$short = $full = '';
	for ($month = 1; $month <= 12; $month++) {
		$full .= (empty($full)) ? Lang::get('months.' . $month) : ',' . Lang::get('months.' . $month);
		$short .= (empty($short)) ? Lang::get('months.' . $month . '_short') : ',' . Lang::get('months.' . $month . '_short');
	}
	$translatedMonth['full'] = explode(',', $full);
	$translatedMonth['short'] = explode(',', $short);

	return $translatedMonth;
}

function getPlUploadControlWithoutLabel($controlName, $allowedMimes = ['jpg', 'jpeg', 'png'], $uploadType = null, $btnLabel = 'Select File', $validationMsg = null, $required = false) {

	$controlHTML = '<div class = "noLabelFU uploadControlWrapper">' .
		'<input type = "file" class = "form-control uploaderProfile" data-allowed="' . (implode(",", $allowedMimes)) . '" data-type="' . $uploadType . '" title = "' . $validationMsg . '" id = "' . $controlName . '_file" name = "' . $controlName . '_file" ' . (($required == true) ? " required " : '') . ' />' .
		'<div class = "choose">' .
		'<div class = "choose-btn">' . $btnLabel . '</div>' .
		'<div class = "choose-file uploadFileName"></div>' .
		'<div class = "uploadPercentage"></div>' .
		'<div class = "uploadProgressWrapper">' .
		'<div class = "uploadProgress" ></div>' .
		'</div>' .
		'</div>' .
		'<input class = "filename" type="hidden" id="' . $controlName . '" value="" name="' . $controlName . '" placeholder="">' .
		'<input class = "original_name" type="hidden" id="' . $controlName . '_tmp" value="" name="' . $controlName . '_tmp" placeholder="">' .
		'</div>';
	return $controlHTML;
}

function getMultiPlUploadControl($label, $controlName, $allowedMimes = ['jpg', 'jpeg', 'png'], $uploadType = null, $btnLabel = 'Select File', $validationMsg = null, $required = false, $oldFileName = "", $postType = null) {

	$dimensions = \Config::get('pgsimagedimensions');

	$width = $height = false;
	$dimensionStr = '';

	if (!empty($dimensions[$controlName . '_file'])) {
		if (!empty($dimensions[$controlName . '_file']['width'])) {
			$width = $dimensions[$controlName . '_file']['width'];
			$height = $dimensions[$controlName . '_file']['height'];
		}
		if (!empty($dimensions[$controlName . '_file']['large'])) {
			$width = $dimensions[$controlName . '_file']['large']['width'];
			$height = $dimensions[$controlName . '_file']['large']['height'];
		}
	}
	if (!empty($width)) {
		$dimensionStr = ' <strong class="imageDims">[' . $width . 'px X ' . $height . 'px] </strong>';
	}
	$imagePreview = '';
	$postBasePath = 'storage/post/';
	if (!empty($oldFileName) && File::exists($postBasePath . $oldFileName) && $uploadType == "image") {
		$imagePreview = '<div class="uploadPreview"><div class="upImgWrapper"><span class="delUploadImage" data-name="' . $oldFileName . '"><i class="fa fa-times-circle"></i></span><img src="' . asset($postBasePath . $oldFileName) . '" class="uploadPreview"/></div><div class="clearfix"></div></div>';
	} else {
		if (!empty($oldFileName) && File::exists($postBasePath . $oldFileName)) {
			$imagePreview = '<div class="uploadPreview"><div class="upImgWrapper"><span class="delUploadImage" data-name="' . $oldFileName . '"><i class="fa fa-times-circle"></i></span><a target="_blank" href="' . asset($postBasePath . $oldFileName) . '" class="uploadPreview">' . $oldFileName . '</a></div><div class="clearfix"></div></div>';
		}
	}

	if (empty($allowedMimes)) {
		$allowedMimes = ['jpg', 'jpeg', 'png'];
	}

	$controlHTML = '<label class = "fl-start">' . $label . $dimensionStr . '<em class = "mandatory">*</em></label>' . $imagePreview .
		'<div class = "uploadControlWrapper input_parent">' .
		'<input type = "file" class = "form-control multiuploader" data-slug="' . $postType . '" data-allowed="' . (implode(",", $allowedMimes)) . '" data-type="' . $uploadType . '" title = "' . $validationMsg . '" id = "' . $controlName . '_file" name = "' . $controlName . '_file" ' . (($required == true) ? " required " : '') . ' />' .
		'<div class = "choose">' .
		'<div class = "choose-btn">' . $btnLabel . '</div>' .
		'<div class = "choose-file uploadFileName"></div>' .
		'<div class = "uploadPercentage"></div>' .
		'<div class = "uploadProgressWrapper">' .
		'<div class = "uploadProgress" ></div>' .
		'</div>' .
		'</div>' .
		'</div>';

	return $controlHTML;
}

function getSinglePlUploadControl($label, $controlName, $allowedMimes = ['jpg', 'jpeg', 'png'], $uploadType = null, $btnLabel = 'Select File', $validationMsg = null, $required = false, $oldFileName = "", $postType = null, $postBasePath = null) {

	$imagePreview = '';
	$postBasePath = (!empty($postBasePath)) ? $postBasePath : 'storage/post/';
	if (!empty($oldFileName) && File::exists($postBasePath . $oldFileName) && $uploadType == "image") {
		$imagePreview = '<div class="uploadPreview img_uploaded"><div class="upImgWrapper"><span class="delUploadImage" data-id="' . $oldFileName . '" data-name="' . $oldFileName . '"><i class="fa fa-times-circle"></i></span><img src="' . asset($postBasePath . $oldFileName) . '" class="uploadPreview"/></div><div class="clearfix"></div></div>';
	} else {
		if (!empty($oldFileName) && File::exists($postBasePath . $oldFileName)) {
			$imagePreview = '<div class="uploadPreview img_uploaded"><div class="upImgWrapper"><span class="delUploadImage" data-name="' . $oldFileName . '"><i class="fa fa-times-circle"></i></span><a target="_blank" href="' . asset($postBasePath . $oldFileName) . '" class="uploadPreview">' . $oldFileName . '</a></div><div class="clearfix"></div></div>';
		}
	}

	if (empty($allowedMimes)) {
		$allowedMimes = ['jpg', 'jpeg', 'png'];
	}

	$dimensions = \Config::get('pgsimagedimensions');

	$width = $height = false;
	$dimensionStr = '';

	if (!empty($dimensions[$controlName])) {
		if (!empty($dimensions[$controlName]['width'])) {
			$width = $dimensions[$controlName]['width'];
			$height = $dimensions[$controlName]['height'];
		}
		if (!empty($dimensions[$controlName]['large'])) {
			$width = $dimensions[$controlName]['large']['width'];
			$height = $dimensions[$controlName]['large']['height'];
		}
	}

	if (!empty($width)) {
		$dimensionStr = ' <strong class="imageDims">[' . $width . 'px X ' . $height . 'px] </strong>';
	}
	$requiredLabel = ($required) ? '<em class = "mandatory">*</em>' : '';

	$controlHTML = '<label class = "fl-start">' . $label . $dimensionStr . $requiredLabel . '</label>' . $imagePreview .
		'<div class = "uploadControlWrapper input_parent">' .
		'<input type = "file" class = "form-control singleuploader" data-slug="' . $postType . '" data-allowed="' . (implode(",", $allowedMimes)) . '" data-type="' . $uploadType . '" title = "' . $validationMsg . '" id = "' . $controlName . '_file" name = "' . $controlName . '_file" ' . (($required == true && !$oldFileName) ? " required " : '') . ' />' .
		'<div class = "choose">' .
		'<div class = "choose-btn">' . $btnLabel . '</div>' .
		'<div class = "choose-file uploadFileName"></div>' .
		'<div class = "uploadPercentage"></div>' .
		'<div class = "uploadProgressWrapper">' .
		'<div class = "uploadProgress" ></div>' .
		'</div>' .
		'</div>' .
		'<input class = "filename" type="hidden" id="' . $controlName . '" value="' . ((!empty($oldFileName)) ? $oldFileName : '') . '" name="meta[text][' . $controlName . ']" placeholder="">' .
		'<input class = "original_name" type="hidden" id="' . $controlName . '_tmp" value="" name="' . $controlName . '_tmp" placeholder="">' .
		'</div>';
	return $controlHTML;
}

function getYoutubeVideoID($url) {

	$videoID = false;
	if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $id)) {
		$videoID = $id[1];
	} elseif (preg_match('/youtube\.com\/watch\?.*&v=([^\&\?\/]+)/', $url, $id)) {
		$mediaID = $id[1];
	} elseif (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $id)) {
		$videoID = $id[1];
	} elseif (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/', $url, $id)) {
		$videoID = $id[1];
	} elseif (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $id)) {
		$videoID = $id[1];
	} elseif (preg_match('/youtube\.com\/verify_age\?next_url=\/watch%3Fv%3D([^\&\?\/]+)/', $url, $id)) {
		$videoID = $id[1];
	}
	return $videoID;
}

function getNormalSinglePlUploadControl($label, $controlName, $allowedMimes = ['jpg', 'jpeg', 'png'], $uploadType = null, $btnLabel = 'Select File', $validationMsg = null, $required = false, $oldFileName = "", $postType = null, $postBasePath = null) {

	$imagePreview = '';
	$postBasePath = (!empty($postBasePath)) ? $postBasePath : 'storage/post/';
	if (!empty($oldFileName) && File::exists($postBasePath . $oldFileName) && $uploadType == "image") {
		$imagePreview = '<div class="uploadPreview img_uploaded"><div class="upImgWrapper"><span class="delUploadImage" data-name="' . $oldFileName . '"><i class="fa fa-times-circle"></i></span><img src="' . asset($postBasePath . $oldFileName) . '" class="uploadPreview"/></div><div class="clearfix"></div></div>';
	} else {
		if (!empty($oldFileName) && File::exists($postBasePath . $oldFileName)) {
			$imagePreview = '<div class="uploadPreview img_uploaded"><div class="upImgWrapper"><span class="delUploadImage" data-name="' . $oldFileName . '"><i class="fa fa-times-circle"></i></span><a target="_blank" href="' . asset($postBasePath . $oldFileName) . '" class="uploadPreview">' . $oldFileName . '</a></div><div class="clearfix"></div></div>';
		}
	}

	if (empty($allowedMimes)) {
		$allowedMimes = ['jpg', 'jpeg', 'png'];
	}

	$dimensions = \Config::get('pgsimagedimensions');

	$width = $height = false;
	$dimensionStr = '';

	if (!empty($dimensions[$controlName])) {
		if (!empty($dimensions[$controlName]['width'])) {
			$width = $dimensions[$controlName]['width'];
			$height = $dimensions[$controlName]['height'];
		}
		if (!empty($dimensions[$controlName]['large'])) {
			$width = $dimensions[$controlName]['large']['width'];
			$height = $dimensions[$controlName]['large']['height'];
		}
	}

	if (!empty($width)) {
		$dimensionStr = ' <strong class="imageDims">[' . $width . 'px X ' . $height . 'px] </strong>';
	}

	$controlHTML = '<label class = "fl-start">' . $label . $dimensionStr . '<em class = "mandatory">*</em></label>' . $imagePreview .
		'<div class = "uploadControlWrapper input_parent">' .
		'<input type = "file" class = "form-control singleuploader " data-slug="' . $postType . '" data-allowed="' . (implode(",", $allowedMimes)) . '" data-type="' . $uploadType . '" title = "' . $validationMsg . '" id = "' . $controlName . '_file" name = "' . $controlName . '_file" ' . (($required == true) ? " required " : '') . ' />' .
		'<div class = "choose">' .
		'<div class = "choose-btn">' . $btnLabel . '</div>' .
		'<div class = "choose-file uploadFileName"></div>' .
		'<div class = "uploadPercentage"></div>' .
		'<div class = "uploadProgressWrapper">' .
		'<div class = "uploadProgress" ></div>' .
		'</div>' .
		'</div>' .
		'<input class = "filename" type="hidden" id="' . $controlName . '" value="' . ((!empty($oldFileName)) ? $oldFileName : '') . '" name="' . $controlName . '" placeholder="">' .
		'<input class = "original_name" type="hidden" id="' . $controlName . '_tmp" value="" name="' . $controlName . '_tmp" placeholder="">' .
		'</div>';
	return $controlHTML;
}

function is_rtl($string) {
	$rtl_chars_pattern = '/[\x{0590}-\x{05ff}\x{0600}-\x{06ff}]/u';
	return preg_match($rtl_chars_pattern, $string);
}

function dateWithLang($obj, $prop) {

	$returnVal = $date = "";
	if (is_object($obj)) {
		$returnVal = (isset($obj->{$prop})) ? $obj->{$prop} : '';
	} elseif (is_array($obj)) {
		$returnVal = (isset($obj[$prop])) ? $obj[$prop] : '';
	}

	if (!empty($returnVal)) {
		$date = '<span>' . date('d ', strtotime($returnVal)) . "</span><span>" . Lang::get("messages." . date('M', strtotime($returnVal))) . " " . date('Y', strtotime($returnVal)) . '</span>';
	}

	return $date;
}

function printDateDay($obj, $prop) {

	$returnVal = "";
	if (is_object($obj)) {
		$returnVal = (isset($obj->{$prop})) ? $obj->{$prop} : '';
	} elseif (is_array($obj)) {
		$returnVal = (isset($obj[$prop])) ? $obj[$prop] : '';
	}
	return date('d ', strtotime($returnVal));
}

function printDateMonthYear($obj, $prop) {

	$returnVal = "";
	if (is_object($obj)) {
		$returnVal = (isset($obj->{$prop})) ? $obj->{$prop} : '';
	} elseif (is_array($obj)) {
		$returnVal = (isset($obj[$prop])) ? $obj[$prop] : '';
	}
	return Lang::get("messages." . date('M', strtotime($returnVal))) . " " . date('Y', strtotime($returnVal));
}

function displaySplitDate($returnVal, $d) {
	if (!empty($returnVal)) {
		$date = date($d, strtotime($returnVal));
		if ($d == 'M') {
			$date = Lang::get("messages." . date('M', strtotime($returnVal)));
		}
	}
	return $date;
}

function displayDateTime($dateTime) {
	$dateTimeTemp = DateTime::createFromFormat('Y-m-d H:i:s', $dateTime);
	if (!$dateTimeTemp) {
		return $dateTime;
	}

	if ($dateTimeTemp->format('H:i:s') == "00:00:00") {
		return $dateTimeTemp->format('Y-m-d');
	}
	return $dateTimeTemp->format('Y-m-d h:i A');
}

function getPaginationSerial($obj) {
	if (!isset($obj)) {
		return 1;
	}
	try {
		return ($obj->currentpage() - 1) * $obj->perpage() + 1;
	} catch (\Exception $ex) {
		return 1;
	}
}

function getAppConfig($label) {
	return \Config::get('constants.' . $label);
}

function getFileSize($bytes) {
	if ($bytes >= 1073741824) {
		$bytes = number_format($bytes / 1073741824, 2) . ' GB';
	} elseif ($bytes >= 1048576) {
		$bytes = number_format($bytes / 1048576, 2) . ' MB';
	} elseif ($bytes >= 1024) {
		$bytes = number_format($bytes / 1024, 2) . ' KB';
	} elseif ($bytes > 1) {
		$bytes = $bytes . ' bytes';
	} elseif ($bytes == 1) {
		$bytes = $bytes . ' byte';
	} else {
		$bytes = '0 bytes';
	}

	return $bytes;
}

function getFrontendAsset($path, $root = false) {
	return ($root) ? asset('assets/frontend/' . $path) : asset('assets/frontend/dist/' . $path);
}

function getStorageAsset($path) {
	return asset('public/storage/uploads/' . $path);
}

function adminPrefix() {
	return \Config::get('app.admin_prefix') . '/';
}

function ap($path) {
	return \Config::get('app.admin_prefix') . '/' . $path;
}

function apa($path, $queryString = false) {
	$url = asset(\Config::get('app.admin_prefix') . '/' . $path);
	if ($queryString) {
		$qs = request()->query(); /* DONOT USE request()->all() , Will load post data too */
		if (count($qs)) {
			foreach ($qs as $key => $value) {
				$qs[$key] = sprintf('%s=%s', $key, urlencode($value));
			}
			$url = sprintf('%s?%s', $url, implode('&', $qs));
		}
	}
	return $url;
}

function get_admin_menu_active_class($currentURI, $slugArr) {

	$className = '';
	$listArr = $slugArr;
	if (!is_array($listArr)) {
		$listArr = [$slugArr];
	}

	$allQueryArr = request()->query();
	if ($allQueryArr) {
		foreach ($allQueryArr as $key => $val) {
			$str = $key . '=' . $val;
			$currentURI = str_replace($str, '', $currentURI);
		}
		$currentURI = str_replace('?', '', $currentURI);
	}

	$URLParts = explode("/", $currentURI);

	if (!empty($URLParts)) {
		foreach ($URLParts as $Uparts) {

			if (in_array($Uparts, $listArr)) {
				$className = 'active';
			}
		}
	}

	if (in_array('seo', $URLParts)) {
		return null;
	}

	return $className;
}

function getHumanReadbleFormat($date) {
	$instance = $date->diff(new DateTime(date('Y-m-d H:i:s')));
	$returnText = '';
	if ($instance->y > 0) {
		$returnText = $instance->y . ' ' . Lang::get('messages.years');
	} elseif ($instance->m > 0) {
		$returnText = $instance->m . ' ' . Lang::get('messages.months');
	} elseif ($instance->d > 0) {
		$returnText = $instance->d . ' ' . Lang::get('messages.days');
	} elseif ($instance->h > 0) {
		$returnText = $instance->h . ' ' . Lang::get('messages.hours');
	} elseif ($instance->i > 0) {
		$returnText = $instance->i . ' ' . Lang::get('messages.minutes');
	} elseif ($instance->s >= 0) {
		$returnText = $instance->s . ' ' . Lang::get('messages.seconds');
	}
	return $returnText;
}

function htmlAsset($fileName) {
	return asset('assets/frontend/dist/' . $fileName);
}

function lang($str) {

	if (!Lang::has('messages.' . $str)) {
       /*  Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/translationkey.log'),
        ])->info($str); */
		\Artisan::call('app:update-translation', ['message' => $str]);
    }
	
	$default = ucwords(str_replace('_', ' ', $str));
	return (Lang::has('messages.' . $str)) ? Lang::get('messages.' . $str) : $default;
}

function getCategoryWisePosts($postsCollections, $fieldName) {

	$splitedArray = [];
	foreach ($postsCollections as $post) {
		if (!empty($post->getData($fieldName))) {
			$splitedArray[$post->getData($fieldName)][] = $post;
		}
	}
	return $splitedArray;
}

function getGalleryItemsByType($galCollection, $type) {
	$filterArray = [];
	foreach ($galCollection as $galItem) {
		if ($galItem->gallery_image_type == 1) {
			$filterArray[] = $galItem;
		}
	}
	return $filterArray;
}
function youtubeImage($videoID) {
	return "//img.youtube.com/vi/" . $videoID . "/sddefault.jpg";
}
function youtubeEmbedUrl($videoID) {
	return "//www.youtube.com/embed/" . $videoID . "&autoplay=1&rel=0&controls=1&showinfo=1&loop=1&playlist=" . $videoID;
}

function getAgeFromDob($userDob) {
	//Create a DateTime object using the user's date of birth.
	$dob = new \DateTime($userDob);

	//We need to compare the user's date of birth with today's date.
	$now = new \DateTime();

	//Calculate the time difference between the two dates.
	$difference = $now->diff($dob);

	//Get the difference in years, as we are looking for the user's age.
	return $difference->y;
}

function getDaysFromInterval($fromDate, $toDate, $resultFormat = 'Y-m-d') {
	$res = array();

	try {

		$toDate = $toDate . ' 23:59:59';
		$intervalDays = new \DatePeriod(
			new \DateTime($fromDate),
			new \DateInterval('P1D'),
			new \DateTime($toDate)
		);

		$fromDate = \DateTime::createFromFormat($resultFormat, $fromDate);

		if (!empty($fromDate)) {
			$res[] = $fromDate->format($resultFormat);
		}

		foreach ($intervalDays as $day) {
			$res[] = $day->format($resultFormat);
		}

		$lastDate = \DateTime::createFromFormat($resultFormat, $toDate);

		if (!empty($lastDate)) {
			$res[] = $lastDate->format($resultFormat);
		}
	} catch (\Exception $ex) {
		return false;
	}
	return $res;
}

function _age($fomart = 'm/d/Y', $date = null) {
	$birthDate = date($format, strtotime($date));
	//explode the date to get month, day and year
	$birthDate =
		explode(
		"/",
		$birthDate
	);
	//get age from date or birthdate
	return $age =
		(date(
		"md",
		date(
			"U",
			mktime(
				0,
				0,
				0,
				$birthDate[0],
				$birthDate[1],
				$birthDate[2]
			)
		)
	) >
		date("md")
		? ((date("Y") -
			$birthDate[2]) -
			1)
		: (date("Y") -
			$birthDate[2]));
}

/*
The below function return day name and day of week as key
 */
function generateWeekDays($startDay = 'Sunday') {
	$timestamp = strtotime('next ' . $startDay);
	$days = array();
	for ($i = 0; $i < 7; $i++) {
		$dayName = strftime('%A', $timestamp);
		$days[date('w', $timestamp)] = $dayName;
		$timestamp = strtotime('+1 day', $timestamp);
	}
	return $days;
}

function getAdminStatusIcon($status, $link = '') {
	$iconStr = '<div data-status-url="' . $link . '" class="change-status az-toggle az-toggle-success ' . (($status == 1) ? "on" : "") . '"><span></span></div>';

	return $iconStr;
}

function getAdminActionIcons($buttons, $postType, $item) {

	$str = '<div class="btn-icon-list">';
	if ($buttons['edit'] || $buttons['delete']) {

		if ($buttons['edit']) {
			$url = apa('post/' . $postType . '/edit/' . $item->post_id, true);
			$str .= '<a  href="' . $url . '"  title="edit" class="btn btn-primary btn-icon"><i class="typcn typcn-edit"></i></a>';
		}
		if ($buttons['delete']) {
			$url = apa('post/' . $postType . '/delete/' . $item->post_id, true);
			$str .= '<a onclick="return confirm(' . lang('do_you_want_to_remove_this_item') . ')" class="deleteRecord btn btn-danger btn-icon" href="' . $url . '"  title="delete" ><i class="typcn typcn-trash"></i></a>';

		}

		$str .= '</div>';
	}
	return $str;
}

function displayAdminUploadedThumb($fieldVal, $path) {

	if (empty($fieldVal)) {
		return '';
	}

	return '<div class="admin-upload-thumb"><img src="' . asset($path . '/' . $fieldVal) . '"/></div>';
}

function is_between_times($startTime, $endTime, $timeToCheck) {
	return $timeToCheck->greaterThanOrEqualTo($startTime) && $timeToCheck->lessThan($endTime);
}

function urlWithQueryStr($path = null, $secure = null) {
	$url = app('url')->to($path, $secure);
	$qs = request()->all();
	if (count($qs)) {
		foreach ($qs as $key => $value) {
			$qs[$key] = sprintf('%s=%s', $key, urlencode($value));
		}
		$url = sprintf('%s?%s', $url, implode('&', $qs));
	}
	return $url;
}

function isFrontendUserLoggedIn() {
	if (Auth::user() && @Auth::user()->is_backend_user == 2) {
		return true;
	}
	return false;
}
function adjust_title_with_br($title, $lang, $removeThe = true) {
	if ($lang == 'en' && $removeThe == true) {
		$title = trim(str_replace('the', '', strtolower($title)));
	}
	$title = str_replace('|', '<br/>', $title);
	return $title;
}

function adjust_title_without_pipe($title, $lang, $removeThe = true) {
	if ($lang == 'en' && $removeThe == true) {
		$title = trim(str_replace('the', '', strtolower($title)));
	}
	$title = str_replace('|', '', $title);
	return $title;
}

function isDatePast($date) {
	return (strtotime(date('Y-m-d')) > strtotime(date('Y-m-d', strtotime($date))));
}

function getWebsiteLogo() {
	$logo = '';
	if (file_exists('./assets/frontend/dist/images/logo.svg')) {
		$logo = asset('assets/frontend/dist/images/logo.svg');
	} elseif (file_exists('./assets/frontend/dist/images/logo.png')) {
		$logo = asset('assets/frontend/dist/images/logo.png');
	} else {
		$logo = 'logo.svg';
	}
	return $logo;
}

function getResourceAttachmentPlUploadControl($label, $controlName, $allowedMimes = ['jpg', 'jpeg', 'png'], $uploadType = null, $btnLabel = 'Select File', $validationMsg = null, $required = false, $oldFileName = "", $resourceID = null) {
	$imagePreview = '';

	if (!empty($oldFileName) && File::exists('storage/app/post/uploads/' . $oldFileName) && $uploadType == "image") {
		$imagePreview = '<div class="uploadPreview"><div class="upImgWrapper"><span class="delUploadImage" data-name="' . $oldFileName . '"><i class="fa fa-times-circle"></i></span><img src="' . asset('storage/app/post/uploads/' . $oldFileName) . '" class="uploadPreview"/></div><div class="clearfix"></div></div>';
	} else {
		if (!empty($oldFileName) && File::exists('storage/app/post/uploads/' . $oldFileName)) {
			$imagePreview = '<div class="uploadPreview"><div class="upImgWrapper"><span class="delUploadImage" data-name="' . $oldFileName . '"><i class="fa fa-times-circle"></i></span><a target="_blank" href="' . asset('storage/app/post/uploads/' . $oldFileName) . '" class="uploadPreview">' . $oldFileName . '</a></div><div class="clearfix"></div></div>';
		}
	}

	if (empty($allowedMimes)) {
		$allowedMimes = ['jpg', 'jpeg', 'png'];
	}
	$controlHTML = '<label class = "fl-start">' . $label . '<em class = "mandatory">*</em></label>' . $imagePreview .
		'<div class = "uploadControlWrapper input_parent">' .
		'<input type = "file" class = "form-control custom_uploader" data-allowed="' . (implode(",", $allowedMimes)) . '" data-type="' . $uploadType . '" title = "' . $validationMsg . '" data-id="' . $resourceID . '" id = "' . $controlName . '_file" name = "' . $controlName . '_file" />' .
		'<div class = "choose">' .
		'<div class = "choose-btn">' . $btnLabel . '</div>' .
		'<div class = "choose-file uploadFileName"></div>' .
		'<div class = "uploadPercentage"></div>' .
		'<div class = "uploadProgressWrapper">' .
		'<div class = "uploadProgress" ></div>' .
		'</div>' .
		'</div>' .
		'</div>';
	return $controlHTML;
}

function showMediaItem($data) {


	switch ($data->pm_file_type) {
	case 'image/jpeg':
	case 'image/svg+xml':
	case 'image/png':
	case 'image/gif':
		if ($data->pm_media_type == 'video') {
			$dispElement = '<a data-fancybox rel="gallery" class="fancybox iframe" href="https://www.youtube.com/embed/' . $data->pm_name . '">';
			if (!empty($data->pm_file_hash)) {
				$dispElement .= '<img src="' . asset('storage/post/' . $data->pm_file_hash) . '" alt="" class="img-fluid imageCenter ">';
			} else {
				$dispElement .= '<img src="https://img.youtube.com/vi/' . $data->pm_name . '/hqdefault.jpg" alt="" class="img-fluid imageCenter ">';
			}
			$dispElement .= '<span class="far fa-play-circle playIcon"></span></a>';
		}else{
			$dispElement = '<a data-fancybox rel="gallery" class="fancybox" href="' . asset('storage/post/' . $data->pm_file_hash) . '"><img src="' . asset('storage/post/' . $data->pm_file_hash) . '" alt="" class="img-fluid imageCenter "></a>';
		}

		break;

	case 'application/pdf':
		$dispElement = '<span class="fa-stack fa-lg">' .
			'<i class="fa fa-square fa-stack-2x text-primary"></i>' .
			'<i class="fa fa-file-pdf fa-stack-1x fa-inverse"></i>' .
			'</span>';
		break;
	case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
		$dispElement = '<span class="fa-stack fa-lg">' .
			'<i class="fa fa-square fa-stack-2x text-primary"></i>' .
			'<i class="fa fa-file-word fa-stack-1x fa-inverse"></i>' .
			'</span>';
		break;
	default:

		if ($data->pm_media_type == 'video') {
			$dispElement = '<a data-fancybox rel="gallery" class="fancybox iframe" href="https://www.youtube.com/embed/' . $data->pm_name . '">';
			if (!empty($data->fileName)) {
				$dispElement .= '<img src="' . asset('storage/post/' . $data->pm_file_hash) . '" alt="" class="img-fluid imageCenter ">';
			} else {
				$dispElement .= '<img src="https://img.youtube.com/vi/' . $data->pm_name . '/hqdefault.jpg" alt="" class="img-fluid imageCenter ">';
			}
			$dispElement .= '<span class="far fa-play-circle playIcon"></span></a>';
		} else {
			$dispElement = '<span class="fa-stack fa-lg">' .
				'<i class="fa fa-square fa-stack-2x text-primary"></i>' .
				'<i class="fa fa-file fa-stack-1x fa-inverse"></i>' .
				'</span>';
		}
		break;
	}

	$inputName = ($data->pm_media_type == 'video') ? 'video' : 'gallery_file';

	$downloadButton = '';

	if ($data->pm_media_type == 'video' && empty($data->pm_extension)) {
		$downloadButton = '';
	} else {
		$downloadButton = '<a class="downloadImage asdsad" href="' . apa("post_media_download") . '/' . $data->pm_id . '">' .
			'<span><i class="fas fa-download "></i></span>' .
			'</a>';
	}

	return '<li  id="' . $data->pm_id . '" class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 custCardWrapper gallery-grid ' . (($data->pm_media_type == "video") ? " YTVideo " : '') . '">' .
	'<div class="card card-figure has-hoverable">' .
	'<div class="row topControls flex" style="padding:10px;">' .
	'<div class="col-sm-4">' .
	$downloadButton .
	'</div>' .
	'<div class="col-sm-4 text-center ytLang">' .
	'<div class="lang-dropdown">' .
	'<select data-id="' . $data->pm_id . '" name="mediaLang[]" class="cardLang">' .
	'<option value="">In Both</option>' .
	'<option ' . (($data->pm_lang == "ar") ? " selected " : "") . ' value="ar">Arabic</option>' .
	'<option ' . (($data->pm_lang == "en") ? " selected " : "") . ' value="en">English</option>' .
	'</select>' .
	'</div>' .
	'</div>' .
	'<div class="col-sm-4">' .
	'<a href="#" class="btn btn-reset text-muted delUploadImage" title="Delete" data-id="' . $data->pm_id . '">' .
	'<span class="fas fa-times-circle"></span>' .
	'</a>' .
	'</div>' .
	'</div>' .
	'<figcaption class="figure-caption source-text">' .
	'<div>' .
	'<input data-type="pm_source" data-id="' . $data->pm_id . '" type="text" class="form-control mediaInput source changeText" placeholder="Source English" value="' . $data->pm_source . '" name="source[]">' .
	'</div>' .
	'<div>' .
	'<input data-type="pm_source_arabic" data-id="' . $data->pm_id . '" type="text" class="form-control mediaInput sourceAR changeText" placeholder="Source Arabic" value="' . $data->pm_source_arabic . '"  dir="rtl" name="sourceAR[]">' .
	'</div>' .
	'</figcaption>' .
	'<figure class="figure">' .
	'<div class="figure-attachment adjustImage">' .

	'<input type="hidden" name="postMedia[' . $inputName . '][]" value="' . $data->pm_id . '">' .
	$dispElement .
	'</div>' .
	'</figure>' .
	'<figcaption class="figure-caption title-text">' .
	'<div>' .
	'<input data-type="pm_title" data-id="' . $data->pm_id . '" type="text" class="form-control engTitle changeText" placeholder="English Title" value="' . $data->pm_title . '" name="engTitle[]">' .
	'</div>' .
	'<div>' .
	'<input data-type="pm_title_arabic" data-id="' . $data->pm_id . '" type="text" class="form-control arTitle changeText"  placeholder="Arabic Title" value="' . $data->pm_title_arabic . '"  dir="rtl" name="arTitle[]">' .
		'</div>' .
		'</figcaption>' .
		'</div>' .
		'</li>';
}
function PPO($fileName) {

	$file = asset('assets/defaults/no-image.svg');

	if (empty($fileName)) {
		return $file;
	}
	$thumb = null;
	if (app("Jenssegers\Agent\Agent")->isMobile() || app("Jenssegers\Agent\Agent")->isTablet()) {
		$thumb = PT($fileName);
		if (!empty($thumb)) {
			return $thumb;
		}
	}

	if (Storage::disk('local')->has('/public/post/' . $fileName)) {
		$file = asset('storage/post/' . $fileName);
	}
	return $file;
}
function PP($fileName, $original = false) {

	$file = asset('assets/defaults/no-image.svg');

	if (empty($fileName)) {
		return $file;
	}
	$thumb = null;


	if (Storage::disk('local')->has('/public/post/large/' . $fileName) && $original == false) {
		$file = asset('storage/post/large/' . $fileName);
	} elseif (Storage::disk('local')->has('/public/post/' . $fileName)) {
		$file = asset('storage/post/' . $fileName);
	}
	return $file;
}

function PP_JPG($fileName, $folder = 'large') {

	$file = asset('assets/defaults/no-image.svg');

	if (empty($fileName)) {
		return $file;
	}

	if (Storage::disk('local')->has('/public/post/' . $folder . '/' . $fileName)) {
		$ext = pathinfo(storage_path('app/public/post/' . $folder . '/' . $fileName), PATHINFO_EXTENSION);
		$file = asset('storage/post/' . $folder . '/' . (str_replace('.' . $ext, '.jpg', $fileName)));
	}
	return $file;
}

function PP_PNG($fileName, $folder = 'large') {

	$file = asset('assets/defaults/no-image.svg');

	if (empty($fileName)) {
		return $file;
	}

	if (Storage::disk('local')->has('/public/post/' . $folder . '/' . $fileName)) {
		$ext = pathinfo(storage_path('app/public/post/' . $folder . '/' . $fileName), PATHINFO_EXTENSION);
		$file = asset('storage/post/' . $folder . '/' . (str_replace('.' . $ext, '.png', $fileName)));
	}
	return $file;
}

function PT($fileName) {
	$file = asset('assets/defaults/no-image.svg');

	if (Storage::disk('local')->has('/public/post/thumb/' . $fileName)) {
		$file = asset('storage/post/thumb/' . $fileName);
	} elseif (Storage::disk('local')->has('public/post/' . $fileName)) {
		$file = asset('storage/post/' . $fileName);
	}
	return $file;
}

function PL($lang, $slug) {
	return asset($lang . '/' . $slug);
}

function encloseWordSpan($sentence) {
	return '<span>' . implode('</span><span>', explode(' ', $sentence)) . '</span>';
}

function EXPL($tag, $content) {
	return explode($tag, $content);
}

function IMPL($tag, $content) {
	return explode($tag, $content);
}
function InnerLink($post) {
	$lang = App::getLocale();
	return asset($lang . '/' . $post->post_type . '/' . $post->post_slug);
}
function getEmbedCodeFromYoutubeURL($embedURL) {
	$src = '';
	$parse = parse_url($embedURL);
	if (empty($parse)) {
		return $embedURL;
	}

	switch ($parse['host']) {
	case 'youtube.com':
	case 'www.youtube.com':
	case 'youtu.be':
	case 'www.youtu.be':
	case 'ytimg.com':
	case 'www.ytimg.com':
		$videoID = getYoutubeVideoID($embedURL);
		$src = "https://www.youtube.com/embed/$videoID?rel=0";
		break;
	case 'vimeo.com':
	case 'www.vimeo.com':
		$videoID = getVimeoVideoID($embedURL);
		$src = "https://player.vimeo.com/video/$videoID?rel=0";

		break;
	default:

		$src = $embedURL;
		break;
	}

	return '<iframe width="100%" height="315" src="' . $src . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
}
function youtubeEmbedUrlFromUrl($url) {

	$videoID = '';
	if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $id)) {
		$videoID = $id[1];
	} elseif (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $id)) {
		$videoID = $id[1];
	} elseif (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/', $url, $id)) {
		$videoID = $id[1];
	} elseif (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $id)) {
		$videoID = $id[1];
	} elseif (preg_match('/youtube\.com\/verify_age\?next_url=\/watch%3Fv%3D([^\&\?\/]+)/', $url, $id)) {
		$videoID = $id[1];
	}

	return "//www.youtube.com/embed/" . $videoID . "?autoplay=1&rel=0&controls=1&showinfo=1&loop=1&playlist=" . $videoID;
}
function youtubeImageFromUrl($url) {
	$videoID = '';
	if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $id)) {
		$videoID = $id[1];
	} elseif (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $id)) {
		$videoID = $id[1];
	} elseif (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/', $url, $id)) {
		$videoID = $id[1];
	} elseif (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $id)) {
		$videoID = $id[1];
	} elseif (preg_match('/youtube\.com\/verify_age\?next_url=\/watch%3Fv%3D([^\&\?\/]+)/', $url, $id)) {
		$videoID = $id[1];
	}
	return "//img.youtube.com/vi/" . $videoID . "/sddefault.jpg";
}
function encryptString($string) {
	$password = "b27tgbsdadk90i293bajbjsdhbvuvgvabsvgvfyxaas9032";
	return openssl_encrypt($string, "AES-128-ECB", $password);
}

function decryptString($EncText) {
	$password = "b27tgbsdadk90i293bajbjsdhbvuvgvabsvgvfyxaas9032";
	return openssl_decrypt($EncText, "AES-128-ECB", $password);
}

function alphabetFilter() {
	$html = '<ul class="filter_alpha">';

	for ($i = 97; $i <= 122; $i++) {
		$active_class = ($i == 97) ? "active_" : "";
		$html .= '<li><a href="#" class="' . $active_class . '" title="Alphabets">' . chr($i) . '</a></li>';
	}

	$html .= '</ul>';
	return $html;
}

function padZeroesLeft($str, $count) {
	return str_pad($str, $count, '0', STR_PAD_LEFT);
}


function padZeroesRight($str, $count) {
	return str_pad($str, $count, '0', STR_PAD_RIGHT);
}

function curlImage($url) {
	$client = new \GuzzleHttp\Client(['defaults' => [
		'verify' => false,
	]]);
	$res = $client->get($url);
	$content = (string) $res->getBody();
	return $content;
}

function getStatusColor($classPrefix, $percentage) {
	$chartColor = "y";
	if ($percentage >= 75 && $percentage <= 100) {
		$chartColor = "g";
	} else if ($percentage >= 50 && $percentage <= 74) {
		$chartColor = "y";
	} else if ($percentage >= 0 && $percentage <= 49) {
		$chartColor = "r";
	}
	return $classPrefix . $chartColor;
}

function abbreviateNumber($num) {
	if ($num >= 0 && $num < 1000) {
		$format = floor($num);
		$suffix = '';
	} else if ($num >= 1000 && $num < 1000000) {
		// Thousand
		$format = floor($num / 1000);
		$suffix = 'K';
	} else if ($num >= 1000000 && $num < 1000000000) {
		// Million
		$format = floor($num / 1000000);
		$suffix = 'M';
	} else if ($num >= 1000000000 && $num < 1000000000000) {
		// Billion
		$format = floor($num / 1000000000);
		$suffix = 'B';
	} else if ($num >= 1000000000000) {
		// Trillion
		$format = floor($num / 1000000000000);
		$suffix = 'T';
	}

	return !empty($format . $suffix) ? $format . $suffix : 0;
}

function wordCount($str) {
	$wordCount = count(preg_split('/\s+/', $str));
	return $wordCount;
}
function webp($fileName) {

	$file = asset('assets/defaults/no-image.svg');
	if (empty($fileName)) {
		return $file;
	}
	$webpfile = explode('.', $fileName);
	$webpfileName = $webpfile[0] . '.webp';
	$thumb = null;
	if (Storage::disk('local')->has('/public/post/large/' . $webpfileName)) {
		$file = asset('storage/post/large/' . $webpfileName);
	} elseif (Storage::disk('local')->has('/public/post/' . $webpfileName)) {
		$file = asset('storage/post/' . $webpfileName);
	} elseif (Storage::disk('local')->has('/public/post/large/' . $fileName)) {
		$file = asset('storage/post/large/' . $fileName);
	} elseif (Storage::disk('local')->has('/public/post/' . $fileName)) {
		$file = asset('storage/post/' . $fileName);
	}

	return $file;
}
function webpT($fileName) {
	$file = asset('assets/defaults/no-image.svg');
	$webpfile = explode('.', $fileName);
	$webpfileName = $webpfile[0] . '.webp';
	if (Storage::disk('local')->has('/public/post/thumb/' . $webpfileName)) {
		$file = asset('storage/post/thumb/' . $webpfileName);
	} elseif (Storage::disk('local')->has('public/post/' . $webpfileName)) {
		$file = asset('storage/post/' . $webpfileName);
	} elseif (Storage::disk('local')->has('/public/post/large/' . $fileName)) {
		$file = asset('storage/post/large/' . $fileName);
	} elseif (Storage::disk('local')->has($fileName)) {
		$file = asset('storage/' . $fileName);
	}
	return $file;
}
function FT($file) {
	return pathinfo($file, PATHINFO_EXTENSION);
}
function DTFM($returnVal) {

	$date = "";

	if (!empty($returnVal)) {
		$month = strtolower(date('M', strtotime($returnVal)));
		$date = date('d ', strtotime($returnVal)) . " " . lang($month) . " " . date('Y', strtotime($returnVal));
	}

	return $date;
}
function DTMY($returnVal) {

	$date = "";

	if (!empty($returnVal)) {
		$month = strtolower(date('M', strtotime($returnVal)));
		$date = lang($month) . " " . date('Y', strtotime($returnVal));
	}

	return $date;
}

function RT($name, $param) {
	if (Route::has($name)) {
		return route($name, $param);
	} else {
		return '#';
	}
}
function YT($url) {

	$videoID = '';
	if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $id)) {
		$videoID = $id[1];
	} elseif (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $id)) {
		$videoID = $id[1];
	} elseif (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/', $url, $id)) {
		$videoID = $id[1];
	} elseif (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $id)) {
		$videoID = $id[1];
	} elseif (preg_match('/youtube\.com\/verify_age\?next_url=\/watch%3Fv%3D([^\&\?\/]+)/', $url, $id)) {
		$videoID = $id[1];
	}

	return "//www.youtube.com/embed/" . $videoID . "?autoplay=1&rel=0&controls=1&showinfo=1&loop=1&playlist=" . $videoID;
}

function formatDateTimeString($dateTime, $specs = ['l', 'j', 'F', 'Y']) {
	$dateSpecs = $specs;

	$dateArr = [];

	foreach ($dateSpecs as $spec) {

		// Add suffix for english dates only
		if ($spec == 'j' && \App::getLocale() == 'en') {
			$spec = 'jS';
		}

		$dateArr[] = \Carbon\Carbon::parse($dateTime)->format($spec);
	}

	switch (count($specs)) {
	case '2':
		$dateString = lang(strtolower($dateArr[0])) . ' ' . $dateArr[1];
		break;

	case '3':
		$dateString = $dateArr[0] . ' ' . lang(strtolower($dateArr[1])) . ' ' . $dateArr[2];
		break;

	default:
		$dateString = lang(strtolower($dateArr[0])) . ' ' . $dateArr[1] . ' ' . lang(strtolower($dateArr[2])) . ' ' . $dateArr[3];
		break;
	}

	return $dateString;
}

// Similar to Python's Zip function
function array_zip(...$arrays) {
	$result = [];
	$args = array_map('array_values', $arrays);
	$min = min(array_map('count', $args));
	for ($i = 0; $i < $min; ++$i) {
		$result[$i] = [];
		foreach ($args as $j => $arr) {
			if (!empty($arr)) {
				$result[$i][$j] = $arr[$i];
			}
		}
	}
	return $result;
}
function galleryItem($data,$inputName) {


	switch ($data->pm_file_type) {
	case 'image/jpeg':
	case 'image/svg+xml':
	case 'image/png':
	case 'image/gif':
		$dispElement = '<a data-fancybox rel="gallery" class="fancybox" href="' . asset('storage/post/' . $data->pm_file_hash) . '"><img src="' . asset('storage/post/' . $data->pm_file_hash) . '" alt="" class="img-fluid imageCenter "></a>';
		break;

	case 'application/pdf':
		$dispElement = '<span class="fa-stack fa-lg">' .
			'<i class="fa fa-square fa-stack-2x text-primary"></i>' .
			'<i class="fa fa-file-pdf fa-stack-1x fa-inverse"></i>' .
			'</span>';
		break;
	case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
		$dispElement = '<span class="fa-stack fa-lg">' .
			'<i class="fa fa-square fa-stack-2x text-primary"></i>' .
			'<i class="fa fa-file-word fa-stack-1x fa-inverse"></i>' .
			'</span>';
		break;
	default:

		if ($data->pm_media_type == 'video') {
			$dispElement = '<a data-fancybox rel="gallery" class="fancybox iframe" href="https://www.youtube.com/embed/' . $data->pm_name . '">';
			if (!empty($data->fileName)) {
				$dispElement .= '<img src="' . asset('storage/post/' . $data->pm_file_hash) . '" alt="" class="img-fluid imageCenter ">';
			} else {
				$dispElement .= '<img src="https://img.youtube.com/vi/' . $data->pm_name . '/hqdefault.jpg" alt="" class="img-fluid imageCenter ">';
			}
			$dispElement .= '<span class="far fa-play-circle playIcon"></span></a>';
		} else {
			$dispElement = '<span class="fa-stack fa-lg">' .
				'<i class="fa fa-square fa-stack-2x text-primary"></i>' .
				'<i class="fa fa-file fa-stack-1x fa-inverse"></i>' .
				'</span>';
		}
		break;
	}



	$downloadButton = '';

	if ($data->pm_media_type == 'video' && empty($data->pm_extension)) {
		$downloadButton = '';
	} else {
		$downloadButton = '<a class="downloadImage asdsad" href="' . apa("post_media_download") . '/' . $data->pm_id . '">' .
			'<span><i class="fas fa-download "></i></span>' .
			'</a>';
	}

	return '<li  id="' . $data->pm_id . '" class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 custCardWrapper' . (($data->pm_media_type == "video") ? " YTVideo " : '') . '">' .
	'<div class="card card-figure has-hoverable">' .
	'<div class="row topControls flex" style="padding:10px;">' .
	'<div class="col-sm-4">' .
	$downloadButton .
	'</div>' .
	'<div class="col-sm-4 text-center ytLang">' .
	'<select data-id="' . $data->pm_id . '" name="mediaLang[]" class="cardLang">' .
	'<option value="">In Both</option>' .
	'<option ' . (($data->pm_lang == "ar") ? " selected " : "") . ' value="ar">Arabic</option>' .
	'<option ' . (($data->pm_lang == "en") ? " selected " : "") . ' value="en">English</option>' .
	'</select>' .
	'</div>' .
	'<div class="col-sm-4">' .
	'<a href="#" class="btn btn-reset text-muted delUploadImage" title="Delete" data-id="' . $data->pm_id . '">' .
	'<span class="fas fa-times-circle"></span>' .
	'</a>' .
	'</div>' .
	'</div>' .
	'<figcaption class="figure-caption">' .
	'<div>' .
	'<input data-type="pm_source" data-id="' . $data->pm_id . '" type="text" class="form-control mediaInput source changeText" placeholder="Source English" value="' . $data->pm_source . '" name="source[]">' .
	'</div>' .
	'<div>' .
	'<input data-type="pm_source_arabic" data-id="' . $data->pm_id . '" type="text" class="form-control mediaInput sourceAR changeText" placeholder="Source Arabic" value="' . $data->pm_source_arabic . '"  dir="rtl" name="sourceAR[]">' .
	'</div>' .
	'</figcaption>' .
	'<figure class="figure">' .
	'<div class="figure-attachment adjustImage">' .

	'<input type="hidden" name="postMedia[' . $inputName . '][]" value="' . $data->pm_id . '">' .
	$dispElement .
	'</div>' .
	'</figure>' .
	'<figcaption class="figure-caption">' .
	'<div>' .
	'<input data-type="pm_title" data-id="' . $data->pm_id . '" type="text" class="form-control engTitle changeText" placeholder="English Title" value="' . $data->pm_title . '" name="engTitle[]">' .
	'</div>' .
	'<div>' .
	'<input data-type="pm_title_arabic" data-id="' . $data->pm_id . '" type="text" class="form-control arTitle changeText"  placeholder="Arabic Title" value="' . $data->pm_title_arabic . '"  dir="rtl" name="arTitle[]">' .
		'</div>' .
		'</figcaption>' .
		'</div>' .
		'</li>';
}
function ul_to_array ($ul) {
	$xml = new DOMDocument();
	$xml->loadHTML($ul);
    $result = [];
	$lang = App::getLocale();
	foreach($xml->getElementsByTagName('li') as $li){
		$text=strip_tags($li->textContent);

		if($lang=="ar"){
			$result[]=utf8_decode(trim($text));
		}else{
            $result[]=trim($text);
		}

	}
    return $result;

  }
function checkFileOrNot($filename)
{
      $extension= pathinfo($filename, PATHINFO_EXTENSION);

      switch ($extension) {
            case 'jpeg':
            case 'jpg':
            case 'png':
            case 'svg':
            case 'gif':
            case 'bmp':
            case 'webp':
            case 'pdf':
            case 'docx':
            case 'doc':
            case 'xls':
            case 'xlsx':
            case 'odt':
                return true;
            break;
            default:
                return false;
            break;
      }

}
