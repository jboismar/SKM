<?php include('MyFunctions.inc.php');

if (isset($_GET["id"])) $id = $_GET["id"]; else $id = "";
if (isset($_GET["id_account"])) $id_account = $_GET["id_account"]; else $id_account = "";
if (isset($_GET["hostgroup"])) $hostgroup = $_GET["hostgroup"]; else $hostgroup = "";
if (isset($_POST["step"])) $step = $_POST["step"]; else $step = "";

// We get the list of keyrings
/* $result = mysql_query( "SELECT * FROM `keyrings`" ); */


if($step != '1')
{
?>


<html>
<HEAD>
<TITLE>Hosts - accounts - Keyrings Association</TITLE>
<LINK REL=STYLESHEET HREF="skm.css" TYPE="text/css">
</HEAD>
<BODY>

<?php 
$name_account = get_account_name($id_account);
$name = get_host_name($id);
start_main_frame("<a href=\"show_all_hosts.php\"> SKM </a> > <a href=\"hosts-view.php?hostgroup=$hostgroup\">$hostgroup</a> > <a href=\"host-view.php?id=$id&hostgroup=$hostgroup\"> $name </a> > <a href=\"account-view.php?id=$id&hostgroup=$hostgroup&id_account=$id_account\">$name_account </a> > Add a Keyring"); ?>
<?php start_left_pane(); ?>
<?php display_menu(); ?>
<?php end_left_pane(); ?>
<?php start_right_pane(); ?>

    <center>
    <form name="setup_hak" action="hak_setup.php" method="post">
    <fieldset><legend>Adding keyring(s) to account <?php echo("$account_name"); ?> on host <?php echo("$host_name");?></legend>
    <table border='0' align='center' class="modif_contact">
      <tr>
        <td class="Type"><img src='images/keyring_little.gif'><?php display_availables_keyrings(); ?></td>
        </td>
      </tr>
    </table>
    </fieldset>
      <center>
      <input name="step" type="hidden" value="1">
      <input name="id" type="hidden" value="<?php echo("$id");?>">
      <input name="hostgroup" type="hidden" value="<?php echo("$hostgroup");?>">
      <input name="id_account" type="hidden" value="<?php echo("$id_account");?>">
      <input name="submit" type="submit" value="add">
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
  $error_list = "";
  if( empty( $error_list ) )
  {
    if (isset($_POST["id"])) $host_id = $_POST["id"]; else $host_id = "";
	if (isset($_POST["id_account"])) $account_id = $_POST["id_account"]; else $account_id = "";
	if (isset($_POST["keyring"])) $keyring_id = $_POST["keyring"]; else $keyring_id = "";
	if (isset($_POST["key"])) $key_id = $_POST["key"]; else $key_id = "";
	if (isset($_POST["hostgroup"])) $hostgroup = $_POST["hostgroup"]; else $hostgroup = "";

    //echo ("account_name = $account_name, account_id = $account_id, host_id = $host_id");
    //echo ("Keyring id = $keyring_id, key id = $key_id");
    //die ("We stop here");

    mysql_query( "INSERT INTO `hak` (`id_host`, `id_account`, `id_keyring`,`expand`) VALUES('$host_id','$account_id','$keyring_id','Y')" ) or die(mysql_error()."<br>Couldn't execute query: insert host_id=$host_id, account_id=$account_id, keyring_id=$keyring_id [$query]");
    header("Location:account-view.php?id=$host_id&hostgroup=$hostgroup&id_account=$account_id");
    echo ("keyring Added, redirecting...");
    exit ();
  }
  else
  {
    // Error occurred let's notify it
    echo( $error_list );
  }
}
?>


