<?php
include("connect.php");
session_start();
$emailerr = "Email";
$usernerr="Username";
$passwerr= "Password";
$uerr = "Username";
$perr = "Password";
$wrong ="";

if(isset($_POST["signup-submit"])){

    $email = $_POST["txtemail"];
    $username = $_POST["txtname"];
    $password = $_POST["txtpass"];
    
    // Check
    if(empty($email))
        $emailerr = "Please enter a Email";
    if(empty($username))
        $usernerr = "Please enter a Username";
    if(empty($password))
        $passwerr = "Please enter a Password";    
    
    
    if(!empty($email) && !empty($username) &&!empty($password))
    {
        $usercheck_sql = " SELECT * FROM users WHERE username = '$username'";
        $insert_sql = "INSERT INTO users (id, username, email, password)
                    VALUES (null, '$username', '$email', '$password');";
     
     $result = mysql_query($usercheck_sql); 
     
       if(mysql_num_rows($result) > 0)
            $usernerr = "Username Aleardy Exist!";
        else
        {
           mysql_query($insert_sql);
           $insert_id = mysql_insert_id(); 
           mysql_close();
           $_SESSION["username"] = $username;
           $_SESSION["user_id"] = $insert_id;
           header("location:./home.php");
        }
           
       
    }

}

if(isset($_POST["signin-submit"])){
  

    $username = $_POST["uname"];
    $password = $_POST["upass"];
    
    if(empty($username))
        $uerr = "Please enter a Username";
    if(empty($password))
        $perr = "Please enter a Password";
    
    if( !empty($username) &&!empty($password))
  {
      
    $check_sql = "SELECT id FROM users WHERE username = '$username' AND  password = '$password'";
    $result = mysql_query($check_sql); 

       if(mysql_num_rows($result) > 0)
       {
           while ($row = mysql_fetch_array($result))
            {
               $_SESSION["user_id"] = $row["id"]; 
            }
        mysql_close();
           $_SESSION["username"] = $username;
           header("location:./home.php");
       }
       else
            $wrong = "<h4 style=color:#9D2235>Invalid Username or Password</h4>";
            
            
        mysql_close();       
       
    
    }
  

}


?>