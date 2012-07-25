<?php
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
$type = $_REQUEST['type'];
$annid = "";

if(isset($_REQUEST['annid']))
{
	$annid = $_REQUEST['annid'];
}
$url = "";
if ( $type == 1)
{
	$url = announcements();
}
if ( $type == 2)
{
	$url = announcements();
}
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

$response = curl_exec($curl);
$resultStatus = curl_getinfo($curl);
$xml = simplexml_load_string($response);

$echoText = "";

$todayCount = 0;
$yesterdayCount = 0;
$daybeforeCount = 0;
$lastweekCount = 0;

if( $type == 1 )
{
	$announcementText = "";
	foreach($xml->children() as $child)
	{
		$temptext = "";
		foreach($child->children() as $minime)
		{
			if($minime->getName() == "entityId")
			{
				$temptext = "
					<div class=\"desc\" id=\"$minime\" style=\"width:100%; height: 15px;background-color:#C2D1FF;margin-bottom: 2px; padding: 3px; padding-top: 5px; padding-bottom: 5px; overflow:hidden; color: black\">" . $temptext;
					echo $temptext;
			}
			if($minime->getName() == "title")
			{
				$temptext = "";
				$temptext = "$minime</div>";
			}
			if($minime->getName() == "createdOn")
			{
				$timer = "";
				//echo strtotime(date('Y-m-d 00:00:00')) . '<br />' . $minime . '<br />' . date($minime) . ' <br /><br />';
				if( strtotime(date('Y-m-d 00:00:00'))*1000 < $minime && $todayCount == 0)
				{
					$timer = "<div class=\"time\">Today</div>";
					echo $timer;
					$todayCount = 1;
				}
				else if( (strtotime(date('Y-m-d 00:00:00')) - 86400)*1000 < $minime && $yesterdayCount == 0)
				{
					$timer = "<div class=\"time\">Yesterday</div>";
					echo $timer;
					$yesterdayCount = 1;
				}
				else if( (strtotime(date('Y-m-d 00:00:00')) - 86400*2)*1000 < $minime && $daybeforeCount == 0)
				{
					$timer = "<div class=\"time\">Day before Yesterday</div>";
					echo $timer;
					$daybeforeCount = 1;
				}
				else if( (strtotime(date('Y-m-d 00:00:00')) - 86400*3)*1000 < $minime && (strtotime(date('Y-m-d 00:00:00')) - 86400*6)*1000 < $minime &&$daybeforeCount == 0)
				{
					$timer = "<div class=\"time\">Last 7 Days</div>";
					echo $timer;
					$daybeforeCount = 1;
				}
				else if( (strtotime(date('Y-m-d 00:00:00')) - 86400*7)*1000 < $minime && $lastweekCount == 0)
				{
					$timer = "<div class=\"time\">Over A Week Ago</div>";
					echo $timer;
					$lastweekCount = 1;
				}
			}
		}
	}
}
else if( $type == 2 )
{
	$announcementText = "";
	foreach($xml->children() as $child)
	{
		$temptext = "";
		$title = "";
		foreach($child->children() as $minime)
		{
			if($minime->getName() == "body")
			{
				$temptext = "
					$minime";
			}
			if($minime->getName() == "id")
			{
				if($minime == $annid)
				{
					//$newmini = substr($minime, 0, 30);
					$temptext = $title."</div>" . $temptext;
					
				}
				else
				{
					$temptext = "";
				}
				
			}
			if($minime->getName() == "siteTitle")
			{
				$title = "<div id=\"subheader\" style=\"background-color: teal; width: 100%;\">" . $minime;
				break;
			}			
		}
		
		if($temptext != "")
		{
			$echoText = $echoText . $temptext;
			break;
		}
	}
}

echo $echoText;

function announcements()
{
	return "https://vula.uct.ac.za/direct/announcement/user.xml?n=30&d=30";
}
?>
