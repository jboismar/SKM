<?php include('MyFunctions.inc.php');

if (isset($_GET["aix"])) $aix = $_GET["aix"]; else $aix = "";
if (isset($_GET["rhel"])) $rhel = $_GET["rhel"]; else $rhel = "";
if (isset($_GET["solaris"])) $solaris = $_GET["solaris"]; else $solaris = "";
if (isset($_GET["id"])) $id = $_GET["id"]; else $id = "";
if (isset($_GET["action"])) $action = $_GET["action"]; else $action = "";

?>

<html>
<HEAD>
<TITLE>All Hosts Overview</TITLE>
<LINK REL=STYLESHEET HREF="skm.css" TYPE="text/css">
</HEAD>
<BODY>

<?php

start_main_frame("SKM > All hosts view");
start_left_pane();
display_menu();
end_left_pane();
start_right_pane();

//print("<center><fieldset><legend>All Hosts Overview</legend>");

$result = mysql_query( "SELECT * FROM `hosts` ORDER BY `name`" )
					 or die (mysql_error()."<br>Couldn't execute query: $query");

$nr = mysql_num_rows( $result );
if(empty($nr)) 
{
	echo("No hosts found ...\n");
}
else 
{
?>
  <table class=detail>
  
    <?php
	echo ("<thead><tr><th>icon</th><th>Hostname</th><th>Environment</th><th>Serial #</th><th>OS type</th><th>OS Version</th><th>Vendor</th><th>Model</th></tr></thead>");
    echo ("<tbody>");
      $odd=1;
      while( $row = mysql_fetch_array( $result )) 
      {
        // Affecting values
        $name = $row["name"];
        $id = $row["id"];
		$id = $row["id"];
		$id_group = $row["id_group"];
		$ostype = $row["ostype"];
		$osvers = $row["osvers"];
		$serialno = $row["serialno"];
		$Environment = $row["Environment"];
		$vendor = $row["vendor"];
		$model = $row["model"];
		  
			// displaying rows
		if ( $odd==1 )
		{
			$odd=0;
			echo("<tr class=odd>");
		} else {
			$odd+=1;
			echo("<tr>\n");
		}

		// getting the right icon
		$icon="images/server.gif";
		if ( $row['ostype'] == "RHEL" ) $icon="images/icon-redhat.gif";
		if ( $row['ostype'] == "AIX" ) $icon="images/icon-aix.gif";
		if ( $row['ostype'] == "Solaris" ) $icon="images/icon-solaris.gif";
		if ( $row['ostype'] == "Windows" ) $icon="images/icon-windows.gif";
		if ( $row['ostype'] == "FreeBSD" ) $icon="images/icon-freebsd.gif";

		echo("  <td class='title'><img src='$icon' border='0'></td>");
		echo("	<td><a href='host-view.php?id=$id&hostgroup=$Environment'>$name</a></td>");
		echo("	<td>$Environment</td>");
		echo("	<td>$serialno</td>");
		echo("	<td>$ostype</td>");
		echo("	<td>$osvers</td>");
		echo("	<td>$vendor</td>");
		echo("	<td>$model</td>");
    }

    mysql_free_result( $result );
    echo("</tr></tbody></table>");

}

echo("</td></tr></table>");
end_right_pane();
end_main_frame(); 

?>

</body>
</html>
