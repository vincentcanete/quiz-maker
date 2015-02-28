<?php

    require_once dirname(__FILE__) . '/inc/session.php';
    require_once dirname(__FILE__) . '/inc/connection.php';
    require_once dirname(__FILE__) . '/inc/functions.php';
    confirm_logged_in();

    $id = $_GET['assign_id'];

    global $connection;
    $count = 0;
    $query = "SELECT * from assignment where assign_id = '$id' ";
    confirm_query($query);
    $result = mysql_query($query,$connection);
    while($row = mysql_fetch_array($result)){
        $title = $row['assign_title'];
        $content = $row['assign_content'];
        $points = $row['assign_points'];
        $publish = $row['assign_publish_date'];
        $deadline = $row['assign_deadline'];
        $file = $row['file_location'];
    }
?>
<?php if(isset($_GET['update']) && $_GET['update'] == 'ok') : ?>
<div class="notification success">
  <span class="icon"></span>
  Assignment Successfully Updated
  <a href="#" class="close">x</a>
</div>
<?php endif; ?>

<?php if(isset($_GET['update']) && $_GET['update'] == 'err') : ?>
<div class="notification error">
  <span class="icon"></span>
  Error!
  <a href="#" class="close">x</a>
</div>
<?php endif; ?>

<div class="box" id="show-quizzes">
  <div class="box-header">
    <h1>Edit Existing Assignment</h1>
    <div class="handler"><img src="img/tip_bg.png" alt="" title="Click to toggle"></div>
    <div class="clear"></div>
  </div>
  
  <div class="box-content">
          <form action="update-assignment.php" method="post" id="assignment-form" enctype="multipart/form-data">
              <p>
               <input type="text" name="assign-title"  id="assign-title" value="<?php echo $title; ?>" placeholder="Assignment Title"/>
              </p>
              <p>
                  <textarea  id="assign-content" class="wysiwyg" name="assign-content" style="height: 300px;"><?php echo $content; ?></textarea>
              </p>

              <div class="column-left">
                <p>
                  <label for="file">Upload File: </label>
                  <input type="file" id="file" name="file" placeholder="<?php echo $file ?>"/>
                </p>
                <p>
                  <label for="groups" style="display: block">Select Groups: </label>
                  <select multiple="multiple" name="assign-groups[]" style="width:100%">
                    <?php 
                        $group_ids = get_groups_id();
                        foreach ($group_ids as $group_id ):

                        $group_name = get_groups_name($group_id); 
                        $assign_groups = get_assign_groups($id);
                        $assign_groups = explode(',', $assign_groups); ?>

                          <?php if(in_array($group_id , $assign_groups)) : ?>
                          <option value="<?php echo $group_id; ?>" selected="selected"><?php echo $group_name; ?></option>
                          <?php else : ?>
                          <option value="<?php echo $group_id; ?>" ><?php echo $group_name; ?></option>
                          <?php endif ?>

                        
                    <?php endforeach ?>
                  </select>
                </p>
                <p class="small">
                  <label for="assign-points">Points:</label>
                  <input type="text" id="assign-points" name="assign-points" value="<?php echo $points ?>"/>
                </p>
              </div>

              <div class="column-right">
                <p>
                  <label for="assign-publish">Publish on: </label>
                  <input type="text" name="assign-publish" class="datepicker" id="assign-publish" value='<?php echo $publish; ?>'>
                </p>
                <p>
                  <label for="assign-deadline">Deadline: </label>
                  <input type="text" name="assign-deadline" class="datepicker" id="assign-deadline" value='<?php echo $deadline; ?>'>
                </p>
              </div>

              <div class="clear"></div>
              <br>
              <br>
              <p>
                <input type="submit" class="button" id="update-assignment" value="Update">
                <input type="hidden" name="id" value="<?php echo $id ; ?>">
              </p>
              
              <script type="text/javascript">
                  (function(){
                    $('.datepicker').datetimepicker({
                      inline: true,
                      showButtonPanel: true,
                      ampm: true
                    });

                    function NumberFieldCheck(id){
                    $(id).keypress(function(event){
                          if(isNumberKey(event)){
                            if(!isBackspace(event)){
                              return true;
                              }
                            }
                          else{
                            return false;
                            }
                          });
                    }
                    NumberFieldCheck('#points');
                  })();
              </script>
          </form>
          
        <div class="clear"></div>
  </div>
</div>
