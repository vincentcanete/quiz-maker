<?php 
	require_once dirname(__FILE__) . '/inc/session.php';
    require_once dirname(__FILE__) . '/inc/connection.php';
    require_once dirname(__FILE__) . '/inc/functions.php';
    confirm_logged_in();   
    $quiz_id = $_POST['quiz_id'];

    error_reporting(0);
    if(!empty($quiz_id)){
	    $score = 0;
	    $count = 0;
	    global $connection;
	    $items = count_question_by_quiz_id($quiz_id);

	    $query = "SELECT * from questions where quiz_id = '$quiz_id'";
		$result = mysql_query($query,$connection);
		confirm_query($result);
		while($quest = mysql_fetch_array($result)){ 
			$quest_id = $quest['questions_id'];
			$question = $quest['questions_question'];

			$query2 = "SELECT * from answers where questions_id = '$quest_id'";
			$result2 = mysql_query($query2,$connection);
			confirm_query($result2); 

			while($ans = mysql_fetch_array($result2)){ 
				$answer_id = $ans['answer_id'];
				$correct = $ans['correct'];
				$answer = $_REQUEST[$answer_id];

				if( strtolower($answer) == strtolower($correct)){
					$score = $score + 1;
				}
				$count++;
			}
		}
	}
	$ratings = get_score_ratings($score , $items);
 ?>
<?php require_once dirname(__FILE__) . '/header.php' ?>
<div id="maincontainer">
      <div id="main" class="container_12">
<div class="box">
  <div class="box-header">
    <h1>The Results</h1>
    <div class="handler"><img src="img/tip_bg.png" alt="" title="Click to toggle"></div>
    <div class="clear"></div>
  </div>

  <div class="box-content">
      <div class="grid_6 alpha">
          <p class="large">
            <table class="datatable">
            	<thead>
            		<th colspan=2>Information</th>
            	</thead>
              <tbody>
                <?php global $connection;
                      $query = "SELECT * from quiz where quiz_id='$quiz_id'";
                      confirm_query($query);
                      $result = mysql_query($query,$connection);
                      while($row = mysql_fetch_array($result)){ ?>
                        <tr class="item">
                        <td><strong>Name : </strong> <?php echo strtoupper(substr($_SESSION['username'] , 0 , 1)) . substr($_SESSION['username'] , 1) ; ?></td>
                        <td><strong>Description : </strong> <?php echo $row['quiz_description']; ?></td>
                        </tr>
                        <tr>
                        <td><strong>Quiz Title : </strong> <?php echo $row['quiz_title']; ?></td>
                        <td><strong>Time Limit : </strong> <?php echo $row['quiz_timelimit'] . " Minutes"; ?></td>
                        </tr>
                        <tr>
                        <td><strong>Your Score : </strong> <?php echo $score . " out of " . $items ;?></td>
                        <td><strong>Score Ratings : </strong> <?php echo $ratings . "%";?></td>
                        </tr>
                 <?php } ?>
              </tbody>   
            </table>
          </p>
          <div id="loading" style="margin-top:60px"><img src="img/loading.gif" alt=""></div>
          <?php if($ratings < 50){ ?>
              <h1 class="failed">Failed!</h1>
          <?php }else{ ?>
              <h1 class="passed">Passed</h1>
          <?php } ?>

        </div>
        <div class="grid_6 omega">
            <div id="basic_pie" class="no_overflow" style="width:100%;height:300px"></div>
        </div>
        <div class="clear"></div>
  </div>
</div>
</div>
      <div class="clear"></div>
    </div>
<?php require_once dirname(__FILE__) . '/footer.php' ?>

<script type="text/javascript"> 
// JavaScript Document    
jQuery(document).ready(function() {
  
//===== CHART - BASIC PIE =====//
  var data = [
      { label: "Correct",  data: <?php echo $ratings; ?>},
      { label: "Wrong",  data: <?php echo $diff = 100 - $ratings ;?>}
    ];

  if(jQuery('#basic_pie').length){
  
  $.plot($("#basic_pie"), data,
  {
      series: {
        pie: {
          show: true,
          radius: 1,
          label: {
            show: true,
            radius: 3/4,
            formatter: function(label, series){
              return '<div style="font-size:8pt;text-align:center;padding:2px;color:white; line-height:16px;">'+label+'<br/>'+Math.round(series.percent)+'%</div>';
            },
            background: { opacity: 0.5 }
          }
        }
      },
      legend: {
        show: true
      }
  });}
  
//===== CHART - PIE DONUT =====//
  if(jQuery('#pie_donut').length){
  
    $.plot($("#pie_donut"), data,
    {
        series: {
          pie: {
            innerRadius: 0.5,
            radius: 1,
            show: true,
            label: {
            show: true,
            radius: 3/4,
            formatter: function(label, series){
              return '<div style="font-size:8pt;text-align:center;padding:2px;color:white; line-height:16px;">'+label+'<br/>'+Math.round(series.percent)+'%</div>';
            },
            background: { opacity: 0.5 }
          }
          }
        }
    });
  }
      
//===== jQUERY DATA TABLE =====//     
      oTable = $('#jqtable').dataTable({
          "bJQueryUI": true,
          "sPaginationType": "full_numbers"
      });   
});

(function(){
  jQuery('#loading').show();
  setInterval(function(){
    jQuery('#loading').hide();
    jQuery('h1.passed').fadeIn('slow');
    jQuery('h1.failed').fadeIn('slow');
  } , 1000);
})();
</script>