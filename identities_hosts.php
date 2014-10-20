<?php
include('MyFunctions.inc.php');

if (isset($_GET["id"])) $id = $_GET["id"]; else $id = "";
if (isset($_GET["hostgroup"])) $hostgroup = $_GET["hostgroup"]; else $hostgroup = "";
if (isset($_POST["step"])) $step = $_POST["step"]; else $step = "";
if ($step != 1)
{ 
?>

<html>
<head>
  <title>SKM - Associate Identity to host</title>
  <LINK REL=STYLESHEET HREF="skm.css" TYPE="text/css">
</head>
<body>

<?php

  $name = get_host_name($id);
  
  start_main_frame("<a href=\"show_all_hosts.php\"> SKM </a> > <a href=\"host-view.php?hostgroup=$hostgroup&id=$id\">$name</a> > Associate identities"); 
  start_left_pane(); 
  display_menu(); 
  end_left_pane(); 
  start_right_pane(); 
  
  // -------------- Host details ---------------
  echo("<fieldset><legend>Identities</legend>");
    //Display the selection box for the groups
    $result = mysql_query( "SELECT * FROM `identities` ORDER BY `name` " )
                             or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      echo 'No identities found... Please create one.';
    }
    else {
      echo '<form name="setup_identities_association" action="identities_hosts.php" method="post">';
      echo '<select class="list" name="id_identities">';
      echo '<option selected value="1">Please select an identity</option>';

      while( $row = mysql_fetch_array( $result ))
      {
		// Afecting values
		$name = $row["name"];
		$id_identities = $row["id"];
		echo '<option value='.$id_identities.'>'.$name.'</option>';
      }
      echo '</select>';
      echo "<input name=\"step\" type=\"hidden\" value=\"1\">";
      echo "<input name=\"id_host\" type=\"hidden\" value=\"$id\">";
      echo "<input name=\"hostgroup\" type=\"hidden\" value=\"$hostgroup\">";
      echo "<input name=\"submit\" type=\"submit\" value=\"add\">";
      echo '</form>';

      mysql_free_result( $result );
    }
  echo("</fieldset>"); ?>



<? end_right_pane(); ?>
<? end_main_frame(); ?>


</body>
</html>

  <?php
}
else //( empty($action))
{
	$id_host = $_POST['id_host'];
	$id_identities = $_POST['id_identities'];
	$hostgroup = $_POST['hostgroup'];

	$query = "SELECT * FROM `hosts-identities` where `id_host` like '$id_host'";	
    $result = mysql_query( $query ) or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(empty($nr)) {
    	$query = "insert into `hosts-identities` ( `id_host`,`id_identities`) values ('$id_host', '$id_identities' )";
    	mysql_query( $query ) or die(mysql_error()."<br>Couldn't execute query: $query");

    }
    else {
    	$query = "update `hosts-identities` set `id_host` = '$id_host',`id_identities`= '$id_identities' where `id_host` = '$id_host'";
		mysql_query( $query ) or die(mysql_error()."<br>Couldn't execute query: $query");
	}
	
	header("Location:host-view.php?hostgroup=$hostgroup&id=$id_host");
/* 	echo ("account Added : host=$id_host, identity=$id_identities, hostgroup=$hostgroup, query=$query, redirecting..."); */
	exit ();
} //( empty($action))
?>

