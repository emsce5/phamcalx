<?php require_once('includes/header.php'); ?>

    <title>Pham Calcs</title>

<?php require_once('includes/menu.php'); ?>

<?php

error_reporting(E_ALL);
ini_set("display_errors", 1); 


require_once("includes/db.php");

$con =  new mysqli($host, $user, $password, $dbname) or die("Error: " . $con->error);

$query = "SELECT pid FROM `calculators` WHERE pageid = 'isovolemic_exchange';";
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
$thct = $_GET["thct"];
$fhct = $_GET["fhct"];
$sex = $_GET["sex"];
$fcr = $_GET["fcr"];
$ihct = $_GET["ihct"]; 
$uhct = $_GET["uhct"]; 

$lbs = $wgt * 2.2; 
$inch = $hgt * 39.4;
$cube = $hgt * $hgt * $hgt;
$fhct = $fhct/100;
$thct = $thct/100; 
$fcr = $fcr/100; 
$ihct = $ihct/100;

if ($uhct == "sixtyfive") {
	$uhct = 0.65;
}


elseif ($uhct == "sixty") {
	$uhct = 0.60;
}

elseif ($uhct == "fiftyfive") {
	$uhct = 0.55;
}

elseif ($uhct == "fifty") {
	$uhct = 0.50;
}

elseif ($uhct == "seventy") {
	$uhct = 0.70;
}

elseif ($uhct == "seventyfive") {
	$uhct = 0.75;
}
elseif ($uhct == "eighty") {
	$uhct = 0.80;
}


if ($sex == "Female") {
	$tbv = 183 + (356 * $cube) + (33.1 * $wgt);
}


elseif ($sex == "Male") {
	$tbv = 604 + (367 * $cube) + (32.2 * $wgt);
}

$wrench = ($fhct - $thct) * $tbv; 

$nail = log ($thct / $fhct); 

$hammer = log ($fcr);

$screw = ($nail/$hammer) * $uhct;

$volt = $wrench / $screw; 

$un = $volt / 275;

$un = ceil ($un);

$tbv = round($tbv, 0);
$volt = round($volt, 0);

$doughnut = ($tbv * $ihct);

$kitkat = log($ihct/$thct);

$vols = $doughnut * $kitkat;
$vols = round($vols, 0);

?>

  <div class= "container">
    <h1>Replacement Volume Results-Automated Isovolemic Hemodilution</h1>
<?php
if ($wgt <= 0 || $hgt <= 0 || $thct <= 0 || $fhct <= 0 || $fcr <= 0 || $ihct == $thct) {
?>
      <div class="alert alert-danger">An inappropriate value has been entered for weight, height, or hematocrit. Please try again!</div>
<?php
} else {
?>
    <ul class="list-group">
      <li class="list-group-item">The patient's total blood volume (TBV) is <?php echo "$tbv";  ?> ml. </li>
      <li class="list-group-item">Volume of red blood cells required for exchange is <?php echo "$volt";  ?>ml.</li>
      <li class="list-group-item">Exchange will require <?php echo "$un";  ?>units.</li>
      <li class="list-group-item">The amount of saline/albumin required for exchange is <?php echo "$vols";  ?>ml.</li>
    </ul>
        	<h4>This calculator has not been validated for use when the FCR is in excess of 50, in that sitaiton it may  be more clinically appropriate to delay exchange. </h4>
        	<h4>This algorithm assumes an RBC volume of 275 mls, please recalculate using the volume appropriate at your facility.</h4>
			<h4>*Please note, this calculator was designed for use in adult patients.</h4>
			<br/>
			<h5>Nadler's formula was utilized to calculate TBV.</h5>
			<h6>Nadler SB, Hidalgo JH, Bloch T. Prediction of blood volume in normal human adults. Surgery 1962;51: 224-32.</h6>
  </div>

		</form>
		</div>
<?php
}
?>

<?php require_once('includes/footer.php'); ?>


