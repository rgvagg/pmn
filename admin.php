<?php 
    
    session_start();

    include 'DatabaseConn.php';
    include 'UtilFunctions.php';

    if(!checkSession()) {
        header("location: login.php?session=1");
    }

    if(isset($_POST["btnPostAnn"]))  {
        $header = $_POST["txtHeader"];
        $ann = $_POST["txtAnn"];
        $userID = $_SESSION["UserID"];
        $anntime = date("Y-m-d h-i-s");

        $query = "insert into announcements(UserID, Header, Content, AnnTime) values('$userID', '$header', '$ann', '$anntime')";
        echo $query . " --> ";
        $rs = mysql_query($query, $connection);
        echo $rs . " --> ";
        if(!$rs) {
            die("Error in putting the announcements. Please try again.");
        }
        else {
            header("location: admin.php?ann=1");
        }
        mysql_close($connection);
    }
 ?>

<?php 

    if(isset($_POST["logout"])) {
        session_unset();
        session_destroy();
        header("location: login.php?logout=1");
    }

?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Admin Section - PlaceMeNow</title>

     <!-- for the favicon -->
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
	<link rel="icon" href="images/favicon.ico" type="image/x-icon" />
    
    <!--for jQuery-->
    <!--<script src="js/jquery-1.7.1.min.js"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/Scripts.js"></script>

    <!--for the custom stylesheet for this particular project -->
    <link rel="stylesheet" type="text/css" href="css/StyleSheet.css" />

    <style type="text/css">
          @font-face {
            font-family: headerText3;
            src: url(fonts/SEGOEUIL_BOLD.ttf);
        }

          .divsMain {
            padding: 0% 2% 2% 2%;
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

            var postAnnouncementDiv = $('#postAnnouncementDiv').hide(1);

            //for the click event of the Post Announcment on the LHS
            $('#postAnnouncement').on('click', function () {
                showDiv(postAnnouncementDiv);
                changeActiveState(this);
                return false;
            });

            //for the initial call to the page
            $('#postAnnouncement').trigger('click');

            //for showing the message when the announcement is posted.
            if(qs["ann"] == "1") {
                popup.children('p').remove();
                popup.append("<p>Your Announcement has been successfully posted.</p>").fadeIn('fast');
            }

            //for the logout button
            $('#logout').on('click', function() {
                /*alertMsg.html("Logging you out, please wait..").fadeIn('fast');
                $.ajax({
                    type: "GET",
                    url: ""

                });  */
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
                    <h3 class="page-header" id="categoriesHeader">Categories</h3>

                    <div class="list-group">
                        <a id="postAnnouncement" href="#" class="list-group-item">Post Announcement(s)</a>
                    </div>
                </div>

                <form id="formPostAnn" name="formPostAnn" method="POST" action="">
                    <div id="postAnnouncementDiv" class="col-sm-9 col-md-10 divsMain">
                        <h1 class="page-header">
                            Post an Announcement
                        </h1>

                        <table class="table table-hover">
                            <tr>
                                <td>
                                    <label class="label" style="color:black;font-size: 1em;">Announcement Header</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="txtHeader" name="txtHeader" placeholder="Announcement Header" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="label" style="color:black;font-size: 1em;">Announcement Content</label>
                                </td>
                                <td>
                                    <textarea id="txtAnn" name="txtAnn" class="form-control" placeholder="Announcement Content" style="height: 200px; min-height: 100px; min-width: 100px; max-width: 100%;"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="submit" id="btnPostAnn" class="btn btn-lg btn-primary btn-block" value="Post Announcement" name="btnPostAnn" />
                                </td>
                                <td>

                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--//for the basic jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <!-- for the bootstrap and stuff -->	
	<link type="text/css" href="BootStrap/css/bootstrap-theme.css" rel="stylesheet" />
    <link type="text/css" href="BootStrap/css/bootstrap.css" rel="stylesheet" />
    <script type="text/javascript" src="BootStrap/js/bootstrap.js"></script>

</body>
</html>
