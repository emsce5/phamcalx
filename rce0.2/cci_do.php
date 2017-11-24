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
$iplt = $_GET["iplt"];
$fplt = $_GET["fplt"];
$tplt = $_GET["tplt"];

if ($tplt == "1ap") {
	$tplt = 3 * (pow (10, 11));
}

elseif ($tplt == "2ap") {
	$tplt = 6 * (pow (10, 11)); 
}

elseif ($tplt == "1wb") {
		$tplt = 5.5 * (pow (10, 10));
}

elseif ($tplt == "2wb") {
	$tplt = 1.1 * (pow (10, 11));
}

elseif ($tplt == "3wb") {
	$tplt = 1.65 * (pow (10, 11));
}

elseif ($tplt == "4wb") {
	$tplt = 2.2 * (pow (10, 11));
}

elseif ($tplt == "5wb") {
	$tplt = 2.75 * (pow (10, 11));
}

elseif ($tplt == "6wb") {
	$tplt = 3.3 * (pow (10, 11));
}

$hgt = $hgt * 100;

$wgt = pow ($wgt, 0.425); 
$hgt = pow ($hgt, 0.725);
$bsa = $wgt * $hgt * 0.007184;

$bsa = round ($bsa, 1); 

$top = ($fplt - $iplt) * $bsa;
$top = $top * pow (10, 11); 
$cci = $top / $tplt; 

$cci = round ($cci, 0); 

?>

  <div class= "container">
    <h1>CCI Results</h1>
<?php
if ($wgt <= 0 || $hgt <= 0) {
?>
      <div class="alert alert-danger">An inappropriate value has been entered for weight, or height. Please try again!</div>
<?php
} else {
?>
		<ul class="list-group">
			<li class="list-group-item">The patient's CCI is approximately <?php echo "$cci";  ?> cells/ul. </li>
		</ul>
		<h4>A CCI less than 7,500 cells/uL is considered an inadequate response to platelet transfusion and is suggestive of an immune mediated cause of  platelet refractoriness.  Clinical correlation is recommended.</h4>
		<br/>
		<h6> BSA was calculated as described by DuBois-Arch Intern Med. 1916; 17:863-871</h6>
	</div>

		</form>
		</div>


<?php
}
?>

<?php require_once('includes/footer.php'); ?>

