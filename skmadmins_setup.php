<?php include('MyFunctions.inc.php');

$step = $_POST["step"];
echo ("Step is $step");
if($step != '1')
{

  if (isset($_GET["id"])) $id = $_GET["id"]; else $id = "";
  if (!empty($id))
  {
    // We modify an existing reminder
    $result = mysql_query( "SELECT * FROM `skmadmins` where `id`='$id'" )
			or die (mysql_error()."<br>Couldn't execute query: $query");
    $row = mysql_fetch_array( $result );
    $login = $row["login"];
    $firstname = $row["firstname"];
    $lastname = $row["lastname"];
    echo ("$login\n");
  }
?>


<html>
<HEAD>
<TITLE>Add Modify skmadmins</TITLE>
<LINK REL=STYLESHEET HREF="skm.css" TYPE="text/css">
</HEAD>
<BODY>

<?php start_main_frame("<a href=\"show_all_hosts.php\"> SKM </a> > Add/Modify Admins"); ?>
<?php start_left_pane(); ?>
<?php display_menu(); ?>
<?php end_left_pane(); ?>
<?php start_right_pane(); ?>

    <center>
    <form name="skmadmins_setup" action="skmadmins_setup.php" method="post">
    <fieldset><legend>Add / Modify SKM admin account</legend>
    <table border='0' align='center' class="TypeContent">
      <tr>
        <td class="Type">First name : </td>
        <td class="Content" width="80%">
        <input name="firstname" size="50" type="text" maxlength="255" value="<?php echo("$firstname"); ?>">
        </td>
      </tr>
      <tr>
        <td class="Type">Last name : </td>
        <td class="Content" width="80%">
        <input name="lastname" size="50" type="text" maxlength="255" value="<?php echo("$lastname"); ?>">
        </td>
      </tr>
      <tr>
        <td class="Type">Login name : </td>
        <td class="Content" width="80%">
        <input name="login" size="50" type="text" maxlength="255" value="<?php echo("$login"); ?>">
        </td>
      </tr>
      <tr>
        <td class="Type">Password : </td>
        <td class="Content" width="80%">
        <input name="password" type="password" class="textfield" id="password" />
        </td>
      </tr>
      </table>
      </fieldset>
      <center>
      <input name="step" type="hidden" value="1">
      <input name="id" type="hidden" value="<?php echo("$id");?>">
      <input name="submit" type="submit" value="submit">
      </center>
    </form>
    </center>

<? end_right_pane(); ?>
<? end_main_frame(); ?>


</body>
</html>

<?php
}
else
{
    $id = $_POST['id'];
   	$login = $_POST['login'];
   	$passwd = $_POST['password'];
   	$firstname = $_POST['firstname'];
   	$lastname = $_POST['lastname'];
	
    if(empty($id)){
    // this is a new account
      $query = "INSERT INTO `skmadmins` (`login`,`passwd`,`firstname`,`lastname` ) VALUES('$login','".md5($_POST['password'])."','$firstname','$lastname')";
      mysql_query( $query ) or die(mysql_error()."<br>Couldn't execute query: $query");
      header("Location:skmadmins.php");
      echo ("Account Added, redirecting...");
      exit ();
    } else {
      $query = "UPDATE `skmadmins` SET `login` = '$login', `passwd`='".md5($_POST['password'])."', `firstname`='$firstname', `lastname`='$lastname'  WHERE `id` = '$id' " ;
      mysql_query( $query ) or die(mysql_error()."<br>Couldn't execute query: $query");
      // Let's go to the Reminder List page
      header("Location:skmadmins.php");
      echo ("Account Modified, redirecting...");
      exit ();
    }

}
?>
