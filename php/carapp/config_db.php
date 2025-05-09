<?php
$serverName = 'sql209.infinityfree.com';
$username = 'if0_38454613';
$password = 'Candacewabibi14';
$databaseName = 'if0_38454613_Cars';

$mysqli = new mysqli($serverName, $username, $password, $databaseName); //('mySQL', 'root', 'verysecret', 'Cars' ); // if0_38454613_Cars	if0_38454613	(Your vPanel Password)	sql209.infinityfree.com
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
//select a database to work with
$mysqli->select_db("if0_38454613_Cars"); 
?>