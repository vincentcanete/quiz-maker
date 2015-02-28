<?php

    require_once dirname(__FILE__) . '/inc/session.php';
    require_once dirname(__FILE__) . '/inc/connection.php';
    require_once dirname(__FILE__) . '/inc/functions.php';
    confirm_logged_in();
    error_reporting(0);
?>

<?php if($_GET['msg'] == '0') : ?>
<div class="notification error">
  <span class="icon"></span>
  There's Something Wrong Updating on Student's Account!
  <a href="#" class="close">x</a>
</div>

<?php elseif($_GET['msg'] == '1') : ?>
<div class="notification success">
  <span class="icon"></span>
  Student's Account Updated Successfully
  <a href="#" class="close">x</a>
</div>
<?php endif; ?>

<div class="quick-actions">
  <a href="content.php?page=messaging">
    <span class="glyph message"></span>
    SMS Messaging
  </a>
</div>

<div class="box" id="show-quizzes">
  <div class="box-header">
    <h1>Registered Students</h1>
    <div class="handler"><img src="img/tip_bg.png" alt="" title="Click to toggle"></div>
    <div class="clear"></div>
  </div>
  
  <div class="box-content">
          <p class="large">
            <table class="datatable">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Group</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php global $connection;
                      $count = 0;
                      $query = "SELECT wpbp_xprofile_data.user_id,  value, name, is_admin, wpusers.ID FROM  wpbp_xprofile_data, wpbp_groups, wpbp_groups_members , wpusers WHERE wpbp_xprofile_data.field_id =1 AND wpbp_xprofile_data.user_id =  wpbp_groups_members.user_id AND wpbp_groups.id = wpbp_groups_members.group_id and wpusers.ID = wpbp_xprofile_data.user_id";
                      confirm_query($query);
                      $result = mysql_query($query,$connection);
                      while($row = mysql_fetch_array($result)){ 
                        if( !$row['is_admin'] == 1 ) { 
                        ?>
                        <tr class="item">
                        <td><?php echo ucwords($row['value']); ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td>
                          <a href="content.php?page=edit-student&student_id=<?php echo $row['user_id']; ?>" class="button plain"><span class="glyph pencil"></span>Edit</a>
                          <a href="content.php?page=student-details&student_id=<?php echo $row['user_id']; ?>" class="button plain"><span class="glyph note"></span>Details</a>
                        </td>
                        </tr>
                 <?php } } ?>
              </tbody>   
            </table> 
          </p>
        <div class="clear"></div>
  </div>
</div>

