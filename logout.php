<?php 

include 'includes/header.php';

if (isset($_GET["logout"])){
    if($_GET["logout"] == 'do'){
        session_destroy();
        header('Location: index.php');   
    }
}else{
    if (isset($_SESSION["USERNAME"]) && $_SESSION["USERNAME"] != NULL){  
      
    }else{
        header('Location: index.php');        
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
    
    <article class="content" >
        <h1><?php echo $headline?></h1>   
        <p><?php echo 'Hi '.$_SESSION["USERNAME"].', do you like to sign out?';?></p>     
        <br>
        <br>
        <div class="center"><a class="button" href="logout.php?logout=do">Confirm</a>   <a href="index.php" class="button">Cancel</a></div>
    </article>

    <aside class="links" style="width:180px;">                
    <br>
    </aside>
    <aside class="ads" style="width:180px;">
    <br>
    </aside>
    
<?php include 'includes/footer.php';?>