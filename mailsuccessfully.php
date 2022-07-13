<?php include 'includes/header.php';?> 

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
            <?php
                $first_name ='';
                $to ='';
                if (isset($_GET["first_name"])){
                    $first_name =$_GET["first_name"];                
                }
                if (isset($_GET["to"])){
                    $to =$_GET["to"];                
                }
                echo '<p>';
                echo '                 
                <br><br><br><br>  
                Hello, <b>' .$first_name. '</b> <br>
                Thanks for contacting us.
                This email was sent to <b>'.$to.'</b> successfully! <br><br> 
                Click <a href="index.php">here,</a> to go to home page.
                <br><br><br><br><br><br>                     
                ';
                echo '</p>';
            ?>
         </article>
         <aside class="links">     
         </aside>
         <aside class="ads">            
         </aside>
    
<?php include 'includes/footer.php';?>