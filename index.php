<?php
include_once 'src/functions.php';
include_once 'src/psl-config.php';

session_start();

if (isset($_SESSION['username']) > "") {
        header('Location: landing_page.php');
        exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hubnest Contact Manager</title>
    <link rel="stylesheet" type="text/css" href="style/style-login.css">
    <script type="text/JavaScript" src="src/js/sha512.js"></script>
    <script type="text/JavaScript" src="src/js/forms.js"></script>
</head>
<body>
    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="loginmodal-container">
                <h1>Hubnest Project</h1><br>
                <form id="login-form" action="src/process_login.php" method="post" name="login_form">
                    <input type="text" name="user" placeholder="Username">
                    <input type="password" name="pass" placeholder="Password">
                    <input type="submit" name="login" onclick="formhash(this.form, this.form.pass);" class="login loginmodal-submit" value="Login">
                </form>
            </div>
        </div>
    </div>
</body>
<script>
       function checkSubmit(e)
       {
          if(e && e.keyCode == 13)
          {
              formhash(document.getElementById("login-form"), document.getElementById("login-form").pass);
             document.getElementById("login-form").submit();
          }
       }
</script>
</html>
