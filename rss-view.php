<?php 
    include 'includes/header.php';

    if (isset($_SESSION["USERNAME"]) == false or $_SESSION["USERNAME"] == NULL){     
        header("Location:login.php");  
    }

    if (isset($_GET["FeedsID"])){        
        $FeedsID =(int)$_GET["FeedsID"];       
    } else {
        header('Location: news.php');
    }

    //Load Feeds data
    $iConn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die(myError(__FILE__,__LINE__,mysqli_connect_error()));
    $sql = 'select a.CategoryName,b.* from winter2022_rss_feeds b inner join winter2022_rss_category a on a.CategoryID = b.CategoryID where b.FeedsID ='.$FeedsID ;

    $CategoryName ='';
    $SubCategory ='';
    $FeedsFrom ='';
    $FeedsUrl ='';
    //$DateAdded ='';
    $result = mysqli_query($iConn,$sql)  or die(myError(__FILE__,__LINE__,mysqli_error($iConn)));
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);    

        $CategoryName = stripslashes($row['CategoryName']);
        $SubCategory = stripslashes($row['SubCategory']);
        $FeedsFrom = stripslashes($row['FeedsFrom']);
        $FeedsUrl = stripslashes($row['FeedsUrl']);
        //$DateAdded = stripslashes($row['DateAdded']);
    } else{
        header('Location: news.php');
    }
    //session_start();
    include 'Class/Feed.php';
    $myitems = array();   
   
    // load xml data from FeedsUrl
    $request = $FeedsUrl;
    $response = file_get_contents($request);
    $xml = simplexml_load_string($response);          

    // store news list in $myitems[]
    $title ="title";
    $link = "link";
    $pubDate = "pubDate";
    foreach($xml->channel->item as $story){      
        $ArySplit = explode(" - ", $story->$title); //$story->title
        $NewsTitle = $ArySplit[0];
        $NewsUrl = $story->$link; // $story->link
        $PubDate = $story->$pubDate; //$story->pubDate
        $Source = "";//$story->source;
        $SourceUrl = "";// $story->source->attributes()->url;   
        
        $myitems[] = new Feed($ArySplit[0],$NewsUrl,$PubDate,$Source,$SourceUrl);    
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
                    <h3><?php echo '<b>'.$CategoryName.'</b> > <b>'.$SubCategory.'</b> <br> Source: <a href="'.$FeedsUrl.'" target="_blank">'.$FeedsFrom ?></a></h3>
                </div>   
                <div class="center">
                    <table style="width:80%;">
                        <thead>
                        <tr>
                            <th>No.</th>					
                            <th scope="col">Link</th>
                            <!-- <th scope="col">Source</th> -->
                            <th scope="col">Public Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php                
                            for ($i = 0; $i < count($myitems) - 1; $i++) {   
                                //<td><a href="'.$myitems[$i]->sourceUrl.'" target="_blank">'.$myitems[$i]->source.'</a></td>                     
                                echo '
                                <tr>
                                    <th>'.($i + 1).'</th>
                                    <td style="text-align:left;"><a href="'.$myitems[$i]->link.'" target="_blank">'.$myitems[$i]->title.'</a></td>                             
                                    <td style="text-align:left;">'.$myitems[$i]->pubDate.'</td>
                                </tr>';                    
                            }  
                        ?>  
                        </tbody>
                    </table>  
                </div>        
                                   
            
            <p class="center"><b><a href="rss.php">Back</a></b></p>
        </article>
        <aside class="links" style="width:100px;">                
            <br>
        </aside>
        <aside class="ads" style="width:100px;">
        <br>
        </aside>
    
<?php include 'includes/footer.php';?>