 <?php
require_once('siteconf.php');
?>

 <!DOCTYPE html>
<html>
<head>
<title>Room Reservation Recommender</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>

        <!-- PHP CODE GOES HERE. -->

        <?php

        session_start();

        if(isset($_GET['action']) && $_GET['action'] == 'logout') {
            session_destroy();
            header('Refresh: 1');
        }
 
if(!isset($_SESSION['user'])) {
	header('Location: login.php');
}




if(isset($_GET['action']) && $_GET['action'] == 'delete') {

    $CheckExists = $database->prepare("SELECT * FROM reservations WHERE cwid = ?");
    $CheckExists->execute(array($_GET['cwid']));
    $RowCount = $CheckExists->rowCount();

    if($RowCount == 1) {
    $DelQuery = $database->prepare("DELETE FROM reservations WHERE cwid = ?");
    $DelQuery->execute(array($_GET['cwid']));
    header('Refresh: 1');
} else{
    header('Location: index.php');
}

}


if(isset($_GET['action']) && $_GET['action'] == 'edit') {

    $CheckExists = $database->prepare("SELECT * FROM reservations WHERE cwid = ?");
    $CheckExists->execute(array($_GET['cwid']));
    $RowCount = $CheckExists->rowCount();

    if($RowCount == 1) {
    $DelQuery = $database->prepare("DELETE FROM reservations WHERE cwid = ?");
    $DelQuery->execute(array($_GET['cwid']));
    header('Refresh: 1');
} else{
    header('Location: index.php');
}

}




    $GetUsersInformation = $database->prepare("SELECT * FROM students WHERE name = ?");
    $GetUsersInformation->execute(array($_SESSION['user']));
    $GetInfo = $GetUsersInformation->fetch();



    $CheckRes = $database->prepare("SELECT * FROM reservations WHERE cwid = ?");
    $CheckRes->execute(array($GetInfo['cwid']));
    $Result = $CheckRes->fetch();
    $RC = $CheckRes->rowCount();


if(isset($_GET['action']) && $_GET['action'] == 'edit') {
    $DelQuery = $database->prepare("DELETE FROM reservations WHERE cwid = ?");
    $DelQuery->execute(array($_GET['cwid']));

    $_SESSION['ra'] = $Result['ra'];
    $_SESSION['special_needs'] = $Result['special_needs'];
    $_SESSION['laundry'] = $Result['laundry'];
    $_SESSION['kitchen'] = $Result['kitchen'];

    header('Refresh: 1; url=index.php?action=edit');
}

    if($RC > 0) {
        echo "<a href='?action=logout'>Logout</a>";
        echo "<h1><center>Your Reservation<br />1 = Yes, 2 = No</h1>";

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
echo "  <tr>\n"; 
echo "    <td>{$Result['cwid']}</td> \n"; 
echo "    <td>{$Result['class']}</td>\n"; 
echo "    <td>{$Result['ra']}</td>\n"; 
echo "    <td>{$Result['special_needs']}</td> \n"; 
echo "    <td>{$Result['laundry']}</td>\n"; 
echo "    <td>{$Result['kitchen']}</td>\n"; 
?>
<td><a href="?action=delete&cwid=<?php echo $Result['cwid'];?>" onclick="return confirm('Are you sure?')"><img src='del.png'></a></td>
<td><a href="?action=edit&cwid=<?php echo $Result['cwid'];?>" onclick="return confirm('Are you sure?')"><img src='edit.png'></a></td>
<?php
echo "  </tr>\n"; 
echo "</table>\n";


    } else {


 
$ch1       = 'unchecked';
$ch2       = 'unchecked';
$ch3       = 'unchecked';
$needs     = null;
$laundry   = null;
$kitchen   = null;
$class     = 'unchecked';
$residence = isset($_POST["residence"]);
$num = rand();
 
 
if (isset($_POST['submit'])) {
     
    $name      = $GetInfo['name'];
    $cwid      = $GetInfo['cwid'];
    $sex       = $_POST['sex'];
    $class     = $_POST['class'];
    $ch1       = isset($_POST["ch1"]);
    $ch2       = isset($_POST["ch2"]);
    $ch3       = isset($_POST["ch3"]);
    $residence = $_POST["residence"];
     
    echo "<input type='hidden' value='$name' name='name'>";
    echo "<input type='hidden' value='$cwid' name='cwid'>";
    echo "<input type='hidden' value='$class' name='class'>";
    echo "<input type='hidden' value='$sex' name='sex'>";
    echo "<input type='hidden' value='$ch1' name='ch1'>";
    echo "<input type='hidden' value='$ch2' name='ch2'>";
    echo "<input type='hidden' value='$ch3' name='ch3'>";
    echo "<input type='hidden' value='$kitchen' name='kitchen'>";
    echo "<input type='hidden' value='$laundry' name='laundry'>";
    echo "<input type='hidden' value='$needs' name='needs'>";
    echo "<input type='hidden' value='$residence' name='residence'>";
 
     
    $freshmanResidences = array('Leo Hall','Champagnat Hall','Marian Hall','Sheahan Hall');
    $sophomoreResidences = array('Midrise Hall','Foy Townhouses (A-C)','New Townhouses (H-M)','Gartland Commons');
    $juniorseniorResidences = array('Lower West Cedar St Townhouses (N-S)','Upper West Cedar St Townhouses (T-Y) ','Fulton Street Townhouses','Fulton Street Townhouses', 'New Fulton Townhouses');
     
    if ($name == ''){
        echo "<font color= red><b>Name is Required</b></font><br>" ;
        $flag = '1';
    }
    else{
        $flag = '0';
    }
    if ($cwid == ''){
        echo "<font color= red><b>CWID is required.</b></font><br>" ;
        $flag1 = '1';
    }
    else{
        $flag1 = '0';
    }
 
    if ($flag == '1' || $flag1 == '1'){
    echo "<font color=red><b>Please make corrections!</font><br></b>";
    echo "<font color=red><b><a href='index.php'>Click Here</a> to go back</font></b><br>";
    exit;
   }
   else{
    if (isset($_POST['class'])) {
        $class     = $_POST['class'];
        $residence = $_POST["residence"];
         
         
        if ($class == 'Freshman') {           
            if (in_array($residence,$freshmanResidences)) {
                echo '<b>Please confirm your selection below.</b><br />';
                echo '<font color=red> <strong>If wrong:</strong><a href="index.php">Click Here</a> to start over!</font></b><br />';
                $error = false;
            }           
            else {
                echo "<font color=red><b>Please choose a residence area in your class <a href='index.php'>Click Here</a> to go back <b></font><br>";
                $error =  true;
            }       
             
        }
        elseif ($class == 'Sophomore') {
            if (in_array($residence,$sophomoreResidences)) {
                echo '<font color=green><b>Good</font></b></br>';
                $error = false;
            }           
            else {
                echo "<font color=red><b>Please choose a residence area in your class <a href='index.php'>Click Here</a> to go back <b></font><br>";
                $error = true;
            }   
        }
        elseif ($class == 'Junior') {
            if (in_array($residence,$juniorseniorResidences)) {
                echo '<font color=green><b>Good</font></b></br>';
                $error = false;
            }           
            else {
                echo "<font color=red><b>Please choose a residence area in your class <a href='index.php'>Click Here</a> to go back <b></font><br>";
                $error = true;
            }   
        }
        elseif ($class == 'Senior') {
            if (in_array($residence,$juniorseniorResidences)) {
                echo '<font color=green><b>Good</font></b></br>';
                $error = false;
            }           
            else {
                echo "<font color=red><b>Please choose a residence area in your class <a href='index.php'>Click Here</a> to go back <b></font><br>";
                $error = true;
            }   
        }
         
    }
     
    if (isset($_POST['ch1'])) {
        $ch1 = $_POST['ch1'];
         
        if ($ch1 == 'Special Needs') {
            $ch1   = 'checked';
            $needs = 'Yes';
        }
    }
     
    if (isset($_POST['ch2'])) {
        $ch2 = $_POST['ch2'];
         
        if ($ch2 == 'Laundry on Premise') {
            $ch2     = 'checked';
            $laundry = 'Yes';
        }
    }
 
    if (isset($_POST['ch3'])) {
        $ch3 = $_POST['ch3'];
         
        if ($ch3 == 'Fully Equipped Kitchen') {
            $ch3     = 'checked';
            $kitchen = 'Yes';
        }
         
    } else {
        $ch3 = 0;
    }
     
     
     
     
    echo '<strong>Name:</strong> ' . $name;
    echo '<br>';
    echo '<strong>CWID:</strong> ' . $cwid;
    echo '<br>';
    echo '<strong>Sex:</strong> ' . $sex;
    echo '<br>';
    echo '<strong>Residence:</strong> ' . $residence;
    echo '<br>';
    echo '<strong>Class:</strong> ' . $class;
    echo '<br>';
    echo 'Reservation Numer:' . $num . '<br>';
     
    if ($ch1) {
        echo '<strong>Special Needs: </strong>' . $needs . '<br>';
    }
     
    if ($ch2) {
        echo '<strong>Laundry on Premise:</strong> ' . $laundry . '<br>';
    }
     
    if ($ch3) {
        echo '<strong>Fully Equipped Kitchen: </strong>' . $kitchen . '<br>';
    }
    
   } 
    echo '<hr>';
     
    echo '<strong> ';

    $name      = $GetInfo['name'];
    $cwid      = $GetInfo['cwid'];
    $sex       = isset($_POST['sex']);
    $class     = isset($_POST['class']);
    $ch1       = isset($_POST["ch1"]);
    $ch2       = isset($_POST["ch2"]);
    $ch3       = isset($_POST["ch3"]);
    $residence = isset($_POST["residence"]);

    if (isset($_POST['submit']) && $error == false){


     if(!isset($_POST['ch1'])) {
        $ch1 = 0;
    } else {
        $ch1 = 1;
    }

    if(!isset($_POST['ch2'])) {
        $ch2 = 0;
    } else {
        $ch2 = 1;
    }

if(!isset($_POST['ch3'])) {
        $ch3 = 0;
    } else {
        $ch3 = 1;
    }


    

    

    $InsertRes = $database->prepare("INSERT INTO `reservations`(`id`, `cwid`, `class`, `ra`, `special_needs`, `laundry`, `kitchen`, `sex`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $InsertRes->execute(array(NULL, $GetInfo['cwid'], $_POST['class'], $_POST['residence'], $ch1, $ch2, $ch3, $_POST['sex']));
    header('Refresh: 1');
 }

}
 
?>
 
 



 <!-- PHP CODE ENDS HERE -->

 
<body>
 
 
<h1> Project one </h1>




<a onclick="return confirm('Are you sure?')" href='?action=logout'>Logout</a>
<br /><br />
 
<form action='index.php' method="POST">
 
    Name: <input type='text' name='Name' value='<?php echo $GetInfo['name']; ?>' disabled />
        <br>
    CWID: <input type='text' name='Cwid' value="<?php echo $GetInfo['cwid']; ?>" disabled />
        <br>
 
 
<strong>Gender:</strong>
<input type="radio" name="sex" value="Male" checked>Male
<input type="radio" name="sex" value="Female">Female
<br>
 
 
 
<strong>Class:</strong> <select name='class'>
<option value='Freshman'> Freshman </option>
<option value='Sophomore'> Sophomore </option>
<option value='Junior'> Junior </option>
<option value='Senior'> Senior </option>
</select>
 
<br>

<strong> Residence Area </strong> 
<select name='residence'>
<?php


   

    // Create connection
    /* What this code does is it again checks to see if there is a connection stored.  If the connection
    is succesful it proceeds to run the remaining code. The code pretty much checks to see how many reservations
    are left in each building. It receives the number of open slots there are lift than stores it in a variable. */
   
    $CheckVacancy = $database->prepare("SELECT ra,COUNT(*) FROM reservations GROUP BY ra");
    $CheckVacancy->execute();
    $result = $CheckVacancy->fetchAll();

    
    // Verify it worked
    if (!$result) echo mysql_error();

    $hallToVacancyMap=[];
    echo "vacancy validated here";
    foreach($result as $row)  {
        $hallToVacancyMap[$row[0]] = 5 - $row[1];
    }
    
?>
<option value='Leo Hall' <?php if($hallToVacancyMap["Leo Hall"]===0) echo "disabled"; ?>>Leo Hall <?php echo (isset($hallToVacancyMap['Leo Hall']) ? $hallToVacancyMap["Leo Hall"] : 5); ?></option>
<option value='Champagnat Hall' <?php if($hallToVacancyMap["Champagnat Hall"]===0) echo "disabled"; ?>>Champagnat Hall <?php echo (isset($hallToVacancyMap['Champagnat Hall']) ? $hallToVacancyMap["Champagnat Hall"] : 5); ?></option>
<option value='Marian Hall' <?php if($hallToVacancyMap["Marian Hall"]===0) echo "disabled"; ?>>Marian Hall<?php echo (isset($hallToVacancyMap['Marian Hall']) ? $hallToVacancyMap["Marian Hall"] : 5); ?></option>
<option value='Sheahan Hall' <?php if($hallToVacancyMap["Sheahan Hall"]===0) echo "disabled"; ?>>Sheahan Hall<?php echo (isset($hallToVacancyMap['Sheahan Hall']) ? $hallToVacancyMap["Sheahan Hall"] : 5); ?></option>
<option value='Midrise Hall' <?php if($hallToVacancyMap["Midrise Hall"]===0) echo "disabled"; ?>>Midrise Hall<?php echo (isset($hallToVacancyMap['Midrise Hall']) ? $hallToVacancyMap["Midrise Hall"] : 5); ?></option>
<option value='Foy Townhouses (A-C)' <?php if($hallToVacancyMap["Foy Townhouses (A-C)"]===0) echo "disabled"; ?>>Foy Townhouses(A-C)<?php echo (isset($hallToVacancyMap['Foy Townhouses (A-C)']) ? $hallToVacancyMap["Foy Townhouses (A-C)"] : 5); ?></option>
<option value='Gartland Commons' <?php if($hallToVacancyMap["Gartland Commons"]===0) echo "disabled"; ?>>Gartland Commons(D-G)<?php echo (isset($hallToVacancyMap['Gartland Commons']) ? $hallToVacancyMap["Gartland Commons"] : 5); ?></option>
<option value='New Townhouses (H-M)' <?php if($hallToVacancyMap["New Townhouses (H-M)"]===0) echo "disabled"; ?>>New Townhouses (H-M)<?php echo (isset($hallToVacancyMap['New Townhouses (H-M)']) ? $hallToVacancyMap["New Townhouses (H-M)"] : 5); ?></option>
<option value='Lower West Cedar St Townhouses (N-S)' <?php if($hallToVacancyMap["Lower West Cedar St Townhouses (N-S)"]===0) echo "disabled"; ?>>Lower West Cedar St Townhouses (N-S)<?php echo (isset($hallToVacancyMap['Lower West Cedar St Townhouses (N-S)']) ? $hallToVacancyMap["Lower West Cedar St Townhouses (N-S)"] : 5); ?></option>
<option value='Upper West Cedar St Townhouses (T-Y)' <?php if($hallToVacancyMap["Upper West Cedar St Townhouses (T-Y)"]===0) echo "disabled"; ?>>Upper West Cedar St Townhouses (T-Y) <?php echo (isset($hallToVacancyMap['Upper West Cedar St Townhouses (T-Y)']) ? $hallToVacancyMap["Upper West Cedar St Townhouses (T-Y)"] : 5); ?></option>
<option value='Fulton Street Townhouses' <?php if($hallToVacancyMap["Fulton Street Townhouses"]===0) echo "disabled"; ?>>Fulton Street Townhouses <?php echo (isset($hallToVacancyMap['Fulton Street Townhouses']) ? $hallToVacancyMap["Fulton Street Townhouses"] : 5); ?></option>
<option value='Talmadge Court' <?php if($hallToVacancyMap["Talmadge Court"]===0) echo "disabled"; ?>>Talmadge Court <?php echo (isset($hallToVacancyMap['Talmadge Court']) ? $hallToVacancyMap["Talmadge Court"] : 5); ?></option>
<option value='New Fulton Townhouses' <?php if($hallToVacancyMap["New Fulton Townhouses"]===0) echo "disabled"; ?>>New Fulton Townhouses <?php echo (isset($hallToVacancyMap['New Fulton Townhouses']) ? $hallToVacancyMap["New Fulton Townhouses"] : 5); ?></option>
</select>

<br />
<strong>Student Preferences</strong>
<br>
<input type="checkbox" name="ch1"  id='ch1' value="Special Needs" />Special Needs <br />
<input type="checkbox" name="ch2"  id='ch2' value="Laundry on Premise" /> Laundry on Premise<br />
<input type="checkbox" name="ch3" id='ch3' value="Fully Equipped Kitchen" /> Fully Equipped Kichen<br />
 
<input type="submit"  name='submit' value="Submit" />
 
</form>
<?php } ?>

</body>
</html>