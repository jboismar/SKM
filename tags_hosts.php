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
  <title>SKM - Assign tags to host</title>
  <LINK REL=STYLESHEET HREF="skm.css" TYPE="text/css">
</head>
<body>

<?php

  $hostname = get_host_name($id);
  
  start_main_frame("<a href=\"show_all_hosts.php\"> SKM </a> > <a href=\"host-view.php?hostgroup=$hostgroup&id=$id\">$hostname</a> > Assign tags"); 
  start_left_pane(); 
  display_menu(); 
  end_left_pane(); 
  start_right_pane(); 
  
  // -------------- Host details ---------------
  echo("<fieldset><legend>Currently assigned tags</legend>");
    
	// We list current assigned tags
	$result_tags = mysql_query( "SELECT * FROM `hosts-tags` where `id-hosts` like '$id' ")
		or die (mysql_error()."<br>Couldn't execute query: $query");

	$nr = mysql_num_rows($result_tags);
	if(! empty($nr)) {

		echo("<table class=detail>");
		echo("<tr><th>Tag name</th><th>actions</th></tr>");

		while( $row_tag = mysql_fetch_array( $result_tags ))
      		{
			echo "<tr><td>".get_tag_name($row_tag['id-tags'])."</td><td><a href=\"tags_hosts_remove.php?id=".$id."&hostgroup=".$hostgroup."&tag_id=".$row_tag['id-tags']."\"> [delete]</a></TD></TR>";
		}
		echo("</table>");
	}

	echo("</fieldset>");
	
  	echo("<fieldset><legend>Assign new tags</legend>");


    echo '<form name="assignTags" action="tags_hosts.php" method="post">';
    //Display the selection box for the groups
    $result = mysql_query( "SELECT * FROM `tags` ORDER BY `name` " )
                             or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      echo "<input name=\"id_tags\" type=\"hidden\" value=\"X\">";
    } else {
      echo '<select class="list" name="id_tags">';
      echo '<option selected value="X">Please select an existing tag</option>';

      while( $row = mysql_fetch_array( $result ))
      {
		// Afecting values
		$tagname = $row["name"];
		$id_tags = $row["id"];
		echo '<option value='.$id_tags.'>'.$tagname.'</option>';
      }
      echo '</select>';
      echo '<br><br>OR<br>';
    }
      
      echo "<br> create a new tag : <input name=\"new_tag\" type=\"text\" size=\"50\"><br>";
      echo "<input name=\"step\" type=\"hidden\" value=\"1\">";
      echo "<input name=\"id_host\" type=\"hidden\" value=\"$id\">";
      echo "<input name=\"hostgroup\" type=\"hidden\" value=\"$hostgroup\">";
      echo "<br><input name=\"submit\" type=\"submit\" value=\"assign to $hostname\">";
      echo '</form>';

      mysql_free_result( $result );
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
    $id_tags = $_POST['id_tags'];
    $new_tag = $_POST['new_tag'];
    $hostgroup = $_POST['hostgroup'];

    // Did we select an existing tag or is it a new one ?
    if ( $id_tags != 'X' )
    {
	$query = "insert into `hosts-tags` (`id-hosts`,`id-tags` ) VALUES ('$id_host','$id_tags')";
    	$result = mysql_query( $query ) or die (mysql_error()."<br>Couldn't execute query: $query");
    } else {

    		// We check if tags already exists
    		$query = "SELECT * FROM `tags` where `name` like '$new_tag'";	
    		$result = mysql_query( $query ) or die (mysql_error()."<br>Couldn't execute query: $query");
    		$nr = mysql_num_rows($result);
    		if(empty($nr)) {
    			// We start to create the tag in the table 
    			$query = "insert into `tags` (`name` ) values ( '$new_tag' )";
    			$result = mysql_query( $query ) or die (mysql_error()."<br>Couldn't execute query: $query");
    
    				// We query the table to get the id of this new tag
    			$id_tag = mysql_insert_id();
    		} else {
   			// tag already exist, we get its id
			$row = mysql_fetch_array( $result );
			$id_tag = $row['id'];
			echo "A tag $new_tag already exists and has a tag id of $id_tag, using it.";
    		}

    		// We assign this new tags to current host 
    		$query = "insert into `hosts-tags` (`id-hosts`,`id-tags` ) VALUES ('$id_host','$id_tag')";
    		$result = mysql_query( $query ) or die (mysql_error()."<br>Couldn't execute query: $query");
    }

     header("Location:tags_hosts.php?hostgroup=$hostgroup&id=$id_host");
     exit ();
} 
?>

