<?php
include('MyFunctions.inc.php');

if (isset($_GET["id"])) $id = $_GET["id"]; else $id = "";
if (isset($_GET["hostgroup"])) $groupname = $_GET["hostgroup"]; else $hostgroup = "";
if (isset($_GET["id_account"])) $id_account = $_GET["id_account"]; else $id_account = "";
if (isset($_GET["action"])) $action = $_GET["action"]; else $action = "";
if (empty($action))
{ 
	?>
	
	<html>
	<head>
	  <title>SKM - Display Account - Key</title>
	  <LINK REL=STYLESHEET HREF="skm.css" TYPE="text/css">
	</head>
	<body>
	
	<?php

	$name_account = get_account_name($id_account);
	$name = get_host_name($id);
	  
	start_main_frame("<a href=\"show_all_hosts.php\"> SKM </a> > <a href=\"host-view.php?id=$id&hostgroup=$groupname\"> $name </a> > $name_account"); 
	start_left_pane(); 
	display_menu(); 
	end_left_pane(); 
	start_right_pane(); 
	
	
	echo("<fieldset><legend><img src=\"images/mister.png\">$name_account [ <a href=\"hak_setup.php?id=$id&host_name=$name&id_account=$id_account&account_name=$name_account&hostgroup=$groupname\"> add a keyring | </a><a href=\"hakk_setup.php?id=$id&host_name=$name&id_account=$id_account&account_name=$name_account&hostgroup=$groupname\">add a key | </a><a href=\"deploy_account.php?id=$id&id_account=$id_account&hostgroup=$groupname\">Deploy |</a><a href=\"view_aut_account.php?id=$id&id_account=$id_account&hostgroup=$groupname\"> View Auth </a> | <a href='host-view.php?id=$id&id_account=$id_account&action=deleteAccount&hostgroup=$groupname'> Delete ]</a></legend>");
	
	// looking for keyrings and keys
	//------------------------------
	$keyrings = mysql_query( "SELECT * FROM `hak` WHERE `id_host` = '$id' and `id_account` ='$id_account' and `id_keyring` != '0' " ) or die (mysql_error()."<br>Couldn't execute query: $query");
	$nr_keyrings = mysql_num_rows( $keyrings );
	$keys = mysql_query( "SELECT * FROM `hak` WHERE `id_host` = '$id' and `id_account` ='$id_account' and `id_key` != '0' " ) or die (mysql_error()."<br>Couldn't execute query: $query");
	$nr_keys = mysql_num_rows( $keys );
	
	echo("<table class=\"detail\"><tr>");
	
	// if no key nor keyring found
	if(empty($nr_keys) and empty($nr_keyrings))
	{
	 		echo ("<tr><td class='detail1'>No keys or keyrings associated</td></tr>\n");
	} //if(empty($nr_keys) and empty($nr_keyrings))
	
	// if keyring found
	if(!empty($nr_keyrings)) 
	{
		while ( $keyringrow = mysql_fetch_array($keyrings))
		{
			display_keyring($keyringrow["id_host"],$keyringrow["id_account"],$keyringrow["id_keyring"],$groupname,"detail2",$keyringrow["expand"]);
		} //while ( $keyringrow = mysql_fetch_array($keyrings))
		mysql_free_result ( $keyrings );
	} //if(!empty($nr_keyrings))
	
	// if key found
	if(!empty($nr_keys)) 
	{
		while ( $keyrow = mysql_fetch_array($keys))
		{
		display_key($keyrow["id_host"],$keyrow["id_account"],$keyrow["id_key"],$groupname,"detail1");
		} //while ( $keyrow = mysql_fetch_array($keys))
		mysql_free_result ( $keys );
	} //if(!empty($nr_keys)) 
	  
	print("</tr></table></fieldset>");
	end_right_pane(); 
	end_main_frame(); 
	
	print("</body></html>");
	
}
else //( empty($action))
{
	if (isset($_GET["id"])) $id = $_GET["id"];
	if (isset($_GET["id_account"])) $id_account = $_GET["id_account"];
	if (isset($_GET["id_keyring"])) $id_keyring = $_GET["id_keyring"];
	if (isset($_GET["id_key"])) $id_key = $_GET["id_key"];
	if (isset($_GET["hostgroup"])) $hostgroup = $_GET["hostgroup"];
	
	if ( $_GET['action'] == "deleteKeyring" )  {
	mysql_query( "DELETE FROM `hak` WHERE `id_host`='$id' and `id_account`='$id_account' and `id_keyring`='$id_keyring'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
	}
	if ( $_GET['action'] == "deleteKey" )  {
	mysql_query( "DELETE FROM `hak` WHERE `id_host`='$id' and `id_account`='$id_account' and `id_key`='$id_key'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
	}
	if ( $_GET['action'] == "expandkeyring" )  {
	mysql_query( "UPDATE `hak` SET `expand` = 'Y' WHERE `id_host`='$id' and `id_account`='$id_account' and `id_keyring`='$id_keyring'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
	}
	if ( $_GET['action'] == "collapsekeyring" )  {
	mysql_query( "UPDATE `hak` SET `expand` = 'N' WHERE `id_host`='$id' and `id_account`='$id_account' and `id_keyring`='$id_keyring'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
	}
	if ( $_GET['action'] == "expandaccount" )  {
	mysql_query( "UPDATE `hosts-accounts` SET `expand` = 'Y' WHERE `id_host`='$id' and `id_account`='$id_account'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
	}
	if ( $_GET['action'] == "collapseaccount" )  {
	mysql_query( "UPDATE `hosts-accounts` SET `expand` = 'N' WHERE `id_host`='$id' and `id_account`='$id_account'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
	}
	if ( $_GET['action'] == "expandall" )
	{
	mysql_query( "UPDATE `hosts` SET `expand` = 'Y' WHERE `id_group` = '$id_hostgroup'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
	# added on 02-02-2006 : to expand all, we also have to expand accounts
	mysql_query( "UPDATE `hosts-accounts` SET `expand` = 'Y'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
	# added on 02-02-2006 : to expand all, we also have to expand keyrings....
	mysql_query( "UPDATE `hak` SET `expand` = 'Y'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
	}
	if ( $_GET['action'] == "collapse" )
	{
	mysql_query( "UPDATE `hosts` SET `expand` = 'N' WHERE `id`='$id'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
	}
	if ( $_GET['action'] == "collapseall" )
	{
	mysql_query( "UPDATE `hosts` SET `expand` = 'N' WHERE `id_group` = '$id_hostgroup'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
	# Added on 02-02-2006 : to expand all, we also have to expand accounts
	mysql_query( "UPDATE `hosts-accounts` SET `expand` = 'N'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
	# Added on 02-02-2006 : to expand all, we also have to expand keyrings
	mysql_query( "UPDATE `hak` SET `expand` = 'N'" )
		or die (mysql_error()."<br>Couldn't execute query: $query");
	}
	
	
	header("Location:account-view.php?hostgroup=$groupname&id=$id&id_account=$id_account");
	exit ();
} //( empty($action))
?>

