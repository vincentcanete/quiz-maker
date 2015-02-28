<?php
    include dirname(__FILE__) . '/inc/session.php';
    include dirname(__FILE__) . '/inc/connection.php';
    include dirname(__FILE__) . '/inc/functions.php';
    confirm_logged_in();
    include dirname(__FILE__) . '/header.php'; 
?>
    <div id="maincontainer">
      <div id="main" class="container_12">
        <?php
          if(isset($_GET['page'])){
            if($_GET['page']=='dashboard') include dirname(__FILE__) . '/dashboard.php';
            else if($_GET['page']=='quiz') include dirname(__FILE__) . '/quiz.php';
            else if($_GET['page']=='user') include dirname(__FILE__) . '/user.php';
            else if($_GET['page']=='students') include dirname(__FILE__) . '/students.php';
            else if($_GET['page']=='edit-student') include dirname(__FILE__) . '/edit-form-student.php';
            else if($_GET['page']=='student-details') include dirname(__FILE__) . '/student-details.php';
            else if($_GET['page']=='edit-user') include dirname(__FILE__) . '/edit-form-user.php';
            else if($_GET['page']=='edit-quiz') include dirname(__FILE__) . '/edit-form-quiz.php';
            else if($_GET['page']=='edit-question') include dirname(__FILE__) . '/edit-form-question.php';
            else if($_GET['page']=='quiz-items') include dirname(__FILE__) . '/quiz-items.php';
            else if($_GET['page']=='simulate-quiz') include dirname(__FILE__) . '/simulate-quiz.php';
            else if($_GET['page']=='assignment') include dirname(__FILE__) . '/assignment.php';
            else if($_GET['page']=='reports') include dirname(__FILE__) . '/reports.php';
            else if($_GET['page']=='new-assignment') include dirname(__FILE__) . '/create-new-assignment.php';
            else if($_GET['page']=='edit-assignment') include dirname(__FILE__) . '/edit-form-assignment.php';
            else if($_GET['page']=='filemanager') include dirname(__FILE__) . '/filemanager.php';
            else if($_GET['page']=='messaging') include dirname(__FILE__) . '/messaging.php';
          }else{
            include dirname(__FILE__) . '/dashboard.php';
          }
        ?>
      </div>
      <div class="clear"></div>
    </div>
<?php include dirname(__FILE__) . '/footer.php'; ?>