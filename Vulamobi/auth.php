<?php

/* Sascha Watermeyer - WTRSAS001
 * Vulamobi CS Honours project
 * sascha.watermeyer@gmail.com */
 
session_start();//for session variables    
try{
$_SESSION['username'] = $_REQUEST['username'];    
$_SESSION['password'] = $_REQUEST['password'];    
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];}
catch(exception $e){}

if($username==null || $password==null)
{
    include_once 'emptypwd.php';
    include_once 'index.php';
    die;
}

$auth = array(
    'eid' => $username,
    'pw' => $password,
);

$url = "https://vula.uct.ac.za/authn/login";

$cookie = tempnam ("/tmp", md5($_POST['username'] . salt()));

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $auth);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

curl_exec($curl);
$resultStatus = curl_getinfo($curl);

if ($resultStatus['url'] == "https://vula.uct.ac.za/portal") 
{ 	//if redirected it means its logged in
    $_SESSION['cookie'] = $cookie;
    session_write_close();
    header( 'Location: home.php' ) ;
    echo "redirecting to home ...";
} 
else 
{
    include_once 'incorrectpwd.php';
    include_once 'index.php';
    die;
} 
    
//returns random num from 10000 - 99999
function salt()
{
    $found = false;
    while(!$found)
    {
        $x = rand(0, 99999);
        if($x < 10000)
            $x = rand(0, 99999);
        else $found = true;
    }
    return (string)$x;
}
?>
