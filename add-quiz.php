<?php 
	require_once dirname(__FILE__) . '/inc/session.php';
    require_once dirname(__FILE__) . '/inc/connection.php';
    require_once dirname(__FILE__) . '/inc/functions.php';
    confirm_logged_in();

    $qtype = $_REQUEST['qtype'];
    if($qtype == 'mc'){ 			// For Multiple Choice 

	    $title = $_REQUEST['title'];
		$file = $_REQUEST['file'];
		$time = $_REQUEST['time'];
		$question = $_REQUEST['question'];
		$answers = $_REQUEST['answers'];
		$correct = $_REQUEST['correct'];
		$items = $_REQUEST['items'];
		$datepicker = $_REQUEST['datepicker'];
		$groups = $_REQUEST['qgroups'];
		$grp = "";
		foreach ($groups as $group) {
			if(!empty($grp)){
			$grp = $grp . "," . $group;
			}else{
			$grp = $group;
			}
		}
		$publish = $_REQUEST['qpublish'];

		if(isset($title) && isset($file) && isset($time)){
			global $connection;

			$query = "INSERT INTO quiz(quiz_title,quiz_description,quiz_timelimit,added_on,quiz_datelimit,quiz_shown_items,quiz_groups,quiz_publish_on) values ('$title','$file','$time',curdate(),'$datepicker','$items','$grp','$publish')";
			$result = mysql_query($query,$connection);
			confirm_query($result);

			$q_id = get_quiz_id_by_title($title);
			$query2 = "INSERT INTO questions(quiz_id,questions_question,questions_type) values ('$q_id','$question','$qtype')";
			$result2 = mysql_query($query2,$connection);
			confirm_query($result2);

			$question_id = get_question_id_by_question($question);
			$query3 = "INSERT INTO answers(questions_id,answer,correct) values ('$question_id','$answers','$correct')";
			$result3 = mysql_query($query3,$connection);
			confirm_query($result3);

			if ($result && $result2 && $result3){
				echo "success";
			}else{
				echo "failed";
			}
		}
	}

	if($qtype == 'tf'){			// For True or False

		$title = $_REQUEST['title'];
		$file = $_REQUEST['file'];
		$time = $_REQUEST['time'];
		$question = $_REQUEST['question'];
		$correct = $_REQUEST['correct'];

		if(isset($title) && isset($file) && isset($time)){
			global $connection;

			$query = "INSERT INTO quiz(quiz_title,quiz_description,quiz_timelimit,added_on) values ('$title','$file','$time',curdate())";
			$result = mysql_query($query,$connection);
			confirm_query($result);

			$q_id = get_quiz_id_by_title($title);
			$query2 = "INSERT INTO questions(quiz_id,questions_question,questions_type) values ('$q_id','$question','$qtype')";
			$result2 = mysql_query($query2,$connection);
			confirm_query($result2);

			$question_id = get_question_id_by_question($question);

			if($correct == 'true'){ $answers = 'false'; }else{ $answers = 'true'; }
			$query3 = "INSERT INTO answers(questions_id,answer,correct) values ('$question_id','$answers','$correct')";
			$result3 = mysql_query($query3,$connection);
			confirm_query($result3);

			if ($result && $result2 && $result3){
				echo "success";
			}else{
				echo "failed";
			}
		}
	}

	if($qtype == 'identification'){			// For Identification

		$title = $_REQUEST['title'];
		$file = $_REQUEST['file'];
		$time = $_REQUEST['time'];
		$question = $_REQUEST['question'];
		$correct = $_REQUEST['correct'];
		$answers = "";

		if(isset($title) && isset($file) && isset($time)){
			global $connection;

			$query = "INSERT INTO quiz(quiz_title,quiz_description,quiz_timelimit,added_on) values ('$title','$file','$time',curdate())";
			$result = mysql_query($query,$connection);
			confirm_query($result);

			$q_id = get_quiz_id_by_title($title);
			$query2 = "INSERT INTO questions(quiz_id,questions_question,questions_type) values ('$q_id','$question','$qtype')";
			$result2 = mysql_query($query2,$connection);
			confirm_query($result2);

			$question_id = get_question_id_by_question($question);
			$query3 = "INSERT INTO answers(questions_id,answer,correct) values ('$question_id','$answers','$correct')";
			$result3 = mysql_query($query3,$connection);
			confirm_query($result3);

			if ($result && $result2 && $result3){
				echo "success";
			}else{
				echo "failed";
			}
		}
	}

?>