<?php
session_start();
$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];
require_once("dbcontroller.php");
$search_result = "";

if(isset($_POST["search"]))
{
  $search_result = $_POST["search"];        
}else header("location:./index.php");

if(!isset($_SESSION["user_id"]))
     header("location:./index.php");

$db_handle = new DBController();

$user_result = $db_handle->runQuery("SELECT id, username from users WHERE username LIKE '$search_result%' OR username LIKE '%$search_result'");
$post_result = $db_handle->runQuery("SELECT username, u.id as u, body FROM posts p JOIN users u ON u.id = p.user_id WHERE body LIKE '$search_result%' OR body LIKE '%$search_result'");

?>
<html>
 
   <head>
       <link rel="shortcut icon" href="./images/logo_rb.png" />
       <title>Search</title>
   <link href="./css/home1.css" rel="stylesheet" type="text/css" media="all"></link> 
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
   <script>
        function showResult(evt, result) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(result).style.display = "block";
            evt.currentTarget.className += " active";
        }
  </script>
  </head>   
  
  
  <body>
      
      <div class="nav">
        <div class ="menu-bar"> 
        
		 <ul>
		 	<li style="border-radius:50px"><a href="./home.php"><b>Home</b></a></li>
		 	<li style="border-radius:50px"><a href="./profile.php?id=<?php echo $user_id?>"><b>Profile</b></a></li>
		 	<form action="./search.php" method="post"><input  type="text" name="search" placeholder="Search.."></form>
		 	<center> <img class="logo" width= "30px" height="30px" src="./images/logo_rb.png"></img></center>
		 	<li style="float:right; margin-top:-69px"><a href="./logout.php"><b>Logout</b></a></li>
         </ul> 
         
	   </div>  
      </div>
      
   
      
      
      
      <center>
         <div class="container2"> 
         <h2 style="color:#9D2235">Search Results for <?php echo " ".$search_result?></h2>

        <ul class="tab">
          <li><a style="color:#9D2235" href="javascript:void(0)" class="tablinks" onclick="showResult(event, 'People')"><b>People</b></a></li>
          <li><a style="color:#9D2235" href="javascript:void(0)" class="tablinks" onclick="showResult(event, 'Posts')"><b>Posts</b></a></li>
        </ul>
    
        <div id="People" class="tabcontent">
                <?php
                $file = "./images/logo_rb.png";
                if(!empty($user_result)) {
                foreach($user_result as $k=>$v) {
                ?>   
             <div class="search-con">
             <img width= "30px" height="30px" src="<?php echo $file;?>"></img>    
         	  <span style="color:#9D2235"><b><?php echo "@". $user_result[$k]["username"];?></b></span>
              </div>
              <div><a href="./profile.php?id=<?php echo $user_result[$k]["id"]?>"><button id="btnViewAction">View Profile</button></a></div>
                <?php }}else {;?>
                <div><h3 style="color:#9D2235">No Users Found</h3></div>
                <?php };?>
        </div>
        
        <div id="Posts" class="tabcontent">
          <?php
                $file = "./images/logo_rb.png";
                if(!empty($post_result)) {
                foreach($post_result as $k=>$v) {
                ?>   
             <div class="search-con">
             <img width= "30px" height="30px" src="<?php echo $file;?>"></img>    
         	  <span style="color:#9D2235"><b><?php echo "@". $post_result[$k]["username"];?></b></span>
         	  <div style="color:black" ><?php echo $post_result[$k]["body"]; ?></div>
               </div>
               <div><a href="./profile.php?id=<?php echo $post_result[$k]["u"]?>"><button id="btnViewAction">View Profile</button></a></div>
                <?php }}else {;?>
                <div><h3 style="color:#9D2235">No Post Found</h3></div>
                <?php };?> 
        </div>

    </div>    
      </center>
      
      
      
      
  </body>  
    
    
</html>
