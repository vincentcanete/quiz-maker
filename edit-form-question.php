<?php
    require_once dirname(__FILE__) . '/inc/session.php';
    require_once dirname(__FILE__) . '/inc/connection.php';
    require_once dirname(__FILE__) . '/inc/functions.php';
    confirm_logged_in();
    date_default_timezone_set('UTC');
    $date = date('F-j-Y-g:i:s:');

    $quest_attr = get_question_attr_by_id($_GET['quest_id']); 
    $answer_attr = get_answer_attr_by_quest_id($_GET['quest_id']);
    $title = get_the_title_by_id($quest_attr['0']);
?>
<div class="quick-actions">
  <a href="content.php?page=quiz-items&title=<?php echo $title ?>">
    <span class="glyph left"></span>
    Back to Items
  </a>
</div>
<div class="box" id="box-question">
  <div class="box-header">
    <h1>Edit Existing Question</h1>
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
              <form action="update-question-process.php" method="post" id="form-mc">
              <h6>Type your question below:</h6>
              <p>
                  <textarea  id="wysiwyg" class="wysiwyg" name="input" style="height: 150px;"><?php if($quest_attr['2']=='mc'){ echo $quest_attr['1']; }?></textarea>
              </p>
              <input type="hidden" name="q_type" class="q_type" value="mc" />
              <br/>
              <h6>Responses:</h6>
              <?php 
                $answers_fn = $answer_attr['1'];
                $answers_fn = explode('#', $answers_fn);
                $answers = array();
                $ctr=0;
                foreach($answers_fn as $answer_fn){
                  if($answer_fn != "" || $answer_fn != null || !empty($answer_fn)){
                    $answers[$ctr++] = $answer_fn;
                  }
                }

                $count = 0;
                $letters = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
                foreach ($answers as $answer) {
                  $count;
              ?>
              <p class="large choice">
                <textarea name="<?php echo $letters[$count]; ?>" class="taginput choiz" style="height: 100px;"><?php if($quest_attr['2']=='mc'){ echo $answer; } ?></textarea>
                <span class="letter"><?php echo $letters[$count]; ?></span>
              </p>

              <?php $count++; } ?>

              <p class="small correct-ans">
                <input type="text" name="correct" id="correct" value="<?php if($quest_attr['2']=='mc'){ echo $answer_attr['2']; }?>" />
              </p>
              <p class="buttons" style="margin-top: 30px;">
                <a href="#" class="button response"><span class="glyph plus"></span>Add Response</a>
                  <input type="submit" class="button" id="update-question-mc" value="Update Question">
              </p>
              </form>
            <div class="clear"></div>
        </div>

        <div class="true-false">
              <form action="update-question-process.php" method="post" id="form-tf">
              <h6>Type your question below:</h6>
              <p>
                  <textarea  id="wysiwyg-tf" class="wysiwyg" name="input" style="height: 150px;"><?php if($quest_attr['2']=='tf'){ echo $quest_attr['1']; }?></textarea>
              </p>
              <input type="hidden" name="q_type" class="q_type" value="tf" />
              <br/>
              <h6>Responses:</h6>
              <p class="large">
                <select name="correct-tf" id="correct-tf" style="width: 200px;">
                  <?php if($quest_attr['2']=='tf'){ 
                            if($answer_attr['2'] == 'true'){ ?>
                              <option value="true" selected="selected">True</option>
                              <option value="false">False</option>
                  <?php     }else{ ?>
                              <option value="true">True</option>
                              <option value="false" selected="selected">False</option>
                  <?php     }   
                        } 
                  ?>
                </select>
              </p>
              
              <p style="margin-top: 30px;">
                  <input type="submit" class="button" id="update-question-tf" value="Update Question">
              </p>
              </form>
            <div class="clear"></div>
        </div>

        <div class="identification">
              <form action="update-question-process.php" method="post" id="form-ident">
              <h6>Type your question below:</h6>
              <p>
                  <textarea  id="wysiwyg-ident" class="wysiwyg" name="input" style="height: 150px;"><?php if($quest_attr['2']=='identification'){ echo $quest_attr['1']; }?></textarea>
              </p>
              <input type="hidden" name="q_type" class="q_type" value="identification" />
              <br/>
              <h6>Responses:</h6>
              <p class="medium">
                <textarea name="correct-ident" id="correct-ident" class="taginput" style="height: 50px;"><?php if($quest_attr['2']=='identification'){ echo $answer_attr['2']; }?></textarea>
              </p>
              
              <p style="margin-top: 30px;">
                  <input type="submit" class="button" id="update-question-ident" value="Update Question">
              </p>
              </form>
            <div class="clear"></div>
        </div>
  </div>
</div>

<!--For Architecture Effects -->

<script type="text/javascript">
  (function(){
    $('#info').hide();
    
    box = $('#box-question');
    box.slideDown();

    var mc = $('.multiple-choice');
    var tf = $('.true-false');
    var ident = $('.identification');

    <?php if($quest_attr['2']=='mc'){ ?>

        tf.hide();
        ident.hide();
        mc.show();

    <?php } ?>
    <?php if($quest_attr['2']=='tf'){ ?>

        mc.hide();
        ident.hide();
        tf.show();

    <?php } ?>
    <?php if($quest_attr['2']=='identification'){ ?>

        mc.hide();
        tf.hide();
        ident.show();

    <?php } ?>
  })();

  (function(){
    $('#update-question-mc').click(function(event){
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
          quest_id : "<?php echo $_GET['quest_id'] ?>",
          title : "<?php echo $title ?>",
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
                  location.href = "content.php?page=quiz-items&title=<?php echo $title ?>";
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
    $('#update-question-tf').click(function(event){
      event.preventDefault();
      var target = $('#form-tf').attr('action');
      var location = window.location;
      var tf_data = {
          quest_id : "<?php echo $_GET['quest_id'] ?>",
          title : "<?php echo $title ?>",
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
                  location.href = "content.php?page=quiz-items&title=<?php echo $title ?>";
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
    $('#update-question-ident').click(function(event){
      event.preventDefault();
      var target = $('#form-ident').attr('action');
      var location = window.location;
      var ident_data = {
          quest_id : "<?php echo $_GET['quest_id'] ?>",
          title : "<?php echo $title ?>",
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
                  location.href = "content.php?page=quiz-items&title=<?php echo $title ?>";
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


</script>
