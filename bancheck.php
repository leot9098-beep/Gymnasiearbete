<?php
session_start();
require_once 'functions.php';
$uid = getUserID();
if (isbanned($uid)) {
    header('Location: banned.php');
    exit();
}
