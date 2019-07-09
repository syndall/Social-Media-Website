<?php
session_start();
$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];
require_once("dbcontroller.php");
$profile_id = "";

if(isset($_GET["id"]))
{
    $profile_id = $_GET["id"];
    
}else{header("location:./index.php");}

if(!isset($_SESSION["user_id"]))
     header("location:./index.php");



$db_handle = new DBController();
$following = $db_handle->Count("SELECT COUNT(user_id) AS 'C' FROM following WHERE user_id = '$profile_id'");
$followers = $db_handle->Count("SELECT COUNT(follower_id) AS 'C' FROM following WHERE follower_id = '$profile_id'");
$post = $db_handle->Count("SELECT COUNT(*) AS 'C' FROM posts WHERE user_id = '$profile_id'");
$isfollowing = $db_handle->Count("SELECT COUNT(*) AS 'C' FROM following WHERE user_id = '$user_id' AND follower_id = '$profile_id'");
$posts = $db_handle->runQuery("SELECT p.id AS p, username, body FROM posts p JOIN users u ON 
             u.id = p.user_id WHERE p.user_id = '$profile_id' 
            GROUP BY UNIX_TIMESTAMP(stamp) DESC");
$profile_username = $db_handle->getUsername("SELECT username from users WHERE id = '$profile_id'");


?>
<html>
 
   <head>
       <link rel="shortcut icon" href="./images/logo_rb.png" />
       <title>Profile</title>
   <link href="./css/home1.css" rel="stylesheet" type="text/css" media="all"></link> 
   
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
   <script>
   function followAction(action,id) {
       var queryString;
       switch(action) {
		case "follow":
			queryString = 'action='+action+'&id='+ id;
		break;
		case "unfollow":
			queryString = 'action='+action+'&id='+ id;
		break;
	}
	jQuery.ajax({
	url: "getdata.php",
	data:queryString,
	type: "POST",
	success:function(data){
		switch(action) {
			case "unfollow":
				$(".follow-div").html(data);
				$("#followers").text($("#followers").text()-1);
				$(".btnUnfollowAction").prop('disabled','');
			break;
			case "follow":
			    var currentValue = parseInt($("#followers").text(),10);
				$(".follow-div").html(data);
				$("#followers").text( currentValue + 1);
				$(".btnFollowAction").prop('disabled','');
			break;
		}
	},
	error:function (){}
	});
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
          
         &nbsp; 
         <div id="banner" >
             <img class="banner"width= "100%" height="25%" src="./images/banner.png"></img>
             <center> <img class="profile_img" width= "100px" height="100px" src="./images/logo_rb.png"></img> </center>
        <div class="grey-box">
            <h2 class="uname"><?php echo "@".$profile_username?></h2> 
                  <ul class="stats_2">
                  <li><span id="followers"><?php echo $followers?></span><b style = "font-size:0.6vw">Followers</b></li>
                  <li><span id="following"><?php echo $following?></span><b style = "font-size:0.6vw">Following</b></li>
                  <li><span id="post"><?php echo $post ?></span><b style = "font-size:0.6vw">Post</b></li>
                  </ul>
       
        <?php if($profile_id == $user_id) { ?>
        <div class="label-msg" ><h3> Your Profile</h3></div>
        <?php }elseif($isfollowing == 0){?>
        <div class="follow-div"><button class="btnFollowAction" name="follow"  onClick="followAction('follow',<?php echo $profile_id ?>)">Follow</div>
        </div>
        <?php }elseif($isfollowing == 1) { ?>
        <div class="follow-div"><button class="btnUnfollowAction" name="follow" data-hover="Unfollow"  onClick="followAction('unfollow',<?php echo $profile_id ?>)"></button></div>
        </div>
        <?php }?>
        </div>
        
        <div class="container2">
              <div class="form_style">
              <div id="comment-list-box">
                <?php
                $file = "./images/logo_rb.png";
                if(!empty($posts)) {
                foreach($posts as $k=>$v) {
                ?>   
              <div class="message-box" id="message_<?php echo $posts[$k]["p"];?>">
              <img class="post_img" width= "30px" height="30px" src="<?php echo $file;?>"></img>    
         	  <span class="post-id"><b><?php echo "@". $posts[$k]["username"];?></b></span>
         	  <div class="message-content"><?php echo $posts[$k]["body"]; ?></div>
              </div>    
                <?php }};?>
          </div>
          </div>
          &nbsp;
       </div>   
       
      </center>
     
      
  </body>  
    
    
</html>