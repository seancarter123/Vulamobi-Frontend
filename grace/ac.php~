<?php
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
$url="https://vula.uct.ac.za/direct/site.xml";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

$response = curl_exec($curl);
$resultStatus = curl_getinfo($curl);

$array= explode("\n", $response);
if(count($array) > 5)
{
	echo "1";
}
else
{
	echo "-1";
}

$postdata = "eid=". $username ."&pw=". $password ."&submit=submit";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://vula.uct.ac.za/portal/relogin");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($ch, CURLOPT_COOKIEJAR, "temp/$username.txt");
curl_setopt($ch, CURLOPT_COOKIEFILE, "temp/$username.txt");
curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata);
curl_setopt ($ch, CURLOPT_POST, 1);
$result = curl_exec ($ch);
$info = curl_getinfo($ch);
curl_close($ch);

?>
