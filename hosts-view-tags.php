<?php
include('MyFunctions.inc.php');
@$id = $_GET['id'];
@$action = $_GET['action'];
@$tagid = $_GET['tagid'];
@$hostname = $_POST['hostname'];
if( !isset($_GET["tagid"])) { $tagid="None"; }
if( !isset($_POST["hostname"])) { $hostname="%"; } else { $hostname=$_POST["hostname"].'%'; }
?>

<html>
<head>
  <title>SKM - Display Host list</title>
  <LINK REL=STYLESHEET HREF="skm.css" TYPE="text/css">
  <script src="sorttable.js"></script>
</head>
<body>

<?php start_main_frame("<a href=\"hosts-view-tags.php\"> SKM </a> > $tag"); ?>
<?php start_left_pane(); ?>
<?php display_menu(); ?>
<?php end_left_pane(); ?>
<?php start_right_pane(); ?>

<!-- <form name="hostnameSearch" action="hosts-view.php" method="post">
	hostname : <input name="hostname" type="text" value="<?php echo "$hostname"; ?>" >
	<input name="submit" type="submit" value="Search">
</form> -->


  <table class=detail>
	
    <?php
    if ($tag == "None") {
    	$SQLQUERY="SELECT * FROM `hosts` WHERE `name` like '$hostname' ORDER BY `name` ASC";
    } else {
    	$SQLQUERY="select * from hosts,`hosts-tags` where hosts.id = `hosts-tags`.`id-hosts` AND `hosts-tags`.`id-tags`='$tagid';";
    }
    if ( $aix == "Y" ) $SQLQUERY = "$SQLQUERY AND `ostype` = 'AIX'";
    if ( $rhel == "Y" ) $SQLQUERY = "$SQLQUERY AND `ostype` = 'RHEL'";
    if ( $solaris == "Y" ) $SQLQUERY = "$SQLQUERY AND `ostype` = 'solaris'";
    $result = mysql_query( $SQLQUERY )
                         or die (mysql_error()."<br>Couldn't execute query: $SQLQUERY");
    
    $nr = mysql_num_rows( $result );
    if(empty($nr)) {
      echo("<tr><td class='detail1'>No host defined</td></tr>\n");
    }
    else {
      echo ("<thead><tr><th>icon</th><th>Hostname</th><th>Serial #</th><th>OS type</th><th>OS Version</th><th>Vendor</th><th>Model</th></tr></thead>");
      echo ("<tbody>");
      $odd=1;
      while( $row = mysql_fetch_array( $result )) 
      {
        // Affecting values
        $name = $row["name"];
        $id = $row["id"];
		$ostype = $row["ostype"];
		$osvers = $row["osvers"];
		$serialno = $row["serialno"];
		$vendor = $row["vendor"];
		$model = $row["model"];
		$hostgroup = $row["Environment"];
      
        // displaying rows
		if ( $odd==1 )
		{
		  $odd=0;
		  echo("<tr class=odd>");
	    } 
		else {
		  $odd+=1;
		  echo("<tr>\n");
		}

		// getting the right icon
		$icon="images/server.gif";
		if ( $row['ostype'] == "RHEL" ) $icon="images/icon-redhat.gif";
		if ( $row['ostype'] == "CentOS" ) $icon="images/icon-centos.png";
		if ( $row['ostype'] == "Linux" ) $icon="images/icon-linux.png";
		if ( $row['ostype'] == "AIX" ) $icon="images/icon-aix.gif";
		if ( $row['ostype'] == "Solaris" ) $icon="images/icon-solaris.gif";
		if ( $row['ostype'] == "Windows" ) $icon="images/icon-windows.gif";
		if ( $row['ostype'] == "FreeBSD" ) $icon="images/icon-freebsd.gif";

			echo("  <td><img src='$icon' border='0'></td>");
		echo("	<td><a href='host-view.php?id=$id&hostgroup=$hostgroup'>$name</a></td>");
		echo("	<td>$serialno</td>");
		echo("	<td>$ostype</td>");
		echo("	<td>$osvers</td>");
		echo("	<td>$vendor</td>");
		echo("	<td>$model</td>");
      }

      mysql_free_result( $result );
      echo("</tr></tbody></table>");
    }
  ?>
 
</td></tr></table>

<? end_right_pane(); ?>
<? end_main_frame(); ?>


</body>
</html>
