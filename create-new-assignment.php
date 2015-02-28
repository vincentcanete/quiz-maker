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
    <h1>Add New Assignment</h1>
    <div class="handler"><img src="img/tip_bg.png" alt="" title="Click to toggle"></div>
    <div class="clear"></div>
  </div>
  
  <div class="box-content">
          <form method="post" action="add-assignment.php" id="assignment-form" enctype="multipart/form-data">
              <p>
               <input type="text" name="assign-title"  id="assign-title" value="" placeholder="Assignment Title"/>
              </p>
              <p>
                  <textarea  id="assign-content" class="wysiwyg" name="assign-content" style="height: 300px;"></textarea>
              </p>

              <div class="column-left">
                <p>
                  <label for="file">Upload File: </label>
                  <input type="file" id="file" name="file" placeholder="Upload File"/>
                </p>
                <p>
                  <label for="groups" style="display: block">Select Groups: </label>
                  <select multiple="multiple" name="assign-groups[]" style="width:100%">
                    <?php 
                        $group_ids = get_groups_id();
                        foreach ($group_ids as $group_id ):
                        $group_name = get_groups_name($group_id); ?>
                        <option value="<?php echo $group_id; ?>"><?php echo $group_name; ?></option>
                    <?php endforeach ?>
                  </select>
                </p>
                <p class="small">
                  <label for="assign-points">Points:</label>
                  <input type="text" id="assign-points" name="assign-points" value=""/>
                </p>
              </div>
              <div class="column-right">
                <p>
                  <label for="assign-publish">Publish on: </label>
                  <input type="text" name="assign-publish" class="datepicker" id="assign-publish">
                </p>
                <p>
                  <label for="assign-deadline">Deadline: </label>
                  <input type="text" name="assign-deadline" class="datepicker" id="assign-deadline">
                </p>
              </div>
              <div class="clear"></div>
              <br>
              <br>
              <p>
                <input type="submit" class="button"  name="submit" id="add-assignment" value="Publish">
                <input type="reset" class="button"  name="reset" id="reset" value="Clear" style="display:none">
              </p>
                            
              <script type="text/javascript">
                  (function(){
                    $('.datepicker').datetimepicker({
                      inline: true,
                      showButtonPanel: true,
                      ampm: true,
                      minDate: '+0'
                    });

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
                          });
                    }

                    NumberFieldCheck('#points');
                  })();


              </script>
          </form>
          
        <div class="clear"></div>
  </div>
</div>