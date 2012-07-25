<?php 
include('simple_html_dom.php');

$username=$_REQUEST['username'];
$password=$_REQUEST['password'];
$link = $_REQUEST['link'];

$url="https://vula.uct.ac.za/";
$cookie="cookie.txt";

$postdata = "eid=". $username ."&pw=". $password ."&submit=submit";

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

curl_setopt ($ch, CURLOPT_URL, $link);	
$result = curl_exec ($ch);

$html = str_get_html($result);

echo $result;
?>
