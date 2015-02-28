<?php
    require_once dirname(__FILE__) . '/inc/session.php';
    require_once dirname(__FILE__) . '/inc/connection.php';
    require_once dirname(__FILE__) . '/inc/functions.php';
    confirm_logged_in();
    
    global $connection;
    $id = $_GET['student_id'];
    $query = "SELECT value , name FROM  wpbp_xprofile_data, wpbp_groups, wpbp_groups_members  WHERE wpbp_xprofile_data.field_id =1  AND wpbp_xprofile_data.user_id = '$id'
    and wpbp_xprofile_data.user_id =  wpbp_groups_members.user_id and wpbp_groups_members.group_id = wpbp_groups.id";

    $result = mysql_query($query,$connection);
    confirm_query($result);
    while($row = mysql_fetch_array($result)){ 
      $value = $row['value'];
      $grp_name = $row['name'];
    }

?>
<div class="box" id="info">
  <div class="box-header">
    <h1>Update Existing Student</h1>
    <div class="handler"><img src="img/tip_bg.png" alt="" title="Click to toggle"></div>
    <div class="clear"></div>
  </div>
  
  <div class="box-content">
      <form action="update-student.php" method="post" id="form1">
        <div class="column-left">
          <p class="large">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" placeholder="name" value="<?php echo $value; ?>" />
          </p>    
          <br/><br/>
          <p>
            <input type="hidden" name="stud-id" value="<?php echo $id; ?>" />
            <input type="submit" class="button" name="submit" value="Update Student">
          </p>
        </div>
      
        <div class="column-right">
          <p class="large">
                <label for="stud-group" style="display: block">Select Groups: </label>
                <select name="stud-group" id="stud-group" style="width:100%">
                  <?php 
                      $group_ids = get_groups_id();
                      foreach ($group_ids as $group_id ):

                      $group_name = get_groups_name($group_id);  ?>

                        <?php if( $grp_name == $group_name ) : ?>
                        
                        <option value="<?php echo $group_id; ?>" selected="selected" ><?php echo $group_name; ?></option>

                        <?php else : ?>

                        <option value="<?php echo $group_id; ?>" ><?php echo $group_name; ?></option>
                        
                        <?php endif ?>

                      
                  <?php endforeach ?>
                </select>
              </p>
        </div>
        <div class="clear"></div>

      </form>
  </div>
</div>
