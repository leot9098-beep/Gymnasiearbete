<?php
$hostname = "localhost";
$database = "BookOfWhos";
$username = "BookOfWhos";
$password = "Whoasked11223344";


try {
  $db = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
  // set the PDO error mode to exception
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //  echo "Connected successfully"; // denna rad kan tas bort om allt fungerar
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
