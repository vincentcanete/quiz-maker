<?php
    require_once dirname(__FILE__) . '/inc/session.php';
    require_once dirname(__FILE__) . '/inc/connection.php';
    require_once dirname(__FILE__) . '/inc/functions.php';
    confirm_logged_in();
    global $connection;

    $id = $_GET['student_id'];
    $user_name = get_user_name_by_id($id);
?>

<div class="box">
  <div class="box-header">
    <h1><?php echo $user_name; ?> | Quiz Taken</h1>
    <div class="handler"><img src="img/tip_bg.png" alt="" title="Click to toggle"></div>
    <div class="clear"></div>
  </div>
  
  <div class="box-content">
          <p class="large">
            <table class="datatable">
              <thead>
                <tr>
                  <th>Quiz Title</th>
                  <th>Description</th>
                  <th>Score</th>
                  <th>Ratings</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
              <?php 
                $group_ids = get_group_id_by_user_id($id);
                $query = "SELECT quiz_title, quiz_description, ratings.quiz_id, quiz_groups, score_rating, points,status FROM quiz , ratings where student_id ='$id' and quiz.quiz_id = ratings.quiz_id";
                $result = mysql_query($query,$connection);
                confirm_query($result);
                while($row = mysql_fetch_array($result)){ 
                  $title = $row['quiz_title'];
                  $desc = $row['quiz_description'];
                  $quiz_id = $row['quiz_id'];
                  $groups_in_quiz = $row['quiz_groups'];
                  $rating = $row['score_rating'];
                  $score = $row['points'];
                  $groups_in_quiz = explode(',', $groups_in_quiz);

                    foreach ($group_ids as $group_id) {

                    if( in_array($group_id, $groups_in_quiz) ){

                  ?>
                  <tr>
                    <td><?php echo $title ?></td>
                    <td><?php echo $desc ?></td>
                    <td><?php echo $score ?></td>
                    <td><?php echo $rating . " %" ?></td>
                    <td>
                      <?php if($row['status'] == 1) : ?>
                        <a href="student-retake.php?student_id=<?php echo $id;?>&quiz_id=<?php echo $quiz_id; ?>" class="button plain retake"><span class="glyph restart"></span>Retake</a>
                      <?php else : ?>
                        Ready to retake
                       <?php endif; ?> 
                    </td>
                  </tr>

                <?php } } ?>
                  

                <?php }  ?>
              </tbody>   
            </table> 
          </p>
        <div class="clear"></div>
  </div>
</div>