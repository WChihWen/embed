
<?php 

   include 'includes/header.php';

   if (isset($_SESSION["USERNAME"]) == false or $_SESSION["USERNAME"] == NULL){     
      header("Location:login.php");  
   }

   $first_name = '';
   $last_name = '';   
   $email = '';
   $phone = '';
   $comments = '';
   $privacy = '';

   $first_name_Err ='';
   $last_name_Err ='';
   $email_Err = '';
   $phone_Err ='';
     $comments_Err = '';
   $privacy_Err = '';    


   $all_set = true;
   if($_SERVER['REQUEST_METHOD'] == "POST"){
      if($_POST['first_name'] == NULL){
         $first_name_Err = 'Please fill out your first name';  
         $all_set = false; 
      }else {
         $first_name = $_POST['first_name'];
      }

      if($_POST['last_name'] == NULL){
         $last_name_Err = 'Please fill out your last name';   
         $all_set = false; 
      }else {
         $last_name = $_POST['last_name'];
      }

      if($_POST['email'] == NULL){
         $email_Err = 'Please enter your email';   
         $all_set = false; 
      }else {
         $email = $_POST['email'];
      }

      if($_POST['phone'] == NULL){
         $phone_Err = 'Please enter your phone';   
         $all_set = false; 
      }else {
         $phone = $_POST['phone'];
         if(!preg_match('/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/', $_POST['phone'])){ // if you are not typing the requested format of xxx-xxx-xxxx, display Invalid format
               $phone_Err = 'Invalid format!';
               $all_set = false;
         }           
      }
   

      if($_POST['comments'] == NULL){
         $comments_Err = 'Please fill out your comments';   
         $all_set = false; 
      }else {
         $comments = $_POST['comments'];
      }

      if( empty($_POST['privacy'])){
         $privacy_Err = 'You MUST Agree'; 
         $all_set = false;   
      }else {
         $privacy = $_POST['privacy'];
      }


      if($all_set == true){

         //$to = $email;
         $to = 'ChihWen.Wang@seattlecolleges.edu';
         $subject = 'Emailable Form from Chih Wen\'s embed project, '.date('Y-m-d') ;   
         $from = 'ChihWen.Wang@seattlecolleges.edu';
         $from_name = 'CW';
         $body ='
               <b>The first name is:</b> '. $first_name .' <br>'.PHP_EOL.'
               <b>The last name is:</b> '. $last_name .' <br>'.PHP_EOL.'
               <b>Email:</b> '.$email.' <br>'.PHP_EOL.'
               <b>Phone:</b> '.$phone.' <br>'.PHP_EOL.'                           
               <b>Comments:</b> <br>'.$comments .' '.PHP_EOL.'      
         ';

         //require 'vendor/autoload.php'; // If you're using Composer (recommended)
         // Comment out the above line if not using Composer
         require("sendgrid-php/sendgrid-php.php");
         // If not using Composer, uncomment the above line and
         // download sendgrid-php.zip from the latest release here,
         // replacing <PATH TO> with the path to the sendgrid-php.php file,
         // which is included in the download:
         // https://github.com/sendgrid/sendgrid-php/releases

         
         $email = new \SendGrid\Mail\Mail(); 
         $email->setFrom($from , $from_name);
         $email->setSubject($subject);
         $email->addTo($to, $first_name);
         $email->addContent("text/plain", $body);
         $email->addContent(
            "text/html", $body
         );
      
         $sendgrid = new \SendGrid(SGKEY);
         try {
            $response = $sendgrid->send($email);   
            $extra = 'mailsuccessfully.php?first_name='.$first_name.'&to='.$to.'';
            header("Location:".$extra);  
         } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
            exit;
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
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
               <fieldset>
                  <label >First Name</label>
                  <input type="text" name="first_name" value="<?php echo $first_name; ?>">
                  <span class="error"><?php echo $first_name_Err;?></span>

                  <label>Last Name</label>
                  <input type="text" name="last_name" value="<?php echo $last_name; ?>">
                  <span class="error"><?php echo $last_name_Err;?></span>

                  <label>Email</label>
                  <input type="email" name="email" value="<?php echo $email; ?>">
                  <span class="error"><?php echo $email_Err;?></span>

                  <label>Phone</label>
                  <input type="tel" name="phone" placeholder="xxx-xxx-xxxx" value="<?php echo $phone; ?>">
                  <span class="error"><?php echo $phone_Err;?></span>                 

                  <label>Comments</label>
                  <textarea name="comments" ><?php echo $comments; ?></textarea>
                  <span class="error"><?php echo $comments_Err;?></span>

                  <label >Privacy</label>
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
         </article>

         <aside class="links" style="width:180px;">                
            <br>
         </aside>
         <aside class="ads"  style="width:180px;">
            <br>
         </aside>
    
<?php include 'includes/footer.php';?>