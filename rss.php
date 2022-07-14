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
                  <?=makeLinks($nav1)?>                    
            </ul>            
        </nav>
        <article class="content">
            <h1><?php echo $headline?></h1> 
            <div >
                Click <img src="images/add.ico" alt="add"> to add SubCategory.
                <br>
                Click <img src="images/edit.ico" alt="edit"> to edit Category or SubCategory.
            </div>  
            <br>
            <div ><a href="category-new.php">New Category</a></div>  
            <br>
            <?php   
                $iConn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die(myError(__FILE__,__LINE__,mysqli_connect_error()));
                        
                $sql = 'SELECT CategoryID, CategoryName FROM winter2022_rss_category';
                $result = mysqli_query($iConn,$sql)  or die(myError(__FILE__,__LINE__,mysqli_error($iConn)));

                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        $categoryName = stripslashes($row['CategoryName']);
                        echo '
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">'.$categoryName.' &nbsp;
                                    <a href="category-edit.php?CategoryID='.(int)$row['CategoryID'].'"><img src="images/edit.ico" alt="edit"></a>                                    
                                </h3>
                            </div>
                            <div class="panel-body">
                                <ul>';  
                
                                $sqlfeed = 'SELECT * FROM winter2022_rss_feeds WHERE CategoryID='.(int)$row['CategoryID'];
                                $resultfeed = mysqli_query($iConn,$sqlfeed)  or die(myError(__FILE__,__LINE__,mysqli_error($iConn)));
                
                                if(mysqli_num_rows($resultfeed) > 0){
                                    while($rowfeeds = mysqli_fetch_assoc($resultfeed)){
                                        $myId = $rowfeeds['SubCategory'];
                                        $categoryID = $rowfeeds['CategoryID'];
                                        echo '<li><a href="rss-view.php?FeedsID='.(int)$rowfeeds['FeedsID'].'">'.stripslashes($rowfeeds['SubCategory']).'</a> &nbsp; &nbsp; <a href="feeds-edit.php?FeedsID='.(int)$rowfeeds['FeedsID'].'"><img src="images/edit.ico" alt="edit"></a></li>';                                                    
                                    } 
                                    echo '<li><a href="feeds-new.php?CategoryID='.(int)$row['CategoryID'].'&CategoryName='.$row['CategoryName'].'"><img src="images/add.ico" alt="add"></a></li>';  
                                }
                            echo '
                                </ul>  
                            </div>
                        </div>	
                        ';
                    }
                } else{
                    echo 'Houston, we have a problem!';                    
                }

                mysqli_free_result($result);
                mysqli_close($iConn);
            ?> 
        </article>
        <aside class="links" style="width:10px;">                
            <br>
        </aside>
        <aside class="ads" style="width:10px;">  
            <br>          
        </aside>
    
<?php include 'includes/footer.php';?>
    