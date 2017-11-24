<?php require_once('includes/header.php'); ?>

    <title>Pham Calcs</title>

<?php require_once('includes/menu.php'); ?>

<?php

error_reporting(E_ALL);
ini_set("display_errors", 1); 


require_once("includes/db.php");

$con =  new mysqli($host, $user, $password, $dbname) or die("Error: " . $con->error);

$query = "SELECT pid FROM `calculators` WHERE pageid = 'simple_transfusion';";
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
$ihct = $_GET["ihct"];
$vt = $_GET["vt"];
$vs = $_GET["vs"];
$sex = $_GET ["sex"];
$ihgb = $_GET ["ihgb"];
$uhct = $_GET ["uhct"];

$lbs = $wgt * 2.2; 
$inch = $hgt * 39.4;
$cube = $hgt * $hgt * $hgt;
$ihct = $ihct/100;



if ($sex == "Female") {
	$tbv = 183 + (356 * $cube) + (33.1 * $wgt);
	$rcv = $tbv * $ihct; 
}


elseif ($sex == "Male") {
	$tbv = 604 + (367 * $cube) + (32.2 * $wgt);
	$rcv = $tbv * $ihct; 
}

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

$lbs = round ($lbs, 1); 
$inch = round ($inch, 1); 
$rcv = round ($rcv, 0);
$tbv = round ($tbv, 0); 


$fhgb = ($rcv * $ihgb) / ($rcv + ($uhct * $vt)); 
$fhgb = round ($fhgb, 1);

$fhct = ($rcv + ( $vt * $uhct)) / ($tbv + $vt + $vs)  ; 
$fhct = $fhct * 100;
$fhct = round ($fhct, 1);
?>


    <div class= "container">
      <h1>Post Simple Transfusion Results</h1>
<?php
if ($wgt <= 0 || $hgt <= 0 || $ihct <= 0 || $ihgb <= 0) {
?>
      <div class="alert alert-danger">An inappropriate value has been entered for weight, height, or hematocrit. Please try again!</div>
<?php
}  else {
?>
      <ul class="list-group">
        <li class="list-group-item">The patient's total blood volume (TBV) is <?php echo "$tbv"; ?> mls.</li>
        <li class="list-group-item">The patient's red cell volume (RCV) is <?php echo "$rcv";  ?> mls.</li>
        <li class="list-group-item">The patient's post transfusion Hemoglobin S should be approximately <?php echo "$fhgb";  ?>%</li>
        <li class="list-group-item">The patient's post transfusion Hematocrit should be approximately <?php echo "$fhct";  ?>%</li>       
      </ul>
      
      </form>
           	<h6>Total blood volume is calculated as described in Nadler SB, Hidalgo JH, Bloch T. Prediction of blood volume in normal human adults. Surgery 1962;51: 224-32.</h6>
			<br/>
			<h4>*Please note, this calculator was designed for use for adult patients.</h4>

      </div>

<?php
if ($fhct > 31 || $vt > 900) {
?>
      <div class="alert alert-danger">This transfusion volume is very large, and/or the patient's hematocritwill be > 30% following transfusion, Red Cell Exchange could be considered as an alternative therapy.</div>
<?php
}
}
?>
    </div>
<?php require_once('includes/footer.php'); ?>
