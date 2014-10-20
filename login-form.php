<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Login Form</title>
<link href="skm.css" rel="stylesheet" type="text/css" />
</head>
<body>

<?php echo("<table class=navigation><tr><td class=navigation>SKM > Login</td></tr></table>\n"); ?>
<center>
<p>&nbsp;</p>
<form id="loginForm" name="loginForm" method="post" action="login-exec.php">
  <table class=login>
    <tr>
      <td class=label width="112"><b>Login</b></td>
      <td class=input width="188"><input name="login" type="text" class="textfield" id="login" /></td>
    </tr>
    <tr>
      <td class=label><b>Password</b></td>
      <td class=input><input name="password" type="password" class="textfield" id="password" /></td>
    </tr>
    <tr>
      <td class=label></td>
      <td class=input><input type="submit" name="Submit" value="Login" /></td>
    </tr>
  </table>
</form>
</center>
<br><br>
<?php echo("<table class=navigation><tr><td class=foot><center>SSH Key Management SKM - v2.0</center></td></tr></table>\n"); ?>

</body>
</html>
