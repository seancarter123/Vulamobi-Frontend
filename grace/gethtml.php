<?php
include('simple_html_dom.php');

$username=$_REQUEST['username'];
$password=$_REQUEST['password'];

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


//$arr = sakai_soap_connect(null,$username,$password);
//list($soap, $session) = $arr;
 
$reponse;
while (!($xml = simplexml_load_string($response)))
{
	$arr = sakai_soap_connect(null,$username,$password);
	list($soap, $session) = $arr;
	$response = $soap->getSitesUserCanAccess($session);
	//echo $response;
	$xml = simplexml_load_string($response);
}




/*
$url = "https://vula.uct.ac.za/portal/site/";
curl_setopt ($ch, CURLOPT_URL, $tempstorage);	
$result = curl_exec ($ch);

*/

$items = array();

foreach ($xml->item AS $item)
{   
	//go through each course and extract the assignment url if it exists.
	$tempstorage = "https://vula.uct.ac.za/portal/site/". $item->siteId;
	$items[] = $tempstorage;
	curl_setopt ($ch, CURLOPT_URL, $tempstorage);	
	$result = curl_exec ($ch);
	
	$tagname = "a";
	$attrName = "class";
	$attrValue = "icon-sakai-assignment-grades";

	$html = str_get_html($result);
	
	
	//get the assignments page
	if(($assignmenturl = $html->find('a[class=icon-sakai-assignment-grades]',0)->href)!=null)
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
			//echo $result;
			
			foreach($html->find('h4') as $td)
			{
				/*foreach($td->find('a') as $a)
        				echo $a->href . '<br>';*/
        				//$a = $td->find('a')->href;
        				//echo '<div class="links">' . $td->innertext . '</div>';
        				//$innerhtml = str_get_html($td->innertext);
        				echo "<div id=\"".$td->find('a',0)->href . "\" onclick='getAssignment($(this).attr(\"id\"))'>" . $td->find('a',0)->plaintext . "</div>";
        				//echo '<div>' . $innerhtml->find('a')->href . '</div>';
			}
		}
	}
	
}

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

function getAssignments($html)
{
	$DOM = new DOMDocument;
	$DOM->loadHTML($html);
	
	$items = $DOM->getElementsById;
}
?>
