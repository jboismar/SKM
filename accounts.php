<?php
include('MyFunctions.inc.php');

if (isset($_GET["id"])) $id = $_GET["id"]; else $id = "";

if( empty($id) )
{

?>


<html>
<head>
  <title>Accounts List</title>
  <LINK REL=STYLESHEET HREF="skm.css" TYPE="text/css">
</head>
<body>

<?php start_main_frame("<a href=\"show_all_hosts.php\"> SKM </a> > Unix Accounts"); ?>
<?php start_left_pane(); ?>
<?php display_menu(); ?>
<?php end_left_pane(); ?>
<?php start_right_pane(); ?>

   <fieldset><legend>Accounts <a href="accounts_setup.php">[create a new account]<img src='images/add.gif' border='0'></a></legend>

   <table class='detail'>
  
    <?php

    $result = mysql_query( "SELECT * FROM `accounts` ORDER BY `UID`" )
                         or die (mysql_error()."<br>Couldn't execute query: $query");
    
    $nr = mysql_num_rows( $result );
    if(empty($nr)) {
      echo("<tr><td class='detail1'>No Account found</td><td class='detail2'></td></tr>\n");
    }
    else {
      echo("<tr><th>Account Name</th><th>UID</th><th>GroupName</th><th>GID</th><th>Home directory</th><th>GECOS</th><th>Actions</th></tr>\n");
      while( $row = mysql_fetch_array( $result )) 
      {
        // Afecting values
        $name = $row["name"];
        $UID = $row["UID"];
        $GID = $row["GID"];
        $GECOS = $row["GECOS"];
        $GIDname = $row["GIDname"];
        $homedir = $row["homedir"];
        $id = $row["id"];
      
        // displaying rows
        echo("<tr>\n");
	echo("  <td class='detail1'><img src='images/mister.png' height=\"16\" width=\"16\" vertical-align=middle>$name</td><td class='detail1'>$UID</td><td class='detail1'>$GIDname</td><td class='detail1'>$GID</td><td class='detail1'>$homedir</td><td class='detail1'>$GECOS</td>\n");
	echo("  <td class='detail1'>");
	// editing & deletion of root account (id 1) is not allowed
	if($id > 1)
	{
	  echo("<a href='accounts_setup.php?id=$id'>[ edit ]</a> <a href='accounts.php?id=$id&action=delete'>[ delete ]</a>");
	} else {
	  echo("None allowed</a>");
	}
	echo("</td>\n");
	echo("</tr>\n");
      }
      mysql_free_result( $result );
    }
  
    //print("<a href=\"accounts_setup.php\">Click here to add an account</a><img src='images/add.gif' border='0'>");?>
   </table>
  </fieldset>

<? end_right_pane(); ?>
<? end_main_frame(); ?>

  
</body>
</html>

  <?php
}
else
{
  // deletion of root account (id 1) is not allowed
  if (($_GET['action'] == "delete") && ($id > 1))
  {
    mysql_query( "DELETE FROM `accounts` WHERE `id`='$id'" );
    mysql_query( "DELETE FROM `hosts-accounts` WHERE `id-account`='$id'" );
    // Let's go back to the Reminder List page
    header("Location:accounts.php");
    echo ("account deleted, redirecting...");
    exit ();
  }
}
?>
