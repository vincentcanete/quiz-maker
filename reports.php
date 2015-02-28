
<?php
    require_once dirname(__FILE__) . '/inc/session.php';
    require_once dirname(__FILE__) . '/inc/connection.php';
    require_once dirname(__FILE__) . '/inc/functions.php';
    
    confirm_logged_in();
    error_reporting(0);
?>


<div class="box" id="show-quizzes">
  <div class="box-header">
    <h1>Reports</h1>
    <div class="handler"><img src="img/tip_bg.png" alt="" title="Click to toggle"></div>
    <div class="clear"></div>
  </div>
  
  <div class="box-content">
          <?php 
            global $connection;
            $query = "SELECT * from quiz";
            $result = mysql_query($query,$connection);
            confirm_query($result);
            $table_all ="";
          ?>

          <p>
            <form method="post" action="">
            <ul class="rep_query" >
              <li>
                <label for="rep-quiz">Please select quiz:</label>   
              </li>
              <li>
                <select multiple="multiple" style="width:300px" name="select_quizzes[]">
                  <?php while($data = mysql_fetch_array($result)){ ?>
                  <?php $title = $data['1']; ?>
                  <option value="<?php echo $data['0'];?>"><?php echo $data['1'] . " | " . $data['2']; ?></option>
                  <?php } ?>
                </select> 
              </li>
              <li>
                  <select multiple="multiple" name="rep-groups[]" style="width:100%">
                    <?php 
                        $group_ids = get_groups_id();
                        foreach ($group_ids as $group_id ):
                        $group_name = get_groups_name($group_id); ?>
                        <option value="<?php echo $group_id; ?>"><?php echo $group_name; ?></option>
                    <?php endforeach ?>
                  </select>
                </li>
                <li>
                <input type="submit" name="go" class="button" value="Go">
              </li>
            </ul>
            </form>
          <p>

          <div class="clear"></div>

          <div class="reports" style="margin-top:40px">
            <?php
            if(isset($_POST['select_quizzes']) && isset($_POST['rep-groups'])) {
              foreach ($_POST['select_quizzes'] as $quiz_id){ 
                  $groups = $_POST['rep-groups'];
                  foreach ( $groups as $group) {
            ?>

            <?php  $sql  = "SELECT quiz_title, quiz_description, score_rating, is_admin, points, value, name , wpusers.ID
                            FROM quiz, ratings, wpbp_xprofile_data, wpbp_groups, wpbp_groups_members , wpusers
                            WHERE wpbp_xprofile_data.field_id =1
                            AND wpbp_xprofile_data.user_id = ratings.student_id
                            AND ratings.student_id = wpbp_groups_members.user_id
                            AND wpbp_groups.id = wpbp_groups_members.group_id
                            AND quiz.quiz_id = ratings.quiz_id
                            AND wpbp_xprofile_data.user_id = wpusers.ID
                            AND quiz.quiz_id =  '$quiz_id' and wpbp_groups.id = '$group' ORDER BY value"; 

                   $result = mysql_query($sql,$connection);
                   confirm_query($result);
                   while($row = mysql_fetch_array($result)){
                        $title = $row['quiz_title'];
                        $desc = $row['quiz_description'];
                   }
            ?>


              <div class="box">
                <div class="box-header">
                  <h1><?php echo $title; ?></h1>
                  <div class="handler"><img src="img/tip_bg.png" alt="" title="Click to toggle"></div>
                  <div class="clear"></div>
                </div>
                
                <div class="box-content">
                        <p class="large">
                          <table class="datatable">
                            <thead>
                              <tr>
                                <th>Names</th>
                                <th>Group</th>
                                <th>Points</th>
                                <th>Ratings</th>
                                <th>Remarks</th>
                              </tr>
                            </thead>
                            <tbody>

                            <?php $result2 = mysql_query($sql,$connection);
                                  while($row2 = mysql_fetch_array($result2)){ 
                                  $score_rating = $row2['score_rating'];
                                  $points = $row2['points'];
                                  $arr = explode(" ", $points);
                                  $score = $arr[0];
                                  $items = $arr[3];
                                  $name = $row2['value'];
                                  $group = $row2['name'];
                                  $is_admin = $row2['is_admin'];
                                  $rating = ($score / $items) * 50 + 50 ;
                                  if(!$is_admin == 1){
                            ?>
                                <tr>
                                  <td><?php echo ucwords(htmlentities($name)); ?></td>
                                  <td><?php echo htmlentities($group); ?></td>
                                  <td><?php echo $points; ?></td>
                                  <td><?php echo substr($rating ,0,5); ?></td>
                                  <td><?php if($rating < 75) echo "FAILED"; else echo "PASSED" ;?></td>
                                </tr>
                            <?php } } ?>
                            
                            </tbody>   
                          </table> 
                        </p>


 <?php $tables =       "<br/><br/>
                          <p><b>Quiz Title:</b> " . $title . "</p>
                          <p><b>Description:</b> " . $desc . "</p>
                          <p><b>SET/Group:</b> " . $group . "</p>
                          <table cellspacing='4' cellpadding='4' >
                          <tr>
                            <td><center><b>Names</b></center></td>
                            <td><center><b>Groups</b></center></td>
                            <td><center><b>Points</b></center></td>
                            <td><center><b>Ratings</b></center></td>
                            <td><center><b>Remarks</b></center></td>
                          </tr>" ; ?>

                        <?php $result3 = mysql_query($sql,$connection);
                                  while($row3 = mysql_fetch_array($result3)){ 
                                  $isadmin = $row3['is_admin'];
                                  $sr = $row3['score_rating'];
                                  $pts = $row3['points'];
                                  $nym = $row3['value'];
                                  $grp = $row3['name'];
                                  $array = explode(" ", $pts);
                                  $scr = $array[0];
                                  $itms = $array[3];
                                  $rate = ($scr / $itms) * 50 + 50 ;

                                  if( !$isadmin == 1 ){
                                    if($rate < 75){
                                      $ov = "FAILED";
                                    }else{
                                      $ov = "PASSED";
                                    }
                         ?>

    <?php $tables .=     "<tr>" .
                            "<td>" . ucwords(htmlentities($nym)) . "</td>" .
                            "<td>" . htmlentities($grp) . "</td>" .
                            "<td>" . $pts . "</td>" .
                            "<td>" . substr($rate,0,5) . "</td>" .
                            "<td>" . $ov . "</td>" .
                          "</tr>" ; ?>
                        <?php } }  ?>
     <?php $tables .=     "</table><p>&nbsp;</p>";  $table_all = $table_all . $tables; ?>

                </div>
              </div>
              
              <?php } } //end foreach
              } ?>
          </div>

        <div class="clear"></div>

        <?php if(isset($_POST['select_quizzes'])) {?>
        <form method="post" action="pdf/">
              <input type="hidden" name="table" value="<?php echo stripcslashes($table_all); ?>">
              <input type="submit" value="Export as PDF" class="button">
        </form>
        <?php } ?>
  </div>
</div>
