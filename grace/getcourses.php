<?php
session_start();
include('simple_html_dom.php');
if(isset($_SESSION['courses']))
{
	print implode("", $_SESSION['courses']);
}
else
{
$username=$_REQUEST['username'];
$password=$_REQUEST['password'];
 
$response = "";
$count = 1;
while (!($xml = simplexml_load_string($response)))
{
	$arr = sakai_soap_connect(null,$username,$password);
	list($soap, $session) = $arr;
	$response = $soap->getSitesUserCanAccess($session);
	if($count > 1)
	{
		sleep(10);
	}
	$count++;
}

$items = array();

foreach ($xml->item AS $item)
{   $items[] = '<div style="background-color:#C2D1FF; margin-top: 5px; overflow: hidden; padding: 5px;" id="' . $item->siteId . '" class="resourcecourse">' . $item->siteTitle . '</div>';
}

$_SESSION['courses'] = $items;
print implode("", $items);
}


/*
foreach ($xml->item AS $item)
{   
	//go through each course and extract the assignment url if it exists.
	$tempstorage = "https://vula.uct.ac.za/portal/site/". $item->siteId;
	$items[] = $tempstorage;
	curl_setopt ($ch, CURLOPT_URL, $tempstorage);	
	$result = curl_exec ($ch);

	$html = str_get_html($result);
	
	
	//get the assignments page
	if(($assignmenturl = $html->find('a[class=icon-sakai-resources]',0)->href)!=null)
	{
		curl_setopt ($ch, CURLOPT_URL, $assignmenturl);
		$result = curl_exec ($ch);
		$html = str_get_html($result);
		
		//get the assignments iframe
		if(($iframeurl = $html->find('iframe',0)->src) != null)
		{
			curl_setopt ($ch, CURLOPT_URL, $iframeurl);
			$result = curl_exec ($ch);
			$html = str_get_html($result);
			
			//echo $html->find('td[@headers=title]',0)->plaintext . "<br />";
			echo $result;
			
			/*foreach($html->find('h4') as $td)
			{
        				//$a = $td->find('a')->href;
        				//echo '<div class="links">' . $td->innertext . '</div>';
        				//$innerhtml = str_get_html($td->innertext);
        				echo "<div id=\"".$td->find('a',0)->href . "\" onclick='getAssignment($(this).attr(\"id\"))'>" . $td->find('a',0)->plaintext . "</div>";
        				//echo '<div>' . $innerhtml->find('a')->href . '</div>';
			}
		}
	}
	
}
*/
function sakai_soap_connect($host=null, $user=null, $pass=null)
{
	if ($host == null)
	{     $host = 'https://vula.uct.ac.za';   }

	$login_wsdl = $host .'/sakai-axis/SakaiLogin.jws?wsdl';
	$script_wsdl = $host .'/sakai-axis/SakaiScript.jws?wsdl';
	 
	$login = new SoapClient($login_wsdl, array('exceptions' => 0));
	 
	$session = $login->login($user, $pass);

	$active = new SoapClient($script_wsdl, array('exceptions' => 0));
 
	return array($active, $session);
}
?>
