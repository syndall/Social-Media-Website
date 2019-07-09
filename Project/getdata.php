<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
$username = $_SESSION["username"];
$user_id = $_SESSION["user_id"];

if(isset($_POST["txtmessage"]))
{
	$body = $_POST["txtmessage"];
}

$datetime = date("Y-m-d H:i:s");

if(isset($_POST["message_id"]))
	$id = $_POST["message_id"];	

$file = "./images/logo_rb.png";

if(isset($_POST["id"]))
     $f_id = $_POST["id"];

$action = $_POST["action"];
if(!empty($action)) {
	switch($action) {
		case "add":
			$result = mysql_query("INSERT INTO posts VALUES(null, '$user_id', '$body', '$datetime')");
			if($result){
				  $insert_id = mysql_insert_id();
				  echo '
				        <div class="message-box"  id="message_' . $insert_id . '">
				         
			              <img class="post_img" width= "30px" height="30px" src='.$file.'></img>    
			         	  <span class="post-id"><b>'. "@".$username.'</b></span>
			         	
			         	 <div class="message-content">' . $_POST["txtmessage"] . '</div>
						<div>
						<button class="btnEditAction" name="edit" onClick="showEditBox(this,' . $insert_id . ')"></button>
                        <button class="btnDeleteAction" name="delete" onClick="callCrudAction(\'delete\',' . $insert_id . ')"></button>
						</div>
						</div> &nbsp;';
			}
			break;
			
		case "edit":
			$result = mysql_query("Update posts set body = '$body' WHERE id = '$id'");
			if($result){
				  echo $body;
			}
			break;			
		
		case "delete": 
			if(!empty($_POST["message_id"])) {
				mysql_query("DELETE FROM posts WHERE id='$id'");
			}
			break;
		case "follow": 
			$result = mysql_query("INSERT INTO following VALUES('$user_id','$f_id')");
			if($result){
				  echo '<button class="btnUnfollowAction" name="follow" data-hover="Unfollow" onClick="followAction(\'unfollow\',' .$f_id. ')"></button>';
			}
			break;
		case "unfollow": 
			if(!empty($_POST["id"])) {
				mysql_query("DELETE FROM following WHERE user_id='$user_id' AND follower_id='$f_id'");
			}
			echo '<button class="btnFollowAction" name="follow" onClick="followAction(\'follow\',' .$f_id. ')">Follow</button>';
			break;
	}
	
}

?>
