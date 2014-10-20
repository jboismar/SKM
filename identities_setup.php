<?php include('MyFunctions.inc.php');

if (isset($_POST["step"])) $step = $_POST["step"]; else $step = "";
$name = "";
if($step != '1')
{

  if (isset($_GET["id"])) $id = $_GET["id"]; else $id = "";
  if (!empty($id))
  {
    // We modify an existing reminder
    $result = mysql_query( "SELECT * FROM `identities` where `id`='$id'" )
			or die (mysql_error()."<br>Couldn't execute query: $query");
    $row = mysql_fetch_array( $result );
    $name = $row["name"];
    $identity_file = $row["identity_file"];
    echo ("$name\n");
  }
?>


<html>
<HEAD>
<TITLE>Add Modify Identities</TITLE>
<LINK REL=STYLESHEET HREF="skm.css" TYPE="text/css">
</HEAD>
<BODY>

<?php start_main_frame("<a href=\"show_all_hosts.php\"> SKM </a> > Add/Modify Identities"); ?>
<?php start_left_pane(); ?>
<?php display_menu(); ?>
<?php end_left_pane(); ?>
<?php start_right_pane(); ?>

    <center>
    <form name="identities_setup" action="identities_setup.php" enctype="multipart/form-data" method="post">
    <fieldset><legend>Add / Modify an identity account</legend>
    <table border='0' align='center' class="modif_contact">
      <tr>
        <td class="Type">Identity Name : </td>
        <td class="Content" width="80%">
        <input name="name" size="50" type="text" maxlength="255" value="<?php echo("$name"); ?>">
        </td>
      </tr>
      <tr>
        <td class="Type">Private key file : </td>
        <td class="Content" width="80%">
        <input type="file" name="ufile">
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
   	$name = $_POST['name'];
	$fileName = $_FILES['ufile']['name'];
	$tmpName  = $_FILES['ufile']['tmp_name'];
	$fileSize = $_FILES['ufile']['size'];
	$fileType = $_FILES['ufile']['type'];
	
	// Slurp the content of the file into a variable
	            
	$fp = fopen($tmpName, 'r');
	$content = fread($fp, filesize($tmpName));
	$content = addslashes($content);
	fclose($fp);
	
/*
	echo("<html><head></head><body>");
	echo("$id $name $fileName $tmpName $fileSize $fileType $content ");
	echo("</body></html>");
*/

    if(empty($id)){
    // this is a new account
      mysql_query( "INSERT INTO `identities` (`name`,`identity_file`,`file_size` ) VALUES('$name','$content','$fileSize')" ) or die(mysql_error()."<br>Couldn't execute query: $query");
      header("Location:identities.php");
      echo ("Account Added, redirecting...");
      exit ();
    } elseif ($id > 1) {
      mysql_query( "UPDATE `identities` SET `name` = '$name', `identity_file`='$content', `file_size`='$fileSize'  WHERE `id` = '$id' " );
      // Let's go to the Reminder List page
      header("Location:identities.php");
      echo ("Account Modified, redirecting...");
      exit ();
    } else {
     die('You are really not allowed to edit the root user');
    }

}
?>
