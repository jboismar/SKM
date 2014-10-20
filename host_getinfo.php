<?php
include('MyFunctions.inc.php');

$id = $_GET['id'];
$keyring_name = get_keyring_name($id_keyring); 

if(!empty($id_keyring))
{

?>


<html>
<head>
  <title>HOST get Info</title>
  <LINK REL=STYLESHEET HREF="skm.css" TYPE="text/css">
</head>
<body>

<?php 
start_main_frame(); 
start_left_pane(); 
display_menu(); 
end_left_pane(); 
start_right_pane(); 



// We fetch all server accounts which have requested keyring

$result = mysql_query( "SELECT * FROM `hak` where `id_keyring` = '$id_keyring' ORDER BY `id_host`" )
                         or die (mysql_error()."<br>Couldn't execute query: $query");

$nr = mysql_num_rows( $result );
if(empty($nr)) 
{
    echo("<fieldset><legend>Error</legend>This keyring does not seem to be in use...</fieldset>\n");
} else {

    echo("<fieldset><legend>Deploying keyring $keyring_name</legend>\n");
    while( $row = mysql_fetch_array( $result ))
    {
        // Afecting values
        $id_host = $row["id_host"];
        $id_account = $row["id_account"];

	$hostname = get_host_name($id_host);
	$account_name = get_account_name($id_account); 

	echo("<fieldset><legend>Processing account $account_name on host $hostname</legend>\n");
	$output = prepare_authorizedkey_file($id_host,$id_account); 
	//echo("prepare_authorizedkey_file($id_host,$id_account)"); 
	echo("<table class='detail'><tr><td class='deployment'>$output</td></tr></table>\n");

	$output = deploy_authorizedkey_file($id_host,$id_account); 
	//echo("deploy_authorizedkey_file($id_host,$id_account)");
	echo("<table class='detail'><tr><td class='deployment'>$output</td></tr></table></fieldset>\n");
    }
    echo("</fieldset>\n");
}


end_right_pane(); 
end_main_frame(); 
?>

</body>
</html>

<?php 
//We delete the private key file
unlink("/var/www/.ssh/id_rsa") or die("ATTENTION : Private key file /var/www/.ssh/id_rsa could not be deleted");
} else {
	die("This page cannot be called without argument...");
}
