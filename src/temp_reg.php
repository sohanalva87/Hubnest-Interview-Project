<?php

include_once 'functions.php';
include_once 'psl-config.php';

if (isset($_POST['username'], $_POST['p'])){

    // Our database object
    $db = new Db();

    // Quote and escape form submitted values
    $name = $db -> quote($_POST['username']);
    $pass = $db -> quote($_POST['p']);
    $random_salt = $db -> quote(hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true)));
    // Insert the values into the database
    $result = $db -> query("INSERT INTO `user` (`user`,`pass`,`salt`) VALUES (" . $name . "," . $pass .  ",".$random_salt.")");

    header("Location:".esc_url($_SERVER['PHP_SELF']));
    exit;
}
?>

<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      <title>Register User</title>
      <script type="text/JavaScript" src="js/sha512.js"></script>
      <script type="text/JavaScript" src="js/forms.js"></script>
   </head>
   <body>
      <!-- Registration form to be output if the POST variables are not
         set or if the registration script caused an error. -->
      <h1>Register</h1>
      <?php
         if (!empty($error_msg)) {
             echo $error_msg;
         }
         ?>
      <form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>"
         method="post"
         name="registration_form">
         <table>
            <tr>
               <td>
                  Username:
               </td>
               <td><input type='text'
                  name='username'
                  id='username' /></td>
            </tr>
            <tr>
               <td>Password</td>
               <td><input type="password"
                  name="password"
                  id="password"/></td>
            </tr>
            <tr>
               <td>Confirm Password</td>
               <td><input type="password"
                  name="confirmpwd"
                  id="confirmpwd" /></td>
            </tr>
            <tr>
               <td colspan =2><br><br><input type="button"
                  value="Register"
                  onclick="return regformhash(this.form,
                  this.form.username,
                  this.form.password,
                  this.form.confirmpwd);" />
               </td>
            </tr>
         </table>
      </form>
   </body>
</html>

