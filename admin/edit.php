<?php

require('../siteconf.php');

$CWID = $_POST['cwid'];

if(isset($_POST['submit'])) {

	$UpdateRes = $database->prepare("UPDATE `reservations` SET `special_needs`=?,`laundry`=?,`kitchen`=? WHERE `cwid` = ?");
	$UpdateRes->execute(array($_POST['special_needs'], $_POST['laundry'], $_POST['kitchen'], $_POST['cwid']));

	header('Location: index.php');

}

echo "<form action='' method='POST'>";

echo "<h1>You are editing the reservation with CWID of: " . $_POST['cwid'] . "</h1><hr><br />";

echo "<input type='hidden' name='cwid' value='".$_POST['cwid']."'>";

echo "Special Needs: <input type='text' name='special_needs' value='" . $_POST['special_needs'] . "'> "; 

echo "<br />";

echo "Kitchen: <input type='text' name='kitchen' value='" . $_POST['kitchen'] . "'> "; 

echo "<br />";

echo "Laundry: <input type='text' name='laundry' value='" . $_POST['laundry'] . "'> "; 

echo "<br />";

echo "<input type='submit' name='submit' value='Update'>";

echo "</form>";

?>