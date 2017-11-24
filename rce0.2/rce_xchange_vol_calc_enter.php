<?php require_once('includes/header.php'); ?>

    <title>Pham Calcs</title>

<?php require_once('includes/menu.php'); ?>

<?php


error_reporting(E_ALL);
ini_set("display_errors", 1); 


require_once("includes/db.php");

$con =  new mysqli($host, $user, $password, $dbname) or die("Error: " . $con->error);

$query = "SELECT pid FROM `calculators` WHERE pageid = 'auto_rce';";
  $stmt = $con->prepare($query);
  $stmt->execute();
  $stmt->bind_result($pid);
  $stmt->fetch();
  $stmt->close();


       
$query = "SELECT vid FROM `visit` WHERE visit_type = 'visit';";
  $stmt = $con->prepare($query);
  $stmt->execute();
  $stmt->bind_result($vid);
  $stmt->fetch();
  $stmt->close();


$date = date('Y-m-d H:i:s');



$query = "INSERT INTO `useage` VALUES ( '', ?, ?, ? );";
  $stmt = $con->prepare($query);
  $stmt ->bind_param("sss", $pid, $vid, $date);
  $stmt ->execute();
  $stmt ->close();

$con->close();


?>

    <div class= 'container'>
    <h1>Automated Red Cell Exchange</h1>
    <h4>This algorithm will estimate the volume/number of units required to achieve a specified FCR/and post procedure hematocrit for a given patient.</h4>
    <form action= "rce_xchange_vol_calc_do.php" method="get">
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
              <input class="form-control" type= "number" step= "any" name= "hgt">
              <div class="input-group-addon">m</div>
            </div>
          </div>

          <div class= "form-group">
            <label>Initial Hematocrit</label>
            <div class="input-group">
              <input class="form-control" type= "number" name= "ihct">
              <div class="input-group-addon">%</div>
            </div>
          </div>

          <div class= "form-group">
            <label>Desired Hematocrit</label>
            <div class="input-group">
              <input class="form-control" type= "number" name= "phct">
              <div class="input-group-addon">%</div>
            </div>            

          <div class= "form-group">
            <label>FCR</label>
            <div class="input-group">
              <input class="form-control" type= "number" name= "fcr">
              <div class="input-group-addon">%</div>
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
              <input class= "btn btn-default" type= "submit" name="submit" value="Submit"/>
            </div>
          </div>
        </div>



<?php require_once('includes/footer.php'); ?>
