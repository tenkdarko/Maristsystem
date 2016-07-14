<!DOCTYPE html>
<html>
	<head>
		<title>Admin Login Page</title>
		<link rel="stylesheet" href="../style.css" type="text/css">
	</head>

	<body>
		<center>
			<h1>Admin Login Page</h1>

<div class='container'>
			<form action="" method="POST">
  <fieldset>
  <legend>Login Information</legend>
    
    <label for="keyword">Keyword:</label>
    <input type="password" name="keyword" id="keyword" required/>
    <br />
    <label for="user">User:</label>
    <input type="text" name="user" id="user" required/>
    <br />
    <label for="comp">Complete:</label>
    <input type='submit' name='submit' value='Submit Login'>
  </fieldset>
</form>
		</center>
    </div>
	</body>
</html>

<?php

require('../siteconf.php');

session_start();

if(isset($_SESSION['adminlogged'])) {
  header('Location: index.php');
}


if(isset($_POST['submit'])) {

  if($_POST['keyword'] == $secretKey && $_POST['user'] == $adminUser) {
      $_SESSION['adminlogged'] = $_POST['keyword'];
      header('Location: index.php');
  } else {
    echo "<center>Incorrect key.</center>";
  }


}

?>