<?php 
		require_once dirname(__FILE__) . '/inc/session.php';
	    require_once dirname(__FILE__) . '/inc/connection.php';
	    require_once dirname(__FILE__) . '/inc/functions.php';
	    confirm_logged_in();
	    $id = $_POST['id'];
		$title = $_POST['assign-title'];
		$content = $_POST['assign-content'];
		$groups = $_POST['assign-groups'];
		$points = $_POST['assign-points'];
		$grp = "";
		foreach ($groups as $group) {
			if(!empty($grp)){
			$grp = $grp . "," . $group;
			}else{
			$grp = $group;
			}
		}
		$deadline = $_POST['assign-deadline'];
		$publish = $_POST['assign-publish'];
		$file = upload_file();
		$location = "uploads/" . $file;
		if( isset($title) && isset($content) && isset($deadline) && isset($publish) ){
			global $connection;

			$query = "UPDATE assignment SET assign_title = '$title' , assign_content = '$content' , assign_points = '$points' , assign_groups = '$grp' , assign_deadline = '$deadline' , assign_publish_date = '$publish' , file_location='$location' where assign_id = '$id'";
			$result = mysql_query($query,$connection);
			confirm_query($result);

			if ($result){
				redirect_to("content.php?page=edit-assignment&assign_id=$id&update=ok");
			}else{
				redirect_to("content.php?page=edit-assignment&assign_id=$id&update=err");
			}
		}

?>
