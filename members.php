<?php

include 'includes/header.php';
$first_name = '';
$last_name = '';   
$email = '';
$account = '';
$pwd = '';
$cfpwd ='';
$privacy = '';

$first_name_Err ='';
$last_name_Err ='';
$email_Err = '';
$account_Err ='';
$pwd_Err = '';
$cfpwd_Err ='';
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

   if($_POST['account'] == NULL){
      $account_Err = 'Please enter your account';   
      $all_set = false; 
   }else {           
      $account = $_POST['account'];
   }

   if($_POST['pwd'] == NULL){
      $pwd_Err = 'Please enter your password';   
      $all_set = false; 
   }else {          
      $pwd = $_POST['pwd'];                
   }

   if($_POST['cfpwd'] == NULL){
      $cfpwd_Err = 'Please enter your confirm password';   
      $all_set = false; 
   }else {     
      $cfpwd = $_POST['cfpwd'];
   }

   if( empty($_POST['privacy'])){
      $privacy_Err = 'You MUST Agree'; 
      $all_set = false;   
   }else {
      $privacy = $_POST['privacy'];
   }

   if($all_set == true && $_POST['pwd'] != $_POST['cfpwd']){
      $cfpwd_Err .= '<br> Password and Confirm Password have to the Same';  
      $all_set = false;
   }

   if($all_set == true){
      // create new member

      $iConn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die(myError(__FILE__,__LINE__,mysqli_connect_error()));
                     
      $sql ="select * from members where username='".$account."'";
      $result = mysqli_query($iConn,$sql) or die(myError(__FILE__,__LINE__,mysqli_error($iConn)));

      if(mysqli_num_rows($result) > 0){
          // already had this account.
         $account_Err .= '<br>['.$account.'] was already a member on Chih Wen\'s website';
      } else{
         // insert new account
         $sql = "INSERT INTO members (username, first_name, last_name, email, passwd) VALUES 
                           ('".$account."', '".$first_name."', '".$last_name."', '".$email."', '".$pwd."')";

         if ($iConn->query($sql) === TRUE) {      
            mysqli_free_result($result);
            mysqli_close($iConn);
            header("Location:member-view.php?type=new&USERNAME=".$account."");     
            
         } else {
            echo "Error: " . $sql . "<br>" . $iConn->error;
            mysqli_free_result($result);
            mysqli_close($iConn);
         }             
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
            <form  style="width:350px;" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
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

               <label>Login Account</label>
               <input type="text" name="account"  value="<?php echo $account; ?>">
               <span class="error"><?php echo $account_Err;?></span>
               
               <label>Login Password</label>
               <input type="password" name="pwd"  value="<?php echo $pwd; ?>">
               <span class="error"><?php echo $pwd_Err;?></span>

               <label>Confirm Password</label>
               <input type="password" name="cfpwd"  value="<?php echo $cfpwd; ?>">
               <span class="error"><?php echo $cfpwd_Err;?></span>


               <label >Agree to be new member.</label>
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
         <p>Already a member?  <a href="login.php">Sign in</a>.</p>
         </article>

         <aside class="links" style="width:180px;">                
            <br>
         </aside>
         <aside class="ads" style="width:180px;">
         <br>
      </aside>

<?php include 'includes/footer.php';?>   