<?php

    require_once dirname(__FILE__) . '/inc/session.php';
    require_once dirname(__FILE__) . '/inc/connection.php';
    require_once dirname(__FILE__) . '/inc/functions.php';
    confirm_logged_in();
    $role = get_role($_SESSION['user_id']);
?>
<div class="quick-actions">
  <a href="content.php?page=quiz">
    <span class="glyph new"></span>
    Create New Quiz
  </a>
  <a href="content.php?page=assignment">
    <span class="glyph pencil"></span>
    Create New Assignment
  </a>
  <a href="content.php?page=user">
    <span class="glyph user"></span>
    Create New User
  </a>
</div>


<?php 
  global $connection;
  $sql = "SELECT COUNT(quiz_title) as num_quiz from quiz";
  $resultset = mysql_query($sql,$connection);
  confirm_query($resultset);
  while ($row = mysql_fetch_array($resultset)) {
      $count = $row['0'];
  }

  if(!$count==0){
?>
<div class="box" id="show-quizzes">
  <div class="box-header">
    <h1>All Quizzes</h1>
    <div class="handler"><img src="img/tip_bg.png" alt="" title="Click to toggle"></div>
    <div class="clear"></div>
  </div>
  
  <div class="box-content">
          <p class="large">
            <table class="datatable">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Exp. Date</th>
                  <th>Visible Items</th>
                  <th>Time Limit</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php global $connection;
                      $count = 0;
                      $query = "SELECT * from quiz ";
                      confirm_query($query);
                      $result = mysql_query($query,$connection);
                      while($row = mysql_fetch_array($result)){ 
                        ?>
                        <tr class="item">
                        <td><?php $merge_title = $row['quiz_title'] . " | ".$row['quiz_description'];  echo substr($merge_title, 0,35)?></td>
                        <td><?php echo $row['quiz_datelimit']; ?></td>
                         <td><?php echo $row['quiz_shown_items']; ?></td>
                        <td><?php echo $row['quiz_timelimit'] . " Minutes" ?></td>
                        <td>
                          <a href="content.php?page=edit-quiz&quiz_id=<?php echo $row['quiz_id']; ?>" class="button plain"><span class="glyph pencil"></span>Edit</a>
                          <a href="content.php?page=quiz-items&title=<?php echo $row['quiz_title']; ?>" class="button plain"><span class="glyph note"></span>View Items</a>
                          <a href="delete-quiz.php?page=quiz&quiz_id=<?php echo $row['quiz_id']; ?>" class="button plain delete"><span class="glyph trash"></span>Delete</a>
                          <a href="content.php?page=simulate-quiz&quiz_id=<?php echo $row['quiz_id']; ?>" class="button plain"><span class="glyph listicon"></span>Simulate</a>
                        </td>
                        </tr>
                 <?php } ?>
              </tbody>   
            </table> 
          </p>
        <div class="clear"></div>
  </div>
</div>
<?php } ?>


<div class="box">
  <div class="box-header">
    <h1>All Assignment</h1>
    <div class="handler"><img src="img/tip_bg.png" alt="" title="Click to toggle"></div>
    <div class="clear"></div>
  </div>
  
  <div class="box-content">
          <p class="large">
            <table class="datatable">
              <thead>
                <tr>
                  <th>Number</th>
                  <th>Title</th>
                  <th>Publish on</th>
                  <th>Deadline</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php global $connection;
                      $count = 0;
                      $query = "SELECT * from assignment";
                      confirm_query($query);
                      $result = mysql_query($query,$connection);
                      while($ass = mysql_fetch_array($result)){ ?>
                        <tr class="item">
                        <td><?php echo ++$count ?></td>
                        <td><?php echo $ass['assign_title']; ?></td>
                        <td><?php echo $ass['assign_publish_date']; ?></td>
                        <td><?php echo $ass['assign_deadline']; ?></td>
                        <td>
                          <a href="content.php?page=edit-assignment&assign_id=<?php echo $ass['assign_id']; ?>" class="button plain"><span class="glyph pencil"></span>Edit</a>
                          <a href="delete-assignment.php?page=assignment&assign_id=<?php echo $ass['assign_id']; ?>" class="button plain delete"><span class="glyph trash"></span>Delete</a>
                        </td>
                        </tr>
                 <?php } ?>
              </tbody>   
            </table> 
          </p>
  </div>
</div>

