<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=utf-8">
<head>
    <meta charset="UTF-8" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="viewport" content="width=1024, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    
    <title>CAI Quiz Manager</title>

    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/icons.css" />
    <link rel="stylesheet" href="css/formalize.css" />
    <link rel="stylesheet" href="css/checkboxes.css" />
    <link rel="stylesheet" href="css/sourcerer.css" />
    <link rel="stylesheet" href="css/jquery-ui-1.8.23.css" />
    <link rel="stylesheet" href="css/tipsy.css" />
    <link rel="stylesheet" href="css/calendar.css" />
    <link rel="stylesheet" href="css/fonts.css" />
    <link rel="stylesheet" href="css/selectboxes.css" />
    <link rel="stylesheet" href="css/960.css" />
    <link rel="stylesheet" href="jquery.confirm/jquery.confirm.css" />
    <link rel="stylesheet" href="redactor/redactor.css" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" media="all and (orientation:portrait)" href="css/portrait.css" />
    <link rel="apple-touch-icon" href="apple-touch-icon-precomposed.html" />
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

    <!--[if lt IE 9]>
    <script src="/js/html5.js"></script>
    
    <![endif]-->

    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-ui-1.8.23.min.js"></script>
    <script src="js/jquery-ui-timepicker.js"></script>
    <script src="js/jquery.cookies.js"></script>
    <script src="js/jquery.pjax.js"></script>
    <script src="js/formalize.min.js"></script>
    <script src="js/jquery.validate.js"></script>
    <script src="js/jquery.checkboxes.js"></script>
    <script src="js/jquery.chosen.js"></script>
    <script src="js/jquery.fileinput.js"></script>
    <script src="js/jquery.datatables.js"></script>
    <script src="js/jquery.sourcerer.js"></script>
    <script src="js/jquery.tipsy.js"></script>
    <script src="js/jquery.calendar.js"></script>
    <script src="js/jquery.livequery.js"></script>
    <script src="js/jquery.flot.min.js"></script>
    <script src="js/jquery.flot.pie.js"> </script>
    <script src="jquery.confirm/jquery.confirm.js"></script>
    <script src="redactor/redactor.min.js"></script>
    <script src="js/script-confirm.js"></script>
    <script src="js/application.js"></script>
    

    <script type="text/javascript">
    $(document).ready(
        function(){
            $('.wysiwyg').redactor({   
                imageUpload: 'scripts/image_upload.php',
                fileUpload: 'scripts/file_upload.php',
            });
        }
    );
    </script>   

    <style type="text/css">
        div.box-content{
            display: none;
        }
    </style>
</head>
  <body>
    <?php error_reporting(0); ?>
    <!-- Secondary navigation -->
    <?php if(isset($_GET['page'])){
        if($_GET['page'] == 'dashboard')
          $dashboard = "active";
        else if($_GET['page'] == 'quiz')
          $quiz = "active";
        else if($_GET['page'] == 'user')
          $user = "active";
        /*else if($_GET['page'] == 'calendar')
          $calendar = "active"; */
        else if($_GET['page'] == 'assignment')
          $assignment = "active";
        else if($_GET['page'] == 'reports')
          $reports = "active";
        else if($_GET['page'] == 'students')
          $students = "active";
      }else{
         $dashboard = "active";
      } 
      ?>
    <div id="primary">
      <ul class="item">
        <li class="<?php echo $dashboard; ?>"><a href="content.php?page=dashboard">
          <span class="glyph dashboard"></span>Dashboard</a>
        </li>
        <li class="<?php echo $quiz; ?>"><a href="content.php?page=quiz">
          <span class="glyph new"></span>Quiz</a>
        </li>
        <li class="<?php echo $assignment; ?>"><a href="content.php?page=assignment">
          <span class="glyph pencil"></span>Assignment</a>
        </li>
        <li class="<?php echo $reports; ?>"><a href="content.php?page=reports">
          <span class="glyph file"></span>Reports</a>
        </li>
        <!--<li class="<?php echo $calendar; ?>"><a href="content.php?page=calendar">
          <span class="glyph calendar"></span>Calendar</a>
        </li> -->
        <li class="<?php echo $students; ?>"><a href="content.php?page=students">
          <span class="glyph group"></span>Students</a>
        </li>
        <li class="<?php echo $user; ?>"><a href="content.php?page=user">
          <span class="glyph user"></span>Users</a>
        </li>
        <li class="bottom"><a href="logout.php" class="logout">
          <span class="glyph quit"></span>Logout</a>
        </li>
      </ul>
    </div>