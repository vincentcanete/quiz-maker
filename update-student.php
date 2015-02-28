<?php 
		require_once dirname(__FILE__) . '/inc/session.php';
	    require_once dirname(__FILE__) . '/inc/connection.php';
	    require_once dirname(__FILE__) . '/inc/functions.php';
	    confirm_logged_in();

	    $name = $_POST['name'];
	    $group = $_POST['stud-group'];
	    $stud_id = $_POST['stud-id'];

		if( isset($name) && isset($group) ){
			global $connection;

			$query = "UPDATE wpbp_xprofile_data, wpbp_groups, wpbp_groups_members SET value ='$name' , wpbp_groups_members.group_id='$group' WHERE wpbp_xprofile_data.field_id =1  AND wpbp_xprofile_data.user_id = '$stud_id' and wpbp_xprofile_data.user_id =  wpbp_groups_members.user_id and wpbp_groups_members.group_id = wpbp_groups.id";
			$result = mysql_query($query,$connection);
			confirm_query($result);

			if ($result){
				redirect_to('content.php?page=students&msg=1');
			}else{
				redirect_to('content.php?page=students&msg=0');
			}
		}

?>