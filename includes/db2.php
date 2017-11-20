<?php
    
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    
 $host = "localhost";
$user = "rcedb";
$password = "SNUg6Tw2LKeIqlubWxHnCUPbMMAYatzk";
$dbname = "rcedb";

$con =  new mysqli($host, $user, $password, $dbname) or die("Error: " . $con->error);

    $query = "CREATE TABLE IF NOT EXISTS `calculators` ( pid BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, pageid VARCHAR(255));";
    if($stmt = $con->prepare($query)) {
        $stmt->execute();
        $stmt->close();
    }
    
    $page_title = array('home', 'calc1', 'calc2', 'calc3', 'calc4');
    
    $query = "SELECT COUNT(*) AS count FROM `calculators` WHERE `pageid` = ?;";
    if($stmt = $con->prepare($query)) {
        $stmt->bind_param("s", $page);
    } else {
        echo "Failed to prepare select statement.<br />";
        exit();
    }
    
    $page_count_array = array();
    foreach($page_title as $page) {
        $stmt->execute();
        $stmt->bind_result($page_count);
        if($stmt->fetch()) {
            echo "Page count for [$page]: $page_count <br />";
            array_push($page_count_array, array('name'=>$page,'count'=>$page_count));
        }
    }
    $stmt->close();
    
    echo "<pre>".print_r($page_count_array,true)."</pre>";

    $query = "INSERT INTO `calculators` (pageid) VALUES (?);";
    if($stmt = $con->prepare($query)) {
        $stmt->bind_param("s", $page2);
    } else {
        echo "Failed to prepare insert statement.<br />";
        exit();
    }
    
    foreach($page_count_array as $page) {
        $page2 = $page['name'];
        if(intval($page['count']) < 1) {
            echo "Creating entry for page [{$page['name']} <br />";
            $stmt->execute();
            if($con->error) {
                echo 'execute error: '.$con->error;
            }
        }
    }
    $stmt->close();
    $con->close();
?>
