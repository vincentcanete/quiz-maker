<?php if(isset($_GET['msg']) && $_GET['msg'] == 'success') : ?>
<div class="notification success">
  <span class="icon"></span>
  Assignment Successfully Added
  <a href="#" class="close">x</a>
</div>
<?php endif; ?>

<?php if(isset($_GET['msg']) && $_GET['msg']== 'error') : ?>
<div class="notification error">
  <span class="icon"></span>
  Error!
  <a href="#" class="close">x</a>
</div>
<?php endif; ?>

<div class="box" id="show-quizzes">
  <div class="box-header">
    <h1>SMS Messaging</h1>
    <div class="handler"><img src="img/tip_bg.png" alt="" title="Click to toggle"></div>
    <div class="clear"></div>
  </div>
  
  <div class="box-content">
          <form method="post" action="send-sms.php">
              <p>
                  <textarea  name="message" id="msg" style="height: 100px;"></textarea>
              </p>
              <p  id="counter"></p>

                <p>
                  <input type="radio" name="user" id="group" value="group">
                  <label for="group">By Group</label>
                  <input type="radio" name="user" id="single" value="single">
                  <label for="single">By User</label>
                </p>

                <p class="medium" id="us" style="display: none">
                  <label for="groups" style="display: block">Select User: </label>
                  <?php get_all_users(); ?>
                </p>
                
                <p class="medium" id="gr" style="display: none">
                  <label for="groups" style="display: block">Select Groups: </label>
                  <select multiple="multiple" name="groups[]" style="width:400px">
                    <?php 
                        $group_ids = get_groups_id();
                        foreach ($group_ids as $group_id ):
                        $group_name = get_groups_name($group_id); ?>
                        <option value="<?php echo $group_id; ?>"><?php echo $group_name; ?></option>
                    <?php endforeach ?>
                  </select>
                </p>

                <p>
                  <input type="submit" class="button"  name="submit"  value="Send Message" />
                </p>
       
          </form>
        <div class="clear"></div>
  </div>
</div>
<script  type="text/javascript" src="js/jquery.limit.js"></script>
<style>
.alert{
    color: red;
}
</style>
<script type="text/javascript">
 
$(document).ready(function() {
    $("#msg").limita({
      limit: 160,
      id_result: "counter",
      alertClass: "alert"
    });


    $("input[type=radio]") // select the radio by its id
    .change(function(){ // bind a function to the change event
        if( $(this).is(":checked") ){ // check if the radio is checked
            var val = $(this).val(); // retrieve the value
            if(val == "group"){
              $('#gr').show();
              $('#us').hide();
            }else{
              $('#us').show();
              $('#gr').hide();
            }
        }
    });
});

</script>