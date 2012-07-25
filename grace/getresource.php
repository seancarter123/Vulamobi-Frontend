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

/*
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
*/

if(isset($_SESSION[$courseid]))
{
	
}
else
{
	$_SESSION['courseid']=true;
}

//go to the specific course
$ch = curl_init();
$tempurl = "https://vula.uct.ac.za/portal/site/". $courseid;
curl_setopt ($ch, CURLOPT_URL, $tempurl);
curl_setopt ($ch, CURLOPT_COOKIEFILE, "temp/$username.txt"); 
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec ($ch);	

//get the url for the resources and go to it
$html = str_get_html($result);
//echo $result;

if(($recurl = $html->find('a[class=icon-sakai-resources]',0)->href)!=null)
{
	curl_setopt ($ch, CURLOPT_URL, $recurl);
	curl_setopt ($ch, CURLOPT_COOKIEFILE, "temp/$username.txt");
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec ($ch);
	$html = str_get_html($result);
	//echo "test";
	//get the assignments iframe
	if(($iframeurl = $html->find('iframe[class=portletMainIframe]',0)->src) != null)
	{
		curl_setopt ($ch, CURLOPT_URL, $iframeurl);
		curl_setopt ($ch, CURLOPT_COOKIEFILE, "temp/$username.txt"); 
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec ($ch);
		$html = str_get_html($result);
		
		foreach($html->find('td[headers=title]') as $element)
		{
       			$innerhtml = str_get_html($element);
       			if($innerhtml->find('a',1)->href == "#")
       			{
       				$valuearray = explode("'",$innerhtml->find('a',1)->onclick);
       				$link = "https://vula.uct.ac.za/access/content" . $valuearray[7];
       				echo '<div id="' . $link .'" class="folder" style="background-color:#C3D9aa; margin-top: 5px; overflow: hidden; padding: 5px;" onclick="folderSelected($(this).attr(\'id\'))">' . $innerhtml->find('a',1)->plaintext . '</div>';
       			}
       			else
       			{
       				echo '<div id="' . $innerhtml->find('a',1)->href .'" class="resource" style="background-color:#C2D1FF; margin-top: 5px; overflow: hidden; padding: 5px;" onclick="resourceSelected($(this).attr(\'id\'))">' . $innerhtml->find('a',1)->plaintext . '</div>';
       			}
       		}
       		
		//output data
		//echo $result;
	}
}
else
{
	if(($iframeurl = $html->find('iframe[class=portletMainIframe]',0)->src) != null)
	{
		curl_setopt ($ch, CURLOPT_URL, $iframeurl);
		curl_setopt ($ch, CURLOPT_COOKIEFILE, "temp/$username.txt"); 
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec ($ch);
		$html = str_get_html($result);
		
		foreach($html->find('td[headers=title]') as $element)
		{
       			$innerhtml = str_get_html($element);
       			if($innerhtml->find('a',1)->href == "#")
       			{
       				$valuearray = explode("'",$innerhtml->find('a',1)->onclick);
       				$link = "https://vula.uct.ac.za/access/content" . $valuearray[7];
       				echo '<div id="' . $link .'" class="folder" style="background-color:#C3D9aa; margin-top: 5px; overflow: hidden; padding: 5px;" onclick="folderSelected($(this).attr(\'id\'))">' . $innerhtml->find('a',1)->plaintext . '</div>';
       			}
       			else
       			{
       				echo '<div id="' . $innerhtml->find('a',1)->href .'" class="resource" style="background-color:#C2D1FF; margin-top: 5px; overflow: hidden; padding: 5px;" onclick="resourceSelected($(this).attr(\'id\'))">' . $innerhtml->find('a',1)->plaintext . '</div>';
       			}
       		}
       		
		//output data
		//echo $result;
	}
}


?>
