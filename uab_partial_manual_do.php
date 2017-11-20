<?php require_once('includes/header.php'); ?>

    <title>Pham Calcs</title>

<?php require_once('includes/menu.php'); ?>

<?php
error_reporting(E_ALL);
ini_set("display_errors", 1); 


require_once("includes/db.php");

$con =  new mysqli($host, $user, $password, $dbname) or die("Error: " . $con->error);

$query = "SELECT pid FROM `calculators` WHERE pageid = 'uab_partial_manual';";
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
$ihgb = $_GET["ihgb"];
$volr = $_GET["volr"];
$volb = $_GET["volb"];
$vols = $_GET["vols"];
$sex = $_GET["sex"];
$uhct = $_GET["uhct"];


$cube = $hgt * $hgt * $hgt;
$ihct = $ihct/100;
$ihgb = $ihgb/100;
 
 
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



$tbv = round ($tbv, 0); 
$rcv = round ($rcv, 0);

$hctp = $rcv/($tbv + $vols);
$volp = $hctp * $volr;

$top = ($rcv * $ihgb) - ($volr * ($rcv/$tbv) * $ihgb); 
$bot = $rcv - ($volr * ($rcv/$tbv)) + ($volb * $uhct); 
$fhgb = ($top / $bot) *100; 
$fhgb = round ($fhgb, 1);

$hctf = ($rcv - ($volr * ($rcv/$tbv)) + ($volb * $uhct)) / ($tbv + $vols - $volr + $volb);
$hctf = $hctf *100; 
$hctf = round ($hctf, 1); 

?>



  <div class="container">
    <h1>UAB Protocol Partial Manual Exchange Results</h1>
<?php
if ($wgt <= 0 || $hgt <= 0 || $ihct <= 0 || $ihgb <= 0 || $volb <= 0) {
?>
      <div class="alert alert-danger">An inappropriate value has been entered for weight, height, or hematocrit. Please try again!</div>
<?php
} else {
?>
    <ul class="list-group">
      <li class="list-group-item">The patient's total blooc volume (TBV) is <?php echo "$tbv";  ?>ml.</li>
      <li class="list-group-item">The patient's red cell volume (RCV) is <?php echo "$rcv";  ?>ml.</li>
      <li class="list-group-item">The post procedure hematocrit should be <?php echo "$hctf";  ?>%.</li> 
      <li class="list-group-item">The post procedure hemoglobin S should be <?php echo "$fhgb";  ?>%.</li>    
    </ul>
  </div>
  
    </form>
		<h5>Nadler's formula was utilized to calculate TBV.</h5>
    </div>
  
<?php 
}
?>

<?php require_once('includes/footer.php'); ?>

