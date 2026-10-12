<?php
session_start();
require_once 'functions.php';
$uid = getUserID($_SESSION['username']);
if (isbanned($uid)) {
    header('Location: banned.php');
    exit();
}
