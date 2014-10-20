<?php
include('MyFunctions.inc.php');


if (isset($_GET["id"])) $id = $_GET["id"]; else $id = "";
if (isset($_GET["action"])) $action = $_GET["action"]; else $action = "";
if (empty($action))
{ 
?>

<html>
<head>
  <title>SKM - Display Host Details</title>
  <LINK REL=STYLESHEET HREF="skm.css" TYPE="text/css">
</head>
<body>

<?php
  
      $result = mysql_query( "SELECT * FROM `hosts` WHERE `id`='$id'" )
                         or die (mysql_error()."<br>Couldn't execute query: $query");
      $nr = mysql_num_rows( $result );
      $row = mysql_fetch_array( $result ); 
      // Afecting values
      $name = $row["name"];
      $id = $row["id"];
      
      // getting the right icon
	$icon="images/server.gif";
	if ( $row['ostype'] == "RHEL" ) $icon="images/icon-redhat.gif";
	if ( $row['ostype'] == "Linux" ) $icon="images/icon-linux.png";
	if ( $row['ostype'] == "CentOS" ) $icon="images/icon-centos.png";
	if ( $row['ostype'] == "AIX" ) $icon="images/icon-aix.gif";
	if ( $row['ostype'] == "Solaris" ) $icon="images/icon-solaris.gif";
	if ( $row['ostype'] == "Windows" ) $icon="images/icon-windows.gif";
	if ( $row['ostype'] == "FreeBSD" ) $icon="images/icon-freebsd.gif";

  $ostype=$row['ostype'];
  $osvers=$row['osvers'];
  $model=$row['model'];
  $po=$row['vendor'];
  $serialno=$row['serialno'];
  $groupname=$row['Environment'];

  start_main_frame("<a href=\"show_all_hosts.php\"> SKM </a> > $name"); 
  start_left_pane(); 
  display_menu(); 
  end_left_pane(); 
  start_right_pane(); 
  
  // -------------- Host details ---------------
  echo("<fieldset><legend>Host Details [ <a href='hosts_setup.php?id=$id&hostgroup=$groupname'>edit details</a> ] [ <a href='host-view.php?id=$id&action=delete&hostgroup=$groupname'>delete $name</a> ]</legend>");
  echo("<table class=detail>");
  echo("<tr><th>OS Type</th><th>OS Version</th><th>Vendor</th><th>Model</th><th>Serial No</th></tr>");
  echo("	<tr><td><img src='$icon' border='0'> $ostype</td><td>$osvers</td><td>$po</td><td>$model</td><td>$serialno</td></tr>\n");
  echo("</table>\n");
  echo("</fieldset>");
  echo("<fieldset><legend>Tags [ <a href='tags_hosts.php?id=$id&hostgroup=$groupname'>edit tags</a> ]</legend>");
        $query_tags = "SELECT * FROM `hosts-tags` where `id-hosts` = '$id' ";
        $result_tags = mysql_query( $query_tags ) or die (mysql_error()."<br>Couldn't execute query: $query_tags");
	$tag_list="";
	while ( $tagrow = mysql_fetch_array($result_tags))
	{
		$tag_id = $tagrow['id-tags'];
		$tag_name = get_tag_name($tag_id);
		$tag_list .= $tag_name.",  ";
	}
	echo "$tag_list";
  echo("</br>\n");

  echo("</fieldset>");

  // -------------- Deployment Identity ---------------  
  echo("<fieldset><legend>Deployment Information</legend>");
	$query_identity = "SELECT * FROM `hosts-identities` where `id_host` like '$id' "; 
	$result_identity = mysql_query( $query_identity ) or die (mysql_error()."<br>Couldn't execute query: $query_identity");
	
	$nridentity = mysql_num_rows($result_identity);
	if(empty($nridentity)) {
		echo "<img src=\"images/error.gif\"> No identity account for deployment associated with this host. <a href=\"identities_hosts.php?hostgroup=$hostgroup&id=$id\">Please add one now</a> ";
	}
	else {
		$row_identity = mysql_fetch_array( $result_identity );
		// Afecting values
		$id_identities = $row_identity["id_identities"];
		
		$name_identity = get_identity_name($id_identities);
		                     
		echo "SSH key on this host will be deployed using identity : $name_identity [ <a href=\"identities_hosts.php?hostgroup=$hostgroup&id=$id\">change</a> ]";
		
		mysql_free_result( $result_identity );
	}
  echo("</fieldset>");
  
  // -------------- Account management ---------------
  
  echo("<fieldset><legend>SSH Key Management</legend>");
	
  echo("<table class='displayaccount'>\n");
  echo("<tr><td class=displayaccount><a href=\"ha_setup.php?id=$id&host_name=$name&hostgroup=$groupname\"><img src=\"images/mister_add.png\"><br>Add an account</td>");

  // looking for accounts
  // --------------------
  $accounts = mysql_query( "SELECT * FROM `hosts-accounts` WHERE `id_host` = '$id'" )
              or die (mysql_error()."<br>Couldn't execute query: $query");
  $nr_accounts = mysql_num_rows( $accounts );
  $currentnum=2; // 2 not 1 because we display Add an Account on first line
  while ( $keyrow = mysql_fetch_array($accounts))
  {
   	$id_account = $keyrow["id_account"];
    $name_account = get_account_name($id_account);
    $account_uid = get_account_uid($id_account);
    if ( $currentnum == 5){
    	echo("</tr><tr>");
    	$currentnum = 1;
    }
    echo("<td class=\"displayaccount\"><a href=\"account-view.php?id=$id&hostgroup=$groupname&id_account=$id_account&id_identity=$id_identities\"><img src=\"images/mister.png\"><br>$name_account<br>( $account_uid )</td>");
    $currentnum += 1;
   }
   echo("</tr></table>");
   
   mysql_free_result( $accounts );
  
?>  
</td></tr></table>
</fieldset>
<? end_right_pane(); ?>
<? end_main_frame(); ?>


</body>
</html>

  <?php
}
else //( empty($action))
{
  if ( $_GET['action'] == "delete" )
  {
    $id = $_GET['id'];
    mysql_query( "DELETE FROM `hosts` WHERE `id`='$id'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
    mysql_query( "DELETE FROM `hosts-accounts` WHERE `id_host`='$id'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
    mysql_query( "DELETE FROM `hak` WHERE `id_host`='$id'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
    header("Location:hosts-view.php?id_hostgroup=$id_hostgroup");
    exit ();
  }
  if ( $_GET['action'] == "deleteAccount" )
  {
    $id = $_GET['id'];
    $id_account = $_GET['id_account'];
    mysql_query( "DELETE FROM `hak` WHERE `id_host`='$id' and `id_account`='$id_account'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
    mysql_query( "DELETE FROM `hosts-accounts` WHERE `id_host`='$id' and `id_account`='$id_account'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
  }

  if ( $_GET['action'] == "deleteKeyring" )
  {
    $id = $_GET['id'];
    $id_account = $_GET['id_account'];
    $id_keyring = $_GET['id_keyring'];
    mysql_query( "DELETE FROM `hak` WHERE `id_host`='$id' and `id_account`='$id_account' and `id_keyring`='$id_keyring'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "deleteKey" )
  {
    $id = $_GET['id'];
    $id_account = $_GET['id_account'];
    $id_key = $_GET['id_key'];
    mysql_query( "DELETE FROM `hak` WHERE `id_host`='$id' and `id_account`='$id_account' and `id_key`='$id_key'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "expand" )
  {
    $id = $_GET['id'];
    mysql_query( "UPDATE `hosts` SET `expand` = 'Y' WHERE `id`='$id'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "expandkeyring" )
  {
    $id = $_GET['id'];
    $id_account = $_GET['account_id'];
    $id_keyring = $_GET['keyring_id'];
    mysql_query( "UPDATE `hak` SET `expand` = 'Y' WHERE `id_host`='$id' and `id_account`='$id_account' and `id_keyring`='$id_keyring'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "collapsekeyring" )
  {
    $id = $_GET['id'];
    $id_account = $_GET['account_id'];
    $id_keyring = $_GET['keyring_id'];
    mysql_query( "UPDATE `hak` SET `expand` = 'N' WHERE `id_host`='$id' and `id_account`='$id_account' and `id_keyring`='$id_keyring'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "expandaccount" )
  {
    $id = $_GET['id'];
    $id_account = $_GET['account_id'];
    mysql_query( "UPDATE `hosts-accounts` SET `expand` = 'Y' WHERE `id_host`='$id' and `id_account`='$id_account'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "collapseaccount" )
  {
    $id = $_GET['id'];
    $id_account = $_GET['account_id'];
    mysql_query( "UPDATE `hosts-accounts` SET `expand` = 'N' WHERE `id_host`='$id' and `id_account`='$id_account'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "expandall" )
  {
    mysql_query( "UPDATE `hosts` SET `expand` = 'Y' WHERE `id_group` = '$id_hostgroup'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
    # Added on 02-02-2006 : To expand all, we also have to expand accounts
    mysql_query( "UPDATE `hosts-accounts` SET `expand` = 'Y'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
    # Added on 02-02-2006 : To expand all, we also have to expand keyrings
    mysql_query( "UPDATE `hak` SET `expand` = 'Y'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "collapse" )
  {
    $id = $_GET['id'];
    mysql_query( "UPDATE `hosts` SET `expand` = 'N' WHERE `id`='$id'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
  }
  if ( $_GET['action'] == "collapseall" )
  {
    mysql_query( "UPDATE `hosts` SET `expand` = 'N' WHERE `id_group` = '$id_hostgroup'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
    # Added on 02-02-2006 : To expand all, we also have to expand accounts
    mysql_query( "UPDATE `hosts-accounts` SET `expand` = 'N'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
    # Added on 02-02-2006 : To expand all, we also have to expand keyrings
    mysql_query( "UPDATE `hak` SET `expand` = 'N'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
  }


  header("Location:host-view.php?hostgroup=$groupname&id=$id");
  exit ();
} //( empty($action))
?>

