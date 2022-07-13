<?php 
    include 'includes/header.php';

    if (isset($_SESSION["USERNAME"]) == false or $_SESSION["USERNAME"] == NULL){     
        header("Location:login.php");  
    }

    if (isset($_GET["VID"])){
        $id =(int)$_GET["VID"];
    } else {
        header('Location: videos.php');
    }
    $iConn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die(myError(__FILE__,__LINE__,mysqli_connect_error()));
    $sql = 'select * from videos where video_id ='.$id.'';
   
    $result = mysqli_query($iConn,$sql)  or die(myError(__FILE__,__LINE__,mysqli_error($iConn)));

    $feedback = "";
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $video_id = stripslashes($row['video_id']);
            $video_type = stripslashes($row['video_type']); 
            $video_title = stripslashes($row['video_title']);
            $video_url = stripslashes($row['video_url']);
            $video_memo = stripslashes($row['video_memo']);
            $video_date = stripslashes($row['video_date']);
            $channel_name = stripslashes($row['channel_name']);
            $channel_url = stripslashes($row['channel_url']);
        }
    } else{
       $feedback = 'Somthing is not working!!!';
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
            <div class="center">
                <table style="width:100%;">                
                    <tr>
                        <th style="width:150px;">Category</th>
                        <td style="text-align:left"><?php echo $video_type;?></td>
                    </tr> 
                    <tr>
                        <th style="width:150px;">Subject</th>
                        <td style="text-align:left"><?php echo $video_title;?></td>
                    </tr>   
                    <tr>
                        <th style="width:150px;">Channel</th>
                        <td style="text-align:left"><a href="<?php echo $channel_url; ?>"><?php echo $channel_name; ?></a></td>
                    </tr> 
                    <tr>
                        <th style="width:150px;">Create Date</th>
                        <td style="text-align:left"><?php echo $video_date;?></td>
                    </tr> 
                    <tr>
                        <td colspan="2">
                            <div>  
                                <iframe type="text/html"  width="100%" height="500px" frameborder="0" src="<?php echo $video_url;?>" frameborder="0" allowfullscreen></iframe>
                            </div> 
                        </td>
                    </tr>  
                    <tr>
                        <th style="width:150px;">Memo</th>
                        <td style="text-align:left"><?php echo $video_memo;?></td>
                    </tr>                   
                </table>
            </div>
            <p class="center"><b><a href="videos.php">Back</a></b></p>
        </article>
        <aside class="links" style="width:100px;">                
            <br>
        </aside>
        <aside class="ads" style="width:100px;">
        <br>
        </aside>
    
<?php include 'includes/footer.php';?>