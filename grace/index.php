<?php
session_start();
session_unset();
//session_destroy();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>
        </title>
        <link rel="stylesheet" href="jquery.mobile-1.1.0.min.css" />
		<link rel="stylesheet" href="my.css" />
        <style>
            /* App custom styles */
        </style>
        <script src="jquery.min.js">
        </script>
        <script src="jquery.mobile-1.1.0.min.js">
        </script>
        <script src="custom.js">
        </script>
    </head>
    <body>
        <div style="background:#D8D8D8; color: black;" data-role="page" id="page1">
        
            <div style="background:#2c77ba;" data-theme="a" data-role="header">
            
                <h3  style="background:#2c77ba;">
                    Vulamobi
                </h3>
            </div>
            <div style="" data-role="content">
                <div data-role="fieldcontain">
                    <fieldset data-role="controlgroup">
                        <label  for="username">
                            USERNAME
                        </label>
                        <input id="username" placeholder="" value="" type="text" />
                    </fieldset>
                </div>
                <div data-role="fieldcontain">
                    <fieldset data-role="controlgroup">
                        <label for="password">
                            PASSWORD
                        </label>
                        <input id="password" placeholder="" value="" type="password" />
                    </fieldset>
                </div>
                <a data-role="button" data-transition="fade" href="#" onclick="login();return false;">
                    Login
                </a>
            </div>
            <input type="hidden" id="sessionid" value="" />
        </div>
        <div data-role="page" id="page2">
            <div data-theme="a" data-role="header">
                <h3>
                    mVULA
                </h3>
            </div>
            <iframe id="secretIFrame" src="" style="display:none; visibility:hidden;"></iframe>
            <div data-role="content" id="metainfo">
            </div>
        </div>
        <div data-role="page" id="page3">
            <div data-theme="a" data-role="header">
                <h3>
                    mVULA
                </h3>
            </div>
            <div data-role="content" id="superlinks">
            </div>
        </div>
        <div data-role="page" id="page4">
             <script type="text/javascript" language="javascript">
		$('#page4').live('pageshow', function (event, ui) {
		    getData();
		});
	    </script>
            <div data-theme="a" data-role="header">
                <h3>
                    mVula
                </h3>
            </div>
            <div data-role="content">
                <div>
					<div class="ablocks">
						<a href="#page5">
						<div class="bblock a c" alight="center">
							Announcements
						</div>
						</a>
						<a href="#page6">
						<div class="bblock b c">
							Resources
						</div>
						</a>
					</div>
                    			<div class="ablocks">
						<a href="#page7">
						<div class="bblock a d">
							Assignments
						</div>
						</a>
						<a href="#page8">
						<div class="bblock b d">
							Chat
						</div>
						</a>
					</div>
                </div>
            </div>
        </div>
        <div data-role="page" id="page5">
        <script>
        $('#page5').live('pageshow', function (event, ui) {
		    annLive();
		});
	</script>
            <div data-theme="a" data-role="header">
                <h3>
                    Announcements
                </h3>
            </div>
            <div class="breadcrumbs" style="background-color: #66E0FF">
            	<a href="#page6">Resources</a>||<a href="#page7">Assignments</a>||<a href="#page8">Chat</a>
            </div>
            <div data-role="content" id="announcements">
            </div>
        </div>
        <div data-role="page" id="page6">
        <script>
        $('#page6').live('pageshow', function (event, ui) {
		    getCourses();
		});
	</script>
            <div data-theme="a" data-role="header">
                <h3>
                    Resources
                </h3>
            </div>
            <div class="breadcrumbs" style="background-color: #80CC99">
            	<a href="#page5">Announcements</a>||<a href="#page7">Assignments</a>||<a href="#page8">Chat</a>
            </div>
            <div data-role="content" id="resources">
            </div>
        </div>
        <div data-role="page" id="page7">
        <script>
        $('#page7').live('pageshow', function (event, ui) {
		    assLogin();
		    $('#links').click(function(){
					alert('test');
				});
		});
	</script>
            <div data-theme="a" data-role="header">
                <h3>
                    Assignments
                </h3>
            </div>
            <div class="breadcrumbs" style="background-color: #FF8566">
            	<a href="#page5">Announcements</a>||<a href="#page6">Resources</a>||<a href="#page8">Chat</a>
            </div>
            <div data-role="content" id="assignments">
            </div>
        </div>
        <div data-role="page" id="page8">
        <script>
        $('#page8').live('pageshow', function (event, ui) {
		    getChats();
		    $('#links').click(function(){
					alert('test');
				});
		});
	</script>
            <div data-theme="a" data-role="header">
                <h3>
                    Chat
                </h3>
            </div>
            <div class="breadcrumbs" style="background-color: #FF99FF">
            	<a href="#page5">Annoucements</a>||<a href="#page6">Resources</a>||<a href="#page7">Assignments</a>
            </div>
            <div data-role="content" id="chat">
            </div>
        </div>
        <div data-role="page" id="page9">
        <script src="chatscript.js" type="text/javascript">
        </script>
        <script>
         $('#page9').live('pageshow', function (event, ui) {
		   var wh = $(window).height() - 200;
		   $("#chatinfo").height(wh);
		   cleanup();
		   updater = setInterval(updateChats, 2000);
		   refresher = setInterval(refreshChats, 10000);
		});
	 $('#page9').unload(function(){
	  alert('Bye.');
	  });
        </script>
            <div data-theme="a" data-role="header">
                <h3>
                    Chat
                </h3>
            </div>
            <div class="breadcrumbs" style="background-color: #FF99FF">
            	<a href="#page8" onclick="cleanup()">chats</a>
            </div>
            <div data-role="content" id="chatinfo" style="overflow: auto">
            </div>
            <div id="Test"></div>
            <div data-theme="a" data-role="footer" id="essential" data-position="fixed"><textarea id="messageme" name="controlPanel:message" row="3" col="30" style="max-height: 40px;"></textarea></div>
        </div>
        <script>
            //App custom javascript
        </script>
    </body>
</html>
