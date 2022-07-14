<!-- footer start here -->
  
  <footer class="footer">  
  <hr>    
	<p><small>
     	Copyright &copy; 
      	<?php 
            $date_current = date("Y");
            $date_created = 2021;
            if($date_current == $date_created){
            	echo $date_current;
			}else{
				echo ' '.$date_created .' - '.$date_current.'  ';
			}

          ?>
    	<a href="contact.php" > Chih Wen Wang</a>, All Rights Reserved  ~     
             
      <a href="../index.php" target="_blank">Portal Page</a>
	  </small></p>
  </footer>  
</div>
</main>
</body>    
</html> 

