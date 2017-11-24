<?php require_once('includes/header.php'); ?>

    <title>Pham Calcs</title>

<?php require_once('includes/menu.php'); ?>

<?php


error_reporting(E_ALL);
ini_set("display_errors", 1); 


require_once("includes/db.php");

$con =  new mysqli($host, $user, $password, $dbname) or die("Error: " . $con->error);

$query = "SELECT pid FROM `calculators` WHERE pageid = 'cci';";
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
    <h1>Platelet Corrected Count Increment</h1>
    <h4>The corrected count increment is performed to assess patient's for potential immune-mediated platelet refractoriness. Post-transfusion platelet counts should be performed within 15-60 minutes post transfusion to ensure validity</h4>
    <form action= "cci_do.php" method="get">
        <div class="row">
          <div class="col-sm-4">
         
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
            <label>Initial Platelet Count</label>
            <div class="input-group">
              <input class="form-control" type= "number" name= "iplt">
              <div class="input-group-addon">cells/ul</div>
            </div>
          </div>

          <div class= "form-group">
            <label>Post-Transfusion Platelet Count</label>
            <div class="input-group">
              <input class="form-control" type= "number" name= "fplt">
              <div class="input-group-addon">cells/ul</div>
            </div>            


            <div class= "form-group">
              <label>Number Platelet Units Transfused</label>
              <select class="form-control" name="tplt">
                <option value="1ap">1 Unit Apheresis Platelets</option>
                <option value="2ap">2 Units Apheresis Platelets </option>
                <option value="1wb">1 Unit Whole Blood Derived Platelets</option>  
                <option value="2wb">2 Units Whole Blood Derived Platelets</option>  
                <option value="3wb">3 Units Whole Blood Derived Platelets</option>               
                <option value="4wb">4 Units Whole Blood Derived Platelets</option> 
                <option value="5wb">5 Units Whole Blood Derived Platelets</option>               
                <option value="6wb">6 Units Whole Blood Derived Platelets</option> 
              </select>

            <div class= "form-group">
              <input class= "btn btn-default" type= "submit" name="submit" value="Submit"/>
            </div>
          </div>
        </div>



<?php require_once('includes/footer.php'); ?>
