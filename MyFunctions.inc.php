<?php

//Start session
session_start();

//Check whether the session variable SESS_MEMBER_ID is present or not
if(!isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) == '')) {
        header("location: access-denied.php");
        exit();
}

include('config.inc.php'); // Our global configuration file
include('database.inc.php'); // Our database connectivity file

// ****************************** DISPLAY GROUP AVAILABLE ****************************************
function display_available_hosts(){
    //Display the selection box for the groups
    $result = mysql_query( "SELECT DISTINCT `Environnement` FROM `hosts` ORDER BY `name` " )
                             or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      echo 'No host found...';
    }
    else {
      echo '<select class="list" name="host">';
      echo '<option selected value="0">Please select a host</option>';
      while( $row = mysql_fetch_array( $result ))
      {
        // Afecting values
        $name = $row["name"];
		$id = $row["id"];
        echo '<option value='.$id.'>'.$name.'</option>';
      }
      echo '</select>';
      mysql_free_result( $result );
    }
}


// ****************************** DISPLAY GROUP AVAILABLE ****************************************
function display_available_groups($id_hostgroup){

    //Display the selection box for the groups
    $result = mysql_query( "SELECT * FROM `groups` ORDER BY `name` " )
                             or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      echo 'No group found...';
    }
    else {
      echo '<select class="list" name="group">';
      echo '<option selected value="1">Please select a group</option>';
      while( $row = mysql_fetch_array( $result ))
      {
        // Afecting values
        $name = $row["name"];
	$id = $row["id"];
	if ( $id == $id_hostgroup ) 
	{
        	echo '<option selected value='.$id.'>'.$name.'</option>';
	} else {
        	echo '<option value='.$id.'>'.$name.'</option>';
	}
      }
      echo '</select>';
      mysql_free_result( $result );
    }
}
function get_group_name($id_hostgroup){

    //Display the selection box for the groups
    $result = mysql_query( "SELECT name FROM `groups` WHERE `id`='$id_hostgroup' " )
                             or die (mysql_error()."<br>Couldn't execute query: $query");
    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      echo 'No group found...';
    }
    else {
      $row = mysql_fetch_array( $result );
      mysql_free_result( $result );
      return $row['name'];
    }

}

function get_direction_name($id){

    //Display the selection box for the groups
    $result = mysql_query( "SELECT name FROM `direction` WHERE `id`='$id' " )
                             or die (mysql_error()."<br>Couldn't execute query: $query");
    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      echo 'No direction found...';
    }
    else {
      $row = mysql_fetch_array( $result );
      mysql_free_result( $result );
      return $row['name'];
    }

}

// ****************************** DISPLAY KEY AVAILABLE ****************************************
function display_availables_keys(){
    //Display the selection box for the keys
    $result = mysql_query( "SELECT * FROM `keys` ORDER BY `name` " )
                             or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      echo 'No key found...';
    }
    else {
      echo '<select class="list" name="key">';
      echo '<option selected value="0">Please select a key</option>';
      while( $row = mysql_fetch_array( $result ))
      {
        // Afecting values
        $name = $row["name"];
	$id = $row["id"];
        echo '<option value='.$id.'>'.$name.'</option>';
      }
      echo '</select>';
      mysql_free_result( $result );
    }
}

// ****************************** DISPLAY ACCOUNT AVAILABLE ****************************************
function display_availables_accounts(){
    $result = mysql_query( "SELECT * FROM `accounts` ORDER BY `name` " )
                             or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      echo 'No account found...';
    }
    else {
      echo '<select class="list" name="account">';
      while( $row = mysql_fetch_array( $result ))
      {
        // Afecting values
        $name = $row["name"];
		$id = $row["id"];
        echo '<option value='.$id.'>'.$name.'</option>';
      }
      echo '</select>';
      mysql_free_result( $result );
    }
}

// ****************************** DISPLAY keyring AVAILABLE ****************************************
function display_availables_keyrings(){
    $result = mysql_query( "SELECT * FROM `keyrings` ORDER BY `name` " )
                             or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(!empty($nr)) {
      echo '<select class="list" name="keyring">';
      echo '<option selected value="0">Please select a keyring</option>';
      while( $row = mysql_fetch_array( $result ))
      {
        // Afecting values
        $name = $row["name"];
	$id = $row["id"];
        echo '<option value='.$id.'>'.$name.'</option>';
      }
      echo '</select>';
      mysql_free_result( $result );
    }
}


// ****************************** GET KEY ID ****************************************
function get_key_id($name){
    $result = mysql_query( "SELECT * FROM `keys` WHERE `name` = '$name' " )
		or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      echo 'No key found...';
    }
    else {
      $row = mysql_fetch_array( $result );
      mysql_free_result( $result );
      return $row['id'];
    }
}

// ****************************** GET KEY NAME ****************************************
function get_key_name($id){
    $result = mysql_query( "SELECT * FROM `keys` WHERE `id` = '$id' " )
		or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      echo 'No key found...';
    }
    else {
      $row = mysql_fetch_array( $result );
      mysql_free_result( $result );
      return $row['name'];
    }
}

// ****************************** GET ACCOUNT NAME ****************************************
function get_account_name($id){
    $result = mysql_query( "SELECT * FROM `accounts` WHERE `id` = '$id' " )
		or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      echo 'No account found...';
    }
    else {
      $row = mysql_fetch_array( $result );
      mysql_free_result( $result );
      return $row['name'];
    }
}

// ****************************** GET ACCOUNT NAME ****************************************
function get_account_uid($id){
    $result = mysql_query( "SELECT UID FROM `accounts` WHERE `id` = '$id' " )
		or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      echo 'No account found...';
    }
    else {
      $row = mysql_fetch_array( $result );
      mysql_free_result( $result );
      return $row['UID'];
    }
}

// ****************************** GET ACCOUNT NAME ****************************************
function get_keyring_name($id){
    $result = mysql_query( "SELECT * FROM `keyrings` WHERE `id` = '$id' " )
		or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(!empty($nr)) {
      $row = mysql_fetch_array( $result );
      mysql_free_result( $result );
      return $row['name'];
    }
}

// ****************************** GET ACCOUNT NAME ****************************************
function get_host_name($id){
	$query = "SELECT `name` FROM `hosts` WHERE `id` = '$id' "; 
    $result = mysql_query( $query )or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      echo 'No host found...';
    }
    else {
      $row = mysql_fetch_array( $result );
      mysql_free_result( $result );
      return $row['name'];
    }
}

// ****************************** GET ACCOUNT NAME ****************************************
function get_os_type($id){
    $query = "SELECT `ostype` FROM `hosts` WHERE `id` = '$id' "; 
    $result = mysql_query( $query )or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      echo 'No host found...';
    }
    else {
      $row = mysql_fetch_array( $result );
      mysql_free_result( $result );
      return $row['ostype'];
    }
}

// ****************************** GET ACCOUNT NAME ****************************************
function get_host_ip($id){
	$query = "SELECT `ip` FROM `hosts` WHERE `id` = '$id' "; 
    $result = mysql_query( $query )or die (mysql_error()."<br>Couldn't execute query: $query");

    $row = mysql_fetch_array( $result );
    mysql_free_result( $result );
    return $row['ip'];
}

// ****************************** GET IDENTITY id ****************************************
function get_identity_id($id_host){
	$query = "SELECT `id_identities` FROM `hosts-identities` WHERE `id_host` = '$id_host' ";
    $result = mysql_query( $query )	or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      echo 'No identity found for host id '.$id_host.'... Go back to your host page, then select an identity account in the Deployment Information section.';
    }
    else {
      $row = mysql_fetch_array( $result );
      mysql_free_result( $result );
      return $row['id_identities'];
    }
}


// ****************************** GET IDENTITY NAME ****************************************
function get_identity_name($id){
	$query = "SELECT `name` FROM `identities` WHERE `id` = '$id' ";
    $result = mysql_query( $query )	or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      echo 'No identity name found with id '.$id.'...';
    }
    else {
      $row = mysql_fetch_array( $result );
      mysql_free_result( $result );
      return $row['name'];
    }
}


// ****************************** GET ACCOUNT NAME ****************************************
function get_gfile_name($id){
    $result = mysql_query( "SELECT * FROM `globalfiles` WHERE `id` = '$id' " )
		or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      echo 'No host found...';
    }
    else {
      $row = mysql_fetch_array( $result );
      mysql_free_result( $result );
      return $row['name'];
    }
}

// ****************************** GET ACCOUNT NAME ****************************************
function get_tag_name($id){
    $result = mysql_query( "SELECT * FROM `tags` WHERE `id` = '$id' " )
		or die (mysql_error()."<br>Couldn't execute query: $query");

    $nr = mysql_num_rows($result);
    if(empty($nr)) {
      echo "No tag name found with id $id...";
    }
    else {
      $row = mysql_fetch_array( $result );
      mysql_free_result( $result );
      return $row['name'];
    }
}

// ********************************* DISPLAY FRAME *****************************************
function start_main_frame($location){
    echo("<table class=navigation><tr><td class=navigation>$location</td></tr></table>\n");
    echo("<table width='100%'>\n");
    echo("  <tr valign='top'>\n");
}

function start_main_frame_view($id){
    echo("<P class=navigation>Current view : get_group_name($id)</P>\n");
    echo("<table width='100%'>\n");
    echo("  <tr valign='top'>\n");
}

function end_main_frame(){
    echo("  </tr>\n");
    echo("</table>\n");
    echo("<table class=navigation><tr><td class=foot><center>SSH Key Management SKM - v2.0</center></td></tr></table>\n");
}

function start_left_pane(){
    echo("    <td width='20%'>\n");
}

function end_left_pane(){
    echo("    </td>\n");
}

function start_right_pane(){
    echo("    <td width='80%'>\n");
}

function end_right_pane(){
    echo("    </td>\n");
}

// ********************************* DISPLAY MENY *****************************************
function display_menu(){
	echo("<center><p class=loginname>Welcome, ".$_SESSION['SESS_FIRST_NAME']." ".$_SESSION['SESS_LAST_NAME']."<br><a href=\"logout.php\">[logout]</a></p></center>\n");
    echo("      <fieldset><legend>Account Management</legend>\n");
    echo("        <a href='skmadmins.php'>SKMadmin Accounts</a><br>\n");
    echo("        <a href='accounts.php'>Unix Accounts</a><br>\n");
    echo("        <a href='identities.php'>Identities Accounts</a><br>\n");
    echo("      </fieldset>\n");
    echo("      <fieldset><legend>Access Management</legend>\n");
    echo("        <a href='keys.php'>SSH Keys</a><br>\n");
    echo("        <a href='keyrings.php'>SSH Keyrings</a><br>\n");
    echo("        <a href='keyrings.php'><img src='images/arrowbright.gif'> Management</a><br>\n");
    echo("        <a href='choose_keyring.php'><img src='images/arrowbright.gif'> Re-Deploy</a><br>\n");
    echo("      </fieldset>\n");
    echo("      <fieldset><legend>Hosts Management</legend>\n");
    echo("        <a href='hosts_setup.php'>Add new host</a><br>\n");
    // echo("        <a href='groups.php'>Add new hostgrp</a><br>\n");
    echo("      </fieldset>\n");
    echo("      <fieldset><legend>Host Groups</legend>\n");
	echo("<form name=\"hostnameSearch\" action=\"hosts-view.php\" method=\"post\">");
        echo("<input name=\"hostname\" type=\"text\" size=\"10\" value=\"$hostname\">");
        echo("<input name=\"submit\" type=\"submit\" value=\"Search host\"> </form>");
	echo("        <a href='hosts-view.php'>All Hosts</a><br>\n");
        $tags = mysql_query( "SELECT * FROM `tags` ORDER BY `name`" )
                         or die (mysql_error()."<br>Couldn't execute query: $query");

        $tags_nr = mysql_num_rows( $tags );
        if (!empty($tags_nr)) {
	//	echo("<b font-size=10pt>By Environment:<br></b>");
              while( $tags_row = mysql_fetch_array( $tags ))
              {
                        // Afecting values
                        $name = $tags_row["name"];
			$tag_id = $tags_row["id"];
		echo("          <a href=\"hosts-view-tags.php?tagid=$tag_id\"><img src='images/arrowbright.gif'> $name</a><br>\n");
                }
                mysql_free_result( $tags );
        }

    echo("      </fieldset>\n");
    //echo("      <fieldset><legend>Global File</legend>\n");
    //echo("        <a href='globalfile.php'>global file list</a><br>\n");
    //echo("      </fieldset>\n");
    echo("      <fieldset><legend>Reports</legend>\n");
    //echo("        <a href='view_keys.php'>Key String value list</a><br>\n");
    echo("        <a href='serial_search.php'>SerialNo Search</a><br>\n");
    echo("        <a href='model_search.php'>Model # Search</a><br>\n");
    echo("        <a href='search_key_securities.php'>Search Key Securities</a><br>\n");
    echo("        <a href='search_keyring_securities.php'>Search Keyring Securities</a><br>\n");
    echo("      </fieldset>\n");
}

function prepare_authorizedkey_file($id,$id_account){
    unlink("/tmp/authorized_keys");
        // Initialising variables
        $hostname = get_host_name($id);
        $account_name = get_account_name($id_account);
        $now = date("Ymd-His");

	$message="";
	$authorized_keys="";

		// -----------------------------------------------
	        // We get all keys associated with current keyring
		// -----------------------------------------------
                $keyrings = mysql_query( "SELECT * FROM `hak` WHERE `id_host` = '$id' and `id_account` ='$id_account'
                                          and `id_keyring` != '0'" )
                         or die (mysql_error()."<br>Couldn't execute query: $query");
                $nr_keyrings = mysql_num_rows( $keyrings );
                if(!empty($nr_keyrings)) {
                        while ( $keyringrow = mysql_fetch_array($keyrings))
                        {
                                $id_keyring = $keyringrow['id_keyring'];
                                $name_keyring = get_keyring_name($id_keyring);
                                //$message.="Deploying keyring $name_keyring with id $id_keyring<br>\n";

                                // Getting the keys associated to current keyring
                                //echo("Select from keyrings-keys id_keyring=$id_keyring\n");
                                $keys = mysql_query( "SELECT * FROM `keyrings-keys` WHERE `id_keyring` = '$id_keyring'" )
                                        or die (mysql_error()."<br>Couldn't execute query: $query");
                                $nr_keys = mysql_num_rows( $keys );
                                if (!empty($nr_keys)) {
                                        while ( $keyrow = mysql_fetch_array($keys))
                                        {
                                                $key_id = $keyrow['id_key'];
                                                $key_name = get_key_name($key_id);
                                                $message.="  <img src='images/ok.gif'>adding key $key_name (id $key_id)<br>\n";


                                                // Getting key value of current key
                                                $keyvalue = mysql_query( "SELECT * FROM `keys` WHERE `id` = '$key_id'" )
                                                        or die (mysql_error()."<br>Couldn't execute query: $query");
                                                $nr_keyvalue = mysql_num_rows( $keyvalue );
                                                if (!empty($nr_keyvalue)) {
                                                        while ($keyvaluerow  = mysql_fetch_array($keyvalue))
                                                        {
                                                                $singlekey = trim($keyvaluerow['key']);
                                                                $authorized_keys.= "$singlekey\n";
                                                        }
                                                } // end if
                                        } // end while keyrow
                                        mysql_free_result($keys);
                                } //end if
                        } // end while keyringrow
                        mysql_free_result($keyrings);
                } // end if

		// -----------------------------------------------
	        // We get all keys associated with current account/host
		// -----------------------------------------------
                $keys = mysql_query( "SELECT * FROM `hak` WHERE `id_host` = '$id' and `id_account` ='$id_account'
                                          and `id_key` != '0'" )
                         or die (mysql_error()."<br>Couldn't execute query: $query");
                $nr_keys = mysql_num_rows( $keys );
                if(!empty($nr_keys)) {
                        while ( $keyrow = mysql_fetch_array($keys))
                        {
                           $key_id = $keyrow['id_key'];
                           $key_name = get_key_name($key_id);
                           $message.="  <img src='images/ok.gif'>adding key $key_name (id $key_id)<br>\n";

                           // Getting key value of current key
                           $keyvalue = mysql_query( "SELECT * FROM `keys` WHERE `id` = '$key_id'" )
                                       or die (mysql_error()."<br>Couldn't execute query: $query");
                           $nr_keyvalue = mysql_num_rows( $keyvalue );
                           if (!empty($nr_keyvalue)) {
                              while ($keyvaluerow  = mysql_fetch_array($keyvalue))
                              {
                                $singlekey = $keyvaluerow['key'];
                                $authorized_keys.= "$singlekey\n";
                              }
                            } // end if
                          } // end while keyrow
                          mysql_free_result($keys);
                  } //end if

        $handle = fopen("/tmp/authorized_keys","w");
        fputs($handle,$authorized_keys);
        fclose($handle);

	return $message;
}

Function view_authorizedkey_file($id,$id_account){
        // Initialising variables
        $hostname = get_host_name($id);
        $account_name = get_account_name($id_account);
        $now = date("Ymd-His");

	$message="";
	$authorized_keys="";

		// -----------------------------------------------
	        // We get all keys associated with current keyring
		// -----------------------------------------------
                $keyrings = mysql_query( "SELECT * FROM `hak` WHERE `id_host` = '$id' and `id_account` ='$id_account'
                                          and `id_keyring` != '0'" )
                         or die (mysql_error()."<br>Couldn't execute query: $query");
                $nr_keyrings = mysql_num_rows( $keyrings );
                if(!empty($nr_keyrings)) {
                        while ( $keyringrow = mysql_fetch_array($keyrings))
                        {
                                $id_keyring = $keyringrow['id_keyring'];
                                $name_keyring = get_keyring_name($id_keyring);
                                //$message.="Deploying keyring $name_keyring with id $id_keyring<br>\n";

                                // Getting the keys associated to current keyring
                                //echo("Select from keyrings-keys id_keyring=$id_keyring\n");
                                $keys = mysql_query( "SELECT * FROM `keyrings-keys` WHERE `id_keyring` = '$id_keyring'" )
                                        or die (mysql_error()."<br>Couldn't execute query: $query");
                                $nr_keys = mysql_num_rows( $keys );
                                if (!empty($nr_keys)) {
                                        while ( $keyrow = mysql_fetch_array($keys))
                                        {
                                                $key_id = $keyrow['id_key'];
                                                $key_name = get_key_name($key_id);
                                                $message.="  <img src='images/ok.gif'>adding key $key_name (id $key_id)<br>\n";


                                                // Getting key value of current key
                                                $keyvalue = mysql_query( "SELECT * FROM `keys` WHERE `id` = '$key_id'" )
                                                        or die (mysql_error()."<br>Couldn't execute query: $query");
                                                $nr_keyvalue = mysql_num_rows( $keyvalue );
                                                if (!empty($nr_keyvalue)) {
                                                        while ($keyvaluerow  = mysql_fetch_array($keyvalue))
                                                        {
                                                                $singlekey = $keyvaluerow['key'];
                                                                $authorized_keys.= "$singlekey<br>\n";
                                                        }
                                                } // end if
                                        } // end while keyrow
                                        mysql_free_result($keys);
                                } //end if
                        } // end while keyringrow
                        mysql_free_result($keyrings);
                } // end if

		// -----------------------------------------------
	        // We get all keys associated with current account/host
		// -----------------------------------------------
                $keys = mysql_query( "SELECT * FROM `hak` WHERE `id_host` = '$id' and `id_account` ='$id_account'
                                          and `id_key` != '0'" )
                         or die (mysql_error()."<br>Couldn't execute query: $query");
                $nr_keys = mysql_num_rows( $keys );
                if(!empty($nr_keys)) {
                        while ( $keyrow = mysql_fetch_array($keys))
                        {
                           $key_id = $keyrow['id_key'];
                           $key_name = get_key_name($key_id);
                           $message.="  <img src='images/ok.gif'>adding key $key_name (id $key_id)<br>\n";

                           // Getting key value of current key
                           $keyvalue = mysql_query( "SELECT * FROM `keys` WHERE `id` = '$key_id'" )
                                       or die (mysql_error()."<br>Couldn't execute query: $query");
                           $nr_keyvalue = mysql_num_rows( $keyvalue );
                           if (!empty($nr_keyvalue)) {
                              while ($keyvaluerow  = mysql_fetch_array($keyvalue))
                              {
                                $singlekey = $keyvaluerow['key'];
                                $authorized_keys.= "$singlekey\n";
                              }
                            } // end if
                          } // end while keyrow
                          mysql_free_result($keys);
                  } //end if

        $handle = fopen("/tmp/authorized_keys","w");
        fputs($handle,$authorized_keys);
        fclose($handle);

	return $authorized_keys;
}
	


function arr_diff( $f1 , $f2 , $show_equal = 0 )
{

        $c1         = 0 ;                   # current line of left
        $c2         = 0 ;                   # current line of right
        $max1       = count( $f1 ) ;        # maximal lines of left
        $max2       = count( $f2 ) ;        # maximal lines of right
        $outcount   = 0;                    # output counter
        $hit1       = "" ;                  # hit in left
        $hit2       = "" ;                  # hit in right

        while ( 
                $c1 < $max1                 # have next line in left
                and                 
                $c2 < $max2                 # have next line in right
                and 
                ($stop++) < 1000            # don-t have more then 1000 ( loop-stopper )
                and 
                $outcount < 20              # output count is less then 20
              )
        {
            /**
            *   is the trimmed line of the current left and current right line
            *   the same ? then this is a hit (no difference)
            */  
            if ( trim( $f1[$c1] ) == trim ( $f2[$c2])  )    
            {
                /**
                *   add to output-string, if "show_equal" is enabled
                */
                $out    .= ($show_equal==1) 
                         ?  formatline ( ($c1) , ($c2), "=", $f1[ $c1 ] ) 
                         : "" ;
                /**
                *   increase the out-putcounter, if "show_equal" is enabled
                *   this ist more for demonstration purpose
                */
                if ( $show_equal == 1 )  
                { 
                    $outcount++ ; 
                }
                
                /**
                *   move the current-pointer in the left and right side
                */
                $c1 ++;
                $c2 ++;
            }

            /**
            *   the current lines are different so we search in parallel
            *   on each side for the next matching pair, we walk on both 
            *   sided at the same time comparing with the current-lines
            *   this should be most probable to find the next matching pair
            *   we only search in a distance of 10 lines, because then it
            *   is not the same function most of the time. other algos
            *   would be very complicated, to detect 'real' block movements.
            */
            else
            {
                
                $b      = "" ;
                $s1     = 0  ;      # search on left
                $s2     = 0  ;      # search on right
                $found  = 0  ;      # flag, found a matching pair
                $b1     = "" ;      
                $b2     = "" ;
                $fstop  = 0  ;      # distance of maximum search

                #fast search in on both sides for next match.
                while ( 
                        $found == 0             # search until we find a pair
                        and 
                        ( $c1 + $s1 <= $max1 )  # and we are inside of the left lines
                        and 
                        ( $c2 + $s2 <= $max2 )  # and we are inside of the right lines
                        and     
                        $fstop++  < 10          # and the distance is lower than 10 lines
                      )
                {

                    /**
                    *   test the left side for a hit
                    *
                    *   comparing current line with the searching line on the left
                    *   b1 is a buffer, which collects the line which not match, to 
                    *   show the differences later, if one line hits, this buffer will
                    *   be used, else it will be discarded later
                    */
                    #hit
                    if ( trim( $f1[$c1+$s1] ) == trim( $f2[$c2] )  )
                    {
                        $found  = 1   ;     # set flag to stop further search
                        $s2     = 0   ;     # reset right side search-pointer
                        $c2--         ;     # move back the current right, so next loop hits
                        $b      = $b1 ;     # set b=output (b)uffer
                    }
                    #no hit: move on
                    else
                    {
                        /**
                        *   prevent finding a line again, which would show wrong results
                        *
                        *   add the current line to leftbuffer, if this will be the hit
                        */
                        if ( $hit1[ ($c1 + $s1) . "_" . ($c2) ] != 1 )
                        {   
                            /**
                            *   add current search-line to diffence-buffer
                            */
                            $b1  .= formatline( ($c1 + $s1) , ($c2), "-", $f1[ $c1+$s1 ] );

                            /**
                            *   mark this line as 'searched' to prevent doubles. 
                            */
                            $hit1[ ($c1 + $s1) . "_" . $c2 ] = 1 ;
                        }
                    }



                    /**
                    *   test the right side for a hit
                    *
                    *   comparing current line with the searching line on the right
                    */
                    if ( trim ( $f1[$c1] ) == trim ( $f2[$c2+$s2])  )
                    {
                        $found  = 1   ;     # flag to stop search
                        $s1     = 0   ;     # reset pointer for search
                        $c1--         ;     # move current line back, so we hit next loop
                        $b      = $b2 ;     # get the buffered difference
                    }
                    else
                    {   
                        /**
                        *   prevent to find line again
                        */
                        if ( $hit2[ ($c1) . "_" . ( $c2 + $s2) ] != 1 )
                        {
                            /**
                            *   add current searchline to buffer
                            */
                            $b2   .= formatline ( ($c1) , ($c2 + $s2), "+", $f2[ $c2+$s2 ] );

                            /**
                            *   mark current line to prevent double-hits
                            */
                            $hit2[ ($c1) . "_" . ($c2 + $s2) ] = 1;
                        }

                     }

                    /**
                    *   search in bigger distance
                    *
                    *   increase the search-pointers (satelites) and try again
                    */
                    $s1++ ;     # increase left  search-pointer
                    $s2++ ;     # increase right search-pointer  
                }

                /**
                *   add line as different on both arrays (no match found)
                */
                if ( $found == 0 )
                {
                    $b  .= formatline ( ($c1) , ($c2), "-", $f1[ $c1 ] );
                    $b  .= formatline ( ($c1) , ($c2), "+", $f2[ $c2 ] );
                }

                /** 
                *   add current buffer to outputstring
                */
                $out        .= $b;
                $outcount++ ;       #increase outcounter

                $c1++  ;    #move currentline forward
                $c2++  ;    #move currentline forward

                /**
                *   comment the lines are tested quite fast, because 
                *   the current line always moves forward
                */

            } /*endif*/

        }/*endwhile*/

        return $out;

}/*end func*/

    /**
    *   callback function to format the diffence-lines with your 'style'
    */
function formatline( $nr1, $nr2, $stat, &$value )  #change to $value if problems
{
        if ( trim( $value ) == "" )
        {
            return "";
        }

        switch ( $stat )
        {
            case "=":
                return $nr1. " : $nr2 : = ".htmlentities( $value )  ."<br>";
            break;

            case "+":
                //return $nr1. " : $nr2 : + <img src='images/expand.gif'>".htmlentities( $value )  ."</font><br>";
                return "<img src='images/expand.gif'>".htmlentities( $value )  ."</font><br>";
            break;

            case "-":
                //return $nr1. " : $nr2 : - <font color='red' >".htmlentities( $value )  ."</font><br>";
                return "<img src='images/error.gif'>".htmlentities( $value )  ."</font><br>";
            break;
        }

} 


function display_key($id_host,$id_account,$id_key,$hostgroup,$ident_level){
       // Afecting values
       //$name = $keyrow["name"];
       $name_key = get_key_name($id_key);

       // Displaying rows
       echo("<tr>\n");
       echo("  <td class='$ident_level'><img src='images/key_little.gif' border=0 >$name_key ");
       // If indent_level == 2, we are displaying key within
       if ($ident_level != "detail2"){ echo("<a href='account-view.php?id=$id_host&id_account=$id_account&id_key=$id_key&hostgroup=$hostgroup&action=deleteKey'>[ Delete ]</a></td>\n"); }
       echo("</tr>\n");
}


// ********************************* DISPLAY KEYRING *****************************************
function display_keyring($id_host,$id_account,$id_keyring,$hostgroup,$ident_level,$display){
	// ident_level : level of identation to display element
	// display (Y/N) : display keys in current keyring


        $name_keyring = get_keyring_name($id_keyring);

        // Displaying rows
	if ( $display == "N" )
	{
        	echo("<tr>\n");
        	echo("  <td class='detail1'><a href=\"account-view.php?id=$id_host&hostgroup=$hostgroup&action=expandkeyring&id_account=$id_account&id_keyring=$id_keyring\"><img src='images/expand.gif' border='0'></a><img src='images/keyring_little.gif' border='0'>$name_keyring ");
        	echo("<a href='account-view.php?id=$id_host&id_account=$id_account&id_keyring=$id_keyring&action=deleteKeyring&hostgroup=$hostgroup'>[ Delete ]</a></td>\n");
        	echo("</tr>\n");
	} else {
        	echo("<tr>\n");
        	echo("  <td class='detail1'><a href=\"account-view.php?id=$id_host&id_account=$id_account&id_keyring=$id_keyring&action=collapsekeyring&hostgroup=$hostgroup\"><img src='images/collapse.gif' border='0'></a><img src='images/keyring_little.gif' border='0'>$name_keyring ");
        	echo("<a href='account-view.php?id=$id_host&id_account=$id_account&id_keyring=$id_keyring&action=deleteKeyring&hostgroup=$hostgroup'>[ Delete ]</a></td>\n");
        	echo("</tr>\n");


		// looking for keys
		$keys = mysql_query( "SELECT * FROM `keyrings-keys` WHERE `id_keyring` = '$id_keyring'" )
		       or die (mysql_error()."<br>Couldn't execute query: $query");
		$nr_keys = mysql_num_rows( $keys );
		if(empty($nr_keys)) {
			//echo ("<tr><td class='$ident_level'>No keys associated</td><td class='$ident_level'></td></tr>\n");
			echo ("<tr><td class='$ident_level'>No keys associated</td></tr>\n");
		} else {
			while ( $keyrow = mysql_fetch_array($keys))
			{
				// Afecting values
				//$name = $keyrow["name"];
				$id_key = $keyrow["id_key"];
				display_key($id_host,$id_account,$id_key,$hostgroup,$ident_level);
			} // end while
			mysql_free_result( $keys );
		} //end if
	} //end if
} 


function display_command_output($legend,$exit_status,$output,$command,$severity){
	if ( $exit_status == 0 ) {

		//echo "<fieldset class=cmdok>";
		//echo "<legend class=cmdok>$legend : <img src='images/ok.gif'></legend>";
		//echo "Command :<br>$command<br><br>Output :<br>";
		//echo implode('<br />', $output);
		//echo "</fieldset>";

		echo "<img src='images/ok.gif'>$legend<br>\n";
	} else {
		echo "<fieldset class=cmd$severity>";
		echo "<legend class=cmd$severity>$legend : $severity</legend>";
		echo "Command :<br>$command<br><br>Output :<br>";
/* 		print_r($output); */
		echo implode('<br />', $output);
		echo "</fieldset>";
	}	
}

// ********************************* TEST CONNECTION *****************************************
function test_connection($host,$identity_name,$account_name){
	$output = array();
	$command = "ssh -vvv -o BatchMode=yes -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no -i /tmp/$identity_name-id $identity_name@$host \"ls -l\" 2>&1";
	exec($command,$output,$exit_status);
	display_command_output("Test connection",$exit_status,$output,$command,error);
	return $exit_status;
}

// ********************************* TEST PRESENCE *****************************************

// ********************************* DEPLOY GLOBALFILE *****************************************
function deploy_globalfile($id_file,$id_host){
	$hostname = get_host_name($id_host);
	$hostip = get_host_ip($id_host);
	
        $gfiles = mysql_query( "SELECT * FROM `globalfiles` WHERE `id` = '$id_file'" )
                    or die (mysql_error()."<br>Couldn't execute query: $query");
        $nr_gbfiles = mysql_num_rows( $gfiles );
        if(!empty($nr_gbfiles)) {

		// Preparing file,path, etc...
		$gfilerow = mysql_fetch_array($gfiles);
		$path=$gfilerow['path'];
		$name=$gfilerow['name'];
		//$filecontents=$gfilerow['text'];
		$localfile=$gfilerow['localfile'];
		$now=date("Ymd-His");

		// Testing connectivity... 
		if ( test_connection($hostname) != "OK" )
		{
			$message.="<img src='images/error.gif'>Connection failed. Please see output below.<br>\n";
			return $message;
		} else {
			$message.="<img src='images/ok.gif'>SSH connection is OK.<br>\n";
		}

		// Testing presence of file
		if ( test_presence($hostname,$path/$name) == 1 )
		{
			$message.="<img src='images/warning.gif'>$path/$name was not found...<br>\n";
		} else {
			// File is present, we try to back it up
			// Archiving current file
			$output = shell_exec("ssh ".$GLOBALS['sudousr']."@$hostname cp $path/$name $path/$name.$now 2>&1");
			if (empty($output)){
				// Archiving is OK
				$message.="<img src='images/ok.gif'>$path/$name has been backup successfully.<br>\n";
			} else {
				$message.="<img src='images/error.gif'>$path/$name could not be backed up.<br>\n";
				return $message;
			}
		}

		// Deploying
		$output = shell_exec("scp $localfile ".$GLOBALS['sudousr']."@$hostname:$path/$name 2>&1");

		if (empty($output)){
		// File was correctly transfered
			$message.="<img src='images/ok.gif'>$path/$name was correctly updated.<br>\n";
			$output = shell_exec("ssh ".$GLOBALS['sudousr']."@$hostname chmod 440 $path/$name 2>&1");
			if (empty($output)){
				$message.="<img src='images/ok.gif'>Permission changed successfully to 440 for file $path/$name.<br>\n";
			} else {
				$message.="<img src='images/error.gif'>Could not change permission to 440 for file $path/$name.<br>\n";
			}
		} else {
			$message.="<img src='images/error.gif'>An error occured during the update.<br>\n";
		}
	} else {
		$message.="<img src='images/error.gif'>No global file found with id $id<br>\n";
	}
	return $message;
}

?>
