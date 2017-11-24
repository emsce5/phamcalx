<?php require_once('includes/header.php'); ?>

    <title>Pham Calcs</title>

<?php require_once('includes/menu.php'); ?>



<?php

error_reporting(E_ALL);
ini_set("display_errors", 1); 


require_once("includes/db.php");

/*pulls the includes file in, this contains the reference for how to get to the sql database*/

$con =  new mysqli($host, $user, $password, $dbname) or die("Error: " . $con->error);

$query = "SELECT pid FROM `calculators` WHERE pageid = 'inr';";
	$stmt = $con->prepare($query);
	$stmt->execute();
	$stmt->bind_result($pid);
	$stmt->fetch();
	$stmt->close();
/*this queries the table calculator to pull the pid associated with the variable simple transfusion, and stores it as $pid.*/

$query = "SELECT vid FROM `visit` WHERE visit_type = 'visit';";
	$stmt = $con->prepare($query);
	$stmt->execute();
	$stmt->bind_result($vid);
	$stmt->fetch();
	$stmt->close();
/*this queries the table visit to pull the vid associated with the variable visit, and stores it as $vid.*/

$date = date('Y-m-d H:i:s');
/*this pulls the date in a sql appropriate format, and stores it as the variable $date.*/


$query = "INSERT INTO `useage` VALUES ( '', ?, ?, ? );";
	$stmt = $con->prepare($query);
	$stmt ->bind_param("sss", $pid, $vid, $date);
	$stmt ->execute();
	$stmt ->close();

/*this prepare the insert statement, binds the values pid, vid, and date to a incrementing uid, and then excutes the statment entering them into the useage table"*/
$con->close();
/*closes the connectiong*/
/*below is the html code for the face-page*/
?>

    <div class= 'container'>
      <h1>INR Following Plasma Transfusion</h1>
      <form action= "inr_do.php" method="get">
        <div class="row">
          <div class="col-sm-4">

            <div class= "form-group">
              <label>Gender</label>
              <select class="form-control" name="sex">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>
            
            <div class= "form-group">
              <label>Weight</label>
              <div class="input-group">
              <input class="form-control" type= "text" name= "wgt">
              <div class="input-group-addon">kg</div>
              </div>
            </div>
            
            <div class= "form-group">
              <label>Height</label>
              <div class="input-group">
                <input class="form-control" type= "text" name= "hgt">
                <div class="input-group-addon">m</div>
              </div>
            </div>
            
            <div class= "form-group">
              <label>Hematocrit</label>
              <div class="input-group">
                <input class="form-control" type= "text" name= "hct">
                <div class="input-group-addon">%</div>
              </div>
            </div>
            
            <div class= "form-group">
              <label>Initial INR</label>
              <div class="input-group">
                <input class="form-control" type= "text" name= "inr">
              </div>
            </div>
            
            <div class= "form-group">
              <label>Volume Plasma Transfused</label>
              <div class="input-group">
                <input class="form-control" type= "text" name= "tpv">
                <div class="input-group-addon">mls</div>
              </div>
            </div>
            
            <div class= "form-group">
              <input class= "btn btn-default" type= "submit" name="submit" value="Submit"/>
            </div>
          
          </div>
        </div>
      </form>
    </div>

<?php require_once('includes/footer.php'); ?>
