<?php include 'includes/header.php';?> 

<?php     

    if (isset($_GET["USERNAME"])){
        $USERNAME = $_GET["USERNAME"];
    }else{    
        if (isset($_SESSION["USERNAME"])){
            $USERNAME = $_SESSION["USERNAME"];
        }else{
            $USERNAME = NULL;
        }        
    }
 
    if ($USERNAME == NULL || $USERNAME == ""){
        header('Location: index.php');        
    } else {
        $type =$_GET["type"];
        $iConn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die(myError(__FILE__,__LINE__,mysqli_connect_error()));
        $sql = "select * from members where username ='".$USERNAME."'";
      
        $result = mysqli_query($iConn,$sql)  or die(myError(__FILE__,__LINE__,mysqli_error($iConn)));
        
        if(mysqli_num_rows($result) > 0){            
            $row = mysqli_fetch_assoc($result);
            $str = '<ul class="ulnone">';
            $str .= '<li><b>First Name:</b> '.$row['first_name'].'</li>';
            $str .= '<li><b>Last Name:</b> '.$row['last_name'].'</li>';
            $str .= '<li><b>Email:</b> '.$row['email'].'</li>';
            $str .= '<li><b>Lgoin Account:</b> '.$row['username'].'</li>';         
            $str .= '</ul><br>'; 
            $welcome ='';
            switch($type){            
                case 'login':
                    $welcome = '        
                        <p>Hi '.$row['first_name'].', you have signed in Chih Wen\'s website.<br> 
                        Please go to the <a href="index.php">home page</a>.</p>';
                    break;

                case 'new':
                    $welcome = '
                        <p>Hi '.$row['first_name'].', you have become a new member on Chih Wen\'s website.<br> 
                        Please go to the <a href="login.php">login page</a> to sign in.</p>';
                    break;
                default:
                    header('Location: index.php');
                    break;
            }
            
        } else{
            $str ='['.$USERNAME.'] is not a member!';
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
        <article class="content" style="display:flex; flex-direction: column;  flex-wrap: wrap;">
            <h1><?php echo $headline?></h1> 
            <div class="center">
            <?php echo $str ;?>
            </div>
            <div class="center">
                <br>
               <?php echo $welcome ;?>
            </div>
        </article>
        <aside class="links" style="width:180px;">                
            <br>
        </aside>
        <aside class="ads"  style="width:180px;">
        <br>
        </aside>
    
<?php include 'includes/footer.php';?>