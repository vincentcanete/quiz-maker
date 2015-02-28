<?php
    require_once dirname(__FILE__) . '/inc/session.php';
    require_once dirname(__FILE__) . '/inc/connection.php';
    require_once dirname(__FILE__) . '/inc/functions.php';
    confirm_logged_in();

if(isset($_POST['submit'])){
      global $connection;
      $quiz_id = $_GET['quiz_id'];
      if(!empty($_POST['title']) && !empty($_POST['file']) && !empty($_POST['time'])){
        $title2 = $_POST['title'];
        $desc2 = $_POST['file'];
        $time2 = $_POST['time'];
        $date = $_POST['date'];
        $items = $_POST['items'];
        $groups = $_POST['quiz-groups'];
        $grp = "";
        foreach ($groups as $group) {
          if(!empty($grp)){
          $grp = $grp . "," . $group;
          }else{
          $grp = $group;
          }
        }
        $publish = $_POST['quiz-publish'];

        $query2 = "UPDATE quiz SET quiz_title = '$title2' , quiz_description = '$desc2' , quiz_timelimit = '$time2' , quiz_datelimit = '$date' , quiz_shown_items='$items' , quiz_publish_on='$publish' , quiz_groups='$grp' WHERE quiz_id = '$quiz_id'";
        $result2 = mysql_query($query2,$connection);
        confirm_query($result2); 
        if($result2){
          redirect_to('content.php?page=quiz&notif=1');
        }else{
          redirect_to('content.php?page=quiz&notif=0');
        }
      } 
  }
?>