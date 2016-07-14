<?php
require_once('siteconf.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Student Login Page</title>
		<link rel="stylesheet" href="style.css" type="text/css">
	</head>

	<body>
		<center>
			<h1>Login Page</h1>

<div class='container'>
			<form action="" method="POST">
  <fieldset>
  <legend>Login Information</legend>
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" required />
    <br />
    <label for="pass">Password:</label>
    <input type="password" name="password" id="password" required/>
    <br />
    <label for="comp">Complete:</label>
    <input type='submit' name='submit' value='Submit Login'>
  </fieldset>
</form>
<br />
<a href='newuser.php'>Not signed up?</a>
<br />
<a href='admin'>Click here for admin</a>
		</center>
    </div>
	</body>
</html>

<?php

session_start();

if(isset($_SESSION['user'])) {
  header('Location: index.php');
}



if(isset($_POST['submit'])) {

  $user = $_POST['name'];
  $password = sha1(md5($_POST['password']));

  $LoginUser = $database->prepare("SELECT * FROM students WHERE name = ? AND password = ? AND activated = 1");
  $LoginUser->execute(array($user, $password));
  $LoginCount = $LoginUser->rowCount();

  if($LoginCount == 1) {
      $_SESSION['user'] = $user;
      header('Refresh: 1; url=index.php');
  } else {
    echo "<center><br />Sorry, that username or password is incorrect.</center>";
  }


}

?>