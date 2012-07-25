<?php 
session_start();
include('simple_html_dom.php');
if(isset($_SESSION['chatchat']))
{
	print implode("", $_SESSION['chatchat']);
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
{   
	$items[] = '<div style="background-color:#C2D1FF; margin-top: 5px; overflow: hidden; padding: 5px;" id="' . $item->siteId . '" class="chatcourse">' . $item->siteTitle . '</div>';
}

$_SESSION['chatchat'] = $items;
print implode("", $items);
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
?>
