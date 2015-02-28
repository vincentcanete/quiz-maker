<?php 
	require_once dirname(__FILE__) . '/inc/session.php';
    require_once dirname(__FILE__) . '/inc/connection.php';
    require_once dirname(__FILE__) . '/inc/functions.php';
    confirm_logged_in();

    $name = $_POST['name'];
    $username = $_POST['user_name'];
	$password = $_POST['admin_password'];
	$password = sha1($password);
	$password2 = $_POST['admin_password2'];
	$password2 = sha1($password2);

	if(!empty($name) && !empty($username) && !empty($password) && $password==$password2){
		global $connection;
		$query = "INSERT INTO users(nice_name,name,hash_password,type) values ('$name','$username','$password','Admin')";
		$result = mysql_query($query,$connection);
		confirm_query($result);
		if ($result){
			redirect_to('content.php?page=user&msg=1');
		}else{
			redirect_to('content.php?page=user&msg=0');
		}
	}else{
		redirect_to('content.php?page=user&msg=error');
	}
?>