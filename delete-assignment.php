<?php 
	require_once dirname(__FILE__) . '/inc/session.php';
    require_once dirname(__FILE__) . '/inc/connection.php';
    require_once dirname(__FILE__) . '/inc/functions.php';
    confirm_logged_in();

    $page = $_GET['page'];
    $id = $_GET['assign_id'];

	if(isset($id) && isset($page)){
		global $connection;

		$query = "DELETE FROM assignment where assign_id = '$id'";
		$result = mysql_query($query,$connection);
		confirm_query($result);
		if ($result){
			echo "success";
		}else{
			echo "failed";
		}
	}
?>