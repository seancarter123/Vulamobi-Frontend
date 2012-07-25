<?

/* Sascha Watermeyer - WTRSAS001
 * Vulamobi CS Honours project
 * sascha.watermeyer@gmail.com */

include_once 'simple_html_dom.php';

session_start(); //for session variables
$cookie = $_SESSION['cookie'];
$username = $_SESSION['username'];
$cookiepath = realpath($cookie);

$url = "https://vula.uct.ac.za/portal/site/~" . $username;

//eat cookie..yum
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_COOKIEFILE, $cookiepath);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

$response = curl_exec($curl);
curl_close($curl);

/* Scrap! */

//create html dom object
$html_str = "";
$html_str = str_get_html($response);
$html = new simple_html_dom($html_str);

//Get User's name
$temp_replace = '(' . $username . ') |';
$loginUser_str = $html->find('#loginUser', 0);
$loginUser = $loginUser_str->innertext;
$loginUser_title = str_replace($temp_replace, "", $loginUser);

//Get User's Active Sites
$count = 0;
$active_sites = array();
$ul = $html->find('ul', 0); //first ul tag
foreach ($ul->find('li') as $li) 
{
    foreach ($li->find('a') as $a) 
    {
        if ($count > 0)//skip workspace link 
        {
            $site_id = substr($a->href, 35);
            $site_id_name = "site".$count;  
            $_SESSION[$site_id_name] = $site_id;
            
            $active_sites[] = '<li><a href="site.php'
            . '?site=' . $count
            . '&title=' . $a->title
            . '" class="ass">' . $a->title . '</a></li>';
        }
        $count++;
		
		/*<ul data-role="listview" data-inset="true">
			<li><a href="#page2">Calender</a></li>
            <li><a href="#page3">Announcements</a><span class="ui-li-count">5</span></li>
            <li><a href="#page4" > Photo Gallery</a> <span class="ui-li-count">55</span></li>
          	<li><a href="#page5">About Us</a></li>
		</ul>*/		
    }
}
//end of script
?>

<!-- HTML output -->
<html>
    <head>
		<meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="jquery.mobile-1.1.0.min.css" />
		<link rel="stylesheet" href="my.css" />
        <style>
            /* App custom styles */
        </style>
        <script src="jquery.min.js">
        </script>
        <script src="jquery.mobile-1.1.0.min.js">
        </script>
		<title>From sascha</title>
      
     
    </head>
    <body>
	
		<div style="background:#D8D8D8; color: black;" data-role="page" id="page1">
			
			<div style="background:#2c77ba;" data-theme="a" data-role="header">
            
                <h1  style="background:#2c77ba;">
                    Vulamobi
                </h1>
            </div>
        
        <h3><? echo $loginUser_title ?></h3>
			
 		<div data-role="content">
		
		
		 	<ul data-role="listview" data-inset="true">
	  		<?
        	//active sites
        	$count = 0;
        	foreach ($active_sites as $value) 
        	{
				echo  $value ;
        	}
        	?>
            </ul>
		</div>
		<br/>
		<br/>
        <footer><a href="logout.php">Logout</a></footer>
    </body>
</html>    
