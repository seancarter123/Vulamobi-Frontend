<?php
include('simple_html_dom.php');

$username=$_REQUEST['username'];
$password=$_REQUEST['password'];
$folderid=$_REQUEST['folderid'];

$items = array();

$url="https://vula.uct.ac.za/";
$cookie="cookie.txt";
$postdata = "eid=". $username ."&pw=". $password ."&submit=submit";


//login and get cookie.. yum
$ch = curl_init();
curl_setopt ($ch, CURLOPT_URL, $url . "portal/relogin");
curl_setopt ($ch, CURLOPT_COOKIEFILE, '');
curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_COOKIEJAR, $cookie);
curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata);
curl_setopt ($ch, CURLOPT_POST, 1);
$result = curl_exec ($ch);


//go to the specific folder
curl_setopt ($ch, CURLOPT_URL, $folderid);	
$result = curl_exec ($ch);

//echo $result;

//get the url for the resources and go to it
$html = str_get_html($result);

$position = strripos($folderid,"/",-3);
//echo $folderid;
$newfolderid = substr($folderid,0,$position);
//echo $newfolderid;

echo '<div id="' . $newfolderid . '/' .'" class="folder" style="background-color:#D3c9bb; margin-top: 5px; overflow: hidden; padding: 5px;" onclick="folderSelected($(this).attr(\'id\'))">Up one folder</div>';

if($html == null)
{
	echo "null";
	die();
}

foreach($html->find('li') as $element)
{
	if($element->class == "folder")
	{	
		$foldername = $folderid . $element->find('a',0)->href;
		echo '<div id="' . $foldername .'" class="folder" style="background-color:#C3D9aa; margin-top: 5px; overflow: hidden; padding: 5px;" onclick="folderSelected($(this).attr(\'id\'))">' . $element->find('a',0)->plaintext . '</div>';
	}
	if($element->class == "file")
	{
		$filename = $folderid . $element->find('a',0)->href;
		echo '<div id="' . $filename .'" class="resource" style="background-color:#C2D1FF; margin-top: 5px; overflow: hidden; padding: 5px;" onclick="resourceSelected($(this).attr(\'id\'))">' . $element->find('a',0)->plaintext . '</div>';
	}
}
?>
