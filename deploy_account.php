<?php

include('MyFunctions.inc.php');


/*
		if (empty($output)){
		//everything was fine
		$message .= "<img src='images/ok.gif'>authorized_keys has been archived successfully to $homedir/.ssh/authorized_keys.$now<br>\n";
		} else {
		$message .= "<img src='images/error.gif'>authorized_keys could NOT be archived to $homedir/.ssh/authorized_keys.$now<br>\n";
		return $message;
		}
*/


function user_exists($identity_name,$account_name,$hostname){
	$output = array();
	$command = "ssh -v -o BatchMode=yes -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no -i /tmp/$identity_name-id $identity_name@$hostname \"grep \"$account_name\:\" /etc/passwd\" 2>&1"; 
	exec($command,$output,$exit_status);
	display_command_output("Testing if user already exists ?",$exit_status,$output,$command,"warning");
	return $exit_status;
}


function get_homedir($identity_name,$account_name,$hostname){
	$output = array();
	$command = "ssh -v -o BatchMode=yes -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no -i /tmp/$identity_name-id $identity_name@$hostname \"grep \"$account_name\:\" /etc/passwd\" 2>/dev/null";
	exec($command,$output,$exit_status);
	if (!empty($output)){
		list($field1,$field2,$field3,$field4,$field5,$homedir,$shell) = explode(":",$output[0]);
		display_command_output("homedir is $homedir",0,"","","warning");
		return $homedir;
	} else {
		return "user not found";
	}

}

function create_user_account($identity_name,$account_name,$hostname,$UID,$GID,$HOMEDIR,$GIDname,$id,$GECOS){
	$output = array();
	$OStype = get_os_type($id);
	if ( ( $OStype == "Linux" ) || ( $OStype == "RHEL" ) || ( $OStype == "CentOS" ) ||  ( $OStype == "Solaris" ) )
	{
		 
		$command = "ssh -v -o BatchMode=yes -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no -i /tmp/$identity_name-id $identity_name@$hostname -t \"sudo /usr/sbin/useradd";
		if ( !empty($HOMEDIR)) { $command .= " -m -d $HOMEDIR"; }
		if ( !empty($UID)) { $command .= " -u $UID"; }
		if ( !empty($GID)) { $command .=" -g $GID"; }
		if ( !empty($GECOS)) { $command .=" -c '$GECOS'"; } 
		$command .=" $account_name\" 2>&1";
	}
	else if ( $OStype == "Unix" ) 
	{ 
		$command = "ssh -v -o BatchMode=yes -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no -i /tmp/$identity_name-id $identity_name@$hostname -t \"sudo /usr/bin/mkuser";
		if ( !empty($HOMEDIR)) { $command .= " home='$HOMEDIR'"; }
		if ( !empty($UID)) { $command .= " id='$UID'"; }
		if ( !empty($GIDname)) { $command .=" pgrp='$GIDname'"; }
		if ( !empty($GECOS)) { $command .=" gecos='$GECOS'"; } 
		$command .=" $account_name\" 2>&1";
	//}
	//else if ( $OStype == "Solaris" ) 
	//{ 
		//useradd -u 999 -g skm -s /bin/bash -c 'usager SKM' skm
		//$command = "ssh -v -o BatchMode=yes -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no -i /tmp/$identity_name-id $identity_name@$hostname -t \"sudo /usr/bin/useradd";
		//if ( !empty($HOMEDIR)) { $command .= " home='$HOMEDIR'"; }
		//if ( !empty($UID)) { $command .= " id='$UID'"; }
		//if ( !empty($GIDname)) { $command .=" pgrp='$GIDname'"; }
		//if ( !empty($GECOS)) { $command .=" gecos='$GECOS'"; } 
		//$command .=" $account_name\" 2>&1";
	} else {
		$command = "ERROR : OS $OStpye not supported for account creation";
	}


	exec($command,$output,$exit_status);
	display_command_output("Create user account",$exit_status,$output,$command,"error");
	return $exit_status;
}

function user_ssh_dir_exists($identity_name,$account_name,$hostname,$homedir){
	$output = array();
	$command = "ssh -v -o BatchMode=yes -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no -i /tmp/$identity_name-id $identity_name@$hostname -t \"sudo ls $homedir/.ssh/\" 2>&1"; 
	exec($command,$output,$exit_status);
	display_command_output("Does .ssh dir exist ?",$exit_status,$output,$command,"warning");
	return $exit_status;
}

function create_user_ssh_dir($identity_name,$account_name,$hostname,$homedir){
	$output = array();
	$command = "ssh -v -o BatchMode=yes -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no -i /tmp/$identity_name-id $identity_name@$hostname -t \"sudo mkdir $homedir/.ssh\" 2>&1"; 
	exec($command,$output,$exit_status);
	display_command_output("Create .ssh dir",$exit_status,$output,$command,"error");
	return $exit_status;
}

function chperm_user_ssh_dir($identity_name,$account_name,$hostname,$homedir){
	$output = array();
	$command = "ssh -v -o BatchMode=yes -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no -i /tmp/$identity_name-id $identity_name@$hostname -t \"sudo chown $account_name $homedir/.ssh;sudo chmod 700 $homedir/.ssh\" 2>&1"; 
	exec($command,$output,$exit_status);
	display_command_output("Change permissions on .ssh dir",$exit_status,$output,$command,"error");
	return $exit_status;
}


function authorized_key_exist($identity_name,$account_name,$host,$file){
	$output = array();
	$command = "ssh -v -o BatchMode=yes -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no -i /tmp/$identity_name-id $identity_name@$host -t \"sudo ls -la $file\" 2>&1";
	exec($command,$output,$exit_status);
	display_command_output("Does authorized key file exist ?",$exit_status,$output,$command,"warning");
	return $exit_status;
}

function archive_authorized_key_file($identity_name,$account_name,$host,$file){
	$output = array();
	$now = date("Ymd-His");
	$command = "ssh -v -o BatchMode=yes -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no -i /tmp/$identity_name-id $identity_name@$host -t \"sudo cp $file $file.$now\" 2>&1";
	exec($command,$output,$exit_status);
	display_command_output("Archive authorized key file",$exit_status,$output,$command,"warning");
}

function get_local_copy_authorized_key_file($identity_name,$account_name,$host,$file){
	$output = array();
	$command = "ssh -v -o BatchMode=yes -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no -i /tmp/$identity_name-id $identity_name@$host \"sudo rm -f ~/authorized_keys; sudo cp $file ~;sudo chown $identity_name ~/authorized_keys\" 2>&1";
	exec($command,$output,$exit_status);
	display_command_output("Copy authorized key file to $account_name home directory",$exit_status,$output,$command,"warning");
	$command = "scp -v -o BatchMode=yes -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no -i /tmp/$identity_name-id $identity_name@$host:~/authorized_keys /tmp/authorized_keys-$host-$account_name 2>&1";
	exec($command,$output,$exit_status);
	display_command_output("Get authorized key file locally for comparison",$exit_status,$output,$command,"warning");

}

function push_authorized_key_file($identity_name,$account_name,$host,$file){
	$output = array();
	$command = "scp -v -o BatchMode=yes -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no -i /tmp/$identity_name-id /tmp/authorized_keys $identity_name@$host:~ 2>&1";
	exec($command,$output,$exit_status);
	display_command_output("Push new authorized key file to $host",$exit_status,$output,$command,"error");
	$command = "ssh -o BatchMode=yes -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no -i /tmp/$identity_name-id $identity_name@$host \"sudo cp ~/authorized_keys $file;sudo chown $account_name $file;sudo chmod 600 $file\" ";
	exec($command,$output,$exit_status);
	display_command_output("Replace on $host authorized key file with new one",$exit_status,$output,$command,"error");
}

function check_differences($account_name,$host ){
	echo "<fieldset class=cmdok><legend class=cmdok>Checking differences</legend>";
	$differences = shell_exec("diff --ignore-blank-lines -u /tmp/authorized_keys-$host-$account_name /tmp/authorized_keys | grep -v ^--- | grep -v ^+++  | sed 's/^-/<P class=delete> /g' | sed 's/^+/<P class=add> /g' | sed 's/^ ssh-rsa/<p > /g' | sed 's/$/<\/P>/g'");
	if ( empty($differences)){
	$message .= "<br>Files are identicals<br>\n";
	} else {
	$message .= "<br>File comparison output :<br>\n";
	$message .= "<br>Legende :<br>";
	$message .= "<p class=add> Key(s) added<br><p class=delete> Key(s) deleted</p><br>";
	$message .= $differences;
	}
	echo "$message<br></fieldset>";
	
	return $message;
}

$id = $_GET['id'];
$id_account = $_GET['id_account'];
$hostgroup = $_GET['hostgroup'];
$hostname = get_host_name($id);
$ip = get_host_ip($id);

// Getting account information
$queryaccount = "SELECT * FROM `accounts` WHERE `id` = '$id_account' ";
$resultaccount = mysql_query( $queryaccount ) or die (mysql_error()."<br>Couldn't execute query: $queryaccount");
$rowaccount = mysql_fetch_array( $resultaccount );
$account_name = $rowaccount["name"]; 
$account_UID = $rowaccount["UID"]; 
$account_GID = $rowaccount["GID"]; 
$GIDname = $rowaccount["GIDname"]; 
$GECOS = $rowaccount["GECOS"]; 

$OStype = get_os_type($id);

$account_homedir = $rowaccount["homedir"]; 
if ( !empty($$account_homedir)) { 
	if ( $OStype == "Solaris" ) { $account_homedir .= "/export".$account_homedir ; }
}

if ( ! empty($ip) )
{
	$hostname = $ip;
}

?>


<html>
<head>
  <title>Deployment process</title>
  <LINK REL=STYLESHEET HREF="skm.css" TYPE="text/css">
</head>
<body>

<?php start_main_frame("<a href=\"show_all_hosts.php\"> SKM </a> > <a href=\"host-view.php?id=$id&hostgroup=$hostgroup\"> $hostname </a> > <a href=\"account-view.php?id=$id&hostgroup=$hostgroup&id_account=$id_account\">$account_name </a> > Deployment "); ?>
<?php start_left_pane(); ?>
<?php display_menu(); ?>
<?php end_left_pane(); ?>
<?php start_right_pane(); ?>

<?php


// ------------------- Deployment ------------------
echo("<fieldset><legend>Deploying securities for $account_name on host $hostname using identity $identity_name</legend>\n"); 

	// ------------------- Prepare idendity file for this deployment ------------------
	$id_identity = get_identity_id($id);
	$identity_name = get_identity_name($id_identity);
	$query = "SELECT * FROM `identities` WHERE `id` = '$id_identity' ";
	$result = mysql_query( $query ) or die (mysql_error()."<br>Couldn't execute query: $query");
	$row_identity = mysql_fetch_array( $result );
	
	$handle = fopen("/tmp/$identity_name-id","w");
	if ( ! fputs($handle,$row_identity["identity_file"]) ) {
		echo "<fieldset class=cmderror><legend class=cmderror>Preparing private key used for deployment : ERROR</legend>";
		echo "Could not write private key of $identity_name from mysql to local file /tmp/$identity_name-id.<br>";
		echo "Please check if /tmp/$identity_name-id can be created";
		echo "</fieldset>";
		die("");
	} else {
		display_command_output("Writing private key from mysql to /tmp/$identity_name-id",0,"/tmp/$identity_name-id created successfully","","error");
	}
	fclose($handle);
	$output = array();
	$command = "chmod 600 /tmp/$identity_name-id";
	exec($command,$output,$exit_status);
	display_command_output("Changing permissions to /tmp/$identity_name-id",$exit_status,$output,$command,"error");
	mysql_free_result( $result_identity );

	// for DEBUG ONLY !!!!
	//$command = "id";
	//exec($command,$output,$exit_status);
	//$exit_status = 2;
	//display_command_output("who am I ?",$exit_status,$output,$command,"error");
	//$command = "cp /tmp/$identity_name-id /tmp/jb-id";
	//exec($command,$output,$exit_status);
	//$exit_status = 2;
	//display_command_output("Copy $identity_name-id to /tmp/jb-id",$exit_status,$output,$command,"error");
	//$command = "ls -lrt /tmp";
	//exec($command,$output,$exit_status);
	//$exit_status = 2;
	//display_command_output("liste /tmp",$exit_status,$output,$command,"error");
	//$command = "cat /tmp/jb-id";
	//exec($command,$output,$exit_status);
	//$exit_status = 2;
	//display_command_output("cat /tmp/jb-id",$exit_status,$output,$command,"error");


	// ------------------- DEPLOYEMENT ----------------------

if ( test_connection($hostname,$identity_name,$account_name) == 0 ){

	// --------------- checking user account
	if ( user_exists($identity_name,$account_name,$hostname) !=0 ) {
		create_user_account($identity_name,$account_name,$hostname,$account_UID,$account_GID,$account_homedir,$GIDname,$id,$GECOS);
	}

	// --------------- getting homedir of current user
	$homedir = get_homedir($identity_name,$account_name,$hostname);
	if ( $homedir != "user not found" ){
		// --------------- checking ssh directory
		if ( user_ssh_dir_exists($identity_name,$account_name,$hostname,$homedir) !=0 ) {
			create_user_ssh_dir($identity_name,$account_name,$hostname,$homedir);
			chperm_user_ssh_dir($identity_name,$account_name,$hostname,$homedir);
		}

		// --------------- Testing presence of file
		if ( authorized_key_exist($identity_name,$account_name,$hostname,"$homedir/.ssh/authorized_keys") == 0 )
		{
			archive_authorized_key_file($identity_name,$account_name,$hostname,"$homedir/.ssh/authorized_keys");
			get_local_copy_authorized_key_file($identity_name,$account_name,$hostname,"$homedir/.ssh/authorized_keys");
		} else {
			// We create an empty file so check_differences will have 2 files to compare.
			$command="touch /tmp/authorized_keys-$hostname-$account_name";
			exec($command,$output,$exit_status);
		}
		
		// ------------------- Construction authorized_keys_file ------------------
		echo("<fieldset class=cmdok><legend class=cmdok>Constructing securities for $account_name on host $hostname</legend>\n");
		$output = prepare_authorizedkey_file($id,$id_account); 
		echo("$output\n"); 
		echo "</fieldset>";

		push_authorized_key_file($identity_name,$account_name,$hostname,"$homedir/.ssh/authorized_keys");
		
		$diff_result = check_differences($account_name,$hostname);	 
		
	}

}
echo "</fieldset>";	
echo "<a href='host-view.php?id_hostgroup=$id_group#$id'><img src='images/arrowbright.gif> Return to $hostname</a>\n"; 	
// We send an email to all users who have an account
$mailheader = "From: SKM <".$admin_email.">\nX-Mailer: Reminder\nContent-Type: text/html";
$emailuser = $admin_email;	
$message = "Deploying $account_name to $hostname";
$message = "User ".$_SESSION['SESS_FIRST_NAME']." ".$_SESSION['SESS_LAST_NAME']." has deployed account $account_name to host $hostname\nHere is what was changed :\n$diff_result";	
#mail("$emailuser","SKM: Deploying SSH-Key from $account_name to $hostname.","$message","$mailheader") or die("Could not send mail...");


// ------------------- Removing private key from filesystems ------------------
unlink("/tmp/$identity_name-id") or die("ATTENTION : Private key file /tmp/".$identity_name."-id could not be deleted");
unlink("/tmp/authorized_keys-$hostname-$account_name") or die("ATTENTION : file /tmp/".$identity_name."-".$hostname."-".$account_name." could not be deleted");
unlink("/tmp/authorized_keys") or die("ATTENTION : Private key file /tmp/authorized_keys could not be deleted");
 
?>

<? end_right_pane(); ?>
<? end_main_frame(); ?>


</body>
</html>

<?php 
//We delete the private key file

?>
