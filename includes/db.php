<?php

error_reporting(E_ALL);
ini_set("display_errors", 1); 


$host = "localhost";
$user = "rcedb";
$password = "SNUg6Tw2LKeIqlubWxHnCUPbMMAYatzk";
$dbname = "rcedb";

$con =  new mysqli($host, $user, $password, $dbname) or die("Error: " . $con->error);
/*Connects to mysqli*/


$query = "CREATE TABLE IF NOT EXISTS `calculators` ( pid BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, pageid VARCHAR(255));";
$stmt = $con->prepare($query);
$stmt->execute();
$stmt->close();
/*Creats the Calculator Table*/
 
 
$page_title = array('home', 'simple_transfusion', 'auto_rce', 'partial_manual', 'uab_partial_manual', 'isovolemic_exchange', 'plasma_volume');
/*defines an array to use to feed the column names to the check function; contains the name of the home page, and the various calculator pages*/

$query = "SELECT COUNT(*) AS count FROM `calculators` WHERE `pageid` = ?;"; 
$stmt = $con->prepare($query);
$stmt->bind_param("s", $page);

/*this is to set up a count to  stop the function from repeatedly processing the array into the database; it just counts and then stores the value counted in the phrase count; it prepares the statment and then tells the comp it can find that value in the space page*/

$query = "INSERT INTO `calculators` VALUES ('', ?);";
$stmt_insert = $con->prepare($query);
$stmt_insert->bind_param("s", $page2);
/*this is to prepare to insert the values from the array into the table/db*/


foreach($page_title as $page)
{
/*for each value in page_tile run through the function starting at space page in the array*/
	
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($page_count);
	$stmt->fetch();

/*this executes the count command, and then binds the result as page count*/

	$page2 = $page; 

/*this transfers the variables in the array that are being fed to page into page2 for insertion*/

	if(!$page_count) 
	{
		$stmt_insert->execute();

	}
/*this inserts the values into the table if the count is anything other than zero; this essentially stops the table from repeatedly entering the array each time the pages are accessed*/
}
$stmt->close();
$stmt_insert->close();
/*closes the statements*/



 /*what follows is the same code simply creating the table visit, and populating one time with the variable desired*/

$query = "CREATE TABLE IF NOT EXISTS `visit` ( vid BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, visit_type VARCHAR(255));";
	if ($stmt = $con->prepare($query));
    {
        $stmt->execute();
        $stmt->close();
    }
      
    
$visit_title = array('visit', 'submit');


$query = "SELECT COUNT(*) AS count FROM `visit` WHERE `visit_type` = ?;"; 
$stmt = $con->prepare($query);
$stmt->bind_param("s", $page);

$query = "INSERT INTO `visit` VALUES ('', ?);";
$stmt_insert = $con->prepare($query);
$stmt_insert->bind_param("s", $page2);

foreach($visit_title as $page)
{

	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($page_count);
	$stmt->fetch();

	$page2 = $page; 

	if(!$page_count) 
	{
		$stmt_insert->execute();

	}
}
$stmt->close();
$stmt_insert->close();

$query = "CREATE TABLE IF NOT EXISTS `useage` ( uid BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, pid BIGINT, vid BIGINT, date DATETIME);";
$stmt = $con->prepare($query);
$stmt->execute();
$stmt->close();

/*creates the useage table*/

$con->close();

?>
