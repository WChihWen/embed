<?php

include 'includes/header.php';

if (isset($_SESSION["USERNAME"]) == false or $_SESSION["USERNAME"] == NULL){     
    header("Location:login.php");  
}

$CategoryName = "";

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
    // insert data    
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
        // insert feeds
        //FeedsID	CategoryID	SubCategory	FeedsFrom	FeedsUrl	DateAdded
        $mydate = date('Y-m-d H:i:s');
        $iConn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die(myError(__FILE__,__LINE__,mysqli_connect_error()));
        $sql = "INSERT INTO winter2022_rss_feeds VALUES (NULL,".$CategoryID.",'".$SubCategory."','".$FeedsFrom."','".$FeedsUrl."','".$mydate."');";

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
    if (isset($_GET["CategoryID"]) && isset($_GET["CategoryName"])){        
        $CategoryID =(int)$_GET["CategoryID"];   
        $CategoryName =$_GET["CategoryName"];        
    } else {
        header('Location: rss.php');
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
            <h3 class="center">Add Feed</h3>
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
                        <input type="submit" class="btn" value="New">
                        <a href="rss.php" class="button">Cancel</a>  
                    </div> 

                    <input type="hidden" id="CategoryID" name="CategoryID" value="<?php echo $CategoryID;?>">
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