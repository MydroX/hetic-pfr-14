<?php

$dsn = 'mysql:dbname=pfr;host=db';
$user = 'root';
$password = 'root';

try {
    $dbh = new PDO($dsn, $user, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
    echo "Failed". $e->getMessage();
}

$csv = fopen(__DIR__ . "/csv/dans-ma-rue.csv", 'r');

while (($data = fgetcsv($csv,10000, ";")) !== false){

    $type = $data[0];
    $subType = $data[1];
    $reportingDate = $data[6];
    $geoPoint = $data[15];

    $sqlRequest = "INSERT INTO defect (type, sub_type, reporting_date, geo_point) VALUES(:type, :sub_type, :reporting_date, :geo_point)";
    $stmt = $dbh->prepare($sqlRequest);

    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':sub_type', $subType);
    $stmt->bindParam(':reporting_date', $reportingDate);
    $stmt->bindParam(':geo_point', $geoPoint);

    $stmt->execute();
    echo("Passed\n");
}
echo("dans-ma-rue.csv has been import successfully");

fclose($csv);