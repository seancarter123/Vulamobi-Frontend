<?php
    
 /* Sascha Watermeyer - WTRSAS001
 * Vulamobi CS Honours project
 * sascha.watermeyer@gmail.com */

include_once 'simple_html_dom.php';

session_start(); //for session variables
$site_id_num = $_GET['site'];
$tool_num = $_GET['tool'];
$site_title = $_GET['title'];
$cookie = $_SESSION['cookie'];
$site_id_name = "site".$site_id_num;
$site_id = $_SESSION[$site_id_name];
$tool_name = "tool".$tool_num;
$tool_id = $_SESSION[$tool_name];

echo "tool_id: ".$tool_id."</br>";

//https://vula.uct.ac.za/portal/tool/bd422298-b893-4816-9eaf-b2bb9052be57?panel=Main

$cookiepath = null;
$cookiepath = realpath($cookie);

$url = "https://vula.uct.ac.za/portal/site/".$site_id."/page/".$tool_id;

//eat cookie..yum
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_COOKIEFILE, $cookiepath);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

$response = curl_exec($curl);
//curl_close($curl);

//create html dom object
$html_str = "";
$html_str = str_get_html($response);
$html = new simple_html_dom($html_str);
		
if(($iframe_url = $html->find('iframe',0)->src) != null)
{
    echo "iframe_url: ".$iframe_url."</br>";
    curl_setopt ($curl, CURLOPT_URL, $iframe_url);
    $result = curl_exec ($curl);
    $html = str_get_html($result);
    
    if(($results_table = $html->find("#gbForm",0)->children(3)) != null)
    {
        echo "results_table: ".$results_table."</br>";

        $theData = array();
        echo "_id_0__hide_division_: ".$results_table->find("#_id_0__hide_division_",0)."</br>";
        // loop over rows
        foreach($results_table->find('tr') as $row) 
        {
            echo "row: ".$row."</br>";
            // initialize array to store the cell data from each row
            $rowData = array();
            /*foreach($row->find('td.text') as $cell) 
            {    // push the cell's text to the array
                echo "cell: ".$cell->innertext."</br>"; 
                $rowData[] = $cell->innertext;
            }*/

            // push the row's data array to the 'big' array
            $theData[] = $rowData;
        }
        //echo $theData."</br>";
    }
}
//end of script
?>

<!-- HTML output -->
<html>
    <head>
        <title>Vulamobi | Gradebook</title>
        <? include_once 'head.php'; ?>
    </head>
    <body>
        <h1><? echo $site_title; ?></h1>
        </br>
        <h2>Gradebook</h2>
        <?
        
        ?>
        </br>
        <footer><a href="logout.php">logout</a></footer>
    </body>
</html>    
