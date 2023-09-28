<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "demo";

if(!$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{

	die("failed to connect!");
}

function executeQuery($query)
{
  $conn = $GLOBALS['conn'];
  return mysqli_query($conn, $query);
}

?>



