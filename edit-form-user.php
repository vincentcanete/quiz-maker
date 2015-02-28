<?php
    require_once dirname(__FILE__) . '/inc/session.php';
    require_once dirname(__FILE__) . '/inc/connection.php';
    require_once dirname(__FILE__) . '/inc/functions.php';
    confirm_logged_in();
    
    global $connection;
    $id = $_GET['user_id'];
    $query = "SELECT * from users where user_id = '$id'";
    $result = mysql_query($query,$connection);
    confirm_query($result);

    while($user = mysql_fetch_array($result)){ 
          $user_id = $user['user_id'];
          $user_type = $user['type'];
          $user_nc = $user['nice_name'];
          $user_name = $user['name'];
    }

?>
<div class="box" id="info">
  <div class="box-header"><h1>Edit Existing User</h1></div>
  
  <div class="box-content">
      <form action="update-user.php" method="post" id="form-user">
          <p class="medium">
            <label for="name">Full Name:</label>
            <input type="text" name="name" id="name" placeholder="Name" value="<?php echo $user_nc; ?>"/>
          </p>
          <p class="small">
            <label for="user_name">Username:</label>
            <input type="text" name="user_name" id="user_login" placeholder="Username" value="<?php echo $user_name; ?>"/>
          </p>
          <p class="small">
            <label for="admin_password">Password:</label>
            <input type="password" name="admin_password" id="pass1" placeholder="Password" />
          </p>
          <p class="small">
            <label for="admin_password2">Confirm Password:</label>
            <input type="password" name="admin_password2" id="pass2" placeholder="Confirm Password" />
          </p>
          <p class="small">
            <div id="pass-strength-result" style="width: 24%;display: block;">Strength indicator</div>
          </p>
          <p class="small">
            <input type="hidden" name="id" value="<?php echo $user_id; ?>" />
          </p>
          <br/>
          <p>
            <input type="submit" name="submit" class="button" id="edit-user" value=" Update ">
          </p>
        <div class="clear"></div>

      </form>
  </div>
</div>
</body>
<script type='text/javascript'>
/* <![CDATA[ */
var pwsL10n = {"empty":"Strength indicator","short":"Very weak","bad":"Weak","good":"Medium","strong":"Strong","mismatch":"Mismatch"};
/* ]]> */
    (function(){

      jQuery(window).resize(function(){
        var password = jQuery('#pass2').width() + 11;
        jQuery('#pass-strength-result').width(password);
      });
    })();
</script>
<script type='text/javascript' src='js/password-strength-meter.js?ver=20101027'></script>
<script type='text/javascript' src='js/user-profile.js?ver=20110628'></script>