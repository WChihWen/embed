
 <?php include 'includes/header.php';?>  
 <?php include 'includes/js.php';?>  
 <?php 

    if (isset($_SESSION["USERNAME"]) == false or $_SESSION["USERNAME"] == NULL){     
        header("Location:login.php");  
    }

    $lang ="";

    if (isset($_GET["lang"])){
        $lang = $_GET["lang"];    
    }

    switch($lang){
        case 'Java':  
        case 'Python':  
        case 'PHP':
            break;        
        default:          
            $lang ="Java";
            break;
    }
    $lowLang =strtolower($lang);    
?>

<script>
    //var myLang = 'Java';
    var myLang = '<?php echo $lang;?>';    
    $( function() {
        //hljs.initHighlightingOnLoad(); // load code space style   
        loadinitialpage();
        defineClickEvent();   
    }); 
    
    function loadinitialpage(){    
        $.ajax({
            url : "txt/"+ myLang +"_history.txt", 
                dataType: "text",
                success : function (data) {
                    $("#divshowhistory").html(data);
                    $("#h4History").html("Language history");
                    showdiv('History');
                }
        }); 
    }
    function defineClickEvent(){
        $("#li-history").click(function() {
            loadinitialpage();
        });
        $("#li-declaration").click(function() {
            loadtxt("txt/"+ myLang +"_declaration.txt", myLang + " Variable declarations");      
        });
        $("#li-loop").click(function() {
            loadtxt("txt/"+ myLang +"_loop.txt", myLang + " Loop");    
        });
        $("#li-branches").click(function() {
            loadtxt("txt/"+ myLang +"_branches.txt" , myLang + " Branches");    
        });
    }

    function loadtxt(_file, _h4txt){
        $.ajax({
            url : _file,
                dataType: "text",
                success : function (data) {
                $("#mycode").html(data);
                $("#h4Code").html(_h4txt);
                hljs.highlightAll(); // load code space style     
                showdiv('Code');
                }
            }); 
    }

    function showdiv(_type){
        if (_type == 'History'){
            $("#divhistory").show(); 
            $("#divcode").hide(); 
        } else {
            $("#divhistory").hide(); 
            $("#divcode").show();
        }    
    }
</script>

<main <?php echo $bc ?>>
<div class="container">
    <header class="header">  
        <a href="index.php" ><img class="logo" src="images/<?php echo $logo ?>" alt="TV Show" /></a>
    </header>
    <nav class="navigation">
        <ul>
            <?=makeLinks($nav1)?>                    
        </ul>  
        <br>              
    </nav>
    <article class="content" style="width:75%">          
            <h1><?php echo $headline?></h1>  
            <div id="divUl">
                <ul >
                    <li><a <?php if($lang == 'Java'){ echo 'class="current"';}?> href="notes.php?lang=Java" >Java</a></li>
                    <li><a <?php if($lang == 'Python'){ echo 'class="current"';}?> href="notes.php?lang=Python" >Python</a></li>     
                    <li><a <?php if($lang == 'PHP'){ echo 'class="current"';}?> href="notes.php?lang=PHP" >PHP</a></li>                  
                </ul>
            </div>
            <div id="divhistory">
                <br>
                <h4 id="h4History"></h4>
                <div id="divshowhistory"></div>
            </div>
            <div id="divcode" >
                <h4 id="h4Code"></h4>
                <pre><code id="mycode" class="<?php echo $lowLang;?>"></code></pre>
            </div>        
    </article>
    <aside class="links">  
      
        <div class="list-type5">
            <h1>Category- <?php echo $lang;?></h1>   
            <ol>
                <li id="li-history"><a href="#">History</a></li>
                <li id="li-declaration"><a href="#">Declaration</a></li>
                <li id="li-loop"><a href="#">Loop</a></li>
                <li id="li-branches"><a href="#">Branches</a></li>
            </ol>   
        </div>
    </aside>
    <aside class="ads">       
    </aside>
    
<?php include 'includes/footer.php';?>