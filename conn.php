<?php
$myfile = fopen("/run/secrets/api.class.conn.user", "r") or die("Unable to open file!");
$username = trim(fgets($myfile));
fclose($myfile);

$myfile = fopen("/run/secrets/api.class.conn.pass", "r") or die("Unable to open file!");
$password = trim(fgets($myfile));
fclose($myfile);

//  $host = "db.class.baileyprogramming.com";
  $host = "api.class.baileyprogramming.com";
  $dbname = "dev_campusmaps";

//Create connection
$conn = mysqli_connect($host, $username, $password, $dbname);
//Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//mysqli_close($conn);

?>
