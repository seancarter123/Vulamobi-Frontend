<?php
session_start();
include('simple_html_dom.php');

$username=$_REQUEST['username'];
$password=$_REQUEST['password'];
$courseid=$_REQUEST['courseid'];

$items = array();

$url="https://vula.uct.ac.za/";
$cookie=$username;
$postdata = "eid=". $username ."&pw=". $password ."&submit=submit";

$ch = curl_init();
$tempurl = "https://vula.uct.ac.za/portal/site/". $courseid;
curl_setopt ($ch, CURLOPT_URL, $tempurl);
curl_setopt ($ch, CURLOPT_COOKIEFILE, "temp/$username.txt"); 
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec ($ch);	

//get the url for the resources and go to it
$html = str_get_html($result);
//echo $result;

if(($recurl = $html->find('a[class=icon-sakai-chat]',0)->href)!=null)
{
	curl_setopt ($ch, CURLOPT_URL, $recurl);
	curl_setopt ($ch, CURLOPT_COOKIEFILE, "temp/$username.txt");
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec ($ch);
	$html = str_get_html($result);
	
	if(($iframeurl = $html->find('iframe[class=portletMainIframe]',0)->src) != null)
	{
		echo "<div style='display: none' id='refresherl'>$iframeurl</div>";
		
		$position = strripos($iframeurl,"?",-1);
		$iframeurl = substr($iframeurl,0,$position). '/room';
		curl_setopt ($ch, CURLOPT_URL, $iframeurl);
		curl_setopt ($ch, CURLOPT_COOKIEFILE, "temp/$username.txt"); 
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec ($ch);
		
		$array = explode("\n", $result);
		echo "<div style='display: none' id='linecount'>".count($array)."</div>";
		
		$html = str_get_html($result);
		if(($text = $html->find('div[id=chatListWrapper]',0)->innertext) != null)
		{
			echo $text;
		}
		if(($text = $html->find('textarea[id=controlPanel:message]',0)->innertext) != null)
		{
			echo $text;
		}
		if(($text = $html->find('input[id=topForm:chatidhidden]',0)->value) != null)
		{
			echo "<div style='display: none' id='thekoi'>" . $text . "</div>";
		}		
	}
}
else if(($iframeurl = $html->find('iframe[class=portletMainIframe]',0)->src) != null)
{
	echo "<div style='display: none' id='refresherl'>$iframeurl</div>";
	
	$position = strripos($iframeurl,"?",-1);
	$iframeurl = substr($iframeurl,0,$position). '/room';
	curl_setopt ($ch, CURLOPT_URL, $iframeurl);
	curl_setopt ($ch, CURLOPT_COOKIEFILE, "temp/$username.txt"); 
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec ($ch);
		
	$array = explode("\n", $result);
	echo "<div style='display: none' id='linecount'>".count($array)."</div>";
		
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
}
?>
