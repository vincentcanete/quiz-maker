<?php 
	require_once dirname(__FILE__) . '/inc/session.php';
    require_once dirname(__FILE__) . '/inc/connection.php';
    require_once dirname(__FILE__) . '/inc/functions.php';
    confirm_logged_in();

    $qtype = $_REQUEST['qtype'];

    if($qtype == 'mc'){				// For Multiple Choice

	    $title = $_REQUEST['title'];
		$question = $_REQUEST['question'];
		$answers = $_REQUEST['answers'];
		$correct = $_REQUEST['correct'];
		$quest_id = $_REQUEST['quest_id'];

		if(isset($question)){
			global $connection;

			$query2 = "UPDATE questions SET questions_question = '$question' , questions_type = '$qtype' WHERE questions_id = '$quest_id'";
			$result2 = mysql_query($query2,$connection);
			confirm_query($result2);

			$answer_attr = get_answer_attr_by_quest_id($quest_id);
			$ans_id = $answer_attr['0'];
			$query3 = "UPDATE answers SET answer = '$answers' , correct = '$correct' where answer_id = '$ans_id'";
			$result3 = mysql_query($query3,$connection);
			confirm_query($result3);

			if ($result2 && $result3){
				echo "success";
			}else{
				echo "failed";
			}
		}
	}

	if($qtype == 'tf'){				// For True or False

	    $title = $_REQUEST['title'];
		$question = $_REQUEST['question'];
		$correct = $_REQUEST['correct'];
		$quest_id = $_REQUEST['quest_id'];

		if(isset($question)){
			global $connection;

			$query2 = "UPDATE questions SET questions_question = '$question' , questions_type = '$qtype' WHERE questions_id = '$quest_id'";
			$result2 = mysql_query($query2,$connection);
			confirm_query($result2);

			$answer_attr = get_answer_attr_by_quest_id($quest_id);
			if($correct == 'true'){ $answers = 'false'; }else{ $answers = 'true'; }

			$ans_id = $answer_attr['0'];
			$query3 = "UPDATE answers SET answer = '$answers' , correct = '$correct' where answer_id = '$ans_id'";
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
		$quest_id = $_REQUEST['quest_id'];
		$answers = "";

		if(isset($question)){
			global $connection;

			$query2 = "UPDATE questions SET questions_question = '$question' , questions_type = '$qtype' WHERE questions_id = '$quest_id'";
			$result2 = mysql_query($query2,$connection);
			confirm_query($result2);

			$answer_attr = get_answer_attr_by_quest_id($quest_id);
			$ans_id = $answer_attr['0'];
			$query3 = "UPDATE answers SET answer = '$answers' , correct = '$correct' where answer_id = '$ans_id'";
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