<?php require_once('includes/header.php'); ?>

    <title>Pham Calcs</title>

<?php require_once('includes/menu.php'); ?>


<?php

error_reporting(E_ALL);
ini_set("display_errors", 1); 


require_once("includes/db.php");
/*pulls the includes file in, this contains the reference for how to get to the sql database*/

$con =  new mysqli($host, $user, $password, $dbname) or die("Error: " . $con->error);

$query = "SELECT pid FROM `calculators` WHERE pageid = 'simple_transfusion';";
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
    <h1> Metrics for Simple Transfusion</h1>
    <h4>Given a known transfusion volume-this calculator can estimate the post transfusion hematocrit and hemoglobin S.</h4>
    <h4>An infusion of saline is sometimes given concurrently at the time of transfusion to potential reduce viscosity, this is not done in all institutions/all settings.</h4>  
      <form action= "rce_post_do.php" method="get">
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
                <input class="form-control" type= "number" step= "any" name= "wgt">
                <div class="input-group-addon">kg</div>
              </div>
            </div>
        
            <div class= "form-group">
              <label>Height</label>
              <div class="input-group">
                <input class="form-control" type= "number" step= "any" name= "hgt">
                <div class="input-group-addon">m</div>
              </div>
            </div>
    
            <div class= "form-group">
              <label>Initial Hematocrit</label>
              <div class="input-group">
                <input class="form-control" type= "number" step= "any" name= "ihct">
                <div class="input-group-addon">%</div>
              </div>
            </div>
    
            <div class= "form-group">
              <label>Initial Hemoglobin S</label>
              <div class="input-group">
                <input class="form-control" type= "number" step= "any" name= "ihgb">
                <div class="input-group-addon">%</div>
              </div>
            </div>
    
            <div class= "form-group">
              <label>Volume Red Cells Transfused</label>
              <div class="input-group">
                <input class="form-control" type= "number" name= "vt">
                <div class="input-group-addon">ml</div>
              </div>
            </div>
            
            <div class= "form-group">
              <label>Hematocrit of RBC Unit</label>
              <select class="form-control" name="uhct">
                <option value="sixty">60</option>
                <option value="fifty">50</option>
                <option value="fiftyfive">55</option>
                <option value="sixtyfive">65</option>
                <option value="seventy">70</option>  
                <option value="seventyfive">75</option>   
                <option value="eighty">80</option>            
              </select>
            </div>
      
            <div class= "form-group">
              <label>Volume Saline Infused</label>
              <div class="input-group">
                <input class="form-control" type= "number" name= "vs">
                <div class="input-group-addon">ml</div>
              </div>
            </div>

            <div class= "form-group">
              <input class= "btn btn-default" type= "submit" name="submit" value="Submit"/>
            </div>
          </div>
        </div>

<?php require_once('includes/footer.php'); ?>
