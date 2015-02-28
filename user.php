<?php
    require_once dirname(__FILE__) . '/inc/session.php';
    require_once dirname(__FILE__) . '/inc/connection.php';
    require_once dirname(__FILE__) . '/inc/functions.php';
    confirm_logged_in();

    $role = get_role($_SESSION['user_id']);
    error_reporting(0);
?>

<?php if($_GET['notif'] == '0' || $_GET['msg'] == 'error') : ?>
<div class="notification error">
  <span class="icon"></span>
  Error Occured!
  <a href="#" class="close">x</a>
</div>

<?php elseif($_GET['notif'] == '1' ) : ?>
<div class="notification success">
  <span class="icon"></span>
  User's Account Updated
  <a href="#" class="close">x</a>
</div>

<?php elseif($_GET['notif'] == 'mismatch') : ?>
<div class="notification error">
  <span class="icon"></span>
  Password Mismatch!
  <a href="#" class="close">x</a>
</div>

<?php elseif($_GET['msg'] == '0') : ?>
<div class="notification error">
  <span class="icon"></span>
  There's Something Wrong Adding a User!
  <a href="#" class="close">x</a>
</div>

<?php elseif($_GET['msg'] == '1') : ?>
<div class="notification success">
  <span class="icon"></span>
  User Added Successfully
  <a href="#" class="close">x</a>
</div>

<?php endif; ?>

<div class="box" id="info">
  <div class="box-header">
    <h1>User Manager</h1>
    <div class="handler"><img src="img/tip_bg.png" alt="" title="Click to toggle"></div>
    <div class="clear"></div>
  </div>
  
  <div class="box-content">
      <form action="add-user.php" method="post" id="form-user">
        <div class="column-left">
          <p class="large">
            <label for="name">Full Name:</label>
            <input type="text" name="name" id="name" placeholder="Name" />
          </p>
          <p class="medium">
            <label for="user_name">Username:</label>
            <input type="text" name="user_name" id="user_login" placeholder="Username" />
          </p>
          <p class="medium">
            <label for="admin_password">Password:</label>
            <input type="password" name="admin_password" id="pass1" placeholder="Password" />
          </p>
          <p class="medium">
            <label for="admin_password2">Confirm Password:</label>
            <input type="password" name="admin_password2" id="pass2" placeholder="Confirm Password" />
          </p>
          <p class="medium">
            <div id="pass-strength-result" style="width:49%">Strength indicator</div>
          </p>
          <br/>
          <p>
            <input type="submit" class="button" id="add-user" value="Add User">
          </p>
        </div>
      
        <div class="column-right">
          <p class="large">
            <table>
              <thead>
                <tr>
                  <th>Full Name</th>
                  <th>Role</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php global $connection;
                      $query = "SELECT * from users";
                      confirm_query($query);
                      $result = mysql_query($query,$connection);
                      while($user = mysql_fetch_array($result)){ 
                            $user_id = $user['user_id'];
                            $user_type = $user['type'];
                      ?>
                        <tr class="item">
                        <td><?php echo $user['nice_name']; ?></td>
                        <td><?php echo $user['type']; ?></td>
                        <td>
                          <?php if($user_id == $_SESSION['user_id'] ){ ?>
                            <a href="content.php?page=edit-user&user_id=<?php echo $user['user_id'];?>" class="button plain"><span class="glyph pencil"></span>Edit</a>
                          <?php  }else{ ?>

                                <?php if($role == 'Super Admin'){ ?>
                                  <a href="content.php?page=edit-user&user_id=<?php echo $user['user_id'];?>" class="button plain"><span class="glyph pencil"></span>Edit</a>
                                  <a href="delete-user.php?page=user&user_id=<?php echo $user['user_id']; ?>" class="button plain delete"><span class="glyph trash"></span>Delete</a>
                                <?php  } ?>

                          <?php } ?>
                          
                        </td>
                        </tr>
                 <?php } ?>
              </tbody>   
            </table> 
          </p>
        </div>
        <div class="clear"></div>

      </form>
  </div>
</div>
<script type='text/javascript'>
/* <![CDATA[ */
var pwsL10n = {"empty":"Strength indicator","short":"Very weak","bad":"Weak","good":"Medium","strong":"Strong","mismatch":"Mismatch"};
/* ]]> */
</script>
<script type='text/javascript' src='js/password-strength-meter.js?ver=20101027'></script>
<script type='text/javascript' src='js/user-profile.js?ver=20110628'></script>
