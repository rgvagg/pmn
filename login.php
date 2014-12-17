<?php

include 'DatabaseConn.php';
include 'UtilFunctions.php';

session_start();

if(isset($_POST["btnLogin"])) {
    $name=$_POST["txtUsername"];
    $pass=$_POST["txtPassword"];
    $query="select * from users where UserEmail='$name' and UserPwd='$pass'";
    $rs=mysql_query($query,$connection);
    if(!$rs) {
        //die("Results cannot be obtained. Please recheck.");
        header("location: login.php?l=-1");
    }
    else if(mysql_num_rows($rs) == 0) {
        //echo "Entry does not exists into the database!";
        header("location: login.php?l=-1");
        //die("Entry does not exists into the database. Please check your username and password.");
    }
    else {
        while ($us = mysql_fetch_array($rs)) {
            if(checkEmail($us["UserEmail"], "users")) {
                //$_SESSION["UserID"] = mysql_result($rs, 0, "UserID");
                //$_SESSION["UserEmail"] = mysql_result($rs, 0, "UserEmail");

                $_SESSION["UserID"] = $us["UserID"];
                $_SESSION["UserEmail"] = $us["UserEmail"];

                //die($_SESSION["UserID"] . " --> " . $_SESSION["UserEmail"]);
                //die($us["UserID"] . " --> " . $us["UserEmail"]);

                if(getUserType($us["UserEmail"]) == "A") {
                    header("location: admin.php");
                }
                else if (getUserType($us["UserEmail"]) == "B") {
                    header("location: Dashboard.php");
                }
                else {
                    die("The Type of the user cannot be retrieved.");
                }
            }
            else {
                die("More than one user with Same Email Exists. Fatal Error. Please contact the Administrator.");
            }
        }
    }
}
mysql_close($connection);
?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Place Me Now - Login</title>

    <!-- for the favicon -->
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
	<link rel="icon" href="images/favicon.ico" type="image/x-icon" />
    
    <!--for jQuery-->
    <!--<script src="js/jquery-1.7.1.min.js"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- this is for the custom scripts that i wrote! -->
    <script src="js/Scripts.js"></script>

    <!--for the custom stylesheet for this particular project -->
    <link rel="stylesheet" type="text/css" href="css/StyleSheet.css" />

    <style type="text/css">
          @font-face {
            font-family: headerText3;
            src: url(fonts/SEGOEUIL_BOLD.ttf);
        }
    </style>

    <script type="text/javascript">1

        $(document).ready(function () {
            
            //for the popup and the alert Msg!
            var alertMsg = $('#alertMsg').hide(1);
            var popup = $('#popup').hide(1);
            //button to hide the popup appearing!
            $('#btnExitPopup').on('click', function () {
                popup.fadeOut();
                return false;
            });

            var qs = getQueryStrings();

            //for navigating to the signup page
            $('#btnSignUpNavigate').on('click', function () {
                window.location.href = "Signup.php";
                return false;
            });

            if(qs["signup"] == "1") {
                popup.children('p').remove();
                popup.append("<p>You have successfully signed up. You might want to login now. Thank You.</p>").fadeIn('fast');
            }
            else if(qs["logout"] == 1) {
                popup.children('p').remove();
                popup.append("<p>Thank You for using the portal. You have successfully logged out.</p>").fadeIn('fast');
            }
            else if(qs["session"] == 1) {
                popup.children('p').remove();
                popup.append("<p>Your session does not exists/has expired. Please login again.</p>").fadeIn('fast');
            }
            else if(qs["l"] == -1) {
                popup.children('p').remove();
                popup.append("<p>Login Failed. Please Recheck your login credenatials.</p>").fadeIn('fast');
            }

            //for the logging in the user
            /*$('#btnLogin').on('click', function() {
                return false;
            });  */
        });

    </script>

</head>
<body style="background: #070716;">
    <div class="alert alert-info" style="position:fixed; z-index: 9999; font-size: 1.3em; left: 0%;" id="alertMsg">
    </div>

    <div class="alert alert-warning" role="alert" id="popup" style="position:fixed; z-index: 9999; font-size: 1.3em; left: 2%; top: 3%; right: 2%;">
        <button id="btnExitPopup" type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    </div>

    <!-- for the responsive model-->
    <div id="mainLogin" class="col-lg-4 col-lg-offset-4 col-xs-10 col-xs-offset-1 col-md-10 col-md-offset-1" style="margin-top:3%;">
        <h1 id="LogoHeader" style="color:white; margin-bottom: 10%; font-family: headerText3; text-align: center; cursor: pointer;">PLACE ME NOW</h1>

        <h3 style="color:white;margin-bottom: 1%; text-align: center;" >LOGIN TO M-R</h3>
        <form id="loginForm" name="loginForm" action="" method="post">
            <div class="table-responsive" >
                <table class="table"  >
                    <tr>
                        <td>                 
                            <!--style="max-height:100px;height:40px;width: 400px;"-->
                            <input type="text" id="txtUsername" name="txtUsername" class="form-control" placeholder="Enter Email"  />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <!--style="max-height:100px;height:40px;width: 400px;"-->
                            <input type="password" id="txtPassword" name="txtPassword" class="form-control" placeholder="Enter Password"  />
                        </td>
                    </tr>
                    <!--<tr>
                        <td>
                            <a href="ForgotPassword.aspx" >Forgot Password</a>
                        </td>   -->
                    </tr>
                    <tr style="height: 40px;">
                        <td>
                            <!--<button id="btnLogin" class="btn btn-lg btn-primary btn-block">Login In</button> -->
                            <input type="submit" value="Log In" class="btn btn-lg btn-primary btn-block" id="btnLogin" name="btnLogin">
                        </td>
                    </tr>
                    <tr>
                        <td >
                            <h3 style="color:white;margin-bottom: 1%; text-align: center; margin-top: 18%;" >SIGN UP HERE</h3>
                            <button id="btnSignUpNavigate" class="btn btn-lg btn-primary btn-block" >Sign Up</button>
                        </td>
                    </tr>
                </table>
            </div>  <!--./table-responsive div-->
        </form>
    </div>   <!--./mainLogin-->

    <!--//for the basic jQuery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <!-- for the bootstrap and stuff -->	
	<link type="text/css" href="BootStrap/css/bootstrap-theme.css" rel="stylesheet" />
    <link type="text/css" href="BootStrap/css/bootstrap.css" rel="stylesheet" />
    <script type="text/javascript" src="BootStrap/js/bootstrap.js"></script>

</body>
</html>
