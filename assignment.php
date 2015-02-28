<div class="quick-actions">
  <a href="content.php?page=new-assignment">
    <span class="glyph pencil"></span>
    Create New Assignment
  </a>

  <a href="content.php?page=filemanager">
    <span class="glyph inbox"></span>
    File Manager
  </a>
</div>


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