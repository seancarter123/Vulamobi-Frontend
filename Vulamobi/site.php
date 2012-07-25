<?php

/* Sascha Watermeyer - WTRSAS001
 * Vulamobi CS Honours project
 * sascha.watermeyer@gmail.com */

include_once 'simple_html_dom.php';

session_start(); //for session variables
$site_id_num = $_GET['site'];
$site_title = $_GET['title'];
$cookie = $_SESSION['cookie'];
$site_id_name = "site".$site_id_num;
$site_id = $_SESSION[$site_id_name];

$cookiepath = null;
$cookiepath = realpath($cookie);

$url = "https://vula.uct.ac.za/portal/site/" . $site_id;

//eat cookie..yum
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_COOKIEFILE, $cookiepath);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

$response = curl_exec($curl);
curl_close($curl);

//create html dom object
$html_str = "";
$html_str = str_get_html($response);
$html = new simple_html_dom($html_str);

//scrap tools list
$tools = array();
$tools_ul = $html->find('#toolMenu', 0);
$ul = $tools_ul->children(0);
foreach ($ul->find('li') as $li) 
{
    foreach ($li->find('a') as $a)
    {
        $tools[] = $a;
    }
}

//Check for supported tools
$sup_tools = array();
foreach ($tools as $a) 
{
    switch ($a->class) 
    {
        case 'icon-sakai-announcements'://announcements
            $temp_replace = "https://vula.uct.ac.za/portal/site/" . $site_id . "/page/";
            $tool_id = str_replace($temp_replace, "", $a->href);
            $tool_id_name = "tool"."1";  
            $_SESSION[$tool_id_name] = $tool_id;

            $sup_tools[] = '<a href="announcements.php'
                    . '?site=' . $site_id_num
                    . '&tool=' . '1'
                    . '&title=' . $site_title
                    . '">Announcements</a></br>';
            break;
        case 'icon-sakai-chat'://chatroom
            $temp_replace = "https://vula.uct.ac.za/portal/site/" . $site_id . "/page/";
            $tool_id = str_replace($temp_replace, "", $a->href);
            $tool_id_name = "tool"."2";  
            $_SESSION[$tool_id_name] = $tool_id;

            $sup_tools[] = '<a href="chatroom.php'
                    . '?site=' . $site_id_num
                    . '&tool=' . '2'
                    . '&title=' . $site_title
                    . '">Chatroom</a></br>';
            break;
        case 'icon-sakai-assignment-grades'://assignments
            $temp_replace = "https://vula.uct.ac.za/portal/site/" . $site_id . "/page/";
            $tool_id = str_replace($temp_replace, "", $a->href);
            $tool_id_name = "tool"."3";  
            $_SESSION[$tool_id_name] = $tool_id;

            $sup_tools[] = '<a href="assignments.php'
                    . '?site=' . $site_id_num
                    . '&tool=' . '3'
                    . '&title=' . $site_title
                    . '">Assignments</a></br>';
            break;
        case 'icon-sakai-gradebook-tool'://gradebook
            $temp_replace = "https://vula.uct.ac.za/portal/site/" . $site_id . "/page/";
            $tool_id = str_replace($temp_replace, "", $a->href);
            $tool_id_name = "tool"."4";  
            $_SESSION[$tool_id_name] = $tool_id;

            $sup_tools[] = '<a href="gradebook.php'
                    . '?site=' . $site_id_num
                    . '&tool=' . '4'
                    . '&title=' . $site_title
                    . '">Gradebook</a></br>';
            break;
        default:
            break;
    }
}
//end of script
?>

<!-- HTML output -->
<html>
    <head>
        <title>Vulamobi | <? echo $site_title; ?></title>
        <? include_once 'head.php'; ?>
    </head>
    <body>
        <h1><? echo $site_title; ?></h1>
        </br>
        <?
        //tools
        foreach ($sup_tools as $a) 
        {
            echo $a;
        }
        echo "</br>";
        ?>
        <footer><a href="logout.php">logout</a></footer>
    </body>
</html>    