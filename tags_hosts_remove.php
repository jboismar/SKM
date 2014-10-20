<?php
include('MyFunctions.inc.php');

if (isset($_GET["id"])) $host_id = $_GET["id"]; else $id = "";
if (isset($_GET["tag_id"])) $tag_id = $_GET["tag_id"]; else $tag_id = "";
if (isset($_GET["hostgroup"])) $hostgroup = $_GET["hostgroup"]; else $hostgroup = "";

if ( !empty($host_id) )
{
	if ( !empty($tag_id))
	{
		//echo "trying to delete id $host_id and tag_id $tag_id and hostgroup $hostgroup";
    		mysql_query( "DELETE FROM `hosts-tags` WHERE `id-hosts`='$host_id' and `id-tags`='$tag_id'" )
			or die (mysql_error()."<br>Couldn't execute query: $query");
	}
}
// Let's go back to where we came from
header("Location:tags_hosts.php?hostgroup=$hostgroup&id=$host_id");
exit ();
?>
