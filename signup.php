<?php

include 'DatabaseConn.php';
include 'UtilFunctions.php';

if(isset($_POST["btnSignup"]))
{
    $name = $_POST["txtNameSignup"];
    $contact = $_POST["txtContactSignup"];
    $password = $_POST["txtPasswordSignup"];
    $profile = $_POST["txtProfileSignUp"];
    $email = $_POST["txtUsernameSignup"];
    $date = date("Y-m-d");
    trim($email);
    if(!checkEmail($email, "users")) {
        $query="insert into users(UserEmail, UserPwd, UserName, UserContact, UserProfile, UserType, UpdatedOn) values ('$email', '$password', '$name', '$contact', '$profile', 'B', '$date');";
        $rs=mysql_query($query,$connection);
        if(!$rs) {
            die("The insertion was unsuccessful." . mysql_error());
        }
        else {
            header("location: login.php?signup=1");
        }
    }
    else {
        die("The Email address has already signed up!!");
    }
}
?>


<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Place Me Now - Signup</title>

   <!-- for the favicon -->
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
	<link rel="icon" href="images/favicon.ico" type="image/x-icon" />
    
    <!--for jQuery-->
    <!--<script src="js/jquery-1.7.1.min.js"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <!--for the custom stylesheet for this particular project -->
    <link rel="stylesheet" type="text/css" href="css/StyleSheet.css" />


    <style type="text/css">
          @font-face {
            font-family: headerText3;
            src: url(fonts/SEGOEUIL_BOLD.ttf);
        }
    </style>

    <script type="text/javascript">

        $(document).ready(function () {

            //for the popup and the alert Msg!
            var alertMsg = $('#alertMsg').hide(1);
            var popup = $('#popup').hide(1);
            //button to hide the popup appearing!
            $('#btnExitPopup').on('click', function () {
                popup.fadeOut();
                return false;
            });

            $('#txtUsernameSignup').focus();
            $('#txtUsernameSignup').popover('show');

            $('#LogoHeader').on('click', function () {
                window.location.href = "Default.aspx";
                return false;
            });

            $('#btnBack').on('click', function () {
                window.location.href = "/Default.aspx";
                return false;
            });

            $('input').on('focus', function () {
                $(this).popover('show');
            });

        });

    </script>

</head>
<body style="background: #070716;">
    <div class="alert alert-info" style="position:fixed; z-index: 9999; font-size: 1.3em; left: 0%;" id="alertMsg">
    </div>

    <div class="alert alert-warning" role="alert" id="popup" style="position:fixed; z-index: 9999; font-size: 1.3em; left: 2%; top: 3%; right: 2%;">
        <button id="btnExitPopup" type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    </div>

    <div class="col-lg-1 col-xs-1 col-md-1">
        <img id="btnBack" src="images/back.png" style="float:left;position:absolute; top: 0%; left: 3%; cursor:pointer;" />
    </div>
	
    <!--<div id="mainLogin" class="col-lg-4 col-lg-offset-3 col-xs-10 col-xs-offset-0 col-md-10 col-md-offset-0" style="margin-top:3%;">-->
    <div id="mainLogin" class="col-md-offset-3 col-md-4" style="margin-top:3%;">
        <h1 id="LogoHeader" style="color:white; margin-bottom: 10%; font-family: headerText3; text-align: center; cursor: pointer;">PLACE ME NOW</h1>

        <h3 style="color:white; text-align: center;" >SIGNUP</h3>
        <!--<span style="color: red; float: left; margin: 5px 0 0 0px;">Fields marked with (*) are compulsory</span>-->
        <form id="signupForm" name="signupForm" method="post" action="" >
            <div class="table-responsive" >
                <table class="table"  >
                    <tr>
                        <td>
                            <input type="text" id="txtUsernameSignup" name="txtUsernameSignup" class="form-control" placeholder="Enter Email*" required="required" data-toggle="popover" data-trigger="focus" title="Be careful!" data-content="Please make sure that you are using that same email address given to Placement Division while signing up for this portal." />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="password" id="txtPasswordSignup" name="txtPasswordSignup" class="form-control" placeholder="Enter Password*" required="required" data-toggle="popover" data-trigger="focus" title="Required!" data-content="Can be anything you want, just dont leave it empty!" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" id="txtNameSignup" name="txtNameSignup" class="form-control" placeholder="Enter Name*" required="required" data-toggle="popover" data-trigger="focus" title="Required!" data-content="Your Full Name Please?" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" id="txtContactSignup" name="txtContactSignup" class="form-control" placeholder="Contact Number" data-toggle="popover" data-trigger="focus" title="Your choice!" data-content="Please provide your contact number for speedy contact. No compulsion though" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" id="txtProfileSignUp" name="txtProfileSignUp" class="form-control" placeholder="Linked In Profile/Facebook/Twitter Handle" data-toggle="popover" data-trigger="focus" title="For Social Media!" data-content="Provide a URL for others to be able to find you on Social Media."  />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <!--<button id="btnSignUp" class="btn btn-lg btn-primary btn-block">Sign Up</button> -->
                            <input type="submit" name="btnSignup" id="btnSignup" value="Sign up" class="btn btn-lg btn-primary btn-block">
    					</td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
    

    <!--//for the basic jQuery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <!-- for the bootstrap and stuff -->	
	<link type="text/css" href="BootStrap/css/bootstrap-theme.css" rel="stylesheet" />
    <link type="text/css" href="BootStrap/css/bootstrap.css" rel="stylesheet" />
    <script type="text/javascript" src="BootStrap/js/bootstrap.js"></script>

</body>
</html>
