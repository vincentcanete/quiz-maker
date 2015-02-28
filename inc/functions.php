<?php
	function get_all_users(){
		global $connection;
		$query = "SELECT  value , (SELECT value from wpbp_xprofile_data where wpbp_xprofile_data.field_id =6 and wpusers.ID = wpbp_xprofile_data.user_id ) as num FROM  wpbp_xprofile_data,  wpusers WHERE wpbp_xprofile_data.field_id =1 AND wpbp_xprofile_data.user_id =  wpusers.ID GROUP BY num;";
		$result = mysql_query($query,$connection);
		confirm_query($result);
		echo "<select multiple='multiple' name='groups[]' style='width:400%'>";
		while($row = mysql_fetch_array($result)){ 
			$name = $row['value'];
			$num = $row['num'];
?>
		<option value="<?php echo $num?>"><?php echo $name?></option>
<?php
		}
		echo "</select>";
	}
	
	function upload_file(){
		$name = $_FILES["file"]["name"];
        move_uploaded_file( $_FILES["file"]["tmp_name"], "uploads/" . $_FILES['file']['name']);
        return $name;
	}

	function get_group_id_by_user_id($id){
		global $connection;
		$query = "SELECT group_id from wpbp_groups_members where user_id='$id'";
		$result = mysql_query($query,$connection);
		confirm_query($result);
		$grp_ids = array();
		$i = 0;
		while($row = mysql_fetch_array($result)){ 
			$group_id = $row['group_id'];
			$grp_ids[$i++] = $group_id;
		}
		return $grp_ids;
	}
	
	function get_user_name_by_id($id){
		global $connection;
		$query = "SELECT value from wpbp_xprofile_data where field_id = 1 and user_id='$id'";
		$result = mysql_query($query,$connection);
		confirm_query($result);
		while($row = mysql_fetch_array($result)){ 
			$user_name = $row['value'];
		}
		return $user_name;
	}

	function get_quiz_groups($id){
		global $connection;
		$groups = "";
		$query = "SELECT quiz_groups from quiz where quiz_id='$id'";
		$result = mysql_query($query,$connection);
		confirm_query($result);
		while($row = mysql_fetch_array($result)){ 
			$groups = $row['quiz_groups'];
		}
		return $groups;
	}

	function get_assign_groups($id){
		global $connection;
		$groups = "";
		$query = "SELECT assign_groups from assignment where assign_id='$id'";
		$result = mysql_query($query,$connection);
		confirm_query($result);
		while($row = mysql_fetch_array($result)){ 
			$groups = $row['assign_groups'];
		}
		return $groups;
	}

	function get_groups_name($id){
		global $connection;

		$query = "SELECT name from wpbp_groups where id='$id'";
		$result = mysql_query($query,$connection);
		confirm_query($result);
		while($row = mysql_fetch_array($result)){ 
			$group_name = $row['name'];
		}
		return $group_name;
	}

	function get_groups_id(){
		global $connection;
		$groups = array();
		$i=0;
		$query = "SELECT id from wpbp_groups";
		$result = mysql_query($query,$connection);
		confirm_query($result);
		while($row = mysql_fetch_array($result)){ 
			$group = $row['id'];
			$groups[$i++] = $group; 
		}
		return $groups;
	}
	function get_role($user_id){
		global $connection;

		$query = "SELECT type from users where user_id='$user_id'";
		$result = mysql_query($query,$connection);
		confirm_query($result);
		while($row = mysql_fetch_array($result)){ 
			$type = $row['type'];
		}
		return $type;
	}

	function get_score_ratings($score , $items){
		$rate = ($score / $items) * 100;
		return (int) $rate;
	}

	function count_question_by_quiz_id($quiz_id){
		global $connection;

		$query = "SELECT count(questions_question) as items from questions where quiz_id = '$quiz_id'";
		$result = mysql_query($query,$connection);
		confirm_query($result);
		while($row = mysql_fetch_array($result)){ 
			$items = $row['items'];
		}
		return $items;
	}
	function get_the_title_by_id($id){
		global $connection;
		$query = "SELECT quiz_title from quiz where quiz_id = '$id'";
		$result = mysql_query($query,$connection);
		confirm_query($result);
		while($row = mysql_fetch_array($result)){ 
			$title = $row['quiz_title'];
		}
		return $title;
	}

	function get_quiz_desc_by_title($title){
		global $connection;
		$query = "SELECT quiz_description from quiz where quiz_title = '$title'";
		$result = mysql_query($query,$connection);
		confirm_query($result);
		$desc = "";
		while($row = mysql_fetch_array($result)){ 
			$desc = $row['quiz_description'];
		}
		return $desc;
	}
	function get_quiz_time_limit_by_id($id){
		global $connection;
		$query = "SELECT quiz_timelimit from quiz where quiz_id= '$id'";
		$result = mysql_query($query,$connection);
		confirm_query($result);
		while($row = mysql_fetch_array($result)){ 
			$limit = $row['quiz_timelimit'];
		}
		return $limit;
	}

	function get_quiz_id_by_title($title){
		global $connection;
		$query = "SELECT quiz_id from quiz where quiz_title = '$title'";
		$result = mysql_query($query,$connection);
		confirm_query($result);
		$quiz_id = "";
		while($row = mysql_fetch_array($result)){ 
			$quiz_id = $row['quiz_id'];
		}
		return $quiz_id;
	}

	function get_question_id_by_question($question){
		global $connection;
		$query = "SELECT questions_id from questions where questions_question = '$question'";
		$result = mysql_query($query,$connection);
		confirm_query($result);
		while($row = mysql_fetch_array($result)){ 
			$question_id = $row['questions_id'];
		}
		return $question_id;
	}
	function get_question_attr_by_id($id){
		global $connection;
		$query = "SELECT * from questions where questions_id = '$id'";
		$result = mysql_query($query,$connection);
		confirm_query($result);
		while($row = mysql_fetch_array($result)){ 
			$quiz_id = $row['quiz_id'];
			$question = $row['questions_question'];
			$type = $row['questions_type'];
		}
		return $questions_attr = array($quiz_id , $question , $type);

	}
	function get_answer_attr_by_quest_id($id){
		global $connection;
		$query = "SELECT * from answers where questions_id = '$id'";
		$result = mysql_query($query,$connection);
		confirm_query($result);
		while($row = mysql_fetch_array($result)){ 
			$answer_id = $row['answer_id'];
			$answer = $row['answer'];
			$correct = $row['correct'];
		}
		return $answer_attr = array($answer_id , $answer , $correct);

	}
	function redirect_to( $location = NULL ) {
		if ($location != NULL) {
			header("Location: {$location}");
			exit;
		}
	}
	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed: " . mysql_error());
		}
	}
	
	function mysql_prep( $value ) {
		$magic_quotes_active = get_magic_quotes_gpc();
		$new_enough_php = function_exists( "mysql_real_escape_string" ); // i.e. PHP >= v4.3.0
		if( $new_enough_php ) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
			if( $magic_quotes_active ) { $value = stripslashes( $value ); }
			$value = mysql_real_escape_string( $value );
		} else { // before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
			if( !$magic_quotes_active ) { $value = addslashes( $value ); }
			// if magic quotes are active, then the slashes already exist
		}
		return $value;
	}
		
	function destroy_session(){
	$_SESSION = array();
	if(isset($_COOKIE[session_name()])){
		setcookie(session_name(), '',time()-42000, '/');
	}
	session_destroy();
	}
	
?>