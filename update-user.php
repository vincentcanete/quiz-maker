<?php
    require_once dirname(__FILE__) . '/inc/session.php';
    require_once dirname(__FILE__) . '/inc/connection.php';
    require_once dirname(__FILE__) . '/inc/functions.php';
    confirm_logged_in();

if(isset($_POST['submit'])){
      global $connection;

      if(!empty($_POST['name']) && !empty($_POST['user_name']) && ($_POST['admin_password'] == $_POST['admin_password2'])){
        $admin_password = sha1($admin_password);

        $id = $_POST['id'];
        $name = $_POST['name'];
        $username = $_POST['user_name'];
        $password = $_POST['admin_password'];
        $password = sha1($password);

        $query2 = "UPDATE users SET nice_name = '$name' , name = '$username' , hash_password = '$password'  WHERE user_id = '$id'";
        $result2 = mysql_query($query2,$connection);
        confirm_query($result2); 
        if($result2){
          redirect_to('content.php?page=user&notif=1');
        }else{
          redirect_to('content.php?page=user&notif=0');
        }
      }else{
          redirect_to('content.php?page=user&notif=mismatch');
      } 
  }
?>