<?php

   include("token.php");    
   include("connect.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
   
      
      $username = mysqli_real_escape_string($db,$_POST['username']);
      $password = mysqli_real_escape_string($db,$_POST['password']); 
      
      $sql = "SELECT id FROM tbl_std WHERE username = '$username' and password = '$password'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    
      
      $count = mysqli_num_rows($result);
      
    
		
      if($count == 1) {
         
         $_SESSION['login_user'] = $username;
         $sql = "SELECT * FROM tbl_std WHERE username = '$username'";
          
         $result = mysqli_query($db, $sql);
         $row = mysqli_fetch_array($result);

         $username = $row['username'];
         $jwt = generate($username, 0, $db);

        $_SESSION['username'] = $username;
        $_SESSION['jwt'] = $jwt;

        $existingToken = generate($username, 1, $db);
        echo "JWT : <br>$jwt";
        echo " <br> EXISTING: <br>$existingToken ";
         
     
      }else {
         $error = "Your Login Name or Password is invalid";
      }
   }
?>
<html>
   
   <head>
      <title>Login Page</title>
   </head>

	
      <div align = "center">
         
    Login
				
         
               <form action = "" method = "post">
                  <label>UserName </label><input type = "text" name = "username" class = "box"/><br /><br />
                  <label>Password  </label><input type = "password" name = "password" class = "box" /><br/><br />
                  <input type = "submit" value = " Submit "/><br />
               </form>

					
         </div>

   </body>
</html>