<?php

include 'includes/header.php';

if (isset($_SESSION["USERNAME"]) == false or $_SESSION["USERNAME"] == NULL){     
    header("Location:login.php");  
}

$CategoryID = 0;
$CategoryName = "";

$errorMsg = "";

$print="";
$sql_err="";

$iConn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die(myError(__FILE__,__LINE__,mysqli_connect_error()));
if($_SERVER['REQUEST_METHOD'] == 'POST') {   
    $CategoryID = (int)$_POST['CategoryID'];

    if(empty($_POST['CategoryName'])){
        $errorMsg .= 'Please enter a new category name.';
    }else {
        $CategoryName = $_POST['CategoryName'];

        
        if(isset($_POST['CategoryName'])){
            
            $sql = 'UPDATE winter2022_rss_category SET CategoryName = "'.$CategoryName.'" WHERE CategoryID = '.$CategoryID;

            if ($iConn->query($sql) === TRUE) {        

                $print .='Update </b> successfully.<br>';           

                header('Location: rss.php');
            } else{    
                $sql_err= "SQL_error: " . $sql . "<br><br>";
            } 
        }

    }
} else {
    if ( isset($_GET['CategoryID'])){        
        $CategoryID =(int)$_GET["CategoryID"];       
    } else {
        header('Location: admin.php');
    }
    //Load Feeds data
    $sql = 'select * from winter2022_rss_category where CategoryID ='.$CategoryID ;

    $result = mysqli_query($iConn,$sql)  or die(myError(__FILE__,__LINE__,mysqli_error($iConn)));
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);   
        $CategoryName = stripslashes($row['CategoryName']);
        $CategoryID =(int)($row['CategoryID']);
    }else {
        // if there is no feedsID, go back admin
        header('Location: rss.php');
    }
    mysqli_free_result($result);
    mysqli_close($iConn);
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
            <h3 class="center">Edit Category</h3>  
            <form  style="width:350px;" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <fieldset>
                    <label for = "CategoryName">New category name:</label>
                    <input for = "CategoryName" type="text" name="CategoryName" value="<?php echo ($CategoryName); ?>"> 
                    <br>
                    <span><?php echo ($errorMsg); ?></span>
                    <br>
                    <div class="center">            
                        <input id="submit" class="btn" type="submit"  value="Update">
                        <a href="rss.php" class="button">Cancel</a>  
                    </div> 
                    <input type="hidden" id="CategoryID" name="CategoryID" value="<?php echo $CategoryID;?>">
                </fieldset>
            </form> 
         </article>
         <aside class="links" style="width:180px;">                
            <br>
         </aside>
         <aside class="ads">
        </aside>

<?php include 'includes/footer.php';?>   