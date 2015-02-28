<?php
    require_once dirname(__FILE__) . '/inc/session.php';
    require_once dirname(__FILE__) . '/inc/connection.php';
    require_once dirname(__FILE__) . '/inc/functions.php';
    confirm_logged_in();
    date_default_timezone_set('UTC');
    $date = date('F-j-Y-g:i:s:');

    $quiz_id = $_GET['quiz_id'];
    $title = get_the_title_by_id($quiz_id);
    $description = get_quiz_desc_by_title($title);
    $time_limit = get_quiz_time_limit_by_id($quiz_id);
?>
<div class="grid_6 alpha" id="container-start">
	<div class="box">
	  <div class="box-header">
	    <h1>Lets Begin</h1>
	  </div>

	  <div class="box-content" id="start">
	  		<a href="#start" class="button blue" id="start-now"><span class="glyph time mega"></span>Start Now</a>
	  </div>
	  		
	</div>
</div>

<div class="grid_6 omega">
  	<div class="box" id="wrapper-timer">
	  <div class="box-header">
	    <h1>Timer</h1>
	  </div>

	  <div class="box-content">
	  		<div id="timer"></div>
	  		<div id="message"></div>
	  		<div id="loading"><img src="img/loading.gif" alt="" /></div>
	  		<div id="timeholder" class="hasCountdown"><span class="countdown_row countdown_show2"><span class="countdown_section"><span class="countdown_amount"><?php echo $time_limit ?></span><br>Minutes</span><span class="countdown_section"><span class="countdown_amount">00</span><br>Seconds</span></span>
	  		</div>

	  		<div id="note"></div>
	  		<div class="clear"></div>
	  </div>
	  		
	</div>		
</div>

<div class="clear"></div>

<div class="box">
  <div class="box-header">
    <h1><?php echo $description ." | " . $title ?></h1>
  </div>

  <div class="box-content">
  	<p class="intro">Click "Start Now" to show questions and you may start answering before the time limit ends.</p>
  	<div id="wrapper-quiz">
  		<form action="result.php?quiz_id=<?php echo $quiz_id ?>" method="post" id="form-quiz" name="form_quiz">

    <?php 
    global $connection;

    	$letters = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
    	$items = count_question_by_quiz_id($quiz_id);

		$query = "SELECT * from questions where quiz_id = '$quiz_id' ORDER BY RAND()";
		$result = mysql_query($query,$connection);
		confirm_query($result);
		$count = 0;
		$counter = 0;
		while($row = mysql_fetch_array($result)){ 
			$quest_id = $row['questions_id'];
			$question = $row['questions_question'];
			$quest_type = $row['questions_type'];

			$query2 = "SELECT * from answers where questions_id = '$quest_id'";
			$result2 = mysql_query($query2,$connection);
			confirm_query($result2);
			while($ans = mysql_fetch_array($result2)){ $count++; 
				$answer_id = $ans['answer_id'];
				$answer = $ans['answer'];
				$correct = $ans['correct'];
				$answers = array();
				$ctr = 0;
				$answers_fn = explode('#', $answer);
				foreach ($answers_fn as $answer_fn) {
					$answers[$ctr++] = $answer_fn;
				}
				$n = count($answers);
			?>
					<div class="box inner-box" >
					  <div class="box-header">
					    <h1><?php echo $count . " / " . $items;?></h1>
					  </div>
					  <div class="box-content">

					<div class="question_area"><div class="num"><?php echo $count . "."?></div> <?php echo $question; ?> </div>

					<?php if($quest_type == 'mc') {  $letter = 0; ?>

					<div class="choices">
						<?php foreach ($answers as $answer) { ?>
							<input type="radio" name="<?php echo $answer_id ?>" id="choice-<?php echo ++$counter?>" value="<?php echo $letters[$letter++]; ?>">
							<label for="choice-<?php echo $counter?>"><?php echo $answer ?></label>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if($quest_type == 'tf') {  ?>
					<div class="choices">
						<select name="<?php echo $answer_id?>" style= "width: 150px">
							<option></option>
							<option value="true">True</option> 
							<option value="false">False</option>
						</select>
					</div>
					<?php } ?>

					<?php if($quest_type == 'identification') {  ?>
					<div class="choices">
						<p class="small">
						<input type="text" name="<?php echo $answer_id?>" value="" />
						</p>
					</div>
					<?php } ?>

					<div class="pagination">
						<?php if($count == $items ) { ?>
							<input type="submit" class="button blue page-button" value="Submit Your Answers" />
						<?php }else{ ?>
							<a href="#" class="button page-button">Next Question</a>
						<?php } ?>
					</div>

					</div>
				</div>
		<?php	} ?>
	<?php } ?>
	<input type="hidden" name="quiz_id" value="<?php echo $quiz_id ?>" />
	</form>
	<span id="watcher"></span>
  </div>
  </div>
</div>
<link rel="stylesheet" href="countdown/jquery.countdown.css">
<script type="text/javascript" src="countdown/jquery.countdown.js"></script>
<script type="text/javascript">
	(function(){
		
		jQuery('#start-now').bind('click',function(){
			jQuery('#container-start').fadeOut('500',function(){
				jQuery('#wrapper-timer').unwrap();
				jQuery('#timeholder').hide();
				jQuery('p.intro').fadeOut('500',function(){
					jQuery('#wrapper-quiz').slideDown('slow');
				});
				jQuery (function(){
						var note = jQuery ('#note');
						var austDay = new Date();
						minute = '<?php echo $time_limit; ?>',
						
						ts = new Date(austDay.getTime() + minute * 60 * 1000 ) ;
						
					jQuery ('#timer').countdown({
						until	: ts,
						 format : 'MS',
						 onExpiry: liftOff
						 //layout : '{mnn}{sep}{snn}',
						 //onTick: FunctionAll
					});	
					
				});
			})
		})

	})();
function liftOff() { 
					jQuery ('#timer').hide();
					jQuery ('#wrapper-quiz').fadeOut('slow',function(){
					jQuery ('#message').text("Time is over! Submitting your answers... ");
					jQuery ('#loading').show();
						
				});
    setInterval(function(){jQuery("#form-quiz").submit();} , 3000);
}


	(function(){
		var inner = jQuery('.inner-box') ,
		button = jQuery('.pagination a'),
		i = 0,
		items = "<?php echo $items; ?>";
		inner.first().show();
		button.on('click',function(){
			i++;
			if(items > i){
					var selector = ".inner-box:nth-child(" + i + ")";
					inner.closest('.inner-box').slideUp();
					jQuery(selector).next('.inner-box').slideDown();
			}
		})
	})();

</script>