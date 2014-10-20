<?php
include('MyFunctions.inc.php');

if (isset($_GET["id"])) $id = $_GET["id"]; else $id = "";

if( empty($id) )
{

?>


<html>
<head>
  <title>Identity Accounts List</title>
  <LINK REL=STYLESHEET HREF="skm.css" TYPE="text/css">
</head>
<body>

<?php start_main_frame("<a href=\"show_all_hosts.php\"> SKM </a> > SKM Admins"); ?>
<?php start_left_pane(); ?>
<?php display_menu(); ?>
<?php end_left_pane(); ?>
<?php start_right_pane(); ?>

   <fieldset><legend>SKM Admin accounts <a href="skmadmins_setup.php">[create a new account]<img src='images/add.gif' border='0'></a></legend>

   <table class='detail'>
  
    <?php

    $result = mysql_query( "SELECT * FROM `skmadmins` ORDER BY `login`" )
                         or die (mysql_error()."<br>Couldn't execute query: $query");
    
    $nr = mysql_num_rows( $result );
    if(empty($nr)) {
      echo("<tr><td class='detail1'>No Account found</td><td class='detail2'></td></tr>\n");
    }
    else {
      echo("<tr><th>Login name</th><th>First name</th><th>Last name</th><th>Options</th></tr>\n");
      while( $row = mysql_fetch_array( $result )) 
      {
        // Afecting values
        $firstname = $row["firstname"];
        $lastname = $row["lastname"];
        $login = $row["login"];
        $id = $row["id"];
      
        // displaying rows
        echo("<tr>\n");
	echo("  <td class='detail1'><img src='images/mister.png' height=\"16\" width=\"16\" vertical-align=middle>$login</td><td class='detail1'>$firstname</td><td class='detail1'>$lastname</td>\n");
	echo("  <td class='detail1'>");
	// editing & deletion of root account (id 1) is not allowed
	echo("<a href='skmadmins_setup.php?id=$id'>[ edit ]</a> <a href='skmadmins.php?id=$id&action=delete'>[ delete ]</a>");
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
  if ($_GET['action'] == "delete")
  {
  	$query = "DELETE FROM `skmadmins` WHERE `id`='$id'"; 
    mysql_query( $query ) or die (mysql_error()."<br>Couldn't execute query: $query");
    // Let's go back to the Reminder List page
    header("Location:skmadmins.php");
    echo ("account deleted, redirecting...");
    exit ();
  }
}
?>
