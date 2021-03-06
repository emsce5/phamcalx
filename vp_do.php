<?php require_once('includes/header.php'); ?>

    <title>Pham Calcs</title>

<?php require_once('includes/menu.php'); ?>


<?php

error_reporting(E_ALL);
ini_set("display_errors", 1); 


require_once("includes/db.php");

$con =  new mysqli($host, $user, $password, $dbname) or die("Error: " . $con->error);

$query = "SELECT pid FROM `calculators` WHERE pageid = 'vp';";
	$stmt = $con->prepare($query);
	$stmt->execute();
	$stmt->bind_result($pid);
	$stmt->fetch();
	$stmt->close();


       
$query = "SELECT vid FROM `visit` WHERE visit_type = 'submit';";
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

$wgt = $_GET["wgt"];
$hgt = $_GET["hgt"];
$hct = $_GET["hct"];
$sex = $_GET["sex"];
$inr = $_GET["inr"];
$ginr = $_GET["ginr"];


$lbs = $wgt * 2.2; 
$inch = $hgt * 39.4;
$cube = $hgt * $hgt * $hgt;
$hct = $hct/100; 



if ($sex == "Female") {
	$tbv = 183 + (356 * $cube) + (33.1 * $wgt);
	$rcv = $tbv * $hct; 
}


elseif ($sex == "Male") {
	$tbv = 604 + (367 * $cube) + (32.2 * $wgt);
	$rcv = $tbv * $hct; 
}


$lbs = round ($lbs, 1); 
$inch = round ($inch, 1); 
$rcv = round ($rcv, 0);
$tbv = round ($tbv, 0); 


$pv = $tbv * (100 - ($hct*100))/100; 

 
$pv = round ($pv, 0); 

$one = ($pv) * (pow (10, -0.0948)); 
$two = pow ($inr, -0.9196);
$three = pow ($ginr, -0.9196); 
$four = $two - $three; 
$top = $one * $four; 
$five = (pow (10, -0.0948)) * $three; 
$bottom = $five - 1; 
$vp = $top/$bottom; 

$vp = round ($vp, 0);
?>

  <div class= "container">
    <h1>Plasma Volume Results</h1>
<?php
if ($wgt <= 0 || $hgt <= 0 || $hct <= 0) {
?>
      <div class="alert alert-danger">An inappropriate value has been entered for weight, height, or hematocrit. Please try again!</div>
<?php
} else {
?>
    <ul class="list-group">
      <li class="list-group-item">The volume of plasma necessary to achieve the specified INR is approximately <?php echo "$vp";  ?> mls. </li>
    </ul>
    
    	<h4>Please note transfusion of plasma may place the patient at risk for both TRALI and TACO. </h4>
    	<h4>Please consider alternative methods of coagulation reversal in patients at risk for circulatory overload.</h4>
    	 <h4>*Please note, this calculator was designed for use for adult patients.</h4>
  </div>

<?php
}
?>

<?php require_once('includes/footer.php'); ?>
