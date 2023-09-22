<?php
function get_user_membership(){

	$ci = &get_instance();
	$user=$ci->session->userdata("user_session");
	$membership =  $user['product'];
	if($membership == 2){
		$classes = 2;
	}elseif($membership == 3){
		$classes = 6;
	}
	return $classes;

}


function get_membership_shortcuts(){

	$ci = &get_instance();
	$user=$ci->session->userdata("user_session");
	$membership =  $user['product'];
	if($membership == 2){
		$shortcuts = 5;
	}elseif($membership == 3){
		$shortcuts = 20;
	}
	return $shortcuts;

}


function get_count_messages(){
	$ci = &get_instance();
	$user = $ci->session->userdata("user_session");
	$membership =  $user['product'];
	if($membership == 2){
		$limit = 5;
	}elseif($membership == 3){
		$limit = 20;
	}
	return $limit;
}



function get_user_id(){


	$ci = &get_instance();
	$user=$ci->session->userdata("user_session");
	return $user['user_id'];

}


function get_teacher_id(){


	$CI =& get_instance();
	$user = $CI->session->userdata("user_session");
	$CI->load->model('crud_model');
	$teacher = $CI->crud_model->get('teacher',array('teacher_id' => (int)$user['user_id']));
	return $teacher[0]['_id'];

}

function get_teacher_name(){
	$CI =& get_instance();
	$user = $CI->session->userdata("user_session");
	$CI->load->model('crud_model');
	$teacher = $CI->crud_model->get('teacher',array('teacher_id' => (int)$user['user_id']));
	return $teacher[0]['teacher_full_name'];
}


function searchForValue($value, $array, $arrayValue) {
   foreach ($array as $key => $val) {
       if ($val[$arrayValue] === $value) {
           return $value;
       }
   }
   return null;
}
	



function get_user_name(){

	$ci = &get_instance();
	$user=$ci->session->userdata("user_session");
	return $user['login'];

}



function student_info($id)
{	
	$where['_id'] = new MongoDB\BSON\ObjectID($id);
	$CI =& get_instance();
	$data = $CI->crud_model->get('student',$where);
	return $data[0];

}

function is_user_logged_in(){

	$ci = &get_instance();

	if (!empty($ci->session->userdata('user_session'))) {

		return true;
	}
	return false;
}
function filter_data($data = array(), $remove_empty = false)
{
	if(!empty($data))
	{
		foreach($data as $key => $val )
		{
			if($val == NULL)
			{
				$data[$key] = '';
			}
			if($remove_empty && $data[$key] == '')
				unset($data[$key]);
		}
	}
	return $data;
}

/** 
* Helper function to print array in pre-formated form
* 
* @param array
* @param bool
* @return print array
*/
function debug($arr, $exit = false)
{
	print "<pre>";
	print_r($arr);
	print "</pre>";
	if($exit)
		exit;
}

/** 
* Helper function to print string in pre-formated form
* 
* @param string
* @param bool
* @return print string
*/
function echo_str($str, $exit = false)
{
	echo $str;
	echo "<br />";
	if($exit)
		exit;
}


/** 
* Helper function to ramdom letters
* 
* @param Int
* @return string
*/	
function get_rand_letters($length)
{
	if($length>0) 
	{ 
		$rand_id="";
		for($i=1; $i<=$length; $i++)
		{
			mt_srand((double)microtime() * 1000000);
			$num = mt_rand(1,26);
			$rand_id .= assign_rand_value($num);
		}
	}
	return $rand_id;
}

function alphanumeric($lenght)
{
	$string = random_string('alnum',$lenght);
	$string = str_replace('I', 'X', $string); 
	$string = str_replace('l', 'X', $string); 
	$string = str_replace('O', 'X', $string); 
	$string = str_replace('0', 'X', $string); 
	return $string;
}


function randomNumber($length) {
    $result = '';

    for($i = 0; $i < $length; $i++) {
        $result .= mt_rand(0, 9);
    }

    return $result;
}
/** 
* Helper function to get random value
* 
* @param Int
* @return string
*/		
function assign_rand_value($num)
{	
	// accepts 1 - 36
	switch($num)
	{
		case "1":
		$rand_value = "a";
		break;
		case "2":
		$rand_value = "b";
		break;
		case "3":
		$rand_value = "c";
		break;
		case "4":
		$rand_value = "d";
		break;
		case "5":
		$rand_value = "e";
		break;
		case "6":
		$rand_value = "f";
		break;
		case "7":
		$rand_value = "g";
		break;
		case "8":
		$rand_value = "h";
		break;
		case "9":
		$rand_value = "i";
		break;
		case "10":
		$rand_value = "j";
		break;
		case "11":
		$rand_value = "k";
		break;
		case "12":
		$rand_value = "l";
		break;
		case "13":
		$rand_value = "m";
		break;
		case "14":
		$rand_value = "n";
		break;
		case "15":
		$rand_value = "o";
		break;
		case "16":
		$rand_value = "p";
		break;
		case "17":
		$rand_value = "q";
		break;
		case "18":
		$rand_value = "r";
		break;
		case "19":
		$rand_value = "s";
		break;
		case "20":
		$rand_value = "t";
		break;
		case "21":
		$rand_value = "u";
		break;
		case "22":
		$rand_value = "v";
		break;
		case "23":
		$rand_value = "w";
		break;
		case "24":
		$rand_value = "x";
		break;
		case "25":
		$rand_value = "y";
		break;
		case "26":
		$rand_value = "z";
		break;
		case "27":
		$rand_value = "0";
		break;
		case "28":
		$rand_value = "1";
		break;
		case "29":
		$rand_value = "2";
		break;
		case "30":
		$rand_value = "3";
		break;
		case "31":
		$rand_value = "4";
		break;
		case "32":
		$rand_value = "5";
		break;
		case "33":
		$rand_value = "6";
		break;
		case "34":
		$rand_value = "7";
		break;
		case "35":
		$rand_value = "8";
		break;
		case "36":
		$rand_value = "9";
		break;
	}
	return $rand_value;
}



/** 
* Helper function to send a curl call
* 
* @param str
* @return str
*/
function send_request($url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0); // no headers in the output
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // output to variable
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 	1);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
} 	

/** 
* Helper function to send email
* 
* @param str
* @param str
* @param str
* @param str
* @param str
* @return int
*/
function send_html_email ($to_email, $from_email, $from_name, $subject, $msg) {
    //split up to email array, if given
	if (is_array($to_email)) {
		$to_email_string = implode(', ', $to_email);
	}
	else {
		$to_email_string = $to_email;
	}

    //Assemble headers
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: $from_name <$from_email>" . "\r\n";

    //send via PHP's mail() function
	return mail($to_email_string, $subject, $msg, $headers);
}

/** 
* Helper function to check file if allowed
* 
* @param array
* @return array
*/
function checkfile($input)
{
   //Check the file is of correct format. function checkfile($input){
	$ext = array('mpg', 'wma', 'mov', 'flv', 'mp4', 'mp3', 'avi', 'qt', 'wmv', 'rm');
	$extfile = substr($input['name'],-4);
	$extfile = explode('.',$extfile);
	$good = array();
	$extfile = $extfile[1];
	if (in_array($extfile, $ext)) 
	{
		$good['safe'] = true;
		$good['ext'] = $extfile;
	}
	else 
	{
		$good['safe'] = false;
	}
	return $good;
}

/** 
* Helper function to make plural string
* 
* @param int
* @return str
*/
if(!function_exists('pluralize'))
{
	function pluralize($num)
	{
		if ((int)$num != 1)
			return "s";
	}
}

/** 
* Helper function to get Relative time
* 
* @param Date Time
* @param bool
* @return print
*/
if(!function_exists('getRelativeTime'))
{
	function getRelativeTime($date)
	{
		$diff = time() - strtotime($date);

		if ($diff < 10)
			return "just now";
		else if ($diff < 60)
			return "just now";

		$diff = round($diff / 60);
		if ($diff < 60)
			return $diff . " min". pluralize($diff) ." ago";
		$diff = round($diff / 60);
		if ($diff < 24)
			return $diff . " hour" . pluralize($diff) . " ago";
		$diff = round($diff / 24);
		if ($diff == 1)
		{
			return "yesterday";
		}
		elseif($diff < 7 )
		{
			return $diff . " day" . pluralize($diff) . " ago";
		}
		$days = $diff; 
		$diff = round($diff / 7);
		if ($diff < 5)
		{
			return $diff . " week" . pluralize($diff) . " ago";
		}
		if($days < 30)
		{
			return "1 month" . pluralize($diff) . " ago";
		}
		$diff = round($days / 30);
		if($diff < 12 )
		{
			return $diff . " month" . pluralize($diff) . " ago";
		}
		$diff = round($diff / 12);
		return $diff . " year" . pluralize($diff) . " ago";
		
	}
}
/** 
* Helper function to get exercise completion time in mints/hours format
* 
* @param Date Time
* @param bool
* @return print
*/
if(!function_exists('getExerciseCompletionTime'))
{
	function getExerciseCompletionTime($start_time, $end_time)
	{
		$start_time = strtotime($start_time);
		$end_time = strtotime($end_time);
		
                //$diff = time() - strtotime($date);
		$diff = $end_time - $start_time;

		if ($diff < 10)
			return "just now";
		else if ($diff < 60)
			return "just now";

		$diff = round($diff / 60);
		if ($diff < 60)
			return $diff . " min". pluralize($diff) ." ago";
		$diff = round($diff / 60);
		if ($diff < 24)
			return $diff . " hour" . pluralize($diff) . " ago";
		$diff = round($diff / 24);
		if ($diff == 1)
		{
			return "yesterday";
		}
		elseif($diff < 7 )
		{
			return $diff . " day" . pluralize($diff) . " ago";
		}
		$days = $diff; 
		$diff = round($diff / 7);
		if ($diff < 5)
		{
			return $diff . " week" . pluralize($diff) . " ago";
		}
		if($days < 30)
		{
			return "1 month" . pluralize($diff) . " ago";
		}
		$diff = round($days / 30);
		if($diff < 12 )
		{
			return $diff . " month" . pluralize($diff) . " ago";
		}
		$diff = round($diff / 12);
		return $diff . " year" . pluralize($diff) . " ago";
		
	}
}


/** 
* Helper Function to get current date and time
* 
* @access 	public 
* @return	Date and Time String
*/
function current_date_time()
{
	return date('Y-m-d H:i:s');
}

/** 
* Helper Function to get current date and time
* 
* @access 	public 
* @return	Date and Time String
*/
function formated_date($mysql_date_time = '', $format = 'd M Y')
{
	
	if(!empty($mysql_date_time))
		return date($format, strtotime($mysql_date_time));
	else
		return date('Y-m-d H:i:s');
}

/** 
* Helper Function to get mysql date and time
* 
* @access 	public 
* @return	Date and Time String
*/
function mysql_date_time($date_time)
{
	if(trim($date_time) == '')
	{
		return true;
	}
	$date_elements = explode('/', $date_time);
	if(!isset($date_elements[2]))
		echo $date_time;
	$time_elements = explode(' ', $date_elements[2]);
	if(!isset($time_elements[1]) || empty($time_elements[1]))
		$time_elements[1] = '00:00:00';
	$msql_date_time =trim($time_elements[0]).'-'.$date_elements[1].'-'.$date_elements[0].' '.trim($time_elements[1]);
	return date('Y-m-d H:i:s', strtotime($msql_date_time));
}

/** 
* Helper Function to get extension of file
* 
* @access 	public 
* @return	string
*/
function get_extension($filename)
{
	return $ext = strtolower(array_pop(explode('.',$filename)));
}

/** 
* Helper Function to get mime type of file
* 
* @access 	public 
* @return	string
*/
if(!function_exists('mime_content_type')) {

	function mime_content_type($filename) {

		$mime_types = array(

			'txt' => 'text/plain',
			'htm' => 'text/html',
			'html' => 'text/html',
			'php' => 'text/html',
			'css' => 'text/css',
			'js' => 'application/javascript',
			'json' => 'application/json',
			'xml' => 'application/xml',
			'swf' => 'application/x-shockwave-flash',
			'flv' => 'video/x-flv',

            // images
			'png' => 'image/png',
			'jpe' => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'jpg' => 'image/jpeg',
			'gif' => 'image/gif',
			'bmp' => 'image/bmp',
			'ico' => 'image/vnd.microsoft.icon',
			'tiff' => 'image/tiff',
			'tif' => 'image/tiff',
			'svg' => 'image/svg+xml',
			'svgz' => 'image/svg+xml',

            // archives
			'zip' => 'application/zip',
			'rar' => 'application/x-rar-compressed',
			'exe' => 'application/x-msdownload',
			'msi' => 'application/x-msdownload',
			'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
			'mp3' => 'audio/mpeg',
			'qt' => 'video/quicktime',
			'mov' => 'video/quicktime',

            // adobe
			'pdf' => 'application/pdf',
			'psd' => 'image/vnd.adobe.photoshop',
			'ai' => 'application/postscript',
			'eps' => 'application/postscript',
			'ps' => 'application/postscript',

            // ms office
			'doc' => 'application/msword',
			'rtf' => 'application/rtf',
			'xls' => 'application/vnd.ms-excel',
			'ppt' => 'application/vnd.ms-powerpoint',

            // open office
			'odt' => 'application/vnd.oasis.opendocument.text',
			'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
		);

		$ext = get_extension($filename);
		if (array_key_exists($ext, $mime_types)) {
			return $mime_types[$ext];
		}
		elseif (function_exists('finfo_open')) {
			$finfo = finfo_open(FILEINFO_MIME);
			$mimetype = finfo_file($finfo, $filename);
			finfo_close($finfo);
			return $mimetype;
		}
		else {
			return 'application/octet-stream';
		}
	}
}

/** 
* Helper Function to upload file
* 
* @param string
* @param string
* @param array
* @param Int
* @return	array
*/
function sfs_upload_file($file_field_name, $upload_dir, $allowed_types = array(), $max_file_sieze = '10240') 
{
	$that =& get_instance();
	$file_name = $_FILES[$file_field_name]['name'];
	$ext  =  get_extension($file_name);
	//echo $ext; 
	if(!empty($allowed_types) && !in_array($ext, $allowed_types))
	{
		return 'File type you are uploading is not allowed.';
	}
	
	$config['upload_path'] 		= $upload_dir;
	$config['allowed_types'] 	= '*';
	$config['max_size'] 		= $max_file_sieze;
	$that->load->library('upload', $config);
	if (!$that->upload->do_upload($file_field_name))
	{
		return $that->upload->display_errors();
	}
	else
	{
		return $that->upload->data();
	}
}



/** 
* Helper Function to get clean Url by string
* 
* @param string
* @return string
*/
function clean_url($string)
{
	$url = str_replace("'", '', $string);
	$url = str_replace('%20', ' ', $url);
	$url = preg_replace('~[^\\pL0-9_]+~u', '-', $url); // substitutes anything but letters, numbers and '_' with separator
	$url = trim($url, "-");
	$url = iconv("utf-8", "us-ascii//TRANSLIT", $url);  // you may opt for your own custom character map for encoding.
	$url = strtolower($url);
	$url = preg_replace('~[^-a-z0-9_]+~', '', $url); // keep only letters, numbers, '_' and separator
	return $url;
}


function implodeAssoc($glue,$arr,$key,$quot=null) 
{ 
	$tempArr = array();
	foreach($arr as $val){
		if($quot!==null)
			$tempArr[]='"'.$val[$key].'"';
		else
			$tempArr[]=$val[$key];
	}
	$values=array_values($tempArr); 
	return(implode($glue,$values)); 
} 


 function slugify($text)
 {
  // replace non letter or digits by -
 	$text = preg_replace('~[^\pL\d]+~u', '-', $text);

  // transliterate
 	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
 	$text = preg_replace('~[^-\w]+~', '', $text);

  // trim
 	$text = trim($text, '-');

  // remove duplicate -
 	$text = preg_replace('~-+~', '-', $text);

  // lowercase
 	$text = strtolower($text);

 	if (empty($text)) {
 		return 'n-a';
 	}

 	return $text;
 }


function create_slug($string)
{
	$slug = slugify($string);
	$CI =& get_instance();
	$CI->load->model('Products_model');
	$slug_array= $CI->Products_model->check_slug($slug,'product_slug');

	if(count($slug_array) > 0)
	{
		$_array = array();
		foreach ($slug_array as $_slug)
		{
			$_array[] = $_slug['product_slug'];
		}
		if(in_array($slug, $_array))
		{
			$apend = 0;
			while(in_array(($slug.'-'.++$apend), $_array));
			$slug = $slug.'-'.$apend;
		}
		return $slug;
	}
	else
	{
		return $slug;
	}

}


function class_info($id)
{	
	$where['_id'] = new MongoDB\BSON\ObjectID($id);
	$CI =& get_instance();
	$data = $CI->crud_model->get('class',$where);
	if(!empty($data)){
		return $data[0];
	}else{
		return array();
	}
	
}	




function class_info_teacher($id)
{	

	
	$CI =& get_instance();
	$user = $CI->session->userdata("user_session");
	$teacher = $CI->crud_model->get('teacher',array("teacher_id"=>$user['user_id']));
	$logged_in_teacher_classes = $teacher[0]['array_classes'];


	if(in_array($id, $logged_in_teacher_classes)){
		$where['_id'] = new MongoDB\BSON\ObjectID($id);
		$data = $CI->crud_model->get('class',$where);
		if(!empty($data)){
			return $data[0];
		}else{
			return array();
		}
	}else{
		return array();
	}

	
}	



?>