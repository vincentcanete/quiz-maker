<?php 
		require_once dirname(__FILE__) . '/inc/session.php';
	    require_once dirname(__FILE__) . '/inc/connection.php';
	    require_once dirname(__FILE__) . '/inc/functions.php';
	    confirm_logged_in();

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

			$query = "INSERT INTO assignment(assign_title , assign_content , assign_points , assign_groups , assign_deadline , assign_publish_date , file_location ) 
					values ('$title', '$content', '$points' , '$grp', '$deadline', '$publish', '$location' )";
			$result = mysql_query($query,$connection);
			confirm_query($result);

			if ($result){
				redirect_to('content.php?page=new-assignment&msg=success');
			}else{
				redirect_to('content.php?page=new-assignment&msg=error');
			}
		}

?>