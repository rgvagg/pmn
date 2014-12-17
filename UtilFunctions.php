<?php 

	include 'DatabaseConn.php';

	//to see if the user email already exists in the users table
	function checkEmail($email, $table) {
		global $connection;
		$qr = "select * from " . $table . " where UserEmail='$email'";
		$rs = mysql_query($qr, $connection);
		if(!$rs) {
			die("Error in Check Email function. " . mysql_error());
		}
		else {
			if(mysql_num_rows($rs) == 1) {
				return true;
			}
			else {
				return false;
			}  
		}
	}

	//function to get the user type of the user passed!
	function getUserType($email) {
		global $connection;
		$qr = "select * from users where UserEmail='$email'";
		$rs = mysql_query($qr, $connection);
		if(!$rs) {
			die("Error in Check Email function. " . mysql_error());
		}
		else {
			while ($us = mysql_fetch_array($rs)) {
				return $us["UserType"];
			}
		}	
	}

	//this is the function to check if the session exists or not
	function checkSession() {
		if(isset($_SESSION["UserID"]) && isset($_SESSION["UserEmail"])) {
			return true;
		}
		else {
			return false;
		} 
	}

	//this is to get all the admins of the database
	function getAllAdmins() {
		global $connection;
		$admins = array();
		$qr = "select * from users where UserType='A'";
		$rs = mysql_query($qr, $connection);
		if(!$rs) {
			die("Error in GetAllAdmins Function");
		}
		else {
			while ($ad = mysql_fetch_array($rs)) {
				array_push($admins, $ad["UserID"]);
			}
		}
		return $admins;
	}    

	//to check for the type of the image uploaded.
	function checkFileType() {
		$imageFileType = strtolower($imageFileType);
        if($imageFileType != "pdf" && $imageFileType != "doc" && $imageFileType != "docx") {
            return false;
        }   
        else {
            return true;
        }
    }

?>
