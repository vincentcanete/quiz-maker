  <script type="text/javascript">
      $(function() {

        $('div.handler img').click(function(){
          var body$ = $(this).closest('div.box').find('div.box-content');
          if (body$.is(':hidden')) {
            body$.show();
          }
          else {
            body$.hide();
          }
        });

      });

      (function(){
        var box = $('div.box-content');
          box.first().slideDown(500, function(){
            box.slideDown(500);
          });
      })();
    </script>
  </body>
<meta http-equiv="content-type" content="text/html;charset=utf-8">
</html>
