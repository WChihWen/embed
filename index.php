<?php 
include 'includes/header.php';

if (isset($_SESSION["USERNAME"]) == false or $_SESSION["USERNAME"] == NULL){     
   header("Location:login.php");  
}

?> 

<main <?php echo $bc ?>>
    <div class="container">
      <header class="header">
      <a href="index.php" ><img class="logo" src="images/<?php echo $logo ?>" alt="PHP Logo" /></a>
      </header>
         <nav class="navigation">
            <ul>
                  <?= makeLinks($nav1);?>                    
            </ul>            
         </nav>
         <article class="content" >  
         <h1><?php echo $headline?></h1> 
            <h2>Information of the website</h2>
            <section style="text-align:left;">   
               <b>Login Page:</b><br>
               The Login page is to sign in to this website if you like to browse information.
               <br><br>      
               <b>Member Page:</b><br>
               The Member Page is to create a new member to allow access to this website.
               <br><br>                
               <b>Notes Page:</b><br>
               The Notes Page is to show my notes on learning programming languages.
               <br><br>
               <b>Videos Page:</b><br>
               The Videos Page is to collect some tutorial videos on YouTub.
               <br><br>
               <b>Contact Page:</b><br>
               The Contact Page is to contact us.
               
            </section>
         </article>
         <aside class="links" style="width:120px;">     
         </aside>
         <aside class="ads" >    
            <?php include 'includes/aside_ads.php';?>         
         </aside>
    
<?php include 'includes/footer.php';?>
    
