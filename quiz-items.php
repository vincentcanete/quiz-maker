<?php
    require_once dirname(__FILE__) . '/inc/session.php';
    require_once dirname(__FILE__) . '/inc/connection.php';
    require_once dirname(__FILE__) . '/inc/functions.php';
    confirm_logged_in();
    $quiz_id =  get_quiz_id_by_title($_GET['title']);
?>
<div class="quick-actions">
  <a href="content.php?page=quiz&quest_id=<?php echo $quiz_id; ?>&title=<?php echo $_GET['title']; ?>" >
    <span class="glyph new"></span>
    Add New Question
  </a>
</div>
<div class="box">
  <div class="box-header">
    <h1>All Quiz Items in <?php echo $_GET['title'];?> | <?php echo get_quiz_desc_by_title($_GET['title']);?></h1>
    <div class="handler"><img src="img/tip_bg.png" alt="" title="Click to toggle"></div>
    <div class="clear"></div>
  </div>
  
  <div class="box-content">
          <p class="large">
            <table class="datatable">
              <thead>
                <tr>
                  <th>Number</th>
                  <th>Question</th>
                  <th>Type</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php global $connection;
                      $count = 0;
                      $query = "SELECT * from questions where quiz_id = '$quiz_id'";
                      confirm_query($query);
                      $result = mysql_query($query,$connection);
                      while($row = mysql_fetch_array($result)){ 
                            $type = $row['questions_type'];
                        ?>
                        <tr class="item">
                        <td><?php echo ++$count; ?></td>
                        <td><?php echo htmlentities(substr($row['questions_question'], 0,70)) . "..."; ?></td>

                        <td><?php if($type == 'mc') echo "Multiple Choice";
                                  if($type == 'tf') echo "True or False";
                                  if($type == 'identification') echo "Identification";
                            ?>
                        </td>
                        <td>
                          <a href="content.php?page=edit-question&quest_id=<?php echo $row['questions_id'];?>" class="button plain"><span class="glyph pencil"></span>Edit</a>
                          <a href="delete-question.php?page=quiz-items&quest_id=<?php echo $row['questions_id'];?>" class="button plain delete"><span class="glyph trash"></span>Delete</a>
                        </td>
                        </tr>
                 <?php } ?>
              </tbody>   
            </table> 
          </p>
        <div class="clear"></div>
  </div>
</div>