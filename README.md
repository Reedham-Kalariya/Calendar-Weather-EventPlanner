# CSE330
NAME:
Reedham
Kalariya <br>

STUDENT-ID:
485788<br>

GITHUB-USERNAME:
Reedham-Kalariya <br>

Link to Instance:
http://ec2-54-197-143-204.compute-1.amazonaws.com/~ReedhamJK/


NAME: Juan Poma <br>
STUDENT-ID: 476418<br>
GITHUB-USERNAME: covidiousthenineteenth <br>
Link to Instance: http://ec2-18-220-15-216.us-east-2.compute.amazonaws.com/~jpoma/module5_testing/


----------------------------------------------------------------------------
Link to working instance: http://ec2-18-220-15-216.us-east-2.compute.amazonaws.com/~jpoma/module5_testing/
Link to PHPMYADMIN: http://ec2-18-220-15-216.us-east-2.compute.amazonaws.com/phpmyadmin/index.php 
    -> if you would like to see how our databse is being written whenever the user adds, deletes, update events,
    -> you can login to a guest account with read only access. You will also be able to see what happens if a user tries to delete
    -> or update an event that does not belong to the user in session. <br>
    -> The username to phpMyAdmin is: TA_Guest <br>
    -> The password to phpMyAdmin is: WelcomeTA <br>
-----------------------------------------------------------------------------
<br>
----- Calendar View (10 Points):<br>
    1) The calendar is displayed as a table grid with days as the columns and weeks as the rows, one month at a time (5 points)
        -> using jquery and css to display the calendar in a table grid. You can press the left or right arrow to swith between months
        -> you can also select from the dropdown menu to select the desired month or year. <br>
    2) The user can view different months as far in the past or future as desired (5 points)
        ->The calendar uses the calendar php functions this allows unlimited selection of years. You can go back to the desired year<br>
----- User and Event Management (25 Points):<br>
    1) Events can be added, modified, and deleted (5 points)
        -> events call php and uses sql to add, delete and modify the user event from the database<br>
    2) Events have a title, date, and time (2 points)
        -> events have a title and a date, unfortunately they do not have a time. <br>
    3) Users can log into the site, and they cannot view or manipulate events associated with other users (8 points)
        -> there are several checks in place. The user can only see their data and if they know the name of another user's event, even if they try
        -> to delete it, it will not happen as the sql calls delete where the title and the username matches. It grabs the username from the session
        -> the username is not an user's input.
        -> Although there is a success message, the database is not being changed if a user tries to delete or update someone else's database. <br>
    4) All actions are performed over AJAX, without ever needing to reload the page (7 points)
        -> we use ajax to perform the requests<br>
    5) Refreshing the page does not log a user out (3 points)
        -> we incorporated module 3 group code to have user session, the user can register, login, logout and reset their password<br>
----- Best Practices (20 Points):<br>
    1) Code is well formatted and easy to read, with proper commenting (2 points)
        -> we commented out code per guidelines and they have their own functions to grab or write data<br>
    2) If storing passwords, they are stored salted and hashed (2 points)
        -> yes, we are using password_hash() php function to save into the DB<br>
    3) All AJAX requests that either contain sensitive information or modify something on the server are performed via POST, not GET (3 points)
        -> we are only using POST<br>
    4) Safe from XSS attacks; that is, all content is escaped on output (3 points)
        -> :(<br>
    5) Safe from SQL Injection attacks (2 points)
        -> the query is prepared<br>
    6) CSRF tokens are passed when adding/editing/deleting events (3 points)
        -> :(<br>
    7) Session cookie is HTTP-Only (3 points)
        -> we maintain it the session cookie as http-only<br>
    8) Page passes the W3C validator (2 points)
        -> although we have scripts and php, we have followed the professors guidance<br>
---- Usability (5 Points):<br>
    1) Site is intuitive to use and navigate (4 points)
        -> the site contains links to direct the user to create a new account or login if they are a guest. 
        -> once they login, it takes them to the calendar where they can view their events
        -> the logged in user can logout by pressing on a link and also reset their password<br>
    2) Site is visually appealing (1 point)
        -> we hope it is!<br>
        
---- Creative Portion (5 points): <br>
    1) Reset Password feature which is not mentioned as a requirement has been added so that user can reaccess their events on calendar without losing them forever!  <br>
    2) Add shared events feature. The host of group event can add usernames of individuals who can access the events. 
    3) Only the hosts has rights to add, delete, or modify any feature of the group events. We tried to attempt to show host change but it did not work. Lastly changes of group events are visible on database.
    
    
## Grading
68/75 points
    
-1pt events don't have a time
-3pts not all content escaped
-3pts no csrf tokens
-2pts page doesn't pass validator
+2pts site looks awesome
