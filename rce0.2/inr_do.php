<?php require_once('includes/header.php'); ?>

    <title>Pham Calcs</title>

<?php require_once('includes/menu.php'); ?>


<?php

error_reporting(E_ALL);
ini_set("display_errors", 1); 


require_once("includes/db.php");

$con =  new mysqli($host, $user, $password, $dbname) or die("Error: " . $con->error);

$query = "SELECT pid FROM `calculators` WHERE pageid = 'inr';";
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
$tpv = $_GET["tpv"];


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

$rat = $tpv/$pv;

$one = pow($inr, -0.9196); 
$two = $one / (1 + $rat);
$three = $rat / (0.8039 * (1 + $rat));
$four = $two + $three; 
$inrf = pow($four, -1.0874);

$inrf = round ($inrf, 2);

?>

  <div class= "container">
    <h1>Predicted INR</h1>
<?php
if ($wgt <= 0 || $hgt <= 0 || $hct <= 0) {
?>
      <div class="alert alert-danger">An inappropriate value has been entered for weight, height, or hematocrit. Please try again!</div>
<?php
} else {
?>
    <ul class="list-group">
      <li class="list-group-item">The post-transfusion INR will be approximately <?php echo "$inrf";  ?>. </li>

    </ul>
    	<h5>INR calculated as explained in Bryan Jr A W, Staley E M, Kennell Jr T, Feldman A Z, Williams III L A, Pham H P.  Plasma transfusion demystified: A review of the key factors influencing the response to plasma transfusion.  Lab Medicine, 2017, 48(2): 108-112.</h5>
    	<h6>Total blood volume is as described in Nadler SB, Hidalgo JH, Bloch T. Prediction of blood volume in normal human adults. Surgery 1962;51: 224-32.</h6>
	<br/>
	<br/>
	<br/>
  <h4>*Please note, this calculator was designed for use for adult patients.</h4>
	</div>

<?php
}
?>

<?php require_once('includes/footer.php'); ?>
