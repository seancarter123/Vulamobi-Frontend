<!-- 
Sascha Watermeyer - WTRSAS001
Vulamobi CS Honours project
sascha.watermeyer@gmail.com -->

<!DOCTYPE HTML>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="doc_theme.css" />
    </head>
    <body>
        </br>
        <h1>Vulamobi Backend Documentation</h1>
        </br>
        <p>Hey Guys, I didn't want to leave you gentleman in the dark about how the backend works while I am away, 
           so I wrote this little documentation page for you guys to use as a reference :)
        </p>
        </br>
        <h2>Introduction</h2>
        </br>
        <p>How the backend PHP code will work with the mobile interface is to simply 
           add the mobile page's HTML and corresponding CSS, Javascript..etc 
           into the <a href="Vulamobi_backend.zip" >source folder</a> that is 
           being hosted by my nightmare.</br>
           </br>
           Unfortunately for some reason, the cookie authentication doesn't want 
           to work on nightmare -thats why the login goes to a blank page-, but works fine on my localhost, so we may be 
           restricted to hosting the app on a Honours lab pc which has access to whole UCT network - I will work at this -.
        </p>
        </br>
        <h2>Architecture</h2>
        </br>
        <p>If you already know this I'm reminding you, a user of <b>Vula</b> has memberships with <b>Sites</b> 
           which have a list of <b>Tools</b> that are of a different combination depending on the site - e.g. Announcements, Gradebook, Chatroom etc. -. 
        </br></br>
           Considering the order Vula navigates it seems intuative that we do it the same way.
        </p>
        </br>
        <img src="Vulamobi_Backend_Architecture.png" alt="Vulamobi Backend Architecture"/> 
        <h5>Fig 1: Vulamobi Backend Architecture</h5>
        <p><b>index.php:</b></br>
            This will be our login page which will be customized by you the designers for a fresh Vula mobile interface.
            </br>
            The page uses PHP's cURL libruary to post the username and login entered by the user. 
            You guys don't need to worry about the logistics of what is going on but its basically cookie authentication.
        </p>
        <p><b>home.php:</b></br>
            This script acts like the <i>driver</i> or <i>main</i> class where the order of scripts it executes is shown 
            in <b>fig 1</b> i.e; auth.php, portal.php, site.php.            
        </p>
        <p><b>auth.php:</b></br>
            This script was kindly donated by P-Rez from the ENGAGE team. It does the curl specific cookie authentication 
            but as said before it doesn't want to gel on nightmare.         
        </p>
        <p><b>portal.php:</b></br>
            This script is made for scraping all the users main details and links to active sites that we will display in 
            the home page the user logs into.         
        </p>
        <p><b>sites.php:</b></br>
            This script is made for scraping all the tools of a site that user selects from the home page. Note that not 
            all sites have the same tools and come with different combination of tools per site
            </br></br>
            I haven't made the scripts for scraping specific tools yet but I agreed with George and Tatenda to atleast get 
            these tools working:
            </br></br>
            - Announcements</br>
            - Gradebook</br>
            - Assignments</br>
            - Chat Room</br>
            - Calender</br>
            </ul>
            </br></br>
            If you want a tool just let me know and ill 
            make a script for it: sascha.watermeyer@gmail.com
        </p>
    </body>
</html>