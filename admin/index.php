 <?php
require_once('../siteconf.php');
?>

 <!DOCTYPE html>
<html>
<head>
<title>Room Reservation Recommender</title>
<link rel="stylesheet" type="text/css" href="../style.css">
</head>

        <!-- PHP CODE GOES HERE. -->

        <?php

        session_start();

 
 if(isset($_GET['action']) && $_GET['action'] == 'logout') {
  session_destroy();
  header('Refresh: 2');
 }

if(!isset($_SESSION['adminlogged'])) {
	header('Location: login.php');
}


switch($_GET['action']) {
	case "deleteres":
		$DeleteRes = $database->prepare("DELETE FROM reservations WHERE cwid = ?");
		$DeleteRes->execute(array($_GET['cwid']));
		break;
	case "deletestu":

    $CheckRes = $database->prepare("SELECT * FROM reservations WHERE cwid = ?");
    $CheckRes->execute(array($_GET['cwid']));
    $CCount = $CheckRes->rowCount();

    if($CCount == 1) {
      echo "Sorry you can not delete a user with a reservation!";
    } else {

		$DeleteStu = $database->prepare("DELETE FROM students WHERE cwid = ?");
		$DeleteStu->execute(array($_GET['cwid']));
		break;

  }
}



    $GetUsersInformation = $database->prepare("SELECT * FROM students");
    $GetUsersInformation->execute();
    $GetInfo = $GetUsersInformation->fetchAll();



    $CheckRes = $database->prepare("SELECT * FROM reservations");
    $CheckRes->execute();
    $Res = $CheckRes->fetchAll();

echo "<a href='?action=logout'>Logout</a>";

    echo "<h1>Reservations</h1>";

    echo "<table style=\"width:100%;text-align:center\">\n"; 
echo "<tr>\n";  
echo "    <th>CWID</th>     \n"; 
echo "    <th>Class</th>\n"; 
echo "    <th>RA</th>\n"; 
echo "    <th>Special Needs</th>\n"; 
echo "    <th>Laundry</th>\n"; 
echo "    <th>Kitchen</th>\n"; 
echo "    <th>Delete</th>\n"; 
echo "    <th>Edit</th>\n"; 
echo "  </tr>\n";

   foreach($Res as $Result) {

echo "  <tr>\n"; 
echo "    <td>{$Result['cwid']}</td> \n"; 
echo "    <td>{$Result['class']}</td>\n"; 
echo "    <td>{$Result['ra']}</td>\n"; 
echo "    <td>{$Result['special_needs']}</td> \n"; 
echo "    <td>{$Result['laundry']}</td>\n"; 
echo "    <td>{$Result['kitchen']}</td>\n"; 
?>

<td><a href="?action=deleteres&cwid=<?php echo $Result['cwid'];?>" onclick="return confirm('Are you sure?')"><img src='../del.png'></a></td>

<td>

<form action='edit.php' method='POST'>
<input type='hidden' name='special_needs' value='<?php echo $Result['special_needs'];?>'>
<input type='hidden' name='kitchen' value='<?php echo $Result['kitchen'];?>'>
<input type='hidden' name='laundry' value='<?php echo $Result['laundry'];?>'>
<input type='hidden' name='cwid' value='<?php echo $Result['cwid'];?>'>
<input type="image" onclick="confirm('Are you sure?')" src="../edit.png" onclick="AjaxResponse()" name="submit" id="button" value="">
</form>

</td>
<?php

   }
   echo "  </tr>\n"; 
echo "</table>\n";
echo "<br />";

echo "<h1>Students</h1>";

echo "<table style=\"width:100%;text-align:center\">\n"; 
echo "<tr>\n";  
echo "    <th>CWID</th>     \n"; 
echo "    <th>Name</th>\n"; 
echo "    <th>Activated</th>\n"; 
echo "    <th>Email</th>\n"; 
echo "    <th>Hashed Pass</th>\n"; 
echo "    <th>Delete</th>\n"; 
echo "  </tr>\n";


   foreach($GetInfo as $Result) {

echo "  <tr>\n"; 
echo "    <td>{$Result['cwid']}</td> \n"; 
echo "    <td>{$Result['name']}</td>\n"; 
echo "    <td>{$Result['activated']}</td>\n"; 
echo "    <td>{$Result['email']}</td>\n";  
echo "    <td>{$Result['password']}</td> \n"; 
?>

<td><a href="?action=deletestu&cwid=<?php echo $Result['cwid'];?>" onclick="return confirm('Are you sure?')"><img src='../del.png'></a></td>
<?php

   }
   echo "  </tr>\n"; 
echo "</table>\n";

?>
 
 



 <!-- PHP CODE ENDS HERE -->

 
<body>

 

</body>
</html>