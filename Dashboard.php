<?php 

    session_start();

    include 'DatabaseConn.php';
    include 'UtilFunctions.php';

    $userID = $_SESSION["UserID"];
    $userEmail = $_SESSION["UserEmail"];

    if(!checkSession()) {
        header("location: login.php?session=1");
    }

    if(isset($_POST["logout"])) {
        session_unset();
        session_destroy();
        header("location: login.php?logout=1");
    }

    //this is for posting the feedback
    if(isset($_POST["btnFeedback"])) {
        $sub = $_POST["txtFeedbackSubject"];
        $content = $_POST["txtFeedback"];
        $updatedOn = date('Y-m-d H-i-s');

        $query = "insert into feedback(UserID, FBSubject, FBContent, UpdatedOn) values('$userID', '$sub', '$content', '$updatedOn')";
        $rs = mysql_query($query, $connection);
        if(!$rs) {
            die("Feedback could not be submitted. Please try again.");
        }
        else {
            header("location: Dashboard.php?fb=1");
        }
        mysql_close($connection);
    }

    //this is for uploading the resume of the user.
    if(isset($_POST["btnUploadResume"])) {
        //$targetDir = "/var/www/html/PlaceMeNow/ResumeFiles/";
        $ext = explode(".", $_FILES["resumeFile"]["name"]);

        $fileName = $userEmail . "_" . date("Y-m-d H-i-s") . "." . end($ext);

        $targetFile = "/var/www/html/PlaceMeNow/ResumeFiles/" . $fileName;

        if (move_uploaded_file($_FILES["resumeFile"]["tmp_name"], $targetFile)) {
            $qr = "insert into resumes(UserID, ResumeLink) values('$userID', '$targetFile')";
            $rs = mysql_query($qr, $connection);
            if(!$rs) {
                die("File could not be resgistered. Please try again.");
            }
            else {
                header("location: Dashboard.php?RU=1");
            }
        } 
        else {
            die("File has NOT been uploaded.");
        }   
    }

 ?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <title>Student Dashboard - Place Me Now</title>
    
      <!-- for the favicon -->
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
	<link rel="icon" href="images/favicon.ico" type="image/x-icon" />
    
    <!--for jQuery-->
    <!--<script src="js/jquery-1.7.1.min.js"></script>-->
    <script src="js/Scripts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <!--for the custom stylesheet for this particular project -->
    <link rel="stylesheet" type="text/css" href="css/StyleSheet.css" />

    <style type="text/css">
          @font-face {
            font-family: headerText3;
            src: url(fonts/SEGOEUIL_BOLD.ttf);
        }

            @font-face {
            font-family: textFont;
            src: url(fonts/SEGOEUIL.ttf);
        }

          .divsMain {
            padding: 0% 2% 2% 2%;
        }

        #welcomeDiv p {
            font-size: 1.3em;
            font-family: textFont;
        }
    </style>

    <script type="text/javascript">

        $(document).ready(function () {
            //for the alert boxes
            var alertMsg = $('#alertMsg').hide();
            //for the popup!
            var popup = $('#popup').hide(1);
            //button to hide the popup appearing!
            $('#btnExitPopup').on('click', function () {
                popup.fadeOut();
                return false;
            });

            var qs = getQueryStrings();

            $('#categoriesHeader').on('click', function () {
                showDiv(welcomeDiv);
                changeActiveState(this);
                return false;
            });

            var welcomeDiv = $('#welcomeDiv').hide(1);
            var dashboardDiv = $('#dashboardDiv').hide(1);
            var resumeDiv = $('#resumeDiv').hide(1);
            var feedbackDiv = $('#feedbackDiv').hide(1);
            var uploadResumeDiv = $('#uploadResumeDiv').hide(1);

            //to get the userID and userEmail in the jQuery from PHP
            var userID = '<?php echo $_SESSION["UserID"] ?>';
            var userEmail = '<?php echo $_SESSION["UserEmail"] ?>';

            //for the click events of the links on the LHS
            $('#dashboard').on('click', function () {
                showDiv(dashboardDiv);
                changeActiveState(this);
                return false;
            });
            $('#resume').on('click', function () {
                showDiv(resumeDiv);
                changeActiveState(this);
                return false;
            });
            $('#feedback').on('click', function () {
                showDiv(feedbackDiv);
                changeActiveState(this);
                return false;
            });
            $('#uploadResume').on('click', function () {
                showDiv(uploadResumeDiv);
                changeActiveState(this);
                return false;
            });

            //for the initial call
            $('#categoriesHeader').trigger('click');

            //for processing the query strings
            if(qs["fb"] == 1) {
                popup.children('p').remove();
                popup.append("<p>Your feedback has been submitted. Thank You.</p>").fadeIn('fast');
            }
            else if(qs["RU"] == 1) {
                popup.children('p').remove();
                popup.append("<p>Your Resume has been uploaded and resgitered. Thank You.</p>").fadeIn('fast');
            }

            //for all the AJAX here
            $('#dashboard').on('click', function() {
                popup.children('p').remove();
                dashboardDiv.children('div').remove();
                alertMsg.html("Please wait while we make up your dashboard...").fadeIn('fast');
                $.ajax({
                    type: "GET",
                    url: "Requests.php/GetAnnouncements",
                    data: {
                        no:"1", userID: userID, userEmail: userEmail
                    },
                    success: function(response) {
                        alertMsg.html("").fadeOut('fast');
                        dashboardDiv.append(response);
                    },
                    error: function(response) {
                        alertMsg.html("").fadeOut('fast');
                        alert("Error in getting the dashboard. Please try again.");
                    }
                });
                return false;
            });

            //for showing all the resumes here
            $('#resume').on('click', function() {
                popup.children('p').remove();
                resumeDiv.children('div').remove();
                alertMsg.html("Please wait while we collect all your resumes....").fadeIn('fast');
                $.ajax({
                    type: "GET",
                    url: "Requests.php/GetResumes",
                    data: {
                        no:"2", userID: userID, userEmail: userEmail
                    },
                    success: function(response) {
                        alertMsg.html("").fadeOut('fast');
                        alert(response);
                        resumeDiv.append(response);
                    },
                    error: function(response) {
                        alertMsg.html("").fadeOut('fast');
                        alert("Error in getting the dashboard. Please try again.");
                    }
                });
                return false; 
            });
        });

    </script>
</head>
<body>
    <div class="alert alert-info" style="position:fixed; z-index: 9999; font-size: 1.3em; left: 5%; top: 3%;" id="alertMsg">
    </div>

    <div class="alert alert-warning" role="alert" id="popup" style="position:fixed; z-index: 9999; font-size: 1.3em; left: 5%; top: 3%;">
        <button id="btnExitPopup" type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    </div>

     <!--this is  for the top level nav bar on the top!!-->
     <div class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="height: 55px; color:white;">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            <a class="navbar-brand" href="#" style="color:white; font-size: 1.8em; margin-top: 2px;">
                    Place Me Now - Your Placement Portal
            </a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">                
                <li>
                <!-- <li id="logout"><a href="#" style="margin-right: 30px;">Logout</a></li> -->
                    <form id="formLogout" name="formLogout" action="" method="POST">
                        <!--<a href="#" name="logout" id="logout" style="margin-right: 30px;">Logout</a> -->
                        <input type="submit" style="margin-right: 50px; margin-top: 13px;" value="logout" class="btn btn-sm btn-primary" id="logout" name="logout" /> 
                    </form>
                </li>    
            </ul>
        </div>
     </div>

    <div id="main-wrapper" class="col-lg-12" style="margin-top: 60px;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 col-md-2" style="position:relative; left: -13px;" id="leftMenu">
                    <h3 class="page-header" id="categoriesHeader" style="cursor: pointer;">Categories</h3>

                    <div class="list-group">
                        <a id="dashboard" href="#" class="list-group-item">Your Dashboard</a>
                        <a id="uploadResume" href="#" class="list-group-item">Upload your Resume</a>
                        <a id="resume" href="#" class="list-group-item">Your Resume(s)</a>
                        <a id="feedback" href="#" class="list-group-item">Feedback</a>
                    </div>
                </div>

                <div id="welcomeDiv" class="col-sm-9 col-md-10 divsMain">
                    <h1 class="page-header">
                        Welcome to Place Me Now
                    </h1>

                    <p>
                        Welcome to place me now. You can write any content for the promotion of this portal HERE!
                    </p>
                </div>

                <div id="dashboardDiv" class="col-sm-9 col-md-10 divsMain">
                    <h1 class="page-header">
                        Admin Announcements
                    </h1>

                </div>

                <div id="uploadResumeDiv" class="col-sm-9 col-md-10 divsMain">
                    <h1 class="page-header">
                        Upload your Resume(s)
                    </h1>
                    <form id="formUploadResume" name="formUploadResume" action="" method="POST" enctype="multipart/form-data">
                        <table class="table table-hover">
                            <tr>
                                <td>
                                    <input type="file" name="resumeFile" id="resumeFile" class="btn btn-lg btn-default" />
                                </td>
                                <td>
                                <input type="submit" name="btnUploadResume" id="btnUploadResume" value="Upload Resume" class="btn btn-lg btn-primary" />
                                </td>
                            </tr>
                        </table>

                    </form>
                </div>

                <div id="resumeDiv" class="col-sm-9 col-md-10 divsMain">
                    <h1 class="page-header">
                      Your Resume(s)
                    </h1>



                </div>

                <form id="formFB" name="formFB" action="" method="POST">
                    <div id="feedbackDiv" class="col-sm-9 col-md-10 divsMain">
                        <h1 class="page-header">
                          Feedback, please?
                        </h1>

                          <table class="table table-hover">
                            <tr>
                                <td>
                                    <label class="label" for="txtFeedbackSubject" style="color:black;font-size: 1em;">Feedback Subject</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="txtFeedbackSubject" id="txtFeedbackSubject" placeholder="Announcement Header" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="label" style="color:black;font-size: 1em;" for="txtFeedback">Feedback Content</label>
                                </td>
                                <td>
                                    <textarea id="txtFeedback" name="txtFeedback" class="form-control" placeholder="Announcement Content" style="height: 200px; min-height: 100px; min-width: 100px; max-width: 100%;"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <!--<button id="btnFeedback" class="btn btn-lg btn-primary btn-block">Submit Feedback</button> -->
                                    <input type="submit" id="btnFeedback" name="btnFeedback" class="btn btn-lg btn-primary btn-block" value="Submit Feedback">
                                </td>
                                <td>

                                </td>
                            </tr>
                        </table>
                    </div>
                </form>

            </div>   <!-- /.Row -->
        </div>  <!-- /. container fluid -->
    </div>   <!-- /.Main Wrapper -->
    

       <!--//for the basic jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <!-- for the bootstrap and stuff -->	
	<link type="text/css" href="BootStrap/css/bootstrap-theme.css" rel="stylesheet" />
    <link type="text/css" href="BootStrap/css/bootstrap.css" rel="stylesheet" />
    <script type="text/javascript" src="BootStrap/js/bootstrap.js"></script>

</body>
</html>
