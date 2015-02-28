<?php
    require_once dirname(__FILE__) . '/inc/session.php';
    require_once dirname(__FILE__) . '/inc/connection.php';
    require_once dirname(__FILE__) . '/inc/functions.php';
    confirm_logged_in();

      global $connection;

      if(!empty($_GET['student_id']) && !empty($_GET['quiz_id'])) {

        $student_id = $_GET['student_id'];
        $quiz_id = $_GET['quiz_id'];

        $query2 = "UPDATE ratings SET status = '0' WHERE student_id = '$student_id' and quiz_id = '$quiz_id'";
        $result2 = mysql_query($query2,$connection);
        confirm_query($result2); 
        if($result2){
          redirect_to("content.php?page=student-details&student_id=$student_id&msg=1");
        }else{
          redirect_to("content.php?page=student-details&student_id=$student_id&msg=0");
        }
      }else{
          redirect_to('content.php?page=student-details&student_id=$student_id');
      } 
?>