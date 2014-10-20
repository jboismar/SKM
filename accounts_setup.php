<?php include('MyFunctions.inc.php');

if (isset($_POST["step"])) $step = $_POST["step"]; else $step = "";
$name = "";
if($step != '1')
{

  if (isset($_GET["id"])) $id = $_GET["id"]; else $id = "";
  if (!empty($id))
  {
    // We modify an existing reminder
    $result = mysql_query( "SELECT * FROM `accounts` where `id`='$id'" )
			or die (mysql_error()."<br>Couldn't execute query: $query");
    $row = mysql_fetch_array( $result );
    $name = $row["name"];
    $UID = $row["UID"];
    $GID = $row["GID"];
    $GIDname = $row["GIDname"];
    $homedir = $row["homedir"];
    $GECOS = $row["GECOS"];
    echo ("$name\n");
  }
?>


<html>
<HEAD>
<TITLE>Account Setup</TITLE>
<LINK REL=STYLESHEET HREF="skm.css" TYPE="text/css">
</HEAD>
<BODY>

<?php start_main_frame(); ?>
<?php start_left_pane(); ?>
<?php display_menu(); ?>
<?php end_left_pane(); ?>
<?php start_right_pane(); ?>

    <center>
    <form name="setup_account" action="accounts_setup.php" method="post">
    <fieldset><legend>Add / Modify a account</legend>
    <table border='0' align='center' class="TypeContent">
      <tr>
        <td class="Type">Account Name : </td>
        <td class="Content" width="80%">
        <input name="name" size="50" type="text" maxlength="255" value="<?php echo("$name"); ?>">
        </td>
      </tr>
      <tr>
        <td class="Type">UID : </td>
        <td class="Content" width="80%">
        <input name="UID" size="11" type="text" maxlength="11" value="<?php echo("$UID"); ?>">
        </td>
      </tr>
      <tr>
        <td class="Type">GroupName : </td>
        <td class="Content" width="80%">
        <input name="GIDname" size="11" type="text" maxlength="11" value="<?php echo("$GIDname"); ?>">
        </td>
      </tr>
      <tr>
        <td class="Type">GID : </td>
        <td class="Content" width="80%">
        <input name="GID" size="11" type="text" maxlength="11" value="<?php echo("$GID"); ?>">
        </td>
      </tr>
      <tr>
        <td class="Type">Home directory : </td>
        <td class="Content" width="80%">
        <input name="homedir" size="50" type="text" maxlength="50" value="<?php echo("$homedir"); ?>">
        </td>
      </tr>
      <tr>
        <td class="Type">Comment ( GECOS ) : </td>
        <td class="Content" width="80%">
        <input name="GECOS" size="50" type="text" maxlength="50" value="<?php echo("$GECOS"); ?>">
        </td>
      </tr>
      </table>
      </fieldset>
      <center>
      <input name="step" type="hidden" value="1">
      <input name="id" type="hidden" value="<?php echo("$id");?>">
      <input name="submit" type="submit" value="add/edit">
      </center>
    </form>
    <fieldset><legend>Note</legend>
    Only the account name is required for the account creation, all other information is optional.<br>If you want to specify a group when you create the account, please note that Linux will use the GID field and AIX the GroupName.</fieldset>
    </center>

<? end_right_pane(); ?>
<? end_main_frame(); ?>


</body>
</html>

<?php
}
else
{
  $error_list = "";
  if( empty( $error_list ) )
  {
    $id = $_POST['id'];
    if(empty($id)){
    // this is a new account
      $name = $_POST['name'];
      $UID = $_POST['UID'];
      $GID = $_POST['GID'];
      $GIDname = $_POST['GIDname'];
      $homedir = $_POST['homedir'];
      $GECOS = $_POST['GECOS'];
      // No error let's add the entry
      mysql_query( "INSERT INTO `accounts` (`name`,`UID`,`GID`,`GIDname`,`homedir`,`GECOS` ) VALUES('$name','$UID','$GID','$GIDname','$homedir','$GECOS')" ) or die(mysql_error()."<br>Couldn't execute query: $query");
      // Let's go to the Reminder List page
      //if (empty($_POST['called']))
      //  header("Location:reminder_list.php");
      //else
      header("Location:accounts.php");
      echo ("Account Added, redirecting...");
      exit ();
    } elseif ($id > 1) {
      // We modify an existing reminder
      // setting the variable for the update
      $UID = $_POST['UID'];
      $GID = $_POST['GID'];
      $GIDname = $_POST['GIDname'];
      $name = $_POST['name'];
      $homedir = $_POST['homedir'];
      $GECOS = $_POST['GECOS'];
      mysql_query( "UPDATE `accounts` SET `name` = '$name', `UID`='$UID',`GID`='$GID',`GIDname`='$GIDname',`homedir`='$homedir',`GECOS`='$GECOS'  WHERE `id` = '$id' " );
      // Let's go to the Reminder List page
      header("Location:accounts.php");
      echo ("Account Modified, redirecting...");
      exit ();
    } else {
     die('You are really not allowed to edit the root user');
    }

  }
  else
  {
    // Error occurred let's notify it
    echo( $error_list );
  }
}
?>
