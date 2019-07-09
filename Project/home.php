<?php
session_start();
$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];
require_once("dbcontroller.php");

if(!isset($_SESSION["user_id"]))
     header("location:./index.php");



$db_handle = new DBController();
$following = $db_handle->Count("SELECT COUNT(user_id) AS 'C' FROM following WHERE user_id = '$user_id'");
$followers = $db_handle->Count("SELECT COUNT(follower_id) AS 'C' FROM following WHERE follower_id = '$user_id'");
$post = $db_handle->Count("SELECT COUNT(*) AS 'C' FROM posts WHERE user_id = '$user_id'");
if($following == 0){
$posts = $db_handle->runQuery("SELECT p.id AS p, username, body FROM posts p JOIN 
                            users u ON u.id = p.user_id  WHERE p.user_id = '$user_id' 
                            ORDER BY p.id DESC");
}else{
$posts = $db_handle->runQuery("SELECT u.id AS u, p.id AS p, username, body FROM 
                             posts p JOIN following f ON p.user_id = f.user_id OR 
                             p.user_id = f.follower_id JOIN users u ON u.id = p.user_id 
                             WHERE( p.user_id = '$user_id' OR f.user_id = '$user_id' ) 
                            GROUP BY p.id DESC");    
}
 



?>
<html>
 
   <head>
       <link rel="shortcut icon" href="./images/logo_rb.png" />
       <title>Home</title>
       
   <link href="./css/home1.css" rel="stylesheet" type="text/css" media="all"></link> 
   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
   <script>
   
    maxL=140;
    var bName = navigator.appName;
    function taLimit(taObj) {
    	if (taObj.value.length==maxL) return false;
    	return true;
    }
    
    function taCount(taObj,Cnt) { 
    	objCnt=createObject(Cnt);
    	objVal=taObj.value;
    	if (objVal.length>maxL) objVal=objVal.substring(0,maxL);
    	if (objCnt) {
    		if(bName == "Netscape"){	
    			objCnt.textContent=maxL-objVal.length;}
    		else{objCnt.innerText=maxL-objVal.length;}
    	}
    	return true;
    }
    function createObject(objId) {
    	if (document.getElementById) return document.getElementById(objId);
    	else if (document.layers) return eval("document." + objId);
    	else if (document.all) return eval("document.all." + objId);
    	else return eval("document." + objId);
    }
   
   function showEditBox(editobj,id) {
	var edit = "edit";
	$('.btnEditAction').hide();
	$('.btnDeleteAction').hide();
	$(editobj).prop('disabled','true');
	var currentMessage = $("#message_" + id + " .message-content").html();
	var editMarkUp = '<textarea maxlength="140" rows="5" cols="60" id="txtmessage_'+id+'">'+currentMessage+'</textarea><button class="btnSaveAction" name="ok" onClick="callCrudAction(\'edit\','+id+')"></button><button class="btnCancelAction" name="cancel" onClick="cancelEdit(\''+currentMessage+'\','+id+')"></button>';
	$("#message_" + id + " .message-content").html(editMarkUp);
    }
    
    function cancelEdit(message,id) {
    	$("#message_" + id + " .message-content").html(message);
    	$('.btnEditAction').show();
	   $('.btnDeleteAction').show();
	   $(".btnEditAction").prop('disabled','');
    	
    }
    
function callCrudAction(action,id) {
	var queryString;
	switch(action) {
		case "add":
			queryString = 'action='+action+'&txtmessage='+ $("#txtmessage").val();
		break;
		case "edit":
			queryString = 'action='+action+'&message_id='+ id + '&txtmessage='+ $("#txtmessage_"+id).val();
		break;
		case "delete":
			queryString = 'action='+action+'&message_id='+ id;
		break;
	}	 
	jQuery.ajax({
	url: "getdata.php",
	data:queryString,
	type: "POST",
	success:function(data){
		switch(action) {
			case "add":
			    var currentValue = parseInt($("#post").text(),10);
				$("#comment-list-box").prepend(data);
				$("#post").text( currentValue + 1);
				$(".pull-right").text("140");
			break;
			case "edit":
				$("#message_" + id + " .message-content").html(data);
				$('.btnEditAction').show();
	            $('.btnDeleteAction').show();
	            $("#message_"+id+" .btnEditAction").prop('disabled','');
			break;
			case "delete":
				$('#message_'+id).fadeOut();
				$("#post").text($("#post").text()-1);
			break;
		}
		$("#txtmessage").val('');
		$("#loaderIcon").hide();
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
         <div class="profile">
               
                <div class="user-info">
                  <img class="user_img" width= "100px" height="100px" src="./images/logo_rb.png"></img>    
                  <h2 class="uname"><?php echo "@".$username?></h2> 
                  <ul class="stats">
                  <li><span id="followers"><?php echo $followers?></span><b style = "font-size:1vw">Followers</b></li>
                  <li><span id="following"><?php echo $following?></span><b style = "font-size:1vw">Following</b></li>
                  <li><span id="post"><?php echo $post ?></span><b style = "font-size:1vw">Post</b></li>
                  </ul>
                </div>
    
         </div>
         
          <div class="container">
           	<div class="row">
         		<div class="span4 well" style="padding-bottom:0">
         		    
                    <div id="frmAdd"><textarea maxlength="140" onKeyPress="return taLimit(this)" 
                    onKeyUp="return taCount(this,'myCounter')" class="span4" id="txtmessage" name="txtmessage"
                    placeholder="What's happending?" rows="3" cols="60"></textarea></div>
                    <button id="btnAddAction" name=submit class="btn btn-info"  type="submit"
                    onClick="callCrudAction('add','')"> Post</button>
                    <b><span class="pull-right"id=myCounter>140</span></b>
            
                 </div>
         	</div>

         
          &nbsp;<br><br><br><br>
              <div class="form_style">
              <div id="comment-list-box">
                <?php
                $file = "./images/logo_rb.png";
                if(!empty($posts)) {
                foreach($posts as $k=>$v) {
                ?>   
              <div class="message-box" id="message_<?php echo $posts[$k]["p"];?>">
              <img class="post_img" width= "30px" height="30px" src="<?php echo $file;?>"></img>    
         	 <div><span class="post-id"><b><?php echo "@". $posts[$k]["username"];?></b></span></div>
         	  <div class="message-content"><?php echo $posts[$k]["body"]; ?></div>
         	  <?php if($posts[$k]["username"] == $username) { ?>
         	  <div>
            <button class="btnEditAction" name="edit" onClick="showEditBox(this,<?php echo $posts[$k]["p"]; ?>)"></button>
            <button class="btnDeleteAction" name="delete" onClick="callCrudAction('delete',<?php echo $posts[$k]["p"]; ?>)"></button>
            </div>
                <?php } else{?>
                <div><a href="./profile.php?id=<?php echo $posts[$k]["u"]?>"><button id="btnViewAction">View Profile</button></a></div>
                <?php }?>
              </div>    
             &nbsp;&nbsp;
                <?php }};?>
          </div>
          </div>
          &nbsp;
       </div>   
      </center>
      
      
      
      
  </body>  
    
    
</html>