<?php
require 'sessionmanager.php';
session_start();
if (!isset($_SESSION['faculty'])) {
    header("Location: login.php");
}
sessionTimer();

?>

<?
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <?php

    include '../inc/style.inc.php';

    ?>
    <style>
        #search,#searchResult {
            width: 40%;
        }
    </style>

</head>

<body>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>
    <br>
    <center><h2>Name : <?php echo $_SESSION['name']?></h2></center>
    <br>
    <section class="container-lg container-md container-sm ">
        <div class="cont">
            <center>
                <input id="search" class="form-control mr-sm-2" type="search" onkeyup="showResult(this.value)" placeholder="Search by name or admission no" aria-label="Search">
                <div id="searchResult">
                    <!-- Search Result -->
                </div>
            </center>
            <br>
            <a href="/faculty/all-students.php" style="text-decoration: none;">
                <button type="button" class="btn btn-outline-info btn-lg btn-block">View All Students</button> </a> <br>
            <br><br>
            <div style="text-align: center;">
                <a href="dashboard.php?logout=true" style="text-decoration: none;">
                    <button type="submit" class="btn btn-danger" name="logout">Logout</button>
                </a>
                &nbsp;&nbsp;&nbsp;
                <a href="resetpassword.php" style="text-decoration: none;">
                    <button type="submit" class="btn btn-warning" name="logout">Reset Password</button>
                </a>
            </div>
            <?php
            include '../inc/js.inc.php';
            ?>
        </div>
    </section>
    <script>
        function showResult(name) {
            if (name.length == 0) {
                document.getElementById("searchResult").innerHTML = "";
                document.getElementById("searchResult").style.border = "0px";
                return;
            }
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("searchResult").innerHTML = this.responseText;
                    document.getElementById("searchResult").style.border = "1px solid #A5ACB2";
                }
            }
            xmlhttp.open("GET", "response.php?search=" + name, true);
            console.log(name);
            xmlhttp.send();
        }
    </script>
</body>

</html>