<html>
  <head>
    <title>Subscribe to Newsletter</title>
    <script
      src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
 
    <script src="https://www.google.com/recaptcha/api.js?render=6LdikMUUAAAAAJKk59iVnjk_38CSCn4UxqdrW59Z"></script>
  </head>
  <body>
    <div>
      <b>Subscribe Newsletter</b>
    </div>
 
    <form id="newsletterForm" action="subscribe_newsletter_submit.php" method="post">
      <div>
          <div>
              <input type="email" id="email" name="email">
          </div>
          <div>
              <input type="submit" value="submit">
          </div>
      </div>
    </form>
 
    <script>
    $('#newsletterForm').submit(function(event) {
        event.preventDefault();
        var email = $('#email').val();
 
        grecaptcha.ready(function() {
            grecaptcha.execute('6LdikMUUAAAAAJKk59iVnjk_38CSCn4UxqdrW59Z', {action: 'subscribe_newsletter'}).then(function(token) {
                $('#newsletterForm').prepend('<input type="hidden" name="token" value="' + token + '">');
                $('#newsletterForm').prepend('<input type="hidden" name="action" value="subscribe_newsletter">');
                $('#newsletterForm').unbind('submit').submit();
            });;
        });
  });
  </script>
  </body>
</html>