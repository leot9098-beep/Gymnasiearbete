<?php
$hostname_forumtest = "localhost";
$database_forumtest = "forum";
$username_forumtest = "forum";
$password_forumtest = "foruminator123";


try {
  $forum = new PDO("mysql:host=$hostname_forumtest;dbname=$database_forumtest", $username_forumtest, $password_forumtest);
  // set the PDO error mode to exception
  $forum->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //  echo "Connected successfully"; // denna rad kan tas bort om allt fungerar
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
