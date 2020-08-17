<?php
require 'process.php';

session_start();
if (!isset($_SESSION['faculty'])) {
    header("Location: login.php");
}else{
    if (isset($_GET['search'])) {
        $response = getStudents($_GET['search']);
        echo $response;
    }

}