<!-- 
Sascha Watermeyer - WTRSAS001
Vulamobi CS Honours project
sascha.watermeyer@gmail.com -->

<html>
    <head>
		<meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="jquery.mobile-1.1.0.min.css" />
        <style>
            /* App custom styles */
        </style>
        <script src="jquery.min.js">
        </script>
        <script src="jquery.mobile-1.1.0.min.js">
        </script>
		<title>For sacha</title>
        <!-- <? include_once 'head.php'; ?> -->
    </head>
    <body>
		<div style="background:#D8D8D8; color: black;" data-role="page" id="page1">
			
			<div style="background:#2c77ba;" data-theme="a" data-role="header">
            
                <h1  style="background:#2c77ba;">
                    Vulamobi
                </h1>
            </div>
			
			<div style="" data-role="content">
		
      	
			<form action="auth.php" method="post">
				
				Username: <input type="text" name="username" />
				Password: <input type="password" name="password" />
				<input type="submit" value="Login"/>   
			</form>
		
			</div>
    </body>
</html>
