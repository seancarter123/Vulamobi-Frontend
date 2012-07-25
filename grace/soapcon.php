<?php
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];

$arr = sakai_soap_connect(null,$username,$password);
list($soap, $session, $assignment) = $arr;
 
$response = $soap->getSitesUserCanAccess($session);

$xml = simplexml_load_string($response);
//echo $response; 

$items = array();

foreach ($xml->item AS $item)
{   $items[] = $item->siteId;
}

print implode("\n", $items);

$response = $assignment->getAssignmentsForContext($session, " 477c3c66-03ff-4a86-8662-10a5fe43d58d");

echo "test";
echo $response;
 
function sakai_soap_connect($host=null, $user=null, $pass=null) 
{
	if ($host == null)
	{     $host = 'https://vula.uct.ac.za';   }
	if ($user == null)
	{     $user = 'admin';   }
	if ($pass == null)
	{     $pass = 'admin';   }
	$login_wsdl = $host .'/sakai-axis/SakaiLogin.jws?wsdl';
	$script_wsdl = $host .'/sakai-axis/SakaiScript.jws?wsdl';
	$assignment_wsdl = $host .'/sakai-axis/WSAssignment.jws?wsdl';
	 
	$login = new SoapClient($login_wsdl, array('exceptions' => 0));
	 
	$session = $login->login($user, $pass);

	$active = new SoapClient($script_wsdl, array('exceptions' => 0));
	$ass = new SoapClient($assignment_wsdl, array('exceptions' => 0));
 
	return array($active, $session, $ass);
}
	

?>
