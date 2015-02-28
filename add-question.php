<?php 
	require_once dirname(__FILE__) . '/inc/session.php';
    require_once dirname(__FILE__) . '/inc/connection.php';
    require_once dirname(__FILE__) . '/inc/functions.php';
    confirm_logged_in();

    $qtype = $_REQUEST['qtype'];

    if($qtype == 'mc'){ 			// For Multiple Choice 

	    $title = $_REQUEST['title'];
		$question = $_REQUEST['question'];
		$answers = $_REQUEST['answers'];
		$correct = $_REQUEST['correct'];
		
		if(isset($question)){
			global $connection;

			$q_id = get_quiz_id_by_title($title);
			$query2 = "INSERT INTO questions(quiz_id,questions_question,questions_type) values ('$q_id','$question','$qtype')";
			$result2 = mysql_query($query2,$connection);
			confirm_query($result2);

			$question_id = get_question_id_by_question($question);
			$query3 = "INSERT INTO answers(questions_id,answer,correct) values ('$question_id','$answers','$correct')";
			$result3 = mysql_query($query3,$connection);
			confirm_query($result3);

			if ($result2 && $result3){
				echo "success";
			}else{
				echo "failed";
			}
		}
	}

	if($qtype == 'tf'){			// For True or False

		$title = $_REQUEST['title'];
		$question = $_REQUEST['question'];
		$correct = $_REQUEST['correct'];
		
		if(isset($question)){
			global $connection;

			$q_id = get_quiz_id_by_title($title);
			$query2 = "INSERT INTO questions(quiz_id,questions_question,questions_type) values ('$q_id','$question','$qtype')";
			$result2 = mysql_query($query2,$connection);
			confirm_query($result2);

			$question_id = get_question_id_by_question($question);

			if($correct == 'true'){ $answers = 'false'; }else{ $answers = 'true'; }

			$query3 = "INSERT INTO answers(questions_id,answer,correct) values ('$question_id','$answers','$correct')";
			$result3 = mysql_query($query3,$connection);
			confirm_query($result3);

			if ($result2 && $result3){
				echo "success";
			}else{
				echo "failed";
			}
		}
	}

	if($qtype == 'identification'){		// For Identification

		$title = $_REQUEST['title'];
		$question = $_REQUEST['question'];
		$correct = $_REQUEST['correct'];
		$answers = "";

		if(isset($question)){
			global $connection;

			$q_id = get_quiz_id_by_title($title);
			$query2 = "INSERT INTO questions(quiz_id,questions_question,questions_type) values ('$q_id','$question','$qtype')";
			$result2 = mysql_query($query2,$connection);
			confirm_query($result2);

			$question_id = get_question_id_by_question($question);
			$query3 = "INSERT INTO answers(questions_id,answer,correct) values ('$question_id','$answers','$correct')";
			$result3 = mysql_query($query3,$connection);
			confirm_query($result3);

			if ($result2 && $result3){
				echo "success";
			}else{
				echo "failed";
			}
		}
	}
?>