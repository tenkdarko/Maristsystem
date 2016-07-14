<?php
require_once('siteconf.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Student Signup Page</title>
		<link rel="stylesheet" href="style.css" type="text/css">
	</head>

	<body>
		<center>
			<h1>Signup Page</h1>

			<form action="" method="POST">
  <fieldset>
  <legend>User Information</legend>
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" required/>
    <br />
    <label for="pass">Password:</label>
    <input type="password" name="password" id="password" required/>
    <br />
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required/>
    <br />
    <label for="cwid">CWID:</label>
    <input type="text" name="cwid" id="cwid" required/>
    <br />
    <label for="comp">Complete:</label>
    <input type='submit' name='submit' value='Submit Registration'>
  </fieldset>
</form>
		</center>
	</body>
</html>

<?php

if(isset($_POST['submit']) && is_numeric($_POST['cwid'])) {

  $CheckUser = $database->prepare("SELECT * FROM students WHERE name = ? OR email = ?");
  $CheckUser->execute(array($_POST['name'], $_POST['email']));
  $RowCount = $CheckUser->rowCount();

  if($RowCount > 0) {
    echo "<center><br />Sorry, you already have an account!</center>";
  } else {

  echo "<br /><center>** CHECK SPAM **. We have sent a activation code to your email, you will not be able to login follow the steps.</center>";

  $name = $_POST['name'];
  $password = sha1(md5($_POST['password']));
  $email = $_POST['email'];
  $cwid = $_POST['cwid'];

  $verificationCode = md5(uniqid($_POST['name'], true));

  $headers = "Reply-To: Kwame Project<d1kwame@gmail.com>\r\n"; 
  $headers = "Return-Path: Kwame Project<d1kwame@gmail.com>\r\n"; 
  $headers = "From: Kwame Project<d1kwame@gmail.com>\r\n";
  $headers = "Organization: Kwame\r\n";
  $headers = "MIME-Version: 1.0\r\n";
  $headers = "Content-type: text/plain; charset=iso-8859-1\r\n";
  $headers = "X-Priority: 3\r\n";
  $headers = "X-Mailer: PHP". phpversion() ."\r\n";

  $message = "Hello " . $name . "! It appears you have registed an account with us.\r\nIn order to complete your registration, you must click the link below.\r\n" . $siteURL . "activate.php?code=".$verificationCode."\r\nThank you!";

  $message = wordwrap($message, 70, "\r\n");

  mail($email, 'Activate Your Account', $message, $headers);



  $InsertUser = $database->prepare("INSERT INTO students (`cwid`, `name`, `password`, `activated`, `activation_code`, `email`, `user_group`) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $InsertUser->execute(array($cwid, $name, $password, 1, $verificationCode, $email, 0));

  header('Refresh: 3; url=login.php');
}


}
?>