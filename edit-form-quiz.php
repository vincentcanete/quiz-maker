<?php
    require_once dirname(__FILE__) . '/inc/session.php';
    require_once dirname(__FILE__) . '/inc/connection.php';
    require_once dirname(__FILE__) . '/inc/functions.php';
    confirm_logged_in();
    
    global $connection;
    $id = $_GET['quiz_id'];
    $query = "SELECT * from quiz where quiz_id = '$id'";
    $result = mysql_query($query,$connection);
    confirm_query($result);
    $quiz_id = "";
    while($row = mysql_fetch_array($result)){ 
      $title = $row['quiz_title'];
      $desc = $row['quiz_description'];
      $publish = $row['quiz_publish_on'];
      $limit = $row['quiz_timelimit'];
      $date = $row['quiz_datelimit'];
      $items = $row['quiz_shown_items'];

    }

?>
<div class="box" id="info">
  <div class="box-header">
    <h1>Update Existing Quiz</h1>
    <div class="handler"><img src="img/tip_bg.png" alt="" title="Click to toggle"></div>
    <div class="clear"></div>
  </div>
  
  <div class="box-content">
      <form action="update-quiz-process.php?quiz_id=<?php echo $id?>" method="post" id="form1">
        <div class="column-left">
          <p>
            <label for="title">Quiz Title:</label>
            <input type="text" name="title" id="title" placeholder="Title" value="<?php echo $title; ?>" />
          </p>
          <p class="medium">
              <label for="quiz-publish">Publish on: </label>
              <input type="text" name="quiz-publish" class="datepicker" id="quiz-publish" value="<?php echo $publish ?>" />
          </p>
              <p class="medium">
                <label for="quiz-groups" style="display: block">Select Groups: </label>
                <select multiple="multiple" name="quiz-groups[]" id="quiz-groups" style="width:100%">
                  <?php 
                      $group_ids = get_groups_id();
                      foreach ($group_ids as $group_id ):

                      $group_name = get_groups_name($group_id); 
                      $assign_groups = get_quiz_groups($id);
                      $assign_groups = explode(',', $assign_groups); ?>

                        <?php if(in_array($group_id , $assign_groups)) : ?>
                        <option value="<?php echo $group_id; ?>" selected="selected"><?php echo $group_name; ?></option>
                        <?php else : ?>
                        <option value="<?php echo $group_id; ?>" ><?php echo $group_name; ?></option>
                        <?php endif ?>

                      
                  <?php endforeach ?>
                </select>
              </p>    
          <br/><br/>
          <p>
            <input type="submit" class="button" name="submit" id="update-quiz" value="Update Quiz">
          </p>
        </div>
      
        <div class="column-right">
          <p class="large">
            <label for="file">Description (In Few Words) :</label>
            <input type="text" id="file" name="file" value="<?php echo $desc?>"/>  
          </p>
          <p class="medium">
              <label for="datepicker">Expiration Date:</label>
              <input type="text" name="date" class="datepicker" id="datepicker" value="<?php echo $date?>">
          </p>
            <p class="small">
              <label for="time">Time Limit: (Min) </label>
              <input type="text" id="time" name="time" value="<?php echo $limit ?>"/>  
            </p>
            <p class="small">
              <label for="items">Items Shown:</label>
              <input type="text" name="items" id="items" value="<?php echo $items ?>" maxlength="2" />
            </p>
        </div>
        <div class="clear"></div>

      </form>
  </div>
</div>
<script type="text/javascript">
  (function(){
   $('.datepicker').datetimepicker({
    inline: true,
    showButtonPanel: true,
    ampm: true
  });
  })();
</script>