<?php 

	include 'DatabaseConn.php';
	include 'UtilFunctions.php';

	//functions to do the processing through AJAX.
	if($_GET["no"] == "1") {
		GetAnnouncements($_GET["userID"], $_GET["userEmail"]);		
	}
	else if($_GET["no"] == "2") {
		GetResumes($_GET["userID"], $_GET["userEmail"]);
	}

    //to get all the resumes for a particular userID     
    function GetResumes($userID, $userEmail) {         
    	global $connection;         
    	$i = 1;         
    	$response = "<div class='resumes'><table class='table table-hover'><tr><td>Sr No.</td><td>Download Resumes</td></tr>"; 
        $query = "select * from resumes where UserID = '$userID'"; 
        $rs= mysql_query($query);         
        if(!$rs) {             
        	die("Cannot get the resumes. Please try again.");         
        }
		else {             
			while ($res = mysql_fetch_array($rs)) {
				$rLink = trim($res["ResumeLink"], "/var/www/html/PlaceMeNow");                 
				$response .= "<tr><td>" . $i . "</td><td><a class='resumeLink' name='"  . $rLink . "' href='" . $rLink . "' taget='_blank'>Download Resume " . $i . "</a></td></tr>";             
				//$response .= "<tr><td>" . $i . "</td><td><a class='resumeLink' name='"  . $res["ResumeLink"] . "' href='#' taget='_blank'>Download Resume " . $i . "</a></td></tr>";             
				$i++;
			}
			$response .= "</table></div>";         
		} 
		//echo $rLink;
		echo $response;    
	}

	//to get all the announcements from all the admins
	function GetAnnouncements($userID, $userEmail) {
		global $connection;
		$response = "";
		$admins = getAllAdmins();
		$query = "select * from announcements where UserID in (";
		$adminCount = count($admins);
		for ($i=0; $i < $adminCount; $i++) { 
			$query .= "'" . array_pop($admins) . "', ";
		}
		$query = trim($query, ", ");
		$query .= ")";

		$rs = mysql_query($query, $connection);

		if(!$rs) {
			echo "Cannot get your dashboard. Please try again.";
		}
		else {
			while ($ann = mysql_fetch_array($rs)) { 
	        	$response .= "<div class='annShow' style='width: auto; height: auto;
	padding: 10px 10px 10px 10px; margin: 20px 20px 20px 20px; border: 1px solid black; border-radius: 10px; background:
	rgb(251,251,251);'><p style='width: 80%; height: auto; font-size: 1.8em;display: block;'> " . $ann["Header"] .
	"</p><span style='width: auto; height: auto; margin: 2px 2px 2px 2px; font-size: 1.0em; display: block;'> Posted On: " .
	$ann["AnnTime"] . "</span><hr style='display:block;' /><p style='width: auto; height: auto; font-size: 1.3em;display: block
	;text-align: justify; margin-bottom: 5%;'>" . $ann["Content"] . "</p></div>";         
			}          
			echo $response;
		} 
	}

?>