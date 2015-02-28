<?php
    require_once dirname(__FILE__) . '/inc/session.php';
    require_once dirname(__FILE__) . '/inc/connection.php';
    require_once dirname(__FILE__) . '/inc/functions.php';
    confirm_logged_in();
?>
<div class="box">
  <div class="box-header">
    <div class="handler"><img src="img/tip_bg.png" alt="" title="Click to toggle"></div>
    <div class="clear"></div>
  </div>
    <div id="calendar"></div>
</div>
<script type="text/javascript">
	$('#calendar').fullCalendar({
      events: [{
                title  : 'System Checking',
                start  : '2012-08-15'
              },
              {
                title  : 'Defense Week',
                start  : '2012-08-20',
                end    : '2012-08-24',
              },
              {
                title  : 'Defense Namo',
                start  : '2012-08-21 9:30:00',
                allDay  : false,
              },
              {
                title  : 'Dapat Mahuman Na Ang System',
                start  : '2012-08-19 12:30:00',
                allDay : false
              }],
      editable: true,
      selectable: true,
      eventBackgroundColor: '#477dae',
      eventBorderColor: '#0E69A1',
      header: {
        left: '',
        center: 'title',
        right: 'prev,today,next month,basicWeek,basicDay'
      },
      buttonText: {
        prev: '<span class="glyph left"></span>',
        next: '<span class="glyph right"></span>'
      },
      aspectRatio: 2
    });

</script>