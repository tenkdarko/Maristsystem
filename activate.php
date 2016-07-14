<?php

require_once('siteconf.php');


if(!isset($_GET['code'])) {
	echo "Nothing to see here!";
}

if(isset($_GET['code'])) {


$SelectCode = $database->prepare("SELECT * FROM students WHERE activation_code = ?");
$SelectCode->execute(array($_GET['code']));
$RowCount = $SelectCode->rowCount();


if($RowCount != 1) {
	echo "That is an invalid code!";
} else {
	$UpdateUser = $database->prepare("UPDATE students SET activated = 1 WHERE activation_code = ?");
	$UpdateUser->execute(array($_GET['code']));
	echo "Thank you for activating your account!";
	header('Refresh: 3;url=login.php');
}


}
?>