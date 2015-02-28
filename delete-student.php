<?php 
	// This is not necessary for Managing a Student's Account.. No deletion..

	require_once dirname(__FILE__) . '/inc/session.php';
    require_once dirname(__FILE__) . '/inc/connection.php';
    require_once dirname(__FILE__) . '/inc/functions.php';
    confirm_logged_in();

    $page = $_GET['page'];
    $id = $_GET['quiz_id'];

	if(isset($id) && isset($page)){
		global $connection;

	//	$query = "DELETE FROM  wpbp_xprofile_data,  wpbp_groups_members, wpusers where  wpbp_xprofile_data.user_id = '35' and wpbp_xprofile_data.user_id =  wpbp_groups_members.user_id and wpusers.ID = wpbp_groups_members.user_id";
		$result = mysql_query($query,$connection);
		confirm_query($result);
		if ($result){
			echo "success";
		}else{
			echo "failed";
		}
	}
?>
