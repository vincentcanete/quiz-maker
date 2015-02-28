<?php
    require_once dirname(__FILE__) . '/inc/session.php';
    require_once dirname(__FILE__) . '/inc/connection.php';
    require_once dirname(__FILE__) . '/inc/functions.php';
    confirm_logged_in();
    $date = date('M-j-Y:g:i a');
?>
<div id="dialog-message" title="Error Message" style="display:none">
  <p>
    <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
    Please complete all fields!
  </p>
</div>

<div class="box" id="info">
  <div class="box-header">
    <h1>Create New Quiz</h1>
    <div class="handler"><img src="img/tip_bg.png" alt="" title="Click to toggle"></div>
    <div class="clear"></div>
  </div>
  
  <div class="box-content">
      <form action="" method="post" id="form1">
        <div class="column-left">
          <p>
            <label for="title">Quiz Title:</label>
            <input type="text" name="title" id="title" placeholder="Title" value="<?php echo $date; ?>" />
          </p>
          <p class="medium">
              <label for="quiz-publish">Publish on: </label>
              <input type="text" name="quiz-publish" class="datepicker" id="quiz-publish">
          </p>
          <p class="medium">
              <label for="quiz-groups" style="display: block">Select Groups: </label>
              <select multiple="multiple" id="quiz-groups" style="width:100%">
                <?php 
                    $group_ids = get_groups_id();
                    foreach ($group_ids as $group_id ):
                    $group_name = get_groups_name($group_id); ?>
                    <option value="<?php echo $group_id; ?>"><?php echo $group_name; ?></option>
                <?php endforeach ?>
              </select>
          </p>
          <p class="medium">
            <label for="question-type">Question Type:</label>
            <select name="types" id="question-type" style="width:100%;">
              <option></option>
              <option value="choice">Multiple Choice</option>
              <option value="truefalse">True or False</option>
              <option value="identify">Identification</option>
            </select>
          </p>
          <br/>
          <p>
            <input type="submit" class="button" id="add-question" value="Add First Question">
          </p>
        </div>
        
        <div class="column-right">
          <p class="large">
            <label for="file">Description (In Few Words) :</label>
            <input type="text" id="file" name="file" value=""/>  
          </p>

          <p class="medium">
              <label for="datepicker">Expiration Date:</label>
              <input type="text" name="date" class="datepicker" id="datepicker">
          </p>

            <p class="small">
              <label for="time">Time Limit: (Min)</label>
              <input type="text" id="time" name="time" value="" maxlength="2"/>  
            </p>
            <p class="small">
              <label for="items">Items Shown:</label>
              <input type="text" name="items" id="items" value="" maxlength="2" />
            </p>
            
            
            <script type="text/javascript">
                (function(){
                 
                  $('.datepicker').datetimepicker({
                    inline: true,
                    showButtonPanel: true,
                    ampm: true,
                    minDate: '+0'
                  });
                })();
            </script>
        </div>
        <div class="clear"></div>

      </form>
  </div>
</div>

<div class="clear"></div>


<?php 
  global $connection;
  $sql = "SELECT COUNT(quiz_title) as num_quiz from quiz";
  confirm_query($sql);
  $resultset = mysql_query($sql,$connection);
  while ($row = mysql_fetch_array($resultset)) {
      $count = $row['0'];
  }

  if(!$count==0){
?>
<div class="box" id="show-quizzes">
  <div class="box-header">
    <h1>All Quizzes</h1>
    <div class="handler"><img src="img/tip_bg.png" alt="" title="Click to toggle"></div>
    <div class="clear"></div>
  </div>
  
  <div class="box-content">
          <p class="large">
            <table class="datatable">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Exp. Date</th>
                  <th>Visible Items</th>
                  <th>Time Limit</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php global $connection;
                      $count = 0;
                      $query = "SELECT * from quiz ";
                      confirm_query($query);
                      $result = mysql_query($query,$connection);
                      while($row = mysql_fetch_array($result)){ 
                        ?>
                        <tr class="item">
                        <td><?php $merge_title = $row['quiz_title'] . " | ".$row['quiz_description'];  echo substr($merge_title, 0,35)?></td>
                        <td><?php echo $row['quiz_datelimit']; ?></td>
                         <td><?php echo $row['quiz_shown_items']; ?></td>
                        <td><?php echo $row['quiz_timelimit'] . " Minutes" ?></td>
                        <td>
                          <a href="content.php?page=edit-quiz&quiz_id=<?php echo $row['quiz_id']; ?>" class="button plain"><span class="glyph pencil"></span>Edit</a>
                          <a href="content.php?page=quiz-items&title=<?php echo $row['quiz_title']; ?>" class="button plain"><span class="glyph note"></span>View Items</a>
                          <a href="delete-quiz.php?page=quiz&quiz_id=<?php echo $row['quiz_id']; ?>" class="button plain delete"><span class="glyph trash"></span>Delete</a>
                          <a href="content.php?page=simulate-quiz&quiz_id=<?php echo $row['quiz_id']; ?>" class="button plain"><span class="glyph listicon"></span>Simulate</a>
                        </td>
                        </tr>
                 <?php } ?>
              </tbody>   
            </table> 
          </p>
        <div class="clear"></div>
  </div>
</div>
<?php } ?>
  <div class="clear"></div>
<?php if(isset($_GET['title'])) {?>
<div class="box">
  <div class="box-header">
    <h1>All Quiz Items in <?php echo $_GET['title'];?> | <?php echo get_quiz_desc_by_title($_GET['title']);?></h1>
    <div class="handler"><img src="img/tip_bg.png" alt="" title="Click to toggle"></div>
    <div class="clear"></div>
  </div>
  
  <div class="box-content">
          <p class="large">
            <table class="datatable">
              <thead>
                <tr>
                  <th>Number</th>
                  <th>Question</th>
                  <th>Type</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php global $connection;
                      $count = 0;
                      $quiz_id =  get_quiz_id_by_title($_GET['title']);
                      $query = "SELECT * from questions where quiz_id = '$quiz_id'";
                      confirm_query($query);
                      $result = mysql_query($query,$connection);
                      while($row = mysql_fetch_array($result)){ 
                            $type = $row['questions_type'];
                        ?>
                        <tr class="item">
                        <td><?php echo ++$count; ?></td>
                        <td><?php echo substr($row['questions_question'], 0,110) . "..."; ?></td>
                        <td><?php if($type == 'mc') echo "Multiple Choice";
                                  if($type == 'tf') echo "True or False";
                                  if($type == 'identification') echo "Identification";
                            ?>
                        </td>
                        <td>
                         <a href="content.php?page=edit-question&quest_id=<?php echo $row['questions_id'];?>" class="button plain"><span class="glyph pencil"></span>Edit</a>
                          <a href="delete-question.php?page=quiz-items&quest_id=<?php echo $row['questions_id'];?>" class="button plain delete"><span class="glyph trash"></span>Delete</a>
                        </td>
                        </tr>
                 <?php } ?>
              </tbody>   
            </table> 
          </p>
        <div class="clear"></div>
  </div>
</div>
<?php } ?>


<div class="box" id="box-question">
  <div class="box-header">
    <h1>Questions</h1>
    <div class="handler"><img src="img/tip_bg.png" alt="" title="Click to toggle"></div>
    <div class="clear"></div>
  </div>
  
  <div class="box-content">
          <div class="column-left" style="border: none;">
            <p>
              <label for="type">Question Type:</label>
              <select name="q-type" class="select-type" style="width: 240px;">
                <option></option>
                <option value="choice">Multiple Choice</option>
                <option value="truefalse" >True or False</option>
                <option value="identification">Identification</option>
              </select>
            </p>
          </div>

          <div class="clear"></div>
          <br>
          <br>

          <div class="multiple-choice">
              <form action="add-quiz.php" method="post" id="form-mc">
              <h6>Type your question below:</h6>
              <p>
                  <textarea  id="wysiwyg" class="wysiwyg" name="input" style="height: 300px;"></textarea>
              </p>
              <input type="hidden" name="q_type" class="q_type" value="mc" />
              <br/>
              <h6>Responses:</h6>
              <p class="large choice">
                <textarea name="a" class="taginput choiz" style="height: 100px;"></textarea>
                <span class="letter">A</span>
              </p>
              <p class="large choice">
                <textarea  name="b" class="taginput choiz" style="height: 100px;"></textarea>
                <span class="letter">B</span>
              </p>
              <p class="small correct-ans">
                <input type="text" name="correct" id="correct" value="" />
              </p>
              <p class="buttons" style="margin-top: 30px;">
                <a href="#" class="button blue response"><span class="glyph plus"></span>Add Response</a>
                  <input type="submit" class="button" id="mc-add" value="Add and Save">
              </p>
              </form>
            <div class="clear"></div>
        </div>

        <div class="true-false">
              <form action="add-quiz.php" method="post" id="form-tf">
              <h6>Type your question below:</h6>
              <p>
                  <textarea  id="wysiwyg-tf" class="wysiwyg" name="tf-question-area" style="height: 150px;"></textarea>
              </p>
              <input type="hidden" name="q_type" class="q_type" value="tf" />
              <br/>
              <h6>Responses:</h6>
              <p class="large">
                <select name="correct-tf" id="correct-tf" style="width: 200px;">
                  <option value="true">True</option>
                  <option value="false">False</option>
                </select>
              </p>
              
              <p style="margin-top: 30px;">
                  <input type="submit" class="button" id="tf-add" value="Add and Save">
              </p>
              </form>
            <div class="clear"></div>
        </div>

        <div class="identification">
              <form action="add-quiz.php" method="post" id="form-ident">
              <h6>Type your question below:</h6>
              <p>
                  <textarea  id="wysiwyg-ident" class="wysiwyg" name="input" style="height: 150px;"></textarea>
              </p>
              <input type="hidden" name="q_type" class="q_type" value="identification" />
              <br/>
              <h6>Responses:</h6>
              <p class="medium">
                <textarea name="correct-ident" id="correct-ident" class="taginput" style="height: 50px;"></textarea>
              </p>
              
              <p style="margin-top: 30px;">
                  <input type="submit" class="button" id="ident-add" value="Add and Save">
              </p>
              </form>
            <div class="clear"></div>
        </div>
  </div>
</div>

<!--For Architecture Effects -->
<?php if(isset($_GET['quest_id'])) { ?> <?php // Execute after you create a first question in the quiz ?>

<script type="text/javascript">
  (function(){
    $('#info').hide();
    var value = $('select#question-type').val() ,
    truefalse = $('div.true-false') ,
    identification = $('div.identification') ,
    choice = $('div.multiple-choice'),
    box = $('#box-question');

    truefalse.hide();identification.hide(); 
    box.slideDown();
    $('#show-quizzes').hide();
    $('#form-mc').attr('action','add-question.php');
    $('#form-tf').attr('action','add-question.php');
    $('#form-ident').attr('action','add-question.php');
  })();

  (function(){
    $('#mc-add').click(function(event){
      event.preventDefault();
      var target = $('#form-mc').attr('action');
      var elems = $('#form-mc textarea.choiz'); // returns a nodeList
      var arr = jQuery.makeArray(elems);
      var responses="";
      jQuery.each(arr, function() {
          var data = this.value;
          if(!responses == ""){
          responses = responses + "#" + data;
          }else{
            responses = data;
          }
      });
      var location = window.location;
      var mc_data = {
          title : "<?php echo $_GET['title'] ?>",
          question : $('#form-mc #wysiwyg').val(),
          answers : responses,
          correct : $('#form-mc #correct').val(),
          qtype : $('#form-mc .q_type').val()
          }
          $.ajax({
              type: "POST",
              url: target,
              data: mc_data,
              success: function(response){
                if(response == 'success'){
                  location.href = "content.php?page=quiz-items&title=<?php echo $_GET['title']; ?>";
                }
                else{
                  alert('Not Save!');
                }
              }
            });
            return false;
    })
  })();

  (function(){
    $('#tf-add').click(function(event){
      event.preventDefault();
      var target = $('#form-tf').attr('action');
      var location = window.location;
      var tf_data = {
          title : "<?php echo $_GET['title'] ?>",
          question : $('#form-tf #wysiwyg-tf').val(),
          correct : $('#form-tf #correct-tf').val(),
          qtype : $('#form-tf .q_type').val()
          }
          $.ajax({
              type: "POST",
              url: target,
              data: tf_data,
              success: function(response){
                if(response == 'success'){
                  location.href = "content.php?page=quiz-items&title=<?php echo $_GET['title']; ?>";
                }
                else{
                  alert('Not Save!');
                }
              }
            });
            return false;
    })
  })();

  (function(){
    $('#ident-add').click(function(event){
      event.preventDefault();
      var target = $('#form-ident').attr('action');
      var location = window.location;
      var ident_data = {
          title : "<?php echo $_GET['title'] ?>",
          question : $('#form-ident #wysiwyg-ident').val(),
          correct : $('#form-ident #correct-ident').val(),
          qtype : $('#form-ident .q_type').val()
          }
          $.ajax({
              type: "POST",
              url: target,
              data: ident_data,
              success: function(response){
                if(response == 'success'){
                  location.href = "content.php?page=quiz-items&title=<?php echo $_GET['title']; ?>";
                }
                else{
                  alert('Not Save!');
                }
              }
            });
            return false;
    })
  })();

</script>

<?php  }else{ ?> <?php // First Execution ?>

<script type="text/javascript">
  (function(){
    $('#box-question').hide();
  })();

  (function(){
  $('#add-question').on('click', function(event){
      event.preventDefault();

      var value = $('select#question-type').val() ,
      truefalse = $('div.true-false') ,
      identification = $('div.identification') ,
      choice = $('div.multiple-choice'),
      box = $('#box-question');
      var sg = $('select#quiz-groups').val();
      var $title = $('#title').val();
      var $time = $('#time').val();
      var $items = $('#items').val();
      var $datepicker = $('#datepicker').val();
      var txt = Array('title','time','file' , 'items' , 'datepicker' , 'quiz-publish');
      var result = true;

      for(var i=0;i<txt.length;i++){if(!validateString(txt[i])){result = false;}}

          if(sg==null){
            MessageDialog("#dialog-message");
          }
          else if(value==='choice' && result){
            truefalse.hide();identification.hide(); 
            $('#info').slideUp(600);box.slideDown();
            $('#show-quizzes').fadeOut();
          }
          else if(value=='truefalse' && result){
            choice.hide();identification.hide();
            $('#info').slideUp(600);box.slideDown(); 
            $('#show-quizzes').fadeOut();   
          }
          else if(value=='identify' && result){
            choice.hide();truefalse.hide();
            $('#info').slideUp(600);box.slideDown();
            $('#show-quizzes').fadeOut();
          }
          else{ MessageDialog("#dialog-message") }
    })
  })();

  (function(){
    $('#mc-add').click(function(event){
      event.preventDefault();
      var title = $('#title').val();
      var target = $('#form-mc').attr('action');
      var elems = $('#form-mc textarea.choiz'); // returns a nodeList
      var arr = jQuery.makeArray(elems);
      var responses="";
      jQuery.each(arr, function() {
          var data = this.value;
          if(!responses == ""){
          responses = responses + "#" + data;
          }else{
            responses = data;
          }
      });
      var location = window.location;
      var mc_data = {
          title : $('#title').val(),
          file  : $('#file').val(),
          time  : $('#time').val(),
          items : $('#items').val(),
          datepicker : $('#datepicker').val(),
          question : $('#form-mc #wysiwyg').val(),
          answers : responses,
          correct : $('#form-mc #correct').val(),
          qtype : $('#form-mc .q_type').val(),
          qgroups : $('#quiz-groups').val(),
          qpublish : $('#quiz-publish').val()
          }
          $.ajax({
              type: "POST",
              url: target,
              data: mc_data,
              success: function(response){
                if(response == 'success'){
                  location.href = "content.php?page=quiz-items&title="+title;
                }
                else{
                  alert('Not Save!');
                }
              }
            });
            return false;
    })
  })();

  (function(){
    $('#tf-add').click(function(event){
      event.preventDefault();
      var title = $('#title').val();
      var target = $('#form-tf').attr('action');
      var location = window.location;
      var tf_data = {
          title : $('#title').val(),
          file  : $('#file').val(),
          time  : $('#time').val(),
          question : $('#form-tf #wysiwyg-tf').val(),
          correct : $('#form-tf #correct-tf').val(),
          qtype : $('#form-tf .q_type').val(),
          qgroups : $('#quiz-groups').val(),
          qpublish : $('#quiz-publish').val()
          }
          $.ajax({
              type: "POST",
              url: target,
              data: tf_data,
              success: function(response){
                if(response == 'success'){
                  location.href = "content.php?page=quiz-items&title="+title;
                }
                else{
                  alert('Not Save!');
                }
              }
            });
            return false;
    })
  })();

  (function(){
    $('#ident-add').click(function(event){
      event.preventDefault();
      var title = $('#title').val();
      var target = $('#form-ident').attr('action');
      var location = window.location;
      var ident_data = {
          title : $('#title').val(),
          file  : $('#file').val(),
          time  : $('#time').val(),
          question : $('#form-ident #wysiwyg-ident').val(),
          correct : $('#form-ident #correct-ident').val(),
          qtype : $('#form-ident .q_type').val(),
          qgroups : $('#quiz-groups').val(),
          qpublish : $('#quiz-publish').val()
          }
          $.ajax({
              type: "POST",
              url: target,
              data: ident_data,
              success: function(response){
                if(response == 'success'){
                  location.href = "content.php?page=quiz-items&title="+title;
                }
                else{
                  alert('Not Save!');
                }
              }
            });
            return false;
    })
  })();
  </script>

<?php } ?>

<script type="text/javascript">

  (function(){
    var count = 1;
    $('a.response').on('click',function(){   
      var cloned = $('p.choice').last().clone();
      var children = cloned.children();
      var ascii_int = parseInt(children.attr('name').charCodeAt()) + count;
      var ascii_char = String.fromCharCode(ascii_int);
      var textarea = children.first().attr('name', ascii_char);
      var gen_quest = "<p class=\"large choice\">";
      var gen_quest = gen_quest + "<textarea name=\"" + ascii_char + "\" class=\"choiz\" style=\"height: 100px;\"></textarea>";
      var gen_quest = gen_quest + "<span class=\"letter\">" +ascii_char+"</span></p>";
      $('.correct-ans').before(gen_quest);
      
    });
  })();

  (function(){
    $(".select-type").change(function() {
      var value = $(this).val();
      var mc = $('.multiple-choice');
      var tf = $('.true-false');
      var ident = $('.identification');

      if(value==='choice'){
        tf.fadeOut('slow');
        ident.fadeOut('slow');
        mc.fadeIn('slow');
      }else if(value==='truefalse'){
        mc.fadeOut('slow');
        ident.fadeOut('slow');
        tf.fadeIn('slow');
      }else{
        mc.fadeOut('slow');
        tf.fadeOut('slow');
        ident.fadeIn('slow');
      }
      // display based on the value
    });
  })();

  function NumberFieldCheck(id){
      $(id).keypress(function(event){
            if(isNumberKey(event)){
              if(!isBackspace(event)){
                return true;
                }
              }
            else{
              return false;
              }
            }
      );
  }

  NumberFieldCheck('#time');
  NumberFieldCheck('#items');

 function MessageDialog(id) {
    $( id ).dialog( "destroy" );

    $( id ).dialog({
      modal: true,
      buttons: {
        Ok: function() {
          $( this ).dialog( "close" );
        }
      }
    });
  }

</script>
