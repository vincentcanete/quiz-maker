    <link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>

    <!-- elFinder CSS (REQUIRED) -->
    <link rel="stylesheet" type="text/css" media="screen" href="css/elfinder.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/theme.css">

    <!-- elFinder JS (REQUIRED) -->
    <script type="text/javascript" src="js/elfinder.min.js"></script>

    <!-- elFinder translation (OPTIONAL) -->
    <script type="text/javascript" src="js/i18n/elfinder.ru.js"></script>

    <!-- elFinder initialization (REQUIRED) -->
    <script type="text/javascript" charset="utf-8">
      $().ready(function() {
        var elf = $('#elfinder').elfinder({
          url : 'php/connector.php'  // connector URL (REQUIRED)
          // lang: 'ru',             // language (OPTIONAL)
        }).elfinder('instance');
      });
    </script>

<div class="box">
  <div class="box-header">
    <h1>File Manager</h1>
    <div class="handler"><img src="img/tip_bg.png" alt="" title="Click to toggle"></div>
    <div class="clear"></div>
  </div>
  
  <div class="box-content">
         
    <div id="elfinder"></div>

  </div>
</div>