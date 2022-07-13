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
            <p class="center"><b><a href="video-new.php">New Video</a></b></p>  
            <?php   
                $iConn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die(myError(__FILE__,__LINE__,mysqli_connect_error()));
                        
                $sql ='select * from videos order by video_type ASC';
                $result = mysqli_query($iConn,$sql)  or die(myError(__FILE__,__LINE__,mysqli_error($iConn)));

                if(mysqli_num_rows($result) > 0){
                    echo '<div class="center">';                  
                    $i = 0;               
                    echo '<table style="width:90%">';
                    echo '<tr>';
                    echo '<th style="width:40px;">No.</th>';
                    echo '<th style="width:100px;">Category</th>'; 
                    echo '<th >Subject</th>';                    
                    echo '<th>Channel</th>';
                    echo '<th style="width:100px">Create Date</th>';
                    echo '</tr>';
                    while($row = mysqli_fetch_assoc($result)){                          
                        echo '<tr>';
                        echo '<th>'.($i + 1).'</th>'; 
                        echo '<td>'.$row['video_type'].'</td>';                       
                        echo '<td style="text-align:left;"><a href="video-view.php?VID='.$row['video_id'].'">'.$row['video_title'].'</a></td>'; 
                        echo '<td><a href="'.$row['channel_url'].'" target="_blank">'.$row['channel_name'].'</a></td>';
                        echo '<td>'.$row['video_date'].'</td>';
                        $i = $i + 1;
                    }
                    
                    echo '</table>';
                    echo '</div>';
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