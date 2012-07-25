<?php
include('simple_html_dom.php');
session_start();
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
$url = $_REQUEST['url'];
$linecount = $_REQUEST['linecount'];

$ch = curl_init();
curl_setopt ($ch, CURLOPT_URL, $url);
curl_setopt ($ch, CURLOPT_COOKIEFILE, "temp/$username.txt"); 
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec ($ch);
	
$array = explode("\n", $result);

//echo $result;

//if ( $linecount < count($array) )
//{
	echo "<div style='display: none' id='linecount'>".count($array)."</div>";
	
	//get the url for the resources and go to it
	$html = str_get_html($result);

	echo "<div style='display: none' id='refresherl'>$url</div>";
	
	$position = strripos($url,"?",-1);
	$iframeurl = substr($url,0,$position). '/room';
	curl_setopt ($ch, CURLOPT_URL, $iframeurl);
	curl_setopt ($ch, CURLOPT_COOKIEFILE, "temp/$username.txt"); 
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec ($ch);

	$html = str_get_html($result);
	//echo $result;

	if(($text = $html->find('div[id=chatListWrapper]',0)->innertext) != null)
	{
		echo $text;
	}
	if(($text = $html->find('textarea[name=controlPanel:message]',0)->innertext) != null)
	{
		echo $text;
	}
	if(($text = $html->find('input[id=topForm:chatidhidden]',0)->value) != null)
	{
		echo "<div style='display: none' id='thekoi'>" . $text . "</div>";
	}	
/*}
else
{
	echo -1;
}*/
?>
