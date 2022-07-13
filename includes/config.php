<?php
include('credentials.php');

//prevents data from being sent early
ob_start();
session_start();

$nav1['index.php'] = "Home";
$nav1['notes.php'] = "Notes";
$nav1['videos.php'] = "Videos";
$nav1['contact.php'] = "Contact";

if (isset($_SESSION["USERNAME"]) && $_SESSION["USERNAME"] != NULL){  
    $nav1['logout.php'] = "Sign out";  
    $nav1['member-view.php?type=login'] = "Hi ".$_SESSION["FIRSTNAME"];    
}else{
    $nav1['login.php'] = "Sign in";
}



//echo basename($_SERVER['PHP_SELF']);
define('THIS_PAGE',basename($_SERVER['PHP_SELF']));

//echo THIS_PAGE;

switch(THIS_PAGE){
    case 'index.php':
        $title = "Home page of final project website";
        $body='home';
        $headline = 'Welcome to the home page of the final project website';
        $logo = 'logo_php.png';
        break;    
    case 'notes.php':
        $title = "notes page of final project website";
        $body='notes inner';
        $headline = 'Welcome to notes page';
        $logo = 'logo_php.png';
        break;
    case 'videos.php':
        $title = "videos page of final project website";
        $body='video inner';
        $headline = 'Welcome to the videos page where to collect some videos of tutorials';
        $logo = 'logo_php.png';
        break;
    case 'video-view.php':
        $title = "Video-view page of final project website";
        $body='video-view inner';
        $headline = 'Welcome to the video detail where to display video detail';
        $logo = 'logo_php.png';
        break;
    case 'video-new.php':
        $title = "Video-new page of final project website";
        $body='video-new inner';
        $headline = 'Welcome to create a new video';
        $logo = 'logo_php.png';
        break;
    case 'contact.php':
        $title = "Contact page of final project website";
        $body='contact inner';
        $headline = 'Welcome to the Contact page where to contact us';
        $logo = 'logo_php.png';
        break;
    case 'login.php':
        $title = "Login page of final project website";
        $body='login inner';
        $headline = 'Sign in to the website';
        $logo = 'logo_php.png';
        break;
    case 'logout.php':
        $title = "Logout page of final project website";
        $body='logout inner';
        $headline = 'Sign out of the website.';
        $logo = 'logo_php.png';
        break;
    case 'members.php':
        $title = "Members page of final project website";
        $body='member inner';
        $headline = 'Welcome to the member page where to register new member';
        $logo = 'logo_php.png';
        break;
    case 'member-view.php';
        $title = "Members page of final project website";
        $body='member-view inner';
        $headline = 'Welcome to the member view page where to show member\'s detail information';
        $logo = 'logo_php.png';
        break;
    default:
        $title = "Home page of final project website";
        $body='home';
        $headline = 'Welcome to the Home page';
        $logo = 'logo_php.png';
        break;
}


if(isset($_GET['today'])){
    $today = $_GET['today'];
} else {
    $today = date('l');
}

// switch main's background color
$bc = ''; //change main background color. it will bork on daily page.
switch($today){
    case 'Tuesday':    
        $bc ='style="background-color:#FCD2D1;"';
        break;        
    case 'Wednesday':    
        $bc ='style="background-color:#CEE5D0;"';
        break;            
    case 'Thursday':     
        $bc ='style="background-color:#D7E9F7;"';
        break;
    case 'Friday':  
        $bc ='style="background-color:#D1E8E4;"';
        break;
    case 'Saturday':    
        $bc ='style="background-color:#C8C6C6;"';
        break;
    case 'Sunday':    
        $bc ='style="background-color:#C7BEA2;"';
        break;
    default:     
        $bc ='style="background-color:#F0E5CF;"';
        break;
}
  

/*
makeLinks function will create our dynamic nav when called.
Call like this:
echo makeLinks($nav1); #in which $nav1 is an associative array of links
*/
function makeLinks($linkArray){
    $myReturn = '';
    
    foreach($linkArray as $url => $text){       
        if(THIS_PAGE == $url){
            $myReturn .= '<li><a class="current" href="' . $url . '">' . $text . '</a></li>'  . PHP_EOL;
        
        }else{
            $myReturn .= '<li><a href="' . $url . '">' . $text . '</a></li>'  . PHP_EOL;
        }
    }      
    return $myReturn;    
}


?>



