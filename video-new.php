<?php

include 'includes/header.php';

if (isset($_SESSION["USERNAME"]) == false or $_SESSION["USERNAME"] == NULL){     
    header("Location:login.php");  
}


$category = '';
$subject = '';   
$subject_url = '';
$channel = '';
$channel_url = '';
$memo = '';
$privacy = '';

$category_Err ='';
$subject_Err ='';
$subject_url_Err = '';
$channel_Err ='';
$channel_url_Err = '';

$memo_Err ='';
$privacy_Err = '';    
$all_set = true;

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if($_POST['category'] == NULL){
        $category_Err = 'Please fill out category';  
        $all_set = false; 
    }else {
        $category = $_POST['category'];
    }

    if($_POST['subject'] == NULL){
        $subject_Err = 'Please fill out subject';   
        $all_set = false; 
    }else {
        $subject = $_POST['subject'];
    }

    if($_POST['subject_url'] == NULL){
        $subject_url_Err = 'Please enter subject url';   
        $all_set = false; 
    }else {
        $subject_url = $_POST['subject_url'];
    }

    if($_POST['channel'] == NULL){
        $channel_Err = 'Please enter channel name';   
        $all_set = false; 
    }else {           
        $channel = $_POST['channel'];
    }

    if($_POST['channel_url'] == NULL){
        $channel_url_Err = 'Please enter channel url';   
        $all_set = false; 
    }else {          
        $channel_url = $_POST['channel_url'];                
    }
    

    if( empty($_POST['privacy'])){
        $privacy_Err = 'You MUST agree to create a new video'; 
        $all_set = false;   
    }else {
        $privacy = $_POST['privacy'];
    }
  
    					
    if($all_set == true){
        

        $iConn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die(myError(__FILE__,__LINE__,mysqli_connect_error()));
                        
        $vdate= date('m-j-Y');

        // convert to embed model
        $subject_url =  str_replace("watch?v=", "embed/", $subject_url ); 
        
        //https://www.youtube.com/embed/2eebptXfEvw to
        //https://www.youtube.com/watch?v=2eebptXfEvw
        
        //https://www.youtube.com/embed/0QO2jdinCoQ&t=14s to
        //https://www.youtube.com/embed/0QO2jdinCoQ
        $ary = explode("&", $subject_url);
        $subject_url = $ary[0];
        $sql = "INSERT INTO videos (video_type, video_title, video_url, video_memo, video_date, channel_name, channel_url) VALUES 
                        ('".$category."', '".$subject."', '".$subject_url."', '".$memo."', '".$vdate."', '".$channel."', '".$channel_url."')";

        if ($iConn->query($sql) === TRUE) {      
            mysqli_free_result($result);
            mysqli_close($iConn);
            header("Location:videos.php");     
        
        } else {
            echo "Error: " . $sql . "<br>" . $iConn->error;
            mysqli_free_result($result);
            mysqli_close($iConn);
        }             

    }
}

?>

<main <?php echo $bc ?>>
    <div class="container">
      <header class="header">
        <a href="index.php" ><img class="logo" src="images/<?php echo $logo ?>" alt="PHP Logo" /></a>
         </header>
         <nav class="navigation">
            <ul>
                  <?=makeLinks($nav1)?>                    
            </ul>            
         </nav>
         <article class="content">
            <h1><?php echo $headline?></h1>   
            <form  style="width:500px;" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <fieldset>
               <label >Category</label>
               <input type="text" name="category" maxlength="20" value="<?php echo $category; ?>">
               <span class="error"><?php echo $category_Err;?></span>

               <label>Subject</label>
               <input type="text" name="subject" maxlength="100" style="width:98%;" value="<?php echo $subject; ?>">
               <span class="error"><?php echo $subject_Err;?></span>              

               <label>Subject Url</label>
               <input type="text" name="subject_url" maxlength="300" style="width:98%;" value="<?php echo $subject_url; ?>">
               <span class="error"><?php echo $subject_url_Err;?></span>

               <label>Channel</label>
               <input type="text" name="channel" maxlength="100"  value="<?php echo $channel; ?>">
               <span class="error"><?php echo $channel_Err;?></span>
               
               <label>Channel Url</label>
               <input type="text" name="channel_url" maxlength="300" style="width:98%;" value="<?php echo $channel_url; ?>">
               <span class="error"><?php echo $channel_url_Err;?></span>
             
               <label>Momo</label>
                <textarea name="memo" style="width:98%;" ><?php echo $memo; ?></textarea>
                <span class="error"><?php echo $memo_Err;?></span>

               <label >Agree to create a new video.</label>
               <ul>
                     <li>               
                        <input type="radio" name="privacy" value="agree" <?php if( $privacy=='agree' ) echo 'checked="checked"'; ?>>I agree!
                     </li>             
               </ul>
               <span class="error"><?php echo $privacy_Err;?></span> 
               <div class="center">            
                  <input type="submit" class="btn" value="Send it">
                  <a href="" class="button">Reset</a>  
               </div> 
              
            </fieldset>
         </form>      
         <p class="center"><b><a href="videos.php">Back</a></b></p>  
         </article>

         <aside class="links" style="width:180px;">                
            <br>
         </aside>
         <aside class="ads">
        </aside>

<?php include 'includes/footer.php';?>   