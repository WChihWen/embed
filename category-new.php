<?php

include 'includes/header.php';

if (isset($_SESSION["USERNAME"]) == false or $_SESSION["USERNAME"] == NULL){     
    header("Location:login.php");  
}

$CategoryName = "";
$Category_Err ="";
$all_set = true; 

if($_SERVER['REQUEST_METHOD'] == 'POST') {   
    if($_POST['CategoryName'] == NULL){
        $Category_Err = 'Please fill out Category Name';  
        $all_set = false; 
    }else {
        $CategoryName = $_POST['CategoryName'];
    }

    if($all_set == true){
        $iConn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die(myError(__FILE__,__LINE__,mysqli_connect_error()));
        $sql = "INSERT INTO winter2022_rss_category VALUES (NULL,'".$CategoryName."');";

        if ($iConn->query($sql) === TRUE) {                      
            //$print .='Update </b> successfully.<br>';           

            //$print .='Go back <a href="admin.php"><b>Manager Page</b></a>';
            header('Location: rss.php');            
        }else{    
            $sql_err= "SQL_error: " . $sql . "<br><br>";
        }
        mysqli_free_result($result);
        mysqli_close($iConn);
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
            <h3 class="center">New Category</h3>   
            <form  style="width:350px;" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <fieldset>
                    <label for = "CategoryName">New category name:</label>
                    <input for = "CategoryName" type="text" name="CategoryName" value="<?php echo ($CategoryName); ?>"> 
                    <br>
                    <span><?php echo ($Category_Err); ?></span>
                    <br>
                    <div class="center">            
                        <input class="btn" id="submit" type="submit"  value="New">
                        <a href="rss.php" class="button">Cancel</a>  
                    </div>         
                </fieldset>
            </form>          
         </article>
         <aside class="links" style="width:180px;">                
            <br>
         </aside>
         <aside class="ads">
        </aside>

<?php include 'includes/footer.php';?>   