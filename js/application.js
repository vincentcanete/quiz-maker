$('document').ready(function() {
  
  /******************
    Tablet rotation
  ******************/
  
  var isiPad = navigator.userAgent.match(/iPad/i) !== null;
  
  if(isiPad) {
    $('body').prepend('<div id="rotatedevice"><h1>Please rotate your device 90 degrees.</div>');
  }
  
  
  /********************
    Modal preparation
  ********************/
  
  $('body').prepend('<div id="overlay"><div id="modalcontainer"></div></div>');
  
  
  /****************
    Notifications
  ****************/

  var maxHeight = $(window).height() - $('#secondary ul').height() - 50;
  $('#notifications').css({'max-height': maxHeight});
  
  $('#notifications ul li').livequery(function() {
    $('#notifications').fadeIn();
  });
  
  $('#notifications').prepend('<a href="#">Show all notifications</a>');
  
  $('#notifications > a').click(function() {
    var container = $('#notifications');
    var height = $('#notifications ul').height() + 24;
    
    if(container.hasClass('expanded')) {
      container.animate({'height': 42}, 200);
      container.removeClass('expanded');
      $(this).html('show all notifications');
    } else {
      container.animate({'height': height}, 200);
      container.addClass('expanded');
      $(this).html('hide notifications');
    }
    
    return false;
  });
  
  function init() {
    
    /**************************
      Obtrusive notifications
    **************************/
    
    $('.notification .close').click(function() {
      $(this).closest('.notification').animate({'opacity': 0.01}, 200, function() {
        $(this).slideUp(200);
      });
    });
    
    
    /************
      Code view
    ************/
  
    $('code').each(function() {
      var elem = $(this);
      var lang = elem.attr("class");
    
      elem.sourcerer(lang);
    });
  
    /*************
      Datatables
    *************/
  
    $('.datatable').dataTable({
      "sPaginationType": "full_numbers",
      "bStateSave": true
    });
    
    $('.dataTables_wrapper').each(function() {
      var table = $(this);
      var info = table.find('.dataTables_info');
      var paginate = table.find('.dataTables_paginate');
    
      table.find('.datatable').after('<div class="action_bar nomargin"></div>');
      table.find('.action_bar').prepend(info).append(paginate);
    });

    
    /************************
      Combined input fields
    ************************/
    
    $('div.combined p:last-child').addClass('last-child');
  
    /**********
      Sliders
    **********/
  
    $(".slider").each(function() {
      var options = $(this).metadata();
      $(this).slider(options, {
        animate: true
      });
    });
  
    $(".slider-vertical").each(function() {
      var options = $(this).metadata();
      $(this).slider(options, {
        animate: true
      });
    });
  
  
    /****************
      Progress bars
    ****************/
  
    $(".progressbar").each(function() {
      var options = $(this).metadata();
      $(this).progressbar(options);
    });
  
    /**********************
      Modal functionality
    **********************/
  
    $('a.modal').each(function() {
      var link = $(this);
      var id = link.attr('href');
      var target = $(id);
      
      if($("#modalcontainer " + id).length === 0) {
        $("#modalcontainer").append(target);
      }
      
      $("#main " + id).remove();
    
      link.click(function() {
        $('#modalcontainer > div').hide();
        target.show();
        $('#overlay').show();
        return false;
      });
    });
  
    $('.close').click(function() {
      $('#modalcontainer > div').hide();
      $('#overlay').hide();
    
      return false;
    });
    
    /***********************
      Secondary navigation
    ***********************/
    
    $('div#secondary > ul > li > a').click(function() {
      $('div#secondary li').removeClass('active');
      $(this).parent().addClass('active');
    });
  
    /********************
      Pretty checkboxes
    ********************/
  
    $('input[type=checkbox], input[type=radio]').each(function() {
      if($(this).siblings('label').length > 0) {
        $(this).prettyCheckboxes();
      }
    });
  
    /**********************
      Pretty select boxes
    **********************/
  
    $('select').chosen();
  
    /******************
      Window resizing
    ******************/

    $(window).resize(function() {
      $('.chzn-container').each(function(){
        $(".chzn-container").css({'width': '100%'});
        var res_wid_drop = ($(".chzn-container").width() - 2);
        $(".chzn-drop").css({'width': res_wid_drop});
      });
    });

    /*********************
      Pretty file inputs
    *********************/

    $('input[type="file"]').customFileInput();
    
    /*******
      Tabs
    *******/
  
    // Hide all .tab-content divs
    $('.tab-content').livequery(function() {
      $(this).hide();
    });

    // Show all active tabs
    $('.box-header ul li.active a').livequery(function() {
      var target = $(this).attr('href');
      $(target).show();
    });
  
    // Add click eventhandler
    $('.box-header ul li').livequery(function() {
      $(this).click(function() {
        var item = $(this);
        var target = item.find('a').attr('href');
        
        if($(target).parent('form').length > 0) {
          if($(target).parent('form').valid()) {
            item.siblings().removeClass('active');
            item.addClass('active');
    
            item.parents('.box').find('.tab-content').hide();
            $(target).show();
          }
        } else {
          item.siblings().removeClass('active');
          item.addClass('active');
    
          item.parents('.box').find('.tab-content').hide();
          $(target).show();
        }

        // Needed for Chosen plugin resizing
        $(window).trigger('resize');
    
        return false;
      });
    });
    
    /***********
      Tooltips
    ***********/
    
    $('.tooltip').tipsy({gravity: 's'});
    
    // Calendar icon fix
    $('form p > .error').livequery(function() {
      $(this).siblings('span.calendar').hide();
    });
  
  }
  
  init();

});

/*************************
  Notification function!
*************************/

function notification(message, error, icon, image) {
  if(icon === null) {
    icon = 'tick2';
  }
  
  if(image) {
    image = 'icon16';
  } else {
    image = 'glyph';
  }
  
  var now = new Date();
  var hours = now.getHours();
  var minutes = now.getMinutes();
    
  if (hours < 10) {
    hours = "0" + hours;
  }
  
  if (minutes < 10) {
    minutes = "0" + minutes;
  }
  
  var time = hours + ':' + minutes;
  
  if(error) {
    $('#notifications ul').append('<li class="error"><span class="' + image + ' cross"></span> ' + message + ' <span class="time">' + time + '</span></li>');
  } else {
    $('#notifications ul').append('<li><span class="' + image + ' ' + icon + '"></span> ' + message + ' <span class="time">' + time + '</span></li>');
  }
  
  $('#notifications ul li:last-child').hide();
  $('#notifications ul li:last-child').slideDown(200);
}