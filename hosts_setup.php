<?php include('MyFunctions.inc.php');

$name = "";
$ip = "";
$Environment = "";
// Setting all variables 
$serialno = "";
$ostype = "";
$osvers = "";

if (isset($_POST["step"])) $step = $_POST["step"]; else $step = "";


if($step != '1')
{
	if (isset($_GET["id"])) $id = $_GET["id"]; 
	
	if (!empty($id))
	{
		// We modify an existing reminder
		$result = mysql_query( "SELECT * FROM `hosts` where `id`='$id'" )
				or die (mysql_error()."<br>Couldn't execute query: $query");
		$row = mysql_fetch_array( $result );
		$name = $row["name"];
		$ip = $row["ip"];
		$Environment = $row["Environment"];
		$ostype = $row["ostype"];
		$osvers = $row["osvers"];
		$serialno = $row["serialno"];
		$vendor = $row["vendor"];
		$model = $row["model"];

		// Extended Infos
		$TypeOfHost = $row["TypeOfHost"];
		$FrameName = $row["FrameName"];
		$NumberOfVM = $row["NumberOfVM"];
		$Goal = $row["Goal"];
		$FinSousCategorie = $row["FinSousCategorie"];
		$ClasseService = $row["ClasseService"];
		$Entity = $row["Entity"];
		$TypeOfHosting = $row["TypeOfHosting"];
		$DateIntro = $row["DateIntro"];
		$BuyOrLease = $row["BuyOrLease"];
		$CTIName = $row["CTIName"];
		$TownName = $row["TownName"];
		$NumberCPUPhys = $row["NumberCPUPhys"];
		$NumberCPUVirt = $row["NumberCPUVirt"];
		$CPUSpeed = $row["CPUSpeed"];
		$Memory = $row["Memory"];
		$DASD = $row["DASD"];
		$SanOr = $row["SanOr"];
		$SanArgent = $row["SanArgent"];
		$SanBronze = $row["SanBronze"];
		$DateDecom = $row["DateDecom"];
		$Releve = $row["Releve"];
		$TypeOfCluster = $row["TypeOfCluster"];
		$ConsoService = $row["ConsoService"];
		$Comments = $row["Comments"];
		
	}

	?>

	<html>
	<HEAD>
	<TITLE>Host Setup</TITLE>
	<LINK REL=STYLESHEET HREF="skm.css" TYPE="text/css">
	</HEAD>
	<BODY>

	<?php start_main_frame("<a href=\"show_all_hosts.php\"> SKM </a> > Add/Modify host"); ?>
	<?php start_left_pane(); ?>
	<?php display_menu(); ?>
	<?php end_left_pane(); ?>
	<?php start_right_pane(); ?>

		<center>
		<form name="setup_host" action="hosts_setup.php" method="post">

		<!-- Host info -->
		<fieldset><legend>Add / Modify a host</legend>
		<table border='0' align='center' class="host">
		 	<tr><td class="Type" width="40%">Host Name : </td><td class="Content" width="60%">
				<input name="name" size="25" type="text" maxlength="255" value="<?php echo("$name"); ?>">
			</td>
		 	<td class="Type" width="40%">IP @ : </td><td class="Content" width="60%">
				<input name="ip" size="25" type="text" maxlength="255" value="<?php echo("$ip"); ?>">
			</td></tr>

		 	<tr><td class="Type" width="40%">Environment : </td><td class="Content" width="60%">
				<input name="Environment" size="25" type="text" maxlength="255" value="<?php echo("$Environment"); ?>">
			</td>
		 	<td class="Type" width="40%">OS Type : </td><td class="Content" width="60%">
				<select class="list" name="ostype">';
      					<option selected value="Linux">Linux</option>';
      					<option value="RHEL">RHEL</option>';
      					<option value="CentOS">CentOS</option>';
      					<option value="AIX">AIX</option>';
      					<option value="Solaris">Solaris</option>';
				</select>
			</td></tr>

		 	<tr><td class="Type" width="40%">OS Version : </td><td class="Content" width="60%">
				<input name="osvers" size="25" type="text" maxlength="255" value="<?php echo("$osvers"); ?>">
			</td>
		 	<td class="Type" width="40%">Serial Number : </td><td class="Content" width="60%">
				<input name="serialno" size="25" type="text" maxlength="255" value="<?php echo("$serialno"); ?>">
			</td></tr>

		 	<tr><td class="Type" width="40%">Vendor : </td><td class="Content" width="60%">
				<input name="vendor" size="25" type="text" maxlength="255" value="<?php echo("$vendor"); ?>">
			</td>
		 	<td class="Type" width="40%">Model : </td><td class="Content" width="60%">
				<input name="model" size="25" type="text" maxlength="255" value="<?php echo("$model"); ?>">
			</td></tr>
		</table>
		<!-- Extended Info : This should be cleaned up or even entirely deleted -->
		<table border='0' align='center' class="host">
		 	<tr><td class="Type" width="40%">Type Of Host : </td><td class="Content" width="60%">
				<select name="TypeOfHost" title="Type of host">
				<option value="Instance"<?php if ("$TypeOfHost" == "Instance"){ echo "SELECTED"; }?>>Instance</option>
				<option value="Physique"<?php if ("$TypeOfHost" == "Physique"){ echo "SELECTED"; }?>>Physique</option>
				<option value="Host"<?php if ("$TypeOfHost" == "Host"){ echo "SELECTED"; }?>>Host</option>
				<option value="N/D"<?php if ("$TypeOfHost" == "N/D"){ echo "SELECTED"; }?>>N/D</option>
				</select>
			</td>
		 	<td class="Type" width="40%">Frame Name : </td><td class="Content" width="60%">
				<input name="FrameName" size="25" type="text" maxlength="255" value="<?php echo("$FrameName"); ?>">
			</td></tr>
		 	<tr><td class="Type" width="40%">Number of VM : </td><td class="Content" width="60%">
				<input name="NumberOfVM" size="25" type="text" maxlength="255" value="<?php echo("$NumberOfVM"); ?>">
			</td>
		 	<td class="Type" width="40%">Goal : </td><td class="Content" width="60%">
				<select name="Goal" title="Goal">
				<option value="Infrastructure"<?php if ("$Goal" == "Infrastructure"){ echo "SELECTED"; }?> >Infrastructure</option>
				<option value="Application"<?php if ("$Goal" == "Application"){ echo "SELECTED"; }?> >Application</option>
				<option value="Utility" <?php if ("$Goal" == "Utility"){ echo "SELECTED"; }?> >Utility</option>
				</select>
			</td></tr>
		 	<tr><td class="Type" width="40%">Fin sous categorie : </td><td class="Content" width="60%">
				<input name="FinSousCategorie" size="25" type="text" maxlength="255" value="<?php echo("$FinSousCategorie"); ?>">
			</td>
		 	<td class="Type" width="40%">Classe de service : </td><td class="Content" width="60%">
				<input name="ClasseService" size="25" type="text" maxlength="255" value="<?php echo("$ClasseService"); ?>">
			</td></tr>
		 	<tr><td class="Type" width="40%">Entity : </td><td class="Content" width="60%">
				<input name="Entity" size="25" type="text" maxlength="255" value="<?php echo("$Entity"); ?>">
			</td>
		 	<td class="Type" width="40%">Type Of Hosting : </td><td class="Content" width="60%">
				<select name="TypeOfHosting" title="TypeOfHosting">
				<option value="Hebergement"<?php if ("$TypeOfHosting" == "Hebergement"){ echo "SELECTED"; }?> >Hebergement</option>
				<option value="Distribue"<?php if ("$TypeOfHosting" == "Distribue"){ echo "SELECTED"; }?> >Distribue</option>
				</select>
			</td></tr>
		 	<tr><td class="Type" width="40%"> Date introduction : </td><td class="Content" width="60%">
				<input name="DateIntro" size="25" type="text" maxlength="255" value="<?php echo("$DateIntro"); ?>">
			</td>
		 	<td class="Type" width="40%">Buy or Lease ? : </td><td class="Content" width="60%">
				<select name="BuyOrLease" title="BuyOrLease">
				<option value="Buy" <?php if ("$BuyOrLease" == "Buy"){ echo "SELECTED"; }?> >Buy</option>
				<option value="Lease"<?php if ("$BuyOrLease" == "Lease"){ echo "SELECTED"; }?> >Lease</option>
				</select>
			</td></tr>
		 	<tr><td class="Type" width="40%">CTI Name : </td><td class="Content" width="60%">
				<input name="CTIName" size="25" type="text" maxlength="255" value="<?php echo("$CTIName"); ?>">
			</td>
		 	<td class="Type" width="40%">Town Name : </td><td class="Content" width="60%">
				<input name="TownName" size="25" type="text" maxlength="255" value="<?php echo("$TownName"); ?>">
			</td></tr>
		 	<tr><td class="Type" width="40%">Number of physical CPU : </td><td class="Content" width="60%">
				<input name="NumberCPUPhys" size="25" type="text" maxlength="255" value="<?php echo("$NumberCPUPhys"); ?>">
			</td>
		 	<td class="Type" width="40%">Number of virtual CPU : </td><td class="Content" width="60%">
				<input name="NumberCPUVirt" size="25" type="text" maxlength="255" value="<?php echo("$NumberCPUVirt"); ?>">
			</td></tr>
		 	<tr><td class="Type" width="40%">CPU speed ( in Mzh ) :</td><td class="Content" width="60%">
				<input name="CPUSpeed" size="25" type="text" maxlength="255" value="<?php echo("$CPUSpeed"); ?>">
			</td>
		 	<td class="Type" width="40%">Memory ( in MB ) : </td><td class="Content" width="60%">
				<input name="Memory" size="25" type="text" maxlength="255" value="<?php echo("$Memory"); ?>">
			</td></tr>
		 	<tr><td class="Type" width="40%"> DASD ( in GB ) :</td><td class="Content" width="60%">
				<input name="DASD" size="25" type="text" maxlength="255" value="<?php echo("$DASD"); ?>">
			</td>
		 	<td class="Type" width="40%"> SanOr ( in GB ) : </td><td class="Content" width="60%">
				<input name="SanOr" size="25" type="text" maxlength="255" value="<?php echo("$SanOr"); ?>">
			</td></tr>
		 	<tr><td class="Type" width="40%"> SanArgent ( in GB ) :</td><td class="Content" width="60%">
				<input name="SanArgent" size="25" type="text" maxlength="255" value="<?php echo("$SanArgent"); ?>">
			</td>
		 	<td class="Type" width="40%"> SanBronze ( in GB ) : </td><td class="Content" width="60%">
				<input name="SanBronze" size="25" type="text" maxlength="255" value="<?php echo("$SanBronze"); ?>">
			</td></tr>
		 	<tr><td class="Type" width="40%"> Date Decomission :</td><td class="Content" width="60%">
				<input name="DateDecom" size="25" type="text" maxlength="255" value="<?php echo("$DateDecom"); ?>">
			</td>
		 	<td class="Type" width="40%"> Releve : </td><td class="Content" width="60%">
				<input name="Releve" size="25" type="text" maxlength="255" value="<?php echo("$Releve"); ?>">
			</td></tr>
		 	<tr><td class="Type" width="40%"> TypeOfCluster :</td><td class="Content" width="60%">
				<input name="TypeOfCluster" size="25" type="text" maxlength="255" value="<?php echo("$TypeOfCluster"); ?>">
			</td>
		 	<td class="Type" width="40%"> Conso Service : </td><td class="Content" width="60%">
				<input name="ConsoService" size="25" type="text" maxlength="255" value="<?php echo("$ConsoService"); ?>">
			</td></tr>
			<tr><td class="Type" width="40%"> Comments : </td><td class="Content" width="60%" colspan=3><textarea cols="110" rows="5" name="Comments"><?php echo("$Comments"); ?> </textarea></td></tr>
		</table>
		
		</fieldset>



                <center>
                  <input name="step" type="hidden" value="1">
                  <input name="id" type="hidden" value="<?php echo("$id");?>">
                  <input name="submit" type="submit" value="add/modify">
                </center>

		</form>
		</center>

	<? end_right_pane(); ?>
	<? end_main_frame(); ?>


	</body>
	</html>

	<?php
}
else
{
	$id = $_POST['id'];
	$name = $_POST["name"];
	$ip = $_POST["ip"];
	$Environment = $_POST["Environment"];
	$ostype = $_POST["ostype"];
	$osvers = $_POST["osvers"];
	$serialno = $_POST["serialno"];
	$vendor = $_POST["vendor"];
	$model = $_POST["model"];

	// Extended Infos
	$TypeOfHost = $_POST["TypeOfHost"];
	$FrameName = $_POST["FrameName"];
	$NumberOfVM = $_POST["NumberOfVM"];
	$Goal = $_POST["Goal"];
	$FinSousCategorie = $_POST["FinSousCategorie"];
	$ClasseService = $_POST["ClasseService"];
	$Entity = $_POST["Entity"];
	$TypeOfHosting = $_POST["TypeOfHosting"];
	$DateIntro = $_POST["DateIntro"];
	$BuyOrLease = $_POST["BuyOrLease"];
	$CTIName = $_POST["CTIName"];
	$TownName = $_POST["TownName"];
	$NumberCPUPhys = $_POST["NumberCPUPhys"];
	$NumberCPUVirt = $_POST["NumberCPUVirt"];
	$CPUSpeed = $_POST["CPUSpeed"];
	$Memory = $_POST["Memory"];
	$DASD = $_POST["DASD"];
	$SanOr = $_POST["SanOr"];
	$SanArgent = $_POST["SanArgent"];
	$SanBronze = $_POST["SanBronze"];
	$DateDecom = $_POST["DateDecom"];
	$Releve = $_POST["Releve"];
	$TypeOfCluster = $_POST["TypeOfCluster"];
	$ConsoService = $_POST["ConsoService"];
	$Comments = $_POST["Comments"];

    if(empty($id)){
    // this is a new host
      // No error let's add the entry
	$myquery = "INSERT INTO `hosts` (`name`,`ip`,`Environment`,`ostype`,`osvers`,`serialno`,`vendor`,`model`,`TypeOfHost`,`FrameName`,`NumberOfVM`,`Goal`,`FinSousCategorie`,`ClasseService`,`Entity`,`TypeOfHosting`,`DateIntro`,`BuyOrLease`,`CTIName`,`TownName`,`NumberCPUPhys`,`NumberCPUVirt`,`CPUSpeed`,`Memory`,`DASD`,`SanOr`,`SanArgent`,`SanBronze`,`DateDecom`,`Releve`,`TypeOfCluster`,`ConsoService`,`Comments`) VALUES('$name','$ip','$Environment','$ostype','$osvers','$serialno','$vendor','$model','$TypeOfHost','$FrameName','$NumberOfVM','$Goal','$FinSousCategorie','$ClasseService','$Entity','$TypeOfHosting','$DateIntro','$BuyOrLease','$CTIName','$TownName','$NumberCPUPhys','$NumberCPUVirt','$CPUSpeed','$Memory','$DASD','$SanOr','$SanArgent','$SanBronze','$DateDecom','$Releve','$TypeOfCluster','$ConsoService','$Comments')";	
	$query = mysql_query( $myquery ) or die(mysql_error()."<br>Couldn't execute query: $myquery");
	$id = mysql_insert_id();
      // JB 2014-09-07 : default root account won't automatically be added when creating a host
      // add account root (id 1) to created host
      // mysql_query("INSERT INTO `hosts-accounts` (`id_host`,`id_account`) VALUES ('$id','1')");
      // add SKM Public Key (id 1) for user root on created host
      // mysql_query("INSERT INTO `hak` (`id_host`,`id_account`,`id_key`) VALUES ('$id','1','1')");
      // JB 2014-09-07 : default root account won't automatically be added when creating a host
      header("Location:hosts-view.php?Environment=$Environment");
      echo ("host Added, redirecting...");
      exit ();
    } else {
      // We modify an existing reminder
      // setting the variable for the update
      $name = $_POST['name'];
      mysql_query( "UPDATE `hosts` SET `name` = '$name',`ip` = '$ip',`Environment`='$Environment',`serialno`='$serialno',`ostype`='$ostype',`osvers`='$osvers',`vendor`='$vendor',`TypeOfHost`='$TypeOfHost',`FrameName`='$FrameName',`NumberOfVM`='$NumberOfVM',`Goal`='$Goal',`FinSousCategorie`='$FinSousCategorie',`ClasseService`='$ClasseService',`Entity`='$Entity',`TypeOfHosting`='$TypeOfHosting',`DateIntro`='$DateIntro',`BuyOrLease`='$BuyOrLease',`CTIName`='$CTIName',`TownName`='$TownName',`NumberCPUPhys`='$NumberCPUPhys',`NumberCPUVirt`='$NumberCPUVirt',`CPUSpeed`='$CPUSpeed',`Memory`='$Memory',`DASD`='$DASD',`SanOr`='$SanOr',`SanArgent`='$SanArgent',`SanBronze`='$SanBronze',`DateDecom`='$DateDecom',`Releve`='$Releve',`TypeOfCluster`='$TypeOfCluster',`ConsoService`='$ConsoService',`Comments`='$Comments' WHERE `id` = '$id' " ) or die(mysql_error()."<br>Couldn't execute query: $query");
      // Let's go to the Reminder List page
      header("Location:host-view.php?hostgroup=$Environment&id=$id");
      echo ("host Modified, redirecting...");
      exit ();
    }

}
?>

