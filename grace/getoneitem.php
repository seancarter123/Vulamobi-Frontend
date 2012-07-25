<?php
include('simple_html_dom.php');
ini_set('display_errors', 1);
$username=$_REQUEST['username'];
$password=$_REQUEST['password'];

if($username==null || $password==null)
{
	echo "null username and password";
	die();
}
$item=$_REQUEST['item'];

$items = array();

$url="https://vula.uct.ac.za/";
$cookie="cookie.txt";
$postdata = "eid=". $username ."&pw=". $password ."&submit=submit";


$name = split("/", $item);
$newname = end( $name );
$newname = str_replace(' ', '+', $newname);

$newname = strtoupper($newname);

//header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.$newname.'"');
//header('Content-Transfer-Encoding: binary');
//header('Expires: 0');
//header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
//header('Pragma: public');


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

curl_setopt ($ch, CURLOPT_BINARYTRANSFER, 1);
curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 0);
curl_setopt ($ch, CURLOPT_URL, $item);

$result2 = curl_exec ($ch);
//$resultStatus = curl_getinfo($ch);

/*if($resultStatus != 200)
{
	echo $item;
	echo "fail" . $resultStatus;
	die();
}
*/

//echo $result;

$fh = fopen("temp/" . $newname,'w');
fwrite($fh,$result2);
fclose($fh);

//echo "<a href='temp/".$newname."'>download</a>'";
?>
