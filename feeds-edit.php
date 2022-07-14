<?php

include 'includes/header.php';

if (isset($_SESSION["USERNAME"]) == false or $_SESSION["USERNAME"] == NULL){     
    header("Location:login.php");  
}

$CategoryName = "";
$FeedsID = 0;
$CategoryID = 0;
$SubCategory="";
$FeedsFrom="";
$FeedsUrl="";

$SubCategory_Err="";
$FeedsFrom_Err="";
$FeedsUrl_Err="";

$all_set = true; 

$print="";
$sql_err="";

if($_SERVER['REQUEST_METHOD'] == "POST"){
// update data    
    $FeedsID = (int)$_POST['FeedsID'];
    $CategoryID = (int)$_POST['CategoryID'];

    if($_POST['SubCategory'] == NULL){
        $SubCategory_Err = 'Please fill out SubCategory';  
        $all_set = false; 
    }else {
        $SubCategory = $_POST['SubCategory'];
    }

    if($_POST['FeedsFrom'] == NULL){
        $FeedsFrom_Err = 'Please fill out FeedsFrom';  
        $all_set = false; 
    }else {
        $FeedsFrom = $_POST['FeedsFrom'];
    }

    if($_POST['FeedsUrl'] == NULL){
        $FeedsUrl_Err = 'Please fill out FeedsUrl';  
        $all_set = false; 
    }else {
        $FeedsUrl = $_POST['FeedsUrl'];
    }

   
    if($all_set == true){
        // update feeds
        $iConn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die(myError(__FILE__,__LINE__,mysqli_connect_error()));
        $mydate = date('Y-m-d H:i:s');
        $sql = 'UPDATE winter2022_rss_feeds SET SubCategory="'.$SubCategory.'", FeedsFrom ="'.$FeedsFrom.'",FeedsUrl="'.$FeedsUrl.'",DateAdded="'.$mydate.'" 
                WHERE FeedsID='.$FeedsID ;

        if ($iConn->query($sql) === TRUE) {  
            header('Location: rss.php');            
        }else{    
            $sql_err= "SQL_error: " . $sql . "<br><br>";
        }  
    }
    mysqli_free_result($result);
    mysqli_close($iConn);
}else{
// load data 
    if ( isset($_GET["FeedsID"])){        
        $FeedsID =(int)$_GET["FeedsID"];       
    } else {
        header('Location: admin.php');
    }
    //Load Feeds data
    $iConn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die(myError(__FILE__,__LINE__,mysqli_connect_error()));
    $sql = 'select a.CategoryName,b.* from winter2022_rss_feeds b
            inner join winter2022_rss_category a on a.CategoryID = b.CategoryID
            where b.FeedsID ='.$FeedsID ;

    $result = mysqli_query($iConn,$sql)  or die(myError(__FILE__,__LINE__,mysqli_error($iConn)));
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);   
        $CategoryName = stripslashes($row['CategoryName']);
        $SubCategory = stripslashes($row['SubCategory']);
        $FeedsFrom = stripslashes($row['FeedsFrom']);
        $FeedsUrl = stripslashes($row['FeedsUrl']);
        $CategoryID =(int)($row['CategoryID']);
    }else{
        // if there is no feedsID, go back admin
        header('Location: admin.php');
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
            <h3 class="center">Edit Feed</h3>
            <br>
            <form  style="width:500px;" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <fieldset>
                    <label>Category: <?php echo $CategoryName;?></label>
                    <br>
                    <label>SubCategory:</label>
                    <input type="text" name="SubCategory" value="<?php echo $SubCategory;?>">                     
                    <span class="error"><?php echo $SubCategory_Err;?></span>
                    <br>
                    <label>Feed From:</label>
                    <input type="text" name="FeedsFrom" value="<?php echo $FeedsFrom;?>"> 
                    <span class="error"><?php echo $FeedsFrom_Err;?></span>
                    <br>
                    <label>FeedsUrl:</label>
                    <textarea name="FeedsUrl" style="width:98%;"  rows="5"><?php echo $FeedsUrl;?></textarea>
                    <span class="error"><?php echo $FeedsUrl_Err;?></span>
                    <br>
                    <div class="center">            
                        <input type="submit" class="btn" value="Update">
                        <a href="rss.php" class="button">Cancel</a>  
                    </div> 
                    
                    <input type="hidden" id="CategoryID" name="CategoryID" value="<?php echo $CategoryID;?>">
                    <input type="hidden" id="FeedsID" name="FeedsID" value="<?php echo $FeedsID;?>">
                </fieldset>
            </form>
            <br>
            <span ><?php echo $print;?></span>
            <span class="error"><?php echo $sql_err;?></span>      
         </article>
         <aside class="links" style="width:180px;">                
            <br>
         </aside>
         <aside class="ads">
        </aside>

<?php include 'includes/footer.php';?>   